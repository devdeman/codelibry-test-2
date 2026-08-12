import Swiper from 'swiper';
import { Pagination, Autoplay, Navigation, EffectFade, Keyboard } from 'swiper/modules';
import 'swiper/swiper-bundle.css';

function TestimSlider() {
	const swiper = document.querySelector('.testimonials-slider__slider');

	if (swiper) {
		new Swiper(swiper, {
			modules: [Navigation, Pagination, EffectFade, Autoplay, Keyboard],
			speed: 900,
			autoHeight: true,
			breakpoints: {
				1280: {
					autoHeight: false,
				},
			},
			effect: 'fade',
			fadeEffect: {
				crossFade: true,
			},
			// loop: true,
			autoplay: {
				delay: 5000,
				disableOnInteraction: false,
				pauseOnMouseEnter: true,
			},
			pagination: {
				el: '.testimonials-slider__pagination',
				type: 'fraction',
			},
			navigation: {
				nextEl: '.swiper-button-next',
				prevEl: '.swiper-button-prev',
			},
			keyboard: {
				enabled: true,
			},
		});
	}
}

export default TestimSlider;
