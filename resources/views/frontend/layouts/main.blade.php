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
            background: #fff !important;
            color: #FF6600 !important;
            border: 1px solid #FF6600 !important;
            transition: all 0.3s ease;
        }
        .counseling-btn-header:hover {
            background: #FF6600 !important;
            color: #fff !important;
        }
        
        .oel-logo img { max-width: 150px; height: auto; }

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
            margin: 0 auto;
            min-height: 100vh;
            padding: 0 20px 150px;
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
        .wiz-form-group { margin-bottom: 25px; }
        .wiz-form-label { display: block; font-weight: 700; color: #1e293b; margin-bottom: 10px; font-size: 15px; }
        .wiz-input {
            width: 100%;
            padding: 16px 16px 16px 50px;
            background: #f9f9f9;
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            font-weight: 500;
            font-size: 16px;
        }

        .wiz-page { display: none; width: 100%; }
        .wiz-page.active { display: block; animation: fadeIn 0.4s ease; }

        @media (max-width: 992px) {
            .dest-grid-exact { grid-template-columns: repeat(2, 1fr); }
            .wiz-split-container { flex-direction: column; }
            .wiz-side-info { width: 100%; }
        }
    </style>

    </style>

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
                    <a href="javascript:void(0)" onclick="openWizard()" class="apply-btn rounded fn border-0 text-decoration-none counseling-btn-header">
                        <i class="fa fa-video-camera me-1"></i> Book Online Counselling
                    </a>
                </li>


                <div class="students_img "><img src="{{ asset('frontend/img/new-list.png') }}">
                </div>
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
                                <li><a href="javascript:openWizard()">IELTS/DET/TOEFL/PTE</a></li>
                                <li><a href="javascript:openWizard()">Free Counseling</a></li>
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

                        <div style="margin-bottom: 24px; display: flex; align-items: center; gap: 8px;">
                            <i class="fa fa-globe" style="color: #1e293b; font-size: 16px;"></i>
                            <select style="width: 100%; border: none; background: transparent; color: #1e293b; font-size: 14px; cursor: pointer; outline: none; padding: 0; font-weight: 600;">
                                <option value="GMT-11:00">(GMT-11:00) Midway Island, Samoa</option>
                                <option value="GMT-10:00">(GMT-10:00) Hawaii</option>
                                <option value="GMT-08:00">(GMT-08:00) Alaska</option>
                                <option value="GMT-07:00">(GMT-07:00) Dawson, Yukon</option>
                                <option value="GMT-07:00">(GMT-07:00) Arizona</option>
                                <option value="GMT-07:00">(GMT-07:00) Tijuana</option>
                                <option value="GMT-07:00">(GMT-07:00) Pacific Time</option>
                                <option value="GMT-06:00">(GMT-06:00) Mountain Time</option>
                                <option value="GMT-06:00">(GMT-06:00) Saskatchewan</option>
                                <option value="GMT-05:00">(GMT-05:00) Central Time</option>
                                <option value="GMT-05:00">(GMT-05:00) Bogota, Lima, Quito</option>
                                <option value="GMT-04:00">(GMT-04:00) Eastern Time</option>
                                <option value="GMT-04:00">(GMT-04:00) Caracas, La Paz</option>
                                <option value="GMT-03:30">(GMT-03:30) Newfoundland</option>
                                <option value="GMT-03:00">(GMT-03:00) Brasilia</option>
                                <option value="GMT-03:00">(GMT-03:00) Buenos Aires, Georgetown</option>
                                <option value="GMT-02:00">(GMT-02:00) Mid-Atlantic</option>
                                <option value="GMT-01:00">(GMT-01:00) Azores</option>
                                <option value="GMT-01:00">(GMT-01:00) Cape Verde Is.</option>
                                <option value="GMT+00:00">(GMT+00:00) Casablanca, Monrovia</option>
                                <option value="GMT+00:00">(GMT+00:00) Greenwich Mean Time : Dublin, Edinburgh, Lisbon, London</option>
                                <option value="GMT+01:00">(GMT+01:00) Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna</option>
                                <option value="GMT+01:00">(GMT+01:00) Belgrade, Bratislava, Budapest, Ljubljana, Prague</option>
                                <option value="GMT+01:00">(GMT+01:00) Brussels, Copenhagen, Madrid, Paris</option>
                                <option value="GMT+01:00">(GMT+01:00) Sarajevo, Skopje, Warsaw, Zagreb</option>
                                <option value="GMT+01:00">(GMT+01:00) West Central Africa</option>
                                <option value="GMT+02:00">(GMT+02:00) Athens, Istanbul, Minsk</option>
                                <option value="GMT+02:00">(GMT+02:00) Bucharest</option>
                                <option value="GMT+02:00">(GMT+02:00) Cairo</option>
                                <option value="GMT+02:00">(GMT+02:00) Harare, Pretoria</option>
                                <option value="GMT+02:00">(GMT+02:00) Helsinki, Kyiv, Riga, Tallinn, Vilnius, Vilnius</option>
                                <option value="GMT+02:00">(GMT+02:00) Jerusalem</option>
                                <option value="GMT+03:00">(GMT+03:00) Baghdad</option>
                                <option value="GMT+03:00">(GMT+03:00) Kuwait, Riyadh</option>
                                <option value="GMT+03:00">(GMT+03:00) Moscow, St. Petersburg, Volgograd</option>
                                <option value="GMT+03:00">(GMT+03:00) Nairobi</option>
                                <option value="GMT+03:30">(GMT+03:30) Tehran</option>
                                <option value="GMT+04:00">(GMT+04:00) Abu Dhabi, Muscat</option>
                                <option value="GMT+04:00">(GMT+04:00) Baku, Tbilisi, Yerevan</option>
                                <option value="GMT+04:30">(GMT+04:30) Kabul</option>
                                <option value="GMT+05:00">(GMT+05:00) Ekaterinburg</option>
                                <option value="GMT+05:00">(GMT+05:00) Islamabad, Karachi, Tashkent</option>
                                <option value="GMT+05:30" selected>(GMT+5:30) Chennai, Kolkata, Mumbai, New Delhi</option>
                                <option value="GMT+05:45">(GMT+05:45) Kathmandu</option>
                                <option value="GMT+06:00">(GMT+06:00) Almaty, Novosibirsk</option>
                                <option value="GMT+06:00">(GMT+06:00) Astana, Dhaka</option>
                                <option value="GMT+06:00">(GMT+06:00) Sri Jayawardenepura</option>
                                <option value="GMT+06:30">(GMT+06:30) Rangoon</option>
                                <option value="GMT+07:00">(GMT+07:00) Bangkok, Hanoi, Jakarta</option>
                                <option value="GMT+07:00">(GMT+07:00) Krasnoyarsk</option>
                                <option value="GMT+08:00">(GMT+08:00) Beijing, Chongqing, Hong Kong, Urumqi</option>
                                <option value="GMT+08:00">(GMT+08:00) Irkutsk, Ulaan Bataar</option>
                                <option value="GMT+08:00">(GMT+08:00) Kuala Lumpur, Singapore</option>
                                <option value="GMT+08:00">(GMT+08:00) Perth</option>
                                <option value="GMT+08:00">(GMT+08:00) Taipei</option>
                                <option value="GMT+09:00">(GMT+09:00) Osaka, Sapporo, Tokyo</option>
                                <option value="GMT+09:00">(GMT+09:00) Seoul</option>
                                <option value="GMT+09:00">(GMT+09:00) Yakutsk</option>
                                <option value="GMT+09:30">(GMT+09:30) Adelaide</option>
                                <option value="GMT+09:30">(GMT+09:30) Darwin</option>
                                <option value="GMT+10:00">(GMT+10:00) Brisbane</option>
                                <option value="GMT+10:00">(GMT+10:00) Canberra, Melbourne, Sydney</option>
                                <option value="GMT+10:00">(GMT+10:00) Guam, Port Moresby</option>
                                <option value="GMT+10:00">(GMT+10:00) Hobart</option>
                                <option value="GMT+10:00">(GMT+10:00) Vladivostok</option>
                                <option value="GMT+11:00">(GMT+11:00) Magadan, Solomon Is., New Caledonia</option>
                                <option value="GMT+12:00">(GMT+12:00) Auckland, Wellington</option>
                                <option value="GMT+12:00">(GMT+12:00) Fiji, Kamchatka, Marshall Is.</option>
                                <option value="GMT+13:00">(GMT+13:00) Nuku'alofa</option>
                            </select>
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
                        <div class="wiz-back-btn" onclick="goToStep(2)">
                            <i class="fa fa-arrow-left"></i>
                        </div>
                        <div style="margin-bottom: 24px;">
                            <div style="color: #64748b; font-weight: 700; text-transform: capitalize; margin-bottom: 8px; font-size: 14px;">Overseas Education Lane</div>
                            <div id="side-dest-name-final" style="color: #1e293b; font-weight: 700; font-size: 26px; line-height: 1.2;">USA</div>
                        </div>
                        <div class="wiz-side-meta">
                            <div style="color:#2563eb; font-weight:700;"><span id="text-selected-time-final"></span></div>
                        </div>
                    </div>
                    <div class="wiz-main-action" style="flex: 1; padding: 60px 30px 20px; display:flex; flex-direction:column; background: #fff;">
                        <div class="wiz-main-title" style="margin-bottom: 20px; display:flex; align-items:center; gap: 12px;">
                            <img src="https://overseaseducationlane.com/public/frontend/img/oel%20(1)%201.png" class="wiz-counselor-avatar" style="width: 32px; height: 32px; background:#f1f5f9; padding:2px; border-radius: 4px;">
                            <span style="font-size: 18px; font-weight: 700; color: #1e293b;">Please help me with some details</span>
                        </div>
                        
                        <form action="{{ route('query') }}" method="POST">
                            @csrf
                            <input type="hidden" name="destination" id="final-dest">
                            <input type="hidden" name="schedule" id="final-time">
                            
                            <div class="wiz-form-group">
                                <label class="wiz-form-label">Name *</label>
                                <div class="wiz-input-wrapper">
                                    <i class="fa fa-user"></i>
                                    <input type="text" name="name" class="wiz-input" placeholder="Enter your name" required>
                                </div>
                            </div>
                            
                            <div class="wiz-form-group">
                                <label class="wiz-form-label">Email *</label>
                                <div class="wiz-input-wrapper">
                                    <i class="fa fa-envelope"></i>
                                    <input type="email" name="email" class="wiz-input" placeholder="Enter your email" required>
                                </div>
                            </div>
                            
                            <div class="wiz-form-group">
                                <label class="wiz-form-label">Your City *</label>
                                <div class="wiz-input-wrapper">
                                    <i class="fa fa-map-marker"></i>
                                    <select name="city" class="wiz-input" style="padding-left:45px; -webkit-appearance: none;" required>
                                        <option value="">Select City...</option>
                                        <option>Mumbai</option>
                                        <option>Delhi</option>
                                        <option>Bangalore</option>
                                        <option>Hyderabad</option>
                                        <option>Pune</option>
                                        <option>Other</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="wiz-form-group">
                                <label class="wiz-form-label">Phone Number *</label>
                                <div class="wiz-input-wrapper">
                                    <i class="fa fa-phone"></i>
                                    <input type="tel" name="mobile" class="wiz-input" placeholder="+91" required>
                                </div>
                            </div>

                            <button type="submit" class="wiz-confirm-btn" style="margin-top:10px;">Schedule Event</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        let selectedDestName = "";
        let selectedDayVal = "Mon 4";
        let selectedTimeVal = "";

        function toggleExactWizard() {
            const modal = document.getElementById('exactWizardModal');
            if (modal.style.display === 'block') {
                modal.style.display = 'none';
                document.body.style.overflow = 'auto';
            } else {
                modal.style.display = 'block';
                document.body.style.overflow = 'hidden';
                goToStep(1);
            }
        }

        function openWizard() {
            toggleExactWizard();
        }

        function goToStep(step) {
            document.querySelectorAll('.wiz-page').forEach(p => p.classList.remove('active'));
            document.getElementById('wiz-p' + step).classList.add('active');
            
            // Toggle wave background only on step 1
            const wave = document.getElementById('wiz-wave');
            if (step === 1) {
                wave.style.display = 'block';
            } else {
                wave.style.display = 'none';
            }
        }

        function selectDest(dest) {
            selectedDestName = dest;
            document.getElementById('side-dest-name').innerText = dest;
            document.getElementById('side-dest-name-final').innerText = dest;
            document.getElementById('final-dest').value = dest;
            goToStep(2);
        }

        function selectDay(el, day) {
            document.querySelectorAll('.cal-day-col').forEach(d => d.classList.remove('active'));
            el.classList.add('active');
            selectedDayVal = day;
            updateTimeDisplay();
        }

        function selectTime(el, time) {
            document.querySelectorAll('.time-slot').forEach(t => t.classList.remove('active'));
            el.classList.add('active');
            selectedTimeVal = time;
            document.getElementById('confirm-time-btn').disabled = false;
            updateTimeDisplay();
        }

        function updateTimeDisplay() {
            const timeStr = selectedTimeVal + ", " + selectedDayVal + ", May 2026";
            document.getElementById('side-selected-time').style.display = selectedTimeVal ? 'flex' : 'none';
            document.getElementById('text-selected-time').innerText = timeStr;
            document.getElementById('text-selected-time-final').innerText = timeStr;
            document.getElementById('final-time').value = timeStr;
        }

        let selectedFullDate = null;
        let timeSlotsOffset = 0;
        const allTimeSlots = [
            '10:30 AM', '11:00 AM', '11:30 AM', '12:00 PM', '12:30 PM', '01:00 PM', '01:30 PM', '02:00 PM',
            '02:30 PM', '03:00 PM', '03:30 PM', '04:00 PM', '04:30 PM', '05:00 PM', '05:30 PM', '06:00 PM'
        ];
        let availableSlots = [];

        function selectDay(el, dayStr, fullDate) {
            document.querySelectorAll('.cal-day-col').forEach(c => c.classList.remove('active'));
            el.classList.add('active');
            selectedDayVal = dayStr;
            selectedFullDate = fullDate;
            timeSlotsOffset = 0;
            updateTimeSlotsUI();
            updateTimeDisplay();
        }

        function updateTimeSlotsUI() {
            const container = document.getElementById('time-slots-container');
            if(!container) return;
            
            // Filter out past times if the selected date is today
            let today = new Date();
            let isToday = selectedFullDate && selectedFullDate.toDateString() === today.toDateString();
            
            availableSlots = allTimeSlots.filter(slot => {
                if (!isToday) return true;
                
                let [time, modifier] = slot.split(' ');
                let [hours, minutes] = time.split(':');
                if (hours === '12') hours = '00';
                if (modifier === 'PM') hours = parseInt(hours, 10) + 12;
                
                let slotDate = new Date(selectedFullDate);
                slotDate.setHours(hours, minutes, 0, 0);
                return slotDate > today;
            });

            renderVisibleSlots();
        }

        function renderVisibleSlots() {
            const container = document.getElementById('time-slots-container');
            container.innerHTML = '';
            
            let visible = availableSlots.slice(timeSlotsOffset, timeSlotsOffset + 3);
            visible.forEach(slot => {
                let btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'time-slot' + (selectedTimeVal === slot ? ' active' : '');
                btn.innerText = slot;
                btn.onclick = function() { selectTime(this, slot); };
                container.appendChild(btn);
            });

            document.getElementById('time-prev-btn').style.opacity = timeSlotsOffset <= 0 ? '0.3' : '1';
            document.getElementById('time-next-btn').style.opacity = (timeSlotsOffset + 3 >= availableSlots.length) ? '0.3' : '1';
        }

        function shiftTimeSlots(dir) {
            let next = timeSlotsOffset + (dir * 3);
            if (next >= 0 && next < availableSlots.length) {
                timeSlotsOffset = next;
                renderVisibleSlots();
            }
        }

        let startDay = new Date();
        function updateCalendarDays() {
            const days = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
            const row = document.getElementById('cal-week-row-container');
            if(!row) return;
            row.innerHTML = '';
            let tempDate = new Date(startDay);
            
            let dayOfWeek = tempDate.getDay();
            let diff = tempDate.getDate() - dayOfWeek + (dayOfWeek === 0 ? -6 : 1);
            tempDate.setDate(diff);

            let today = new Date();
            today.setHours(0,0,0,0);

            for (let i = 0; i < 7; i++) {
                let dNum = tempDate.getDate();
                let dName = days[tempDate.getDay()];
                let isPast = tempDate < today;
                
                let col = document.createElement('div');
                col.className = 'cal-day-col';
                let dateCopy = new Date(tempDate);
                if(isPast) {
                    col.style.opacity = '0.3';
                    col.style.cursor = 'default';
                    col.style.pointerEvents = 'none';
                } else {
                    if (i === 0 && !selectedDayVal) {
                        col.classList.add('active');
                        selectedDayVal = dName + ' ' + dNum;
                        selectedFullDate = dateCopy;
                    }
                    col.onclick = function() { selectDay(this, dName + ' ' + dNum, dateCopy); };
                }
                
                col.innerHTML = `<div class="cal-day-name">${dName}</div>
                                 <div class="cal-day-num"><span>${dNum}</span><div class="cal-day-dot"></div></div>`;
                row.appendChild(col);
                tempDate.setDate(tempDate.getDate() + 1);
            }
            updateTimeSlotsUI();
        }

        function shiftWeek(dir) {
            startDay.setDate(startDay.getDate() + (dir * 7));
            updateCalendarDays();
            
            let today = new Date();
            let weekLabel = document.getElementById('week-label');
            if (Math.abs(startDay - today) < 7 * 24 * 60 * 60 * 1000 && startDay.getDay() >= today.getDay()) {
                weekLabel.innerText = "This week";
            } else {
                weekLabel.innerText = "Next week";
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            updateCalendarDays();
        });
    </script>

</body>

</html>