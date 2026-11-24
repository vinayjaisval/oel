@extends('frontend.layouts.main')
@section('title', 'Check Eligibility')
@section('content')
<link rel="stylesheet" href="{{ asset('assets/eligibility/wizard.css') }}">
<main class="eligibility" id="eligibility-wizard">
    <div class="elig-head"><h1>Check my eligibility</h1><span id="elig-meta"></span></div>
    <div class="elig-bar" aria-hidden="true"><i id="elig-progress"></i></div>
    <ol class="elig-steps" id="elig-steps" aria-label="Steps"></ol>
    <div class="elig-grid"><section class="elig-card elig-question" id="elig-question" aria-live="polite"></section><aside class="elig-side"><div class="elig-card elig-answers" id="elig-answers"></div><div class="elig-help"><strong>Need help?</strong> A counsellor can check your eligibility for free. <a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal">Talk to a counsellor</a></div></aside></div>
</main>
<script>
@php
$wizardConfig = ['levels' => $program_level, 'disciplines' => $program_discipline, 'english' => $eng_proficiency_level, 'countries' => $country, 'urls' => ['sublevels' => route('get-program-sublevel'), 'education' => route('get-education-level-data'), 'subdisciplines' => route('program-subdiscipline-data'), 'exams' => route('fetch-other-exam-data'), 'results' => url('apply-program')], 'csrf' => csrf_token()];
@endphp
window.eligibilityConfig = @json($wizardConfig);
</script>
<script defer src="{{ asset('assets/eligibility/wizard.js') }}"></script>
@endsection
