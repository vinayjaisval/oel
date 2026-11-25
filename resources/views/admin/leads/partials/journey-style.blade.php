    <link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-select.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.2/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <style>
        .octicon.octicon-light-bulb {
            position: absolute;
            left: 31px;
            top: 43px;
            font-size: 12px;
            width: 99%;
            text-align: center;
        }

    </style>
    <Style>
        .bs4-order-tracking {
            margin-bottom: 30px;
            overflow: hidden;
            color: #878788;
            padding-left: 0px;
            margin-top: 30px
        }

        .bs4-order-tracking li {
            list-style-type: none;
            font-size: 13px;
            width: 9%;
            float: left;
            position: relative;
            font-weight: 400;
            color: #878788;
            text-align: center
        }
        .bg-primary2{
            background-color:rgb(62, 62, 145);
        }

        .bs4-order-tracking li:first-child:before {
            margin-left: 15px !important;
            padding-left: 11px !important;
            text-align: left !important
        }

        .bs4-order-tracking li:last-child:before {
            margin-right: 5px !important;
            padding-right: 11px !important;
            text-align: right !important
        }

        .bs4-order-tracking li>div {
            color: #fff;
            width: 29px;
            text-align: center;
            line-height: 29px;
            display: block;
            font-size: 12px;
            background: rgb(62, 62, 145);
            border-radius: 50%;
            margin: auto
        }

        .bs4-order-tracking li:after {
            content: '';
            width: 150%;
            height: 2px;
            background: #878788;
            position: absolute;
            left: 0%;
            right: 0%;
            top: 15px;
            z-index: -1
        }

        .bs4-order-tracking li:first-child:after {
            left: 50%
        }

        .bs4-order-tracking li:last-child:after {
            left: 0% !important;
            width: 0% !important
        }

        .bs4-order-tracking li.active {
            font-weight: bold;
            color: #dc3545
        }

        .bs4-order-tracking li.active>div {
            background: #dc3545
        }

        .bs4-order-tracking li.active:after {
            background: #dc3545
        }

        .card-timeline {
            background-color: #fff;
            z-index: 0
        }

        .bootstrap-select .dropdown-menu {
    min-width: 100%;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
    max-height: 300px !important;
}
    </style>
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script> --}}
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="{{ asset('assets/css/apply-360-redesign.css') }}">
