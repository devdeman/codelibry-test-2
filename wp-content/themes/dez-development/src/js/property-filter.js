export default function PropertyFilter(mapInstance) {
  const selects = document.querySelectorAll('.js-filter-select');
  if (!selects.length) return;

  const cardsWrap = document.querySelector('.property-view__cards');
  const countEl   = document.querySelector('.property-view__count');
  if (!cardsWrap || !countEl) return;

  // ── Dropdown open / close ─────────────────────────────────────

  function openSelect(sel) {
    sel.classList.add('is-open');
  }

  function closeSelect(sel) {
    sel.classList.remove('is-open');
  }

  function closeAll() {
    selects.forEach(s => closeSelect(s));
  }

  selects.forEach(sel => {
    const trigger = sel.querySelector('.filter-select__trigger');
    const items   = sel.querySelectorAll('.filter-select__item');
    const label   = sel.querySelector('.filter-select__label');
    const prefix  = sel.dataset.prefix || '';
    const placeholder = sel.dataset.placeholder || '';

    trigger.addEventListener('click', e => {
      e.stopPropagation();
      const wasOpen = sel.classList.contains('is-open');
      closeAll();
      wasOpen ? closeSelect(sel) : openSelect(sel);
    });

    items.forEach(item => {
      item.addEventListener('click', () => {
        items.forEach(i => i.classList.remove('is-active'));
        item.classList.add('is-active');
        sel.dataset.value = item.dataset.value;

        const display = item.dataset.value
          ? (prefix + item.textContent.trim())
          : (prefix + placeholder);
        label.textContent = display;

        closeSelect(sel);
        fetchResults();
      });
    });
  });

  document.addEventListener('click', closeAll);

  // ── AJAX fetch ────────────────────────────────────────────────

  function fetchResults() {
    const body = new FormData();
    body.append('action', 'property_filter');
    body.append('nonce',  window.site.property_filter_nonce);

    selects.forEach(sel => {
      body.append(sel.dataset.param, sel.dataset.value || '');
    });

    cardsWrap.style.opacity = '0.4';
    cardsWrap.style.pointerEvents = 'none';

    fetch(window.site.ajax_url, { method: 'POST', body })
      .then(r => r.json())
      .then(res => {
        if (!res.success) return;
        cardsWrap.innerHTML = res.data.html;
        countEl.textContent = res.data.label;
        if (mapInstance && res.data.markers) {
          mapInstance.updateMarkers(res.data.markers);
        }
      })
      .catch(() => {})
      .finally(() => {
        cardsWrap.style.opacity = '';
        cardsWrap.style.pointerEvents = '';
      });
  }
}
