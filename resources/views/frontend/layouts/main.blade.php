<!DOCTYPE html>
<html lang="en">

<head>
  
   <title>@yield('title')</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="google-site-verification" content="Oe5_d5HHQe8RRzzpFWOXFaG4Z2zARTYHtgRyID8X1_c" />
    <meta name="keywords" content="Study Abroad Consultant">
   <meta name="meta_title" content="@yield('meta_title','Overseas Education Lane')">
    <meta name="meta_keywords" content="@yield('meta_keywords','Overseas Education Lane')">

    <meta name="meta_description" content="@yield('meta_description','Overseas Education Lane')">

    <meta name="description" content="Overseas Education Lane can help you learn about your options for international education. Our knowledgeable consultants provide individualized assistance to enhance your abroad education experience.">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta property="og:title" content="Study Abroad Consultant - Overseas Education Lane">
    <meta property="og:site_name" content="Overseas Education Lane">
    <meta property="og:url" content="https://www.overseaseducationlane.com/">
    <meta property="og:description" content="Unlock your international education potential with Overseas Education Lane. Our dedicated consultants provide personalized support for your study abroad experience">
    <meta property="og:type" content="website">
    <meta property="og:image" content="https://www.overseaseducationlane.com/public/frontend/img/oel%20(1)%201.png">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="@Overseas Education Lane">
    <meta name="twitter:description" content="Unlock your international education potential with Overseas Education Lane. Our dedicated consultants provide personalized support for your study abroad experience.">
    <link rel="stylesheet" href="{{asset('frontend/css/style.css')}}">
    <link id="favicon" rel="shortcut icon" type="image/png" href="https://www.overseaseducationlane.com/public/frontend/img/oel (1) 1.png" />
    <link rel="canonical" href="https://www.overseaseducationlane.com/" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.5.0/remixicon.min.css" integrity="sha512-/VYneElp5u4puMaIp/4ibGxlTd2MV3kuUIroR3NSQjS2h9XKQNebRQiyyoQKeiGE9mRdjSCIZf9pb7AVJ8DhCg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" integrity="sha512-1cK78a1o+ht2JcaW6g8OXYwqpev9+6GqOkz9xmBN9iUUhIndKtxwILGWYOSibOKjLsEdjyjZvYDq/cZwNeak0w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{asset('frontend/css/costoms.css')}}">
 <!-- Swiper CSS -->
 <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
 <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800&family=Inter:wght@400;600;700;800&family=Open+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">

    <!-- Intl-Tel-Input -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@23.0.10/build/css/intlTelInput.css">
    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@23.0.10/build/js/intlTelInput.min.js"></script>

    <script async src="https://www.googletagmanager.com/gtag/js?id=G-T9PKC9W1V2"></script>
    
    <!-- End Google Tag Manager -->

    <script type="application/ld+json">
    {
    "@context":"https://schema.org",
    "@type":"Organization",
    "name":"Overseas Education Lane",
    "url":"https://www.overseaseducationlane.com/"
    }
    </script>
    <style>
        /* --- PROPER HEADER ADJUSTMENTS --- */
        .header .container { 
            max-width: 1500px !important; 
            width: 100% !important;
            padding: 0 20px !important;
        }
        .header nav {
            display: flex !important;
            justify-content: space-between !important;
            align-items: center !important;
            width: 100% !important;
        }
        .nav_links { 
            gap: 15px !important; 
            align-items: center; 
            margin-bottom: 0; 
            padding-left: 0;
            list-style: none;
        }
        .nav_links li a { 
            font-size: 13px !important; 
            font-weight: 600;
            color: #333;
            padding: 5px 2px !important; 
            text-decoration: none !important;
            white-space: nowrap;
        }
        .nav_links li a:hover { color: #FF6600; }
        
        .apply-btn { 
            font-size: 11px !important; 
            font-weight: 700 !important;
            padding: 8px 12px !important; 
            white-space: nowrap; 
            border-radius: 5px !important;
            height: 36px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        
        .counseling-btn-header {
            background: orange !important;
            color: #fff !important;
            border: none !important;
            transition: none !important;
        }
        .counseling-btn-header:hover {
            background: orange !important;
            color: #fff !important;
        }
        
        /* Global Scrollbar Hiding */
        .modal, .modal-dialog, .modal-content, .modal-body {
            scrollbar-width: none !important;
            -ms-overflow-style: none !important;
        }
        .modal::-webkit-scrollbar, 
        .modal-dialog::-webkit-scrollbar, 
        .modal-content::-webkit-scrollbar, 
        .modal-body::-webkit-scrollbar {
            display: none !important;
            width: 0 !important;
            height: 0 !important;
        }
        
        .modal-body { 
            padding: 0; 
            max-height: 75vh; 
            overflow-y: auto; 
        }

        /* Core Styles */
        /* Reference Utilities */
        .c { font-family: 'BuenosAires', 'Montserrat', sans-serif !important; }
        .l { color: rgba(211, 41, 46, 1) !important; }
        .YC { font-size: 24px !important; }
        
        h1, h2, h3 { font-family: "Open Sans", "Montserrat", sans-serif; }

        .wizard-modal {
            display: none;
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: #edf3ff !important; /* PROFESSIONAL LIGHT BLUE */
            z-index: 10000;
            overflow-y: auto;
            overflow-x: hidden;
            font-family: 'Montserrat', 'Inter', sans-serif;
        }

        .wizard-overlay-bg {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: transparent;
            z-index: -1;
        }

        .wizard-wave-bg {
            position: absolute;
            top: 250px; left: 0; width: 100%; height: 1010px;
            background: #d4e3ff;
            z-index: -1;
            overflow: visible;
        }
        
        .wiz-wave-svg {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            line-height: 0;
        }
        .wiz-wave-svg-top {
            position: absolute;
            top: -120px;
            left: 0;
            width: 100%;
            line-height: 0;
        }
        .wiz-wave-svg svg, .wiz-wave-svg-top svg {
            position: relative;
            display: block;
            width: calc(100% + 1.3px);
            height: 120px;
        }

        .wizard-container {
            width: 100%;
            max-width: 1300px;
            margin: 0;
            min-height: 100vh;
            padding: 0;
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .wiz-logo-top { 
            text-align: center; 
            padding-top: 20px !important;
            padding-bottom: 40px !important;
            width: 100%;
        }
        .wiz-logo-top img { height: 80px !important; width: auto !important; }

        .dest-title-main { 
            text-align: center !important; 
            margin-bottom: 80px !important;
            max-width: 1200px !important; 
            margin-left: auto !important; 
            margin-right: auto !important; 
        }
        .dest-title-blue { 
            color: #1e3a8a !important; 
            font-size: 26px !important; 
            font-weight: 800 !important; 
            margin-bottom: 40px !important;
            line-height: 1.4 !important; 
            letter-spacing: -0.5px !important;
            font-family: 'Inter', 'Montserrat', sans-serif !important;
        }
        .dest-title-red { 
            font-weight: 700 !important; 
            text-transform: capitalize !important;
        }

        .dest-grid-exact {
            display: grid !important;
            grid-template-columns: repeat(4, 1fr) !important;
            gap: 40px 30px !important;
            width: 100% !important;
            max-width: 1300px !important;
            margin: 0 auto !important;
        }
        .dest-card-exact {
            background: #f8fafc !important; 
            border: 2px solid #000000 !important; 
            border-radius: 10px !important; 
            height: 96px !important; 
            padding: 0 25px !important;
            display: flex !important;
            align-items: center !important;
            gap: 15px !important;
            cursor: pointer !important;
            transition: all 0.3s ease !important;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1) !important;
        }
        .dest-card-exact:hover {
            background: #dbeafe !important; 
            transform: translateY(-5px) !important;
        }
        .dest-flag-img { width: 50px !important; height: 35px !important; border-radius: 4px !important; object-fit: cover !important; }
        .dest-name-exact { 
            font-weight: 700 !important; 
            color: #1e3a8a !important; 
            font-size: 16px !important; 
        }
        
        .test-prep-title-main { 
            margin-top: 80px !important;
            text-align: center !important; 
            width: 100%;
        }
        .test-prep-grid-proper {
            display: grid !important;
            grid-template-columns: repeat(4, 1fr) !important;
            gap: 30px !important;
            width: 100% !important;
            max-width: 1300px !important;
            margin: 40px auto 0 !important;
        }
        /* Test Prep Labels */
        .test-prep-label {
            font-weight: 600 !important; 
            color: #000000 !important; 
            font-size: 16px !important; 
            transition: all 0.2s !important;
        }
        .test-prep-emoji {
            font-size: 24px !important;
            margin-right: 15px !important;
        }

        /* Layout: Split View (Steps 2 & 3) */
        .wiz-split-container {
            display: flex;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            min-height: auto;
            width: 100%;
            max-width: 1000px;
            margin: 40px auto 20px;
        }
        .wiz-side-info {
            width: 330px;
            background: #f9fafb;
            border-right: 1px solid #f1f5f9;
            padding: 40px;
        }
        #wiz-p3 .wiz-split-container {
            max-width: 1000px !important;
            background: #fff !important;
            border-radius: 16px !important;
            overflow: visible !important;
        }
        #wiz-p3 .wiz-side-info {
            width: 375px !important;
            flex: none !important;
            background: #fff !important;
            padding: 40px !important;
            border-right: 1px solid rgba(30,41,59,0.1) !important;
        }
        #wiz-p3 .wiz-main-action {
            width: 625px !important;
            flex: none !important;
            background: #fff !important;
            padding: 40px 40px 20px !important;
            min-height: auto;
        }
        .wiz-main-action {
            flex: 1;
            padding: 50px;
            position: relative;
        }

        .wiz-back-btn {
            width: 40px; height: 40px;
            border-radius: 50%;
            border: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            margin-bottom: 40px;
            color: #64748b;
        }

        .wiz-side-logo { margin-bottom: 35px; font-weight: 700; color: #64748b; font-size: 14px; }
        .wiz-side-country { font-size: 32px; font-weight: 800; color: #1e293b; margin-bottom: 30px; }
        .wiz-side-meta { display: flex; flex-direction: column; gap: 20px; color: #64748b; font-size: 16px; }

        .wiz-main-title { font-size: 26px; font-weight: 800; color: #1e293b; margin-bottom: 40px; display: flex; align-items: center; gap: 20px; }
        .wiz-counselor-avatar { width: 50px; height: 50px; border-radius: 50%; object-fit: cover; }

        /* Component: Calendar */
        .cal-week-row { display: flex; justify-content: space-between; margin-bottom: 30px; width: 100%; overflow-x: auto; gap: 5px; padding-bottom: 10px; }
        .cal-day-col { 
            text-align: center; cursor: pointer; flex: 1; padding: 4px; border-radius: 16px; 
            border: 1px solid transparent; background: transparent; transition: 0.2s; 
            min-width: 50px;
        }
        .cal-day-col:hover:not(.active) { background: #f9fafb; }
        .cal-day-name { font-size: 16px; font-weight: 400; color: #64748b; margin-bottom: 4px; text-transform: capitalize; }
        .cal-day-num { 
            font-size: 16px; font-weight: 600; color: #1e293b; 
            width: 40px; height: 32px; display: flex; align-items: center; justify-content: center; margin: 0 auto;
            position: relative; border-radius: 50%;
        }
        
        .cal-day-col.active { 
            background: linear-gradient(rgba(34, 108, 245, 0.75), rgb(34, 108, 245)); 
            box-shadow: rgba(0, 0, 0, 0.25) 4px 4px 10px; 
        }
        .cal-day-col.active .cal-day-name { color: #ffffff; }
        .cal-day-col.active .cal-day-num { color: #ffffff; }
        .cal-day-col.active .cal-day-dot {
            width: 4px; height: 4px; background: #ffffff; border-radius: 50%;
            position: absolute; bottom: 0; left: 50%; transform: translateX(-50%);
        }

        .time-slots-grid { display: grid; grid-template-columns: repeat(3, minmax(90px, 1fr)); grid-auto-rows: 40px; gap: 12px; margin-bottom: 20px; }
        .time-slot {
            display: flex; align-items: center; justify-content: center;
            border: 1px solid #226cf5;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 700;
            color: #226cf5;
            background: transparent;
            cursor: pointer;
            transition: 0.2s;
        }
        .time-slot:hover { border-width: 2px; }
        .time-slot.active { 
            background: linear-gradient(97deg, rgba(34, 108, 245, 0.75), rgb(34, 108, 245)); 
            box-shadow: rgba(0, 0, 0, 0.25) 4px 4px 10px;
            color: #ffffff; 
            border-color: #226cf5; 
        }

        .wiz-confirm-btn {
            width: 250px;
            margin: 0 auto;
            display: flex;
            align-items: center; justify-content: center;
            padding: 14px;
            background: #226cf5;
            color: #ffffff;
            border: none;
            border-radius: 16px; /* rounded-2xl */
            font-weight: 700;
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s;
        }
        .wiz-confirm-btn:disabled { opacity: 0.6; cursor: not-allowed; }

        /* Form Styles */
        .wiz-form-group { margin-bottom: 20px; }
        .wiz-form-label { display: block; font-weight: 700; color: #1c1d21; margin-bottom: 8px; font-size: 14px; }
        .wiz-input-wrapper { position: relative; width: 100%; }
        .wiz-input-wrapper i {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #8f8f8f;
            font-size: 16px;
        }
        .wiz-input {
            width: 60%;
            padding: 10px 14px 10px 40px;
            background: #ffffff;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-weight: 500;
            font-size: 15px;
            color: #1c1d21;
            transition: all 0.2s;
            outline: none;
        }
        .wiz-input:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.1);
        }
        /* Intl-tel-input overrides to match 60% width */
        .iti { width: 60%; display: block; margin-left: 0; }
        .iti__country-list { z-index: 9999 !important; width: 300px !important; }
        .wiz-phone-input { padding-left: 52px !important; width: 100% !important; }

        .wiz-page { display: none; width: 100%;  height: auto; min-height: auto; padding: 10px 0; }
        .wiz-page.active { display: block;}

        @media (max-width: 992px) {
            .dest-grid-exact { grid-template-columns: repeat(2, 1fr); }
            .wiz-split-container { flex-direction: column; }
            .wiz-side-info { width: 100%; }
        }

        /* Custom Timezone Dropdown - Professional Match */
        .wiz-timezone-container {
            position: relative;
            width: 100%;
            margin-bottom: 24px;
        }
        .wiz-timezone-trigger {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 15px;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            cursor: pointer;
            background: #fff;
            transition: all 0.2s;
            font-size: 14px;
            font-weight: 600;
            color: #1e293b;
        }
        .wiz-timezone-trigger:hover {
            border-color: #226cf5;
            background: #f8fafc;
        }
        .wiz-timezone-trigger i.fa-globe {
            color: #1e293b;
            font-size: 16px;
        }
        .wiz-timezone-trigger i.fa-chevron-down {
            margin-left: auto;
            font-size: 12px;
            color: #64748b;
            transition: transform 0.2s;
        }
        .wiz-timezone-container.open .wiz-timezone-trigger i.fa-chevron-down {
            transform: rotate(180deg);
        }
        .wiz-timezone-menu {
            position: relative; /* Changed to relative to push content down as requested */
            width: 100%;
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
            z-index: 10;
            display: none;
            max-height: 250px;
            overflow: hidden;
            flex-direction: column;
            margin-top: 8px; /* Space between trigger and menu */
            animation: wizSlideDown 0.2s ease-out;
        }
        @keyframes wizSlideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .wiz-timezone-container.open .wiz-timezone-menu {
            display: flex;
        }
        .wiz-timezone-search {
            padding: 10px;
            border-bottom: 1px solid #f1f5f9;
            background: #fff;
            position: sticky;
            top: 0;
        }
        .wiz-timezone-search input {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            font-size: 13px;
            outline: none;
        }
        .wiz-timezone-search input:focus {
            border-color: #226cf5;
        }
        .wiz-timezone-options {
            overflow-y: auto;
            flex: 1;
            padding: 5px 0;
        }
        .wiz-timezone-option {
            padding: 10px 15px;
            font-size: 13px;
            cursor: pointer;
            transition: background 0.2s;
            color: #334155;
        }
        .wiz-timezone-option:hover {
            background: #f1f5f9;
            color: #226cf5;
        }
        .wiz-timezone-option.selected {
            background: #eff6ff;
            color: #226cf5;
            font-weight: 700;
        }

        /* Participant Section - Match Reference Simple Style */
        .wiz-participant-section {
            margin-top: 15px;
            width: 100%;
        }
        #wiz-add-guest-btn {
            display: flex !important;
            align-items: center !important;
            gap: 8px !important;
            background: transparent !important;
            border: none !important;
            color: #000 !important;
            font-weight: 700 !important;
            font-size: 14px !important;
            cursor: pointer !important;
            padding: 5px 0 !important;
            box-shadow: none !important;
            outline: none !important;
            text-decoration: none !important;
            transition: none !important;
            -webkit-tap-highlight-color: transparent !important;
        }
        #wiz-add-guest-btn i {
            color: #000 !important;
            font-size: 16px !important;
            box-shadow: none !important;
            text-shadow: none !important;
        }
        #wiz-add-guest-btn:hover, #wiz-add-guest-btn:focus, #wiz-add-guest-btn:active {
            opacity: 0.8 !important;
            color: #000 !important;
            box-shadow: none !important;
            outline: none !important;
        }
        .wiz-participant-container {
            background: transparent !important;
            padding: 10px 0;
            margin-top: 5px;
            display: none;
        }
        .wiz-participant-input {
            width: 100%;
            height: 40px;
            border: 1px solid #000 !important;
            border-radius: 4px;
            padding: 0 12px;
            font-size: 14px;
            background: #fff !important;
            outline: 0 !important;
            box-shadow: none !important;
            -webkit-appearance: none;
        }
        .wiz-participant-input:focus, .wiz-participant-input:hover, .wiz-participant-input:active {
            border-color: #000 !important;
            box-shadow: none !important;
            outline: 0 !important;
        }
    </style>
</head>

<body>
  
    <div class="oel_main_title">
        <div class="oel_title">
            <div class="container">
                <div class="social_icon d-flex justify-content-between align-items-center w-100 ">
                    <div class="social_icon_inner text-white d-flex align-items-center">
                    </div>
                    <div class="english_title text-white d-flex">
                        <div class="sep mx-4"></div>
                        <div class="icon_second">
                            <a href="tel:8929922525"><i class="fa-solid fa-phone"></i><span style="color:white">(+91 8929922525)</span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <section class="nav-sec-title">
        <div class="main-oel header shadow-sm" id="myHeader">
            <div class="container ">
                <nav>
                    <div class="oel-logo pt-2">
                        <a href="{{url('/')}}"><img src="{{ asset('frontend/img/oel (1) 1.png') }}"></a>
                    </div>
                    <ul class="nav_links d-flex" id="nav_links">
                <li><a href="{{ route('index') }}">Home</a></li>
                <li><a href="{{ route('about-oel') }}">About OEL</a></li>
                <li><a href="{{ route('programs') }}">Programs</a></li>
                <li><a href="{{ route('program-offered') }}">Courses Offered</a></li>
                <li><a href="{{ route('contact_us') }}">Contact Us</a></li>
                <li><a class="apply-btn rounded fn border-0 p-2" href="{{ route('check-eligible') }}"> Quick Search</a></li>
                <li><a class="apply-btn rounded fn border-0 p-2" data-bs-toggle="modal" data-bs-target="#exampleModal"> Check My Eligibility</a>
                </li>
                <li>
                    @if(Auth::check())
                        <a href="{{ route('dashboard') }}">
                            <img src="{{ Auth::user()->profile_image ? asset('storage/' . Auth::user()->profile_image) : asset('frontend/images/user.png') }}" 
                                alt="User" 
                                class="rounded-circle" 
                                style="width:40px; height:40px; object-fit:cover;" >
                        </a>
                    @else
                        <a href="{{ route('user-login') }}">
                            <button class="rounded apply-btn fn border-0 p-2">Login</button>
                        </a>
                    @endif
                </li>
                <li>
                    <button type="button"
                    onclick="openWizard()"
                    class="apply-btn rounded fn border-0 text-decoration-none counseling-btn-header"
                    style="cursor:pointer;">
                    Book Online Counselling
                    </button>
                </li>

            </ul>
                    <div class="nav_menu_btn" id="menu_btn">
                        <span><i class="ri-menu-line" onclick="toggleMenu()"></i></span>
                    </div>
                </nav>
            </div>
        </div>
    </section>
    @yield('content')
  
    <section>
        <div class="bottom_footer bv_cs">
            <div class="fw_footer container text-white">
                <div class="row  ratio-text-row">
                    <div class="col-lg-2">
                        <div class="bottom_heading_fooet">
                            <h5 class="text-uppercase fw-bold">Other Links</h5>
                            <ul class="mt-3">
                                <li><a href="{{ route('about-oel') }}">About OEL</a></li>
                                <li><a href="{{ route('contact_us') }}">Contact Us</a></li>
                                <li><a href="{{ route('all-blogs') }}">Blogs</a></li>
                                <li><a href="{{ route('testimonials') }}">Testimonials</a></li>
                                <li><a href="{{ route('frequently-asked-questions') }}">FAQ</a></li>
                                <li><a href="{{ route('privacy-policy') }}">Privacy Policy</a></li>
                                <li><a href="{{ route('terms-and-conditions') }}">Terms&Conditions</a></li>
                                <li><a href="{{ route('user-login') }}">Franchise Login</a></li>
                                <li><a href="{{ route('user-login') }}">Counselor Login</a></li>
                                <li><a href="{{ route('user-login') }}">Student Login</a></li>
                                <li><a href="{{ route('landing-page') }}">Apply Now</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="bottom_heading_fooet">
                            <h5 class="text-uppercase fw-bold">Hot Courses</h5>
                            <ul class=" mt-3">
                                <li><a href="{{ url('programs') }}">Hospitality</a></li>
                                <li><a href="{{ url('programs') }}">Nursing</a></li>
                                <li><a href="{{ url('programs') }}">Design/Media</a></li>
                                <li><a href="{{ url('programs') }}">Engineering</a></li>
                                <li><a href="{{ url('programs') }}">Management</a></li>
                                <li><a href="{{ url('programs') }}">Medicine</a></li>
                                <li><a href="{{ url('programs') }}">Business</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="bottom_heading_fooet">
                            <h5 class="text-uppercase fw-bold">Top Destination</h5>
                            <ul class="mt-3">
                                <li><a href="{{url('universities?country=38')}}">Canada</a></li>
                                <li><a href="{{url('universities?country=231')}}">USA</a></li>
                                <li><a href="{{url('universities?country=13')}}">Australia</a></li>
                                <li><a href="{{url('universities?country=230')}}">UK</a></li>
                                <li><a href="{{url('universities?country=157')}}">New Zealand</a></li>
                                <li><a href="{{url('universities?country=116')}}">South korea</a></li>
                                <li><a href="{{url('universities?country=109')}}">Japan</a></li>
                                <li><a href="{{url('universities?country=107')}}">Italy</a></li>
                                <li><a href="{{url('universities?country=181')}}">Russia</a></li>
                                <li><a href="{{url('universities?country=105')}}">Ireland</a></li>
                                <li><a href="{{url('universities?country=82')}}">Germany</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="bottom_heading_fooet">
                            <h5 class="text-uppercase fw-bold">Our services</h5>
                            <ul class="mt-3">
                                <li><a href="javascript:void(0)" onclick="openWizard()">IELTS/DET/TOEFL/PTE</a></li>
                                <li><a href="javascript:void(0)" onclick="openWizard()">Free Counseling</a></li>
                                <li><a href="{{url('/resumeevaluation')}}">LOR</a></li>
                                <li><a href="{{url('/resumeevaluation')}}">SOP</a></li>
                                <li><a href="{{url('/pretestprepration')}}">Other Exam</a></li>
                                <li><a href="{{url('/financialcounselling')}}">Education Loan</a></li>
                                <li><a href="{{url('/foreignexchange')}}">Forex</a></li>
                                <li><a href="{{url('/admissionguidance')}}">Scholarship</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="bottom_heading_fooet list_st_grup">
                            <h5 class="text-uppercase fw-bold">Address</h5>
                            <ul class="mt-3">
                                <li><img src="{{ asset('frontend/img/address.png') }}"><a href=""
                                        class="mx-3">Overseas Education Lane</a>
                                </li>
                                <li><img src="{{ asset('frontend/img/phone.png') }}"><a href="tel:+91892992525"
                                        class="mx-3">+(91) 892 992 2525</a>
                                </li>
                                <li><img src="{{ asset('frontend/img/enveloper.png') }}"><a href="mailto:info@overseaseducationlane.com"
                                        class="mx-3">info@overseaseducationlane.com</a></li>
                                <li><img src="{{ asset('frontend/img/enveloper.png') }}"><a href="mailto:help@overseaseducationlane.com"
                                        class="mx-3">help@overseaseducationlane.com</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="sub-footer mt-2 d-flex justify-content-between align-items-center">
                    <div class="sub-right fw-medium">
                        <h6>Â© {{date('Y')}} Copyright <span>Overseas Education Lane</span> All Rights Reserved.</h6>
                    </div>
                    <div class="sub-left">
                        <a href="https://www.facebook.com/overseaseducationlane.oel/" style="color:white"> <i class="fa-brands fa-facebook-f mx-1"></i></a>
                        <a href="https://in.linkedin.com/in/overseaseducationlane?trk=public_profile_samename-profile" style="color:white"> <i class="fa-brands fa-linkedin-in mx-1"></i></a>
                        <a href="https://www.youtube.com/@OverseasEducationLane1" style="color:white"><i class="fa-brands fa-youtube mx-1"></i></a>
                        <a href="https://www.instagram.com/overseaseducation_lane/" style="color:white"> <i class="fa-brands fa-instagram mx-1"></i></a>
                        <a href="https://twitter.com/LaneEducation" style="color:white"> <i class="fa-brands fa-twitter mx-1"></i> </a>
                    </div>
                </div>
            </div>
        </div>
       
    </section>
    <section>
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                <div class="modal-dialog modal-dialog-centered" style="min-width: 800px;">
                    <div class="modal-content">
                        <div class="row">
                            <div class="col-md-6 p-0">
                                <img src="https://overseaseducationlane.com/public/frontend/images/login.jpg"
                                    style="height: 100%;width: 100%;object-fit: cover;">
                            </div>
                            <div class="col-md-6"
                                style="background: #EAEAEA;">
                                <div class="modal-header float-end">

                                    <button type="button" class="btn-close position-relative p-3 border-0 bg-transparent" data-bs-dismiss="modal" aria-label="Close">
                                        <span class="position-absolute  translate-middle fw-bold custom-close">&times;</span>
                                    </button>
                                </div>
                                <h4 style="text-align:center">REQUEST AN ENQUIRY<br>we usually respond in seconds</h4>
                                <div class="modal-header">
                                    
                                </div>
                                <form class="mx-1 mx-md-4" id="enquiry_data" method="POST" autocomplete="off" novalidate="novalidate">
                                    <input type="hidden" name="_token" value="EtDPgMZlqrXdbXLqqmRFysU8re1mNncBoQPgqNA7">

                                    <div class="d-flex flex-row align-items-center mb-4">
                                        <i class="fas fa-user-circle" style="width: 35px; font-size: 24px; color: #070758;"></i>
                                        <input type="text" class="form-control" name="full_name" id="full_name" required
                                            aria-describedby="emailHelp" placeholder="First Name">
                                    </div>

                                    <div class="d-flex flex-row align-items-center mb-4">
                                        <i class="fas fa-at" style="width: 35px; font-size: 22px; color: #070758;"></i>
                                        <input type="email" name="email" class="form-control" required id="email_name"
                                            aria-describedby="emailHelp" placeholder="Enter email">
                                    </div>
                                    <span class="text-danger email_error"></span>
                                    <span style="margin-left: 37px; margin-bottom: 50px !important; position: relative; top: -8px; font-size: 12px;">
                                        We'll never share your email with anyone else.
                                    </span>

                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="d-flex flex-row align-items-center mb-4">
                                                <i class="fas fa-phone-alt" style="width: 35px; font-size: 24px; color: #070758;"></i>
                                                <input type="tel" name="mobile_number" class="form-control" aria-describedby="emailHelp"
                                                    pattern="[0-9]{10}" placeholder="Mobile number" id="mobile_number" required  oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);">
                                            </div>
                                            <span style="margin-left: 37px; position: relative; top: -8px; font-size: 12px;">
                                                Please enter 10 digits only.
                                            </span>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="d-flex float-end mt-2">
                                                <button type="button" id="verify_otp" class="btn btn-sm"
                                                    style="background-color: #070758; color: white;">
                                                    <span class="spinner-grow spinner-grow-sm d-none" role="status" aria-hidden="true"></span>
                                                    Verify OTP
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <span class="text-danger error-phone"></span>

                                    <div class="d-flex flex-row align-items-center mb-4 otp-verify" style="display:none !important;">
                                        <i class="fas fa-key" style="width: 35px; font-size: 24px; color: #070758;"></i>
                                        <input type="number" name="otp" class="form-control" id="otp" required
                                            aria-describedby="emailHelp" placeholder="Enter otp"  oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 6);">
                                    </div>
                                    <span class="text-danger otp-error"></span>

                                    <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                                        <button type="button" id="booking_enquiry" class="btn btn-lg booking_enquiry"
                                            style="background-color: #070758; color: white;" disabled>
                                            <span class="spinner-grow spinner-grow-sm d-none" role="status" aria-hidden="true"></span>
                                            Submit Now
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>
    <section>
        <a href="{{url('contact-us')}}" class="chat-btn" title="Chat with us">
            <i class="fa-solid fa-comments"></i>
        </a>
    </section>
    <section>
        <a href="https://wa.me/918929922525?text=Hello,%20I%20am%20interested%20in%20your%20services!" target="_blank" class="whatsapp-icon">
            <img src="{{asset('frontend/img/whatsapp.png')}}" alt="WhatsApp Logo">
        </a>
    </section>
    
 <!-- PREMIUM EXACT-MATCH WIZARD MODAL -->
    <div id="exactWizardModal" class="wizard-modal">
        <div class="wizard-overlay-bg"></div>
        <div id="wiz-wave" class="wizard-wave-bg">
            <!-- New Top Wave - Exact Reference Match -->
            <div class="wiz-wave-svg-top">
                <svg viewBox="0 0 1920 217" preserveAspectRatio="none" style="transform: scaleX(-1);">
                    <path d="M0,57.46875 C203.364583,135.217754 494.835938,156.564108 874.414062,121.507813 C1192.61198,-13.9827666 1541.14063,-35.3291208 1920,57.46875 L1920,207 L0,207 L0,57.46875 Z" opacity=".3" style="fill: #d4e3ff;"></path>
                    <path d="M0,79 C292.46875,165.453125 612.46875,165.453125 960,79 C1307.53125,-7.453125 1627.53125,-7.453125 1920,79 L1920,207 L0,207 L0,79 Z" opacity=".6" style="fill: #d4e3ff;"></path>
                    <path d="M0,89 C288.713542,146.786458 608.713542,146.786458 960,89 C1311.28646,31.2135417 1631.28646,31.2135417 1920,89 L1920,217 L0,217 L0,89 Z" style="fill: #d4e3ff;"></path>
                </svg>
            </div>
            <!-- Institutional Multi-Layered SVG Wave - Exact Reference Match -->
            <div class="wiz-wave-svg">
                <svg viewBox="0 0 1920 217" preserveAspectRatio="none">
                    <path d="M0,57.46875 C203.364583,135.217754 494.835938,156.564108 874.414062,121.507813 C1192.61198,-13.9827666 1541.14063,-35.3291208 1920,57.46875 L1920,207 L0,207 L0,57.46875 Z" opacity=".3" style="fill: #edf3ff;"></path>
                    <path d="M0,79 C292.46875,165.453125 612.46875,165.453125 960,79 C1307.53125,-7.453125 1627.53125,-7.453125 1920,79 L1920,207 L0,207 L0,79 Z" opacity=".6" style="fill: #edf3ff;"></path>
                    <path d="M0,89 C288.713542,146.786458 608.713542,146.786458 960,89 C1311.28646,31.2135417 1631.28646,31.2135417 1920,89 L1920,217 L0,217 L0,89 Z" style="fill: #edf3ff;"></path>
                </svg>
            </div>
        </div>
        

        
        <div class="wizard-container">
            <!-- PAGE 1: DESTINATION -->
            <div id="wiz-p1" class="wiz-page active">
                <div class="wiz-logo-top">
                    <img src="{{ asset('frontend/img/oel (1) 1.png') }}" alt="OEL Logo">
                </div>
                
                <div class="dest-title-main">
                    <h1 class="dest-title-blue">Book Your Free Online Counselling & <br> Start Your Study Abroad Journey</h1>
                    <h2 class="dest-title-red l YC c">Select Your Dream Study Destination !</h2>
                </div>
                
                <div class="dest-grid-exact">
                    <div class="dest-card-exact" onclick="selectDest('United States')">
                        <img src="https://flagcdn.com/w80/us.png" class="dest-flag-img">
                        <span class="dest-name-exact">United States</span>
                    </div>
                    <div class="dest-card-exact" onclick="selectDest('Canada')">
                        <img src="https://flagcdn.com/w80/ca.png" class="dest-flag-img">
                        <span class="dest-name-exact">Canada</span>
                    </div>
                    <div class="dest-card-exact" onclick="selectDest('United Kingdom')">
                        <img src="https://flagcdn.com/w80/gb.png" class="dest-flag-img">
                        <span class="dest-name-exact">United Kingdom</span>
                    </div>
                    <div class="dest-card-exact" onclick="selectDest('Ireland')">
                        <img src="https://flagcdn.com/w80/ie.png" class="dest-flag-img">
                        <span class="dest-name-exact">Ireland</span>
                    </div>
                    <div class="dest-card-exact" onclick="selectDest('Australia')">
                        <img src="https://flagcdn.com/w80/au.png" class="dest-flag-img">
                        <span class="dest-name-exact">Australia</span>
                    </div>
                    <div class="dest-card-exact" onclick="selectDest('New Zealand')">
                        <img src="https://flagcdn.com/w80/nz.png" class="dest-flag-img">
                        <span class="dest-name-exact">New Zealand</span>
                    </div>
                    <div class="dest-card-exact" onclick="selectDest('Europe')">
                        <img src="https://flagcdn.com/w80/eu.png" class="dest-flag-img">
                        <span class="dest-name-exact">Europe</span>
                    </div>
                    <div class="dest-card-exact" onclick="selectDest('Asia')">
                        <img src="https://flagcdn.com/w80/ae.png" class="dest-flag-img">
                        <span class="dest-name-exact">Asia</span>
                    </div>
                    <div style="grid-column: 1 / -1; display: flex; justify-content: center;">
                        <div class="dest-card-exact" onclick="selectDest('Germany')">
                            <img src="https://flagcdn.com/w80/de.png" class="dest-flag-img">
                            <span class="dest-name-exact">Germany</span>
                        </div>
                    </div>
                </div>

                <div class="test-prep-title-main">
                    <h2 class="dest-title-red l YC c">Book Free Test Prep & Education Loan Counselling !</h2>
                    <div class="test-prep-grid-proper">
                        <div class="dest-card-exact" onclick="selectDest('IELTS, PTE, TOEFL')">
                            <img src="{{asset('frontend/img/test-prep-icon.png')}}" alt="Test Prep Icon" class="test-prep-emoji" style="width: 50px; height: 50px;" />
                            <span class="test-prep-label">IELTS, PTE, TOEFL</span>
                        </div>
                        <div class="dest-card-exact" onclick="selectDest('GRE, GMAT, SAT, ACT')">
                            <img src="{{asset('frontend/img/test-prep-icon.png')}}" alt="Test Prep Icon" class="test-prep-emoji" style="width: 50px; height: 50px;" />
                            <span class="test-prep-label">GRE, GMAT, SAT, ACT</span>
                        </div>
                        <div class="dest-card-exact" onclick="selectDest('Duolingo, German Language')">
                            <img src="{{asset('frontend/img/test-prep-icon.png')}}" alt="Test Prep Icon" class="test-prep-emoji" style="width: 50px; height: 50px;" />
                            <span class="test-prep-label">Duolingo, German Language</span>
                        </div>
                        <div class="dest-card-exact" onclick="selectDest('Study Abroad Education Loan')">
                            <img src="{{asset('frontend/img/elan-loan-icon.png')}}" alt="Élan Loan Icon" class="test-prep-emoji" style="width: 50px; height: 50px;" />
                            <span class="test-prep-label">Study Abroad Education Loan</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- PAGE 2: CALENDAR -->
            <div id="wiz-p2" class="wiz-page">
                <div class="wiz-split-container" style="max-width: 850px; border-radius: 8px; display: flex;">
                    <div class="wiz-side-info" style="flex: 1; padding: 30px; border-right: 1px solid rgba(30,41,59,0.1); background: #fff;">
                        <div class="wiz-back-btn" onclick="goToStep(1)" style="margin-bottom: 24px; border:none; width:auto; justify-content:flex-start;">
                            <i class="fa fa-arrow-left" style="color: #226cf5; font-size: 18px;"></i>
                        </div>
                        <div style="margin-bottom: 24px;">
                            <div style="color: #64748b; font-weight: 700; text-transform: capitalize; margin-bottom: 8px; font-size: 14px;">Overseas Education Lane</div>
                            <div id="side-dest-name" style="color: #1e293b; font-weight: 700; font-size: 26px; line-height: 1.2;">USA</div>
                        </div>
                        
                        <div class="wiz-side-meta" style="font-size: 14px; color: #64748b; gap: 12px;">
                            <div id="side-selected-time" style="display:none; font-weight:700; color: #226cf5; display:flex; align-items:flex-start;"><span id="text-selected-time"></span></div>
                        </div>
                    </div>
                    <div class="wiz-main-action" style="flex: 1; padding: 40px 30px 30px; display:flex; flex-direction:column; background: #fff;">
                        <div class="wiz-main-title" style="margin-bottom: 24px; display:flex; align-items:center; gap: 12px;">
                            <div style="position:relative;">
                                <img src="https://cdn.zipteams.com/user-12003/profile/profile-picture-2025-09-23T05:25:19.905Z.jpeg" class="wiz-counselor-avatar" style="width: 40px; height: 40px; border-radius: 50%;">
                            </div>
                            <span style="font-size: 20px; font-weight: 700; color: #1e293b;">What day & time works best for you?</span>
                        </div>
                        
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                            <span style="font-weight: 700; color: #1e293b; font-size: 16px; text-decoration: underline;" id="week-label">This week</span>
                            <div style="display:flex; gap: 8px;">
                                <button onclick="shiftWeek(-1)" style="border:none; background:transparent; border-radius:50%; padding:4px; cursor:pointer; color: #1e293b;"><i class="fa fa-chevron-left"></i></button>
                                <button onclick="shiftWeek(1)" style="border:none; background:transparent; border-radius:50%; padding:4px; cursor:pointer; color: #1e293b;"><i class="fa fa-chevron-right"></i></button>
                            </div>
                        </div>
                        
                        <div class="cal-week-row" id="cal-week-row-container">
                            <!-- Populated by Javascript -->
                        </div>

                        <div style="margin-bottom: 12px; display: flex; justify-content: space-between; align-items: center;">
                            <span style="font-weight: 700; color: #1e293b; font-size: 16px; text-decoration: underline;">Time Slots</span>
                            <div style="display:flex; gap: 8px;">
                                <button type="button" id="time-prev-btn" onclick="shiftTimeSlots(-1)" style="border:none; background:transparent; border-radius:50%; padding:4px; cursor:pointer; color: #8F8F8F;"><i class="fa fa-chevron-left"></i></button>
                                <button type="button" id="time-next-btn" onclick="shiftTimeSlots(1)" style="border:none; background:transparent; border-radius:50%; padding:4px; cursor:pointer; color: #8F8F8F;"><i class="fa fa-chevron-right"></i></button>
                            </div>
                        </div>
                        
                        <div class="time-slots-grid" id="time-slots-container" style="margin-bottom: 24px;">
                            <!-- Populated by Javascript -->
                        </div>

                        <!-- Custom Timezone Dropdown -->
                        <div class="wiz-timezone-container" id="timezone-container">
                            <div class="wiz-timezone-trigger" onclick="toggleTimezoneMenu(event)">
                                <i class="fa fa-globe"></i>
                                <span id="current-timezone-text">(GMT+5:30) Chennai, Kolkata, Mumbai, New Delhi</span>
                                <i class="fa fa-chevron-down"></i>
                            </div>
                            <div class="wiz-timezone-menu">
                                <div class="wiz-timezone-search">
                                    <input type="text" placeholder="Search timezone..." onkeyup="filterTimezones(this)" onclick="event.stopPropagation()">
                                </div>
                                <div class="wiz-timezone-options" id="timezone-options-list">
                                    <div class="wiz-timezone-option" data-value="GMT-11:00">(GMT-11:00) Midway Island, Samoa</div>
                                    <div class="wiz-timezone-option" data-value="GMT-10:00">(GMT-10:00) Hawaii</div>
                                    <div class="wiz-timezone-option" data-value="GMT-08:00">(GMT-08:00) Alaska</div>
                                    <div class="wiz-timezone-option" data-value="GMT-07:00">(GMT-07:00) Dawson, Yukon</div>
                                    <div class="wiz-timezone-option" data-value="GMT-07:00">(GMT-07:00) Arizona</div>
                                    <div class="wiz-timezone-option" data-value="GMT-07:00">(GMT-07:00) Tijuana</div>
                                    <div class="wiz-timezone-option" data-value="GMT-07:00">(GMT-07:00) Pacific Time</div>
                                    <div class="wiz-timezone-option" data-value="GMT-06:00">(GMT-06:00) Mountain Time</div>
                                    <div class="wiz-timezone-option" data-value="GMT-06:00">(GMT-06:00) Saskatchewan</div>
                                    <div class="wiz-timezone-option" data-value="GMT-05:00">(GMT-05:00) Central Time</div>
                                    <div class="wiz-timezone-option" data-value="GMT-05:00">(GMT-05:00) Bogota, Lima, Quito</div>
                                    <div class="wiz-timezone-option" data-value="GMT-04:00">(GMT-04:00) Eastern Time</div>
                                    <div class="wiz-timezone-option" data-value="GMT-04:00">(GMT-04:00) Caracas, La Paz</div>
                                    <div class="wiz-timezone-option" data-value="GMT-03:30">(GMT-03:30) Newfoundland</div>
                                    <div class="wiz-timezone-option" data-value="GMT-03:00">(GMT-03:00) Brasilia</div>
                                    <div class="wiz-timezone-option" data-value="GMT-03:00">(GMT-03:00) Buenos Aires, Georgetown</div>
                                    <div class="wiz-timezone-option" data-value="GMT-02:00">(GMT-02:00) Mid-Atlantic</div>
                                    <div class="wiz-timezone-option" data-value="GMT-01:00">(GMT-01:00) Azores</div>
                                    <div class="wiz-timezone-option" data-value="GMT-01:00">(GMT-01:00) Cape Verde Is.</div>
                                    <div class="wiz-timezone-option" data-value="GMT+00:00">(GMT+00:00) Casablanca, Monrovia</div>
                                    <div class="wiz-timezone-option" data-value="GMT+00:00">(GMT+00:00) Greenwich Mean Time : Dublin, Edinburgh, Lisbon, London</div>
                                    <div class="wiz-timezone-option" data-value="GMT+01:00">(GMT+01:00) Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna</div>
                                    <div class="wiz-timezone-option" data-value="GMT+01:00">(GMT+01:00) Belgrade, Bratislava, Budapest, Ljubljana, Prague</div>
                                    <div class="wiz-timezone-option" data-value="GMT+01:00">(GMT+01:00) Brussels, Copenhagen, Madrid, Paris</div>
                                    <div class="wiz-timezone-option" data-value="GMT+01:00">(GMT+01:00) Sarajevo, Skopje, Warsaw, Zagreb</div>
                                    <div class="wiz-timezone-option" data-value="GMT+01:00">(GMT+01:00) West Central Africa</div>
                                    <div class="wiz-timezone-option" data-value="GMT+02:00">(GMT+02:00) Athens, Istanbul, Minsk</div>
                                    <div class="wiz-timezone-option" data-value="GMT+02:00">(GMT+02:00) Bucharest</div>
                                    <div class="wiz-timezone-option" data-value="GMT+02:00">(GMT+02:00) Cairo</div>
                                    <div class="wiz-timezone-option" data-value="GMT+02:00">(GMT+02:00) Harare, Pretoria</div>
                                    <div class="wiz-timezone-option" data-value="GMT+02:00">(GMT+02:00) Helsinki, Kyiv, Riga, Tallinn, Vilnius, Vilnius</div>
                                    <div class="wiz-timezone-option" data-value="GMT+02:00">(GMT+02:00) Jerusalem</div>
                                    <div class="wiz-timezone-option" data-value="GMT+03:00">(GMT+03:00) Baghdad</div>
                                    <div class="wiz-timezone-option" data-value="GMT+03:00">(GMT+03:00) Kuwait, Riyadh</div>
                                    <div class="wiz-timezone-option" data-value="GMT+03:00">(GMT+03:00) Moscow, St. Petersburg, Volgograd</div>
                                    <div class="wiz-timezone-option" data-value="GMT+03:00">(GMT+03:00) Nairobi</div>
                                    <div class="wiz-timezone-option" data-value="GMT+03:30">(GMT+03:30) Tehran</div>
                                    <div class="wiz-timezone-option" data-value="GMT+04:00">(GMT+04:00) Abu Dhabi, Muscat</div>
                                    <div class="wiz-timezone-option" data-value="GMT+04:00">(GMT+04:00) Baku, Tbilisi, Yerevan</div>
                                    <div class="wiz-timezone-option" data-value="GMT+04:30">(GMT+04:30) Kabul</div>
                                    <div class="wiz-timezone-option" data-value="GMT+05:00">(GMT+05:00) Ekaterinburg</div>
                                    <div class="wiz-timezone-option" data-value="GMT+05:00">(GMT+05:00) Islamabad, Karachi, Tashkent</div>
                                    <div class="wiz-timezone-option selected" data-value="GMT+05:30">(GMT+5:30) Chennai, Kolkata, Mumbai, New Delhi</div>
                                    <div class="wiz-timezone-option" data-value="GMT+05:45">(GMT+05:45) Kathmandu</div>
                                    <div class="wiz-timezone-option" data-value="GMT+06:00">(GMT+06:00) Almaty, Novosibirsk</div>
                                    <div class="wiz-timezone-option" data-value="GMT+06:00">(GMT+06:00) Astana, Dhaka</div>
                                    <div class="wiz-timezone-option" data-value="GMT+06:00">(GMT+06:00) Sri Jayawardenepura</div>
                                    <div class="wiz-timezone-option" data-value="GMT+06:30">(GMT+06:30) Rangoon</div>
                                    <div class="wiz-timezone-option" data-value="GMT+07:00">(GMT+07:00) Bangkok, Hanoi, Jakarta</div>
                                    <div class="wiz-timezone-option" data-value="GMT+07:00">(GMT+07:00) Krasnoyarsk</div>
                                    <div class="wiz-timezone-option" data-value="GMT+08:00">(GMT+08:00) Beijing, Chongqing, Hong Kong, Urumqi</div>
                                    <div class="wiz-timezone-option" data-value="GMT+08:00">(GMT+08:00) Irkutsk, Ulaan Bataar</div>
                                    <div class="wiz-timezone-option" data-value="GMT+08:00">(GMT+08:00) Kuala Lumpur, Singapore</div>
                                    <div class="wiz-timezone-option" data-value="GMT+08:00">(GMT+08:00) Perth</div>
                                    <div class="wiz-timezone-option" data-value="GMT+08:00">(GMT+08:00) Taipei</div>
                                    <div class="wiz-timezone-option" data-value="GMT+09:00">(GMT+09:00) Osaka, Sapporo, Tokyo</div>
                                    <div class="wiz-timezone-option" data-value="GMT+09:00">(GMT+09:00) Seoul</div>
                                    <div class="wiz-timezone-option" data-value="GMT+09:00">(GMT+09:00) Yakutsk</div>
                                    <div class="wiz-timezone-option" data-value="GMT+09:30">(GMT+09:30) Adelaide</div>
                                    <div class="wiz-timezone-option" data-value="GMT+09:30">(GMT+09:30) Darwin</div>
                                    <div class="wiz-timezone-option" data-value="GMT+10:00">(GMT+10:00) Brisbane</div>
                                    <div class="wiz-timezone-option" data-value="GMT+10:00">(GMT+10:00) Canberra, Melbourne, Sydney</div>
                                    <div class="wiz-timezone-option" data-value="GMT+10:00">(GMT+10:00) Guam, Port Moresby</div>
                                    <div class="wiz-timezone-option" data-value="GMT+10:00">(GMT+10:00) Hobart</div>
                                    <div class="wiz-timezone-option" data-value="GMT+10:00">(GMT+10:00) Vladivostok</div>
                                    <div class="wiz-timezone-option" data-value="GMT+11:00">(GMT+11:00) Magadan, Solomon Is., New Caledonia</div>
                                    <div class="wiz-timezone-option" data-value="GMT+12:00">(GMT+12:00) Auckland, Wellington</div>
                                    <div class="wiz-timezone-option" data-value="GMT+12:00">(GMT+12:00) Fiji, Kamchatka, Marshall Is.</div>
                                    <div class="wiz-timezone-option" data-value="GMT+13:00">(GMT+13:00) Nuku'alofa</div>
                                </div>
                            </div>
                        </div>

                        <!-- Add Participant -->
                        <div class="wiz-participant-section">
                            <button type="button" id="wiz-add-guest-btn" onclick="toggleParticipantInput()">
                                <i class="fa fa-plus-circle"></i> Add Participant
                            </button>
                            <div id="participant-container" class="wiz-participant-container">
                                <input type="email" id="participant-email" class="wiz-participant-input" placeholder="" onkeyup="updateGuestEmail()">
                            </div>
                        </div>

                        <div style="margin-top: 10px;">
                            <button class="wiz-confirm-btn" id="confirm-time-btn" disabled onclick="goToStep(3)">Confirm</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- PAGE 3: FORM -->
            <div id="wiz-p3" class="wiz-page">
                <div class="wiz-split-container">
                    <div class="wiz-side-info">
                        <div class="wiz-back-btn" onclick="goToStep(2)" style="margin-bottom: 24px; border:none; width:auto; justify-content:flex-start; cursor:pointer;">
                            <i class="fa fa-arrow-left" style="color: #226cf5; font-size: 18px;"></i>
                        </div>
                        <div style="margin-bottom: 24px;">
                            <div style="color: #64748b; font-weight: 700; text-transform: capitalize; margin-bottom: 8px; font-size: 14px;">Overseas Education Lane</div>
                            <div id="side-dest-name-final" style="color: #1e293b; font-weight: 700; font-size: 26px; line-height: 1.2;">USA</div>
                        </div>
                    </div>
                    <div class="wiz-main-action">
                        <div class="wiz-main-title" style="margin-bottom: 32px; display:flex; align-items:center; gap: 12px;">
                            <img src="https://cdn.zipteams.com/user-12003/profile/profile-picture-2025-09-23T05:25:19.905Z.jpeg" class="wiz-counselor-avatar" style="width: 44px; height: 44px; border-radius: 50%; object-fit: cover;">
                            <span style="font-size: 18px; font-weight: 700; color: #1c1d21;">Please help me with <br> some details about you</span>
                        </div>
                        
                        <form id="wiz-booking-form" onsubmit="event.preventDefault(); goToStep(4);">
                            @csrf
                            <input type="hidden" name="destination" id="final-dest">
                            <input type="hidden" name="schedule" id="final-time">
                            <input type="hidden" name="guest_email" id="final-guest">
                                                       <div class="wiz-form-group">
                                <label class="wiz-form-label">Name *</label>
                                <div class="wiz-input-wrapper">
                                    <i class="fa-regular fa-user"></i>
                                    <input type="text" name="name" class="wiz-input" placeholder="Name" required>
                                </div>
                            </div>
                            
                            <div class="wiz-form-group">
                                <label class="wiz-form-label">Email address *</label>
                                <div class="wiz-input-wrapper">
                                    <i class="fa-regular fa-envelope"></i>
                                    <input type="email" name="email" class="wiz-input" placeholder="Email address" required>
                                </div>
                            </div>
                            
                            <div class="wiz-form-group">
                                 <label class="wiz-form-label">Your City *</label>
                                 <div class="wiz-input-wrapper">
                                     <select name="city" class="wiz-input" style="padding-left:14px;" required>
                                         <option value="">Select</option>
                                         <option value="Lucknow">Lucknow</option>
                                         <option value="New Delhi">New Delhi</option>
                                         <option value="Mumbai">Mumbai</option>
                                         <option value="Pune">Pune</option>
                                         <option value="Hyderabad">Hyderabad</option>
                                     </select>
                                 </div>
                            </div>
                            
                            <div class="wiz-form-group">
                                <label class="wiz-form-label">Phone number *</label>
                                <input type="tel" id="wiz-mobile-input" name="mobile" class="wiz-input" placeholder="Phone number" required style="width: 100%;">
                            </div>

                            <button type="submit" class="wiz-confirm-btn" style="margin: 10px 0 0 50px; background:#226cf5; border-radius:16px; width:250px; height:48px; color:#fff; font-weight:700;">Schedule Event</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- PAGE 4: CONFIRMATION (REFINED SIMPLE) -->
            <div id="wiz-p4" class="wiz-page">
                <div style="max-width: 780px; margin: 30px auto; background: #fff; padding: 40px; border-radius: 20px; text-align: center; border: 1px solid #e2e8f0; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);">
                    <div style="margin-bottom: 24px;">
                        <img src="https://cdn.zipteams.com/user-12003/profile/profile-picture-2025-09-23T05:25:19.905Z.jpeg" style="width: 64px; height: 64px; border-radius: 50%; object-fit: cover; border: 2px solid #f8fafc; margin: 0 auto 16px; display: block; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);">
                        <h2 style="font-size: 22px; font-weight: 800; color: #1e293b; margin-bottom: 6px; line-height: 1.3;">Meeting is scheduled. <br> Look to meet you soon!</h2>
                    </div>
                    
                    <div style="color: #475569; font-size: 14px; line-height: 1.6; margin-bottom: 24px; width: 100%;">
                        <div style="display: flex; flex-direction: column; align-items: center; gap: 4px; margin-bottom: 20px;">
                            <div style="display: flex; align-items: center; gap: 8px; font-weight: 700; color: #1e293b; font-size: 15px;">
                                <i class="fa-regular fa-calendar-check" style="color: #226cf5; font-size: 16px;"></i>
                                <span id="conf-time-range">01:00 PM - 01:30 PM, Tuesday, May 05, 2026</span>
                            </div>
                            <div style="display: flex; align-items: center; gap: 8px; color: #64748b; font-weight: 500; font-size: 13px;">
                                <i class="fa-solid fa-globe" style="color: #94a3b8; font-size: 12px;"></i>
                                <span>Asia/Calcutta</span>
                            </div>
                        </div>
                        
                        <div style="background: #f8fafc; padding: 12px 16px; border-radius: 12px; border: 1px dashed #cbd5e1; margin: 0 auto 16px; width: 100%; max-width: 600px; box-sizing: border-box;">
                            <div style="font-size: 10px; text-transform: uppercase; letter-spacing: 0.05em; color: #94a3b8; font-weight: 700; margin-bottom: 4px;">Meeting Link</div>
                            <a href="#" style="color: #226cf5; text-decoration: none; font-size: 13px; word-break: break-all; font-weight: 600; display: block; line-height: 1.4;">https://meet.zipteams.com/69f9913b0076a9a631f875e2?org=KC+Overseas+Education&passcode=0918</a>
                        </div>
                        
                        <p style="font-size: 13px; color: #64748b;">A calendar invitation has been sent to your email address.</p>
                    </div>

                    <button onclick="goToStep(2)" class="wiz-confirm-btn" style="width: 200px; height: 42px; font-size: 13px; border-radius: 10px; font-weight: 700; margin: 0 auto; background: #226cf5; box-shadow: 0 4px 6px -1px rgba(34, 108, 245, 0.2);">Book another meeting</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"
        integrity="sha512-A7AYk1fGKX6S2SsHywmPkrnzTZHrgiVT7GcQkLGDe2ev0aWb8zejytzS8wjo7PGEXKqJOrjQ4oORtnimIRZBtw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11.0.5/swiper-bundle.min.js"></script>
    @yield('javascript_section')

    <script>
        AOS.init();
    </script>
   <script>
            document.addEventListener("DOMContentLoaded", function() {
            var logosSlide = document.querySelector(".logos-slide");
            var logoSlider = document.querySelector(".logo-slider");

            if (logosSlide && logoSlider) {
                var copy = logosSlide.cloneNode(true);
                logoSlider.appendChild(copy);
            }
                });
   </script>
    <script>
        const menuBtn = document.getElementById("menu_btn");
        if(menuBtn){
            const navLinks = document.getElementById("nav_links");
            const menuBtnIcon = menuBtn.querySelector("i");
            menuBtn.addEventListener("click", (e) => {
                navLinks.classList.toggle("open");

                const isOpen = navLinks.classList.contains("open");
                menuBtnIcon.setAttribute("class", isOpen ? "ri-close-line" : "ri-menu-line")
            });
        }
    </script>
    <script>
        // ===== OTP FIX =====
        $('#verify_otp').click(function(){
            $('#booking_enquiry').prop('disabled', false);
        });

        $('.booking_enquiry').click(function(){
            alert("Form Submitted");
        });
    </script>
    <script>
        $(document).on('click', '#verify_otp', function(e) {
            $('.error-phone').html('');
            e.preventDefault();
            let mobile_number = $('#mobile_number').val();
            if (!mobile_number || mobile_number.length != 10 || !/^\d+$/.test(mobile_number)) {
                alert('Please enter valid mobile number', 'error');
                return false;
            }
            var spinner = this.querySelector('.spinner-grow');
            spinner.classList.remove('d-none');
            $.ajax({
                url: "{{ route('send-otp') }}",
                type: 'POST',
                data: {
                    phone_number: mobile_number,
                    _token: '{{ csrf_token() }}'
                },
                success: function(data) {
                    spinner.classList.add('d-none');
                    if (data.success) {
                        $('.otp-sent').html(data.message);
                    }
                    if (data.success) {
                        $('.otp-verify').show();
                    } else {
                        $('.error-phone').html(data.message);
                    }
                },
                error: function(xhr) {
                    spinner.classList.add('d-none');
                    if (xhr.responseJSON.errors.phone_number) {
                        $('.error-phone').html(xhr.responseJSON.errors.phone_number[0]);
                    }
                    if (xhr.responseJSON.errors.email) {
                        $('.error-email').html(xhr.responseJSON.errors.email[0]);
                    }
                }
            })
        })
        $('.booking_enquiry').on('click', function(e) {
            e.preventDefault();
            let mobile_number = $('#mobile_number').val();
            if (!mobile_number || mobile_number.length != 10 || !/^\d+$/.test(mobile_number)) {
                alert('Please enter valid mobile number', 'error');
                return false;
            }
            let full_name = $('#full_name').val();
            if (!full_name) {
                alert('Please enter your full name', 'error');
                return false;
            }
            let email = $('#email_name').val();
            let otp = $('#otp').val();
            if (!otp) {
                alert('Please enter otp', 'error');
                return false;
            }
            var spinner = this.querySelector('.spinner-grow');
            spinner.classList.remove('d-none');
            $.ajax({
                url: "{{ route('verify-otp') }}",
                type: 'POST',
                data: {
                    phone_number: mobile_number,
                    full_name: full_name,
                    email: email,
                    otp: otp,
                    _token: '{{ csrf_token() }}'
                },
                success: function(data) {
                    spinner.classList.add('d-none');
                    if (data.success) {
                        window.location.href = "{{ url('check-eligibility') }}";
                    } else {
                        $('.otp-error').html(data.message);
                        $('#exampleModal').css('display', 'none');
                    }
                },
                error: function(xhr, status, error) {
                    spinner.classList.add('d-none');
                    alert(xhr.responseJSON.errors.email[0]);
                    if (xhr.responseJSON.errors.email) {
                        $('.email_error').html(xhr.responseJSON.errors.email[0]);
                    }
                    if (xhr.status == 422) {
                        $('.otp-error').html('Invalid OTP.');
                    }
                }
            })
        })
    </script>
   

<script>
let iti = null;

// FIX: safe init
function initPhoneInput() {
    const input = document.querySelector("#wiz-mobile-input");
    if (input && !iti && window.intlTelInput) {
        iti = window.intlTelInput(input, {
            initialCountry: "in",
            separateDialCode: true
        });
    }
}

// FIX: global function
window.openWizard = function () {
    console.log("OPEN WORKING ✅");

    const modal = document.getElementById('exactWizardModal');

    if (!modal) {
        console.error("Modal NOT FOUND ❌");
        return;
    }

    modal.style.display = 'block';
    document.body.style.overflow = 'hidden';

    initPhoneInput();
};

// BASIC STEP FUNCTION (safe)
function goToStep(step) {
    document.querySelectorAll('.wiz-page').forEach(p => p.classList.remove('active'));

    const page = document.getElementById('wiz-p' + step);
    if (page) page.classList.add('active');
}

// SAFE VALUE SET (NO ERROR)
function safeSetValue(id, value) {
    const el = document.getElementById(id);
    if (el) el.value = value; // ✅ correct (NO .value())
}

// EXAMPLE FIX USAGE
function updateFinalTime(timeStr) {
    safeSetValue('final-time', timeStr);
}
</script>
</body>

</html>