<!DOCTYPE html>

<!--
Template Name: Metronic - Bootstrap 4 HTML, React, Angular 11 & VueJS Admin Dashboard Theme
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Dribbble: www.dribbble.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: https://1.envato.market/EA4JP
Renew Support: https://1.envato.market/EA4JP
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<html lang="en">

<!--begin::Head-->

<head>
    <base href="">
    <meta charset="utf-8" />
    <title>POS Sistem || Warung Aceh Bang Ari</title>
    <meta name="description" content="Updates and statistics" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="canonical" href="https://keenthemes.com/metronic" />
    <link rel="icon" type="image/x-icon" href="{{ asset('media/client-logos/logo.png') }}">

    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />

    <!--end::Fonts-->

    <!--begin::Page Vendors Styles(used by this page)-->
    <link href="{{ asset('plugins/custom/fullcalendar/fullcalendar.bundle.css') . '?v=' . time() }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('plugins/custom/leaflet/leaflet.bundle.css') . '?v=' . time() }}" rel="stylesheet"
        type="text/css" />

    <!--end::Page Vendors Styles-->

    <!--begin::Global Theme Styles(used by all pages)-->
    <link href="{{ asset('plugins/global/plugins.bundle.css') . '?v=' . time() }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('plugins/custom/prismjs/prismjs.bundle.css') . '?v=' . time() }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('css/style.bundle.css') . '?v=' . time() }}" rel="stylesheet" type="text/css" />
    @yield('css')
    <!--end::Global Theme Styles-->

    <!--begin::Layout Themes(used by all pages)-->

    <!--end::Layout Themes-->
    <link rel="shortcut icon" href="assets/media/client-logos/Logo-client-png.png" />
</head>

<!--end::Head-->

<!--begin::Body-->
{{-- Sweetalert --}}

