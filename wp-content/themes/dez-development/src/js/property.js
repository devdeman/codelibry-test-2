import Swiper from 'swiper';
import { Pagination, Navigation, EffectFade, Autoplay, Keyboard } from 'swiper/modules';

function PropertyGallery() {
	const slider = document.querySelector('.property-hero__slider');
	if (!slider) return;

	new Swiper(slider, {
		modules: [Navigation, Pagination, EffectFade, Autoplay, Keyboard],
		speed: 800,
		effect: 'fade',
		fadeEffect: { crossFade: true },
		loop: true,
		autoplay: {
			delay: 5000,
			disableOnInteraction: false,
			pauseOnMouseEnter: true,
		},
		pagination: {
			el: '.property-hero__pagination',
			type: 'fraction',
		},
		navigation: {
			nextEl: '.property-hero__slider .swiper-button-next',
			prevEl: '.property-hero__slider .swiper-button-prev',
		},
		keyboard: { enabled: true },
	});
}

function PropertyFloorTabs() {
	const containers = document.querySelectorAll('.property-floor-plan');
	if (!containers.length) return;

	containers.forEach(container => {
		const tabs = container.querySelectorAll('.property-floor-plan__tab');
		const panels = container.querySelectorAll('.property-floor-plan__panel');
		const info = container.querySelector('.js-floor-info');

		tabs.forEach(tab => {
			tab.addEventListener('click', () => {
				const index = tab.dataset.index;

				tabs.forEach(t => {
					t.classList.remove('is-active');
					t.setAttribute('aria-selected', 'false');
				});
				panels.forEach(p => p.classList.remove('is-active'));

				tab.classList.add('is-active');
				tab.setAttribute('aria-selected', 'true');

				const activePanel = container.querySelector(
					`.property-floor-plan__panel[data-index="${index}"]`,
				);
				if (activePanel) activePanel.classList.add('is-active');

				if (info) {
					const name = tab.dataset.name || '';
					const sqft = tab.dataset.sqft ? Number(tab.dataset.sqft).toLocaleString() : '';
					info.textContent = sqft ? `${name} · ${sqft} sqft` : name;
				}
			});
		});
	});
}

export { PropertyGallery, PropertyFloorTabs };
