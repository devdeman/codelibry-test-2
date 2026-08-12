export default function TestimonialsLoadMore() {
    const sections = document.querySelectorAll('.js-testimonials');

    sections.forEach(section => {
        const cards = Array.from(section.querySelectorAll('.testimonials__card'));
        const btn = section.querySelector('.js-testim-more');
        const counter = section.querySelector('.js-testim-counter');

        if (!btn || cards.length <= 9) return;

        const total = cards.length;
        let shown = 9;

        cards.forEach((card, i) => {
            if (i >= shown) card.classList.add('is-hidden');
        });

        btn.addEventListener('click', () => {
            const next = Math.min(shown + 9, total);

            cards.slice(shown, next).forEach(card => card.classList.remove('is-hidden'));
            shown = next;

            if (counter) {
                counter.textContent = `Showing ${shown} of ${total} reviews`;
            }

            if (shown >= total) {
                btn.parentElement.style.display = 'none';
            }
        });
    });
}
