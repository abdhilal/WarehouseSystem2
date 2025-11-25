<header class="page-header row">
    <div class="logo-wrapper d-flex align-items-center col-auto"><a class="close-btn toggle-sidebar"
            href="javascript:void(0)">
            <svg class="svg-color">
                <use href="{{ asset('assets/svg/iconly-sprite.svg#Category') }}"></use>
            </svg></a></div>
    <div class="page-main-header col">
        <div class="header-left">
            <form class="form-inline search-full col" action="#" method="get">
                <div class="form-group w-100">
                    <div class="Typeahead Typeahead--twitterUsers">
                        <div class="u-posRelative">
                            <input class="demo-input Typeahead-input form-control-plaintext w-100" type="text"
                                placeholder="Search Admiro .." name="q" title="" autofocus="autofocus" />
                            <div class="spinner-border Typeahead-spinner" role="status"><span
                                    class="sr-only">Loading...</span></div><i class="close-search" data-feather="x"></i>
                        </div>
                        <div class="Typeahead-menu"></div>
                    </div>
                </div>
            </form>
            @php
                use App\Models\File;
                $files = File::where('warehouse_id', Auth()->user()->warehouse_id)->get();
                $is_default = File::where('warehouse_id', Auth()->user()->warehouse_id)
                    ->where('is_default', 1)
                    ->first();
            @endphp
            @if ($files)
                <form action="{{ route('files.filter') }}" method="POST">
                    @csrf
                    <div class="input-group">
                        <select name="file" class="form-select" id="inputGroupSelect04"
                            aria-label="Example select with button addon">
                            <option value="">{{ __('Select File') }}</option>

                            @foreach ($files as $file)
                                <option value="{{ $file->code }}"
                                    {{ isset($is_default) && $is_default->code == $file->code ? 'selected' : '' }}>
                                    {{ $file->code }}
                                </option>
                            @endforeach
                        </select>
                        <button class="btn btn-outline-secondary" type="submit">{{ __('Filter') }}</button>
                    </div>
                </form>
            @endif
        </div>
        <div class="nav-right">
            <ul class="header-right">
                <li class="custom-dropdown">
                    <div class="translate_wrapper">
                        <div class="current_lang"><a class="lang" href="javascript:void(0)"><i
                                    class="flag-icon {{ app()->getLocale() === 'ar' ? 'flag-icon-sa' : 'flag-icon-us' }}"></i>
                                <h6 class="lang-txt f-w-700">{{ app()->getLocale() === 'ar' ? 'AR' : 'EN' }}</h6>
                            </a></div>
                        <ul class="custom-menu profile-menu language-menu py-0 more_lang">
                            <li class="d-block"><a class="lang"
                                    href="{{ route('locale.switch', ['locale' => 'ar']) }}"><i
                                        class="flag-icon flag-icon-sa"></i>
                                    <div class="lang-txt">العربية</div>
                                </a></li>
                            <li class="d-block"><a class="lang"
                                    href="{{ route('locale.switch', ['locale' => 'en']) }}"><i
                                        class="flag-icon flag-icon-us"></i>
                                    <div class="lang-txt">English</div>
                                </a></li>
                        </ul>
                    </div>
                </li>
                <li class="search d-lg-none d-flex"> <a href="javascript:void(0)">
                        <svg>
                            <use href="{{ asset('assets/svg/iconly-sprite.svg#Search') }}"></use>
                        </svg></a></li>
                <li> <a class="dark-mode" href="javascript:void(0)">
                        <svg>
                            <use href="{{ asset('assets/svg/iconly-sprite.svg#moondark') }}"></use>
                        </svg></a></li>


                <li><a class="full-screen" href="javascript:void(0)">
                        <svg>
                            <use href="{{ asset('assets/svg/iconly-sprite.svg#scanfull') }}"></use>
                        </svg></a></li>


                <li class="profile-nav custom-dropdown">
                    <div class="user-wrap">
                        <div class="user-img"> <i class="fa-solid fa-user" style="font-size: 10px; color: #ffffff; background-color: var(--theme-default); padding: 8px 14px; border-radius: 50%;"></i>
                        </div>
                        <div class="user-content">
                            <h6>{{ auth()->user()->name }}</h6>
                            <p class="mb-0">{{ auth()->user()->roles[0]->name }}<i
                                    class="fa-solid fa-chevron-down"></i></p>
                        </div>
                    </div>
                    <div class="custom-menu overflow-hidden">
                        <ul class="profile-body">



                            <li class="d-flex align-items-center gap-2">

                                <use href="{{ asset('assets/svg/iconly-sprite.svg#Login') }}"></use>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf

                                    <button type="submit" class="btn btn-primary btn-sm ms-2">{{ __('Log Out') }}</button>
                                </form>

                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</header>
