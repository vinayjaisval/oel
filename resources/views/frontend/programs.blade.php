@extends('frontend.layouts.main')
@section('title', 'Programs')
@section('content')
<style>
    .pp {
        --navy: #111A66;
        --orange: #C2410C;
        --bg: #F4F6FB;
        --border: #E3E7F0;
        --green: #166534;
        background: var(--bg);
    }

    .pp-band {
        background: var(--navy);
        padding: 40px 0 76px;
    }

    .pp-band h1 {
        color: #fff;
        font-weight: 700;
        font-size: clamp(24px, 4vw, 34px);
        margin-bottom: 6px;
    }

    .pp-band p {
        color: #c9cdf0;
        margin-bottom: 24px;
    }

    .pp-search-wrap {
        margin-top: -52px;
    }

    .pp-panel {
        background: #fff;
        border-radius: 12px;
        border: 1px solid var(--border);
        padding: 18px;
        box-shadow: 0 10px 30px rgba(17, 26, 102, 0.12);
        position: relative;
        z-index: 1;
    }

    @media (max-width: 575px) {
        .pp-band {
            padding-bottom: 32px;
        }

        .pp-search-wrap {
            margin-top: -16px;
        }
    }

    .pp-field label {
        display: block;
        font-size: 12px;
        font-weight: 600;
        color: #5b6275;
        margin-bottom: 4px;
    }

    .pp-field .form-control,
    .pp-field .select2-selection--single {
        min-height: 48px !important;
        height: 48px;
        border-radius: 8px;
        border: 1px solid var(--border);
        display: flex;
        align-items: center;
    }

    .pp-field .select2-selection__rendered {
        line-height: 46px !important;
    }

    .pp-field .select2-selection__arrow {
        height: 46px !important;
    }

    .pp-search-btn {
        background: var(--orange);
        border: none;
        color: #fff;
        font-weight: 600;
        border-radius: 8px;
        height: 48px;
        min-width: 44px;
    }

    .pp-search-btn:hover {
        background: #a8380a;
        color: #fff;
    }

    .pp-results-head {
        display: flex;
        justify-content: space-between;
        align-items: baseline;
        flex-wrap: wrap;
        gap: 8px;
        margin: 28px 0 20px;
    }

    .pp-count {
        font-weight: 700;
        color: var(--navy);
    }

    .pp-fees-note {
        color: #6b7280;
        font-size: 13px;
    }

    .pp-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(min(100%, 330px), 1fr));
        gap: 20px;
        padding-bottom: 36px;
    }

    .pp-card {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 18px;
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .pp-card-head {
        display: flex;
        gap: 12px;
        margin-bottom: 12px;
    }

    .pp-logo {
        width: 48px;
        height: 48px;
        border-radius: 8px;
        border: 1px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        flex-shrink: 0;
        background: #fff;
        font-weight: 700;
        color: var(--navy);
        font-size: 14px;
    }

    .pp-logo img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    .pp-card-title a {
        color: var(--navy);
        font-weight: 700;
        text-decoration: none;
        font-size: 16px;
    }

    .pp-card-title a:hover {
        text-decoration: underline;
    }

    .pp-card-uni a {
        color: #4b5563;
        font-size: 13px;
        text-decoration: none;
    }

    .pp-card-uni a:hover {
        text-decoration: underline;
    }

    .pp-facts {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 8px;
        margin: 12px 0;
    }

    .pp-fact {
        background: var(--bg);
        border-radius: 8px;
        padding: 8px 10px;
    }

    .pp-fact .l {
        display: block;
        font-size: 11px;
        color: #6b7280;
    }

    .pp-fact .v {
        font-weight: 700;
        font-size: 13px;
        color: #1f2430;
    }

    .pp-fact .v.free {
        color: var(--green);
    }

    .pp-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        margin-bottom: 14px;
    }

    .pp-tag {
        background: var(--bg);
        border: 1px solid var(--border);
        border-radius: 999px;
        padding: 3px 10px;
        font-size: 12px;
        color: #374151;
    }

    .pp-view-btn {
        margin-top: auto;
        display: block;
        text-align: center;
        background: var(--navy);
        color: #fff;
        font-weight: 600;
        border-radius: 8px;
        padding: 10px;
        text-decoration: none;
        min-height: 44px;
    }

    .pp-view-btn:hover {
        background: #0c1450;
        color: #fff;
    }

    .pp-skel {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: 12px;
        height: 230px;
        animation: pp-pulse 1.4s ease-in-out infinite;
    }

    @keyframes pp-pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: .55; }
    }

    .pp-pagination {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        justify-content: center;
        padding-bottom: 40px;
    }

    .pp-pagination button {
        min-width: 44px;
        min-height: 44px;
        border-radius: 8px;
        border: 1px solid var(--border);
        background: #fff;
        color: var(--navy);
        font-weight: 600;
    }

    .pp-pagination button[aria-current="true"] {
        background: var(--navy);
        color: #fff;
        border-color: var(--navy);
    }

    .pp-pagination button:disabled {
        opacity: .45;
    }

    .pp-load-more {
        display: none;
        margin: 8px auto 40px;
        min-height: 44px;
        min-width: 200px;
        border-radius: 8px;
        border: 1px solid var(--navy);
        background: #fff;
        color: var(--navy);
        font-weight: 600;
        padding: 10px 18px;
    }

    .pp-empty {
        text-align: center;
        padding: 40px 0;
        color: #6b7280;
    }

    @media (max-width: 991px) {
        .pp-panel .row.g-2 > div { flex: 0 0 50%; max-width: 50%; }
        .pp-panel .row.g-2 > div.pp-submit-col { flex: 0 0 100%; max-width: 100%; }
    }

    @media (max-width: 575px) {
        .pp-panel .row.g-2 > div { flex: 0 0 100%; max-width: 100%; }
        .pp-load-more { display: inline-block; }
    }

    @media (min-width: 576px) {
        .pp-pagination.pp-mobile-only { display: none; }
    }

    a.pp-view-btn:focus-visible,
    .pp-search-btn:focus-visible,
    .pp-pagination button:focus-visible,
    .pp-load-more:focus-visible {
        outline: 3px solid #90a4ff;
        outline-offset: 2px;
    }

    /* Select2 restyle to match 48px fields */
    .select2-container--default .select2-selection--single {
        border: 1px solid var(--border);
        border-radius: 8px;
        min-height: 48px;
        padding: 0.375rem 0.75rem;
    }

    .select2-container--default.select2-container--focus .select2-selection--single {
        border-color: var(--navy);
        box-shadow: 0 0 0 0.2rem rgba(17, 26, 102, 0.15);
    }
