import Swiper from 'swiper';
import { Navigation, Keyboard, Pagination } from 'swiper/modules';

export default function Gallery() {
	document.querySelectorAll('.gallery-block').forEach(initGallery);
}

function initGallery(section) {
	const grid = section.querySelector('.js-gallery-grid');
	const footer = section.querySelector('.js-gallery-footer');
	const loadMore = section.querySelector('.js-gallery-load-more');
	const countEl = section.querySelector('.js-gallery-count');
	const filterBtns = Array.from(section.querySelectorAll('.gallery-block__filter-btn'));

	if (!grid) return;

	let loading = false;
	let lightboxSwiper = null;
	let lightboxEl = null;

	// ── Lightbox ─────────────────────────────────────────────────────────────

	function buildLightbox(startIndex) {
		if (lightboxEl) {
			lightboxEl.remove();
			if (lightboxSwiper) {
				lightboxSwiper.destroy(true, true);
				lightboxSwiper = null;
			}
		}

		lightboxEl = document.createElement('div');
		lightboxEl.className = 'gallery-lightbox';

		const wrapper = document.createElement('div');
		wrapper.className = 'swiper-wrapper';

		Array.from(section.querySelectorAll('.gallery-block__item')).forEach(item => {
			const slide = document.createElement('div');
			slide.className = 'swiper-slide';
			const img = document.createElement('img');
			img.src = item.dataset.fullSrc || item.querySelector('.gallery-block__img')?.src || '';
			img.alt = item.querySelector('.gallery-block__img')?.alt || '';
			slide.appendChild(img);
			wrapper.appendChild(slide);
		});

		lightboxEl.innerHTML = `
			<div class="gallery-lightbox__backdrop"></div>
			<button class="gallery-lightbox__close" type="button" aria-label="Close">
				<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 256 256" aria-hidden="true">
					<path d="M205.66,194.34a8,8,0,0,1-11.32,11.32L128,139.31,61.66,205.66a8,8,0,0,1-11.32-11.32L116.69,128,50.34,61.66A8,8,0,0,1,61.66,50.34L128,116.69l66.34-66.35a8,8,0,0,1,11.32,11.32L139.31,128Z"/>
				</svg>
			</button>
			<div class="swiper gallery-lightbox__swiper">
				<div class="swiper-wrapper"></div>
				<div class="swiper-button-prev"></div>
				<div class="swiper-button-next"></div>
				<div class="gallery-lightbox__pagination"></div>
			</div>
		`;

		lightboxEl.querySelector('.swiper-wrapper').replaceWith(wrapper);
		document.body.appendChild(lightboxEl);

		const swiperEl = lightboxEl.querySelector('.gallery-lightbox__swiper');

		lightboxSwiper = new Swiper(swiperEl, {
			modules: [Navigation, Keyboard, Pagination],
			initialSlide: startIndex,
			centeredSlides: true,
			navigation: {
				nextEl: swiperEl.querySelector('.swiper-button-next'),
				prevEl: swiperEl.querySelector('.swiper-button-prev'),
			},
			pagination: {
				el: lightboxEl.querySelector('.gallery-lightbox__pagination'),
				type: 'fraction',
			},
			keyboard: { enabled: true },
		});

		lightboxEl
			.querySelector('.gallery-lightbox__backdrop')
			.addEventListener('click', closeLightbox);
		lightboxEl.querySelector('.gallery-lightbox__close').addEventListener('click', closeLightbox);

		document.body.style.overflow = 'hidden';
	}

	function closeLightbox() {
		if (!lightboxEl) return;
		lightboxEl.remove();
		lightboxEl = null;
		if (lightboxSwiper) {
			lightboxSwiper.destroy(true, true);
			lightboxSwiper = null;
		}
		document.body.style.overflow = '';
	}

	document.addEventListener('keydown', e => {
		if (e.key === 'Escape') closeLightbox();
	});

	section.addEventListener('click', e => {
		const btn = e.target.closest('.gallery-block__expand');
		if (!btn) return;
		const item = btn.closest('.gallery-block__item');
		const items = Array.from(section.querySelectorAll('.gallery-block__item'));
		buildLightbox(Math.max(0, items.indexOf(item)));
	});

	// ── Filter ───────────────────────────────────────────────────────────────

	filterBtns.forEach(btn => {
		btn.addEventListener('click', () => {
			if (btn.classList.contains('is-active')) return;
			filterBtns.forEach(b => b.classList.remove('is-active'));
			btn.classList.add('is-active');
			grid.dataset.category = btn.dataset.category || '';
			fetchItems({ replace: true });
		});
	});

	// ── Load more ────────────────────────────────────────────────────────────

	if (loadMore) {
		loadMore.addEventListener('click', () => fetchItems({ replace: false }));
	}

	// ── AJAX ─────────────────────────────────────────────────────────────────

	function fetchItems({ replace }) {
		if (loading) return;
		loading = true;

		const perPage = parseInt(grid.dataset.perPage, 10) || 7;
		const offset = replace ? 0 : parseInt(grid.dataset.offset, 10) || 0;
		const category = grid.dataset.category || '';
		const nonce = grid.dataset.nonce;

		const body = new FormData();
		body.append('action', 'gallery_filter');
		body.append('nonce', nonce);
		body.append('per_page', perPage);
		body.append('offset', offset);
		body.append('category', category);

		if (replace) {
			grid.style.opacity = '0.4';
			grid.style.pointerEvents = 'none';
		} else if (loadMore) {
			loadMore.disabled = true;
		}

		fetch(window.site.ajax_url, { method: 'POST', body })
			.then(r => r.json())
			.then(res => {
				if (!res.success) return;
				const { html, has_more, shown, total } = res.data;

				if (replace) {
					grid.innerHTML = html;
				} else {
					grid.insertAdjacentHTML('beforeend', html);
				}

				grid.dataset.offset = String(shown);

				if (footer) footer.hidden = !has_more;
				if (countEl) countEl.textContent = `Showing ${shown} of ${total} photos`;
				if (countEl) countEl.hidden = false;
			})
			.catch(() => {})
			.finally(() => {
				loading = false;
				grid.style.opacity = '';
				grid.style.pointerEvents = '';
				if (loadMore) loadMore.disabled = false;
			});
	}
}
