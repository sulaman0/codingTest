<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Transfer Money</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <link rel="stylesheet" href="{{ asset('font/iconsmind-s/css/iconsminds.css') }}"/>
    <link rel="stylesheet" href="{{ asset('font/simple-line-icons/css/simple-line-icons.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/css/vendor/bootstrap.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/css/vendor/bootstrap.rtl.only.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/css/vendor/bootstrap-float-label.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/css/headerStyling/styles.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}?<?php echo time()?>"/>
    <link rel="stylesheet" href="{{ asset('assets/css/dore.light.blue.min.css') }}?<?php echo time()?>"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="background  no-footer">
@yield('main-content')
<script src="{{ asset('assets/js/vendor/jquery-3.3.1.min.js') }}"></script>
<script src="{{ asset('assets/js/vendor/bootstrap.bundle.min.js')}}"></script>
<script src="{{ asset('assets/js/dore.script.js') }}"></script>
<script src="{{ asset('assets/js/scripts.js') }}"></script>
@yield('script')
</body>
</html>
