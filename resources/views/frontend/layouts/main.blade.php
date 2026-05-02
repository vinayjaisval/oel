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
    <meta property="og:url" content=https://www.overseaseducationlane.com />
    <meta property="og:description" content="Unlock your international education potential with Overseas Education Lane. Our dedicated consultants provide personalized support for your study abroad experience">
    <meta property="og:type" content="website">
    <meta property="og:image" content=https://www.overseaseducationlane.com/public/frontend/img/oel%20(1)%201.png>
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
            "@context": "https://schema.org",
            "@type": "Organization",
            "name": "Overseas Education Lane",
            "alternateName": "OEL",
            "url": "https://www.overseaseducationlane.com/",
            "logo": "https://www.overseaseducationlane.com/public/frontend/img/oel%20(1)%201.png",
            "sameAs": [
                "https://www.facebook.com/overseaseducationlane.oel/",
                "https://x.com/LaneEducation",
                "https://www.instagram.com/overseaseducation_lane/",
                "https://www.youtube.com/@OverseasEducationLane1",
                "https://www.linkedin.com/company/75765761/admin/dashboard/",
                "https://in.pinterest.com/Overseaseducationlane/",
                "https://www.overseaseducationlane.com/"
            ]
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

        /* --- 100% EXACT FULL-PAGE MATCH SPECIFICATIONS --- */
        .wizard-modal {
            display: none;
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: linear-gradient(to bottom, #e0ebff 0%, #ffffff 100%); /* Exact Gradient */
            z-index: 10000;
            overflow-y: auto;
        }

        .wizard-container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            min-height: 100vh;
            display: block;
            padding: 50px 20px;
            position: relative;
        }

        .wiz-top-logo { text-align: center; margin-bottom: 50px; }
        .wiz-top-logo img { max-width: 220px; }

        .wiz-header-main { text-align: center; margin-bottom: 60px; }
        .wiz-title-blue { font-size: 38px; font-weight: 800; color: #001d6e; margin-bottom: 12px; line-height: 1.1; }
        .wiz-title-red { font-size: 24px; font-weight: 800; color: #ff4d4d; text-transform: uppercase; letter-spacing: 2px; }

        .dest-grid { 
            display: grid; 
            grid-template-columns: repeat(4, 1fr); 
            gap: 15px; 
            max-width: 1050px; 
            margin: 0 auto; 
        }
        .dest-card { 
            background: #f1f1f1;
            border: 2px solid #000; 
            padding: 16px 20px; 
            border-radius: 12px; 
            cursor: pointer; 
            display: flex;
            align-items: center;
            gap: 12px;
            transition: all 0.2s ease;
            position: relative;
        }
        .dest-card:hover { 
            background: #fff;
        }

        .wizard-container {
            background: #fff;
            width: 90%;
            max-width: 850px;
            height: 550px;
            border-radius: 12px;
            display: flex;
            overflow: hidden;
            position: relative;
            box-shadow: 0 25px 50px rgba(0,0,0,0.3);
        }

        .wizard-sidebar {
            width: 30%;
            background: #f8f9fb;
            padding: 30px;
            border-right: 1px solid #eee;
            display: flex;
            flex-direction: column;
        }

        .wizard-sidebar h4 { color: #666; font-size: 14px; margin-bottom: 10px; }
        .wizard-sidebar h2 { color: #333; font-size: 22px; font-weight: 800; line-height: 1.2; }
        .wizard-sidebar .selection-info { margin-top: 30px; }
        .wizard-sidebar .info-item { margin-bottom: 15px; font-size: 14px; color: #555; display: flex; align-items: center; gap: 8px; }

        .wiz-page { display: none; }
        .wiz-page.active { display: block; animation: wizSlideUp 0.5s ease forwards; }
        @keyframes wizSlideUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }

        /* Mobile adjust */
        @media (max-width: 768px) {
            .wizard-sidebar { display: none; }
            .wizard-main { width: 100%; padding: 30px; }
            .dest-grid { grid-template-columns: 1fr 1fr; }
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
                                <li><a href="{{url('/testprepration')}}">IELTS/DET/TOEFL/PTE</a></li>
                                <li><a href="{{url('/meetoel')}}">Free Counseling</a></li>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"
        integrity="sha512-A7AYk1fGKX6S2SsHywmPkrnzTZHrgiVT7GcQkLGDe2ev0aWb8zejytzS8wjo7PGEXKqJOrjQ4oORtnimIRZBtw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

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
        const navLinks = document.getElementById("nav_links");
        const menuBtnIcon = menuBtn.querySelector("i");
        menuBtn.addEventListener("click", (e) => {
            navLinks.classList.toggle("open");

            const isOpen = navLinks.classList.contains("open");
            menuBtnIcon.setAttribute("class", isOpen ? "ri-close-line" : "ri-menu-line")
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#verify_otp').click(function() {
                $('#booking_enquiry').prop('disabled', false);
            });
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
    <!-- PREMIUM COUNSELING WIZARD MODAL -->
    <div id="exactWizardModal" class="wizard-modal">
        <span class="close-wiz" onclick="toggleExactWizard()">&times;</span>
        
        <div class="wizard-container">
            <div class="wiz-top-logo">
                <img src="{{ asset('frontend/img/logo.png') }}" alt="OEL Logo">
            </div>

            <!-- PAGE 1: DESTINATION -->
            <div id="wiz-p1" class="wiz-page active">
                <div class="wiz-header-main">
                    <h1 class="wiz-title-blue">Book Your Free Online Counselling & Start Your Study Abroad Journey</h1>
                    <h2 class="wiz-title-red">SELECT YOUR DREAM STUDY DESTINATION !</h2>
                </div>
                
                <div class="dest-grid">
                    <div class="dest-card" onclick="goPage2('USA')"><span class="dest-flag">🇺🇸</span><span class="dest-name">USA</span></div>
                    <div class="dest-card" onclick="goPage2('Canada')"><span class="dest-flag">🇨🇦</span><span class="dest-name">Canada</span></div>
                    <div class="dest-card" onclick="goPage2('United Kingdom')"><span class="dest-flag">🇬🇧</span><span class="dest-name">UK</span></div>
                    <div class="dest-card" onclick="goPage2('Ireland')"><span class="dest-flag">🇮🇪</span><span class="dest-name">Ireland</span></div>
                    <div class="dest-card" onclick="goPage2('Australia')"><span class="dest-flag">🇦🇺</span><span class="dest-name">Australia</span></div>
                    <div class="dest-card" onclick="goPage2('New Zealand')"><span class="dest-flag">🇳🇿</span><span class="dest-name">New Zealand</span></div>
                    <div class="dest-card" onclick="goPage2('Europe')"><span class="dest-flag">🇪🇺</span><span class="dest-name">Europe</span></div>
                    <div class="dest-card" onclick="goPage2('Asia')"><span class="dest-flag">🌏</span><span class="dest-name">Asia</span></div>
                </div>
                <div style="display:flex; justify-content:center; margin-top:15px;">
                    <div class="dest-card" style="width:250px; justify-content:center;" onclick="goPage2('Germany')"><span class="dest-flag">🇩🇪</span><span class="dest-name">Germany</span></div>
                </div>

                <div class="test-prep-section">
                    <h3 class="test-prep-title">Book Free Test Prep & Education Loan Counselling !</h3>
                    <div class="dest-grid" style="grid-template-columns: repeat(4, 1fr);">
                        <div class="dest-card" onclick="goPage2('IELTS')"><span class="dest-flag">📝</span><span class="dest-name">IELTS</span></div>
                        <div class="dest-card" onclick="goPage2('PTE')"><span class="dest-flag">📝</span><span class="dest-name">PTE</span></div>
                        <div class="dest-card" onclick="goPage2('GRE')"><span class="dest-flag">📝</span><span class="dest-name">GRE</span></div>
                        <div class="dest-card" onclick="goPage2('Loan')"><span class="dest-flag">💰</span><span class="dest-name">Education Loan</span></div>
                    </div>
                </div>
            </div>

            <!-- PAGE 2: SCHEDULE -->
            <div id="wiz-p2" class="wiz-page">
                <div style="text-align:center; margin-bottom:30px;">
                    <button class="btn btn-link text-decoration-none" onclick="backPage(1)" style="color:#003399; font-weight:700;">← Back to Destination</button>
                </div>
                <div class="wiz-header-main">
                    <h1 class="wiz-title-blue">When should we talk?</h1>
                    <p style="color:#666; font-size:18px;">Select a date and time for your free counseling session.</p>
                </div>
                <div class="dest-grid" style="grid-template-columns: repeat(2, 1fr); max-width:600px;">
                    <div class="dest-card" style="justify-content:center;" onclick="goPage3('10:00 AM')"><span class="dest-name">10:00 AM</span></div>
                    <div class="dest-card" style="justify-content:center;" onclick="goPage3('11:30 AM')"><span class="dest-name">11:30 AM</span></div>
                    <div class="dest-card" style="justify-content:center;" onclick="goPage3('02:00 PM')"><span class="dest-name">02:00 PM</span></div>
                    <div class="dest-card" style="justify-content:center;" onclick="goPage3('04:30 PM')"><span class="dest-name">04:30 PM</span></div>
                </div>
            </div>

            <!-- PAGE 3: DETAILS -->
            <div id="wiz-p3" class="wiz-page">
                <div style="text-align:center; margin-bottom:30px;">
                    <button class="btn btn-link text-decoration-none" onclick="backPage(2)" style="color:#003399; font-weight:700;">← Back to Schedule</button>
                </div>
                <div class="wiz-header-main">
                    <h1 class="wiz-title-blue">Almost there!</h1>
                    <p style="color:#666; font-size:18px;">Fill in your details to confirm your session.</p>
                </div>
                <div style="max-width:500px; margin:0 auto;">
                    <form action="{{ route('query') }}" method="POST">
                        @csrf
                        <input type="hidden" name="destination" id="f-dest">
                        <input type="hidden" name="schedule" id="f-time">
                        <div style="display:grid; gap:20px;">
                            <input type="text" name="name" placeholder="Full Name" required style="padding:18px; border-radius:12px; border:2px solid #000; font-weight:600;">
                            <input type="email" name="email" placeholder="Email Address" required style="padding:18px; border-radius:12px; border:2px solid #000; font-weight:600;">
                            <input type="text" name="mobile" placeholder="Phone Number" required style="padding:18px; border-radius:12px; border:2px solid #000; font-weight:600;">
                            <button type="submit" style="background:#FF6600; color:white; padding:20px; border-radius:12px; border:none; font-weight:800; font-size:20px; cursor:pointer;">Confirm Booking</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleExactWizard() {
            const modal = document.getElementById('exactWizardModal');
            modal.style.display = (modal.style.display === 'flex') ? 'none' : 'flex';
        }
        function openWizard() {
            toggleExactWizard();
        }
        function goPage2(dest) {
            document.getElementById('wiz-p1').classList.remove('active');
            document.getElementById('wiz-p2').classList.add('active');
            document.getElementById('step-1').classList.remove('active');
            document.getElementById('step-2').classList.add('active');
            document.getElementById('f-dest').value = dest;
        }
        function goPage3(time) {
            document.getElementById('wiz-p2').classList.remove('active');
            document.getElementById('wiz-p3').classList.add('active');
            document.getElementById('step-2').classList.remove('active');
            document.getElementById('step-3').classList.add('active');
            document.getElementById('f-time').value = time;
        }
        function backPage(page) {
            document.querySelectorAll('.wiz-page').forEach(p => p.classList.remove('active'));
            document.getElementById('wiz-p' + page).classList.add('active');
            document.querySelectorAll('.wiz-step').forEach(s => s.classList.remove('active'));
            document.getElementById('step-' + page).classList.add('active');
        }
    </script>
</body>

</html>