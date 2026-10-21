
<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Book Meeting</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>

   
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        body{
            font-family:Arial,sans-serif;
            background:#f8fafc;
        }

        .hero{
            width:100%;
            min-height:100vh;
            display:flex;
            align-items:center;
            justify-content:center;
            flex-direction:column;
            text-align:center;
            padding:20px;
        }

        .hero img{
            height:90px;
            margin-bottom:20px;
        }

        .hero h1{
            font-size:42px;
            color:#1e3a8a;
            margin-bottom:15px;
            font-weight:800;
        }

        .hero p{
            max-width:650px;
            line-height:1.7;
            color:#64748b;
        }

        .book-btn{
            margin-top:30px;
            background:#1e3a8a;
            color:#fff;
            border:none;
            padding:18px 45px;
            border-radius:50px;
            font-size:18px;
            cursor:pointer;
            font-weight:700;
        }

        .wizard-modal{
            position:fixed;
            top:0;
            left:0;
            width:100%;
            height:100%;
            background:rgba(0,0,0,.6);
            z-index:9999;
            overflow:auto;
            display:none;
            padding:20px;
        }

        .wizard-container{
            max-width:1200px;
            margin:auto;
            background:#fff;
            border-radius:20px;
            overflow:hidden;
            position:relative;
        }

        .wizard-close{
            position:absolute;
            top:20px;
            right:20px;
            width:42px;
            height:42px;
            border-radius:50%;
            background:#fff;
            display:flex;
            align-items:center;
            justify-content:center;
            cursor:pointer;
            box-shadow:0 4px 12px rgba(0,0,0,.1);
            z-index:999;
        }

        .wiz-page{
            display:none;
        }

        .wiz-page.active{
            display:block;
        }

        .dest-header{
            padding:40px 20px 20px;
            text-align:center;
        }

        .dest-header h2{
            color:#1e3a8a;
            font-size:34px;
        }

        .section-title{
            text-align:center;
            font-size:20px;
            font-weight:700;
            color:#1e3a8a;
            margin:30px 0 20px;
        }

        .dest-grid{
            display:grid;
            grid-template-columns:repeat(auto-fit,minmax(180px,1fr));
            gap:18px;
            padding:0 30px 40px;
        }

        .dest-card{
            border:1px solid #e2e8f0;
            border-radius:18px;
            padding:20px;
            text-align:center;
            cursor:pointer;
            transition:.3s;
        }

        .dest-card:hover{
            transform:translateY(-4px);
            box-shadow:0 10px 25px rgba(0,0,0,.08);
        }

        .dest-card img{
            width:65px;
            height:65px;
            object-fit:cover;
            margin-bottom:12px;
        }

        .dest-card span{
            display:block;
            font-weight:700;
        }

        .wiz-split{
            display:flex;
            min-height:700px;
        }

        .wiz-sidebar{
            width:32%;
            background:#fff;
            padding:25px 30px;
            border-right:1px solid #e2e8f0;
        }

        .wiz-main{
            width:68%;
            padding:25px 40px;
        }

        .back-btn{
            width:42px;
            height:42px;
            background:#fff;
            border:1px solid #e2e8f0;
            border-radius:50%;
            display:flex;
            align-items:center;
            justify-content:center;
            cursor:pointer;
            margin-bottom:25px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }

        .sidebar-title{
            font-size:22px;
            font-weight:800;
            color:#1e3a8a;
            white-space: nowrap;
        }

        .sidebar-country{
            color:#226cf5;
            font-size:22px;
            margin-top:10px;
            font-weight:700;
        }

        .sidebar-list{
            list-style:none;
            margin-top:30px;
        }

        .sidebar-list li{
            margin-bottom:18px;
            line-height:1.7;
            color:#475569;
            display:flex;
            gap:10px;
        }

        .sidebar-list i{
            color:#226cf5;
            margin-top:4px;
        }

        .main-title{
            font-size:28px;
            font-weight:800;
            margin-bottom:15px;
        }

        .calendar-row{
            display:flex;
            gap:12px;
            flex-wrap:wrap;
        }

        .day-box{
            width:85px;
            padding:15px;
            border:1px solid #cbd5e1;
            border-radius:14px;
            text-align:center;
            cursor:pointer;
        }

        .day-box.active{
            background:#226cf5;
            color:#fff;
        }

        .slots{
            margin-top:25px;
            display:grid;
            grid-template-columns:repeat(auto-fit,minmax(120px,1fr));
            gap:15px;
        }

        .slot{
            padding:14px;
            border:1px solid #226cf5;
            border-radius:12px;
            text-align:center;
            cursor:pointer;
            color:#226cf5;
            font-weight:700;
        }

        .slot.active{
            background:#226cf5;
            color:#fff;
        }

        .confirm-btn{
            margin-top:30px;
            width:220px;
            height:50px;
            border:none;
            border-radius:14px;
            background:#226cf5;
            color:#fff;
            font-size:16px;
            font-weight:700;
            cursor:pointer;
        }

        .form-group{
            margin-bottom:10px;
        }

        .form-group label{
            display:block;
            margin-bottom:5px;
            font-weight:700;
        }

        .form-control{
            width:100%;
            height:52px;
            border:1px solid #cbd5e1;
            border-radius:14px;
            padding:0 15px;
            transition: all 0.25s ease-in-out;
            outline: none !important;
        }

        .form-control:hover, .custom-counselor-selected:hover{
            border-color: #94a3b8;
        }

        .form-control:focus, .custom-counselor-selected.active-focus{
            border-color: #94a3b8;
            box-shadow: none !important;
            outline: none !important;
            background-color: #fff;
        }

        .success-box{
            text-align:center;
            padding:70px 20px;
        }

        .success-box h2{
            font-size:36px;
            margin-bottom:20px;
        }

        .meeting-link{
            margin-top:20px;
            background:#f1f5f9;
            padding:15px;
            border-radius:10px;
            word-break:break-all;
        }

        .meeting-link a{
            color:#226cf5;
            font-weight:700;
            text-decoration:none;
        }

        @media(max-width:900px){

            .wiz-split{
                flex-direction:column;
            }

            .wiz-sidebar,
            .wiz-main{
                width:100%;
            }
        }

    
        #state-dropdown-wrapper .custom-counselor-selected,
        #city-dropdown-wrapper .custom-counselor-selected {
            width:100%; text-align:left; font:inherit;
        }
        #state-dropdown-wrapper .custom-counselor-selected:disabled,
        #city-dropdown-wrapper .custom-counselor-selected:disabled {
            background:#f8fafc; cursor:not-allowed;
        }
        #state_options, #city_options { max-height:none; overflow:hidden; }
        .booking-location-search { padding:10px; border-bottom:1px solid #e2e8f0; background:#fff; }
        .booking-location-search .form-control { height:40px; border-radius:8px; font:inherit; }
        .booking-location-results { max-height:210px; overflow-y:auto; }
        .booking-location-empty { padding:12px 15px; color:#64748b; font-size:14px; }
        .booking-location-results .custom-counselor-option[hidden],
        .booking-location-empty[hidden] { display:none; }
        #locationError { display:block; color:#dc2626; margin-top:6px; }
        #locationError[hidden] { display:none; }

    </style>

</head>
<body>



<div class="wizard-modal" id="wizardModal">

    <div class="wizard-container">

        <div class="wizard-close" onclick="closeWizard()">
            <i class="fa fa-times"></i>
        </div>

        {{-- STEP 1 --}}
      {{-- REPLACE ONLY STEP 1 CODE WITH THIS --}}

{{-- STEP 1 --}}
<div class="wiz-page active" id="step1">

    {{-- CLOSE BUTTON --}}
    <div class="wizard-close" onclick="closeWizard()">
        <i class="fa fa-times"></i>
    </div>

    {{-- HEADER --}}
    <div class="dest-header">

        <h2>
            Book Your Free Online  Counseling Session
        </h2>

    </div>


    {{-- TEST PREP SECTION --}}
    <div class="section-title">

        Select Test Prep / Education Loan

    </div>

    <div class="dest-grid">

        {{-- IELTS --}}
        <div class="dest-card"
             onclick="selectDestination('IELTS, PTE, TOEFL, DET')">

            <!-- <img src="{{ asset('assets/img/training-icon.jpg') }}"> -->

            <span>
                IELTS, PTE, TOEFL, DET
            </span>

        </div>

        {{-- GRE --}}
        <div class="dest-card"
             onclick="selectDestination('GRE, GMAT, SAT, ACT')">

            <!-- <img src="{{ asset('assets/img/training-icon.jpg') }}"> -->

            <span>
                GRE, GMAT, SAT, ACT
            </span>

        </div>

        {{-- LANGUAGE --}}
        <div class="dest-card"
             onclick="selectDestination('Korean, Japanese, German Language')">

            <!-- <img src="{{ asset('assets/img/training-icon.jpg') }}"> -->

            <span>
                Korean, Japanese, German
            </span>

        </div>

        {{-- LOAN --}}
        <div class="dest-card"
             onclick="selectDestination('Study Abroad Education Loan')">

            <!-- <img src="{{ asset('assets/img/elan-logo.png') }}"> -->

            <span>
                Study Abroad Education Loan
            </span>

        </div>

    </div>


    {{-- COUNTRY SECTION --}}
    <div class="section-title">

        Select Your Dream Destination

    </div>

    <div class="dest-grid">


    @foreach($online_country as $item)
        <div class="dest-card"
            onclick="selectDestination('{{ $item->name }}')">

            <img src="{{ $item->flag ?? 'https://flagcdn.com/w80/us.png' }}">

            <span>{{ $item->name }}</span>
        </div>
    @endforeach









    </div>

</div>
        {{-- STEP 2 --}}
        <div class="wiz-page" id="step2">

            <div class="wiz-split">

                <div class="wiz-sidebar">

                    <div class="back-btn" onclick="goStep(1)">
                        <i class="fa fa-arrow-left"></i>
                    </div>

                    <div class="sidebar-title">
                        Overseas Education Lane
                    </div>

                    <div class="sidebar-country" id="selectedCountryText"></div>

                    <ul class="sidebar-list">

                        <li>
                            <i class="fa fa-check-circle"></i>
                            Expert Visa Guidance
                        </li>

                        <li>
                            <i class="fa fa-check-circle"></i>
                            University Selection Support
                        </li>

                        <li>
                            <i class="fa fa-check-circle"></i>
                            Scholarship Assistance
                        </li>

                    </ul>

                </div>

                <div class="wiz-main">

                    <div class="main-title">
                        Select Date & Time
                    </div>

                    <div class="calendar-row" id="calendarRow"></div>

                    <div class="slots" id="slotContainer"></div>

                    <button class="confirm-btn"
                            id="confirmBtn"
                            disabled
                            onclick="goStep(3)">
                        Confirm
                    </button>

                </div>

            </div>

        </div>

        {{-- STEP 3 --}}
        <div class="wiz-page" id="step3">

            <div class="wiz-split">

                <div class="wiz-sidebar">

                    <div class="back-btn" onclick="goStep(2)">
                        <i class="fa fa-arrow-left"></i>
                    </div>

                    <div class="sidebar-title">
                        Overseas Education Lane
                    </div>

                    <div class="sidebar-country" id="finalCountry"></div>

                    <div style="margin-top: 30px; text-align: center;">
                        <img src="{{ asset('frontend/images/login.jpg') }}" alt="Study Abroad Counseling" style="width: 100%; height: auto; border-radius: 16px; object-fit: contain;">
                    </div>

                </div>

                <div class="wiz-main">

                    <div class="main-title">
                        Enter Your Details
                    </div>

                    <form id="bookingForm">

                        @csrf

                        <input type="hidden" name="date" id="dateInput">
                        <input type="hidden" name="time" id="timeInput">
                        <input type="hidden" name="destination" id="destinationInput">
                        <div class="form-group">

                            <label>Name *</label>

                            <input type="text"
                                   name="name"
                                   class="form-control"
                                   required>

                        </div>

                        <div class="form-group">

                            <label>Email *</label>

                            <input type="email"
                                   name="email"
                                   class="form-control"
                                   required>

                        </div>

                        <div class="form-group">
                            <label for="state_trigger">State  *</label>
                            <div class="custom-counselor-dropdown" id="state-dropdown-wrapper">
                                <input type="hidden" name="state" id="state_input">
                                <button type="button" class="form-control custom-counselor-selected"
                                        id="state_trigger" onclick="toggleStateDropdown(event)"
                                        aria-expanded="false" aria-controls="state_options">
                                    <span class="selected-content" id="state_selected_text">Select State </span>
                                    <i class="fa fa-chevron-down" style="font-size:12px;color:#64748b;"></i>
                                </button>
                                <div class="custom-counselor-options" id="state_options">
                                    <div class="booking-location-search">
                                        <input type="search" id="state_search" class="form-control"
                                               placeholder="Search state " aria-label="Search state "
                                               autocomplete="off"
                                               oninput="filterBookingLocations('state', this.value)">
                                    </div>
                                    <div class="booking-location-results" id="state_results"></div>
                                    <div class="booking-location-empty" id="state_empty" role="status" hidden>
                                        No matching state found.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="city_trigger">Your City *</label>
                            <div class="custom-counselor-dropdown" id="city-dropdown-wrapper">
                                <input type="hidden" name="city" id="city_input">
                                <button type="button" class="form-control custom-counselor-selected"
                                        id="city_trigger" onclick="toggleCityDropdown(event)"
                                        aria-expanded="false" aria-controls="city_options" disabled>
                                    <span class="selected-content" id="city_selected_text">Select State First</span>
                                    <i class="fa fa-chevron-down" style="font-size:12px;color:#64748b;"></i>
                                </button>
                                <div class="custom-counselor-options" id="city_options">
                                    <div class="booking-location-search">
                                        <input type="search" id="city_search" class="form-control"
                                               placeholder="Search city..." aria-label="Search city"
                                               autocomplete="off"
                                               oninput="filterBookingLocations('city', this.value)">
                                    </div>
                                    <div class="booking-location-results" id="city_results"></div>
                                    <div class="booking-location-empty" id="city_empty" role="status" hidden>
                                        No matching city found.
                                    </div>
                                </div>
                            </div>
                            <small id="locationError" role="alert" hidden></small>
                           
                        </div>

                        <div class="form-group">

                            <label>Phone *</label>

                            <input type="tel"
                                   name="phone"
                                   id="phone"
                                   class="form-control"
                                   inputmode="numeric"
                                   pattern="[0-9]*"
                                   maxlength="10"
                                   required>

                        </div>

                        <div class="form-group">

                            <label>Counselor *</label>

                            <style>
                            .custom-counselor-dropdown { position: relative; width: 100%; }
                            .custom-counselor-selected { 
                                height: 52px; border-radius: 14px; border: 1px solid #cbd5e1; 
                                padding: 0 15px; display: flex !important; align-items: center; justify-content: space-between;
                                background: #fff; cursor: pointer; color: #475569;
                            }
                            .custom-counselor-selected .selected-content { display: flex; align-items: center; font-size: inherit; font-family: inherit; }
                            .custom-counselor-selected .counselor-icon { font-size: 18px; margin-right: 12px; color: #226cf5; }
                            .custom-counselor-options { 
                                position: absolute; top: 100%; left: 0; width: 100%; background: #fff; 
                                border: 1px solid #cbd5e1; border-radius: 14px; margin-top: 5px; 
                                box-shadow: 0 4px 10px rgba(0,0,0,0.1); z-index: 100; display: none; overflow: visible; max-height: none;
                            }
                            .custom-counselor-options.open { display: block; }
                            .custom-counselor-option { 
                                padding: 6px 15px; display: flex; align-items: center; cursor: pointer; border-bottom: 1px solid #f1f5f9; color: #000; font-size: inherit; font-family: inherit;
                            }
                            .custom-counselor-option:last-child { border-bottom: none; }
                            .custom-counselor-option:hover { background: #f8fafc; }
                            .custom-counselor-option .counselor-icon { font-size: 18px; margin-right: 12px; color: #226cf5; }
                            </style>

                          @php
                        $counselors = [
                            [
                                'id' => 804,
                                'name' => 'Myra K',
                                'avatar' => asset('frontend/img/counselor-avatar-1.png'),
                            ],
                            [
                                'id' => 19,
                                'name' => 'Alina R',
                                'avatar' => asset('frontend/img/counselor-avatar-2.png'),
                            ],
                            [
                                'id' => 3,
                                'name' => 'Sonia S',
                                'avatar' => asset('frontend/img/counselor-avatar-3.png'),
                            ],
                            [
                                'id' => 23,
                                'name' => 'Rian M',
                                'avatar' => asset('frontend/img/counselor-avatar-4.png'),
                            ],
                            [
                                'id' => 5,
                                'name' => 'Aarav T',
                                'avatar' => asset('frontend/img/counselor-avatar-5.png'),
                            ],
                        ];
                         @endphp

                            <div class="custom-counselor-dropdown" id="counselor-dropdown-wrapper">
                                <input type="hidden" name="counselor" id="counselor_input" required>

                                <div class="form-control custom-counselor-selected" onclick="toggleCounselorDropdown(event)">
                                    <div class="selected-content" id="counselor_selected_text">
                                        <span style="color: #475569;">Select Counselor</span>
                                    </div>

                                    <i class="fa fa-chevron-down" style="font-size: 12px; color: #64748b;"></i>
                                </div>

                                <div class="custom-counselor-options" id="counselor_options">
                                    @foreach($counselors as $index => $counselor)

                                        @php
                                            $isBusy = ($index == 2 || $index == 4);
                                        @endphp

                                        @if($isBusy)

                                            <div class="custom-counselor-option"
                                                style="cursor: not-allowed; opacity: 0.6; justify-content: space-between;"
                                                onclick="event.stopPropagation()">

                                                <div style="display: flex; align-items: center;">

                                                    <img src="{{ $counselor['avatar'] }}"
                                                        alt="{{ $counselor['name'] }}"
                                                        style="width: 24px; height: 24px; border-radius: 50%; object-fit: cover; margin-right: 12px; filter: grayscale(100%);">

                                                    {{ $counselor['name'] }}
                                                </div>

                                                <span style="font-size: 11px; background: #fee2e2; color: #ef4444; padding: 2px 8px; border-radius: 10px; font-weight: 700;">
                                                    Busy
                                                </span>
                                            </div>

                                        @else

                                            <div class="custom-counselor-option"
                                                onclick="selectCounselor('{{ $counselor['id'] }}', '{{ $counselor['name'] }}', '{{ $counselor['avatar'] }}', event)">

                                                <img src="{{ $counselor['avatar'] }}"
                                                    alt="{{ $counselor['name'] }}"
                                                    style="width: 24px; height: 24px; border-radius: 50%; object-fit: cover; margin-right: 12px;">

                                                {{ $counselor['name'] }}
                                            </div>

                                        @endif

                                    @endforeach
                                </div>
                            </div>

                            <script>
                            function toggleCounselorDropdown(e) {
                                toggleBookingDropdown('counselor', e);
                            }
                            function selectCounselor(id, name, imgSrc, e) {
                                if(e && e.stopPropagation) e.stopPropagation();
                                if(!imgSrc || typeof imgSrc !== 'string' || imgSrc === '[object MouseEvent]') {
                                    imgSrc = '{{ asset("frontend/images/user.png") }}';
                                }
                                document.getElementById('counselor_input').value = id;
                                document.getElementById('counselor_selected_text').innerHTML = '<img src="' + imgSrc + '" class="counselor-icon" style="width:24px; height:24px; border-radius:50%; object-fit:cover; margin-right:12px;"> <span style="color: #000; font-weight: 500;">' + name + '</span>';
                                document.getElementById('counselor_options').classList.remove('open');
                                var sel = document.querySelector('#counselor-dropdown-wrapper .custom-counselor-selected');
                                if(sel) sel.classList.remove('active-focus');
                            }
                            document.addEventListener('click', function(event) {
                                var dropdown = document.getElementById('counselor-dropdown-wrapper');
                                if (dropdown && !dropdown.contains(event.target)) {
                                    var options = document.getElementById('counselor_options');
                                    if(options) options.classList.remove('open');
                                    var sel = document.querySelector('#counselor-dropdown-wrapper .custom-counselor-selected');
                                    if(sel) sel.classList.remove('active-focus');
                                }
                            });
                            </script>

                        </div>

                       <button type="submit"
                            class="confirm-btn"
                            id="scheduleBtn"
                            style="margin-top: 5px; margin-bottom: 120px;">

                            Schedule Event

                        </button>

                    </form>

                </div>

            </div>

        </div>

        {{-- STEP 4 --}}
        <div class="wiz-page" id="step4">

            <div class="success-box">

                <h2>
                    Meeting Scheduled Successfully
                </h2>

                <p id="finalScheduleText"></p>

                <div class="meeting-link">

                    <a href="" target="_blank" id="meetingLink"></a>

                </div>

                <button class="confirm-btn"
                        onclick="goStep(1)">
                    Book Another Meeting
                </button>

            </div>

        </div>

    </div>

</div>

<!--
Embedded location data derived from Countries States Cities Database:
https://github.com/dr5hn/countries-states-cities-database
Data licence: Open Database License (ODbL) 1.0
https://opendatacommons.org/licenses/odbl/1-0/
The adapted embedded location database is also available under ODbL 1.0.
Source includes GeoNames/OpenStreetMap/Wikidata-derived records; upstream attribution:
https://github.com/dr5hn/countries-states-cities-database#license-and-attribution
Transformations: India only, group by state, omit explicit district/area/abandoned
records and one malformed entry, deduplicate names case-insensitively, sort.
-->
<!-- Edit state/city data here; no separate JSON file is needed. -->
<script type="application/json" id="stateCityData">
{
    "Andaman and Nicobar Islands": [
        "Bamboo Flat",
        "Diglipur",
        "Sri Vijaya Puram"
    ],
    "Andhra Pradesh": [
        "Addanki",
        "Adoni",
        "Akasahebpet",
        "Akividu",
        "Akkarampalle",
        "Amalapuram",
        "Amaravati",
        "Amudalavalasa",
        "Anakapalle",
        "Anantapur",
        "Atmakur",
        "Attili",
        "Avanigadda",
        "Badvel",
        "Banganapalle",
        "Bapatla",
        "Betamcherla",
        "Bhattiprolu",
        "Bhimavaram",
        "Bhimunipatnam",
        "Bobbili",
        "Challapalle",
        "Chemmumiahpet",
        "Chilakalurupet",
        "Chinnachowk",
        "Chipurupalle",
        "Chirala",
        "Chittoor",
        "Chodavaram",
        "Cuddapah",
        "Cumbum",
        "Darsi",
        "Dharmavaram",
        "Dhone",
        "Diguvametta",
        "Elamanchili",
        "Emmiganur",
        "Erraguntla",
        "Etikoppaka",
        "Gajuwaka",
        "Ganguvada",
        "Gannavaram",
        "Giddalur",
        "Gokavaram",
        "Gooty",
        "Gorantla",
        "Gudivada",
        "Gudlavalleru",
        "Gudur",
        "Guntakal",
        "Guntur",
        "Hindupur",
        "Ichchapuram",
        "Jaggayyapeta",
        "Jammalamadugu",
        "Kadiri",
        "Kaikalur",
        "Kakinada",
        "Kalyandurg",
        "Kamalapuram",
        "Kandukur",
        "Kanigiri",
        "Kankipadu",
        "Kanuru",
        "Kasibugga",
        "Kavali",
        "Kolanukonda",
        "Kondapalle",
        "Korukollu",
        "Kosigi",
        "Kovvur",
        "Kuppam",
        "Kurnool",
        "Macherla",
        "Machilipatnam",
        "Madanapalle",
        "Madugula",
        "Mandapeta",
        "Mandasa",
        "Mangalagiri",
        "Markapur",
        "Nagari",
        "Nagireddipalli",
        "Nandigama",
        "Nandikotkur",
        "Nandyal",
        "Narasannapeta",
        "Narasapur",
        "Narasaraopet",
        "Narasingapuram",
        "Narayanavanam",
        "Narsipatnam",
        "Nayudupet",
        "Nellimarla",
        "Nellore",
        "Nidadavole",
        "Nuzvid",
        "Ongole",
        "Pakala",
        "Palasa",
        "Palkonda",
        "Pallevada",
        "Palmaner",
        "Parvatipuram",
        "Pavuluru",
        "Payakaraopeta",
        "Pedana",
        "pedda nakkalapalem",
        "Peddapuram",
        "Penugonda",
        "Penukonda",
        "Phirangipuram",
        "Piduguralla",
        "Pileru",
        "Pippara",
        "Pithapuram",
        "Podili",
        "Polavaram",
        "Ponnur",
        "Poranki",
        "Proddatur",
        "Pulivendla",
        "Punganuru",
        "Puttaparthi",
        "Puttur",
        "Rajahmundry",
        "Ramachandrapuram",
        "Ramanayyapeta",
        "Ramapuram",
        "Rampachodavaram",
        "Rayachoti",
        "Rayadrug",
        "Razam",
        "Razampeta",
        "Razole",
        "Renigunta",
        "Repalle",
        "Salur",
        "Samalkot",
        "Sattenapalle",
        "Singarayakonda",
        "Sivala East Godavari",
        "Somandepalle",
        "Sompeta",
        "Srikakulam",
        "Srikalahasti",
        "Srisailain",
        "Suluru",
        "Tadepalle",
        "Tadepallegudem",
        "Tadpatri",
        "Tanuku",
        "Tekkali",
        "Tirumala",
        "Tirupati",
        "Tuni",
        "Uravakonda",
        "vadlamuru",
        "Vadlapudi",
        "Venkatagiri",
        "Vepagunta",
        "Vetapalem",
        "Vijayawada",
        "Vinukonda",
        "Vuyyuru",
        "Yanam",
        "Yanamalakuduru",
        "Yarada"
    ],
    "Arunachal Pradesh": [
        "Basar",
        "Bomdila",
        "Daporijo",
        "Dibang Valley",
        "East Siang",
        "Hayuliang",
        "Itanagar",
        "Khonsa",
        "Naharlagun",
        "Pangin",
        "Pasighat",
        "Roing",
        "Seppa",
        "Tawang",
        "Tezu",
        "Upper Siang",
        "Ziro"
    ],
    "Assam": [
        "Abhayapuri",
        "Amguri",
        "Badarpur",
        "Barpathar",
        "Barpeta",
        "Barpeta Road",
        "Basugaon",
        "Bihpuriagaon",
        "Bijni",
        "Bilasipara",
        "Bokajan",
        "Bokakhat",
        "Bongaigaon",
        "Chabua",
        "Chapar",
        "Dergaon",
        "Dhekiajuli",
        "Dhemaji",
        "Dhing",
        "Dhubri",
        "Dibrugarh",
        "Digboi",
        "Diphu",
        "Dispur",
        "Duliagaon",
        "Dum Duma",
        "Gauripur",
        "Goalpara",
        "Gohpur",
        "Golaghat",
        "Golakganj",
        "Goshaingaon",
        "Guwahati",
        "Haflong",
        "Hailakandi",
        "Hajo",
        "Howli",
        "Jogighopa",
        "Jorhat",
        "Karbi Anglong",
        "Karimganj",
        "Kharupatia",
        "Kokrajhar",
        "Lakhipur",
        "Lala",
        "Lumding Railway Colony",
        "Mahur",
        "Maibong",
        "Makum",
        "Mangaldai",
        "Mankachar",
        "Margherita",
        "Mariani",
        "Moranha",
        "Nagaon",
        "Nahorkatiya",
        "Nalbari",
        "Namrup",
        "Nazira",
        "North Guwahati",
        "North Lakhimpur",
        "Numaligarh",
        "Palasbari",
        "Raha",
        "Rangapara",
        "Rangia",
        "Sapatgram",
        "Sarupathar",
        "Sibsagar",
        "Silapathar",
        "Silchar",
        "Soalkuchi",
        "Sonari",
        "Sorbhog",
        "Tangla",
        "Tezpur",
        "Tinsukia",
        "Titabar",
        "Udalguri"
    ],
    "Bihar": [
        "Amarpur",
        "Araria",
        "Areraj",
        "Arrah",
        "Arwal",
        "Asarganj",
        "Aurangabad",
        "Bagaha",
        "Bahadurganj",
        "Bairagnia",
        "Baisi",
        "Bakhtiyarpur",
        "Bangaon",
        "Banka",
        "Banmankhi",
        "Bar Bigha",
        "Barauli",
        "Barh",
        "Barhiya",
        "Bariarpur",
        "Baruni",
        "Belsand",
        "Bettiah",
        "Bhabhua",
        "Bhagalpur",
        "Bhagirathpur",
        "Bhawanipur",
        "Bhojpur",
        "Bihar Sharif",
        "Bihariganj",
        "Bihta",
        "Bikramganj",
        "Birpur",
        "Bodh Gaya",
        "Buxar",
        "Chakia",
        "Chapra",
        "Chhatapur",
        "Colgong",
        "Dalsingh Sarai",
        "Darbhanga",
        "Daudnagar",
        "Dehri",
        "Dhaka",
        "Dighwara",
        "Dinapore",
        "Dumra",
        "Dumraon",
        "Fatwa",
        "Forbesganj",
        "Gaya",
        "Ghoga",
        "Gogri Jamalpur",
        "Gopalganj",
        "Hajipur",
        "Hilsa",
        "Hisua",
        "Islampur",
        "Jagdispur",
        "Jahanabad",
        "Jainagar",
        "Jamui",
        "Jhajha",
        "Jhanjharpur",
        "Jogbani",
        "Kantai",
        "Kasba",
        "Katihar",
        "Khagaria",
        "Khagaul",
        "Kharagpur",
        "Khusropur",
        "Kishanganj",
        "Koath",
        "Koelwar",
        "Lalganj",
        "Luckeesarai",
        "Madhepura",
        "Madhubani",
        "Maharajgani",
        "Mahnar Bazar",
        "Mairwa",
        "Makhdumpur",
        "Maner",
        "Manihari",
        "Marhaura",
        "Masaurhi Buzurg",
        "Mirganj",
        "Mohiuddinagar",
        "Mokameh",
        "Mothihari",
        "Munger",
        "Murliganj",
        "Muzaffarpur",
        "Nabinagar",
        "Narkatiaganj",
        "Nasriganj",
        "Naubatpur",
        "Naugachhia",
        "Nawada",
        "Nirmali",
        "Nohsa",
        "Nokha",
        "Pashchim Champaran",
        "Patna",
        "Piro",
        "Pupri",
        "Purba Champaran",
        "Purnia",
        "Rafiganj",
        "Raghunathpur",
        "Rajgir",
        "Ramnagar",
        "Raxaul",
        "Revelganj",
        "Rusera",
        "Sagauli",
        "Saharsa",
        "Samastipur",
        "Sasaram",
        "Shahbazpur",
        "Shahpur",
        "Sheikhpura",
        "Sheohar",
        "Sherghati",
        "Silao",
        "Sitamarhi",
        "Siwan",
        "Supaul",
        "Teghra",
        "Tekari",
        "Thakurganj",
        "Waris Aliganj"
    ],
    "Chandigarh": [
        "Chandigarh"
    ],
    "Chhattisgarh": [
        "Ahiwara",
        "Akaltara",
        "Ambagarh Chauki",
        "Arang",
        "Baikunthpur",
        "Baloda",
        "Basna",
        "Bhanpuri",
        "Bhatapara",
        "Bhatgaon",
        "Bhilai",
        "Bijapur",
        "Bilaspur",
        "Champa",
        "Chhuikhadan",
        "Dalli Rajhara",
        "Dantewada",
        "Deori",
        "Dhamtari",
        "Dongargaon",
        "Dongargarh",
        "Durg",
        "Gandai",
        "Gaurela",
        "Gharghoda",
        "Gidam",
        "Jagdalpur",
        "Jamul",
        "Janjgir",
        "Jashpurnagar",
        "Kanker",
        "Katghora",
        "Khairagarh",
        "Khamharia",
        "Kharod",
        "Kharsia",
        "Kirandul",
        "Korba",
        "Koria",
        "Kota",
        "Kotaparh",
        "Kumhari",
        "Kurud",
        "Lormi",
        "Mahasamund",
        "Manendragarh",
        "Narayanpur",
        "Narharpur",
        "Pandaria",
        "Pandatarai",
        "Pasan",
        "Patan",
        "Pathalgaon",
        "Pendra",
        "Pithora",
        "Raigarh",
        "Raipur",
        "Raj Nandgaon",
        "Ramanuj Ganj",
        "Ratanpur",
        "Sakti",
        "Saraipali",
        "Sarangarh",
        "Seorinarayan",
        "Simga",
        "Takhatpur",
        "Uttar Bastar Kanker"
    ],
    "Dadra and Nagar Haveli and Daman and Diu": [
        "Amli",
        "Dadra",
        "Dadra \u0026 Nagar Haveli",
        "Daman",
        "Diu"
    ],
    "Delhi": [
        "Bawana",
        "Burari",
        "Delhi",
        "Delhi Cantonment",
        "Deoli",
        "Jharoda Kalan",
        "Karol Bagh",
        "Kondli",
        "Mundka",
        "Najafgarh",
        "Nangloi Jat",
        "Narela",
        "New Delhi",
        "North Delhi",
        "Pitampura",
        "Rohini",
        "South Delhi",
        "Tigri"
    ],
    "Goa": [
        "Aldona",
        "Arambol",
        "Baga",
        "Bambolim",
        "Bandora",
        "Benaulim",
        "Calangute",
        "Canacona",
        "Candolim",
        "Carapur",
        "Cavelossim",
        "Chicalim",
        "Chinchinim",
        "Colovale",
        "Colva",
        "Cortalim",
        "Cuncolim",
        "Curchorem",
        "Curti",
        "Davorlim",
        "Goa Velha",
        "Guirim",
        "Jua",
        "Kankon",
        "Madgaon",
        "Mapusa",
        "Morjim",
        "Mormugao",
        "Navelim",
        "North Goa",
        "Palle",
        "Panaji",
        "Pernem",
        "Ponda",
        "Quepem",
        "Queula",
        "Raia",
        "Saligao",
        "Sancoale",
        "Sanguem",
        "Sanquelim",
        "Sanvordem",
        "Serula",
        "Solim",
        "Taleigao",
        "Vagator",
        "Valpoi",
        "Varca",
        "Vasco da Gama"
    ],
    "Gujarat": [
        "Abrama",
        "Adalaj",
        "Agol",
        "Ahmedabad",
        "Ahwa",
        "Akrund",
        "Amod",
        "Amroli",
        "Anand",
        "Anjar",
        "Anklav",
        "Ankleshwar",
        "Babra",
        "Bagasra",
        "Bakharla",
        "Balagam",
        "Balasinor",
        "Balisana",
        "Bamanbore",
        "Bandia",
        "Bantva",
        "Bardoli",
        "Bareja",
        "Bavla",
        "Bedi",
        "Bhachau",
        "Bhadran",
        "Bhandu",
        "Bhanvad",
        "Bharuch",
        "Bhatha",
        "Bhavnagar",
        "Bhayavadar",
        "Bhildi",
        "Bilimora",
        "Bilkha",
        "Boriavi",
        "Borsad",
        "Chaklasi",
        "Chalala",
        "Chaloda",
        "Chalthan",
        "Champaner",
        "Chanasma",
        "Chhala",
        "Chikhli",
        "Chotila",
        "Chuda",
        "Dabhoda",
        "Dabhoi",
        "Dahegam",
        "Dahod",
        "Dakor",
        "Damnagar",
        "Dandi",
        "Danta",
        "Dayapar",
        "Delvada",
        "Delwada",
        "Detroj",
        "Devbhumi Dwarka",
        "Devgadh Bariya",
        "Dhandhuka",
        "Dhanera",
        "Dhansura",
        "Dharampur",
        "Dharasana",
        "Dhari",
        "Dhasa",
        "Dhola",
        "Dholera",
        "Dholka",
        "Dhoraji",
        "Dhrangadhra",
        "Dhrol",
        "Dhuwaran",
        "Dohad",
        "Dumkhal",
        "Dungarpur",
        "Dwarka",
        "Gadhada",
        "Gandevi",
        "Gandhidham",
        "Gandhinagar",
        "Gariadhar",
        "Ghodasar",
        "Ghogha",
        "Gir Somnath",
        "Godhra",
        "Gondal",
        "Gorwa",
        "Halenda",
        "Halol",
        "Halvad",
        "Hansot",
        "Harij",
        "Harsol",
        "Hathuran",
        "Idar",
        "Jakhau",
        "Jalalpore",
        "Jalalpur",
        "Jalia",
        "Jambuda",
        "Jambusar",
        "Jamnagar",
        "Jarod",
        "Jasdan",
        "Jetalpur",
        "Jetalsar",
        "Jetpur",
        "Jhalod",
        "Jhulasan",
        "Jodhpur",
        "Jodhpur (Ahmedabad)",
        "Jodiya Bandar",
        "Junagadh",
        "Kachholi",
        "Kadi",
        "Kadod",
        "Kadodara",
        "Kalavad",
        "Kalol",
        "Kandla",
        "Kandla port",
        "Kanodar",
        "Kapadvanj",
        "Karamsad",
        "Kariana",
        "Karjan",
        "Kathor",
        "Katpur",
        "Kawant",
        "Kayavarohan",
        "Kerwada",
        "Keshod",
        "Khambhat",
        "Khavda",
        "Kheda",
        "Khedbrahma",
        "Khedoi",
        "Kherali",
        "Kheralu",
        "Kim",
        "Kodinar",
        "Kosamba",
        "Kothara",
        "Kotharia",
        "Kukarmunda",
        "Kukma",
        "Kundla",
        "Kutiyana",
        "Ladol",
        "Lakhpat",
        "Lakhtar",
        "Lalpur",
        "Langhnaj",
        "Lathi",
        "Limbdi",
        "Limkheda",
        "Madhapar",
        "Madhavpur Ghed",
        "Madhi",
        "Mahemdavad",
        "Mahisa",
        "Mahudha",
        "Mahuva",
        "Mahuva (Surat)",
        "Malpur",
        "Manavadar",
        "Mandal",
        "Mandvi",
        "Mandvi (Surat)",
        "Mangrol",
        "Mangrol (Junagadh)",
        "Mansa",
        "Meghraj",
        "Mehsana",
        "Mendarda",
        "Mithapur",
        "Morva (Hadaf)",
        "Morwa",
        "Mundra",
        "Nadiad",
        "Nagwa",
        "Naldhara",
        "Naliya",
        "Nargol",
        "Naroda",
        "Nikora",
        "Nizar",
        "Odadar",
        "Okha",
        "Olpad",
        "Paddhari",
        "Padra",
        "Palanpur",
        "Palanswa",
        "Palitana",
        "Paliyad",
        "Palsana",
        "Pardi",
        "Parnera",
        "Patan",
        "Patdi",
        "Pavi Jetpur",
        "Petlad",
        "Pipavav",
        "Piplod",
        "Porbandar",
        "Prabhas Patan",
        "Prantij",
        "Radhanpur",
        "Rajkot",
        "Rajpipla",
        "Rajula",
        "Ranavav",
        "Ranpur",
        "Rapar",
        "Reha",
        "Roha",
        "Sabar Kantha",
        "Sachin",
        "Salaya",
        "Samakhiali",
        "Sanand",
        "Sankheda",
        "Sarbhon",
        "Sarkhej",
        "Sathamba",
        "Savarkundla",
        "Savli",
        "Sayla",
        "Shahpur",
        "Shivrajpur",
        "Siddhpur",
        "Sihor",
        "Sikka",
        "Sinor",
        "Sojitra",
        "Songadh",
        "Supedi",
        "Surat",
        "Surendranagar",
        "Sutrapada",
        "Talaja",
        "Talod",
        "Tankara",
        "Than",
        "Thara",
        "Tharad",
        "Thasra",
        "The Dangs",
        "Umarpada",
        "Umrala",
        "Umreth",
        "Un",
        "Una",
        "Unjha",
        "Upleta",
        "Utran",
        "Vadali",
        "Vadgam",
        "Vadnagar",
        "Vadodara",
        "Vaghodia",
        "Vaghodia INA",
        "Vallabh Vidyanagar",
        "Vallabhipur",
        "Valsad",
        "Vanala",
        "Vansda",
        "Vanthli",
        "Vapi",
        "Vartej",
        "Vasa",
        "Vasavad",
        "Vaso",
        "Vataman",
        "Vejalpur",
        "Vijapur",
        "Vinchhiya",
        "Viramgam",
        "Virpur",
        "Visavadar",
        "Visnagar",
        "Vyara",
        "Wadhai",
        "Wadhwan",
        "Waghai",
        "Wankaner"
    ],
    "Haryana": [
        "Ambala",
        "Asandh",
        "Ateli Mandi",
        "Bahadurgarh",
        "Bara Uchana",
        "Barwala",
        "Bawal",
        "Bawani Khera",
        "Beri Khas",
        "Bilaspur",
        "Buriya",
        "Chhachhrauli",
        "Dabwali",
        "Dharuhera",
        "Ellenabad",
        "Farrukhnagar",
        "Fatehabad",
        "Firozpur Jhirka",
        "Gharaunda",
        "Gohana",
        "Gorakhpur",
        "Gurugram",
        "Hansi",
        "Hasanpur",
        "Hisar",
        "Hodal",
        "Inda Chhoi",
        "Indri",
        "Jagadhri",
        "Jakhal",
        "Jhajjar",
        "Jind",
        "Kaithal",
        "Kalanaur",
        "Kalanwali",
        "Kalayat",
        "Kalka",
        "Kanina Khas",
        "Karnal",
        "Kharkhauda",
        "Kheri Sampla",
        "Ladwa",
        "Loharu",
        "Maham",
        "Mandholi Kalan",
        "Mustafabad",
        "Naraingarh",
        "Narnaul",
        "Narnaund",
        "Narwana",
        "Nilokheri",
        "Nuh",
        "Palwal",
        "Panchkula",
        "Panipat",
        "Pataudi",
        "Pehowa",
        "Pinjaur",
        "Punahana",
        "Pundri",
        "Radaur",
        "Rania",
        "Ratia",
        "Rewari",
        "Rohtak",
        "Safidon",
        "Samalkha",
        "Shadipur Julana",
        "Shahabad",
        "Sirsa",
        "Siwani",
        "Sohna",
        "Sonipat",
        "Taoru",
        "Thanesar",
        "Tilpat",
        "Tohana",
        "Tosham",
        "Uklana",
        "Yamunanagar"
    ],
    "Himachal Pradesh": [
        "Arki",
        "Baddi",
        "Banjar",
        "Bilaspur",
        "Chamba",
        "Chaupal",
        "Chowari",
        "Dagshai",
        "Dalhousie",
        "Daulatpur",
        "Dera Gopipur",
        "Dharamsala",
        "Gagret",
        "Ghumarwin",
        "Hamirpur",
        "Jawala Mukhi",
        "Jogindarnagar",
        "Jubbal",
        "Jutogh",
        "Kangar",
        "Kasauli",
        "Kotkhai",
        "Kotla",
        "Kulu",
        "Kyelang",
        "Lahul and Spiti",
        "Manali",
        "Mandi",
        "Nadaun",
        "Nagar",
        "Nagrota",
        "Nahan",
        "Nalagarh",
        "Palampur",
        "Pandoh",
        "Paonta Sahib",
        "Parwanoo",
        "Rajgarh",
        "Rampur",
        "Rohru",
        "Sabathu",
        "Santokhgarh",
        "Sarahan",
        "Sarka Ghat",
        "Seoni",
        "Shimla",
        "Solan",
        "Sundarnagar",
        "Theog",
        "Tira Sujanpur",
        "Una",
        "Yol"
    ],
    "Jammu and Kashmir": [
        "Akhnur",
        "Anantnag",
        "Awantipur",
        "Badgam",
        "Bandipore",
        "Banihal",
        "Baramula",
        "Batoti",
        "Bhadarwah",
        "Bijbehara",
        "Bishnah",
        "Bunjwah",
        "Doda",
        "Ganderbal",
        "Gho Brahmanan de",
        "Hajan",
        "Hiranagar",
        "Jammu",
        "Jaurian",
        "Kathua",
        "Katra",
        "Khaur",
        "Kishtwar",
        "Kud",
        "Kulgam",
        "Kupwara",
        "Magam",
        "Nawanshahr",
        "Noria",
        "Pahlgam",
        "Pampur",
        "Parol",
        "Pattan",
        "Pulwama",
        "Punch",
        "Qazigund",
        "Rajaori",
        "Rajauri",
        "Ramban",
        "Ramgarh",
        "Ramnagar",
        "Riasi",
        "Samba",
        "Shupiyan",
        "Sopur",
        "Soyibug",
        "Srinagar",
        "Sumbal",
        "Thang",
        "Thanna Mandi",
        "Tral",
        "Tsrar Sharif",
        "Udhampur",
        "Uri"
    ],
    "Jharkhand": [
        "Bagbera",
        "Bagra",
        "Barka Kana",
        "Barki Saria",
        "Barwadih",
        "Bermo",
        "Bhojudih",
        "Bokaro",
        "Bundu",
        "Chaibasa",
        "Chakradharpur",
        "Chakulia",
        "Chandil",
        "Chandrapura",
        "Chas",
        "Chatra",
        "Chiria",
        "Chirkunda",
        "Chitarpur",
        "Churi",
        "Dhanwar",
        "Dugda",
        "Dumka",
        "Garhwa",
        "Ghatsila",
        "Giridih",
        "Gobindpur",
        "Godda",
        "Gomoh",
        "Gopinathpur",
        "Gua",
        "Gumia",
        "Gumla",
        "Hazaribag",
        "Hazaribagh",
        "Hesla",
        "Husainabad",
        "Jagannathpur",
        "Jamadoba",
        "Jamshedpur",
        "Jamtara",
        "Jasidih",
        "Jharia",
        "Jhumri Tilaiya",
        "Jugsalai",
        "Kalikapur",
        "Kandra",
        "Kanke",
        "Katras",
        "Kenduadih",
        "Kharsawan",
        "Khunti",
        "Kodarma",
        "Kuju",
        "Latehar",
        "Lohardaga",
        "Madhupur",
        "Maithon",
        "Malkera",
        "Manoharpur",
        "Medininagar",
        "Mugma",
        "Muri",
        "Mushabani",
        "Neturhat",
        "Nirsa",
        "Noamundi",
        "Pakur",
        "Pashchim Singhbhum",
        "patamda",
        "Pathardih",
        "Patratu",
        "Phusro",
        "Purba Singhbhum",
        "Rajmahal",
        "Ramgarh",
        "Ranchi",
        "Ray",
        "Sahibganj",
        "Saraikela",
        "Sarubera",
        "Saunda",
        "Sijua",
        "Simdega",
        "Sini",
        "Topchanchi"
    ],
    "Karnataka": [
        "Afzalpur",
        "Ajjampur",
        "Aknapur",
        "Aland",
        "Alnavar",
        "Alur",
        "Anekal",
        "Ankola",
        "Annigeri",
        "Arkalgud",
        "Arsikere",
        "Athani",
        "Aurad",
        "Badami",
        "Bagalkot",
        "Bagepalli",
        "Bagewadi",
        "Bail-Hongal",
        "Ballari",
        "Banavar",
        "Bangarapet",
        "Bannur",
        "Bantval",
        "Basavakalyan",
        "Basavana Bagevadi",
        "Belagavi",
        "Belluru",
        "Beltangadi",
        "Belur",
        "Bengaluru",
        "Bhadravati",
        "Bhalki",
        "Bhatkal",
        "Bidar",
        "Bijur",
        "Bilgi",
        "Birur",
        "Byadgi",
        "Byndoor",
        "Challakere",
        "Chamrajnagar",
        "Channagiri",
        "Channapatna",
        "Channarayapatna",
        "Chik Ballapur",
        "Chikkaballapur",
        "Chikkamagaluru",
        "Chiknayakanhalli",
        "Chikodi",
        "Chincholi",
        "Chintamani",
        "Chitapur",
        "Chitradurga",
        "Closepet",
        "Dandeli",
        "Davanagere",
        "Devanahalli",
        "Dharwad",
        "Doddaballapura",
        "French Rocks",
        "Gadag-Betageri",
        "Gajendragarh",
        "Gangawati",
        "Gangolli",
        "Gauribidanur",
        "Gokak",
        "Gokarna",
        "Gorur",
        "Gubbi",
        "Gudibanda",
        "Guledagudda",
        "Gundlupet",
        "Gurmatkal",
        "Hadagalli",
        "Haliyal",
        "Hampi",
        "Hangal",
        "Harihar",
        "Harpanahalli",
        "Hassan",
        "Hatti",
        "Haveri",
        "Hebbagodi",
        "Heggadadevankote",
        "Hirekerur",
        "Hiriyur",
        "Holalkere",
        "Hole Narsipur",
        "Homnabad",
        "Honnali",
        "Honnavar",
        "Hosadurga",
        "Hosanagara",
        "Hosangadi",
        "Hosapete",
        "Hoskote",
        "Hubballi",
        "Hukeri",
        "Hungund",
        "Hunsur",
        "Hutagalli",
        "Ilkal",
        "Indi",
        "Jagalur",
        "Jamkhandi",
        "Jevargi",
        "Kadur",
        "Kalaburgi",
        "Kalghatgi",
        "Kamalapuram",
        "Kamatgi",
        "Kampli",
        "Kanakapura",
        "Karkala",
        "Karwar",
        "Kavalur",
        "Kerur",
        "Khanapur",
        "Kodigenahalli",
        "Kodlipet",
        "Kolar",
        "Kollegal",
        "Konanur",
        "Konnur",
        "Koppa",
        "Koppal",
        "Koratagere",
        "Kotekara",
        "Kotturu",
        "Krishnarajasagara",
        "Krishnarajpet",
        "Kudachi",
        "Kudligi",
        "Kumsi",
        "Kumta",
        "Kundapura",
        "Kundgol",
        "Kunigal",
        "Kurgunta",
        "Kushalnagar",
        "Kushtagi",
        "Lakshmeshwar",
        "Lingsugur",
        "Londa",
        "Maddur",
        "Madhugiri",
        "Madikeri",
        "Magadi",
        "Mahalingpur",
        "Malavalli",
        "Malpe",
        "Malur",
        "Mandya",
        "Mangaluru",
        "Manipal",
        "Manvi",
        "Mayakonda",
        "Melukote",
        "Mudalgi",
        "Mudbidri",
        "Muddebihal",
        "Mudgal",
        "Mudgere",
        "Mudhol",
        "Mulbagal",
        "Mulgund",
        "Mulki",
        "Mundargi",
        "Mundgod",
        "Munirabad",
        "Murudeshwara",
        "Mysuru",
        "Nagamangala",
        "Nanjangud",
        "Narasimharajapura",
        "Naregal",
        "Nargund",
        "Navalgund",
        "Nelamangala",
        "Nipani",
        "Nyamti",
        "Pangala",
        "Pavugada",
        "Piriyapatna",
        "Ponnampet",
        "Puttur",
        "Rabkavi",
        "Raichur",
        "Ramanagara",
        "Ranebennur",
        "Raybag",
        "Robertsonpet",
        "Ron",
        "Sadalgi",
        "Sagar",
        "Sakleshpur",
        "Sandur",
        "Sanivarsante",
        "Sankeshwar",
        "Sargur",
        "Saundatti",
        "Savanur",
        "Sedam",
        "Shahabad",
        "Shahpur",
        "Shedbal",
        "Shiggaon",
        "Shikarpur",
        "Shiraguppi",
        "Shirhatti",
        "Shorapur",
        "Shrirangapattana",
        "Siddapur",
        "Sidlaghatta",
        "Sindgi",
        "Sindhnur",
        "Sira",
        "Sirsi",
        "Siruguppa",
        "Someshwar",
        "Somvarpet",
        "Sorab",
        "Sravana Belgola",
        "Sringeri",
        "Srinivaspur",
        "Sulya",
        "Suntikoppa",
        "Talikota",
        "Tarikere",
        "Tekkalakote",
        "Terdal",
        "Tiptur",
        "Tirthahalli",
        "Tirumakudal Narsipur",
        "Tumakuru",
        "Turuvekere",
        "Udupi",
        "Ullal",
        "Uttar Kannada",
        "Vijayapura",
        "Virajpet",
        "Vittal",
        "Wadi",
        "Yadgir",
        "Yelahanka",
        "Yelandur",
        "Yelbarga",
        "Yellapur"
    ],
    "Kerala": [
        "Adoor",
        "Alangad",
        "Alappuzha",
        "Aluva",
        "Angamali",
        "Aroor",
        "Arukutti",
        "Attingal",
        "Avanoor",
        "Ayancheri",
        "Aymanam",
        "Azhikkal",
        "Beypore",
        "Changanacheri",
        "Chavara",
        "Chelakara",
        "Chelora",
        "Chendamangalam",
        "Chengamanad",
        "Chengannur",
        "Cheppad",
        "Cheriyamundam",
        "Cherpulassery",
        "Cherthala",
        "Cherukunnu",
        "Chetwayi",
        "Chirakkal",
        "Chittur",
        "Dharmadom",
        "Edakkazhiyur",
        "Edakkulam",
        "Edavilangu",
        "Elamkunnapuzha",
        "Elur",
        "Erattupetta",
        "Eravattur",
        "Ernakulam",
        "Eruvatti",
        "Ettumanoor",
        "Ferokh",
        "Guruvayur",
        "Haripad",
        "Idukki",
        "Iringal",
        "Irinjalakuda",
        "Iriveri",
        "Iroopara",
        "Kadakkavoor",
        "Kadikkad",
        "Kalamassery",
        "Kalavoor",
        "Kalpetta",
        "Kanhangad",
        "Kannapuram",
        "Kannavam",
        "Kannur",
        "Karthikappally",
        "Kasaragod",
        "Kattanam",
        "Kattipparutti",
        "Kayamkulam",
        "Kizhake Chalakudi",
        "Kochi",
        "Kodungallur",
        "Kollam",
        "Kondotty",
        "Koovappady",
        "Kotamangalam",
        "Kottakkal",
        "Kottayam",
        "Kovalam",
        "Koyilandy",
        "Kozhikode",
        "Kudlu",
        "Kumbalam",
        "Kunnamangalam",
        "Kunnamkulam",
        "Kunnumma",
        "Kutiatodu",
        "Kuttampuzha",
        "Kuttippuram",
        "Lalam",
        "Mahe",
        "Malappuram",
        "Manjeri",
        "Manjeshwaram",
        "Mannarakkat",
        "Marayur",
        "Mattanur",
        "Mavelikara",
        "Mavoor",
        "Mayyanad",
        "Moothakunnam",
        "Muluppilagadu",
        "Munnar",
        "Muvattupula",
        "Muvattupuzha",
        "Nadapuram",
        "Naduvannur",
        "Nedumangad",
        "Nedumpana",
        "Neyyattinkara",
        "Nilambur",
        "Nileshwar",
        "Ottapalam",
        "Palackattumala",
        "Palakkad",
        "Pallikunnu",
        "Panamaram",
        "Panniyannur",
        "Pappinissheri",
        "Paravur Tekkumbhagam",
        "Pariyapuram",
        "Pathanamthitta",
        "Pattanamtitta",
        "Payyanur",
        "Perinthalmanna",
        "Perumbavoor",
        "Perumpavur",
        "Peruvallur",
        "Perya",
        "Pinarayi",
        "Piravam",
        "Ponmana",
        "Ponnani",
        "Punalur",
        "Punnayur",
        "Puthencruz",
        "Ramamangalam",
        "Ramanattukara",
        "Shertallai",
        "Shoranur",
        "Taliparamba",
        "Tanalur",
        "Tennala",
        "Thaikkattussery",
        "Thalassery",
        "Thanneermukkom",
        "Thanniyam",
        "Thiruvananthapuram",
        "Thodupuzha",
        "Thottada",
        "Thrissur",
        "Tirur",
        "Tirurangadi",
        "Tiruvalla",
        "Vaikam",
        "Varkala",
        "Vatakara",
        "Vayalar",
        "Vettur"
    ],
    "Ladakh": [
        "Kargil",
        "Leh",
        "Padam"
    ],
    "Lakshadweep": [
        "Kavaratti",
        "Lakshadweep"
    ],
    "Madhya Pradesh": [
        "Agar",
        "Ajaigarh",
        "Akodia",
        "Alampur",
        "Alirajpur",
        "Alot",
        "Amanganj",
        "Amarkantak",
        "Amarpatan",
        "Amarwara",
        "Ambah",
        "Amla",
        "Anjad",
        "Antri",
        "Anuppur",
        "Aron",
        "Ashoknagar",
        "Ashta",
        "Bada Malhera",
        "Badarwas",
        "Badi",
        "Badnawar",
        "Bagh",
        "Bagli",
        "Baihar",
        "Baikunthpur",
        "Bakshwaha",
        "Balaghat",
        "Baldeogarh",
        "Bamna",
        "Bamor Kalan",
        "Bamora",
        "Banda",
        "Barela",
        "Barghat",
        "Bargi",
        "Barhi",
        "Barnagar",
        "Barwah",
        "Barwani",
        "Basoda",
        "Begamganj",
        "Beohari",
        "Berasia",
        "Betma",
        "Betul Bazar",
        "Bhabhra",
        "Bhainsdehi",
        "Bhander",
        "Bhanpura",
        "Bhikangaon",
        "Bhind",
        "Bhitarwar",
        "Bhopal",
        "Biaora",
        "Bijawar",
        "Bijrauni",
        "Bodri",
        "Budhni",
        "Burhanpur",
        "Burhar",
        "Chanderi",
        "Chandia",
        "Chandla",
        "Chhatarpur",
        "Chhindwara",
        "Chichli",
        "Churhat",
        "Daboh",
        "Dabra",
        "Damoh",
        "Damua",
        "Deori Khas",
        "Depalpur",
        "Dewas",
        "Dhamnod",
        "Dhana",
        "Dhar",
        "Dharampuri",
        "Dindori",
        "Etawa",
        "Gadarwara",
        "Gairtganj",
        "Garha Brahman",
        "Garhakota",
        "Garot",
        "Gautampura",
        "Ghansor",
        "Gogapur",
        "Gohad",
        "Gormi",
        "Govindgarh",
        "Guna",
        "Gurh",
        "Gwalior",
        "Harda",
        "Harda Khas",
        "Harpalpur",
        "Harrai",
        "Hatod",
        "Hatta",
        "Hindoria",
        "Hoshangabad",
        "Iawar",
        "Ichhawar",
        "Iklehra",
        "Indore",
        "Isagarh",
        "Itarsi",
        "Jabalpur",
        "Jaisinghnagar",
        "Jaithari",
        "Jamai",
        "Jaora",
        "Jatara",
        "Jawad",
        "Jhabua",
        "Jiran",
        "Jirapur",
        "Jobat",
        "Kailaras",
        "Kaimori",
        "Kannod",
        "Kareli",
        "Karera",
        "Karrapur",
        "Kasrawad",
        "Katangi",
        "Katni",
        "Khachrod",
        "Khajuraho Group of Monuments",
        "Khandwa",
        "Khargapur",
        "Khargone",
        "Khategaon",
        "Khetia",
        "Khilchipur",
        "Khirkiya",
        "Khujner",
        "Khurai",
        "Kolaras",
        "Korwai",
        "Kotar",
        "Kothi",
        "Kotma",
        "Kotwa",
        "Kukshi",
        "Kumbhraj",
        "Lahar",
        "Lakhnadon",
        "Leteri",
        "Lodhikheda",
        "Machalpur",
        "Madhogarh",
        "Maheshwar",
        "Mahgawan",
        "Maihar",
        "Majholi",
        "Makhan Nagar",
        "Makronia",
        "Maksi",
        "Malhargarh",
        "Manasa",
        "Manawar",
        "Mandideep",
        "Mandla",
        "Mandleshwar",
        "Mandsaur",
        "Mangawan",
        "Manpur",
        "Mau",
        "Mauganj",
        "Mihona",
        "Mohgaon",
        "Morar",
        "Morena",
        "Multai",
        "Mundi",
        "Mungaoli",
        "Murwara",
        "Nagda",
        "Nagod",
        "Naigarhi",
        "Nainpur",
        "Nal Khera",
        "Namli",
        "Narayangarh",
        "Narsimhapur",
        "Narsinghgarh",
        "Narwar",
        "Nasrullahganj",
        "Neemuch",
        "Nepanagar",
        "Nowgong",
        "Orchha",
        "Pachmarhi",
        "Palda",
        "Palera",
        "Pali",
        "Panagar",
        "Panara",
        "Pandhana",
        "Pandhurna",
        "Panna",
        "Pansemal",
        "Parasia",
        "Patan",
        "Patharia",
        "Pawai",
        "Petlawad",
        "Piploda",
        "Pithampur",
        "Porsa",
        "Punasa",
        "Raghogarh",
        "Rahatgarh",
        "Raisen",
        "Rajgarh",
        "Rajnagar",
        "Rampura",
        "Ranapur",
        "Ratangarh",
        "Ratlam",
        "Rehli",
        "Rehti",
        "Rewa",
        "Sabalgarh",
        "Sagar",
        "Sailana",
        "Sanawad",
        "Sanchi",
        "Sanwer",
        "Sarangpur",
        "Satna",
        "Satwas",
        "Saugor",
        "Sausar",
        "Sehore",
        "Sendhwa",
        "Seondha",
        "Seoni",
        "Seoni Malwa",
        "Shahdol",
        "Shahgarh",
        "Shahpur",
        "Shahpura",
        "Shajapur",
        "Shamgarh",
        "Sheopur",
        "Shivpuri",
        "Shujalpur",
        "Sidhi",
        "Sihora",
        "Simaria",
        "Singoli",
        "Singrauli",
        "Sirmaur",
        "Sironj",
        "Sitamau",
        "Sohagi",
        "Sohagpur",
        "Sonkach",
        "Sultanpur",
        "Susner",
        "Tal",
        "Talen",
        "Tarana",
        "Tekanpur",
        "Tendukheda",
        "Teonthar",
        "Thandla",
        "Tikamgarh",
        "Tirodi",
        "Udaipura",
        "Ujjain",
        "Ukwa",
        "Umaria",
        "Umri",
        "Unhel",
        "Vidisha",
        "Waraseoni"
    ],
    "Maharashtra": [
        "Achalpur",
        "Adawad",
        "Agar Panchaitan",
        "Aheri",
        "Ahilyanagar",
        "Ahmadpur",
        "Airoli",
        "Ajara",
        "Akalkot",
        "Akluj",
        "Akola",
        "Akolner",
        "Akot",
        "Akrani",
        "Alandi",
        "Ale",
        "Alibag",
        "Alkuti",
        "Allapalli",
        "Amalner",
        "Ambad",
        "Ambajogai",
        "Ambarnath",
        "Ambegaon",
        "Amgaon",
        "Andheri",
        "Andura",
        "Anjangaon",
        "Anjarle",
        "Anshing",
        "Arag",
        "Arangaon",
        "Ardhapur",
        "Argaon",
        "Artist Village",
        "Arvi",
        "Ashta",
        "Ashti",
        "Asoda",
        "Assaye",
        "Astagaon",
        "Aundh Satara",
        "Ausa",
        "Badlapur",
        "Badnapur",
        "Balapur",
        "Ballalpur",
        "Ballard Estate",
        "Ballarpur",
        "Banda Maharashtra",
        "Bandra",
        "Baner",
        "Bankot",
        "Baramati",
        "Barshi",
        "Basmat",
        "Bavdhan",
        "Bawanbir",
        "Bhadgaon Maharashtra",
        "Bhandara",
        "Bhandardara",
        "Bhandup",
        "Bhayandar",
        "Bhigvan",
        "Bhiwandi",
        "Bhiwapur",
        "Bhokar",
        "Bhokardan",
        "Bhoom",
        "Bhor",
        "Bhudgaon",
        "Bhugaon",
        "Bhusawal",
        "Bilashi",
        "Biloli",
        "Boisar",
        "Borgaon Manju",
        "Borivali",
        "Bramhapuri",
        "Breach Candy",
        "Buldana",
        "Byculla",
        "Chakan",
        "Chakur",
        "Chalisgaon",
        "Chandgad",
        "Chandor",
        "Chandrapur",
        "Chandur",
        "Chandur Bazar",
        "Chausala",
        "Chembur",
        "Chicholi",
        "Chichondi Patil",
        "Chikhli",
        "Chikhli (Jalna)",
        "Chimur",
        "Chinchani",
        "Chinchpokli",
        "Chiplun",
        "Chopda",
        "Colaba",
        "Dabhol",
        "Daddi",
        "Dahanu",
        "Dahivel",
        "Dapoli",
        "Darwha",
        "Daryapur",
        "Dattapur",
        "Daulatabad",
        "Daund",
        "Deccan Gymkhana",
        "Deglur",
        "Dehu",
        "Deolali",
        "Deolapar",
        "Deoli",
        "Deoni",
        "Desaiganj",
        "Deulgaon Raja",
        "Devrukh",
        "Dharangaon",
        "Dharavi",
        "Dharmabad",
        "Dharur",
        "Dhawalpuri",
        "Dhule",
        "Dighori",
        "Digras",
        "Diveagar",
        "Dombivli",
        "Dondaicha",
        "Dongri",
        "Dudhani",
        "Durgapur",
        "Dyane",
        "Erandol",
        "Faizpur",
        "Fort",
        "Gadhinglaj",
        "Gangakher",
        "Gangapur",
        "Gevrai",
        "Ghargaon",
        "Ghatanji",
        "Ghatkopar",
        "Ghoti Budrukh",
        "Ghugus",
        "Girgaon",
        "Gondia",
        "Gorai",
        "Goregaon",
        "Guhagar",
        "Hadapsar Pune",
        "Hadgaon",
        "Halkarni",
        "Harangul",
        "Harnai",
        "Helwak",
        "Hinganghat",
        "Hingoli",
        "Hirapur",
        "Hirapur Hamesha",
        "Hotgi",
        "Ichalkaranji",
        "Igatpuri",
        "Indapur",
        "Jaitapur",
        "Jakhangaon",
        "Jalgaon",
        "Jalgaon Jamod",
        "Jalkot",
        "Jalna",
        "Jamkhed",
        "Jamod",
        "Janephal",
        "Jaoli",
        "Jat Sangli",
        "Jategaon",
        "Jawhar",
        "Jaysingpur",
        "Jejuri",
        "Jintur",
        "Jogeshwari",
        "Juhu",
        "Junnar",
        "Kachurwahi",
        "Kadegaon",
        "Kadus",
        "Kagal",
        "Kaij",
        "Kalamb",
        "Kalamboli",
        "Kalamnuri",
        "Kalas",
        "Kali(DK)",
        "Kalmeshwar",
        "Kalundri",
        "Kalyan",
        "Kalyani Nagar",
        "Kamargaon",
        "Kamptee",
        "Kandari",
        "Kandri",
        "Kanhan",
        "Kankauli",
        "Kannad",
        "Karad",
        "Karajagi",
        "Karanja",
        "Karjat",
        "Karkamb",
        "Karmala",
        "Kasara",
        "Kasoda",
        "Kati",
        "Katol",
        "Katral",
        "Khadki",
        "Khalapur",
        "Khallar",
        "Khamgaon",
        "Khanapur",
        "Khandala",
        "Khangaon",
        "Khapa",
        "Kharakvasla",
        "Kharda",
        "Kharghar",
        "Kharsundi",
        "Khed",
        "Khoni",
        "Khopoli",
        "Khuldabad",
        "Kinwat",
        "Kodoli",
        "Kolhapur",
        "Kondalwadi",
        "Kondhali",
        "Kopar Khairane",
        "Kopargaon",
        "Kopela",
        "Koradi",
        "Koregaon",
        "Koynanagar",
        "Kudal",
        "Kuhi",
        "Kurandvad",
        "Kurankhed",
        "Kurduvadi",
        "Kusumba",
        "Lakhandur",
        "Lanja",
        "Lasalgaon",
        "Latur",
        "Lavasa",
        "Loha",
        "Lohogaon",
        "Lonand",
        "Lonar",
        "Lonavla",
        "Mahabaleshwar",
        "Mahad",
        "Mahape",
        "Mahim",
        "Maindargi",
        "Majalgaon",
        "Makhjan",
        "Malabar Hill",
        "Malad",
        "Malegaon",
        "Malkapur",
        "Malvan",
        "Manchar",
        "Mandangad",
        "Mandhal",
        "Mandwa",
        "Mangaon",
        "Mangrul Pir",
        "Mankeshwar",
        "Mankhurd",
        "Manmad",
        "Manor",
        "Mansar",
        "Manwath",
        "Maregaon",
        "Mastiholi",
        "Masur India",
        "Matheran",
        "Matunga",
        "Mazagaon",
        "Mehergaon",
        "Mehkar",
        "Mhasla",
        "Mhaswad",
        "Miraj",
        "Mohadi",
        "Mohol",
        "Mohpa",
        "Mokhada taluka",
        "Mora Maharashtra",
        "Moram",
        "Morsi",
        "Mowad",
        "Mudkhed",
        "Mukher",
        "Mul",
        "Mulher",
        "Mulund",
        "Mumbai",
        "Murbad",
        "Murgud",
        "Murtajapur",
        "Murud (Raigad)",
        "Murud (Ratnagiri)",
        "Nadgaon",
        "Nagapur",
        "Nagothana",
        "Nagpur Division",
        "Nala Sopara",
        "Naldurg",
        "Nalegaon",
        "Nampur",
        "Nanded",
        "Nandgaon",
        "Nandnee",
        "Nandura",
        "Nandura Buzurg",
        "Nandurbar",
        "Narayangaon",
        "Nariman Point",
        "Narkhed",
        "Nashik Division",
        "Navapur",
        "Navi Mumbai",
        "Neral",
        "Nerur",
        "Nevasa",
        "Nighoj",
        "Nilanga",
        "Nildoh",
        "Niphad",
        "Nira Narsingpur",
        "Osmanabad",
        "Ozar",
        "Pabal",
        "Pachora",
        "Pahur Maharashtra",
        "Paithan",
        "Pali Raigad",
        "Palso",
        "Panchgani",
        "Pandharpur",
        "Pandhurli",
        "Panhala",
        "Panvel",
        "Paranda",
        "Parbhani",
        "Parel",
        "Parli Vaijnath",
        "Parner",
        "Parola",
        "Parseoni",
        "Partur",
        "Patan",
        "Pathardi",
        "Pathri",
        "Patur",
        "Paturda",
        "Paud",
        "Pauni",
        "Pedgaon",
        "Peint",
        "Pen",
        "Phaltan",
        "Phulambri",
        "Piliv",
        "Pimpalgaon Baswant",
        "Pimpalgaon Raja",
        "Pimpri",
        "Pimpri-Chinchwad",
        "Pipri",
        "Powai",
        "Prabhadevi",
        "Prakasha",
        "Pulgaon",
        "Pune",
        "Puntamba",
        "Pural",
        "Purna",
        "Pusad",
        "Radhanagari",
        "Rahata",
        "Rahimatpur",
        "Rahuri",
        "Raigarh",
        "Raireshwar",
        "Rajapur",
        "Rajgurunagar",
        "Rajur",
        "Rajura",
        "Ralegaon",
        "Ramewadi",
        "Ramtek",
        "Ratnagiri",
        "Raver",
        "Renavi",
        "Revadanda",
        "Risod",
        "Roha",
        "Sailu",
        "Sakol",
        "Sakoli",
        "Sakri",
        "Samudrapur",
        "Sangameshwar",
        "Sangamner",
        "Sangli",
        "Sangola",
        "Sangrampur Maharashtra",
        "Saoli",
        "Saoner",
        "Sarangkheda",
        "Saswad",
        "Satana",
        "Satara",
        "Satara Division",
        "Satpati",
        "Savantvadi",
        "Savda",
        "Savlaj",
        "Sawantvadi",
        "Selu",
        "Sevagram",
        "Sewri",
        "Shahada",
        "Shahapur",
        "Shegaon",
        "Shendurjana",
        "Shevgaon",
        "Shikrapur",
        "Shirala",
        "Shirdi",
        "Shirgaon",
        "Shirol",
        "Shirpur",
        "Shirud",
        "Shirwal",
        "Shivaji Nagar",
        "Shrigonda",
        "Shrirampur",
        "Sillod",
        "Sindewahi",
        "Sindi",
        "Sindkhed Raja",
        "Sindkheda",
        "Sinnar",
        "Sion Mumbai",
        "Sironcha",
        "Sirur",
        "Solapur",
        "Sonala",
        "Sonegaon",
        "Songir",
        "Sonvad",
        "Soygaon",
        "Srivardhan",
        "Surgana",
        "Taklibhan",
        "Talbid",
        "Talegaon Dabhade",
        "Talegaon Dhamdhere",
        "Taloda",
        "Talode",
        "Tarapur",
        "Tardeo",
        "Tasgaon",
        "Telhara",
        "Thalner",
        "Thane",
        "Trimbak",
        "Trombay",
        "Tuljapur",
        "Tumsar",
        "Udgir",
        "Ulhasnagar",
        "Umarga",
        "Umarkhed",
        "Umred",
        "Uran",
        "Uruli Kanchan",
        "Vada",
        "Vadner",
        "Vaijapur",
        "Vairag",
        "Valsang",
        "Vangaon",
        "Varangaon",
        "Vashi",
        "Vasind",
        "Vatul",
        "Velas Maharashtra",
        "Velneshwar",
        "Vengurla",
        "Vijaydurg",
        "Vikhroli",
        "Vile Parle",
        "Vinchur",
        "Virar",
        "Vite",
        "Wadala",
        "Wadgaon",
        "Wadner",
        "Wadwani",
        "Wagholi",
        "Wai",
        "Wakad",
        "Walgaon",
        "Walki",
        "Wani",
        "Wardha",
        "Warora",
        "Warud",
        "Washim",
        "Worli",
        "Yaval",
        "Yavatmal",
        "Yeola"
    ],
    "Manipur": [
        "Bishnupur",
        "Chandel",
        "Churachandpur",
        "Imphal West",
        "Jiribam",
        "Mayang Imphal",
        "Moirang",
        "Nambol",
        "Noney",
        "Pherzawl",
        "Tamenglong",
        "Tengnoupal",
        "Thoubal",
        "Ukhrul"
    ],
    "Meghalaya": [
        "Baghmara",
        "Cherrapunji",
        "Jowai",
        "Mairang",
        "Nongpoh",
        "Nongstoin",
        "Nongthymmai",
        "Shillong",
        "Tura"
    ],
    "Mizoram": [
        "Aizawl",
        "Darlawn",
        "Khawhai",
        "Kolasib",
        "Lawngtlai",
        "Lunglei",
        "Mamit",
        "North Vanlaiphai",
        "Saiha",
        "Sairang",
        "Saitlaw",
        "Serchhip",
        "Thenzawl"
    ],
    "Nagaland": [
        "Dimapur",
        "Kohima",
        "Mokokchung",
        "Mon",
        "Peren",
        "Phek",
        "Tuensang",
        "Wokha",
        "Zunheboto"
    ],
    "Odisha": [
        "Angul",
        "Asika",
        "Athagarh",
        "Athmallik",
        "Bada Barabil",
        "Balangir",
        "Balasore",
        "Baliguda",
        "Balimila",
        "Balugaon",
        "Banapur",
        "Banki",
        "Banposh",
        "Barbil",
        "Bargarh",
        "Baripada",
        "Barpali",
        "Basudebpur",
        "Baud",
        "Baudh",
        "Belaguntha",
        "Belpahar",
        "Bhadrak",
        "Bhanjanagar",
        "Bhawanipatna",
        "Bhuban",
        "Bhubaneswar",
        "Binika",
        "Birmitrapur",
        "Bolanikhodan",
        "Brahmapur",
        "Brajarajnagar",
        "Buguda",
        "Burla",
        "Champua",
        "Chandbali",
        "Chandili",
        "Chhatrapur",
        "Chikiti",
        "Chittarkonda",
        "Choudwar",
        "Cuttack",
        "Daitari",
        "Deogarh",
        "Dhamanagar",
        "Dhenkanal",
        "Digapahandi",
        "Ganjam",
        "Gopalpur",
        "Gudari",
        "Gunupur",
        "Hinjilicut",
        "Hirakud",
        "Jagatsinghpur",
        "Jajpur",
        "Jalda",
        "Jaleshwar",
        "Jatani",
        "Jeypore",
        "Junagarh",
        "Kamakhyanagar",
        "Kantabanji",
        "Kantilo",
        "Karanjia",
        "Kendrapara",
        "Kendujhar",
        "Kesinga",
        "Khallikot",
        "Kharhial",
        "Khordha",
        "Kiri Buru",
        "Kodala",
        "Konarka",
        "Koraput",
        "Kuchinda",
        "Malkangiri",
        "Nayagarh",
        "Nilagiri",
        "Nimaparha",
        "Nuapada",
        "Padampur",
        "Paradip Garh",
        "Paralakhemundi",
        "Patamundai",
        "Patnagarh",
        "Phulbani",
        "Pipili",
        "Polasara",
        "Puri",
        "Purushottampur",
        "Rairangpur",
        "Rajgangpur",
        "Rambha",
        "Rayagada",
        "Remuna",
        "Rengali",
        "Rourkela",
        "Sambalpur",
        "Sonepur",
        "Sorada",
        "Soro",
        "Sunabeda",
        "Talcher",
        "Tarabha",
        "Titlagarh",
        "Udayagiri",
        "Umarkot"
    ],
    "Puducherry": [
        "Ariyankuppam",
        "Karaikal",
        "Mahe",
        "Puducherry",
        "Villianur",
        "Yanam"
    ],
    "Punjab": [
        "Abohar",
        "Adampur",
        "Ajitgarh",
        "Ajnala",
        "Akalgarh",
        "Alawalpur",
        "Amloh",
        "Amritsar",
        "Anandpur Sahib",
        "Badhni Kalan",
        "Bagha Purana",
        "Bakloh",
        "Balachor",
        "Banga",
        "Banur",
        "Barnala",
        "Basi",
        "Batala",
        "Begowal",
        "Bhadaur",
        "Bhatinda",
        "Bhawanigarh",
        "Bhikhi",
        "Bhogpur",
        "Bholath",
        "Budhlada",
        "Chima",
        "Dasuya",
        "Dera Baba Nanak",
        "Dera Bassi",
        "Dhanaula",
        "Dhariwal",
        "Dhilwan",
        "Dhudi",
        "Dhuri",
        "Dina Nagar",
        "Dirba",
        "Doraha",
        "Faridkot",
        "Fatehgarh Churian",
        "Firozpur",
        "Gardhiwala",
        "Garhshankar",
        "Ghanaur",
        "Giddarbaha",
        "Goraya",
        "Gurdaspur",
        "Guru Har Sahai",
        "Hajipur",
        "Hariana",
        "Ishanpur",
        "Jagraon",
        "Jaito",
        "Jalalabad",
        "Jalandhar",
        "Jandiala",
        "Jandiala Guru",
        "Jugial",
        "Kalanaur",
        "Kapurthala",
        "Kartarpur",
        "Khamanon",
        "Khanna",
        "Kharar",
        "Khemkaran",
        "Kot Isa Khan",
        "Kotkapura",
        "Kurali",
        "Lalru",
        "Laungowal",
        "Lehragaga",
        "Ludhiana",
        "Machhiwara",
        "Majitha",
        "Makhu",
        "Malerkotla",
        "Malout",
        "Mansa",
        "Maur Mandi",
        "Moga",
        "Mohali",
        "Moonak",
        "Morinda",
        "Mukerian",
        "Nabha",
        "Nakodar",
        "Nangal",
        "Nawanshahr",
        "Nurmahal",
        "Nurpur Kalan",
        "Paras Rampur",
        "Pathankot",
        "Patiala",
        "Patti",
        "Phagwara",
        "Phillaur",
        "Qadian",
        "Rahon",
        "Raikot",
        "Rajasansi",
        "Rajpura",
        "Ram Das",
        "Rampura",
        "Rupnagar",
        "Samrala",
        "Sanaur",
        "Sangrur",
        "Sardulgarh",
        "Shahid Bhagat Singh Nagar",
        "Shahkot",
        "Sham Churasi",
        "Sirhind-Fategarh",
        "Sri Muktsar Sahib",
        "Sujanpur",
        "Sultanpur Lodhi",
        "Sunam",
        "Talwandi Bhai",
        "Talwara",
        "Tarn Taran Sahib",
        "Zerakpur",
        "Zira"
    ],
    "Rajasthan": [
        "Abhaneri",
        "Abu",
        "Abu Road",
        "Ajmer",
        "Aklera",
        "Alwar",
        "Amet",
        "Anta",
        "Anupgarh",
        "Asind",
        "Bagar",
        "Bakani",
        "Bali",
        "Balotra",
        "Bandikui",
        "Banswara",
        "Baran",
        "Bari",
        "Bari Sadri",
        "Barmer",
        "Basi",
        "Basni",
        "Baswa",
        "Bayana",
        "Beawar",
        "Begun",
        "Behror",
        "Bhadasar",
        "Bhadra",
        "Bharatpur",
        "Bhawani Mandi",
        "Bhilwara",
        "Bhindar",
        "Bhinmal",
        "Bhiwadi",
        "Bhuma",
        "Bhusawar",
        "Bidasar",
        "Bikaner",
        "Bilara",
        "Bissau",
        "Borkhera",
        "Bundi",
        "Chaksu",
        "Chaumu",
        "Chechat",
        "Chhabra",
        "Chhapar",
        "Chhoti Sadri",
        "Chidawa",
        "Chittaurgarh",
        "Churu",
        "Dariba",
        "Dausa",
        "Deoli",
        "Deshnoke",
        "Devgarh",
        "Dhaulpur",
        "Didwana",
        "Dig",
        "Dungarpur",
        "Fatehpur",
        "Galiakot",
        "Gangapur",
        "Govindgarh",
        "Gulabpura",
        "Hanumangarh",
        "Hindaun",
        "Jahazpur",
        "Jaipur",
        "Jaisalmer",
        "Jaitaran",
        "Jalor",
        "Jalore",
        "Jhajhar",
        "Jhalawar",
        "Jhalrapatan",
        "Jhunjhunun",
        "Jobner",
        "Jodhpur",
        "Kaithoon",
        "Kaman",
        "Kanor",
        "Kapasan",
        "Kapren",
        "Karanpur",
        "Karauli",
        "Kekri",
        "Keshorai Patan",
        "Khandela",
        "Khanpur",
        "Khetri",
        "Kishangarh",
        "Kota",
        "Kotputli",
        "Kuchaman",
        "Kuchera",
        "Kumher",
        "Kushalgarh",
        "Lachhmangarh Sikar",
        "Ladnun",
        "Lakheri",
        "Lalsot",
        "Losal",
        "Mahwa",
        "Makrana",
        "Malpura",
        "Mandal",
        "Mandalgarh",
        "Mandawar",
        "Mangrol",
        "Manohar Thana",
        "Manoharpur",
        "Meethari Marwar",
        "Merta",
        "Mundwa",
        "Nadbai",
        "Nagar",
        "Nagaur",
        "Nainwa",
        "Napasar",
        "Naraina",
        "Nasirabad",
        "Nathdwara",
        "Nawa",
        "Nawalgarh",
        "Neem ka Thana",
        "Nimaj",
        "Nimbahera",
        "Niwai",
        "Nohar",
        "Nokha",
        "Padampur",
        "Pali",
        "Partapur",
        "Parvatsar",
        "Phalodi",
        "Phulera",
        "Pilani",
        "Pilibangan",
        "Pindwara",
        "Pipar",
        "Pirawa",
        "Pokaran",
        "Pratapgarh",
        "Pushkar",
        "Raipur",
        "Raisinghnagar",
        "Rajakhera",
        "Rajaldesar",
        "Rajgarh",
        "Rajsamand",
        "Ramganj Mandi",
        "Ramgarh",
        "Rani",
        "Ratangarh",
        "Rawatbhata",
        "Rawatsar",
        "Reengus",
        "Sadri",
        "Sagwara",
        "Salumbar",
        "Sambhar",
        "Samdari",
        "Sanchor",
        "Sangaria",
        "Sangod",
        "Sardarshahr",
        "Sarwar",
        "Satalkheri",
        "Sawai Madhopur",
        "Shahpura",
        "Sheoganj",
        "Sikar",
        "Sirohi",
        "Siwana",
        "Sojat",
        "Sri Dungargarh",
        "Sri Ganganagar",
        "Sri Madhopur",
        "Sujangarh",
        "Suket",
        "Sunel",
        "Surajgarh",
        "Suratgarh",
        "Takhatgarh",
        "Taranagar",
        "Tijara",
        "Todabhim",
        "Todaraisingh",
        "Tonk",
        "Udaipur",
        "Udpura",
        "Uniara",
        "Viratnagar",
        "Weir"
    ],
    "Sikkim": [
        "Gangtok",
        "Jorethang",
        "Mangan",
        "Namchi",
        "Naya Bazar",
        "Rangpo",
        "Singtam"
    ],
    "Tamil Nadu": [
        "Abiramam",
        "Adirampattinam",
        "Aduthurai",
        "Alagapuram",
        "Alandur",
        "Alanganallur",
        "Alangayam",
        "Alangudi",
        "Alangulam",
        "Alappakkam",
        "Alur",
        "Alwa Tirunagari",
        "Ambasamudram",
        "Ambattur",
        "Ambur",
        "Ammapettai",
        "Anaiyur",
        "Anamalais",
        "Andipalayam",
        "Andippatti",
        "Annamalainagar",
        "Annavasal",
        "Annur",
        "Anthiyur",
        "Arakkonam",
        "Arantangi",
        "Arcot",
        "Arimalam",
        "Ariyalur",
        "Arni",
        "Arumanai",
        "Arumbavur",
        "Arumuganeri",
        "Aruppukkottai",
        "Aruvankad",
        "Attayampatti",
        "Attur",
        "Auroville",
        "Avadi",
        "Avinashi",
        "Ayakudi",
        "Ayyalur",
        "Ayyampettai",
        "Bargur",
        "Belur",
        "Bhavani",
        "Bodinayakkanur",
        "Boothapandi",
        "Chengam",
        "Chennai",
        "Chennimalai",
        "Chetput",
        "Chettipalaiyam",
        "Cheyyar",
        "Cheyyur",
        "Chidambaram",
        "Chinna Salem",
        "Chinnalapatti",
        "Chinnamanur",
        "Chinnasekkadu",
        "Cholapuram",
        "Coimbatore",
        "Colachel",
        "Coonoor",
        "Cuddalore",
        "Cumbum",
        "Darasuram",
        "Denkanikota",
        "Desur",
        "Devadanapatti",
        "Devakottai",
        "Devarshola",
        "Dhali",
        "Dharapuram",
        "Dharmapuri",
        "Dindigul",
        "Dusi",
        "Elandakuttai",
        "Elayirampannai",
        "Elumalai",
        "Eral",
        "Eraniel",
        "Erode",
        "Erumaippatti",
        "Ettaiyapuram",
        "Gandhi Nagar",
        "Gangaikondan",
        "Gangavalli",
        "Gingee",
        "Gobichettipalayam",
        "Gudalur",
        "Gudiyatham",
        "Guduvancheri",
        "Gummidipundi",
        "Harur",
        "Hosur",
        "Idappadi",
        "Ilampillai",
        "Iluppur",
        "Injambakkam",
        "Irugur",
        "Jalakandapuram",
        "Jalarpet",
        "Jambai",
        "Jayamkondacholapuram",
        "Kadambur",
        "Kadayal",
        "Kadayanallur",
        "Kalakkadu",
        "Kalavai",
        "Kallakkurichchi",
        "Kallidaikurichi",
        "Kallupatti",
        "Kalugumalai",
        "Kamuthi",
        "Kanadukattan",
        "Kanchipuram",
        "Kangayam",
        "Karaikkudi",
        "Karamadai",
        "Karambakkudi",
        "Kariapatti",
        "Karumbakkam",
        "Karur",
        "Katpadi",
        "Kattivakkam",
        "Kattumannarkoil",
        "Kattupputtur",
        "Kaveripatnam",
        "Kayalpattinam",
        "Kayattar",
        "Kelamangalam",
        "Kil Bhuvanagiri",
        "Kilakarai",
        "Kilvelur",
        "Kiranur",
        "Kodaikanal",
        "Kodumudi",
        "Kombai",
        "Kondalampatti",
        "Konganapuram",
        "Koothanallur",
        "Koradachcheri",
        "Korampallam",
        "Kotagiri",
        "Kottaiyur",
        "Kottur",
        "Kovilpatti",
        "Krishnagiri",
        "Kulattur",
        "Kulittalai",
        "Kumaralingam",
        "Kumarapalayam",
        "Kumbakonam",
        "Kunnattur",
        "Kurinjippadi",
        "Kuttalam",
        "Kuzhithurai",
        "Lalgudi",
        "Madambakkam",
        "Madipakkam",
        "Madukkarai",
        "Madukkur",
        "Madurai",
        "Madurantakam",
        "Mallapuram",
        "Mallasamudram",
        "Mallur",
        "Manali",
        "Manalurpettai",
        "Manamadurai",
        "Manappakkam",
        "Manapparai",
        "Manavalakurichi",
        "Mandapam",
        "Mangalam",
        "Mannargudi",
        "Marakkanam",
        "Marandahalli",
        "Marthandam",
        "Masinigudi",
        "Mattur",
        "Mechcheri",
        "Melur",
        "Mettuppalaiyam",
        "Mettur",
        "Minjur",
        "Mohanur",
        "Mudukulathur",
        "Mulanur",
        "Musiri",
        "Muthupet",
        "Muttayyapuram",
        "Naduvattam",
        "Nagapattinam",
        "Nagercoil",
        "Namagiripettai",
        "Namakkal",
        "Nambiyur",
        "Nambutalai",
        "Nandambakkam",
        "Nangavalli",
        "Nangavaram",
        "Nangilickondan",
        "Nanguneri",
        "Nannilam",
        "Narasimhanaickenpalayam",
        "Narasingapuram",
        "Naravarikuppam",
        "Natham",
        "Nattarasankottai",
        "Needamangalam",
        "Neelankarai",
        "Nellikkuppam",
        "Nerkunram",
        "Nilakottai",
        "Nilgiris",
        "Odugattur",
        "Omalur",
        "Ooty",
        "Padmanabhapuram",
        "Palakkodu",
        "Palamedu",
        "Palani",
        "Palavakkam",
        "Palladam",
        "Pallappatti",
        "Pallattur",
        "Pallavaram",
        "Pallikonda",
        "Pallipalayam",
        "Pallipattu",
        "Pallippatti",
        "Pamban",
        "Panruti",
        "Papanasam",
        "Papireddippatti",
        "Papparapatti",
        "Paramagudi",
        "Parangipettai",
        "Paravai",
        "Pattukkottai",
        "Pennadam",
        "Pennagaram",
        "Pennathur",
        "Peraiyur",
        "Perambalur",
        "Peranamallur",
        "Peranampattu",
        "Peravurani",
        "Periyakulam",
        "Periyanayakkanpalaiyam",
        "Periyanegamam",
        "Periyapatti",
        "Periyapattinam",
        "Perundurai",
        "Perungudi",
        "Perur",
        "Pollachi",
        "Polur",
        "Ponnamaravati",
        "Ponneri",
        "Poonamalle",
        "Porur",
        "Pudukkottai",
        "Puduppatti",
        "Pudur",
        "Puduvayal",
        "Puliyangudi",
        "Puliyur",
        "Pullambadi",
        "Punjai Puliyampatti",
        "Rajapalayam",
        "Ramanathapuram",
        "Rameswaram",
        "Ranipet",
        "Rasipuram",
        "Saint Thomas Mount",
        "Salem",
        "Samalapuram",
        "Sathankulam",
        "Sathyamangalam",
        "Sattur",
        "Sayalgudi",
        "Sendamangalam",
        "Settur",
        "Seven Pagodas",
        "Sevilimedu",
        "Sholavandan",
        "Sholinghur",
        "Singampunari",
        "Singanallur",
        "Singapperumalkovil",
        "Sirkazhi",
        "Sirumugai",
        "Sithurajapuram",
        "Sivaganga",
        "Sivagiri",
        "Sivakasi",
        "Srimushnam",
        "Sriperumbudur",
        "Srivaikuntam",
        "Srivilliputhur",
        "Suchindram",
        "Sulur",
        "Surampatti",
        "Surandai",
        "Swamimalai",
        "Tambaram",
        "Taramangalam",
        "Tattayyangarpettai",
        "Tevaram",
        "Thanjavur",
        "Tharangambadi",
        "Theni",
        "Thenkasi",
        "Thirukattupalli",
        "Thiruthani",
        "Thiruthuraipoondi",
        "Thiruvaiyaru",
        "Thiruvallur",
        "Thiruvarur",
        "Thiruvidaimaruthur",
        "Thoothukudi",
        "Tindivanam",
        "Tinnanur",
        "Tiruchchendur",
        "Tiruchengode",
        "Tiruchirappalli",
        "Tirukkoyilur",
        "Tirumullaivasal",
        "Tirunelveli Kattabo",
        "Tiruppalaikudi",
        "Tirupparangunram",
        "Tiruppur",
        "Tiruppuvanam",
        "Tiruttangal",
        "Tiruvankod",
        "Tiruvannamalai",
        "Tiruvottiyur",
        "Tisaiyanvilai",
        "Tondi",
        "Turaiyur",
        "Udangudi",
        "Udumalaippettai",
        "Uppiliyapuram",
        "Usilampatti",
        "Uttamapalaiyam",
        "Uttiramerur",
        "Uttukkuli",
        "V.S.K.Valasai (Dindigul-Dist.)",
        "Vadakkanandal",
        "Vadakku Valliyur",
        "Vadakku Viravanallur",
        "Vadamadurai",
        "Vadipatti",
        "Valangaiman",
        "Valavanur",
        "Vallam",
        "Valparai",
        "Vandalur",
        "Vandavasi",
        "Vandiyur",
        "Vaniyambadi",
        "Vasudevanallur",
        "Vattalkundu",
        "Vedaraniyam",
        "Vedasandur",
        "Velankanni",
        "Vellalur",
        "Vellanur",
        "Vellore",
        "Velur",
        "Vengavasal",
        "Vettaikkaranpudur",
        "Vettavalam",
        "Vijayapuri",
        "Vikravandi",
        "Vilangudi",
        "Vilankurichi",
        "Vilattikulam",
        "Villukuri",
        "Villupuram",
        "Viraganur",
        "Virudhunagar",
        "Vriddhachalam",
        "Walajabad",
        "Walajapet",
        "Wellington"
    ],
    "Telangana": [
        "Adilabad",
        "Alampur",
        "Andol",
        "Asifabad",
        "Balapur",
        "Banswada",
        "Bellampalli",
        "Bhadrachalam",
        "Bhaisa",
        "Bhongir",
        "Bodhan",
        "Chandur",
        "Chatakonda",
        "Dasnapur",
        "Devarkonda",
        "Dornakal",
        "Farrukhnagar",
        "Gaddi Annaram",
        "Ghatkesar",
        "Gopalur",
        "Gudur",
        "Hyderabad",
        "Jayashankar Bhupalapally",
        "Jogipet",
        "Kamareddy",
        "Karimnagar",
        "Khammam",
        "Kodar",
        "Koratla",
        "Kothakota",
        "Kothapet",
        "Kottapalli",
        "Kukatpally",
        "Kyathampalle",
        "Lakshettipet",
        "Lal Bahadur Nagar",
        "Mahabubabad",
        "Mahbubnagar",
        "Malkajgiri",
        "Mancherial",
        "Mandamarri",
        "Manthani",
        "Manuguru",
        "Medak",
        "Medchal",
        "Medchal Malkajgiri",
        "Metpalle",
        "Miryalaguda",
        "Nakrekal",
        "Nalgonda",
        "Narayanpet",
        "Narsampet",
        "Narsingi",
        "Naspur",
        "Nizamabad",
        "Paloncha",
        "Palwancha",
        "Patancheru",
        "Quthbullapur",
        "Ramagundam",
        "Ramgundam",
        "Rangareddi",
        "Sadasivpet",
        "Sangareddi",
        "Sarapaka",
        "Sathupalli",
        "Secunderabad",
        "Serilingampalle",
        "Siddipet",
        "Singapur",
        "Sirpur",
        "Sriramnagar",
        "Tandur",
        "Uppal Kalan",
        "Vemalwada",
        "Vijayapuri North",
        "Warangal",
        "Yellandu",
        "Zahirabad"
    ],
    "Tripura": [
        "Agartala",
        "Amarpur",
        "Ambasa",
        "Barjala",
        "Kailashahar",
        "Kamalpur",
        "North Tripura",
        "Ranir Bazar",
        "Sabrum",
        "Sonamura",
        "Unakoti",
        "West Tripura"
    ],
    "Uttar Pradesh": [
        "Achhnera",
        "Afzalgarh",
        "Ahraura",
        "Aidalpur",
        "Airwa",
        "Akbarpur",
        "Akola",
        "Aliganj",
        "Aligarh",
        "Allahganj",
        "Amanpur",
        "Amauli",
        "Ambahta",
        "Amethi",
        "Amroha",
        "Anandnagar",
        "Antu",
        "Anupshahr",
        "Aonla",
        "Araul",
        "Asalatganj",
        "Atarra",
        "Atrauli",
        "Atraulia",
        "Auraiya",
        "Auras",
        "Ayodhya",
        "Azizpur",
        "Baberu",
        "Babina",
        "Babrala",
        "Babugarh",
        "Bachhraon",
        "Bachhrawan",
        "Baghpat",
        "Baghra",
        "Bah",
        "Baheri",
        "Bahjoi",
        "Bahraich",
        "Bahsuma",
        "Bahua",
        "Bajna",
        "Bakewar",
        "Baksar",
        "Balamau",
        "Baldev",
        "Ballia",
        "Balrampur",
        "Banat",
        "Banda",
        "Bangarmau",
        "Bansdih",
        "Bansgaon",
        "Bansi",
        "Banthra",
        "Bara Banki",
        "Baragaon",
        "Baraut",
        "Bareilly",
        "Barkhera",
        "Barokhar",
        "Barsana",
        "Barwar (Lakhimpur Kheri)",
        "Basti",
        "Behat",
        "Bela",
        "Belthara",
        "Beniganj",
        "Beswan",
        "Bewar",
        "Bhadarsa",
        "Bhadohi",
        "Bhagwantnagar",
        "Bharatpura",
        "Bhargain",
        "Bharthana",
        "Bharwari",
        "Bhaupur",
        "Bhinga",
        "Bhognipur",
        "Bhongaon",
        "Bidhnu",
        "Bidhuna",
        "Bighapur Khurd",
        "Bijnor",
        "Bikapur",
        "Bilari",
        "Bilariaganj",
        "Bilaspur",
        "Bilgram",
        "Bilhaur",
        "Bilsanda",
        "Bilsi",
        "Bilthra",
        "Binauli",
        "Binaur",
        "Bindki",
        "Birdpur",
        "Bisalpur",
        "Bisauli",
        "Bisenda Buzurg",
        "Bishunpur Urf Maharajganj",
        "Biswan",
        "Bithur",
        "Budaun",
        "Budhana",
        "Bulandshahr",
        "Chail",
        "Chakia",
        "Chandauli",
        "Chandausi",
        "Chandpur",
        "Charkhari",
        "Charthawal",
        "Chhaprauli",
        "Chharra",
        "Chhata",
        "Chhibramau",
        "Chhitauni",
        "Chhutmalpur",
        "Chillupar",
        "Chirgaon",
        "Chitrakoot Dham",
        "Chopan",
        "Chunar",
        "Churk",
        "Colonelganj",
        "Dadri",
        "Dalmau",
        "Dankaur",
        "Daraganj",
        "Daranagar",
        "Dasna",
        "Dataganj",
        "Daurala",
        "Dayal Bagh",
        "Deoband",
        "Deogarh",
        "Deoranian",
        "Deoria",
        "Derapur",
        "Dewa",
        "Dhampur",
        "Dhanaura",
        "Dhanghata",
        "Dharau",
        "Dhaurahra",
        "Dibai",
        "Divrasai",
        "Dohrighat",
        "Domariaganj",
        "Dostpur",
        "Dudhi",
        "Etah",
        "Etawah",
        "Etmadpur",
        "Faizabad",
        "Farah",
        "Faridnagar",
        "Faridpur",
        "Farrukhabad",
        "Fatehabad",
        "Fatehganj West",
        "Fatehgarh",
        "Fatehpur",
        "Fatehpur (Barabanki)",
        "Fatehpur Chaurasi",
        "Fatehpur Sikri",
        "Firozabad",
        "Gahlon",
        "Gahmar",
        "Gaini",
        "Gajraula",
        "Gangoh",
        "Ganj Dundwara",
        "Ganj Muradabad",
        "Garautha",
        "Garhi Pukhta",
        "Garhmuktesar",
        "Gauriganj",
        "Gautam Buddha Nagar",
        "Gawan",
        "Ghatampur",
        "Ghazipur",
        "Ghiror",
        "Ghorawal",
        "Ghosi",
        "Gohand",
        "Gokul",
        "Gola Bazar",
        "Gola Gokarannath",
        "Gonda",
        "Gopamau",
        "Gorakhpur",
        "Gosainganj",
        "Goshainganj",
        "Govardhan",
        "Greater Noida",
        "Gulaothi",
        "Gunnaur",
        "Gursahaiganj",
        "Gursarai",
        "Gyanpur",
        "Haldaur",
        "Hamirpur",
        "Handia",
        "Haraipur",
        "Haraiya",
        "Harchandpur",
        "Hardoi",
        "Harduaganj",
        "Hasanpur",
        "Hastinapur",
        "Hata",
        "Hathras",
        "Hulas",
        "Iglas",
        "Ikauna",
        "Indergarh",
        "Indragarh",
        "Islamnagar",
        "Itaunja",
        "Jagdishpur",
        "Jagnair",
        "Jahanabad",
        "Jahanabad (Pilibhit)",
        "Jahangirabad",
        "Jahangirpur",
        "Jainpur",
        "Jais",
        "Jalalabad",
        "Jalali",
        "Jalalpur",
        "Jalaun",
        "Jalesar",
        "Janghai",
        "Jansath",
        "Jarwa",
        "Jarwal",
        "Jasrana",
        "Jaswantnagar",
        "Jaunpur",
        "Jewar",
        "Jhalu",
        "Jhansi",
        "Jhinjhak",
        "Jhinjhana",
        "Jhusi",
        "Jyotiba Phule Nagar",
        "Kabrai",
        "Kachhwa",
        "Kadaura",
        "Kadipur",
        "Kaimganj",
        "Kairana",
        "Kakori",
        "Kakrala",
        "Kalinagar",
        "Kalpi",
        "Kalyanpur",
        "Kamalganj",
        "Kampil",
        "Kandhla",
        "Kannauj",
        "Kanpur",
        "Kant",
        "Kanth",
        "Kaptanganj",
        "Kara",
        "Karari",
        "Karbigwan",
        "Karchana",
        "Karhal",
        "Kasganj",
        "Katra",
        "Kausani",
        "Kemri",
        "Khada",
        "Khaga",
        "Khailar",
        "Khair",
        "Khairabad",
        "Khalilabad",
        "Khanpur",
        "Kharela",
        "Khargupur",
        "Kharkhauda",
        "Khatauli",
        "Khekra",
        "Kheri",
        "Khudaganj",
        "Khurja",
        "Khutar",
        "Kirakat",
        "Kiraoli",
        "Kiratpur",
        "Kishanpur",
        "Kishni",
        "Kithor",
        "Konch",
        "Kopaganj",
        "Kosi",
        "Kota",
        "Kotra",
        "Kuchesar",
        "Kudarkot",
        "Kulpahar",
        "Kunda",
        "Kundarkhi",
        "Kurara",
        "Kurebharsaidkhanpur",
        "Kushinagar",
        "Kusmara",
        "Kuthaund",
        "Laharpur",
        "Lakhimpur",
        "Lakhna",
        "Lalganj",
        "Lalitpur",
        "Lambhua",
        "Lar",
        "Lawar Khas",
        "Loni",
        "Lucknow",
        "Machhlishahr",
        "Madhoganj",
        "Madhogarh",
        "Maghar",
        "Mahaban",
        "Maharajganj",
        "Mahmudabad",
        "Mahoba",
        "Maholi",
        "Mahrajganj",
        "Mahrajganj (Raebareli)",
        "Mahroni",
        "Mahul",
        "Mailani",
        "Mainpuri",
        "Majhupur",
        "Makanpur",
        "Malasa",
        "Malihabad",
        "Mandawar",
        "Maniar",
        "Manikpur",
        "Manjhanpur",
        "Mankapur",
        "Marahra",
        "Mariahu",
        "Mataundh",
        "Mathura",
        "Mau",
        "Mau Aimma",
        "Maudaha",
        "Maurawan",
        "Mawana",
        "Mawar",
        "Meerut",
        "Mehnagar",
        "Mehndawal",
        "Milak",
        "Milkipur",
        "Miranpur",
        "Miranpur Katra",
        "Mirganj",
        "Mirzapur",
        "Misrikh",
        "Mohan",
        "Mohanpur",
        "Moth",
        "Mubarakpur",
        "Muhammadabad",
        "Mukteshwar",
        "Mungra Badshahpur",
        "Munsyari",
        "Muradnagar",
        "Mursan",
        "Musafir-Khana",
        "Musafirkhana",
        "Muzaffarnagar",
        "Nadigaon",
        "Nagina",
        "Nagla",
        "Nagram",
        "Najibabad",
        "Nakur",
        "Nanauta",
        "Nandgaon",
        "Nanpara",
        "Naraini",
        "Narauli",
        "Naraura",
        "Naugama",
        "Naurangpur",
        "Nautanwa",
        "Nawabganj",
        "Nawabganj (Barabanki)",
        "Nawabganj (Bareilly)",
        "Newara",
        "Nichlaul",
        "Nigoh",
        "Nihtaur",
        "Niwari",
        "Nizamabad",
        "Noida",
        "Nurpur",
        "Obra",
        "Orai",
        "Oran",
        "Pachperwa",
        "Padrauna",
        "Pahasu",
        "Paigaon",
        "Pali",
        "Palia Kalan",
        "Pandit Deen Dayal Upadhyaya Nagar",
        "Parichha",
        "Parichhatgarh",
        "Parshadepur",
        "Pathakpura",
        "Patiali",
        "Patti",
        "Pawayan",
        "Payagpur",
        "Phalauda",
        "Phaphamau",
        "Phaphund",
        "Phariha",
        "Pheona",
        "Phulpur",
        "Pichhaura",
        "Pihani",
        "Pilibhit",
        "Pilkhua",
        "Pinahat",
        "Pipraich",
        "Pipri",
        "Pratapgarh",
        "Prayagraj",
        "Prayagraj (Allahabad)",
        "Pukhrayan",
        "Puranpur",
        "Purmafi",
        "Purwa",
        "Qadirganj",
        "Rabupura",
        "Radha Kund",
        "Raebareli",
        "Rajapur",
        "Ramkola",
        "Ramnagar",
        "Rampur",
        "Rampura",
        "Ranipur",
        "Ranipur Barsi",
        "Rasra",
        "Rasulabad",
        "Rath",
        "Raya",
        "Rehar",
        "Renukut",
        "Reoti",
        "Reotipur",
        "Richha",
        "Robertsganj",
        "Rudarpur",
        "Rudauli",
        "Rura",
        "Sabalpur",
        "Sachendi",
        "Sadabad",
        "Sadat",
        "Safipur",
        "Saharanpur",
        "Sahaspur",
        "Sahaswan",
        "Sahawar",
        "Sahibabad",
        "Sahpau",
        "Saidpur",
        "Sakhanu",
        "Sakit",
        "Salempur",
        "Salon",
        "Samthar",
        "Sandi",
        "Sandila",
        "Sant Ravi Das Nagar",
        "Sarai Akil",
        "Sarai Ekdil",
        "Sarai Mir",
        "Sarauli",
        "Sardhana",
        "Sarila",
        "Sarurpur",
        "Sasni",
        "Satrikh",
        "Saurikh",
        "Sector",
        "Seohara",
        "Shahabad",
        "Shahganj",
        "Shahi",
        "Shahjahanpur",
        "Shahpur",
        "Shamsabad",
        "Shankargarh",
        "Shergarh",
        "Sherkot",
        "Shibnagar",
        "Shikarpur",
        "Shikohabad",
        "Shishgarh",
        "Shivrajpur",
        "Siddharthnagar",
        "Siddhaur",
        "Sidhauli",
        "Sidhpura",
        "Sikandarabad",
        "Sikandarpur",
        "Sikandra",
        "Sikandra Rao",
        "Sirathu",
        "Sirsa",
        "Sirsaganj",
        "Sirsi",
        "Sisauli",
        "Siswa Bazar",
        "Sitapur",
        "Soron",
        "Suar",
        "Sultanpur",
        "Surianwan",
        "Tajpur",
        "Talbahat",
        "Talgram",
        "Tanda",
        "Terha",
        "Thakurdwara",
        "Thana Bhawan",
        "Tikaitnagar",
        "Tikri",
        "Tilhar",
        "Tilsahri",
        "Tindwari",
        "Titron",
        "Tori Fatehpur",
        "Tulsipur",
        "Tundla",
        "Ugu",
        "Ujhani",
        "Umri",
        "Un",
        "Unnao",
        "Usawan",
        "Usehat",
        "Uska",
        "Utraula",
        "Varanasi",
        "Vindhyachal",
        "Vrindavan",
        "Walterganj",
        "Wazirganj",
        "Yusufpur",
        "Zafarabad",
        "Zaidpur",
        "Zamania"
    ],
    "Uttarakhand": [
        "Almora",
        "Bageshwar",
        "Banbasa",
        "Barkot",
        "Bazpur",
        "Bhim Tal",
        "Bhimtal",
        "Bhowali",
        "Birbhaddar",
        "Chakrata",
        "Chamoli",
        "Champawat",
        "Clement Town",
        "Devaprayag",
        "Dharchula",
        "Doiwala",
        "Dugadda",
        "Dwarahat",
        "Garhwal",
        "Haldwani",
        "Harbatpur",
        "Haridwar",
        "Jaspur",
        "Joshimath",
        "Kaladhungi",
        "Kalagarh Project Colony",
        "Kashipur",
        "Khatima",
        "Kichha",
        "Kotdwara",
        "Laksar",
        "Lansdowne",
        "Lohaghat",
        "Manglaur",
        "Mussoorie",
        "Naini Tal",
        "Narendranagar",
        "Pauri",
        "Pipalkoti",
        "Pithoragarh",
        "Raipur",
        "Raiwala Bara",
        "Ramnagar",
        "Ranikhet",
        "Rishikesh",
        "Roorkee",
        "Rudraprayag",
        "Rudrapur",
        "Sitarganj",
        "Srinagar",
        "Sultanpur",
        "Tanakpur",
        "Tehri",
        "Tehri-Garhwal",
        "Uttarkashi",
        "Vikasnagar"
    ],
    "West Bengal": [
        "Adra",
        "Ahmedpur",
        "Aistala",
        "Alipurduar",
        "Amlagora",
        "Amta",
        "Amtala",
        "Andal",
        "Arambagh community development block",
        "Ashoknagar Kalyangarh",
        "Badkulla",
        "Baduria",
        "Bagdogra",
        "Bagnan",
        "Bagula",
        "Bahula",
        "Baidyabati",
        "Bakreswar",
        "Balarampur",
        "Bali Chak",
        "Bally",
        "Balurghat",
        "Baneswar",
        "Bangaon",
        "Bankra",
        "Bankura",
        "Bansberia",
        "Barabazar",
        "Baranagar",
        "Barasat",
        "Bardhaman",
        "Barjora",
        "Barrackpore",
        "Baruipur",
        "Basanti",
        "Basirhat",
        "Bawali",
        "Begampur",
        "Belda",
        "Beldanga",
        "Beliatore",
        "Berhampore",
        "Bhadreswar",
        "Bhandardaha",
        "Bhatpara",
        "Bishnupur",
        "Bolpur",
        "Budge Budge",
        "Canning",
        "Chakapara",
        "Chakdaha",
        "Champadanga",
        "Champahati",
        "Champdani",
        "Chandannagar",
        "Chandrakona",
        "Chittaranjan",
        "Churulia",
        "Contai",
        "Cooch Behar",
        "Cossimbazar",
        "Dalkola",
        "Dam Dam",
        "Darjeeling",
        "Daulatpur",
        "Debagram",
        "Debipur",
        "Dhulagari",
        "Dhulian",
        "Dhupguri",
        "Diamond Harbour",
        "Digha",
        "Dinhata",
        "Domjur",
        "Dubrajpur",
        "Durgapur",
        "Egra",
        "Falakata",
        "Farakka",
        "Fort Gloster",
        "Gaighata community development block",
        "Gairkata",
        "Gangadharpur",
        "Gangarampur",
        "Garui",
        "Garulia",
        "Ghatal",
        "Giria",
        "Gobardanga",
        "Gobindapur",
        "Gopalpur",
        "Gopinathpur",
        "Gorubathan",
        "Gosaba",
        "Gosanimari",
        "Gurdaha",
        "Guskhara",
        "Habra",
        "Haldia",
        "Haldibari",
        "Halisahar",
        "Harindanga",
        "Haringhata",
        "Haripur",
        "Hasimara",
        "Hindusthan Cables Town",
        "Howrah",
        "Ichapur",
        "Islampur",
        "Jafarpur",
        "Jaigaon",
        "Jamuria",
        "Jangipur",
        "Jaynagar Majilpur",
        "Jejur",
        "Jhalida",
        "Jhilimili",
        "Kakdwip",
        "Kalaikunda",
        "Kaliaganj",
        "Kalimpong",
        "Kalna",
        "Kalyani",
        "Kamarhati",
        "Kamarpukur",
        "Kanchrapara",
        "Kandi",
        "Karimpur",
        "Katwa",
        "Kenda",
        "Keshabpur",
        "Kharagpur",
        "Kharar",
        "Kharba",
        "Khardah",
        "Khatra",
        "Kirnahar",
        "Kolkata",
        "Konnagar",
        "Krishnanagar",
        "Krishnapur",
        "Kshirpai",
        "Kulpi",
        "Kultali",
        "Kulti",
        "Kurseong",
        "Lalgarh",
        "Lalgola",
        "Loyabad",
        "Madanpur",
        "Madhyamgram",
        "Mahiari",
        "Mahishadal community development block",
        "Mainaguri",
        "Manikpara",
        "Masila",
        "Mathabhanga",
        "Medinipur",
        "Memari",
        "Mirik",
        "Monoharpur",
        "Muragacha",
        "Murshidabad",
        "Nabadwip",
        "Nabagram",
        "Nagarukhra",
        "Nagrakata",
        "Naihati",
        "Naksalbari",
        "Nalhati",
        "Nalpur",
        "Nandigram",
        "Nangi",
        "Odlabari",
        "Paikpara",
        "Panagarh",
        "Panchla",
        "Panchmura",
        "Pandua",
        "Panihati",
        "Panskura",
        "Parbatipur",
        "Patiram",
        "Patrasaer",
        "Patuli",
        "Pujali",
        "Purulia",
        "Raghudebbati",
        "Raghunathpur",
        "Raiganj",
        "Rajpur Sonarpur",
        "Ramchandrapur",
        "Ramjibanpur",
        "Ramnagar",
        "Rampur Hat",
        "Ranaghat",
        "Raniganj",
        "Raypur",
        "Rishra",
        "Sahapur",
        "Sainthia",
        "Salanpur community development block",
        "Sankarpur",
        "Sankrail",
        "Santipur",
        "Santoshpur",
        "Sarenga",
        "Serampore",
        "Serpur",
        "Shyamnagar West Bengal",
        "Siliguri",
        "Singur",
        "Sodpur",
        "Solap",
        "Sonada",
        "Sonamukhi",
        "Sonarpur community development block",
        "Srikhanda",
        "Srirampur",
        "Suri",
        "Takdah",
        "Taki",
        "Tamluk",
        "Tarakeswar",
        "Titagarh",
        "Tufanganj",
        "Tulin",
        "Uchalan",
        "Ula",
        "Uluberia",
        "Uttarpara Kotrung"
    ]
}
</script>

<script>

    let selectedDestination = '';
    let selectedDate = '';
    let selectedTime = '';

    let iti = null;

    // State/city JSON is embedded in this same Blade file.
    const stateCityData = JSON.parse(document.getElementById('stateCityData').textContent);
    let bookingSubmitting = false;

    function closeBookingDropdowns() {
        ['state', 'city', 'counselor'].forEach(function (type) {
            const options = document.getElementById(type + '_options');
            const trigger = document.querySelector(
                '#' + type + '-dropdown-wrapper .custom-counselor-selected'
            );
            if (options) options.classList.remove('open');
            if (trigger) {
                trigger.classList.remove('active-focus');
                trigger.setAttribute('aria-expanded', 'false');
            }
        });
    }

    function toggleBookingDropdown(type, event) {
        event.stopPropagation();
        const trigger = document.querySelector(
            '#' + type + '-dropdown-wrapper .custom-counselor-selected'
        );
        if (!trigger || trigger.disabled) return;
        const options = document.getElementById(type + '_options');
        const wasOpen = options.classList.contains('open');
        closeBookingDropdowns();
        if (!wasOpen) {
            options.classList.add('open');
            trigger.classList.add('active-focus');
            trigger.setAttribute('aria-expanded', 'true');
            const search = document.getElementById(type + '_search');
            if (search) {
                search.value = '';
                filterBookingLocations(type, '');
                document.getElementById(type + '_results').scrollTop = 0;
                search.focus();
            }
        }
    }

    function toggleStateDropdown(event) { toggleBookingDropdown('state', event); }
    function toggleCityDropdown(event) { toggleBookingDropdown('city', event); }

    function setLocationText(type, text, selected) {
        const element = document.getElementById(type + '_selected_text');
        element.textContent = text;
        element.style.color = selected ? '#000' : '#475569';
        element.style.fontWeight = selected ? '500' : '400';
    }

    function normalizeLocationSearch(value) {
        return value.normalize('NFD').replace(/[\u0300-\u036f]/g, '').toLowerCase().trim();
    }

    function filterBookingLocations(type, query) {
        const term = normalizeLocationSearch(query);
        const results = document.getElementById(type + '_results');
        let matches = 0;
        results.querySelectorAll('.custom-counselor-option').forEach(function (option) {
            option.hidden = !normalizeLocationSearch(option.textContent).includes(term);
            if (!option.hidden) matches++;
        });
        document.getElementById(type + '_empty').hidden = matches > 0;
        results.scrollTop = 0;
    }

    function renderBookingLocationOptions(type, names) {
        const results = document.getElementById(type + '_results');
        results.replaceChildren();
        names.forEach(function (name) {
            const option = document.createElement('div');
            option.className = 'custom-counselor-option';
            option.textContent = name;
            option.addEventListener('click', function (event) {
                if (type === 'state') selectState(name, event);
                else selectCity(name, event);
            });
            results.appendChild(option);
        });
        document.getElementById(type + '_search').value = '';
        filterBookingLocations(type, '');
    }

    function initializeStateCities() {
        renderBookingLocationOptions('state', Object.keys(stateCityData).sort());
    }

    function selectState(state, event) {
        event.stopPropagation();
        if (!Object.prototype.hasOwnProperty.call(stateCityData, state)) return;
        $('#state_input').val(state);
        $('#city_input').val('');
        $('#city_trigger').prop('disabled', false);
        $('#locationError').prop('hidden', true);
        setLocationText('state', state, true);
        setLocationText('city', 'Select City', false);

        renderBookingLocationOptions('city', stateCityData[state]);
        closeBookingDropdowns();
    }

    function selectCity(city, event) {
        event.stopPropagation();
        const state = $('#state_input').val();
        if (!Object.prototype.hasOwnProperty.call(stateCityData, state) ||
            !stateCityData[state].includes(city)) return;
        $('#city_input').val(city);
        setLocationText('city', city, true);
        $('#locationError').prop('hidden', true);
        closeBookingDropdowns();
    }

    function validateBookingLocation() {
        const state = $('#state_input').val();
        const city = $('#city_input').val();
        let message = '';
        if (!Object.prototype.hasOwnProperty.call(stateCityData, state)) message = 'Please select your state / UT.';
        else if (!stateCityData[state].includes(city)) message = 'Please select your city.';
        if (!message) return true;
        $('#locationError').text(message).prop('hidden', false);
        document.getElementById(state ? 'city_trigger' : 'state_trigger').focus();
        return false;
    }

    function setBookingProcessing(processing) {
        bookingSubmitting = processing;
        $('#scheduleBtn').prop('disabled', processing)
            .text(processing ? 'Processing...' : 'Schedule Event')
            .css({ opacity: processing ? '0.7' : '1', cursor: processing ? 'not-allowed' : 'pointer' });
    }

    document.addEventListener('click', function (event) {
        if (!event.target.closest('#bookingForm .custom-counselor-dropdown')) closeBookingDropdowns();
    });
    document.getElementById('bookingForm').addEventListener('keydown', function (event) {
        if (event.key === 'Escape') closeBookingDropdowns();
    });
    document.getElementById('bookingForm').addEventListener('reset', function () {
        $('#state_input, #city_input, #counselor_input').val('');
        $('#city_trigger').prop('disabled', true);
        $('#city_results').empty();
        $('#state_search, #city_search').val('');
        filterBookingLocations('state', '');
        $('#city_empty').prop('hidden', true);
        $('#locationError').prop('hidden', true);
        setLocationText('state', 'Select State / UT', false);
        setLocationText('city', 'Select State First', false);
        $('#counselor_selected_text').text('Select Counselor');
        closeBookingDropdowns();
    });


    ['state', 'city'].forEach(function (type) {
        document.getElementById(type + '_search').addEventListener('keydown', function (event) {
            if (event.key === 'Enter') {
                // Enter selects a result instead of submitting the booking form.
                event.preventDefault();
                event.stopPropagation();
                const first = document.querySelector(
                    '#' + type + '_results .custom-counselor-option:not([hidden])'
                );
                if (first) {
                    first.click();
                    document.getElementById(type + '_trigger').focus();
                }
            } else if (event.key === 'Escape') {
                event.preventDefault();
                event.stopPropagation();
                closeBookingDropdowns();
                document.getElementById(type + '_trigger').focus();
            }
        });
    });

    initializeStateCities();


    // Prevent non-numeric input on phone field
    $(document).on('input', '#phone', function() {
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    function openWizard(){

        $('#wizardModal').fadeIn();

        if(!iti && typeof window.intlTelInput === 'function'){

            iti = window.intlTelInput(document.querySelector("#phone"), {

                initialCountry:"in",

                utilsScript:"https://cdn.jsdelivr.net/npm/intl-tel-input@23.0.10/build/js/utils.js"
            });
        }

        renderCalendar();
    }

    function closeWizard(){

        $('#wizardModal').fadeOut();

        $('#bookingForm')[0].reset();

        $('.wiz-page').removeClass('active');

        $('#step1').addClass('active');
    }

    function goStep(step){

        $('.wiz-page').removeClass('active');

        $('#step'+step).addClass('active');
    }

    function selectDestination(name){

        selectedDestination = name;

        $('#selectedCountryText').text(name);

        $('#finalCountry').text(name);

        $('#destinationInput').val(name);

        goStep(2);

        renderCalendar();
    }

    function renderCalendar(){

        let html = '';

        const days = ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'];

        for(let i=0;i<7;i++){

            let d = new Date();

            d.setDate(d.getDate()+i);

            let dateStr = d.toISOString().split('T')[0];

            html += `
                <div class="day-box"
                     onclick="selectDate('${dateStr}',this)">

                    <div>${days[d.getDay()]}</div>

                    <div style="margin-top:8px;font-weight:700;">
                        ${d.getDate()}
                    </div>

                </div>
            `;
        }

        $('#calendarRow').html(html);
    }

    function selectDate(date,el){

        selectedDate = date;

        $('#dateInput').val(date);

        $('.day-box').removeClass('active');

        $(el).addClass('active');

        $('#slotContainer').html('Loading...');

        $.get('{{ url("get-slots") }}/'+date,function(data){

            let html='';

            data.forEach(function(slot){

                html += `
                    <div class="slot"
                         onclick="selectTime('${slot}',this)">
                        ${slot}
                    </div>
                `;
            });

            $('#slotContainer').html(html);
        });
    }

    function selectTime(time,el){

        selectedTime = time;

        $('#timeInput').val(time);

        $('.slot').removeClass('active');

        $(el).addClass('active');

        $('#confirmBtn').prop('disabled',false);
    }

    $('#bookingForm').submit(function(e){
        e.preventDefault();
        if (bookingSubmitting || !validateBookingLocation()) return;

        const mobile = $('#phone').val().replace(/[^0-9]/g, '');
        if (mobile.length !== 10) {
            alert('Please enter a valid 10 digit mobile number');
            return;
        }

        setBookingProcessing(true);

        $.ajax({
            url: '{{ url("book") }}',
            type: 'POST',
            // Includes state, city, counselor, CSRF and all existing fields.
            data: $(this).serialize(),
            success: function(res){
                if (!res || res.success === false || !res.meeting_link) {
                    alert((res && res.message) || 'Could not confirm the booking. Please try again.');
                    return;
                }
                $('#finalScheduleText').text(
                    'Your meeting for ' + selectedDestination +
                    ' has been scheduled on ' + selectedDate + ' at ' + selectedTime
                );
                $('#meetingLink').attr('href', res.meeting_link).text(res.meeting_link);
                goStep(4);
                if (res.whatsapp_url) {
                    setTimeout(function(){ window.location.href = res.whatsapp_url; }, 1000);
                }
            },
            error: function(xhr){
                const response = xhr.responseJSON || {};
                const errors = response.errors ? Object.values(response.errors).flat().join('\n') : '';
                alert(errors || response.message || 'Something went wrong');
            },
            complete: function(){ setBookingProcessing(false); }
        });
    });

</script>

</body>
</html>