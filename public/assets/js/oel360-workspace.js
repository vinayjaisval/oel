(() => {
    const root = document.querySelector('.oel360');
    if (!root) return;

    const filters = root.querySelector('[data-list-filters]');
    let request;
    let timer;

    async function loadList({append = false, page = 1, updateUrl = true} = {}) {
        request?.abort();
        const active = new AbortController();
        request = active;
        const url = new URL(location.href);
        const fields = new FormData(filters);
        for (const [name, value] of fields) {
            if (value) url.searchParams.set(name, value);
            else url.searchParams.delete(name);
        }
        url.searchParams.delete('page');
        const endpoint = new URL(root.dataset.listEndpoint);
        endpoint.search = url.search;
        endpoint.searchParams.set('page', page);
        try {
            const response = await fetch(endpoint, {signal: active.signal});
            if (!response.ok) throw new Error('Unable to load students');
            const template = document.createElement('template');
            template.innerHTML = await response.text();
            if (active.signal.aborted) return;
            const rows = template.content.querySelector('[data-student-rows]');
            if (!rows) throw new Error('Unable to load students');
            const old = root.querySelector('[data-student-rows]');
            if (append) {
                old.querySelector('[data-load-more]')?.remove();
                old.append(...rows.children);
            } else {
                old.replaceWith(rows);
            }
            root.querySelector('[data-student-count]').textContent = rows.dataset.total;
            if (updateUrl) history.replaceState(history.state, '', url);
            for (const chip of root.querySelectorAll('[data-view]')) {
                chip.setAttribute('aria-pressed', chip.dataset.view === fields.get('view'));
            }
            root.querySelector('[data-list-error]').hidden = true;
        } catch (error) {
            if (error.name !== 'AbortError') root.querySelector('[data-list-error]').hidden = false;
        }
    }

    root.addEventListener('input', event => {
        if (event.target.name !== 'q' || event.target.form !== filters) return;
        clearTimeout(timer);
        request?.abort();
        timer = setTimeout(loadList, 300);
    });
    root.addEventListener('change', event => {
        if (event.target.form === filters && event.target.name !== 'q') loadList();
    });
    root.addEventListener('submit', event => {
        if (event.target !== filters) return;
        event.preventDefault();
        clearTimeout(timer);
        loadList();
    });
    root.addEventListener('click', event => {
        const chip = event.target.closest('[data-view]');
        const more = event.target.closest('[data-load-more]');
        if (chip) {
            clearTimeout(timer);
            filters.elements.view.value = chip.dataset.view;
            loadList();
        }
        if (more) loadList({append: true, page: more.dataset.loadMore, updateUrl: false});
    });
})();
