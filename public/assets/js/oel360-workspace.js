(() => {
    const root = document.querySelector('.oel360');
    if (!root) return;

    const filters = root.querySelector('[data-list-filters]');
    let request;
    let timer;
    let caseRequest;
    const casePanel = root.querySelector('[data-case-panel]');
    const panels = new Map();
    const wrap = root.querySelector('.wrap');
    const emptyCase = '<div class="card empty" style="padding:48px">Select a student to open their OEL 360 case.</div>';
    const listUrl = new URL(location.href);
    let listSearch = '';

    function caseKey(url) {
        return JSON.stringify(['view','student','tab','step'].map(key => url.searchParams.get(key)));
    }

    function selectStudent() {
        const student = new URL(location.href).searchParams.get('student');
        root.querySelectorAll('[data-student]').forEach(row => row.setAttribute('aria-current', row.dataset.student === student));
    }

    function activateJourney() {
        const template = casePanel.querySelector('[data-journey-scripts]');
        if (!template) return;
        const journey = casePanel.querySelector('[data-legacy-journey]');
        const step = journey.dataset.step;
        const tab = journey.querySelector('#step' + step + '-tab');
        if (tab && !tab.hasAttribute('disabled')) {
            journey.querySelectorAll('.tab-pane.active,.nav-link.active').forEach(element => element.classList.remove('active','show'));
            tab.classList.add('active');
            journey.querySelector('#step' + step)?.classList.add('active','show');
        }
        template.content.querySelectorAll('script:not([src])').forEach(source => {
            const script = document.createElement('script');
            script.textContent = source.textContent;
            casePanel.append(script);
            script.remove();
        });
    }

    function clearJourney() {
        if (!window.jQuery) return;
        const $ = window.jQuery;
        $(document).off('.workspaceJourney');
        $(casePanel).find('.select2-hidden-accessible').select2('destroy');
    }

    async function loadCase(url, push = true) {
        caseRequest?.abort();
        const active = new AbortController();
        caseRequest = active;
        const student = url.searchParams.get('student');
        const key = caseKey(url);
        const cached = panels.get(key);
        if (student && !cached) casePanel.setAttribute('data-loading', '');
        wrap.classList.toggle('open', Boolean(student));
        try {
            let html = cached || emptyCase;
            if (student && !cached) {
                const endpoint = new URL(root.dataset.caseEndpoint.replace('STUDENT', encodeURIComponent(student)));
                endpoint.search = url.search;
                const response = await fetch(endpoint, {signal: active.signal});
                if (!response.ok || response.redirected) throw new Error('Unable to open this case');
                html = await response.text();
                if (active.signal.aborted) return;
                panels.set(key, html);
            }
            if (push) history.pushState(null, '', url);
            clearJourney();
            casePanel.innerHTML = html;
            activateJourney();
            selectStudent();
        } catch (error) {
            if (error.name === 'AbortError') return;
            casePanel.querySelector('[data-case-error]')?.remove();
            const note = document.createElement('p');
            note.className = 'note n-bad';
            note.dataset.caseError = '';
            note.textContent = 'Unable to open this case. Try again.';
            casePanel.prepend(note);
            wrap.classList.toggle('open', new URL(location.href).searchParams.has('student'));
        } finally {
            if (!active.signal.aborted) casePanel.removeAttribute('data-loading');
        }
    }

    if (listUrl.searchParams.has('student')) panels.set(caseKey(listUrl), casePanel.innerHTML);
    activateJourney();
    const listKeys = url => {
        const params = new URLSearchParams(url.search);
        ['student','tab','step','page'].forEach(key => params.delete(key));
        params.sort();
        return params.toString();
    };
    listSearch = listKeys(listUrl);

    window.addEventListener('popstate', () => {
        const url = new URL(location.href);
        if (listKeys(url) !== listSearch) {
            for (const field of filters.elements) {
                if (field.name) field.value = url.searchParams.get(field.name) ?? field.defaultValue ?? '';
            }
            loadList({updateUrl: false});
        }
        loadCase(url, false);
    });

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
            listSearch = listKeys(url);
            selectStudent();
            for (const chip of root.querySelectorAll('[data-view]')) {
                chip.setAttribute('aria-pressed', chip.dataset.view === fields.get('view'));
            }
            root.querySelector('[data-list-error]').hidden = true;
        } catch (error) {
            if (error.name !== 'AbortError') root.querySelector('[data-list-error]').hidden = false;
        }
    }

    document.addEventListener('apply360:saved', () => panels.clear());
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
        const target = event.target.closest('[data-student], [data-case-tab], [data-case-step], [data-case-close]');
        if (target && !event.ctrlKey && !event.metaKey && !event.shiftKey && !event.altKey) {
            event.preventDefault();
            const url = new URL(location.href);
            if (target.dataset.student) {
                url.searchParams.set('student', target.dataset.student);
                url.searchParams.set('tab', new URL(target.href).searchParams.get('tab'));
                url.searchParams.delete('step');
            } else if (target.dataset.caseTab) {
                url.searchParams.set('tab', target.dataset.caseTab);
                url.searchParams.delete('step');
            } else if (target.dataset.caseStep) {
                url.searchParams.set('step', target.dataset.caseStep);
            } else {
                ['student','tab','step'].forEach(key => url.searchParams.delete(key));
            }
            loadCase(url);
            return;
        }
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
