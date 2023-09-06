<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="{{ asset('users/css/main.css') . '?v=' . time() }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="icon" type="image/x-icon" href="{{ asset('media/client-logos/logo.png') }}">
    <!--begin::Global Theme Styles(used by all pages)-->
    {{-- <link href="{{ asset('plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" /> --}}
    {{-- <link href="{{ asset('plugins/custom/prismjs/prismjs.bundle.css') }}" rel="stylesheet" type="text/css" /> --}}
    {{-- <link href="{{ asset('css/style.bundle.css') }}" rel="stylesheet" type="text/css" /> --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <title>Warung Aceh Bang Ari</title>
    @yield('css')
    <style>
        #loader-wrapper .loader-section {
            position: fixed;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgb(241, 240, 240);
            z-index: 2000;
        }

        #loader-wrapper .loader-section.section-left {
            left: 0;
        }

        #loader-wrapper .loader-section.section-right {
            right: 0;
        }

        #loader {
            z-index: 1001;
            /* anything higher than z-index: 1000 of .loader-section */
        }

        /* Loaded */
        .loaded #loader-wrapper .loader-section.section-left {
            -webkit-transform: translateX(-100%);
            /* Chrome, Opera 15+, Safari 3.1+ */
            -ms-transform: translateX(-100%);
            /* IE 9 */
            transform: translateX(-100%);
            /* Firefox 16+, IE 10+, Opera */
        }

        .loaded #loader-wrapper .loader-section.section-right {
            -webkit-transform: translateX(100%);
            /* Chrome, Opera 15+, Safari 3.1+ */
            -ms-transform: translateX(100%);
            /* IE 9 */
            transform: translateX(100%);
            /* Firefox 16+, IE 10+, Opera */
        }

        .loaded #loader {
            opacity: 0;
        }

        .loaded #loader-wrapper {
            visibility: hidden;
        }

        .loaded #loader {
            opacity: 0;
            -webkit-transition: all 0.3s ease-out;
            transition: all 0.3s ease-out;
        }

        .loaded #loader-wrapper .loader-section.section-right,
        .loaded #loader-wrapper .loader-section.section-left {

            -webkit-transition: all 0.3s 0.3s ease-out;
            transition: all 0.3s 0.3s ease-out;
        }

        .loaded #loader-wrapper {
            -webkit-transform: translateY(-100%);
            -ms-transform: translateY(-100%);
            transform: translateY(-100%);

            -webkit-transition: all 0.3s 0.6s ease-out;
            transition: all 0.3s 0.6s ease-out;
        }
    </style>
    <style>
        /* KEYFRAMES */

        @keyframes spin {
            from {
                transform: rotate(0);
            }

            to {
                transform: rotate(359deg);
            }
        }

        @keyframes spin3D {
            from {
                transform: rotate3d(.5, .5, .5, 360deg);
            }

            to {
                transform: rotate3d(0deg);
            }
        }

        @keyframes configure-clockwise {
            0% {
                transform: rotate(0);
            }

            25% {
                transform: rotate(90deg);
            }

            50% {
                transform: rotate(180deg);
            }

            75% {
                transform: rotate(270deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        @keyframes configure-xclockwise {
            0% {
                transform: rotate(45deg);
            }

            25% {
                transform: rotate(-45deg);
            }

            50% {
                transform: rotate(-135deg);
            }

            75% {
                transform: rotate(-225deg);
            }

            100% {
                transform: rotate(-315deg);
            }
        }

        @keyframes pulse {
            from {
                opacity: 1;
                transform: scale(1);
            }

            to {
                opacity: .25;
                transform: scale(.75);
            }
        }

        /* GRID STYLING */

        * {
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
        }

        .spinner-box {
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: transparent;
        }

        /* SPINNING CIRCLE */

        .leo-border-1 {
            position: absolute;
            width: 150px;
            height: 150px;
            padding: 3px;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 50%;
            background: rgb(63, 249, 220);
            background: linear-gradient(0deg, rgba(63, 249, 220, 0.1) 33%, rgba(63, 249, 220, 1) 100%);
            animation: spin3D 1.8s linear 0s infinite;
        }

        .leo-core-1 {
            width: 100%;
            height: 100%;
            background-color: #37474faa;
            border-radius: 50%;
        }

        .leo-border-2 {
            position: absolute;
            width: 150px;
            height: 150px;
            padding: 3px;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 50%;
            background: rgb(251, 91, 83);
            background: linear-gradient(0deg, rgba(251, 91, 83, 0.1) 33%, rgba(251, 91, 83, 1) 100%);
            animation: spin3D 2.2s linear 0s infinite;
        }

        .leo-core-2 {
            width: 100%;
            height: 100%;
            background-color: #1d2630aa;
            border-radius: 50%;
        }

        /* ALTERNATING ORBITS */

        .circle-border {
            width: 150px;
            height: 150px;
            padding: 3px;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 50%;
            background: rgb(63, 249, 220);
            background: linear-gradient(0deg, rgba(63, 249, 220, 0.1) 33%, rgba(63, 249, 220, 1) 100%);
            animation: spin .8s linear 0s infinite;
        }

        .circle-core {
            width: 100%;
            height: 100%;
            background-color: #1d2630;
            border-radius: 50%;
        }

        /* X-ROTATING BOXES */

        .configure-border-1 {
            width: 115px;
            height: 115px;
            padding: 3px;
            position: absolute;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #fb5b53;
            animation: configure-clockwise 3s ease-in-out 0s infinite alternate;
        }

        .configure-border-2 {
            width: 115px;
            height: 115px;
            padding: 3px;
            left: -115px;
            display: flex;
            justify-content: center;
            align-items: center;
            background: rgb(63, 249, 220);
            transform: rotate(45deg);
            animation: configure-xclockwise 3s ease-in-out 0s infinite alternate;
        }

        .configure-core {
            width: 100%;
            height: 100%;
            background-color: #1d2630;
        }

        /* PULSE BUBBLES */

        .pulse-container {
            width: 120px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .pulse-bubble {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background-color: #3ff9dc;
        }

        .pulse-bubble-1 {
            animation: pulse .4s ease 0s infinite alternate;
        }

        .pulse-bubble-2 {
            animation: pulse .4s ease .2s infinite alternate;
        }

        .pulse-bubble-3 {
            animation: pulse .4s ease .4s infinite alternate;
        }

        /* SOLAR SYSTEM */

        .solar-system {
            width: 250px;
            height: 250px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .orbit {
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
            border: 1px solid #fafbfC;
            border-radius: 50%;
        }

        .earth-orbit {
            width: 165px;
            height: 165px;
            -webkit-animation: spin 12s linear 0s infinite;
        }

        .venus-orbit {
            width: 120px;
            height: 120px;
            -webkit-animation: spin 7.4s linear 0s infinite;
        }

        .mercury-orbit {
            width: 90px;
            height: 90px;
            -webkit-animation: spin 3s linear 0s infinite;
        }

        .planet {
            position: absolute;
            top: -5px;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background-color: #3ff9dc;
        }

        .sun {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background-color: #ffab91;
        }

        .leo {
            position: absolute;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 50%;
        }

        .blue-orbit {
            width: 165px;
            height: 165px;
            border: 1px solid #91daffa5;
            -webkit-animation: spin3D 3s linear .2s infinite;
        }

        .green-orbit {
            width: 120px;
            height: 120px;
            border: 1px solid #91ffbfa5;
            -webkit-animation: spin3D 2s linear 0s infinite;
        }

        .red-orbit {
            width: 90px;
            height: 90px;
            border: 1px solid #ffca91a5;
            -webkit-animation: spin3D 1s linear 0s infinite;
        }

        .white-orbit {
            width: 60px;
            height: 60px;
            border: 2px solid #ffffff;
            -webkit-animation: spin3D 10s linear 0s infinite;
        }

        .w1 {
            transform: rotate3D(1, 1, 1, 90deg);
        }

        .w2 {
            transform: rotate3D(1, 2, .5, 90deg);
        }

        .w3 {
            transform: rotate3D(.5, 1, 2, 90deg);
        }

        .three-quarter-spinner {
            width: 50px;
            height: 50px;
            border: 3px solid #fb5b53;
            border-top: 3px solid transparent;
            border-radius: 50%;
            animation: spin .5s linear 0s infinite;
        }
    </style>
    <style>
        .blink {
            animation: blinker 1s linear infinite;
            /* background: red; */
            /* color: white; */
            font-weight: bold;
        }

        @keyframes blinker {
            50% {
                opacity: 0;
            }
        }
    </style>
</head>

<body>
    <div id="loader-wrapper" class="d-none">
        <div id="loader"></div>

        <div class="loader-section">
            <!-- GRADIENT CIRCLE PLANES -->
            <div class="spinner-box">
                <div class="leo-border-1">
                    <div class="leo-core-1"></div>
                </div>
                <div class="leo-border-2">
                    <div class="leo-core-2"></div>
                </div>
                <h5 class="blink" style="margin-top: 200px">Memproses Pesanan..</h5>
            </div>
        </div>

    </div>

    {{-- Header Navbara --}}
    <div class="headers" id="header">
        <nav class="navbars container d-flex justify-content-center  mt-2 mb-2">
            <div class="brand">
                <img src="{{ asset('media/client-logos/logo.png') }}" class="logo-brand" />
                {{ config('appsetting.aps_name') }}
            </div>
        </nav>
        @yield('header-content')
    </div>
    {{-- End Header Navbar --}}
    {{-- <div class="product-wrap container"> --}}
    {{-- </div> --}}
    <div class="main-cart">
        <!-- LOADING DOTS... -->
        @yield('content')
    </div>
    @yield('footer')

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="{{ asset('users/js/main.js') }}"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script> --}}
    {{-- <script src="{{ asset('bootstrap/js/bootstrap.js') }}"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @yield('js')
</body>

</html>
