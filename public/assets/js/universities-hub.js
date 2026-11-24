(function ($) {
    'use strict';

    var cfg = window.UNIVERSITIES_HUB;
    if (!cfg) return;

    var panelCache = {};
    var currentTab = cfg.initialTab || 'all';
    var currentQuery = {};

    function setupCSRF() {
        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': cfg.csrfToken } });
    }

    function panelUrl(tab) {
        return cfg.panelUrl.replace('__TAB__', tab);
    }

    function loadPanel(tab, query, forceReload) {
        query = query || {};
        var cacheKey = tab + JSON.stringify(query);

        if (!forceReload && panelCache[cacheKey] !== undefined) {
            $('#universities-panel-container').html(panelCache[cacheKey]);
            afterPanelRender(tab);
            return;
        }

        $.ajax({
            url: panelUrl(tab),
            method: 'GET',
            data: query,
            success: function (html) {
                panelCache[cacheKey] = html;
                $('#universities-panel-container').html(html);
                afterPanelRender(tab);
            },
            error: function () {
                $('#universities-panel-container').html('<div class="pr-card" style="padding:2rem;text-align:center;color:var(--pr-red);">Could not load this tab. Please try again.</div>');
            }
        });
    }

    function invalidateCache() {
        panelCache = {};
    }

    function switchTab(tab, query) {
        currentTab = tab;
        currentQuery = query || {};
        $('.pr-tab').removeClass('pr-tab-active');
        $('.pr-tab[data-tab="' + tab + '"]').addClass('pr-tab-active');

        var url = new URL(window.location.href);
        url.searchParams.set('tab', tab);
        window.history.replaceState({}, '', url.toString());

        // auto-scroll active tab into view on mobile
        var $activeTab = $('.pr-tab[data-tab="' + tab + '"]');
        if ($activeTab.length) {
            var el = $activeTab[0];
            el.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
        }

        loadPanel(tab, currentQuery);
    }

    /* ================= Tab clicks ================= */
    $(document).on('click', '.pr-tab', function () {
        var tab = $(this).data('tab');
        switchTab(tab, {});
    });

    /* ================= Filter form submit (delegated) ================= */
    $(document).on('submit', '.pr-panel-filter-form', function (e) {
        e.preventDefault();
        var query = $(this).serializeArray().reduce(function (acc, f) {
            if (f.value !== '') acc[f.name] = f.value;
            return acc;
        }, {});
        currentQuery = query;
        loadPanel(currentTab, query, true);
    });

    $(document).on('click', '.pr-panel-reset', function () {
        currentQuery = {};
        loadPanel(currentTab, {}, true);
    });

    /* ================= Debounced auto-search on text inputs ================= */
    var debounceTimer;
    $(document).on('input', '.pr-panel-filter-form input[type="text"]', function () {
        clearTimeout(debounceTimer);
        var $form = $(this).closest('.pr-panel-filter-form');
        debounceTimer = setTimeout(function () {
            $form.trigger('submit');
        }, 400);
    });

    /* ================= Pagination (delegated, AJAX) ================= */
    $(document).on('click', '.pr-pagination a', function (e) {
        e.preventDefault();
        var href = $(this).attr('href');
        if (!href) return;
        var pageMatch = href.match(/[?&]page=(\d+)/);
        var page = pageMatch ? pageMatch[1] : 1;
        var query = $.extend({}, currentQuery, { page: page });
        loadPanel(currentTab, query, true);
    });

    /* ================= Bulk select ================= */
    function updateBulkBar() {
        var $checked = $('.pr-row-check:checked');
        var count = $checked.length;
        $('[data-bulk-bar]').toggle(count > 0);
        $('[data-bulk-count]').text(count);
    }

    $(document).on('change', '[data-select-all]', function () {
        var checked = $(this).is(':checked');
        $('.pr-row-check').prop('checked', checked);
        updateBulkBar();
    });

    $(document).on('change', '.pr-row-check', updateBulkBar);

    $(document).on('click', '.pr-bulk-clear', function () {
        $('.pr-row-check, [data-select-all]').prop('checked', false);
        updateBulkBar();
    });

    function selectedIds() {
        return $('.pr-row-check:checked').map(function () { return $(this).val(); }).get();
    }

    $(document).on('click', '.pr-bulk-approve', function () {
        var ids = selectedIds();
        if (!ids.length) return;
        var status = $(this).data('status');
        setupCSRF();
        $.ajax({
            url: cfg.bulkApprovalUrl,
            method: 'POST',
            data: { ids: ids, status: status },
            success: function (res) {
                Swal.fire({ icon: 'success', title: 'Done', text: res.message, timer: 1500, showConfirmButton: false });
                invalidateCache();
                refreshStatsAndReload();
            },
            error: function () {
                Swal.fire({ icon: 'error', title: 'Something went wrong' });
            }
        });
    });

    $(document).on('click', '.pr-bulk-verify', function () {
        var ids = selectedIds();
        if (!ids.length) return;
        setupCSRF();
        $.ajax({
            url: cfg.bulkVerifyUrl,
            method: 'POST',
            data: { ids: ids },
            success: function (res) {
                Swal.fire({ icon: 'success', title: 'Done', text: res.message, timer: 1500, showConfirmButton: false });
                invalidateCache();
                refreshStatsAndReload();
            },
            error: function () {
                Swal.fire({ icon: 'error', title: 'Something went wrong' });
            }
        });
    });

    /* ================= Single toggle approval (optimistic, reverts on failure) ================= */
    $(document).on('change', '.toggle-university-approval', function () {
        var $checkbox = $(this);
        var $row = $checkbox.closest('tr, .pr-card-row');
        var $label = $row.find('.pr-status-text');
        var id = $checkbox.data('id');
        var status = $checkbox.is(':checked') ? 1 : 0;
        var previous = status ? 0 : 1;

        $checkbox.prop('disabled', true);
        setupCSRF();
        $.ajax({
            url: cfg.toggleApprovalUrl,
            method: 'POST',
            data: { id: id, status: status },
            success: function () {
                $label.text(status ? 'Approved' : 'Pending').toggleClass('pr-approved', !!status).toggleClass('pr-pending', !status);
                invalidateCache();
                refreshStatsOnly();
            },
            error: function () {
                $checkbox.prop('checked', previous === 1);
                Swal.fire({ icon: 'error', title: 'Could not update status', text: 'Please try again.' });
            },
            complete: function () {
                $checkbox.prop('disabled', false);
            }
        });
    });

    /* ================= Mark single as verified ================= */
    $(document).on('click', '.pr-mark-verified', function () {
        var id = $(this).data('id');
        setupCSRF();
        $.ajax({
            url: cfg.markVerifiedUrl,
            method: 'POST',
            data: { id: id },
            success: function () {
                invalidateCache();
                refreshStatsAndReload();
            }
        });
    });

    /* ================= Stats / tab counts refresh ================= */
    function refreshStatsOnly() {
        $.get(cfg.statsUrl, function (res) {
            if (!res || !res.stats) return;
            $.each(res.stats, function (key, value) {
                $('[data-stat="' + key + '"]').text(numberFormat(value));
                $('[data-tab-count="' + key + '"]').text(numberFormat(value));
            });
        });
    }

    function numberFormat(n) {
        return (n || 0).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
    }

    function refreshStatsAndReload() {
        loadPanel(currentTab, currentQuery, true);
        refreshStatsOnly();
    }

    /* ================= University Types ================= */
    $(document).on('submit', '#type-form', function (e) {
        e.preventDefault();
        var id = $('#type-id').val();
        var url = id ? cfg.typeUpdateUrl.replace('__ID__', id) : cfg.typeStoreUrl;
        setupCSRF();
        $.ajax({
            url: url,
            method: 'POST',
            data: { name: $('#type-name').val(), description: $('#type-description').val() },
            success: function () {
                $('#type-form')[0].reset();
                $('#type-id').val('');
                $('#type-submit-btn').text('+ Add type');
                $('#type-cancel-btn').hide();
                invalidateCache();
                loadPanel('types', {}, true);
                refreshStatsOnly();
            },
            error: function (xhr) {
                var res = xhr.responseJSON || {};
                $('[data-error="name"]').text((res.errors && res.errors.name) ? res.errors.name[0] : '');
            }
        });
    });

    $(document).on('click', '.pr-type-edit', function () {
        $('#type-id').val($(this).data('id'));
        $('#type-name').val($(this).data('name'));
        $('#type-description').val($(this).data('description'));
        $('#type-submit-btn').text('Save changes');
        $('#type-cancel-btn').show();
        $('html, body').animate({ scrollTop: 0 }, 200);
    });

    $(document).on('click', '#type-cancel-btn', function () {
        $('#type-form')[0].reset();
        $('#type-id').val('');
        $('#type-submit-btn').text('+ Add type');
        $(this).hide();
    });

    $(document).on('click', '.pr-type-delete', function () {
        var id = $(this).data('id');
        Swal.fire({
            title: 'Delete this type?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Delete'
        }).then(function (result) {
            if (!result.isConfirmed) return;
            setupCSRF();
            $.ajax({
                url: cfg.typeDeleteUrl.replace('__ID__', id),
                method: 'POST',
                success: function () {
                    invalidateCache();
                    loadPanel('types', {}, true);
                    refreshStatsOnly();
                },
                error: function (xhr) {
                    var res = xhr.responseJSON || {};
                    Swal.fire({ icon: 'error', title: 'Cannot delete', text: res.message || 'Please try again.' });
                }
            });
        });
    });

    $(document).on('change', '.pr-type-active-toggle', function () {
        var id = $(this).data('id');
        var active = $(this).is(':checked');
        setupCSRF();
        $.ajax({
            url: cfg.typeToggleActiveUrl.replace('__ID__', id),
            method: 'POST',
            data: { active: active ? 1 : 0 },
        });
    });

    function initSortableTypes() {
        var $list = $('#types-list');
        if (!$list.length || !$.fn.sortable) return;
        $list.sortable({
            handle: '.pr-drag-handle',
            update: function () {
                var ids = $list.find('.pr-type-row').map(function () { return $(this).data('id'); }).get();
                setupCSRF();
                $.ajax({ url: cfg.typeReorderUrl, method: 'POST', data: { ids: ids } });
            }
        });
    }

    /* ================= OEL Reviews ================= */
    function initReviewUniversitySelects() {
        if (!$.fn.select2) return;

        $('#review-school-id').select2({
            dropdownParent: $('#review-offcanvas'),
            placeholder: 'Select university',
            width: '100%',
            ajax: {
                url: cfg.searchUniversityUrl,
                dataType: 'json',
                delay: 300,
                data: function (params) { return { q: params.term || '' }; },
                processResults: function (data) { return { results: data.results }; }
            }
        });

        $('#review-student-id').select2({
            dropdownParent: $('#review-offcanvas'),
            placeholder: 'Search student (optional)',
            width: '100%',
            allowClear: true,
            ajax: {
                url: cfg.searchStudentsUrl,
                dataType: 'json',
                delay: 300,
                data: function (params) { return { q: params.term || '' }; },
                processResults: function (data) { return { results: data.results }; }
            }
        });

        $('.pr-review-university-filter').select2({
            placeholder: 'Search university',
            width: '100%',
            allowClear: true,
            ajax: {
                url: cfg.searchUniversityUrl,
                dataType: 'json',
                delay: 300,
                data: function (params) { return { q: params.term || '' }; },
                processResults: function (data) { return { results: data.results }; }
            }
        });
    }

    function setStarRating(value) {
        $('#review-rating').val(value || '');
        $('#review-star-input .pr-star').each(function () {
            $(this).toggleClass('pr-star-filled', value && $(this).data('value') <= value);
        });
    }

    $(document).on('click', '#review-star-input .pr-star', function () {
        var value = $(this).data('value');
        if ($('#review-rating').val() == value) {
            setStarRating(''); // click same star again to clear
        } else {
            setStarRating(value);
        }
    });

    $(document).on('click', '.pr-add-review', function () {
        $('#review-form')[0].reset();
        $('#review-id').val('');
        setStarRating('');
        $('#review-offcanvas-title').text('Add Review');
        if ($.fn.select2) {
            $('#review-school-id').val(null).trigger('change');
            $('#review-student-id').val(null).trigger('change');
        }
        new bootstrap.Offcanvas(document.getElementById('review-offcanvas')).show();
    });

    $(document).on('click', '.pr-edit-review', function () {
        var d = $(this).data();
        $('#review-id').val(d.id);
        $('#review-heading').val(d.heading);
        $('#review-details').val(d.details);
        $('#review-reviewer-name').val(d.reviewer_name);
        $('#review-status').val(d.status);
        setStarRating(d.rating);
        $('#review-offcanvas-title').text('Edit Review');

        if ($.fn.select2) {
            if (d.school_id) {
                var opt = new Option(d.university_name || ('School #' + d.school_id), d.school_id, true, true);
                $('#review-school-id').append(opt).trigger('change');
            }
            if (d.student_id) {
                var sOpt = new Option('Student #' + d.student_id, d.student_id, true, true);
                $('#review-student-id').append(sOpt).trigger('change');
            }
        }
        new bootstrap.Offcanvas(document.getElementById('review-offcanvas')).show();
    });

    $(document).on('submit', '#review-form', function (e) {
        e.preventDefault();
        var id = $('#review-id').val();
        var url = id ? cfg.reviewUpdateUrl.replace('__ID__', id) : cfg.reviewStoreUrl;
        var data = {
            school_id: $('#review-school-id').val(),
            student_id: $('#review-student-id').val(),
            reviewer_name: $('#review-reviewer-name').val(),
            rating: $('#review-rating').val(),
            heading: $('#review-heading').val(),
            details: $('#review-details').val(),
            status: $('#review-status').val(),
        };
        setupCSRF();
        $.ajax({
            url: url,
            method: 'POST',
            data: data,
            success: function () {
                bootstrap.Offcanvas.getInstance(document.getElementById('review-offcanvas')).hide();
                invalidateCache();
                loadPanel('reviews', currentQuery, true);
                refreshStatsOnly();
            },
            error: function (xhr) {
                var res = xhr.responseJSON || {};
                $('#review-form .pr-error').text('');
                if (res.errors) {
                    $.each(res.errors, function (field, msgs) {
                        $('#review-form [data-error="' + field + '"]').text(msgs[0]);
                    });
                }
            }
        });
    });

    $(document).on('click', '.pr-approve-review', function () {
        var id = $(this).data('id');
        setupCSRF();
        $.ajax({
            url: cfg.reviewApproveUrl.replace('__ID__', id),
            method: 'POST',
            success: function () {
                invalidateCache();
                loadPanel('reviews', currentQuery, true);
            }
        });
    });

    function afterPanelRender(tab) {
        updateBulkBar();
        if (tab === 'types') {
            initSortableTypes();
        }
        if (tab === 'reviews') {
            initReviewUniversitySelects();
        }
        applyPendingHighlight();
    }

    /* ================= Drafts ================= */
    $(document).on('click', '#universities-drafts-link', function () {
        setupCSRF();
        $.get(cfg.draftsListUrl, function (res) {
            var $body = $('#drafts-offcanvas-body').empty();
            if (!res.drafts || !res.drafts.length) {
                $body.append('<p style="color:var(--pr-text-muted);">No drafts right now.</p>');
                return;
            }
            $.each(res.drafts, function (_, d) {
                $body.append(
                    '<div class="pr-card-row">' +
                    '<p class="pr-program-name">' + d.name + '</p>' +
                    '<p class="pr-program-sub">Last saved ' + d.updated_at + '</p>' +
                    '<a href="' + cfg.editUniversityUrl.replace('__ID__', d.id) + '" class="pr-btn pr-btn-primary" style="margin-top:0.5rem;">Resume</a>' +
                    '</div>'
                );
            });
        });
        new bootstrap.Offcanvas(document.getElementById('drafts-offcanvas')).show();
    });

    /* ================= Highlight a just-submitted row ================= */
    var pendingHighlightId = null;
    var toastShown = false;

    function applyPendingHighlight() {
        if (!pendingHighlightId) return;
        var $row = $('[data-university-row="' + pendingHighlightId + '"]');
        if ($row.length) {
            $row.addClass('pr-highlight-row');
            $row[0].scrollIntoView({ behavior: 'smooth', block: 'center' });
            pendingHighlightId = null;
        }
    }

    /* ================= Init ================= */
    $(function () {
        setupCSRF();

        var params = new URLSearchParams(window.location.search);
        if (params.get('submitted') === '1' && !toastShown) {
            toastShown = true;
            Swal.fire({ icon: 'success', title: 'University submitted', timer: 2000, showConfirmButton: false });
        }
        if (params.get('highlight')) {
            pendingHighlightId = params.get('highlight');
        }

        loadPanel(currentTab, {});
    });

})(jQuery);
