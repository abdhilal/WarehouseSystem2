
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
@include('layouts.partials.head')
<body class="{{ app()->getLocale() === 'ar' ? 'rtl' : '' }}">
<div class="row m-0">
    <div class="col-12 p-0">
        <div class="login-card login-dark">
            <div>
                <div>
                    <a class="logo" href="/">
                        <img class="img-fluid for-light m-auto" src="{{ asset('assets/images/logo/logo1.png') }}" alt="logo">
                        <img class="img-fluid for-dark" src="{{ asset('assets/images/logo/logo-dark.png') }}" alt="logo">
                    </a>
                </div>
                <div class="login-main">
                    <form class="theme-form" method="POST" action="{{ route('login') }}">
                        @csrf
                        <h2 class="text-center">{{ __('Sign in to account') }}</h2>
                        <p class="text-center">{{ __('Enter your email & password to login') }}</p>
                        <div class="form-group">
                            <label class="col-form-label">{{ __('Email') }}</label>
                            <input class="form-control" type="email" name="email" value="{{ old('email') }}" required placeholder="name@example.com">
                            @error('email')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">{{ __('Password') }}</label>
                            <div class="form-input position-relative">
                                <input class="form-control" type="password" name="password" required placeholder="••••••••">
                                <div class="show-hide"><span class="show"> </span></div>
                            </div>
                            @error('password')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mb-0 checkbox-checked d-flex justify-content-between align-items-center">
                           
                            <div class="text-end mt-3 w-100">
                                <button class="btn btn-primary btn-block w-100" type="submit">{{ __('Sign in') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@include('layouts.partials.scripts')
</body>
</html>
