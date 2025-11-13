<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
                    <div class="row">
                        <div class="col-sm-6 col-12">
                            <h2>@yield('title')</h2>
                            <p class="mb-0 text-title-gray">@yield('subTitle')</p>
                        </div>
                        <div class="col-sm-6 col-12">
                            @include('layouts.partials.breadcrumb')
                        </div>
                    </div>
                </div>
            </div>
            <!-- Container-fluid starts-->
            <div class="container-fluid default-dashboard">
                <div class="row">
                    <div class="col-sm-12">
                        @yield('content')
                    </div>
                </div>
            </div>
            <!-- Container-fluid Ends-->
        </div>