<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled page-loading">
    @include('sweetalert::alert')



    <!--[html-partial:include:{"file":"partials/_page-loader.html"}]/-->
    @include('partials._page-loader')
    @include('partials._aside')

    @include('partials._header')
    @include('partials._header-mobile')

    <!--begin::Main-->


    <!--[html-partial:include:{"file":"partials/_header-mobile.html"}]/-->
    <div class="d-flex flex-column flex-root">

        <!--begin::Page-->
        <div class="d-flex flex-row flex-column-fluid page">

            <!--[html-partial:include:{"file":"partials/_aside.html"}]/-->

            <!--begin::Wrapper-->
            <div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">

                <!--[html-partial:include:{"file":"partials/_header.html"}]/-->

                <!--begin::Content-->
                <div class="content  d-flex flex-column flex-column-fluid" id="kt_content">

                    {{-- @include('partials._subheader.subheader-v4') --}}
                    <div class="subheader py-5 py-lg-10 gutter-b subheader-transparent" id="kt_subheader"
                        style="background-color: #931919; background-position: right bottom; background-size: auto 100%; background-repeat: no-repeat; background-image: url(/media/svg/patterns/taieri.svg)">
                        <div class="container d-flex flex-column">
                            <!--begin::Title-->
                            <div class="d-flex align-items-sm-end flex-column flex-sm-row">
                                <h2 class="d-flex align-items-center text-white mr-5 mb-0">Grand Antares Hotel</h2>
                                <span class="text-white opacity-60 font-weight-bold">POS & Order Managament
                                    System</span>
                            </div>
                            <!--end::Title-->
                        </div>
                    </div>
                    <div class="container">
                        <div class="alert alert-custom alert-white alert-shadow fade show gutter-b" role="alert">
                            <div class="alert-icon">
                                <span class="svg-icon svg-icon-xl">
                                    <!--begin::Svg Icon | path:assets/media/svg/icons/Tools/Compass.svg-->
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="0" y="0" width="24" height="24">
                                            </rect>
                                            <path
                                                d="M7.07744993,12.3040451 C7.72444571,13.0716094 8.54044565,13.6920474 9.46808594,14.1079953 L5,23 L4.5,18 L7.07744993,12.3040451 Z M14.5865511,14.2597864 C15.5319561,13.9019016 16.375416,13.3366121 17.0614026,12.6194459 L19.5,18 L19,23 L14.5865511,14.2597864 Z M12,3.55271368e-14 C12.8284271,3.53749572e-14 13.5,0.671572875 13.5,1.5 L13.5,4 L10.5,4 L10.5,1.5 C10.5,0.671572875 11.1715729,3.56793164e-14 12,3.55271368e-14 Z"
                                                fill="#000000" opacity="0.3"></path>
                                            <path
                                                d="M12,10 C13.1045695,10 14,9.1045695 14,8 C14,6.8954305 13.1045695,6 12,6 C10.8954305,6 10,6.8954305 10,8 C10,9.1045695 10.8954305,10 12,10 Z M12,13 C9.23857625,13 7,10.7614237 7,8 C7,5.23857625 9.23857625,3 12,3 C14.7614237,3 17,5.23857625 17,8 C17,10.7614237 14.7614237,13 12,13 Z"
                                                fill="#000000" fill-rule="nonzero"></path>
                                        </g>
                                    </svg>
                                    <!--end::Svg Icon-->
                                </span>
                            </div>
                            <div class="alert-text">
                                @yield('menu-detail')
                            </div>
                        </div>
                    </div>
                    @yield('content')

                    <!--Content area here-->
                </div>

                <!--end::Content-->

                <!--[html-partial:include:{"file":"partials/_footer.html"}]/-->
            </div>

            <!--end::Wrapper-->
        </div>

        <!--end::Page-->
    </div>

    <!--end::Main-->

    <!--[html-partial:include:{"file":"partials/_extras/offcanvas/quick-user.html"}]/-->

    <!--[html-partial:include:{"file":"partials/_extras/offcanvas/quick-panel.html"}]/-->

    <!--[html-partial:include:{"file":"partials/_extras/chat.html"}]/-->

    <!--[html-partial:include:{"file":"partials/_extras/scrolltop.html"}]/-->

    @include('partials._footer')
    <script>
        var HOST_URL = "";
    </script>

    <!--begin::Global Config(global config for global JS scripts)-->
    <script>
        var KTAppSettings = {
            "breakpoints": {
                "sm": 576,
                "md": 768,
                "lg": 992,
                "xl": 1200,
                "xxl": 1200
            },
            "colors": {
                "theme": {
                    "base": {
                        "white": "#ffffff",
                        "primary": "#8950FC",
                        "secondary": "#E5EAEE",
                        "success": "#1BC5BD",
                        "info": "#8950FC",
                        "warning": "#FFA800",
                        "danger": "#F64E60",
                        "light": "#F3F6F9",
                        "dark": "#212121"
                    },
                    "light": {
                        "white": "#ffffff",
                        "primary": "#E1E9FF",
                        "secondary": "#ECF0F3",
                        "success": "#C9F7F5",
                        "info": "#EEE5FF",
                        "warning": "#FFF4DE",
                        "danger": "#FFE2E5",
                        "light": "#F3F6F9",
                        "dark": "#D6D6E0"
                    },
                    "inverse": {
                        "white": "#ffffff",
                        "primary": "#ffffff",
                        "secondary": "#212121",
                        "success": "#ffffff",
                        "info": "#ffffff",
                        "warning": "#ffffff",
                        "danger": "#ffffff",
                        "light": "#464E5F",
                        "dark": "#ffffff"
                    }
                },
                "gray": {
                    "gray-100": "#F3F6F9",
                    "gray-200": "#ECF0F3",
                    "gray-300": "#E5EAEE",
                    "gray-400": "#D6D6E0",
                    "gray-500": "#B5B5C3",
                    "gray-600": "#80808F",
                    "gray-700": "#464E5F",
                    "gray-800": "#1B283F",
                    "gray-900": "#212121"
                }
            },
            "font-family": "Poppins"
        };
    </script>

    <!--end::Global Config-->
    <!--begin::Global Theme Bundle(used by all pages)-->
    <script src="{{ asset('plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('plugins/custom/prismjs/prismjs.bundle.js') }}"></script>
    <script src="{{ asset('js/scripts.bundle.js') }}"></script>

    <!--end::Global Theme Bundle-->

    <!--begin::Page Vendors(used by this page)-->
    <script src="{{ asset('plugins/custom/fullcalendar/fullcalendar.bundle.js') }}"></script>
    <script src="{{ asset('plugins/custom/leaflet/leaflet.bundle.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bluebird/3.3.5/bluebird.min.js"></script>

    <!--end::Page Vendors-->

    <!--begin::Page Scripts(used by this page)-->
    <script src="{{ asset('js/pages/widgets.js') }}"></script>

    @yield('script')

    <!--end::Page Scripts-->
</body>

<!--end::Body-->

</html>
