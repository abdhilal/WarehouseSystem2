<!DOCTYPE html >
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
@include('layouts.partials.head')
  <body class="{{ app()->getLocale() === 'ar' ? 'rtl' : '' }}">
    @include('layouts.partials.alert')
    <!-- page-wrapper Start-->
    <!-- tap on top starts-->
    <div class="tap-top"><i class="iconly-Arrow-Up icli"></i></div>
    <!-- tap on tap ends-->
    @include('layouts.partials.loader')
    <div class="page-wrapper compact-wrapper" id="pageWrapper">
        @include('layouts.partials.header')
      <!-- Page Body Start-->
      <div class="page-body-wrapper">
        <!-- Page sidebar start-->
      @auth
          @include('layouts.partials.aside')
      @endauth
        <!-- Page sidebar end-->

        @include('layouts.partials.body')
        @include('layouts.partials.footer')
      </div>
    </div>
    @include('layouts.partials.scripts')
  </body>
</html>
