export default function ArchiveView() {
	const handleToggleClick = (event) => {
		const toggle = event.target.closest('.js-view-toggle');

		if (!toggle) {
			return;
		}

		const view = toggle.closest('.js-archive-view')
			|| document.querySelector('.js-archive-view');

		if (!view) {
			return;
		}

		event.preventDefault();

		const currentView = view.dataset.view || 'list';
		const nextView = currentView === 'list' ? 'map' : 'list';

		setView(view, nextView);
	};

	const setView = (view, nextView) => {
		if (!view || !['list', 'map'].includes(nextView)) {
			return;
		}

		view.dataset.view = nextView;

		const toggles = view.querySelectorAll('.js-view-toggle');

		toggles.forEach((toggle) => {
			toggle.setAttribute(
				'aria-label',
				nextView === 'map'
					? 'Show list view'
					: 'Show map view'
			);

			toggle.setAttribute(
				'aria-pressed',
				nextView === 'map' ? 'true' : 'false'
			);
		});

		document.dispatchEvent(
			new CustomEvent('archive:view-change', {
				detail: {
					view: nextView,
					container: view,
				},
			})
		);
	};

	document.addEventListener('click', handleToggleClick);
}