    <!-- Favicon icon-->
    <link rel="icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon"/>
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon"/>

    <!-- Flag icon css -->
    <link rel="stylesheet" href="{{ asset('assets/css/vendors/flag-icon.css') }}"/>
    <!-- iconly-icon-->
    <link rel="stylesheet" href="{{ asset('assets/css/iconly-icon.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/css/bulk-style.css') }}"/>
    <!-- iconly-icon-->
    <link rel="stylesheet" href="{{ asset('assets/css/themify.css') }}"/>
    <!--fontawesome-->
    <link rel="stylesheet" href="{{ asset('assets/css/fontawesome-min.css') }}"/>
    <!-- Whether Icon css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/weather-icons/weather-icons.min.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/scrollbar.css') }}"/>
    <!-- Slick css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/slick.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/slick-theme.css') }}"/>
    <!-- App css -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}"/>
    <link id="color" rel="stylesheet" href="{{ asset('assets/css/color-1.css') }}" media="screen"/>

 <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap" rel="stylesheet">
<style>
    *:not(i) {
        font-family: "Cairo", sans-serif !important;
        font-optical-sizing: auto !important;
        font-weight: 700 !important;
        font-style: normal !important;
        font-variation-settings:"slnt" 0 !important;
    }
</style>
@stack('styles')