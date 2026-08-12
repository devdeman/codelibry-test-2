import InitPopups from './js/popup.js';
import MobileMenu from './js/mobile-menu.js';
import TestimSlider from './js/testimonials.js';
import TestimonialsLoadMore from './js/testimonials-loadmore.js';
import { PropertyGallery, PropertyFloorTabs } from './js/property.js';
import ArchiveMap from './js/archive-map.js';
import ArchiveView from './js/archive-view.js';
import CommunityFilter from './js/community-filter.js';
import PropertyFilter from './js/property-filter.js';
import HeroSearch from './js/hero-search.js';
import CF7UI from './js/cf7-ui.js';
import ContentDoc from './js/content-doc.js';
import Gallery from './js/gallery.js';

import './js/header-submenu';
import './scss/main.scss';

const waitForGoogleMaps = (timeout = 10000) => {
	return new Promise((resolve, reject) => {
		const startedAt = Date.now();

		const checkGoogleMaps = () => {
			if (window.google?.maps) {
				resolve();
				return;
			}

			if (Date.now() - startedAt >= timeout) {
				reject(new Error('Google Maps API loading timeout.'));
				return;
			}

			window.setTimeout(checkGoogleMaps, 100);
		};

		checkGoogleMaps();
	});
};

document.addEventListener('DOMContentLoaded', async () => {
	InitPopups();
	MobileMenu();
	TestimSlider();
	TestimonialsLoadMore();
	PropertyGallery();
	PropertyFloorTabs();
	ArchiveView();

	HeroSearch();
	CF7UI();
	ContentDoc();
	Gallery();

	const communityMapElement = document.getElementById('community-map');
	const propertyMapElement = document.getElementById('property-map');

	if (communityMapElement || propertyMapElement) {
		try {
			await waitForGoogleMaps();

			if (communityMapElement) {
				const map = new ArchiveMap();
				map.init();

				CommunityFilter(map);
			}

			if (propertyMapElement) {
				const map = new ArchiveMap({
					mapElId: 'property-map',
					dataKey: 'propertyMapMarkers',
				});

				map.init();
				PropertyFilter(map);
			} else {
				PropertyFilter();
			}

		} catch (error) {
			console.error(error);

			CommunityFilter();
			PropertyFilter();
		}
	} else {
		PropertyFilter();
	}
});


// document.addEventListener('DOMContentLoaded', () => {
//     const cards = document.querySelector('.community-view__cards');
//     const bar = document.querySelector('.community-view__bar');

//     if (!cards || !bar) {
//         return;
//     }

//     const updateBarWidth = () => {
//         bar.style.width = `${cards.getBoundingClientRect().width}px`;
//     };

//     // Встановлюємо ширину одразу
//     updateBarWidth();

//     // Стежимо за зміною ширини блоку cards
//     const resizeObserver = new ResizeObserver(updateBarWidth);
//     resizeObserver.observe(cards);
// });


document.addEventListener('DOMContentLoaded', () => {
    const barDesktop = document.querySelector(
       '.bar-mobile'
    );

    const results = document.querySelector(
        
		 '.bar-desktop'
    );

    if (!barDesktop || !results) {
        return;
    }

    const updateResultsWidth = () => {
        results.style.width = `${barDesktop.getBoundingClientRect().width}px`;
    };

    updateResultsWidth();

    const resizeObserver = new ResizeObserver(updateResultsWidth);
    resizeObserver.observe(barDesktop);
});