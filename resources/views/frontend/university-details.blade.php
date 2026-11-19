
@extends('frontend.layouts.main')
@section('title', ($about_university->university_name ?? 'University') . ' | Overseas Education Lane')
@section('meta_description', 'Explore programs, courses and admission details at ' . ($about_university->university_name ?? '') . ' in ' . ($about_university->country->name ?? '') . '.')
@section('og_title', $about_university->university_name ?? 'University')
@section('og_description', Str::limit(strip_tags($about_university->details ?? ''), 160))
@section('og_image', $about_university->banner ? asset($about_university->banner) : asset('frontend/img/default-og.jpg'))
@php
$studyInUniversitySlugs = [
'country' => \Illuminate\Support\Str::slug($about_university->country->name ?? 'unknown'),
'university' => \Illuminate\Support\Str::slug($about_university->university_name) . '-' . $about_university->id,
];

$universityType = $about_university->university_type->name ?? null;
$locationLine = collect([$about_university->city ?? null, $about_university->country->name ?? null])->filter()->implode(', ');

$universityInitials = \Illuminate\Support\Str::of($about_university->university_name ?? '')
    ->explode(' ')->filter()->take(2)->map(fn($w) => strtoupper($w[0]))->implode('');

$rawWebsite = trim($about_university->website ?? '');
$websiteHref = $rawWebsite ? (preg_match('#^https?://#i', $rawWebsite) ? $rawWebsite : 'https://' . $rawWebsite) : null;
$websiteDisplay = $rawWebsite ? rtrim(preg_replace('#^https?://#i', '', $rawWebsite), '/') : null;

$phoneDigits = preg_replace('/\D/', '', $about_university->phone_number ?? '');
$phoneDisplay = $about_university->phone_number ? '+' . $about_university->phone_number : null;

$facts = [
    ['label' => 'Country', 'value' => $about_university->country->name ?? null],
    ['label' => 'Founded', 'value' => $about_university->founded_in ?? null],
    ['label' => 'Type', 'value' => $universityType],
    ['label' => 'Total students', 'value' => $about_university->total_students ? number_format((int) $about_university->total_students) . '+' : null],
    ['label' => 'Size of campus', 'value' => $about_university->size_of_campus ?? null],
    ['label' => 'Male : female ratio', 'value' => $about_university->male_female_ratio ?? null],
    ['label' => 'Faculty : student ratio', 'value' => $about_university->faculty_student_ratio ?? null],
    ['label' => 'ZIP code', 'value' => $about_university->zip ?? null],
    ['label' => 'Phone', 'value' => $phoneDisplay, 'href' => $phoneDisplay ? 'tel:+' . $phoneDigits : null],
    ['label' => 'Email', 'value' => $about_university->email ?? null, 'href' => ($about_university->email ?? null) ? 'mailto:' . $about_university->email : null],
    ['label' => 'Website', 'value' => $websiteDisplay, 'href' => $websiteHref, 'target' => '_blank'],
];
@endphp
@section('canonical_url', route('study-in.university', $studyInUniversitySlugs))
@section('content')

