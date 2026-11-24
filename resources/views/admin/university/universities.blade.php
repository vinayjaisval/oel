@extends('admin.include.app')
@section('style')
<link href="{{ asset('assets/css/program-redesign.css') }}" rel="stylesheet">
@endsection
@section('main-content')
<div class="pr-page" id="universities-app" data-initial-tab="{{ $tab }}">

    <div class="pr-header">
        <div>
            <h1 class="pr-title">Universities</h1>
            <ol class="pr-breadcrumb" style="list-style:none;display:flex;gap:0.35rem;padding:0;margin:0.2rem 0 0;">
                <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li>/</li>
                <li>Universities</li>
            </ol>
        </div>
        <div style="display:flex;align-items:center;">
            @can('universities.create')
            @if($stats['drafts'] > 0)
            <a href="javascript:void(0)" class="pr-drafts-link" id="universities-drafts-link">
                <i class="la la-file-alt"></i> Drafts ({{ $stats['drafts'] }})
            </a>
            @endif
            <a href="{{ route('add-university') }}" class="pr-btn pr-btn-primary">
                <span class="pr-add-label-full">+ Add University</span>
                <span class="pr-add-label-short">+</span>
            </a>
            @endcan
        </div>

        <div class="offcanvas offcanvas-end border-0" tabindex="-1" id="drafts-offcanvas">
            <div class="sidebar-headerset" style="box-shadow: 0 1.6rem 3rem rgba(0,0,0,.1);">
                <div class="sidebar-headersets"><h5>Drafts</h5></div>
                <div class="sidebar-headerclose">
                    <a data-bs-dismiss="offcanvas" aria-label="Close"><img src="{{ url('assets/img/close.png') }}" alt="Close"></a>
                </div>
            </div>
            <div class="offcanvas-body" id="drafts-offcanvas-body">Loading…</div>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="pr-stats">
        <div class="pr-card pr-stat-card">
            <p class="pr-stat-label">Total Universities</p>
            <p class="pr-stat-value" data-stat="total">{{ number_format($stats['total']) }}</p>
        </div>
        <div class="pr-card pr-stat-card">
            <p class="pr-stat-label">Approved</p>
            <p class="pr-stat-value pr-green" data-stat="approved">{{ number_format($stats['approved']) }}</p>
        </div>
        <div class="pr-card pr-stat-card">
            <p class="pr-stat-label">Unapproved</p>
            <p class="pr-stat-value pr-amber" data-stat="unapproved">{{ number_format($stats['unapproved']) }}</p>
        </div>
        <div class="pr-card pr-stat-card">
            <p class="pr-stat-label">Needs Update</p>
            <p class="pr-stat-value" style="color: var(--pr-red);" data-stat="needs_update">{{ number_format($stats['needs_update']) }}</p>
        </div>
    </div>

    <div class="pr-card pr-tabbar-card">
        <div class="pr-tabbar" id="universities-tabbar">
            @php
                $tabDefs = [
                    'all' => ['label' => 'All Universities', 'icon' => 'la-list', 'count' => $stats['total'], 'stat' => 'total'],
                    'approved' => ['label' => 'Approved', 'icon' => 'la-check-circle', 'count' => $stats['approved'], 'stat' => 'approved'],
                    'unapproved' => ['label' => 'Unapproved', 'icon' => 'la-times-circle', 'count' => $stats['unapproved'], 'stat' => 'unapproved'],
                ];
                $tabDefs2 = [
                    'needs-update' => ['label' => 'Needs Update', 'icon' => 'la-exclamation-triangle', 'count' => $stats['needs_update'], 'stat' => 'needs_update', 'red' => true],
                    'reviews' => ['label' => 'OEL Reviews', 'icon' => 'la-star', 'count' => $stats['reviews_total'], 'stat' => 'reviews_total'],
                    'types' => ['label' => 'University Types', 'icon' => 'la-tags', 'count' => $stats['types_total'], 'stat' => 'types_total'],
                ];
            @endphp
            @foreach ($tabDefs as $key => $def)
                @if($visibleTabs->contains($key))
                <button type="button" class="pr-tab {{ $tab === $key ? 'pr-tab-active' : '' }}" data-tab="{{ $key }}">
                    <i class="la {{ $def['icon'] }}"></i> {{ $def['label'] }}
                    <span class="pr-tab-count" data-tab-count="{{ $def['stat'] }}">{{ number_format($def['count']) }}</span>
                </button>
                @endif
            @endforeach
            @if($visibleTabs->intersect(['needs-update','reviews','types'])->isNotEmpty() && $visibleTabs->intersect(['all','approved','unapproved'])->isNotEmpty())
            <span class="pr-tab-divider"></span>
            @endif
            @foreach ($tabDefs2 as $key => $def)
                @if($visibleTabs->contains($key))
                <button type="button" class="pr-tab {{ $tab === $key ? 'pr-tab-active' : '' }}" data-tab="{{ $key }}">
                    <i class="la {{ $def['icon'] }}"></i> {{ $def['label'] }}
                    <span class="pr-tab-count {{ !empty($def['red']) ? 'pr-tab-count-red' : '' }}" data-tab-count="{{ $def['stat'] }}">{{ number_format($def['count']) }}</span>
                </button>
                @endif
            @endforeach
        </div>
    </div>

    <div id="universities-panel-container">
        <div class="pr-card" style="padding:3rem;text-align:center;color:var(--pr-text-muted);">
            Loading…
        </div>
    </div>

</div>
@endsection
@section('scripts')
<script src="{{ asset('assets/js/jquery-3.7.1.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.2/dist/sweetalert2.all.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
<script src="{{ asset('assets/js/universities-hub.js') }}" defer></script>
<script>
    window.UNIVERSITIES_HUB = {
        panelUrl: "{{ route('universities.panel', ['tab' => '__TAB__']) }}",
        indexUrl: "{{ route('universities.index') }}",
        statsUrl: "{{ route('universities.stats') }}",
        toggleApprovalUrl: "{{ route('universities.toggle-approval') }}",
        bulkApprovalUrl: "{{ route('universities.bulk-approval') }}",
        markVerifiedUrl: "{{ route('universities.mark-verified') }}",
        bulkVerifyUrl: "{{ route('universities.bulk-verify') }}",
        searchStudentsUrl: "{{ route('universities.search-students') }}",
        draftsListUrl: "{{ route('universities.drafts-list') }}",
        editUniversityUrl: "{{ route('edit-university', ['id' => '__ID__']) }}",
        searchUniversityUrl: "{{ route('search-university') }}",
        typeStoreUrl: "{{ route('universities.types.store') }}",
        typeUpdateUrl: "{{ route('universities.types.update', ['id' => '__ID__']) }}",
        typeDeleteUrl: "{{ route('universities.types.delete', ['id' => '__ID__']) }}",
        typeToggleActiveUrl: "{{ route('universities.types.toggle-active', ['id' => '__ID__']) }}",
        typeReorderUrl: "{{ route('universities.types.reorder') }}",
        reviewStoreUrl: "{{ route('universities.reviews.store') }}",
        reviewUpdateUrl: "{{ route('universities.reviews.update', ['id' => '__ID__']) }}",
        reviewApproveUrl: "{{ route('universities.reviews.approve', ['id' => '__ID__']) }}",
        csrfToken: "{{ csrf_token() }}",
        initialTab: "{{ $tab }}",
    };
</script>
@endsection
