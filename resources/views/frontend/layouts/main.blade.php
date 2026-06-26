<!DOCTYPE html>
<html lang="en">

<head>

    <title>@yield('title','Overseas Education Lane')</title>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="description"
        content="@yield('meta_description',
      'Overseas Education Lane can help you learn about your options for international education.')">

    <meta name="keywords"
        content="@yield('meta_keywords','Study Abroad Consultant')">

    <link rel="canonical"
        href="{{ url()->current() }}" />

    <meta property="og:title"
        content="@yield('og_title', View::yieldContent('title'))">

    <meta property="og:description"
        content="@yield('og_description', View::yieldContent('meta_description'))">

    <meta property="og:url"
        content="{{ url()->current() }}">

    <meta property="og:type"
        content="website">

    <meta property="og:image"
        content="@yield('og_image', asset('frontend/img/default-og.jpg'))">

    <meta name="twitter:card"
        content="summary_large_image">

    <meta name="twitter:title"
        content="@yield('title','Overseas Education Lane')">

    <meta name="twitter:description"
        content="@yield('meta_description')">

    <meta name="twitter:image"
        content="@yield('og_image', asset('frontend/img/default-og.jpg'))">
    <link rel="stylesheet" href="{{asset('frontend/css/style.css')}}">
    <link id="favicon" rel="shortcut icon" type="image/png" href="https://www.overseaseducationlane.com/public/frontend/img/oel (1) 1.png" />
    <link rel="canonical" href="{{ url()->current() }}" />
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
        }
    </script>
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
                                Book Online Counselling </button>
                        </li>
                        <li>
                            @if(Auth::check())
                            <a href="{{ route('dashboard') }}">
                                <img src="{{ Auth::user()->profile_image ? asset('storage/' . Auth::user()->profile_image) : asset('frontend/images/user.png') }}"
                                    alt="User"
                                    class="rounded-circle"
                                    style="width:40px; height:40px; object-fit:cover;">
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

   <section>
    <div class="bottom_footer bv_cs py-5">
        <div class="container text-white">

            <div class="row g-4">

                <!-- Other Links -->
                <div class="col-lg-3 col-md-6">
                    <div class="bottom_heading_fooet">
                        <h5 class="text-uppercase fw-bold">Other Links</h5>

                        <ul class="footer-links mt-3">
                            <li><a href="{{ route('about-oel') }}">About OEL</a></li>
                            <li><a href="{{ route('contact_us') }}">Contact Us</a></li>
                            <li><a href="{{ route('all-blogs') }}">Blogs</a></li>
                            <li><a href="{{ route('testimonials') }}">Testimonials</a></li>
                            <li><a href="{{ route('frequently-asked-questions') }}">FAQ</a></li>
                            <li><a href="{{ route('privacy-policy') }}">Privacy Policy</a></li>
                            <li><a href="{{ route('terms-and-conditions') }}">Terms & Conditions</a></li>
                            <li><a href="{{ route('user-login') }}">Franchise Login</a></li>
                            <li><a href="{{ route('user-login') }}">Counselor Login</a></li>
                            <li><a href="{{ route('user-login') }}">Student Login</a></li>
                            <li><a href="{{ route('landing-page') }}">Apply Now</a></li>
                        </ul>
                    </div>
                </div>

                <!-- Top Destination -->
                <div class="col-lg-3 col-md-6">
                    <div class="bottom_heading_fooet">
                        <h5 class="text-uppercase fw-bold">Top Destinations</h5>

                        <ul class="footer-links mt-3">
                            <li><a href="{{url('universities?country=Canada')}}">Canada</a></li>
                            <li><a href="{{url('universities?country=United States')}}">USA</a></li>
                            <li><a href="{{url('universities?country=Australia')}}">Australia</a></li>
                            <li><a href="{{url('universities?country=United Kingdom')}}">United Kingdom</a></li>
                            <li><a href="{{url('universities?country=New Zealand')}}">New Zealand</a></li>
                            <li><a href="{{url('universities?country=South Korea')}}">South Korea</a></li>
                            <li><a href="{{url('universities?country=Japan')}}">Japan</a></li>
                            <li><a href="{{url('universities?country=Italy')}}">Italy</a></li>
                            <li><a href="{{url('universities?country=Russia')}}">Russia</a></li>
                            <li><a href="{{url('universities?country=Ireland')}}">Ireland</a></li>
                            <li><a href="{{url('universities?country=Germany')}}">Germany</a></li>
                        </ul>
                    </div>
                </div>

                <!-- Services -->
                <div class="col-lg-3 col-md-6">
                    <div class="bottom_heading_fooet">
                        <h5 class="text-uppercase fw-bold">Our Services</h5>

                        <ul class="footer-links mt-3">
                            <li><a href="{{url('/testprepration')}}">IELTS / DET / TOEFL / PTE</a></li>
                            <li><a href="{{url('/meetoel')}}">Free Counseling</a></li>
                            <li><a href="{{url('/resumeevaluation')}}">LOR Assistance</a></li>
                            <li><a href="{{url('/resumeevaluation')}}">SOP Assistance</a></li>
                            <li><a href="{{url('/pretestprepration')}}">Other Exams</a></li>
                            <li><a href="{{url('/financialcounselling')}}">Education Loan</a></li>
                            <li><a href="{{url('/foreignexchange')}}">Forex Services</a></li>
                            <!-- <li><a href="{{url('/admissionguidance')}}">Scholarships</a></li> -->
                        </ul>
                    </div>
                </div>

                <!-- Address -->
                <div class="col-lg-3 col-md-6">
                    <div class="bottom_heading_fooet">
                        <h5 class="text-uppercase fw-bold">Contact Us</h5>

                        <ul class="footer-links mt-3">

                            <li class="d-flex align-items-start">
                                <img src="{{ asset('frontend/img/address.png') }}"
                                     width="18"
                                     height="18"
                                     class="mt-1">
                                <span class="ms-2">
                                    Overseas Education Lane
                                </span>
                            </li>

                            <li class="d-flex align-items-center">
                                <img src="{{ asset('frontend/img/phone.png') }}"
                                     width="18"
                                     height="18">

                                <a href="tel:+91892992525" class="ms-2">
                                    +91 892 992 2525
                                </a>
                            </li>

                            <li class="d-flex align-items-center">
                                <img src="{{ asset('frontend/img/enveloper.png') }}"
                                     width="18"
                                     height="18">

                                <a href="mailto:info@overseaseducationlane.com"
                                   class="ms-2">
                                    info@overseaseducationlane.com
                                </a>
                            </li>

                            <li class="d-flex align-items-center">
                                <img src="{{ asset('frontend/img/enveloper.png') }}"
                                     width="18"
                                     height="18">

                                <a href="mailto:help@overseaseducationlane.com"
                                   class="ms-2">
                                    help@overseaseducationlane.com
                                </a>
                            </li>

                        </ul>
                    </div>
                </div>

            </div>

            <hr class="border-light my-4">

            <!-- Bottom Footer -->
            <div class="sub-footer d-flex flex-column flex-md-row justify-content-between align-items-center text-center text-md-start">

                <div class="sub-right mb-3 mb-md-0">
                    <h6 class="mb-0">
                        © {{ date('Y') }}
                        <span class="fw-bold">Overseas Education Lane</span>.
                        All Rights Reserved.
                    </h6>
                </div>

                <div class="sub-left d-flex gap-3">

                    <a href="https://www.facebook.com/overseaseducationlane.oel/" target="_blank">
                        <i class="fa-brands fa-facebook-f"></i>
                    </a>

                    <a href="https://in.linkedin.com/in/overseaseducationlane?trk=public_profile_samename-profile" target="_blank">
                        <i class="fa-brands fa-linkedin-in"></i>
                    </a>

                    <a href="https://www.youtube.com/@OverseasEducationLane1" target="_blank">
                        <i class="fa-brands fa-youtube"></i>
                    </a>

                    <a href="https://www.instagram.com/overseaseducation_lane/" target="_blank">
                        <i class="fa-brands fa-instagram"></i>
                    </a>

                    <a href="https://twitter.com/LaneEducation" target="_blank">
                        <i class="fa-brands fa-x-twitter"></i>
                    </a>

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
                                                pattern="[0-9]{10}" placeholder="Mobile number" id="mobile_number" required oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);">
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
                                        aria-describedby="emailHelp" placeholder="Enter otp" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 6);">
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
        $(document).ready(function() {

            // SEND OTP
            $(document).on('click', '#verify_otp', function() {

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
                    success: function(res) {

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
            $(document).on('click', '#booking_enquiry', function() {

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

                    success: function(res) {

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

</body>

</html>