<style>
    .ud {
        --navy: #111A66;
        --orange: #C2410C;
        --bg: #F4F6FB;
        --border: #E3E7F0;
        --green: #166534;
        background: var(--bg);
    }

    .ud-container {
        max-width: 1080px;
        margin: 0 auto;
        padding: 0 20px;
    }

    @media (max-width: 575px) {
        .ud-container {
            padding: 0 16px;
        }
    }

    /* ---- hero ---- */
    .ud-hero {
        background: var(--navy);
        padding: 20px 0 64px;
    }

    .ud-hero .oel-breadcrumb {
        background: transparent;
        border: none;
        padding: 0;
        margin-bottom: 20px;
    }

    .ud-hero .breadcrumb-item a {
        color: rgba(255, 255, 255, .8);
    }

    .ud-hero .breadcrumb-item.active {
        color: rgba(255, 255, 255, .6);
    }

    .ud-hero .breadcrumb-item + .breadcrumb-item::before {
        color: rgba(255, 255, 255, .4);
    }

    .ud-hero-top {
        display: flex;
        align-items: flex-start;
        gap: 16px;
        flex-wrap: wrap;
    }

    .ud-logo {
        width: 84px;
        height: 84px;
        border-radius: 16px;
        background: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        flex-shrink: 0;
        font-weight: 700;
        color: var(--navy);
        font-size: 20px;
    }

    .ud-logo img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    .ud-hero h1 {
        color: #fff;
        font-weight: 700;
        font-size: clamp(24px, 3.2vw, 34px);
        margin: 0 0 8px;
    }

    .ud-hero-location {
        display: flex;
        align-items: center;
        gap: 6px;
        color: rgba(255, 255, 255, .75);
        font-size: 15px;
    }

    .ud-hero-location svg {
        flex-shrink: 0;
    }

    .ud-chips {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 20px;
    }

    .ud-chip {
        background: rgba(255, 255, 255, .12);
        color: rgba(255, 255, 255, .85);
        border-radius: 999px;
        padding: 8px 16px;
        font-size: 14px;
    }

    .ud-chip b {
        color: #fff;
        font-weight: 700;
        margin: 0 3px;
    }

    /* ---- section nav card ---- */
    .ud-nav-card {
        display: block;
        height: auto;
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(17, 26, 102, .12);
        padding: 18px 20px;
        margin-top: -40px;
        margin-bottom: 24px;
        position: sticky;
        top: 0;
        z-index: 30;
    }

    .ud-nav-label {
        color: #6b7280;
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 12px;
    }

    .ud-pills {
        display: flex;
        gap: 8px;
        overflow-x: auto;
        white-space: nowrap;
        padding-bottom: 2px;
    }

    .ud-pill {
        flex: 0 0 auto;
        display: inline-flex;
        align-items: center;
        gap: 7px;
        background: #F3F4F6;
        color: #374151;
        border: none;
        border-radius: 999px;
        padding: 10px 16px;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
    }

    .ud-pill svg {
        flex-shrink: 0;
    }

    .ud-pill.active {
        background: var(--navy);
        color: #fff;
    }

    /* ---- body ---- */
    .ud-body {
        padding-bottom: 56px;
    }

    .ud-card {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 16px;
    }

    .ud-card h2 {
        font-weight: 700;
        font-size: 20px;
        color: var(--navy);
        margin-bottom: 10px;
    }

    .ud-card h3 {
        font-weight: 700;
        font-size: 16px;
        color: #1f2430;
        margin: 18px 0 10px;
    }

    .ud-prose {
        line-height: 1.7;
        color: #374151;
    }

    .ud-section-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        flex-wrap: wrap;
        margin-bottom: 18px;
    }

    .ud-section-head h2 {
        font-weight: 700;
        font-size: 22px;
        color: #1f2430;
        margin: 0;
    }

    .ud-search-wrap {
        position: relative;
        width: 340px;
        max-width: 100%;
    }

    .ud-search-wrap input {
        width: 100%;
        min-height: 48px;
        border: 1px solid var(--border);
        border-radius: 999px;
        padding: 0 16px 0 42px;
        font-size: 14px;
        background: #fff;
    }

    .ud-search-wrap button {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        padding: 4px;
        color: #6b7280;
        cursor: pointer;
        display: flex;
    }

    .ud-course-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(min(100%, 320px), 1fr));
        gap: 16px;
    }

    .ud-course-card {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 18px;
        display: flex;
        flex-direction: column;
    }

    .ud-course-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 10px;
        margin-bottom: 14px;
    }

    .ud-course-top a {
        color: var(--navy);
        font-weight: 700;
        font-size: 17px;
        text-decoration: none;
        line-height: 1.3;
        min-width: 0;
        flex: 1 1 auto;
    }

    .ud-course-top a:hover {
        text-decoration: underline;
    }

    .ud-free-badge {
        flex-shrink: 0;
        background: #ecfdf5;
        color: var(--green);
        font-size: 12px;
        font-weight: 700;
        border-radius: 999px;
        padding: 5px 11px;
        white-space: nowrap;
    }

    .ud-course-facts {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px 12px;
        margin-bottom: 16px;
    }

    .ud-course-facts .f {
        display: flex;
        align-items: center;
        gap: 7px;
        font-size: 14px;
        color: #374151;
    }

    .ud-course-facts .f svg {
        flex-shrink: 0;
        color: var(--navy);
    }

    .ud-course-facts .f b {
        color: #1f2430;
    }

    .ud-view-btn {
        margin-top: auto;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        background: var(--navy);
        color: #fff;
        font-weight: 600;
        border-radius: 10px;
        padding: 12px;
        text-decoration: none;
        min-height: 48px;
    }

    .ud-view-btn:hover {
        background: #0c1450;
        color: #fff;
    }

    .ud-load-more-wrap {
        text-align: center;
        margin: 24px 0 0;
    }

    .ud-load-more {
        min-height: 48px;
        min-width: 200px;
        border-radius: 999px;
        border: 1px solid var(--border);
        background: #fff;
        color: var(--navy);
        font-weight: 600;
        padding: 10px 24px;
    }

    .ud-load-more:disabled {
        opacity: .6;
    }

    .ud-help-banner {
        background: #FFF7ED;
        border: 1px solid #FDE4CE;
        border-radius: 14px;
        padding: 20px 24px;
        margin-top: 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        flex-wrap: wrap;
    }

    .ud-help-banner h3 {
        color: var(--orange);
        font-weight: 700;
        font-size: 17px;
        margin: 0 0 4px;
    }

    .ud-help-banner p {
        color: #9a5b2e;
        font-size: 14px;
        margin: 0;
    }

    .ud-help-actions {
        display: flex;
        gap: 10px;
        flex-shrink: 0;
    }

    .ud-btn-primary,
    .ud-btn-secondary {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 46px;
        border-radius: 8px;
        font-weight: 600;
        padding: 10px 20px;
        text-decoration: none;
        border: none;
        cursor: pointer;
        white-space: nowrap;
    }

    .ud-btn-primary {
        background: var(--orange);
        color: #fff;
    }

    .ud-btn-primary:hover {
        background: #a8380a;
        color: #fff;
    }

    .ud-btn-secondary {
        background: #fff;
        color: var(--navy);
        border: 1px solid var(--border);
    }

    .ud-btn-secondary:hover {
        background: var(--bg);
        color: var(--navy);
    }

    @media (max-width: 575px) {
        .ud-help-banner {
            flex-direction: column;
            align-items: stretch;
        }

        .ud-help-actions {
            flex-direction: column;
        }
    }

    .ud-fees-note {
        text-align: center;
        color: #6b7280;
        font-size: 13px;
        margin-top: 18px;
    }

    .ud-facts-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 16px 20px;
        margin: 0;
    }

    .ud-fact-item dt {
        color: #6b7280;
        font-size: 13px;
        margin-bottom: 4px;
    }

    .ud-fact-item dd {
        font-weight: 700;
        color: #1f2430;
        font-size: 15px;
        margin: 0;
    }

    .ud-fact-item dd a {
        color: var(--navy);
        text-decoration: none;
    }

    .ud-fact-item dd a:hover {
        text-decoration: underline;
    }

    .ud-gallery-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
        gap: 12px;
    }

    .ud-gallery-grid img {
        width: 100%;
        height: 140px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid var(--border);
        background: var(--bg);
    }

    .ud-rank-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 14px;
    }

    .ud-rank-card {
        background: var(--bg);
        border: 1px solid var(--border);
        border-radius: 10px;
        padding: 16px;
    }

    .ud-rank-card .from {
        color: #6b7280;
        font-size: 13px;
    }

    .ud-rank-card .rank {
        font-weight: 700;
        font-size: 24px;
        color: var(--navy);
        margin: 4px 0;
    }

    .ud-rank-card .meta {
        color: #6b7280;
        font-size: 13px;
    }

    .ud-accred-row {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 12px 0;
        border-bottom: 1px solid var(--border);
    }

    .ud-accred-row:last-child {
        border-bottom: none;
    }

    .ud-accred-row .check {
        color: var(--green);
        flex-shrink: 0;
    }

    .ud-accred-row img {
        width: 36px;
        height: 36px;
        object-fit: contain;
    }

    .ud-empty-state {
        text-align: center;
        padding: 48px 20px;
    }

    .ud-empty-state h3 {
        font-weight: 700;
        font-size: 18px;
        color: #1f2430;
        margin-bottom: 6px;
    }

    .ud-empty-state p {
        color: #6b7280;
        margin-bottom: 18px;
    }

    /* ---- mobile sticky bottom bar ---- */
    .ud-bottombar {
        display: none;
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        background: #fff;
        border-top: 1px solid var(--border);
        padding: 10px 14px calc(10px + env(safe-area-inset-bottom));
        gap: 10px;
        z-index: 50;
    }

    .ud-bottombar a,
    .ud-bottombar button {
        flex: 1;
        text-align: center;
        min-height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        font-weight: 600;
        text-decoration: none;
        border: none;
    }

    .ud-bottombar .wa {
        border: 1px solid var(--border);
        color: var(--navy);
        background: #fff;
    }

    .ud-bottombar .cnsl {
        background: var(--orange);
        color: #fff;
    }

    @media (max-width: 767px) {
        .ud-bottombar {
            display: flex;
        }

        .ud-body {
            padding-bottom: 96px;
        }

        /* keep the site-wide floating chat/WhatsApp bubbles clear of our sticky bar */
        body:has(.ud-bottombar) .whatsapp-icon {
            bottom: calc(25px + 78px + env(safe-area-inset-bottom));
        }

        body:has(.ud-bottombar) .chat-btn {
            bottom: calc(75px + 78px + env(safe-area-inset-bottom));
        }
    }

    a.ud-btn-primary:focus-visible,
    a.ud-btn-secondary:focus-visible,
    .ud-btn-primary:focus-visible,
    .ud-btn-secondary:focus-visible,
    .ud-pill:focus-visible,
    .ud-view-btn:focus-visible,
    .ud-load-more:focus-visible {
        outline: 3px solid #90a4ff;
        outline-offset: 2px;
    }
