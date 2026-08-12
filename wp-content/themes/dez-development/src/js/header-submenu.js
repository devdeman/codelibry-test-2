(function () {
	function initMobileSubmenus() {
		document.querySelectorAll('.mobile-menu .menu-item-has-children').forEach(item => {
			const link = item.querySelector(':scope > a');
			const subMenu = item.querySelector(':scope > .sub-menu');
			if (!link || !subMenu) return;

			// Wrap the <ul> itself in a div so grid-template-rows: 0fr works
			// (putting a <div> inside <ul> is invalid HTML)
			const inner = document.createElement('div');
			inner.className = 'sub-menu-inner';
			subMenu.parentNode.insertBefore(inner, subMenu);
			inner.appendChild(subMenu);

			// Inject toggle button after the link
			const btn = document.createElement('button');
			btn.className = 'submenu-toggle';
			btn.type = 'button';
			btn.setAttribute('aria-expanded', 'false');
			btn.setAttribute('aria-label', link.textContent.trim() + ' submenu');
			link.after(btn);

			const toggle = () => {
				const isOpen = item.classList.contains('menu-open');

				// Collapse siblings at the same level
				item.parentElement.querySelectorAll(':scope > .menu-item-has-children').forEach(sibling => {
					if (sibling !== item) {
						sibling.classList.remove('menu-open');
						const sibBtn = sibling.querySelector(':scope > .submenu-toggle');
						if (sibBtn) sibBtn.setAttribute('aria-expanded', 'false');
					}
				});

				item.classList.toggle('menu-open', !isOpen);
				btn.setAttribute('aria-expanded', String(!isOpen));
			};

			btn.addEventListener('click', toggle);

			link.addEventListener('click', e => {
				e.preventDefault();
				toggle();
			});
		});
	}

	document.addEventListener('DOMContentLoaded', initMobileSubmenus);
})();
