export default function HeroSearch() {
  const hero = document.querySelector('.js-hero-search');
  if (!hero) return;

  const action = hero.dataset.action;
  const fields  = hero.querySelectorAll('.js-hero-field');

  // ── Dropdown open / close ─────────────────────────────────────

  function closeAllFields() {
    fields.forEach(f => f.classList.remove('is-open'));
  }

  fields.forEach(field => {
    const trigger  = field.querySelector('.js-hero-trigger');
    const items    = field.querySelectorAll('.hero__search-item');
    const valEl    = field.querySelector('.js-hero-val');

    trigger.addEventListener('click', e => {
      e.stopPropagation();
      const wasOpen = field.classList.contains('is-open');
      closeAllFields();
      if (!wasOpen) field.classList.add('is-open');
    });

    items.forEach(item => {
      item.addEventListener('click', () => {
        items.forEach(i => i.classList.remove('is-active'));
        item.classList.add('is-active');
        field.dataset.value = item.dataset.value;
        valEl.textContent   = item.textContent.trim();
        closeAllFields();
      });
    });
  });

  document.addEventListener('click', closeAllFields);

  // ── Submit ────────────────────────────────────────────────────

  const btn = hero.querySelector('.js-hero-submit');
  if (!btn || !action) return;

  btn.addEventListener('click', () => {
    const url = new URL(action);
    fields.forEach(field => {
      const val = field.dataset.value;
      if (val) url.searchParams.set(field.dataset.param, val);
    });
    url.hash = 'property-results';
    window.location.href = url.toString();
  });
}