</style>

<div class="ud">
    <section class="ud-hero">
        <div class="ud-container">
            @include('frontend.partials.breadcrumb', ['items' => [
                ['label' => 'Home', 'url' => url('/')],
                ['label' => $about_university->country->name ?? ''],
                ['label' => $about_university->university_name ?? ''],
            ]])

            <div class="ud-hero-top">
                <div class="ud-logo">
                    @if($about_university->logo ?? null)
                        <img src="{{ asset($about_university->logo) }}" alt="{{ $about_university->university_name }} logo" width="84" height="84" loading="eager" decoding="async" onerror="this.parentElement.textContent='{{ $universityInitials }}'">
                    @else
                        {{ $universityInitials }}
                    @endif
                </div>
                <div>
                    <h1>{{ $about_university->university_name ?? '' }}</h1>
                    @if($locationLine)
                        <div class="ud-hero-location">
                            <svg width="16" height="16" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M10 18s6-5.686 6-10a6 6 0 10-12 0c0 4.314 6 10 6 10z"/><circle cx="10" cy="8" r="2"/></svg>
                            <span>{{ $locationLine }}</span>
                        </div>
                    @endif
                </div>
            </div>

            <div class="ud-chips">
                @if($totalPrograms)
                    <span class="ud-chip"><b>{{ number_format($totalPrograms) }}</b> course{{ $totalPrograms === 1 ? '' : 's' }}</span>
                @endif
                @if(!empty($about_university->total_students))
                    <span class="ud-chip"><b>{{ number_format((int) $about_university->total_students) }}+</b> students</span>
                @endif
                @if(!empty($about_university->founded_in))
                    <span class="ud-chip">Since <b>{{ $about_university->founded_in }}</b></span>
                @endif
                @if($universityType)
                    <span class="ud-chip"><b>{{ $universityType }}</b> university</span>
                @endif
            </div>
        </div>
    </section>

    <div class="ud-container">
        <nav class="ud-nav-card">
            <div class="ud-nav-label">What would you like to see?</div>
            <div class="ud-pills" id="nav-tab" role="tablist">
                <button class="ud-pill {{ isset($_GET['tab']) && $_GET['tab'] === 'programs' ? 'active' : '' }}" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="{{ isset($_GET['tab']) && $_GET['tab'] === 'programs' ? 'true' : 'false' }}">
                    <svg width="16" height="16" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M10 3l8 4-8 4-8-4 8-4z"/><path stroke-linecap="round" stroke-linejoin="round" d="M5 9v4c0 1.4 2.2 2.5 5 2.5s5-1.1 5-2.5V9"/></svg>
                    Courses &middot; {{ number_format($totalPrograms) }}
                </button>
                <button class="ud-pill {{ !isset($_GET['tab']) ? 'active' : '' }}" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="{{ !isset($_GET['tab']) ? 'true' : 'false' }}">
                    <svg width="16" height="16" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><circle cx="10" cy="10" r="7.5"/><path stroke-linecap="round" d="M10 9v4.5M10 6.6h.01"/></svg>
                    About
                </button>
                <button class="ud-pill" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">
                    <svg width="16" height="16" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><rect x="3" y="4" width="14" height="12" rx="2"/><circle cx="7.5" cy="8.5" r="1.1"/><path stroke-linecap="round" stroke-linejoin="round" d="M4 15l3.5-4 2.7 2.8L13.5 10 16.5 15"/></svg>
                    Photos
                </button>
                <button class="ud-pill" id="nav-contacts-tabs" data-bs-toggle="tab" data-bs-target="#nav-contacts" type="button" role="tab" aria-controls="nav-contacts" aria-selected="false">
                    <svg width="16" height="16" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M6 3h8v3.2a4 4 0 01-8 0V3z"/><path stroke-linecap="round" d="M6 4H3.5v1.6A2.6 2.6 0 006 8M14 4h2.5v1.6A2.6 2.6 0 0114 8"/><path stroke-linecap="round" d="M10 10.5v2.5M7.3 16.5h5.4M8.3 13h3.4v2.8H8.3z"/></svg>
                    Ranking
                </button>
                <button class="ud-pill" id="nav-notes-tabs" data-bs-toggle="tab" data-bs-target="#nav-notes" type="button" role="tab" aria-controls="nav-notes" aria-selected="false">
                    <svg width="16" height="16" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M3.5 9.5L10 4l6.5 5.5V16a1 1 0 01-1 1h-3v-5h-5v5h-3a1 1 0 01-1-1V9.5z"/></svg>
                    Accommodation
                </button>
                <button class="ud-pill" id="nav-tabing-tabs" data-bs-toggle="tab" data-bs-target="#nav-tabing" type="button" role="tab" aria-controls="nav-tabing" aria-selected="false">
                    <svg width="16" height="16" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M10 3l6 2.2v4.6c0 4-2.6 6.5-6 7.2-3.4-.7-6-3.2-6-7.2V5.2L10 3z"/><path stroke-linecap="round" stroke-linejoin="round" d="M7.3 10l1.8 1.8L12.7 8"/></svg>
                    Accreditation
                </button>
                <button class="ud-pill" id="nav-place-tabs" data-bs-toggle="tab" data-bs-target="#nav-place" type="button" role="tab" aria-controls="nav-place" aria-selected="false">
                    <svg width="16" height="16" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><rect x="3" y="7" width="14" height="9" rx="1.5"/><path stroke-linecap="round" stroke-linejoin="round" d="M7 7V5.3A1.3 1.3 0 018.3 4h3.4A1.3 1.3 0 0113 5.3V7"/><path d="M3 11.2h14"/></svg>
                    Placement
                </button>
                <button class="ud-pill" id="nav-con-tabs" data-bs-toggle="tab" data-bs-target="#nav-con" type="button" role="tab" aria-controls="nav-con" aria-selected="false">
                    <svg width="16" height="16" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M6.5 3h5l3 3v10.5a.8.8 0 01-.8.8H6.5a.8.8 0 01-.8-.8V3.8a.8.8 0 01.8-.8z"/><path stroke-linecap="round" d="M11.5 3v3h3M7.5 11h5M7.5 14h5"/></svg>
                    Notes
                </button>
            </div>
        </nav>

        <div class="ud-body">
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade {{ isset($_GET['tab']) && $_GET['tab'] === 'programs' ? 'active show' : '' }}" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                    <div class="ud-section-head">
                        <h2>Courses at this university</h2>
                        <form action="{{ route('study-in.university', $studyInUniversitySlugs) }}" method="get" class="ud-search-wrap">
                            <input type="hidden" name="tab" value="programs">
                            <button type="submit" aria-label="Search">
                                <svg width="18" height="18" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><circle cx="9" cy="9" r="6"/><path stroke-linecap="round" d="M14 14l4 4"/></svg>
                            </button>
                            <input name="program_name" type="search" value="{{ $_GET['program_name'] ?? '' }}" placeholder="Search a course, e.g. MBA, Data">
                        </form>
                    </div>

                    <div id="ud-program-list" class="ud-course-grid">
                        @forelse ($program as $item)
                            @include('frontend.partials.university-program-row', ['item' => $item])
                        @empty
                            <p class="ud-empty">No courses match your search.</p>
                        @endforelse
                    </div>

                    @if($hasMorePrograms)
                        <div class="ud-load-more-wrap">
                            <button type="button" class="ud-load-more" id="ud-load-more" data-page="1">Show more courses</button>
                        </div>
                    @endif

                    <div class="ud-help-banner">
                        <div>
                            <h3>Not sure which course is right for you?</h3>
                            <p>Talk to our counsellor &mdash; it's free.</p>
                        </div>
                        <div class="ud-help-actions">
                            <button type="button" class="ud-btn-primary" onclick="openWizard()">Book free counselling</button>
                            @if($websiteHref)
                                <a href="{{ $websiteHref }}" target="_blank" rel="noopener" class="ud-btn-secondary">Visit website</a>
                            @endif
                        </div>
                    </div>

                    <p class="ud-fees-note">Fees may vary according to university structure and policy.</p>
                </div>

                <div class="tab-pane fade {{ !isset($_GET['tab']) || $_GET['tab'] === 'home' ? 'active show' : '' }}" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                    <div class="ud-card">
                        <h2>About the university</h2>
                        <div class="ud-prose">{!! $about_university->details ?? 'No university information available' !!}</div>

                        <h3>University facts</h3>
                        <dl class="ud-facts-grid">
                            @foreach($facts as $fact)
                                <div class="ud-fact-item">
                                    <dt>{{ $fact['label'] }}</dt>
                                    <dd>
                                        @if(!empty($fact['value']) && !empty($fact['href']))
                                            <a href="{{ $fact['href'] }}" @if(($fact['target'] ?? null) === '_blank') target="_blank" rel="noopener" @endif>{{ $fact['value'] }}</a>
                                        @else
                                            {{ $fact['value'] }}
                                        @endif
                                    </dd>
                                </div>
                            @endforeach
                        </dl>
                    </div>

                    <div class="ud-card">
                        <h2>Location</h2>
                        <p><i class="fa fa-map-marker" style="font-size: 16px;"></i>
                            &nbsp;{{ $about_university->country->name ?? 'Unknown' }}, {{ $about_university->province->name ?? 'Unknown' }}, {{ $about_university->city ?? 'Unknown' }}, {{ $about_university->zip ?? 'Unknown' }}</p>

                        @php
                        $map = $about_university->map_location ?? '';
                        $src_data = $map;
                        if ($map) {
                            $parts = explode('src="', $map);
                            if (count($parts) > 1) {
                                $urlParts = explode('"', $parts[1]);
                                $src_data = $urlParts[0] ?? $map;
                            }
                        }
                        @endphp

                        @if ($src_data)
                            <iframe src="{{ $src_data }}" width="100%" height="360" style="border:0;" allowfullscreen loading="lazy"></iframe>
                        @else
                            <p class="text-danger">Map location not available.</p>
                        @endif
                    </div>
                </div>

                <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                    <div class="ud-card">
                        <h2>Photos</h2>
                        @php
                        $images = \Illuminate\Support\Facades\Cache::remember("university_{$about_university->id}_gallery", 3600, function () use ($about_university) {
                            return DB::table('university_galary_images')->where('university_id', $about_university->id)->get();
                        });
                        @endphp
                        @if($images->isNotEmpty())
                            <div class="ud-gallery-grid" id="ud-gallery-grid">
                                @foreach ($images as $image)
                                    <img data-src="{{ asset($image->file_name) }}" alt="{{ $about_university->university_name }} gallery photo" loading="lazy">
                                @endforeach
                            </div>
                        @else
                            @include('frontend.partials.university-empty-state', ['label' => 'photos'])
                        @endif
                    </div>
                </div>

                <div class="tab-pane fade" id="nav-contacts" role="tabpanel" aria-labelledby="nav-contacts-tabs">
                    <div class="ud-card">
                        <h2>Ranking</h2>
                        @php
                        $university_rankings = \Illuminate\Support\Facades\Cache::remember("university_{$about_university->id}_rankings", 3600, function () use ($about_university) {
                            return DB::table('university_ranking')->where('university_id', $about_university->id)->get();
                        });
                        @endphp
                        @if($university_rankings->isNotEmpty())
                            <div class="ud-rank-grid">
                                @foreach ($university_rankings as $ranking)
                                    <div class="ud-rank-card">
                                        <div class="from">{{ $ranking->from_place }}</div>
                                        <div class="rank">#{{ $ranking->ranking }}</div>
                                        <div class="meta">{{ $ranking->year }}{{ $ranking->type ? ' · ' . $ranking->type : '' }}</div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            @include('frontend.partials.university-empty-state', ['label' => 'ranking information'])
                        @endif
                    </div>
                </div>

                <div class="tab-pane fade" id="nav-notes" role="tabpanel" aria-labelledby="nav-notes-tabs">
                    <div class="ud-card">
                        <h2>Accommodation</h2>
                        @if (!empty($about_university->accomodation_details))
                            <div class="ud-prose">{!! $about_university->accomodation_details !!}</div>
                        @else
                            @include('frontend.partials.university-empty-state', ['label' => 'accommodation details'])
                        @endif
                    </div>
                </div>

                <div class="tab-pane fade" id="nav-tabing" role="tabpanel" aria-labelledby="nav-tabing-tabs">
                    <div class="ud-card">
                        <h2>Accreditation</h2>
                        @if (!empty($university_accerediations))
                            @foreach ($university_accerediations as $accreditation)
                                <div class="ud-accred-row">
                                    <svg class="check" width="20" height="20" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><circle cx="10" cy="10" r="8"/><path stroke-linecap="round" stroke-linejoin="round" d="M6.5 10.2l2.2 2.2L13.5 7.6"/></svg>
                                    @if($accreditation->logo ?? null)
                                        <img src="{{ asset($accreditation->logo) }}" alt="logo">
                                    @endif
                                    <div>
                                        <div>{{ $accreditation->name }}</div>
                                        <span>{{ $accreditation->year }}</span>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            @include('frontend.partials.university-empty-state', ['label' => 'accreditation details'])
                        @endif
                    </div>
                </div>

                <div class="tab-pane fade" id="nav-place" role="tabpanel" aria-labelledby="nav-place-tabs">
                    <div class="ud-card">
                        <h2>Placement</h2>
                        @if (!empty($about_university->placement))
                            <div class="ud-prose">{!! $about_university->placement !!}</div>
                        @else
                            @include('frontend.partials.university-empty-state', ['label' => 'placement details'])
                        @endif
                    </div>
                </div>

                <div class="tab-pane fade" id="nav-con" role="tabpanel" aria-labelledby="nav-con-tabs">
                    <div class="ud-card">
                        <h2>Notes</h2>
                        @if (!empty($about_university->notes))
                            <div class="ud-prose">{!! $about_university->notes !!}</div>
                        @else
                            @include('frontend.partials.university-empty-state', ['label' => 'notes'])
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="ud-bottombar">
    <a href="https://wa.me/918929922525?text=Hello,%20I%20am%20interested%20in%20your%20services!" target="_blank" class="wa">WhatsApp us</a>
    <button type="button" class="cnsl" onclick="openWizard()">Free counselling</button>
