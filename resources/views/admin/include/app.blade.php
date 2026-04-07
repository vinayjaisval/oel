<!DOCTYPE html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark"
      data-sidebar-size="lg" data-sidebar-image="none">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Admin Dashboard</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/img/favicon.png') }}">

    <!-- ===================== CSS ===================== -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/line-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/material.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/morris/morris.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">

    @yield('style')
</head>

<body>

<div class="main-wrapper">

    @include('admin.include.header')
    @include('admin.include.sidebar')

    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <div class="content container-fluid">
            @yield('main-content')
        </div>
    </div>

</div>

<!-- ===================== CORE JS ===================== -->

<!-- jQuery (LOAD ONCE ONLY) -->
<script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>

<!-- Bootstrap -->
<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

<!-- Slimscroll -->
<script src="{{ asset('assets/js/jquery.slimscroll.min.js') }}"></script>

<!-- Charts / Utilities -->
<script src="{{ asset('assets/plugins/raphael/raphael.min.js') }}"></script>
<script src="{{ asset('assets/js/greedynav.js') }}"></script>

<!-- Theme -->
<script src="{{ asset('assets/js/layout.js') }}"></script>
<script src="{{ asset('assets/js/theme-settings.js') }}"></script>
<script src="{{ asset('assets/js/app.js') }}"></script>

<!-- ===================== PAGE SCRIPTS (VERY IMPORTANT) ===================== -->
@yield('page-script')
@yield('scripts')

<!-- ===================== TOASTR ===================== -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-slimScroll/1.3.8/jquery.slimscroll.min.js"></script>
<script>
    $(document).ready(function () {
        $('#mobile_btn').on('click', function () {
            $('#sidebar').toggleClass('sidebarNew');
        });

        $('.sidebar-overlay').on('click', function () {
            $('#sidebar').removeClass('sidebarNew');
        });
    });
</script>

</body>
</html>