</style>

<div class="pp">
    <section class="pp-band">
        <div class="container text-center">
            <h1>Find your program</h1>
            <p>Choose a country, university or program and search.</p>
        </div>
    </section>

    <section class="pp-search-wrap">
        <div class="container">
            <form action="{{ route('programs') }}" method="get" id="filter_form" class="pp-panel">
                <div class="row g-2 align-items-end">
                    <div class="col pp-field">
                        <label for="country_search">Country</label>
                        <select id="country_search" name="country" class="form-control">
                            <option value="">All countries</option>
                            @foreach($countries as $c)
                                <option value="{{ \Illuminate\Support\Str::slug($c->name).'-'.$c->id }}">
                                    {{ $c->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col pp-field">
                        <label for="university_search">University</label>
                        <select id="university_search" name="university" class="form-control" aria-label="Search university">
                            <option value="">Search university&hellip;</option>
                        </select>
                    </div>

                    <div class="col pp-field">
                        <label for="program_search">Program</label>
                        <select id="program_search" name="program" class="form-control" aria-label="Search program">
                            <option value="">Search program&hellip;</option>
                        </select>
                    </div>

                    <div class="col-12 col-sm-auto pp-submit-col pp-field">
                        <label class="d-none d-sm-block">&nbsp;</label>
                        <button type="submit" class="pp-search-btn w-100 px-4">
                            Search
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <section class="container">
        <div class="pp-results-head">
            <span class="pp-count" id="pp-count" aria-live="polite">Loading programs&hellip;</span>
            <span class="pp-fees-note">Fees may vary according to university structure and policy.</span>
        </div>

        <div id="program-data" class="pp-grid"></div>
        <p class="pp-empty" id="pp-empty" style="display:none">No programs found for these filters.</p>

        <nav class="pp-pagination" id="pp-pagination" aria-label="Program results pages"></nav>
        <button type="button" class="pp-load-more" id="pp-load-more">Load 20 more</button>
    </section>
</div>
@endsection

@section('javascript_section')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function () {

    let assetBaseUrl = "{{ asset('') }}/";
    let currentPage = parseInt(new URLSearchParams(window.location.search).get('page')) || 1;
    let lastPagination = null;
    let activeRequest = null;
    let requestVersion = 0;

    function isMobile() {
        return window.matchMedia('(max-width: 575px)').matches;
    }

    function money(amount, currency) {
        const n = Number(amount);
        if (!amount || isNaN(n)) return null;
        return (currency ? currency + ' ' : '') + n.toLocaleString('en-US');
    }

    function feeDisplay(amount) {
        const n = Number(amount);
        if (isNaN(n)) return null;
        if (n === 0) return { text: 'Free', free: true };
        return { text: '₹ ' + n.toLocaleString('en-US'), free: false };
    }

    function fact(label, value, isFree) {
        if (value === null || value === undefined || value === '') return '';
        return `<div class="pp-fact"><span class="l">${label}</span><span class="v${isFree ? ' free' : ''}">${value}</span></div>`;
    }

    function tag(text) {
        if (!text) return '';
        return `<span class="pp-tag">${text}</span>`;
    }

    function sentenceCase(text) {
        const lower = String(text ?? '').toLowerCase();
        return lower.charAt(0).toUpperCase() + lower.slice(1);
    }

    function logoBox(item) {
        const uni = item.university_name || {};
        const name = uni.university_name || '';
        const initials = name.split(/\s+/).filter(Boolean).slice(0, 2).map(w => w[0]).join('').toUpperCase();
        if (uni.logo) {
            const src = `${assetBaseUrl}${uni.logo}`;
            return `<div class="pp-logo"><img src="${src}" alt="${name} logo" width="48" height="48" loading="lazy" decoding="async" onerror="this.parentElement.innerHTML='${initials}'"></div>`;
        }
        return `<div class="pp-logo">${initials}</div>`;
    }

    function renderPrograms(data) {
        return data.map(item => {
            const uni = item.university_name || {};
            const country = uni.country_name?.name || '';
            const universityUrl = `{{ url('/') }}/study-in-${window.slugify(country)}/${window.slugify(uni.university_name)}-${uni.id ?? 0}`;
            const programUrl = `${universityUrl}/${window.slugify(item.name)}-${item.id}`;
            const duration = item.length ? `${item.length} month${item.length == 1 ? '' : 's'}` : null;
            const appFee = feeDisplay(item.application_fee);
            const tuition = money(item.tution_fee, item.currency);

            return `
            <div class="pp-card">
                <div class="pp-card-head">
                    ${logoBox(item)}
                    <div>
                        <div class="pp-card-title"><a href="${programUrl}">${item.name}</a></div>
                        <div class="pp-card-uni"><a href="${universityUrl}">${uni.university_name || ''}</a></div>
                    </div>
                </div>
                <div class="pp-facts">
                    ${fact('Level', item.program_level?.name, false)}
                    ${fact('Duration', duration, false)}
                    ${fact('Application fee', appFee ? appFee.text : null, appFee ? appFee.free : false)}
                    ${fact('1st-year tuition', tuition, false)}
                </div>
                <div class="pp-tags">
                    ${tag([country, item.programType].filter(Boolean).join(' · '))}
                    ${uni.testrequired ? tag('Exams: ' + sentenceCase(uni.testrequired)) : ''}
                </div>
                <a href="${programUrl}" class="pp-view-btn">View details</a>
            </div>`;
        }).join('');
    }

    function renderSkeletons(n) {
        return Array.from({ length: n }).map(() => '<div class="pp-skel" aria-hidden="true"></div>').join('');
    }

    function updateUrl(page) {
        const params = new URLSearchParams($('#filter_form').serialize());
        if (page > 1) {
            params.set('page', page);
        } else {
            params.delete('page');
        }
        const qs = params.toString();
        history.replaceState(null, '', window.location.pathname + (qs ? '?' + qs : ''));
    }

    function renderPagination(pagination) {
        const nav = $('#pp-pagination');
        const loadMoreBtn = $('#pp-load-more');

        if (!pagination || pagination.last_page <= 1) {
            nav.empty();
            loadMoreBtn.hide();
            return;
        }

        if (isMobile()) {
            nav.empty();
            if (pagination.current_page < pagination.last_page) {
                loadMoreBtn.show().text(`Load ${pagination.per_page} more`);
            } else {
                loadMoreBtn.hide();
            }
            return;
        }

        loadMoreBtn.hide();
        let html = `<button type="button" data-page="${pagination.current_page - 1}" ${pagination.current_page === 1 ? 'disabled' : ''} aria-label="Previous page">&laquo;</button>`;
        for (let p = 1; p <= pagination.last_page; p++) {
            if (p === 1 || p === pagination.last_page || Math.abs(p - pagination.current_page) <= 1) {
                html += `<button type="button" data-page="${p}" aria-current="${p === pagination.current_page}">${p}</button>`;
            } else if (p === 2 || p === pagination.last_page - 1) {
                html += `<span aria-hidden="true">&hellip;</span>`;
            }
        }
        html += `<button type="button" data-page="${pagination.current_page + 1}" ${pagination.current_page === pagination.last_page ? 'disabled' : ''} aria-label="Next page">&raquo;</button>`;
        nav.html(html);
    }

    function loadData(page, mode) {
        const currentRequestVersion = ++requestVersion;
        if (activeRequest) activeRequest.abort();

        if (mode === 'replace') {
            $('#program-data').html(renderSkeletons(6));
            $('#pp-empty').hide();
        }

        activeRequest = $.ajax({
            url: "{{ route('programs') }}",
            type: "GET",
            data: $('#filter_form').serialize() + '&page=' + page
        }).done(function (response) {
            if (currentRequestVersion !== requestVersion) return;

            const pagination = response.data;
            lastPagination = pagination;
            currentPage = pagination.current_page;

            $('#pp-count').text(`${pagination.total.toLocaleString('en-US')} program${pagination.total === 1 ? '' : 's'} found`);

            if (pagination.data.length === 0) {
                $('#program-data').html('');
                $('#pp-empty').show();
                $('#pp-pagination').empty();
                $('#pp-load-more').hide();
                return;
            }

            if (mode === 'append') {
                $('#program-data').append(renderPrograms(pagination.data));
            } else {
                $('#program-data').html(renderPrograms(pagination.data));
            }

            renderPagination(pagination);
            updateUrl(currentPage);
        }).fail(function (xhr) {
            if (xhr.statusText === 'abort') return;
            if (currentRequestVersion === requestVersion) {
                $('#pp-count').text('Could not load programs. Please try again.');
            }
        });
    }

    loadData(currentPage, 'replace');

    $(document).on('click', '#pp-pagination button[data-page]', function () {
        const page = parseInt($(this).data('page'));
        if (!page || page < 1 || (lastPagination && page > lastPagination.last_page)) return;
        loadData(page, 'replace');
        $('html, body').animate({ scrollTop: $('#program-data').offset().top - 100 }, 200);
    });

    $('#pp-load-more').on('click', function () {
        loadData(currentPage + 1, 'append');
    });

    $("#country_search").select2({ placeholder: "All countries", allowClear: true, width: '100%' });

    $("#university_search").select2({
        placeholder: "Search university",
        allowClear: true,
        width: '100%',
        minimumInputLength: 2,
        ajax: {
            url: "{{ route('ajax.universities') }}",
            dataType: 'json',
            delay: 300,
            data: params => ({ term: params.term }),
            processResults: data => ({ results: data.map(item => ({ id: item.id, text: item.text })) }),
            cache: true
        }
    });

    $("#program_search").select2({
        placeholder: "Search program",
        allowClear: true,
        width: '100%',
        minimumInputLength: 2,
        ajax: {
            url: "{{ route('ajax.programs') }}",
            dataType: 'json',
            delay: 300,
            data: params => ({ term: params.term }),
            processResults: data => ({ results: data.map(item => ({ id: item.id, text: item.text })) }),
            cache: true
        }
    });

    $('#filter_form').on('submit', function (e) {
        e.preventDefault();
        loadData(1, 'replace');
    });

    $(window).on('resize', function () {
        if (lastPagination) renderPagination(lastPagination);
    });
});
</script>
@endsection
