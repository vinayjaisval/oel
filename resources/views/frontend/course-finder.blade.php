
@extends('frontend.layouts.main')
@section('title', 'Course Finder')
@section('content')
<style>
    .ap {
        --navy: #111A66;
        --orange: #C2410C;
        --bg: #F4F6FB;
        --border: #E3E7F0;
        --green: #166534;
        background: var(--bg);
    }

    .ap-band {
        background: var(--navy);
        padding: 28px 0 24px;
    }

    .ap-band h1 {
        color: #fff;
        font-weight: 700;
        font-size: clamp(22px, 3.4vw, 30px);
        margin-bottom: 4px;
    }

    .ap-band p {
        color: #c9cdf0;
        margin-bottom: 18px;
    }

    .ap-search-row {
        display: flex;
        gap: 8px;
        background: #fff;
        border-radius: 12px;
        padding: 8px;
        box-shadow: 0 10px 30px rgba(17, 26, 102, 0.12);
    }

    .ap-search-row input[type="search"],
    .ap-search-row input[type="text"] {
        flex: 1;
        border: none;
        min-height: 44px;
        padding: 0 14px;
        font-size: 16px;
        border-radius: 8px;
    }

    .ap-search-row input:focus {
        outline: 2px solid var(--navy);
        outline-offset: -2px;
    }

    .ap-search-row button {
        background: var(--orange);
        border: none;
        color: #fff;
        font-weight: 600;
        border-radius: 8px;
        min-height: 44px;
        min-width: 44px;
        padding: 0 18px;
    }

    .ap-search-row button:hover {
        background: #a8380a;
    }

    .ap-popular {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        align-items: center;
        margin-top: 14px;
    }

    .ap-popular .label {
        color: #c9cdf0;
        font-size: 13px;
        margin-right: 2px;
    }

    .ap-chip {
        background: rgba(255, 255, 255, 0.12);
        border: 1px solid rgba(255, 255, 255, 0.3);
        color: #fff;
        border-radius: 999px;
        padding: 6px 14px;
        font-size: 13px;
        cursor: pointer;
    }

    .ap-chip:hover {
        background: rgba(255, 255, 255, 0.22);
    }

    .ap-body {
        padding: 24px 0 48px;
    }

    .ap-grid {
        display: grid;
        grid-template-columns: 280px 1fr;
        gap: 22px;
        align-items: start;
    }

    @media (max-width: 991px) {
        .ap-grid {
            grid-template-columns: 1fr;
        }
    }

    .ap-sidebar {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 18px;
    }

    .ap-sidebar-head {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 12px;
    }

    .ap-sidebar-head h2 {
        font-weight: 700;
        font-size: 16px;
        margin: 0;
        color: #1f2430;
    }

    .ap-clear-all {
        background: none;
        border: none;
        color: var(--navy);
        font-weight: 600;
        font-size: 13px;
        padding: 0;
        cursor: pointer;
    }

    .ap-filter-group {
        margin-bottom: 18px;
    }

    .ap-filter-group > .ap-label {
        display: block;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: .04em;
        color: #6b7280;
        text-transform: uppercase;
        margin-bottom: 8px;
    }

    .ap-country-search {
        width: 100%;
        min-height: 40px;
        border: 1px solid var(--border);
        border-radius: 8px;
        padding: 0 10px;
        margin-bottom: 8px;
        font-size: 14px;
    }

    .ap-checkbox-list {
        list-style: none;
        margin: 0;
        padding: 0;
        max-height: 260px;
        overflow-y: auto;
    }

    .ap-checkbox-list li {
        margin-bottom: 2px;
    }

    .ap-checkbox-list label {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 6px 2px;
        font-size: 14px;
        color: #374151;
        cursor: pointer;
        min-height: 32px;
    }

    .ap-checkbox-list input[type="checkbox"] {
        width: 17px;
        height: 17px;
        accent-color: var(--navy);
        flex-shrink: 0;
    }

    .ap-show-more {
        background: none;
        border: none;
        color: var(--navy);
        font-weight: 600;
        font-size: 13px;
        padding: 6px 2px;
        cursor: pointer;
    }

    .ap-pill-group {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    .ap-pill {
        border: 1px solid var(--border);
        background: #fff;
        color: #374151;
        border-radius: 999px;
        padding: 7px 14px;
        font-size: 13px;
        cursor: pointer;
        min-height: 36px;
    }

    .ap-pill input {
        position: absolute;
        opacity: 0;
        pointer-events: none;
    }

    .ap-pill.active,
    .ap-pill:has(input:checked) {
        background: var(--navy);
        border-color: var(--navy);
        color: #fff;
    }

    .ap-more-toggle {
        background: none;
        border: none;
        border-top: 1px solid var(--border);
        width: 100%;
        text-align: left;
        padding: 12px 2px 0;
        font-weight: 600;
        color: var(--navy);
        cursor: pointer;
    }

    .ap-more-filters {
        display: none;
        margin-top: 14px;
    }

    .ap-more-filters.open {
        display: block;
    }

    .ap-more-filters .accordion-button h5 {
        font-size: 14px;
        margin: 0;
        font-weight: 600;
    }

    .ap-results-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 10px;
    }

    .ap-tabs {
        display: inline-flex;
        background: #fff;
        border: 1px solid var(--border);
        border-radius: 10px;
        padding: 3px;
    }

    .ap-tab {
        border: none;
        background: none;
        padding: 8px 16px;
        font-weight: 600;
        font-size: 14px;
        color: #6b7280;
        border-radius: 8px;
        cursor: pointer;
    }

    .ap-tab.active {
        background: var(--navy);
        color: #fff;
    }

    .ap-sort {
        min-height: 40px;
        border: 1px solid var(--border);
        border-radius: 8px;
        padding: 0 10px;
        font-size: 14px;
        background: #fff;
    }

    .ap-showing {
        color: #6b7280;
        font-size: 13px;
        margin-bottom: 10px;
    }

    .ap-active-chip-row {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        margin-bottom: 14px;
    }

    .ap-active-chip-row .badge {
        background: #EEF0FA !important;
        color: var(--navy) !important;
        border: 1px solid var(--border);
        border-radius: 999px;
        padding: 6px 10px;
        font-size: 12px;
        font-weight: 600;
    }

    /* ---- course row card ---- */
    .course_data {
        display: flex;
        flex-direction: column;
        gap: 14px;
    }

    .ap-course-row {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 16px;
        display: flex;
        align-items: center;
        gap: 16px;
        flex-wrap: wrap;
    }

    .ap-logo {
        width: 52px;
        height: 52px;
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

    .ap-logo img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    .ap-course-main {
        flex: 1 1 320px;
        min-width: 0;
    }

    .ap-course-main .title a {
        font-weight: 700;
        color: var(--navy);
        text-decoration: none;
        font-size: 16px;
    }

    .ap-course-main .title a:hover {
        text-decoration: underline;
    }

    .ap-course-main .uni {
        color: #6b7280;
        font-size: 13px;
        margin-bottom: 8px;
    }

    .ap-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
    }

    .ap-tag {
        background: var(--bg);
        border: 1px solid var(--border);
        border-radius: 999px;
        padding: 3px 10px;
        font-size: 12px;
        color: #374151;
    }

    .ap-tag.fee {
        background: #EAF6EC;
        border-color: #CFE9D3;
        color: var(--green);
    }

    .ap-course-side {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-shrink: 0;
        margin-left: auto;
    }

    .ap-tuition {
        text-align: right;
    }

    .ap-tuition .l {
        display: block;
        font-size: 12px;
        color: #6b7280;
    }

    .ap-tuition .v {
        font-weight: 700;
        color: #1f2430;
        font-size: 16px;
    }

    .ap-heart-btn {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        border: 1px solid var(--border);
        background: #fff;
        color: #9ca3af;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }

    .ap-heart-btn.active {
        color: var(--orange);
        border-color: var(--orange);
    }

    .ap-view-btn {
        background: var(--navy);
        color: #fff;
        font-weight: 600;
        border-radius: 8px;
        padding: 10px 18px;
        text-decoration: none;
        min-height: 44px;
        display: inline-flex;
        align-items: center;
        white-space: nowrap;
    }

    .ap-view-btn:hover {
        background: #0c1450;
        color: #fff;
    }

    /* ---- university grid card ---- */
    .university-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(min(100%, 300px), 1fr));
        gap: 16px;
    }

    .ap-uni-card {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 16px;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .ap-uni-card-head {
        display: flex;
        gap: 12px;
        align-items: flex-start;
    }

    .ap-uni-card-head .name a {
        font-weight: 700;
        color: var(--navy);
        text-decoration: none;
    }

    .ap-uni-card-head .name a:hover {
        text-decoration: underline;
    }

    .ap-uni-card-head .loc {
        color: #6b7280;
        font-size: 13px;
    }

    .ap-uni-actions {
        display: flex;
        gap: 8px;
        margin-top: auto;
    }

    .ap-uni-actions .ap-view-btn {
        flex: 1;
        justify-content: center;
    }

    .ap-uni-actions .ap-details-btn {
        flex: 1;
        justify-content: center;
        background: #fff;
        color: var(--navy);
        border: 1px solid var(--border);
        font-weight: 600;
        border-radius: 8px;
        padding: 10px 18px;
        text-decoration: none;
        min-height: 44px;
        display: inline-flex;
        align-items: center;
        text-align: center;
    }

    .ap-uni-actions .ap-details-btn:hover {
        background: var(--bg);
        color: var(--navy);
    }

    /* ---- pagination / load more ---- */
    .ap-pagination {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        justify-content: center;
        padding: 24px 0 0;
    }

    .ap-pagination button {
        min-width: 40px;
        min-height: 40px;
        border-radius: 8px;
        border: 1px solid var(--border);
        background: #fff;
        color: var(--navy);
        font-weight: 600;
    }

    .ap-pagination button[aria-current="true"] {
        background: var(--navy);
        color: #fff;
        border-color: var(--navy);
    }

    .ap-pagination button:disabled {
        opacity: .45;
    }

    .ap-load-more {
        display: none;
        width: 100%;
        margin-top: 10px;
        min-height: 48px;
        border-radius: 10px;
        border: 1px solid var(--border);
        background: #fff;
        color: var(--navy);
        font-weight: 600;
    }

    .ap-skel {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: 12px;
        height: 110px;
        animation: ap-pulse 1.4s ease-in-out infinite;
    }

    @keyframes ap-pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: .55; }
    }

    .ap-empty {
        text-align: center;
        padding: 40px 0;
        color: #6b7280;
    }

    /* ---- mobile sticky filter bar ---- */
    .ap-mobile-filterbar {
        display: none;
        background: #fff;
        border-bottom: 1px solid var(--border);
        padding: 10px 14px;
        position: sticky;
        top: 0;
        z-index: 40;
        gap: 8px;
        align-items: center;
        overflow-x: auto;
    }

    .ap-filters-btn {
        background: var(--navy);
        color: #fff;
        border: none;
        border-radius: 999px;
        padding: 8px 14px;
        font-weight: 600;
        font-size: 13px;
        white-space: nowrap;
        min-height: 40px;
    }

    .ap-mobile-filterbar .ap-active-chip-row {
        margin-bottom: 0;
        flex-wrap: nowrap;
    }

    /* ---- mobile sticky bottom bar ---- */
    .ap-bottombar {
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

    .ap-bottombar a {
        flex: 1;
        text-align: center;
        min-height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        font-weight: 600;
        text-decoration: none;
    }

    .ap-bottombar .wa {
        border: 1px solid var(--border);
        color: var(--navy);
        background: #fff;
    }

    .ap-bottombar .elig {
        background: var(--orange);
        color: #fff;
    }

    .ap-sidebar-close {
        display: none;
        background: none;
        border: none;
        font-size: 20px;
        line-height: 1;
        cursor: pointer;
        color: #374151;
        min-width: 32px;
        min-height: 32px;
    }

    .ap-sidebar-apply {
        display: none;
        width: 100%;
        min-height: 48px;
        border-radius: 10px;
        background: var(--navy);
        color: #fff;
        border: none;
        font-weight: 600;
        margin-top: 16px;
    }

    @media (max-width: 991px) {
        .ap-mobile-filterbar {
            display: flex;
        }

        .ap-bottombar {
            display: flex;
        }

        .ap-body {
            padding-bottom: 90px;
        }

        .ap-load-more {
            display: block;
        }

        .ap-pagination.desktop-only {
            display: none;
        }

        .ap-sidebar {
            position: fixed;
            left: 0;
            right: 0;
            bottom: 0;
            top: 10vh;
            border-radius: 16px 16px 0 0;
            z-index: 100;
            transform: translateY(110%);
            transition: transform .25s ease;
            overflow-y: auto;
            display: block !important;
        }

        .ap-sidebar.open {
            transform: translateY(0);
        }

        .ap-sidebar-backdrop {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(17, 26, 102, 0.35);
            z-index: 90;
        }

        .ap-sidebar-backdrop.open {
            display: block;
        }

        .ap-sidebar-close,
        .ap-sidebar-apply {
            display: block;
        }
    }

    a.ap-view-btn:focus-visible,
    .ap-heart-btn:focus-visible,
    .ap-tab:focus-visible,
    .ap-pill:focus-visible-within,
    .ap-pagination button:focus-visible {
        outline: 3px solid #90a4ff;
        outline-offset: 2px;
    }
</style>

@php
    $countryIds = array_values(array_filter(array_map(function ($token) {
        $token = trim($token);
        if ($token === '') {
            return null;
        }
        return preg_match('/(\d+)$/', $token, $m) ? $m[1] : $token;
    }, explode(',', $_GET['country'] ?? ''))));
    $country_name = App\Models\Country::whereIn('id', $countryIds)->Select('name','id')->get();
    $program_level_name = App\Models\ProgramLevel::whereIn(
    'id',
    explode(',', $_GET['program_level'] ?? null),
    )->get();
    $program_sub_level_name = App\Models\ProgramSubLevel::whereIn(
    'id',
    explode(',', $_GET['program_sub_level'] ?? null),
    )->get();
    $education_level_name = App\Models\EducationLevel::whereIn(
    'id',
    explode(',', $_GET['education_level'] ?? null),
    )->get();
    $program_discipline_name = App\Models\ProgramDiscipline::whereIn(
    'id',
    explode(',', $_GET['program_discipline'] ?? null),
    )->get();
    $program_sub_discipline_name = App\Models\ProgramSubdiscipline::whereIn(
    'id',
    explode(',', $_GET['program_sub_discipline'] ?? null),
    )->get();
    $eng_proficiency_level_name = App\Models\EngProficiencyLevel::whereIn(
    'id',
    explode(',', $_GET['eng_proficiency_level'] ?? null),
    )->get();

    $other_exam_name = App\Models\Exam::whereIn('id', explode(',', $_GET['other_exam'] ?? null))->get();
    $intake=  explode(',', $_GET['intake'] ?? null);



    $state = App\Models\Province::where('id', $university->state ?? null)->get();
    $university_type = App\Models\SchoolType::where('id', $university->type_of_university ?? null)->get();
@endphp
@php
    $shortlistUser = Auth::user();
    $canManageProgramShortlists = $shortlistUser && $shortlistUser->hasAnyRole(['agent', 'sub_agent']);
    $shortlistBusinessRole = $shortlistUser && $shortlistUser->hasRole('agent') ? 'Agent' : 'Sub-Agent';
@endphp
@if(Auth::check())
    @php
    $user=Auth::user();
    $student_data=DB::table('student')->select('country_id','id')->where('user_id',$user->id)->first();
    $program_id=DB::table('student_by_agent')->select('program_label')->where('student_user_id',$student_data->id ?? null)->first();
    $education_id=DB::table('education_history')->select('education_level_id')->where('student_id',$student_data->id  ?? null)->first();
    @endphp
@endif

<div class="ap">
    <section class="ap-band">
        <div class="container">
            <h1>Find your course abroad</h1>
            <p id="ap-subtitle">{{ number_format($totalCourses) }} courses across {{ number_format($totalUniversities) }} universities</p>
            <form class="ap-search-row" id="ap-search-form">
                <input type="search" id="program-directory-search" placeholder="Course or university, e.g. Data Science, Glasgow" aria-label="Search programs or universities">
                <button type="submit" aria-label="Search"><i class="fa fa-search" aria-hidden="true"></i></button>
            </form>
            <div class="ap-popular">
                <span class="label">Popular:</span>
                <button type="button" class="ap-chip" data-preset-country="united-kingdom-230">Postgraduate in UK</button>
                <button type="button" class="ap-chip" data-preset-country="canada-38">Study in Canada</button>
                <button type="button" class="ap-chip" data-preset-country="south-korea-116">Study in South Korea</button>
            </div>
        </div>
    </section>

    <div class="ap-mobile-filterbar">
        <button type="button" class="ap-filters-btn" id="ap-open-filters">Filters <span id="ap-filter-count"></span></button>
        <div class="ap-active-chip-row ap-active-chip-row-mobile-mirror"></div>
    </div>

    <div class="ap-sidebar-backdrop" id="ap-sidebar-backdrop"></div>

    <section class="container ap-body">
        @if(session()->has('success'))
            <div class="alert alert-success">{{ session()->get('success') }}</div>
        @endif

        @if($canManageProgramShortlists)
        <div class="mb-3" id="program-shortlist-tools">
            <div class="border rounded p-3 bg-light">
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                    <div>
                        <strong>Program Shortlisting</strong>
                        <span class="text-muted ms-2">{{ $shortlistBusinessRole }}</span>
                        <span class="ms-3">Selected: <strong id="shortlist-selected-count">0 / 5</strong></span>
                    </div>
                    <div class="d-flex flex-wrap gap-2">
                        <button type="button" class="btn btn-outline-primary btn-sm" id="shortlist-select-page">Select current page</button>
                        <button type="button" class="btn btn-outline-secondary btn-sm" id="shortlist-clear-selection">Clear selection</button>
                        <button type="button" class="btn btn-primary btn-sm" id="shortlist-save-open" data-bs-toggle="modal" data-bs-target="#saveProgramShortlist" disabled>Save New Shortlist</button>
                        <a class="btn btn-outline-dark btn-sm" href="{{ route('program-shortlists.index') }}">My Shortlists</a>
                    </div>
                </div>
                <div class="small mt-2" id="shortlist-feedback" role="status" aria-live="polite"></div>
            </div>
        </div>
        <div class="modal fade" id="saveProgramShortlist" tabindex="-1" aria-labelledby="saveProgramShortlistLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <form class="modal-content" id="save-program-shortlist-form">
                    <div class="modal-header">
                        <h5 class="modal-title" id="saveProgramShortlistLabel">Save New Shortlist</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <label for="program-shortlist-name" class="form-label">Shortlist name</label>
                        <input id="program-shortlist-name" name="name" class="form-control" maxlength="120" required>
                        <div class="invalid-feedback" id="program-shortlist-name-error"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="program-shortlist-submit">Save Shortlist</button>
                    </div>
                </form>
            </div>
        </div>
        @endif

        <div class="ap-grid">
            <aside class="ap-sidebar" id="ap-sidebar">
                <div class="ap-sidebar-head">
                    <h2>Filters</h2>
                    <div class="d-flex align-items-center gap-3">
                        <button type="button" class="ap-clear-all" id="ap-clear-all">Clear all</button>
                        <button type="button" class="ap-sidebar-close" id="ap-close-filters" aria-label="Close filters">&times;</button>
                    </div>
                </div>

                <div class="ap-filter-group">
                    <span class="ap-label">Country</span>
                    <input type="text" class="ap-country-search keyword" placeholder="Search country" aria-label="Search country">
                    <ul class="ap-checkbox-list addto-playlists1" id="ap-country-list">
                        @foreach ($country as $item)
                            <li>
                                <label for="{{ $item->id }}-country">
                                    <input type="checkbox" name="country[]" class="country-checkbox"
                                        value="{{ \Illuminate\Support\Str::slug($item->name) . '-' . $item->id }}"
                                        id="{{ $item->id }}-country"
                                        {{ in_array($item->id, $country_name->pluck('id')->toArray()) ? 'checked' : '' }}>
                                    {{ $item->name }}
                                </label>
                            </li>
                        @endforeach
                    </ul>
                    @if($country->count() > 6)
                        <button type="button" class="ap-show-more" id="ap-country-show-more">+ {{ $country->count() - 6 }} more</button>
                    @endif
                </div>

                <div class="ap-filter-group">
                    <span class="ap-label">Level</span>
                    <div class="ap-pill-group addto-playlists2">
                        @foreach ($program_level as $item)
                            <label class="ap-pill">
                                <input class="program_level_value"
                                    id="{{ $item->id }}-program-level"
                                    {{ in_array($item->id, $program_level_name->pluck('id')->toArray()) ? 'checked' : '' }}
                                    type="checkbox" name="program_level[]"
                                    value="{{ $item->id }}"
                                    onchange="fetchProgramSubLevel(this.id)">
                                {{ $item->name }}
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="ap-filter-group">
                    <span class="ap-label">Intake</span>
                    <div class="ap-pill-group">
                        @foreach (range(1, 12) as $month)
                            <label class="ap-pill">
                                <input type="checkbox" name="intake[]" class="intake-name-data" value="{{ $month }}"
                                    {{ in_array((string) $month, $intake) ? 'checked' : '' }}>
                                {{ date('M', strtotime(date('Y') . '-' . $month . '-01')) }}
                            </label>
                        @endforeach
                    </div>
                </div>

                <button type="button" class="ap-more-toggle" id="ap-more-toggle" aria-expanded="false">More filters</button>
                <div class="ap-more-filters" id="ap-more-filters">
                    <div class="accordion accordion-flush" id="accordionExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" id="education_level" type="button" data-bs-toggle="collapse" data-bs-target="#col3" aria-expanded="false" aria-controls="col3">
                                    <h5>Program Sub Level</h5>
                                </button>
                            </h2>
                            <div id="col3" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                <div class="addto-playlists3">
                                    <ul class="program-sub-level"></ul>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed subdiscipline" type="button" data-bs-toggle="collapse" data-bs-target="#col6" aria-expanded="false" aria-controls="col6">
                                    <h5>Program Discipline</h5>
                                </button>
                            </h2>
                            <div id="col6" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                <div class="addto-playlists6">
                                    <ul>
                                        @foreach ($program_discipline as $item)
                                            <li>
                                                <label class="playlist-name" for="discipline_{{ $item->id }}">
                                                    <input type="checkbox" name="program_discipline[]" class="program_discipline_checkbox"
                                                        id="discipline_{{ $item->id }}" value="{{ $item->id }}"
                                                        {{ in_array($item->id, $program_discipline_name->pluck('id')->toArray()) ? 'checked' : '' }}>
                                                    {{ $item->name }}
                                                </label>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#col7" aria-expanded="false" aria-controls="col7">
                                    <h5>Program Sub Discipline</h5>
                                </button>
                            </h2>
                            <div id="col7" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                <div class="addto-playlists4">
                                    <ul class="program_subdiscipline"></ul>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#col8" aria-expanded="false" aria-controls="col8">
                                    <h5>English Proficiency Level</h5>
                                </button>
                            </h2>
                            <div id="col8" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                <div class="addto-playlists8">
                                    <ul>
                                        @foreach ($eng_proficiency_level as $item)
                                            <li>
                                                <label for="eng-pro-{{ $item->id }}" class="playlist-name">
                                                    <input type="checkbox" name="end_profiency_level[]" class="eng-pro"
                                                        {{ in_array($item->id, $eng_proficiency_level_name->pluck('id')->toArray()) ? 'checked' : '' }}
                                                        value="{{ $item->id }}" id="eng-pro-{{ $item->id }}">
                                                    {{ $item->name }}
                                                </label>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#col9" aria-expanded="false" aria-controls="col9">
                                    <h5>Other Exam</h5>
                                </button>
                            </h2>
                            <div id="col9" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                <div class="addto-playlists9">
                                    <ul>
                                        @foreach ($exam as $item)
                                            <li>
                                                <label for="other-exam-{{ $item->id }}" class="playlist-name">
                                                    <input type="checkbox" name="other_exam[]" class="other_exam_check"
                                                        {{ in_array($item->id, $eng_proficiency_level_name->pluck('id')->toArray()) ? 'checked' : '' }}
                                                        value="{{ $item->id }}" id="other-exam-{{ $item->id }}">
                                                    {{ $item->name }}
                                                </label>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="button" class="ap-sidebar-apply" id="ap-sidebar-apply">Show courses</button>
            </aside>

            <div class="ap-results">
                <div class="ap-results-top">
                    <div class="ap-tabs" id="nav-tab" role="tablist">
                        <button type="button" class="ap-tab active apps-vt" id="nav-contact-tab" role="tab" aria-selected="true" onclick="showContactTab()">
                            Courses &middot; <span class="course_count">0</span>
                        </button>
                        <button type="button" class="ap-tab app-vt" id="nav-profile-tab" role="tab" aria-selected="false" onclick="showProfileTab()">
                            Universities &middot; <span class="university_count">0</span>
                        </button>
                    </div>
                    <select class="ap-sort" id="program-directory-sort" aria-label="Sort programs">
                        <option value="name">Most relevant</option>
                        <option value="university">University name</option>
                        <option value="tuition">Tuition fee</option>
                    </select>
                </div>

                <div class="ap-showing" id="ap-showing-text"></div>

                <div class="ap-active-chip-row">
                    @php
                        $apChipGroups = [
                            ['class' => 'country_name', 'input' => 'country', 'items' => $country_name],
                            ['class' => 'program_level_name', 'input' => 'program_level', 'items' => $program_level_name],
                            ['class' => 'program_sub_level_name', 'input' => 'program_sub_level', 'items' => $program_sub_level_name],
                            ['class' => 'education_level_name', 'input' => 'education_level', 'items' => $education_level_name],
                            ['class' => 'program_discipline_name', 'input' => 'program_discipline', 'items' => $program_discipline_name],
                            ['class' => 'program_sub_discipline_name', 'input' => 'program_sub_discipline', 'items' => $program_sub_discipline_name],
                            ['class' => 'eng_proficiency_level_name', 'input' => 'end_profiency_level', 'items' => $eng_proficiency_level_name],
                            ['class' => 'other_exam_name', 'input' => 'other_exam', 'items' => $other_exam_name],
                        ];
                    @endphp
                    @foreach ($apChipGroups as $group)
                        <div class="{{ $group['class'] }}">
                            @foreach ($group['items'] as $item)
                                <span class="badge">{{ $item->name }} <a href="javascript:void(0)" class="ap-chip-remove" data-input="{{ $group['input'] }}" data-value-label="{{ $item->name }}" style="color:inherit;text-decoration:none;font-weight:800;">&times;</a></span>
                            @endforeach
                        </div>
                    @endforeach
                    <div class="intake_name">
                        @foreach ($intake as $month)
                            @if ($month)
                                @php $monthLabel = date('M', strtotime(date('Y') . '-' . $month . '-01')); @endphp
                                <span class="badge">{{ $monthLabel }} <a href="javascript:void(0)" class="ap-chip-remove" data-input="intake" data-value-label="{{ $monthLabel }}" style="color:inherit;text-decoration:none;font-weight:800;">&times;</a></span>
                            @endif
                        @endforeach
                    </div>
                </div>

                <div id="nav-contact" role="tabpanel">
                    <div class="course_data"></div>
                    <p class="ap-empty" id="ap-course-empty" style="display:none">No courses found for these filters.</p>
                    <nav class="ap-pagination desktop-only" id="ap-course-pagination" aria-label="Course results pages"></nav>
                    <button type="button" class="ap-load-more" id="ap-course-load-more">Load 20 more</button>
                </div>

                <div id="nav-profile" role="tabpanel" style="display:none">
                    <div class="university-grid" id="university"></div>
                    <p class="ap-empty" id="ap-uni-empty" style="display:none">No universities found for these filters.</p>
                    <nav class="ap-pagination desktop-only" id="ap-uni-pagination" aria-label="University results pages"></nav>
                    <button type="button" class="ap-load-more" id="ap-uni-load-more">Load 20 more</button>
                </div>
            </div>
        </div>
    </section>
</div>

<div class="ap-bottombar">
    <a href="https://wa.me/918929922525?text=Hello,%20I%20am%20interested%20in%20your%20services!" target="_blank" class="wa">WhatsApp us</a>
    <a href="{{ route('check-eligible') }}" class="elig">Check eligibility</a>
</div>

@endsection
@section('javascript_section')
<script type="text/javascript">
   (function($) {
       $(".keyword").on('keyup', function(e) {
           var $this = $(this);
           var exp = new RegExp($this.val(), 'i');
           $(".addto-playlists1 li label").each(function() {
               var $self = $(this);
               if (!exp.test($self.text())) {
                   $self.parent().hide();
               } else {
                   $self.parent().show();
               }
           });
       });
   })(jQuery);
</script>


<script>
         $(document).ready(function () {
    // ---------- GLOBAL VARIABLES ----------
    let coursePage = 1;
    let uniPage = 1;
    let lastCoursePagination = null;
    let lastUniPagination = null;
    let activeRequest = null;
    let requestVersion = 0;
    const shortlistEnabled = @json($canManageProgramShortlists);
    const selectedProgramIds = new Set();
    let currentPageProgramIds = [];
    const isInitialUnfilteredLoad = !window.location.search;

    function isMobile() {
        return window.matchMedia('(max-width: 991px)').matches;
    }

    function syncShortlistControls() {
        if (!shortlistEnabled) return;
        $('#shortlist-selected-count').text(selectedProgramIds.size + ' / 5');
        $('#shortlist-save-open').prop('disabled', selectedProgramIds.size === 0);
        const allSelected = currentPageProgramIds.length > 0 && currentPageProgramIds.every(id => selectedProgramIds.has(String(id)));
        $('#shortlist-select-page').text(allSelected ? 'Deselect current page' : 'Select current page');
    }

    // ---------- CSRF HEADER SETUP ----------
    function csrf() {
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });
    }

    // ---------- URL PARAM HANDLER ----------
    function getParams() {
        const params = new URLSearchParams(window.location.search);
        params.delete('page');
        return params.toString();
    }

    function reloadProgramDirectoryParameter(name, value) {
        const params = new URLSearchParams(window.location.search);
        params.delete('page');
        if (value) params.set(name, value);
        else params.delete(name);
        const query = params.toString();
        window.history.replaceState(null, '', window.location.pathname + (query ? '?' + query : ''));
        coursePage = 1;
        uniPage = 1;
        currentPageProgramIds = [];
        $('#university').empty();
        $('.course_data').empty();
        loadData('replace');
        updateFilterCount();
    }

    // ---------- SUBMIT LONG PROGRAM-ID LISTS VIA POST (kept out of the URL) ----------
    window.submitProgramIds = function (action, ids) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = action;
        form.style.display = 'none';

        const token = document.createElement('input');
        token.type = 'hidden';
        token.name = '_token';
        token.value = '{{ csrf_token() }}';
        form.appendChild(token);

        const idsInput = document.createElement('input');
        idsInput.type = 'hidden';
        idsInput.name = 'selected_program_id';
        idsInput.value = ids;
        form.appendChild(idsInput);

        document.body.appendChild(form);
        form.submit();
    };

    // ---------- SEO URL BUILDERS ----------
      const BASE_URL = "{{ url('/') }}";

    function buildUniversityUrl(item) {
        return `${BASE_URL}/study-in-${slugify(item.country?.name)}/${slugify(item.university_name)}-${item.id}`;
    }

    function buildProgramUrl(item) {
        const university = item.university_name || {};
        return `${BASE_URL}/study-in-${slugify(university.country_name?.name)}/${slugify(university.university_name)}-${university.id ?? 0}/${slugify(item.name)}-${item.id}`;
    }

    function initials(name) {
        return String(name || '').split(/\s+/).filter(Boolean).slice(0, 2).map(w => w[0]).join('').toUpperCase();
    }

    // ---------- UNIVERSAL RENDER HELPERS ----------
    function renderUniversity(item) {
        const urlParams = getParams();
        let programAction = '';

        if (!urlParams) {
            @if(auth()->check())
                programAction = "{{ url('selected-program-data') }}";
            @else
                programAction = "{{ url('view-program-data') }}";
            @endif
        } else {
            programAction = "{{ url('view-program-data') }}";
        }

        const logoSrc = item.logo ? `${BASE_URL}/public/${item.logo}` : '';
        const name = item.university_name || '';
        const locationBits = [item.city, item.country?.name].filter(Boolean).join(', ');

        return `
        <div class="ap-uni-card">
            <div class="ap-uni-card-head">
                <div class="ap-logo">${logoSrc ? `<img src="${logoSrc}" alt="${name} logo" loading="lazy" decoding="async" onerror="this.parentElement.textContent='${initials(name)}'">` : initials(name)}</div>
                <div>
                    <div class="name"><a href="${buildUniversityUrl(item)}">${name}</a></div>
                    <div class="loc">${locationBits}</div>
                </div>
            </div>
            <div class="ap-tags">
                ${item.university_type?.name ? `<span class="ap-tag">${item.university_type.name}</span>` : ''}
            </div>
            <div class="ap-uni-actions">
                <a href="javascript:void(0)" onclick="submitProgramIds('${programAction}', '${item.program_ids}')" class="ap-view-btn">${item.program_count ?? 0} programs</a>
                <a href="${buildUniversityUrl(item)}" class="ap-details-btn">Details</a>
            </div>
        </div>
        `;
    }

    function sentenceCase(text) {
        const lower = String(text ?? '').toLowerCase();
        return lower.charAt(0).toUpperCase() + lower.slice(1);
    }

    function renderCourse(item) {
        const checked = shortlistEnabled && selectedProgramIds.has(String(item.id));
        const selectionControl = shortlistEnabled
            ? `<button type="button" class="ap-heart-btn shortlist-program-btn${checked ? ' active' : ''}" data-id="${item.id}" aria-pressed="${checked}" aria-label="Add to shortlist" title="Add to shortlist">&#9825;</button>`
            : '';
        const uni = item.university_name || {};
        const country = uni.country_name?.name || '';
        const appFee = (item.application_fee === null || item.application_fee === undefined || item.application_fee === '' || Number(item.application_fee) === 0)
            ? { text: 'Free', free: true }
            : { text: (item.currency ? item.currency + ' ' : '') + Number(item.application_fee).toLocaleString('en-US'), free: false };
        const tuition = item.tution_fee ? (item.currency ? item.currency + ' ' : '') + Number(item.tution_fee).toLocaleString('en-US') : null;
        const duration = item.length ? `${item.length} month${item.length == 1 ? '' : 's'}` : null;
        const logoSrc = uni.logo ? `${BASE_URL}/public/${uni.logo}` : '';

        return `
        <div class="ap-course-row program-listing-row" data-name="${String(item.name || '').replace(/&/g, '&amp;').replace(/"/g, '&quot;').toLowerCase()}" data-university="${String(uni.university_name || '').replace(/&/g, '&amp;').replace(/"/g, '&quot;').toLowerCase()}" data-tuition="${Number(item.tution_fee) || 0}">
            <div class="ap-logo">${logoSrc ? `<img src="${logoSrc}" alt="${uni.university_name || ''} logo" loading="lazy" decoding="async" onerror="this.parentElement.textContent='${initials(uni.university_name)}'">` : initials(uni.university_name)}</div>
            <div class="ap-course-main">
                <div class="title"><a href="${buildProgramUrl(item)}">${item.name || ''}</a></div>
                <div class="uni">${uni.university_name || ''}${country ? ' &middot; ' + country : ''}</div>
                <div class="ap-tags">
                    ${item.program_level?.name ? `<span class="ap-tag">${item.program_level.name}</span>` : ''}
                    ${duration ? `<span class="ap-tag">${duration}</span>` : ''}
                    <span class="ap-tag fee">App fee: ${appFee.text}</span>
                </div>
            </div>
            <div class="ap-course-side">
                ${tuition ? `<div class="ap-tuition"><span class="l">1st year tuition</span><span class="v">${tuition}</span></div>` : ''}
                ${selectionControl}
                <a href="${buildProgramUrl(item)}" class="ap-view-btn">View details</a>
            </div>
        </div>
        `;
    }

    function renderSkeletons(n) {
        return Array.from({ length: n }).map(() => '<div class="ap-skel" aria-hidden="true"></div>').join('');
    }

    function renderPagination(container, pagination, onPage) {
        const nav = $(container);
        if (!pagination || pagination.last_page <= 1) {
            nav.empty();
            return;
        }
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
        nav.off('click', 'button[data-page]').on('click', 'button[data-page]', function () {
            const page = parseInt($(this).data('page'));
            if (!page || page < 1 || page > pagination.last_page) return;
            onPage(page);
            $('html, body').animate({ scrollTop: $('.ap-results').offset().top - 100 }, 200);
        });
    }

    // ---------- AJAX LOADER ----------
    function loadData(mode, page) {
        if (mode === 'append-course' || mode === 'replace-course-only') {
            coursePage = page;
        } else if (mode === 'append-uni' || mode === 'replace-uni-only') {
            uniPage = page;
        } else {
            coursePage = 1;
            uniPage = 1;
        }

        const thisRequestVersion = ++requestVersion;
        if (activeRequest) activeRequest.abort();

        activeRequest = $.ajax({
            url: `?course_page=${coursePage}&uni_page=${uniPage}&${getParams()}`,
            type: 'GET',
            beforeSend: () => {
                if (mode === 'replace') {
                    $('.course_data').html(renderSkeletons(4));
                    $('#university').html(renderSkeletons(4));
                    $('#ap-course-empty, #ap-uni-empty').hide();
                }
            },
            success: function (res) {
                if (thisRequestVersion !== requestVersion) return;

                lastUniPagination = res.data;
                lastCoursePagination = res.course_data;
                uniPage = res.data.current_page;
                coursePage = res.course_data.current_page;

                if (mode === 'append-course') {
                    $('.course_data').append(res.course_data.data.map(renderCourse).join(''));
                } else {
                    $('.course_data').html(res.course_data.data.map(renderCourse).join(''));
                }
                if (mode === 'append-uni') {
                    $('#university').append(res.data.data.map(renderUniversity).join(''));
                } else if (mode !== 'append-course') {
                    $('#university').html(res.data.data.map(renderUniversity).join(''));
                }

                currentPageProgramIds = res.course_data.data.map(program => String(program.id));
                syncShortlistControls();

                $('.course_count').text(res.course_data.total.toLocaleString('en-US'));
                $('.university_count').text(res.data.total.toLocaleString('en-US'));

                if (isInitialUnfilteredLoad && mode === 'replace') {
                    $('#ap-subtitle').text(`${res.course_data.total.toLocaleString('en-US')} courses across ${res.data.total.toLocaleString('en-US')} universities`);
                }

                $('#ap-course-empty').toggle(res.course_data.data.length === 0);
                $('#ap-uni-empty').toggle(res.data.data.length === 0);

                const activeTab = $('#nav-contact-tab').hasClass('active') ? 'course' : 'uni';
                if (activeTab === 'course') {
                    $('#ap-showing-text').text(`Showing ${res.course_data.data.length ? ((res.course_data.current_page - 1) * res.course_data.per_page + 1) : 0}–${Math.min(res.course_data.current_page * res.course_data.per_page, res.course_data.total)} of ${res.course_data.total.toLocaleString('en-US')} courses`);
                } else {
                    $('#ap-showing-text').text(`Showing ${res.data.data.length ? ((res.data.current_page - 1) * res.data.per_page + 1) : 0}–${Math.min(res.data.current_page * res.data.per_page, res.data.total)} of ${res.data.total.toLocaleString('en-US')} universities`);
                }

                renderPagination('#ap-course-pagination', res.course_data, p => loadData('replace-course-only', p));
                renderPagination('#ap-uni-pagination', res.data, p => loadData('replace-uni-only', p));

                $('#ap-course-load-more').toggle(!!(res.course_data.current_page < res.course_data.last_page) && activeTab === 'course');
                $('#ap-uni-load-more').toggle(!!(res.data.current_page < res.data.last_page) && activeTab === 'uni');

                applyProgramDirectorySort();
                updateSidebarApplyLabel();
            }
        });
    }

    function applyProgramDirectorySort() {
        const sortBy = $('#program-directory-sort').val() || 'name';
        const container = $('.course_data');
        const cards = Array.from(container.children('.program-listing-row'));
        cards.sort((left, right) => {
            if (sortBy === 'tuition') {
                return Number(left.dataset.tuition || 0) - Number(right.dataset.tuition || 0);
            }
            const field = sortBy === 'university' ? 'university' : 'name';
            return (left.dataset[field] || '').localeCompare(right.dataset[field] || '');
        });
        cards.forEach(card => container.append(card));
    }

    // ---------- TAB SWITCHING ----------
    window.showContactTab = function () {
        $('#nav-contact-tab').addClass('active').attr('aria-selected', 'true');
        $('#nav-profile-tab').removeClass('active').attr('aria-selected', 'false');
        $('#nav-contact').show();
        $('#nav-profile').hide();
        if (lastCoursePagination) {
            $('#ap-showing-text').text(`Showing ${lastCoursePagination.data.length ? ((lastCoursePagination.current_page - 1) * lastCoursePagination.per_page + 1) : 0}–${Math.min(lastCoursePagination.current_page * lastCoursePagination.per_page, lastCoursePagination.total)} of ${lastCoursePagination.total.toLocaleString('en-US')} courses`);
        }
        $('#ap-course-load-more').toggle(!!(lastCoursePagination && lastCoursePagination.current_page < lastCoursePagination.last_page));
        $('#ap-uni-load-more').hide();
    };

    window.showProfileTab = function () {
        $('#nav-profile-tab').addClass('active').attr('aria-selected', 'true');
        $('#nav-contact-tab').removeClass('active').attr('aria-selected', 'false');
        $('#nav-profile').show();
        $('#nav-contact').hide();
        if (lastUniPagination) {
            $('#ap-showing-text').text(`Showing ${lastUniPagination.data.length ? ((lastUniPagination.current_page - 1) * lastUniPagination.per_page + 1) : 0}–${Math.min(lastUniPagination.current_page * lastUniPagination.per_page, lastUniPagination.total)} of ${lastUniPagination.total.toLocaleString('en-US')} universities`);
        }
        $('#ap-uni-load-more').toggle(!!(lastUniPagination && lastUniPagination.current_page < lastUniPagination.last_page));
        $('#ap-course-load-more').hide();
    };

    $('#ap-course-load-more').on('click', function () {
        loadData('append-course', coursePage + 1);
    });
    $('#ap-uni-load-more').on('click', function () {
        loadData('append-uni', uniPage + 1);
    });

    $(document).on('click', '.shortlist-program-btn', function () {
        const programId = String($(this).data('id'));
        const pressed = $(this).attr('aria-pressed') === 'true';
        if (!pressed && selectedProgramIds.size >= 5) {
            $('#shortlist-feedback').text('A shortlist can contain a maximum of 5 programs.').addClass('text-danger');
            return;
        }
        if (!pressed) selectedProgramIds.add(programId);
        else selectedProgramIds.delete(programId);
        $(this).attr('aria-pressed', String(!pressed)).toggleClass('active', !pressed);
        syncShortlistControls();
    });
    $('#shortlist-select-page').on('click', function () {
        const select = !currentPageProgramIds.every(id => selectedProgramIds.has(String(id)));
        currentPageProgramIds.forEach(id => {
            const key = String(id);
            if (select) {
                if (!selectedProgramIds.has(key) && selectedProgramIds.size < 5) selectedProgramIds.add(key);
            } else {
                selectedProgramIds.delete(key);
            }
            $(`.shortlist-program-btn[data-id="${key}"]`).attr('aria-pressed', String(selectedProgramIds.has(key))).toggleClass('active', selectedProgramIds.has(key));
        });
        if (select && selectedProgramIds.size === 5) {
            $('#shortlist-feedback').text('A shortlist can contain a maximum of 5 programs.').addClass('text-danger');
        }
        syncShortlistControls();
    });
    $('#shortlist-clear-selection').on('click', function () {
        selectedProgramIds.clear();
        $('.shortlist-program-btn').attr('aria-pressed', 'false').removeClass('active');
        syncShortlistControls();
    });
    $('#save-program-shortlist-form').on('submit', function (event) {
        event.preventDefault();
        const submitButton = $('#program-shortlist-submit');
        const name = $('#program-shortlist-name').val().toString().trim();
        submitButton.prop('disabled', true).text('Saving...');
        $('#program-shortlist-name').removeClass('is-invalid');
        fetch('{{ route('program-shortlists.store') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ name: name, program_ids: Array.from(selectedProgramIds) })
        }).then(response => response.json().then(data => ({ response, data }))).then(({ response, data }) => {
            if (!response.ok) {
                const message = data.errors?.name?.[0] || data.errors?.program_ids?.[0] || data.message || 'The shortlist could not be saved.';
                $('#shortlist-feedback').text(message).addClass('text-danger');
                if (data.errors?.name) $('#program-shortlist-name').addClass('is-invalid');
                throw new Error(message);
            }
            window.location.href = data.url;
        }).catch(() => {
            submitButton.prop('disabled', false).text('Save Shortlist');
        });
    });

    // ---------- FILTER FUNCTIONS ----------
    window.fetchProgramSubLevel = function () {
        const selected = $("input[name='program_level[]']:checked").map(function () {
            return this.value;
        }).get();

        csrf();
        $.post("{{ route('get-program-sublevel') }}", { program_level_id: selected }, function (data) {
            const selectedIds = @json($program_sub_level_name).map(item => item.id);
            const list = data.length
                ? data.map((lvl, i) => `
                    <li>
                        <label>
                            <input type="checkbox" class="program-sub-level-check" name="program_sub_level[]" value="${lvl.id}" ${selectedIds.includes(lvl.id) ? 'checked' : ''}>
                            ${lvl.name.toUpperCase()}
                        </label>
                    </li>`).join('')
                : '<li><h4>Not Found</h4></li>';
            $('.program-sub-level').html(list);
        });
    };

    window.checkAndCall = function () {
        fetchProgramSubLevel();
    };
    checkAndCall();

    // ---------- EDUCATION LEVEL (legacy, no UI control currently) ----------
    $('#education_level').on('click', function () {
        const programLevels = $("input[name='program_level[]']:checked").map(function () { return this.value; }).get();
        const subLevels = $("input[name='program_sub_level[]']:checked").map(function () { return this.value; }).get();

        csrf();
        $.post("{{ route('get-education-level-filter') }}", { program_level_id: programLevels, program_sublevel_id: subLevels }, function (data) {
            const selectedIds = @json($education_level_name).map(item => item.id);
            const list = data.length
                ? data.map(lvl => `
                    <li>
                        <label>
                            <input type="checkbox" class="education_level_check" name="education_level[]" value="${lvl.id}" ${selectedIds.includes(lvl.id) ? 'checked' : ''}>
                            ${lvl.name.toUpperCase()}
                        </label>
                    </li>`).join('')
                : '<li><label>Not Found</label></li>';
            $('#education-level-list').html(list);
        });
    });

    // ---------- PROGRAM DISCIPLINE ----------
    function loadProgramSubdisciplineOptions() {
        const selected = $("input[name='program_discipline[]']:checked").map(function () { return this.value; }).get();

        if (selected.length === 0) {
            $('.program_subdiscipline').html('<li><label>No Program Discipline selected</label></li>');
            return;
        }

        csrf();
        $.post("{{ route('program-subdiscipline-data') }}", { program_displine: selected }, function (data) {
            const selectedIds = @json($program_sub_discipline_name).map(item => item.id);
            const list = data.length
                ? data.map(d => `
                    <li>
                        <label>
                            <input type="checkbox" class="program-sub-discipline-checkbox" name="program_sub_discipline[]" value="${d.id}" ${selectedIds.includes(d.id) ? 'checked' : ''}>
                            ${d.name.toUpperCase()}
                        </label>
                    </li>`).join('')
                : '<li><label>Not Found</label></li>';
            $('.program_subdiscipline').html(list);
        });
    }

    $(document).on('click', '.subdiscipline', function () {
        loadProgramSubdisciplineOptions();
    });

    // ---------- OTHER EXAM ----------
    $('.other_exam').on('click', other_exam);
    other_exam();

    function other_exam() {
        const selected = $("input[name='program_level[]']:checked").map(function () { return this.value; }).get();

        csrf();
        $.post("{{ route('fetch-other-exam-data') }}", { program_id: selected }, function (data) {
            const selectedIds = @json($other_exam_name).map(item => item.id);
            const list = data.map(e => `
                <li>
                    <label>
                        <input type="checkbox" class="other_exam_check" name="other_exam[]" value="${e.id}" ${selectedIds.includes(e.id) ? 'checked' : ''}>
                        ${e.name.toUpperCase()}
                    </label>
                </li>`).join('');
            $('.other_exam_show').html(list);
        });
    }

    function collectSelectedOptions(page = 1) {
        const getCheckedValues = (name) => $(`input[name='${name}[]']:checked`).map(function () {
            return $(this).val();
        }).get();

        return {
            program_level: getCheckedValues('program_level'),
            program_sub_level: getCheckedValues('program_sub_level'),
            education_level: getCheckedValues('education_level'),
            program_discipline: getCheckedValues('program_discipline'),
            program_sub_discipline: getCheckedValues('program_sub_discipline'),
            other_exam: getCheckedValues('other_exam'),
            country: getCheckedValues('country'),
            intake: getCheckedValues('intake'),
            end_profiency_level: getCheckedValues('end_profiency_level'),
            schlorship: getCheckedValues('schlorship'),
            tution_fees: getCheckedValues('tution_fees')
        };
    }

    function updateFilterCount() {
        const total = $("#ap-sidebar input[type=checkbox]:checked").length;
        $('#ap-filter-count').text(total > 0 ? `· ${total}` : '');
    }

    // Reusable function to handle checkbox filters
    function handleFilterClick(inputName, badgeContainer, urlParamName) {
        const values = $(`input[name='${inputName}[]']:checked`).map(function () {
            return this.value;
        }).get();

        const labels = $(`input[name='${inputName}[]']:checked`).map(function () {
            return $(this).closest('label').text().trim();
        }).get();

        let url = window.location.origin + window.location.pathname;
        let params = new URLSearchParams(window.location.search);
        params.delete(urlParamName);

        if (values.length > 0) {
            params.append(urlParamName, values.join(','));
            url += '?' + params.toString();
        } else if ([...params].length > 0) {
            url += '?' + params.toString();
        }

        window.history.pushState(null, '', url);

        $('#university').empty();
        $('.course_data').empty();
        loadData('replace');

        $(badgeContainer).empty();
        if (labels.length > 0) {
            labels.forEach(label => {
                $(badgeContainer).append(`<span class="badge">${label} <a href="javascript:void(0)" class="ap-chip-remove" data-input="${inputName}" data-value-label="${label}" style="color:inherit;text-decoration:none;font-weight:800;">&times;</a></span>`);
            });
        }
        updateFilterCount();
        renderMobileChipMirror();
    }

    function renderMobileChipMirror() {
        $('.ap-active-chip-row-mobile-mirror').html($('.ap-active-chip-row').html());
    }

    $(document).on('click', '.ap-chip-remove', function (e) {
        e.preventDefault();
        const inputName = $(this).data('input');
        const label = String($(this).data('value-label'));
        $(`input[name='${inputName}[]']:checked`).each(function () {
            if ($(this).closest('label').text().trim() === label) {
                $(this).prop('checked', false).trigger('change').trigger('__ap_reclick');
            }
        });
        // trigger the same click-bound handler used by the real checkbox/pill
        $(this).trigger('ap:refresh-' + inputName);
    });

    // Attach handlers for all filters
    $(document).on('click', '.country-checkbox', function () {
        handleFilterClick('country', '.country_name', 'country');
    });

    $(document).on('click', '.program_level_value', function () {
        handleFilterClick('program_level', '.program_level_name', 'program_level');
    });

    $(document).on('click', '.program-sub-level-check', function () {
        handleFilterClick('program_sub_level', '.program_sub_level_name', 'program_sub_level');
    });

    $(document).on('click', '.education_level_check', function () {
        handleFilterClick('education_level', '.education_level_name', 'education_level');
    });

    $(document).on('click', '.intake-name-data', function () {
        handleFilterClick('intake', '.intake_name', 'intake');
    });

    $(document).on('click', '.program_discipline_checkbox', function () {
        handleFilterClick('program_discipline', '.program_discipline_name', 'program_discipline');
        loadProgramSubdisciplineOptions();
    });

    $(document).on('click', '.program-sub-discipline-checkbox', function () {
        handleFilterClick('program_sub_discipline', '.program_sub_discipline_name', 'program_sub_discipline');
    });

    $(document).on('click', '.eng-pro', function () {
        handleFilterClick('end_profiency_level', '.eng_proficiency_level_name', 'eng_proficiency_level');
    });

    $(document).on('click', '.other_exam_check', function () {
        handleFilterClick('other_exam', '.other_exam_name', 'other_exam');
    });

    // re-click proxies so the × chip-remove can reuse the exact same handlers above
    $(document).on('ap:refresh-country', () => handleFilterClick('country', '.country_name', 'country'));
    $(document).on('ap:refresh-program_level', () => handleFilterClick('program_level', '.program_level_name', 'program_level'));
    $(document).on('ap:refresh-program_sub_level', () => handleFilterClick('program_sub_level', '.program_sub_level_name', 'program_sub_level'));
    $(document).on('ap:refresh-education_level', () => handleFilterClick('education_level', '.education_level_name', 'education_level'));
    $(document).on('ap:refresh-intake', () => handleFilterClick('intake', '.intake_name', 'intake'));
    $(document).on('ap:refresh-program_discipline', () => handleFilterClick('program_discipline', '.program_discipline_name', 'program_discipline'));
    $(document).on('ap:refresh-program_sub_discipline', () => handleFilterClick('program_sub_discipline', '.program_sub_discipline_name', 'program_sub_discipline'));
    $(document).on('ap:refresh-end_profiency_level', () => handleFilterClick('end_profiency_level', '.eng_proficiency_level_name', 'eng_proficiency_level'));
    $(document).on('ap:refresh-other_exam', () => handleFilterClick('other_exam', '.other_exam_name', 'other_exam'));

    // ---------- TOP SEARCH BAR (program_search) ----------
    let programSearchTimer;
    $('#program-directory-search').on('input', function () {
        window.clearTimeout(programSearchTimer);
        const searchTerm = this.value.trim();
        programSearchTimer = window.setTimeout(function () {
            reloadProgramDirectoryParameter('program_search', searchTerm);
        }, 300);
    });
    $('#ap-search-form').on('submit', function (e) {
        e.preventDefault();
        reloadProgramDirectoryParameter('program_search', $('#program-directory-search').val().trim());
    });
    $('#program-directory-sort').on('change', function () {
        reloadProgramDirectoryParameter('program_sort', this.value);
    });

    // ---------- POPULAR PRESET CHIPS ----------
    $('.ap-chip[data-preset-country]').on('click', function () {
        const value = $(this).data('preset-country');
        $('.country-checkbox').prop('checked', false);
        $(`.country-checkbox[value="${value}"]`).prop('checked', true);
        handleFilterClick('country', '.country_name', 'country');
    });

    // ---------- CLEAR ALL ----------
    $('#ap-clear-all').on('click', function () {
        $('#ap-sidebar input[type=checkbox]').prop('checked', false);
        window.history.pushState(null, '', window.location.pathname);
        coursePage = 1;
        uniPage = 1;
        $('#university').empty();
        $('.course_data').empty();
        $('.ap-active-chip-row > div').empty();
        loadData('replace');
        updateFilterCount();
        renderMobileChipMirror();
    });

    // ---------- COUNTRY SHOW MORE ----------
    $('#ap-country-show-more').on('click', function () {
        $('#ap-country-list').css('max-height', 'none');
        $(this).hide();
    });

    // ---------- MORE FILTERS TOGGLE ----------
    $('#ap-more-toggle').on('click', function () {
        const open = $('#ap-more-filters').toggleClass('open').hasClass('open');
        $(this).attr('aria-expanded', String(open)).text(open ? 'Fewer filters' : 'More filters');
    });

    // ---------- MOBILE FILTER SHEET ----------
    function openFilterSheet() {
        $('#ap-sidebar').addClass('open');
        $('#ap-sidebar-backdrop').addClass('open');
        $('body').css('overflow', 'hidden');
        $('#ap-sidebar').attr('tabindex', '-1').trigger('focus');
    }
    function closeFilterSheet() {
        $('#ap-sidebar').removeClass('open');
        $('#ap-sidebar-backdrop').removeClass('open');
        $('body').css('overflow', '');
    }
    $('#ap-open-filters').on('click', openFilterSheet);
    $('#ap-close-filters, #ap-sidebar-backdrop, #ap-sidebar-apply').on('click', closeFilterSheet);
    $(document).on('keydown', function (e) {
        if (e.key === 'Escape' && $('#ap-sidebar').hasClass('open')) closeFilterSheet();
    });
    function updateSidebarApplyLabel() {
        if (lastCoursePagination) {
            $('#ap-sidebar-apply').text(`Show ${lastCoursePagination.total.toLocaleString('en-US')} courses`);
        }
    }

    loadProgramSubdisciplineOptions();
    renderMobileChipMirror();
    updateFilterCount();
    loadData('replace');
        });
</script>
@endsection
