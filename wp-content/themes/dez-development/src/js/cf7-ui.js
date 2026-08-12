export default function CF7UI() {
    initDatePlaceholders();
    initFileUploads();
}

function initDatePlaceholders() {
    document.querySelectorAll('.cf7-date-wrap').forEach(wrap => {
        const input = wrap.querySelector('input[type="date"]');
        if (!input) return;

        const update = () => {
            wrap.classList.toggle('has-value', !!input.value);
        };

        input.addEventListener('change', update);
        update();
    });
}

function initFileUploads() {
    document.querySelectorAll('.cf7-file-wrap').forEach(wrap => {
        const input = wrap.querySelector('input[type="file"]');
        const placeholder = wrap.querySelector('.cf7-file-placeholder');
        if (!input) return;

        // Force multiple regardless of CF7 version
        input.setAttribute('multiple', '');

        input.addEventListener('change', () => {
            wrap.querySelector('.cf7-file-list')?.remove();

            const files = Array.from(input.files);

            if (files.length === 0) {
                if (placeholder) placeholder.hidden = false;
                return;
            }

            if (placeholder) placeholder.hidden = true;

            const list = document.createElement('div');
            list.className = 'cf7-file-list';

            files.forEach(file => {
                const dotIndex = file.name.lastIndexOf('.');
                const baseName = dotIndex > 0 ? file.name.slice(0, dotIndex) : file.name;
                const ext      = dotIndex > 0 ? file.name.slice(dotIndex) : '';

                const item = document.createElement('div');
                item.className = 'cf7-file-item';
                item.innerHTML =
                    `<span class="cf7-file-name">${baseName}</span>` +
                    `<span class="cf7-file-ext">${ext}</span>`;
                list.appendChild(item);
            });

            const removeBtn = document.createElement('span');
            removeBtn.className = 'cf7-file-remove';
            removeBtn.setAttribute('aria-hidden', 'true');
            removeBtn.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>`;
            list.appendChild(removeBtn);

            wrap.appendChild(list);
        });
    });
}
