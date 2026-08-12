export default function ContentDoc() {
	document.querySelectorAll('.content-doc__inner').forEach(inner => {
		initScrollTracking(inner);
	});
}

function initScrollTracking(inner) {
	const sections = Array.from(inner.querySelectorAll('.content-doc__section'));
	const navLinks = Array.from(inner.querySelectorAll('.content-doc__nav a'));
	const metaRow = inner.querySelector('.content-doc__meta-section');
	const metaValue = inner.querySelector('.content-doc__meta-section-value');

	if (sections.length === 0) return;

	function getActiveSection() {
		const offset = 120; // sticky header height + buffer
		const scrollY = window.scrollY + offset;
		let active = sections[0];
		for (const section of sections) {
			if (section.offsetTop <= scrollY) {
				active = section;
			}
		}
		return active;
	}

	function update() {
		const active = getActiveSection();
		const activeId = active.id;
		const label = active.dataset.sectionLabel || '';

		// Update active nav link
		navLinks.forEach(link => {
			link.classList.toggle('is-active', link.getAttribute('href') === '#' + activeId);
		});

		// Update Section label in sidebar
		if (metaRow && metaValue) {
			if (label) {
				metaValue.textContent = label;
				metaRow.hidden = false;
			} else {
				metaRow.hidden = true;
			}
		}
	}

	window.addEventListener('scroll', update, { passive: true });
	update();
}
