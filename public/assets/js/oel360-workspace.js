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
    const toastEl = root.querySelector('[data-toast]');
    let toastTimer;

    function toast(message) {
        if (!toastEl) return;
        toastEl.textContent = message;
        toastEl.classList.add('on');
        clearTimeout(toastTimer);
        toastTimer = setTimeout(() => toastEl.classList.remove('on'), 1800);
    }

    function csrfToken() {
        return document.querySelector('meta[name="csrf-token"]')?.content || '';
    }

    function escapeHtml(value) {
        return String(value ?? '').replace(/[&<>"]/g, c => ({'&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;'}[c]));
    }

    async function loadUniversityCourses(select, universityId, selectedId) {
        if (!universityId) return;
        try {
            const response = await fetch(root.dataset.coursesEndpoint, {
                method: 'POST',
                headers: {'X-CSRF-TOKEN': csrfToken(), 'Accept': 'application/json', 'Content-Type': 'application/x-www-form-urlencoded'},
                body: new URLSearchParams({university_id: universityId}),
            });
            const data = await response.json().catch(() => ({}));
            select.innerHTML = '<option value="">Select course</option>' + (data.program || []).map(item => `<option value="${item.id}"${String(item.id) === String(selectedId) ? ' selected' : ''}>${escapeHtml(item.name)}</option>`).join('');
        } catch (error) {
            select.innerHTML = '<option value="">Select course</option>';
        }
    }

    async function loadOfferCourses(form, universityId, selectedId) {
        const select = casePanel.querySelector('[data-offer-course]');
        if (!select) return;
        select.innerHTML = '<option value="">Select</option>';
        if (!universityId) return;
        try {
            const url = new URL(root.dataset.offerCoursesEndpoint);
            url.searchParams.set('university_id', universityId);
            url.searchParams.set('sba_id', form?.dataset.sbaId || '');
            const response = await fetch(url, {headers: {'Accept': 'application/json'}});
            const data = await response.json().catch(() => ({}));
            select.innerHTML = '<option value="">Select</option>' + (data.courses || []).map(item => `<option value="${item.id}"${String(item.id) === String(selectedId) ? ' selected' : ''}>${escapeHtml(item.name)}</option>`).join('');
        } catch (error) {
            select.innerHTML = '<option value="">Select</option>';
        }
    }

    function initStepForm() {
        casePanel.querySelectorAll('[data-course-select]').forEach(select => {
            loadUniversityCourses(select, select.dataset.university, select.dataset.selected);
        });
        const offerUniversity = casePanel.querySelector('[data-offer-university]');
        const offerCourse = casePanel.querySelector('[data-offer-course]');
        if (offerUniversity && offerUniversity.value) {
            loadOfferCourses(offerUniversity.closest('form'), offerUniversity.value, offerCourse?.dataset.selected || '');
        }
    }

    function addUniversityChip(id, name) {
        const chips = casePanel.querySelector('[data-uni-chips]');
        if (!chips || !id || chips.querySelector(`[data-chip-uni="${id}"]`)) return;
        chips.querySelector('[data-uni-empty]')?.remove();
        const chip = document.createElement('span');
        chip.className = 'chip';
        chip.dataset.chipUni = id;
        chip.innerHTML = `${escapeHtml(name)}<button type="button" data-rmuni="${id}" aria-label="Remove ${escapeHtml(name)}">&#10005;</button><input type="hidden" name="collegeValues[]" value="${id}">`;
        chips.append(chip);
    }

    let uniTimer;
    let uniRequest;

    async function searchUniversities(input) {
        const results = input.closest('.fld')?.querySelector('[data-uni-results]');
        if (!results) return;
        uniRequest?.abort();
        const active = new AbortController();
        uniRequest = active;
        try {
            const url = new URL(root.dataset.universitySearchEndpoint);
            url.searchParams.set('q', input.value.trim());
            const response = await fetch(url, {signal: active.signal, headers: {'Accept': 'application/json'}});
            const data = await response.json().catch(() => ({}));
            if (active.signal.aborted) return;
            const chips = casePanel.querySelector('[data-uni-chips]');
            const added = new Set([...(chips?.querySelectorAll('[data-chip-uni]') || [])].map(el => el.dataset.chipUni));
            const items = (data.results || []).filter(item => !added.has(String(item.id)));
            results.innerHTML = items.length
                ? items.map(item => `<button type="button" class="it" style="width:100%" data-pick-uni="${item.id}" data-name="${escapeHtml(item.text)}">${escapeHtml(item.text)}</button>`).join('')
                : '<p class="empty">No matches.</p>';
            results.hidden = false;
        } catch (error) {
            if (error.name !== 'AbortError') results.hidden = true;
        }
    }

    function removeUniversityChip(button) {
        const chip = button.closest('[data-chip-uni]');
        if (!chip) return;
        chip.remove();
        const chips = casePanel.querySelector('[data-uni-chips]');
        if (chips && !chips.querySelector('[data-chip-uni]')) {
            const empty = document.createElement('div');
            empty.className = 'note n-info';
            empty.dataset.uniEmpty = '';
            empty.textContent = 'No university selected yet.';
            chips.append(empty);
        }
    }

    function showJourneyErrors(form, errors) {
        form.querySelectorAll('[data-field-error]').forEach(el => el.remove());
        const ferr = form.querySelector('[data-ferr]');
        let shown = false;
        Object.keys(errors || {}).forEach(key => {
            const field = form.querySelector(`[name="${key}"], [name="${key}[]"]`);
            const message = Array.isArray(errors[key]) ? errors[key][0] : errors[key];
            if (field) {
                const note = document.createElement('div');
                note.className = 'hint';
                note.dataset.fieldError = '';
                note.style.color = 'var(--bad)';
                note.textContent = message;
                (field.closest('.fld') || field.parentElement).append(note);
                shown = true;
            }
        });
        if (ferr) {
            ferr.hidden = shown;
            if (!shown) ferr.textContent = 'Check the fields and try again.';
        }
    }

    async function saveJourneyStep(form) {
        const button = form.querySelector('button[type="submit"]');
        button?.setAttribute('disabled', '');
        const ferr = form.querySelector('[data-ferr]');
        if (ferr) ferr.hidden = true;
        form.querySelectorAll('[data-field-error]').forEach(el => el.remove());
        try {
            const response = await fetch(root.dataset.saveEndpoint, {
                method: 'POST',
                headers: {'X-CSRF-TOKEN': csrfToken(), 'Accept': 'application/json'},
                body: new FormData(form),
            });
            const data = await response.json().catch(() => ({}));
            if (!response.ok) {
                showJourneyErrors(form, data.errors);
                toast(data.message || 'Save failed');
                return;
            }
            const step = Number(form.dataset.step);
            let stay = step === 3 && data.status === 'Rejected';
            let message = 'Saved';
            if (step === 7) {
                const visaStatus = new FormData(form).get('visa_application');
                if (visaStatus === 'Rejected') { stay = true; message = 'Saved — travel steps locked'; }
                else if (visaStatus === 'Inprogress') { stay = true; message = 'Saved — waiting for visa decision'; }
            }
            toast(message);
            document.dispatchEvent(new CustomEvent('apply360:saved'));
            const url = new URL(location.href);
            url.searchParams.set('step', stay ? step : step + 1);
            loadCase(url);
        } catch (error) {
            toast('Save failed');
        } finally {
            button?.removeAttribute('disabled');
        }
    }

    async function uploadOfferDocument(form) {
        if (!form) return;
        const files = form.querySelector('#document')?.files || [];
        const formData = new FormData(form);
        for (const file of files) formData.append('images[]', file);
        const errorEl = casePanel.querySelector('[data-offer-upload-error]');
        if (errorEl) errorEl.hidden = true;
        try {
            const response = await fetch(root.dataset.saveEndpoint, {
                method: 'POST',
                headers: {'X-CSRF-TOKEN': csrfToken(), 'Accept': 'application/json'},
                body: formData,
            });
            const data = await response.json().catch(() => ({}));
            if (!response.ok) throw new Error('upload failed');
            document.dispatchEvent(new CustomEvent('apply360:saved'));
            toast('Document uploaded');
            const rows = casePanel.querySelector('[data-offer-doc-rows]');
            if (rows && Array.isArray(data.table_three_sixtee_image)) {
                rows.innerHTML = data.table_three_sixtee_image.length
                    ? data.table_three_sixtee_image.map(row => `<tr><td data-l="#">${row.id}</td><td data-l="Document">${escapeHtml(row.program_name || '')}</td><td data-l="File"><a href="${root.dataset.assetBase}${row.image || ''}" target="_blank">View</a></td></tr>`).join('')
                    : '<tr><td colspan="3" class="empty">No documents uploaded yet.</td></tr>';
            }
        } catch (error) {
            if (errorEl) { errorEl.hidden = false; errorEl.textContent = 'Upload failed. Check the file and try again.'; }
            toast('Upload failed');
        }
    }

    async function loadVisaSubDocuments(select, documentTypeId) {
        if (!select) return;
        select.innerHTML = '<option value="">Select</option>';
        if (!documentTypeId) return;
        try {
            const url = new URL(root.dataset.visaSubDocumentEndpoint);
            url.searchParams.set('visa_document_id', documentTypeId);
            const response = await fetch(url, {headers: {'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest'}});
            const data = await response.json().catch(() => ({}));
            select.innerHTML = '<option value="">Select</option>' + (data.data || []).map(item => `<option value="${item.id}">${escapeHtml(item.name)}</option>`).join('');
        } catch (error) {
            select.innerHTML = '<option value="">Select</option>';
        }
    }

    async function deleteVisaDocument(button) {
        if (!confirm('Delete this document? This cannot be undone.')) return;
        const row = button.closest('[data-doc-row]');
        try {
            const url = new URL(root.dataset.deleteVisaDocumentEndpoint);
            url.searchParams.set('id', button.dataset.delVisaDoc);
            const sbaId = button.closest('form')?.dataset.sbaId;
            if (sbaId) url.searchParams.set('sba_id', sbaId);
            const response = await fetch(url, {headers: {'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest'}});
            const data = await response.json().catch(() => ({}));
            if (!response.ok || !data.success) throw new Error('delete failed');
            row?.remove();
            document.dispatchEvent(new CustomEvent('apply360:saved'));
            toast('Document deleted');
        } catch (error) {
            toast('Delete failed');
        }
    }

    function refreshCase() {
        document.dispatchEvent(new CustomEvent('apply360:saved'));
        loadCase(new URL(location.href));
    }

    async function addPayment(form) {
        const button = form.querySelector('button[type="submit"]');
        const errorEl = form.querySelector('[data-pay-error]');
        button?.setAttribute('disabled', '');
        if (errorEl) errorEl.hidden = true;
        try {
            const response = await fetch(root.dataset.savePaymentEndpoint, {
                method: 'POST',
                headers: {'X-CSRF-TOKEN': csrfToken(), 'Accept': 'application/json'},
                body: new FormData(form),
            });
            const data = await response.json().catch(() => ({}));
            if (!response.ok || !data.status) {
                const message = data.message || (data.errors && Object.values(data.errors)[0]?.[0]) || 'Check the fields and try again.';
                if (errorEl) { errorEl.hidden = false; errorEl.textContent = message; }
                toast(message);
                return;
            }
            toast('Payment added');
            refreshCase();
        } catch (error) {
            if (errorEl) { errorEl.hidden = false; errorEl.textContent = 'Save failed. Try again.'; }
            toast('Save failed');
        } finally {
            button?.removeAttribute('disabled');
        }
    }

    async function markPaymentPaid(button) {
        button.setAttribute('disabled', '');
        try {
            const response = await fetch(root.dataset.markPaidEndpoint, {
                method: 'POST',
                headers: {'X-CSRF-TOKEN': csrfToken(), 'Accept': 'application/json'},
                body: new URLSearchParams({id: button.dataset.markPaid}),
            });
            const data = await response.json().catch(() => ({}));
            if (!response.ok || !data.success) throw new Error(data.message || 'Failed');
            toast('Marked as paid');
            refreshCase();
        } catch (error) {
            toast(error.message || 'Could not mark as paid');
            button.removeAttribute('disabled');
        }
    }

    async function deletePayment(button) {
        if (!confirm('Delete this payment entry? This cannot be undone.')) return;
        button.setAttribute('disabled', '');
        try {
            const url = new URL(root.dataset.deletePaymentEndpoint);
            url.searchParams.set('score_id', button.dataset.deletePayment);
            const response = await fetch(url, {headers: {'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest'}});
            const data = await response.json().catch(() => ({}));
            if (!response.ok || !data.success) throw new Error(data.message || 'Failed');
            toast('Entry deleted');
            refreshCase();
        } catch (error) {
            toast(error.message || 'Delete failed');
            button.removeAttribute('disabled');
        }
    }

    function caseKey(url) {
        return JSON.stringify(['view','student','tab','step'].map(key => url.searchParams.get(key)));
    }

    function selectStudent() {
        const student = new URL(location.href).searchParams.get('student');
        root.querySelectorAll('[data-student]').forEach(row => row.setAttribute('aria-current', row.dataset.student === student));
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
            casePanel.innerHTML = html;
            initStepForm();
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
    initStepForm();
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
        if (event.target.matches('[data-uni-search]')) {
            clearTimeout(uniTimer);
            uniRequest?.abort();
            const input = event.target;
            uniTimer = setTimeout(() => searchUniversities(input), 300);
            return;
        }
        if (event.target.name !== 'q' || event.target.form !== filters) return;
        clearTimeout(timer);
        request?.abort();
        timer = setTimeout(loadList, 300);
    });
    root.addEventListener('change', event => {
        const target = event.target;
        if (target.matches('[data-status-select]')) {
            const wrap = casePanel.querySelector(`[data-remarks-wrap="${target.dataset.course}"]`);
            if (wrap) wrap.style.display = ['rejected', 'in_progress'].includes(target.value) ? '' : 'none';
            return;
        }
        if (target.matches('[data-offer-university]')) {
            loadOfferCourses(target.closest('form'), target.value, '');
            return;
        }
        if (target.name === 'fees_details' && target.closest('[data-journey-form]')) {
            casePanel.querySelectorAll('[data-fee-prepaid-fields]').forEach(el => el.style.display = target.value === 'Prepaid' ? '' : 'none');
            return;
        }
        if (target.id === 'fee_payment_by') {
            const field = casePanel.querySelector('[data-fee-agent-field]');
            if (field) field.style.display = target.value === 'agent' ? '' : 'none';
            return;
        }
        if (target.matches('[data-visa-agent-type]')) {
            const agentField = casePanel.querySelector('[data-visa-agent-field]');
            const manualField = casePanel.querySelector('[data-visa-manual-field]');
            if (agentField) agentField.style.display = target.value === 'agent' ? '' : 'none';
            if (manualField) manualField.style.display = target.value === 'manual' ? '' : 'none';
            return;
        }
        if (target.matches('[data-visa-document-type]')) {
            loadVisaSubDocuments(casePanel.querySelector('#visa_sub_document_type'), target.value);
            return;
        }
        if (target.name === 'hand_holding' && target.closest('[data-journey-form]')) {
            const field = casePanel.querySelector('[data-handholding-agent]');
            if (field) field.style.display = target.value === 'yes' ? '' : 'none';
            return;
        }
        if (target.name === 'visa_application' && target.closest('[data-journey-form]')) {
            const rejectedNote = casePanel.querySelector('[data-visa-rejected-note]');
            const rejectedReason = casePanel.querySelector('[data-visa-rejected-reason]');
            const acceptedNote = casePanel.querySelector('[data-visa-accepted-note]');
            if (rejectedNote) rejectedNote.style.display = target.value === 'Rejected' ? '' : 'none';
            if (rejectedReason) rejectedReason.style.display = target.value === 'Rejected' ? '' : 'none';
            if (acceptedNote) acceptedNote.style.display = target.value === 'Accepted' ? '' : 'none';
            return;
        }
        if (target.matches('[data-pay-service]')) {
            const option = target.selectedOptions[0];
            const amountField = casePanel.querySelector('#pamt');
            if (amountField && !amountField.value && option?.dataset.amount) amountField.value = option.dataset.amount;
            const needsUniversity = option?.dataset.name === 'University Application Fee';
            casePanel.querySelector('[data-pay-university-field]')?.toggleAttribute('hidden', !needsUniversity);
            casePanel.querySelector('[data-pay-program-field]')?.toggleAttribute('hidden', !needsUniversity);
            return;
        }
        if (target.matches('[data-pay-university]')) {
            const option = target.selectedOptions[0];
            const programField = casePanel.querySelector('#psvcprog');
            const programInput = casePanel.querySelector('[data-pay-program]');
            if (programField) programField.value = option?.dataset.programName || '';
            if (programInput) programInput.value = option?.dataset.program || '';
            return;
        }
        if (target.form === filters && target.name !== 'q') loadList();
    });
    root.addEventListener('submit', event => {
        if (event.target.matches('[data-journey-form]')) {
            event.preventDefault();
            saveJourneyStep(event.target);
            return;
        }
        if (event.target.matches('[data-add-payment-form]')) {
            event.preventDefault();
            addPayment(event.target);
            return;
        }
        if (event.target !== filters) return;
        event.preventDefault();
        clearTimeout(timer);
        loadList();
    });
    root.addEventListener('click', event => {
        const pickUni = event.target.closest('[data-pick-uni]');
        if (pickUni) {
            addUniversityChip(pickUni.dataset.pickUni, pickUni.dataset.name);
            const field = pickUni.closest('.fld');
            if (field) {
                field.querySelector('[data-uni-search]').value = '';
                const results = field.querySelector('[data-uni-results]');
                if (results) { results.hidden = true; results.innerHTML = ''; }
            }
            return;
        }
        if (!event.target.closest('[data-uni-search], [data-uni-results]')) {
            casePanel.querySelectorAll('[data-uni-results]').forEach(el => { el.hidden = true; });
        }
        const rmuni = event.target.closest('[data-rmuni]');
        if (rmuni) {
            removeUniversityChip(rmuni);
            return;
        }
        const uploadOffer = event.target.closest('[data-upload-offer]');
        if (uploadOffer) {
            uploadOfferDocument(uploadOffer.closest('form'));
            return;
        }
        const pwToggle = event.target.closest('[data-pw-toggle]');
        if (pwToggle) {
            const input = casePanel.querySelector('#' + pwToggle.dataset.pwToggle);
            if (input) {
                const showing = input.type === 'text';
                input.type = showing ? 'password' : 'text';
                pwToggle.textContent = showing ? 'Show' : 'Hide';
            }
            return;
        }
        const delVisaDoc = event.target.closest('[data-del-visa-doc]');
        if (delVisaDoc) {
            deleteVisaDocument(delVisaDoc);
            return;
        }
        const markPaid = event.target.closest('[data-mark-paid]');
        if (markPaid) {
            markPaymentPaid(markPaid);
            return;
        }
        const deletePay = event.target.closest('[data-delete-payment]');
        if (deletePay) {
            deletePayment(deletePay);
            return;
        }
        const viewPay = event.target.closest('[data-view-payment]');
        if (viewPay) {
            casePanel.querySelector(`[data-payment-detail="${viewPay.dataset.viewPayment}"]`)?.toggleAttribute('hidden');
            return;
        }
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
        const clearFilters = event.target.closest('[data-clear-filters]');
        if (clearFilters) {
            for (const field of filters.elements) {
                if (field.name && field.name !== 'view') field.value = '';
            }
            clearTimeout(timer);
            loadList();
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
