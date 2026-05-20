
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

    </style>

</head>
<body>

<!-- <div class="hero">

    <img src="https://overseaseducationlane.com/public/frontend/img/oel%20(1)%201.png">

    <h1>
        Welcome to Overseas Education Lane
    </h1>

    <p>
        Your dream study destination is just a few clicks away.
        Book a session with our expert counselors today.
    </p>

    <button class="book-btn" onclick="openWizard()">
        <i class="fa-solid fa-calendar-check"></i>
        Book Online Meeting
    </button>

</div> -->

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
            Book Your Free Online   ing
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

                            <label>Your City *</label>

                            <div class="custom-counselor-dropdown" id="city-dropdown-wrapper">
                                <input type="hidden" name="city" id="city_input" required>
                                <div class="form-control custom-counselor-selected" onclick="toggleCityDropdown(event)">
                                    <div class="selected-content" id="city_selected_text">
                                        <span style="color: #475569;">Select City</span>
                                    </div>
                                    <i class="fa fa-chevron-down" style="font-size: 12px; color: #64748b;"></i>
                                </div>
                                <div class="custom-counselor-options" id="city_options">
                                    <div class="custom-counselor-option" onclick="selectCity('Lucknow', event)">Lucknow</div>
                                    <div class="custom-counselor-option" onclick="selectCity('New Delhi', event)">New Delhi</div>
                                    <div class="custom-counselor-option" onclick="selectCity('Mumbai', event)">Mumbai</div>
                                    <div class="custom-counselor-option" onclick="selectCity('Pune', event)">Pune</div>
                                    <div class="custom-counselor-option" onclick="selectCity('Hyderabad', event)">Hyderabad</div>
                                </div>
                            </div>

                            <script>
                            function toggleCityDropdown(e) {
                                e.stopPropagation();
                                var opts = document.getElementById('city_options');
                                opts.classList.toggle('open');
                                var sel = document.querySelector('#city-dropdown-wrapper .custom-counselor-selected');
                                if(opts.classList.contains('open')) {
                                    sel.classList.add('active-focus');
                                } else {
                                    sel.classList.remove('active-focus');
                                }
                                var cOpts = document.getElementById('counselor_options');
                                if(cOpts) {
                                    cOpts.classList.remove('open');
                                    var cSel = document.querySelector('#counselor-dropdown-wrapper .custom-counselor-selected');
                                    if(cSel) cSel.classList.remove('active-focus');
                                }
                            }
                            function selectCity(name, e) {
                                e.stopPropagation();
                                document.getElementById('city_input').value = name;
                                document.getElementById('city_selected_text').innerHTML = '<span style="color: #000; font-weight: 500;">' + name + '</span>';
                                document.getElementById('city_options').classList.remove('open');
                                var sel = document.querySelector('#city-dropdown-wrapper .custom-counselor-selected');
                                if(sel) sel.classList.remove('active-focus');
                            }
                            document.addEventListener('click', function(event) {
                                var dropdown = document.getElementById('city-dropdown-wrapper');
                                if (dropdown && !dropdown.contains(event.target)) {
                                    var options = document.getElementById('city_options');
                                    if(options) options.classList.remove('open');
                                    var sel = document.querySelector('#city-dropdown-wrapper .custom-counselor-selected');
                                    if(sel) sel.classList.remove('active-focus');
                                }
                            });
                            </script>

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
            'id' => 16,
            'name' => 'Rahul Sharma',
            'avatar' => asset('frontend/img/counselor-avatar-1.png'),
        ],
        [
            'id' => 19,
            'name' => 'Priya Verma',
            'avatar' => asset('frontend/img/counselor-avatar-2.png'),
        ],
        [
            'id' => 3,
            'name' => 'Aman Singh',
            'avatar' => asset('frontend/img/counselor-avatar-3.png'),
        ],
        [
            'id' => 23,
            'name' => 'Neha Gupta',
            'avatar' => asset('frontend/img/counselor-avatar-4.png'),
        ],
        [
            'id' => 5,
            'name' => 'Vikas Yadav',
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
                                e.stopPropagation();
                                var opts = document.getElementById('counselor_options');
                                opts.classList.toggle('open');
                                var sel = document.querySelector('#counselor-dropdown-wrapper .custom-counselor-selected');
                                if(opts.classList.contains('open')) {
                                    sel.classList.add('active-focus');
                                } else {
                                    sel.classList.remove('active-focus');
                                }
                                var cityOpts = document.getElementById('city_options');
                                if(cityOpts) {
                                    cityOpts.classList.remove('open');
                                    var citySel = document.querySelector('#city-dropdown-wrapper .custom-counselor-selected');
                                    if(citySel) citySel.classList.remove('active-focus');
                                }
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

<script>

    let selectedDestination = '';
    let selectedDate = '';
    let selectedTime = '';

    let iti = null;

    // Prevent non-numeric input on phone field
    $(document).on('input', '#phone', function() {
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    function openWizard(){

        $('#wizardModal').fadeIn();

        if(!iti){

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

        let mobile = $('#phone').val().replace(/[^0-9]/g,'');

        if(!mobile || mobile.length !== 10){

            alert('Please enter a valid 10 digit mobile number');

            return;
        }

        $.ajax({

            url:'{{ url("book") }}',

            type:'POST',

            data:$(this).serialize(),

           success:function(res){

                $('#finalScheduleText').html(`
                    Your meeting for
                    <b>${selectedDestination}</b>
                    has been scheduled on
                    <b>${selectedDate}</b>
                    at
                    <b>${selectedTime}</b>
                `);

                $('#meetingLink').attr('href', res.meeting_link);

                $('#meetingLink').text(res.meeting_link);

                goStep(4);

                setTimeout(function(){

                    window.location.href = res.whatsapp_url;

                },1000);

            }, // IMPORTANT COMMA

            error:function(xhr){

                console.log(xhr);

                if(xhr.responseJSON && xhr.responseJSON.message){

                    alert(xhr.responseJSON.message);

                }else{

                    alert('Something went wrong');
                }
            }
        });
    });

</script>

</body>
</html>