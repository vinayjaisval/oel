@extends('frontend.layouts.main')
@section('title', ($headerUniversity->university_name ?? null) ? 'Programs at ' . $headerUniversity->university_name : 'Programs')
@section('content')
<style>
    .vpd {
        --navy: #111A66;
        --orange: #C2410C;
        --bg: #F4F6FB;
        --border: #E3E7F0;
        --green: #166534;
        background: var(--bg);
    }

    .vpd-header {
        background: #fff;
        border-bottom: 1px solid var(--border);
        padding: 20px 0;
    }

    .vpd-header-row {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .vpd-back {
        width: 44px;
        height: 44px;
        border-radius: 8px;
        border: 1px solid var(--border);
        background: #fff;
        color: var(--navy);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
        text-decoration: none;
    }

    .vpd-back:hover {
        background: var(--bg);
        color: var(--navy);
    }

    .vpd-logo {
        width: 48px;
        height: 48px;
        border-radius: 10px;
        border: 1px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        flex-shrink: 0;
        background: #fff;
        font-weight: 700;
        color: var(--navy);
        font-size: 13px;
    }

    .vpd-logo img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    .vpd-header h1 {
        font-weight: 700;
        font-size: clamp(20px, 3vw, 28px);
        color: var(--navy);
        margin: 0;
    }

    .vpd-header .sub {
        color: #6b7280;
        font-size: 14px;
        margin-top: 2px;
    }

    .vpd-body {
        max-width: 1200px;
        margin: 0 auto;
        padding: 24px 20px 48px;
    }

    .vpd-fees-note {
        color: #6b7280;
        font-size: 13px;
        margin-bottom: 18px;
    }

    .vpd-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(min(100%, 320px), 1fr));
        gap: 16px;
    }

    .vpd-card {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 18px;
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .vpd-card .title a {
        color: var(--navy);
        font-weight: 700;
        font-size: 17px;
        text-decoration: none;
    }

    .vpd-card .title a:hover {
        text-decoration: underline;
    }

    .vpd-card .uni {
        color: #6b7280;
        font-size: 13px;
        margin-top: 2px;
    }

    .vpd-facts {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 8px;
        margin: 14px 0;
    }

    .vpd-fact {
        background: var(--bg);
        border-radius: 8px;
        padding: 8px 10px;
    }

    .vpd-fact .l {
        display: block;
        font-size: 11px;
        color: #6b7280;
    }

    .vpd-fact .v {
        font-weight: 700;
        font-size: 13px;
        color: #1f2430;
    }

    .vpd-fact .v.free {
        color: var(--green);
    }

    .vpd-view-btn {
        margin-top: auto;
        display: block;
        text-align: center;
        background: var(--navy);
        color: #fff;
        font-weight: 600;
        border-radius: 8px;
        padding: 12px;
        text-decoration: none;
        min-height: 44px;
    }

    .vpd-view-btn:hover {
        background: #0c1450;
        color: #fff;
    }

    .vpd-load-more-wrap {
        text-align: center;
        margin-top: 24px;
    }

    .vpd-load-more {
        min-height: 48px;
        min-width: 200px;
        border-radius: 10px;
        border: 1px solid var(--border);
        background: #fff;
        color: var(--navy);
        font-weight: 600;
        padding: 10px 24px;
    }

    .vpd-load-more:disabled {
        opacity: .6;
    }

    @media (max-width: 575px) {
        .vpd-body {
            padding: 20px 16px 110px;
        }
    }

    a.vpd-back:focus-visible,
    a.vpd-view-btn:focus-visible,
    .vpd-load-more:focus-visible {
        outline: 3px solid #90a4ff;
        outline-offset: 2px;
    }
</style>

<div class="vpd">
    <section class="vpd-header">
        <div class="container">
            <div class="vpd-header-row">
                <a href="{{ route('check-eligible') }}" class="vpd-back" id="vpd-back" aria-label="Go back">&lsaquo;</a>
                @if($headerUniversity)
                    <div class="vpd-logo">
                        @if($headerUniversity->logo ?? null)
                            <img src="{{ asset($headerUniversity->logo) }}" alt="{{ $headerUniversity->university_name }} logo" width="48" height="48" loading="eager" decoding="async" onerror="this.parentElement.textContent='{{ \Illuminate\Support\Str::of($headerUniversity->university_name ?? '')->explode(' ')->filter()->take(2)->map(fn($w) => strtoupper($w[0]))->implode('') }}'">
                        @else
                            {{ \Illuminate\Support\Str::of($headerUniversity->university_name ?? '')->explode(' ')->filter()->take(2)->map(fn($w) => strtoupper($w[0]))->implode('') }}
                        @endif
                    </div>
                @endif
                <div>
                    @if($headerUniversity)
                        <h1>Programs at {{ $headerUniversity->university_name }}</h1>
                        @php
                            $subBits = collect([$headerUniversity->city ?? null, $headerUniversity->country_name->name ?? null])->filter()->implode(', ');
                        @endphp
                        <div class="sub">{{ number_format($totalPrograms) }} program{{ $totalPrograms === 1 ? '' : 's' }}{{ $subBits ? ' · ' . $subBits : '' }}</div>
                    @else
                        <h1>Programs</h1>
                        <div class="sub">{{ number_format($totalPrograms) }} program{{ $totalPrograms === 1 ? '' : 's' }}</div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <div class="vpd-body">
        <p class="vpd-fees-note">Fees may vary according to university structure and policy.</p>

        <div class="vpd-grid" id="vpd-grid">
            @foreach ($program_data as $item)
                @include('frontend.partials.program-list-card', ['item' => $item, 'showUniversity' => !$headerUniversity])
            @endforeach
        </div>

        @if($hasMore)
            <div class="vpd-load-more-wrap">
                <button type="button" class="vpd-load-more" id="vpd-load-more" data-page="1">Load 20 more</button>
            </div>
        @endif
    </div>
</div>

@endsection

@section('javascript_section')
<script>
    document.getElementById('vpd-back').addEventListener('click', function (event) {
        if (window.history.length > 1) {
            event.preventDefault();
            window.history.back();
        }
    });

    (function () {
        const loadMoreBtn = document.getElementById('vpd-load-more');
        if (!loadMoreBtn) return;

        const showUniversity = @json(!$headerUniversity);

        function money(amount, currency) {
            if (amount === null || amount === undefined || amount === '') return null;
            const n = Number(amount);
            if (isNaN(n)) return null;
            return (currency ? currency + ' ' : '') + n.toLocaleString('en-US');
        }

        function feeDisplay(amount, currency) {
            if (amount === null || amount === undefined || amount === '') return null;
            const n = Number(amount);
            if (isNaN(n)) return null;
            if (n === 0) return { text: 'Free', free: true };
            return { text: (currency ? currency + ' ' : '') + n.toLocaleString('en-US'), free: false };
        }

        function fact(label, value, isFree) {
            if (value === null || value === undefined || value === '') return '';
            return `<div class="vpd-fact"><span class="l">${label}</span><span class="v${isFree ? ' free' : ''}">${value}</span></div>`;
        }

        function buildProgramUrl(item) {
            const uni = item.university_name || {};
            const country = uni.country_name?.name || '';
            return `{{ url('/') }}/study-in-${window.slugify(country)}/${window.slugify(uni.university_name)}-${uni.id ?? 0}/${window.slugify(item.name)}-${item.id}`;
        }

        function renderCard(item) {
            const uni = item.university_name || {};
            const duration = item.length
                ? `${item.length}${String(item.length).toLowerCase().includes('month') ? '' : ' month' + (item.length == 1 ? '' : 's')}`
                : null;
            const tuition = money(item.tution_fee, item.currency);
            const appFee = feeDisplay(item.application_fee, item.currency);
            const url = buildProgramUrl(item);

            return `
            <div class="vpd-card">
                <div class="title"><a href="${url}">${item.name}</a></div>
                ${showUniversity ? `<div class="uni">${uni.university_name || ''}</div>` : ''}
                <div class="vpd-facts">
                    ${fact('Level', item.program_level?.name, false)}
                    ${fact('Duration', duration, false)}
                    ${fact('Tuition fee', tuition, false)}
                    ${fact('Application fee', appFee ? appFee.text : null, appFee ? appFee.free : false)}
                </div>
                <a href="${url}" class="vpd-view-btn">Course details</a>
            </div>`;
        }

        loadMoreBtn.addEventListener('click', function () {
            const nextPage = parseInt(loadMoreBtn.dataset.page) + 1;
            loadMoreBtn.disabled = true;
            loadMoreBtn.textContent = 'Loading…';

            fetch(window.location.pathname + '?page=' + nextPage, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
                .then(res => res.json())
                .then(res => {
                    document.getElementById('vpd-grid').insertAdjacentHTML('beforeend', res.data.map(renderCard).join(''));
                    loadMoreBtn.dataset.page = nextPage;
                    loadMoreBtn.disabled = false;
                    loadMoreBtn.textContent = 'Load 20 more';
                    if (!res.has_more) {
                        loadMoreBtn.remove();
                    }
                })
                .catch(() => {
                    loadMoreBtn.disabled = false;
                    loadMoreBtn.textContent = 'Load 20 more';
                });
        });
    })();
</script>
@endsection