</div>

@endsection

@section('javascript_section')
<script>
    (function () {
        var galleryLoaded = false;
        var galleryTabBtn = document.getElementById('nav-contact-tab');
        if (galleryTabBtn) {
            galleryTabBtn.addEventListener('shown.bs.tab', function () {
                if (galleryLoaded) return;
                galleryLoaded = true;
                document.querySelectorAll('#ud-gallery-grid img[data-src]').forEach(function (img) {
                    img.src = img.getAttribute('data-src');
                    img.removeAttribute('data-src');
                });
            });
        }
    })();

    (function () {
        const loadMoreBtn = document.getElementById('ud-load-more');
        if (!loadMoreBtn) return;

        const listEl = document.getElementById('ud-program-list');
        const countrySlug = @json($studyInUniversitySlugs['country']);
        const universitySlug = @json($studyInUniversitySlugs['university']);
        const programName = @json($_GET['program_name'] ?? '');

        function money(amount, currency) {
            if (amount === null || amount === undefined || amount === '') return null;
            const n = Number(amount);
            if (isNaN(n)) return null;
            return (currency ? currency + ' ' : '') + n.toLocaleString('en-US');
        }

        function buildUrl(item) {
            return `{{ url('/') }}/study-in-${countrySlug}/${universitySlug}/${window.slugify(item.name)}-${item.id}`;
        }

        function icon(path) {
            return `<svg width="15" height="15" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true">${path}</svg>`;
        }

        const ICONS = {
            level: icon('<rect x="5" y="5" width="10" height="10" rx="2" transform="rotate(45 10 10)"/>'),
            clock: icon('<circle cx="10" cy="10" r="7"/><path stroke-linecap="round" d="M10 6v4l3 2"/>'),
            calendar: icon('<rect x="3" y="4" width="14" height="13" rx="2"/><path d="M3 8h14M7 2v4M13 2v4"/>'),
            dollar: icon('<circle cx="10" cy="10" r="7.5"/><path stroke-linecap="round" d="M10 5.5v9M12.3 7.6c0-1-1-1.6-2.3-1.6s-2.4.6-2.4 1.6c0 2.1 4.9 1 4.9 3.1 0 1-1 1.7-2.5 1.7s-2.4-.6-2.4-1.7"/>'),
        };

        function renderCard(item) {
            const level = item.program_level ? item.program_level.name : null;
            const lengthDigits = item.length ? String(item.length).replace(/[^0-9]/g, '') : '';
            const duration = lengthDigits ? `${lengthDigits} month${lengthDigits === '1' ? '' : 's'}` : null;
            const tuition = money(item.tution_fee, item.currency);
            const isFree = item.application_fee === null || item.application_fee === undefined || Number(item.application_fee) === 0;
            const url = buildUrl(item);

            return `
            <div class="ud-course-card">
                <div class="ud-course-top">
                    <a href="${url}">${item.name}</a>
                    ${isFree ? '<span class="ud-free-badge">Free to apply</span>' : ''}
                </div>
                <div class="ud-course-facts">
                    ${level ? `<div class="f">${ICONS.level}<span>${level}</span></div>` : ''}
                    ${duration ? `<div class="f">${ICONS.clock}<span>${duration}</span></div>` : ''}
                    ${item.programType ? `<div class="f">${ICONS.calendar}<span>${item.programType}</span></div>` : ''}
                    ${tuition ? `<div class="f">${ICONS.dollar}<span><b>${tuition}</b> /yr</span></div>` : ''}
                </div>
                <a href="${url}" class="ud-view-btn">View course &rarr;</a>
            </div>`;
        }

        loadMoreBtn.addEventListener('click', function () {
            const nextPage = parseInt(loadMoreBtn.dataset.page) + 1;
            loadMoreBtn.disabled = true;
            loadMoreBtn.textContent = 'Loading…';

            const params = new URLSearchParams({ tab: 'programs', page: nextPage });
            if (programName) params.set('program_name', programName);

            fetch(window.location.pathname + '?' + params.toString(), {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
                .then(res => res.json())
                .then(res => {
                    listEl.insertAdjacentHTML('beforeend', res.data.map(renderCard).join(''));
                    loadMoreBtn.dataset.page = nextPage;
                    loadMoreBtn.disabled = false;
                    loadMoreBtn.textContent = 'Show more courses';
                    if (!res.has_more) {
                        loadMoreBtn.remove();
                    }
                })
                .catch(() => {
                    loadMoreBtn.disabled = false;
                    loadMoreBtn.textContent = 'Show more courses';
                });
        });
    })();
</script>
@endsection
