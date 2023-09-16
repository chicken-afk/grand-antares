<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="{{ asset('users/css/main.css') . '?v=' . time() }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('media/client-logos/logo.png') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <!--begin::Global Theme Styles(used by all pages)-->
    {{-- <link href="{{ asset('plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" /> --}}
    {{-- <link href="{{ asset('plugins/custom/prismjs/prismjs.bundle.css') }}" rel="stylesheet" type="text/css" /> --}}
    {{-- <link href="{{ asset('css/style.bundle.css') }}" rel="stylesheet" type="text/css" /> --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <title>Grand Antares Hotel</title>
    <style>
        .sidebar {
            flex-direction: column;
            align-items: center;
            background-color: #f0f0f0;
        }

        .sidebar .logout-link {
            padding: 10px;
            background-color: #fdfdfd;
            color: #f72f2f;
            border-radius: 5px;
            text-decoration: none;
            font-size: small;
        }

        .form-control {
            font-size: 0.75rem;
        }

        .btn-primary {
            --bs-btn-color: #fff;
            --bs-btn-bg: rgb(187, 36, 36);
            --bs-btn-border-color: rgb(187, 36, 36);
            --bs-btn-hover-color: #fff;
            --bs-btn-hover-bg: rgb(187, 36, 36);
            --bs-btn-hover-border-color: rgb(187, 36, 36);
            --bs-btn-focus-shadow-rgb: 49, 132, 253;
            --bs-btn-active-color: #fff;
            --bs-btn-active-bg: rgb(187, 36, 36);
            --bs-btn-active-border-color: rgb(187, 36, 36);
            --bs-btn-active-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
            --bs-btn-disabled-color: #fff;
            --bs-btn-disabled-bg: #0d6efd;
            --bs-btn-disabled-border-color: #0d6efd;
        }

        .social-media {
            align-content: center;
            margin-top: 2rem;
            margin-bottom: 3rem;
        }

        .svg-inline--fa {
            vertical-align: 0.8000em;
        }

        .rounded-social-buttons {
            text-align: center;
        }

        .rounded-social-buttons .social-button {
            display: inline-block;
            position: relative;
            cursor: pointer;
            width: 1.7rem;
            height: 1.7rem;
            border: 0.125rem solid transparent;
            padding: 0;
            text-decoration: none;
            text-align: center;
            color: #ffffff;
            font-size: 1.5625rem;
            font-weight: normal;
            line-height: 2em;
            border-radius: 1.6875rem;
            transition: all 0.5s ease;
            margin-right: 0.25rem;
            margin-bottom: 0.25rem;
        }

        .rounded-social-buttons .social-button:hover,
        .rounded-social-buttons .social-button:focus {
            -webkit-transform: rotate(360deg);
            -ms-transform: rotate(360deg);
            transform: rotate(360deg);
        }

        .rounded-social-buttons .fa-twitter,
        .fa-facebook-f,
        .fa-linkedin,
        .fa-youtube,
        .fa-instagram {
            font-size: 20px;
        }

        .rounded-social-buttons .social-button.facebook {
            background: #3b5998;
        }

        .rounded-social-buttons .social-button.facebook:hover,
        .rounded-social-buttons .social-button.facebook:focus {
            color: #3b5998;
            background: #fefefe;
            border-color: #3b5998;
        }

        .rounded-social-buttons .social-button.twitter {
            background: #55acee;
        }

        .rounded-social-buttons .social-button.twitter:hover,
        .rounded-social-buttons .social-button.twitter:focus {
            color: #55acee;
            background: #fefefe;
            border-color: #55acee;
        }

        .rounded-social-buttons .social-button.linkedin {
            background: #007bb5;
        }

        .rounded-social-buttons .social-button.linkedin:hover,
        .rounded-social-buttons .social-button.linkedin:focus {
            color: #007bb5;
            background: #fefefe;
            border-color: #007bb5;
        }

        .rounded-social-buttons .social-button.youtube {
            background: #bb0000;
        }

        .rounded-social-buttons .social-button.youtube:hover,
        .rounded-social-buttons .social-button.youtube:focus {
            color: #bb0000;
            background: #fefefe;
            border-color: #bb0000;
        }

        .rounded-social-buttons .social-button.instagram {
            background: #125688;
        }

        .rounded-social-buttons .social-button.instagram:hover,
        .rounded-social-buttons .social-button.instagram:focus {
            color: #125688;
            background: #fefefe;
            border-color: #125688;
        }
    </style>

    @yield('css')
</head>

<body>

    {{-- Header Navbara --}}
    <div class="headers" id="header">
        <nav class="navbars container d-flex justify-content-center  mt-2 mb-2">
            <a class="justify-content-center" style="text-decoration: none;vertical-align:middle !important"
                href="{{ route('dashboardUser', $row['code']) }}">
                <div class="brand justify-content-center" style="vertical-align:middle !important">
                    <img src="{{ asset('media/client-logos/logo.png') }}" class="logo-brand" />
                    <span>Hotel Grand Antares</span>
                </div>
            </a>
        </nav>
        @yield('header-content')
    </div>
    {{-- End Header Navbar --}}
    {{-- <div class="product-wrap container"> --}}
    {{-- </div> --}}
    <div class="main">
        @yield('content')
        {{-- <div class="container d-flex justify-content-center mt-3">
            <a
                href="{{ route('logoutAdmin') }}"style="font-size: small; font-weight:600; color: red;vertical-align: middle !important; font-decoration : underline;">Logout</a>
        </div> --}}
    </div>

    <footer>
        <div class="social-media">
            <p onclick="showModalKritik()" style="text-align: center; margin-bottom : 6px; text-decoration : underline"
                class="text-center">Kritik
                dan saran</p>
            {{-- Modal --}}
            <div class="modal fade" id="modalKritik" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content p-4" id="modalContent">

                        <form action="{{ route('storeKritik') }}" method="post">
                            @csrf
                            <input type="hidden" name="order_id" value="">
                            <div class="form-group fv-plugins-icon-container has-success">
                                <label style="font-size:0.7rem">Masukan Kritik dan Saran</label>
                                <textarea id="inputSearch" type="text" class="form-control" name="kritik" autofocus required> </textarea>
                            </div>
                            <button type="submit" class="button btn btn-sm btn-warning mt-1">
                                Kirim
                            </button>
                        </form>
                    </div>
                    {{-- <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                    onclick="closeModalDetail()">Close</button> --}}

                    {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                    {{-- </div> --}}
                </div>
            </div>
            <div class="rounded-social-buttons">
                <a class="social-button facebook" href="https://www.facebook.com/" target="_blank"><i
                        class="fab fa-facebook-f"></i></a>
                <a class="social-button twitter" href="https://www.twitter.com/" target="_blank"><i
                        class="fab fa-twitter"></i></a>
                {{-- <a class="social-button linkedin" href="https://www.linkedin.com/" target="_blank"><i
                        class="fab fa-linkedin"></i></a> --}}
                <a class="social-button youtube" href="https://www.youtube.com/" target="_blank"><i
                        class="fab fa-youtube"></i></a>
                <a class="social-button instagram" href="https://www.instagram.com/" target="_blank"><i
                        class="fab fa-instagram"></i></a>
            </div>
        </div>
    </footer>

    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/all.js"
        integrity="sha384-xymdQtn1n3lH2wcu0qhcdaOpQwyoarkgLVxC/wZ5q7h9gHtxICrpcaSUfygqZGOe" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    {{-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="{{ asset('users/js/main.js') }}"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script> --}}
    {{-- <script src="{{ asset('bootstrap/js/bootstrap.js') }}"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function showModalKritik() {
            $('#modalKritik').modal('show');
        }
    </script>

    @yield('js')
</body>

</html>
