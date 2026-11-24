@extends('admin.include.app')
@section('style')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
<link href="{{ asset('assets/css/program-redesign.css') }}" rel="stylesheet">
@endsection
@section('main-content')
@php $isEdit = false; $university = null; @endphp
<div class="pr-page" id="wizard-app" data-is-edit="0" data-university-id="">

    <div class="pr-header">
        <div>
            <h1 class="pr-title">Add University</h1>
            <ol class="pr-breadcrumb" style="list-style:none;display:flex;gap:0.35rem;padding:0;margin:0.2rem 0 0;">
                <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li>/</li>
                <li><a href="{{ route('universities.index') }}">Universities</a></li>
                <li>/</li>
                <li>Add</li>
            </ol>
        </div>
        <a href="{{ route('universities.index') }}" class="pr-btn pr-btn-outline" id="wizard-back-to-list">&larr; Back to list</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="pr-card">
        @include('admin.university.wizard._stepper')

        <div class="tab-content" id="wizardTabContent" style="padding:1.5rem;">
            @include('admin.university.wizard._step1-location')
            @include('admin.university.wizard._step2-basic-info')
            @include('admin.university.wizard._step3-ranking')
            @include('admin.university.wizard._step4-accreditation')
            @include('admin.university.wizard._step5-documents')
        </div>
    </div>

    <div class="pr-sticky-bar" style="justify-content:space-between;">
        <span class="pr-draft-note" id="wizard-autosave-note"></span>
        <div style="display:flex;gap:0.75rem;">
            <button type="button" class="pr-btn pr-btn-outline" id="wizard-back-btn" style="display:none;">&larr; Back</button>
            <button type="button" class="pr-btn pr-btn-outline" id="wizard-save-draft-btn"><i class="la la-save"></i> Save draft</button>
            <button type="button" class="pr-btn pr-btn-primary" id="wizard-next-btn">Next &rarr;</button>
            <button type="button" class="pr-btn pr-btn-success" id="wizard-submit-btn" style="display:none;">&#10003; Submit</button>
        </div>
    </div>

    {{-- Confirm-delete modal (ranking/accreditation entries) --}}
    <div class="offcanvas offcanvas-end border-0" tabindex="-1" id="wizard-confirm-offcanvas" style="width:360px;">
        <div class="offcanvas-body" style="display:flex;flex-direction:column;justify-content:center;align-items:center;text-align:center;gap:1rem;">
            <i class="la la-exclamation-triangle" style="font-size:2.5rem;color:var(--pr-red);"></i>
            <p id="wizard-confirm-text">Delete this entry?</p>
            <div style="display:flex;gap:0.75rem;">
                <button type="button" class="pr-btn pr-btn-outline" data-bs-dismiss="offcanvas">Cancel</button>
                <button type="button" class="pr-btn pr-btn-danger-outline" id="wizard-confirm-delete-btn">Delete</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="{{ asset('assets/js/jquery-3.7.1.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.2/dist/sweetalert2.all.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js" defer></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js" defer></script>
<script src="{{ asset('assets/js/university-wizard.js') }}" defer></script>
<script>
    window.UNIVERSITY_WIZARD = {
        isEdit: false,
        universityId: null,
        storeUrl: "{{ route('store-university') }}",
        statesUrl: "{{ route('states.get') }}",
        rankingAddUrl: "{{ route('add-university-rank') }}",
        rankingListUrl: "{{ route('all-uni-ranking') }}",
        rankingUpdateUrl: "{{ route('universities.ranking.update', ['id' => '__ID__']) }}",
        rankingDeleteUrl: "{{ route('universities.ranking.delete', ['id' => '__ID__']) }}",
        accreditationAddUrl: "{{ route('add-uni-accerediation') }}",
        accreditationListUrl: "{{ route('all-uni-accerediation') }}",
        accreditationUpdateUrl: "{{ route('universities.accreditation.update', ['id' => '__ID__']) }}",
        accreditationDeleteUrl: "{{ route('universities.accreditation.delete', ['id' => '__ID__']) }}",
        documentsUploadUrl: "{{ route('add-uni-documents') }}",
        documentsListUrl: "{{ route('university-document') }}",
        galleryDeleteUrl: "{{ route('university-gallery-delete') }}",
        submitWizardUrl: "{{ route('universities.submit-wizard') }}",
        universitiesIndexUrl: "{{ route('universities.index') }}",
        csrfToken: "{{ csrf_token() }}",
        assetBase: "{{ asset('') }}",
    };
</script>
@endsection
