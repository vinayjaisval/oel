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
                        <!-- <li><a href="{{ route('program-offered') }}">Courses Offered</a></li> -->
                        <li><a href="{{ route('contact_us') }}">Contact Us</a></li>
                        <li><a class="apply-btn rounded fn border-0 p-2" href="{{ route('check-eligible') }}"> Quick Search</a></li>
                        <li><a class="apply-btn rounded fn border-0 p-2" data-bs-toggle="modal" data-bs-target="#exampleModal"> Check My Eligibility</a>
                        </li>
                        <li><button class="rounded apply-btn fn border-0 p-2" onclick="openWizard()" style="background-color: red;">
                               <i class="fa-solid fa-video"></i>
                                Book Online Counselling                            </button>
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
                        <div class="students_img ">
                            <img src="{{ asset('frontend/img/new-list.png') }}">
                        </div>
                   </ul>
                    <div class="nav_menu_btn" id="menu_btn">
                        <span><i class="ri-menu-line" onclick="toggleMenu()"></i></span>
                    </div>
                </nav>
            </div>
        </div>
    </section>
    @include('frontend.layouts.onlinemeeting')

    @yield('content')
   /// footer section
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


   //modal section
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"
        integrity="sha512-A7AYk1fGKX6S2SsHywmPkrnzTZHrgiVT7GcQkLGDe2ev0aWb8zejytzS8wjo7PGEXKqJOrjQ4oORtnimIRZBtw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11.0.5/swiper-bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

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
    $(document).ready(function () {

        // SEND OTP
        $(document).on('click', '#verify_otp', function () {

            let mobile = $('#mobile_number').val();

            if (!mobile || mobile.length != 10) {
                alert('Enter valid 10 digit mobile number');
                return;
            }

            $.ajax({
                url: "{{ route('send-otp') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    phone_number: mobile
                },
                success: function (res) {

                    if (res.success) {
                        $('.otp-verify').show();
                        $('.error-phone').text('');
                        alert('OTP Sent');
                    } else {
                        $('.error-phone').text(res.message);
                    }
                }
            });

        });


        // VERIFY OTP + REDIRECT
        $(document).on('click', '#booking_enquiry', function () {

            $.ajax({
                url: "{{ route('verify-otp') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    phone_number: $('#mobile_number').val(),
                    full_name: $('#full_name').val(),
                    email: $('#email_name').val(),
                    otp: $('#otp').val()
                },

                success: function (res) {

                    if (res.success) {

                        window.location.href = "{{ route('check-eligibility') }}";

                    } else {
                        $('.otp-error').text(res.message);
                    }
                }

            });

        });

    });
  </script>

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