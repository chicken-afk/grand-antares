<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Live Order</title>


    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="icon" type="image/x-icon" href="{{ asset('media/client-logos/logo.png') }}">
    <!--begin::Global Theme Styles(used by all pages)-->
    {{-- <link href="{{ asset('plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" /> --}}
    {{-- <link href="{{ asset('plugins/custom/prismjs/prismjs.bundle.css') }}" rel="stylesheet" type="text/css" /> --}}
    {{-- <link href="{{ asset('css/style.bundle.css') }}" rel="stylesheet" type="text/css" /> --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <link rel="stylesheet" href="{{ asset('css/live-order.css') . '?v=' . time() }}">
    <style>
        .blink {
            animation: blinker 1s linear infinite;
            /* background: red; */
            color: red;
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
    <nav class="navbar navbar-light text-center p-2 sticky-top" style="background-color: #663259;">
        <!-- Navbar content -->
        <div class="running-container">
            <h3 class="running-text" style="color : white !important;">
                Live Order | Warung Aceh Bang Ari || {{ Auth::user()->name }}
            </h3>
        </div>
    </nav>

    <div class="container">
        <div class="alert alert-info m-2 p-1" role="alert">
            <h3 id="invoiceTotal" class="blink"> <span class="svg-icon svg-icon-md text-danger">
                    <!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\legacy\metronic\theme\html\demo4\dist/../src/media/svg/icons\Text\Dots.svg-->
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                        height="24px" viewBox="0 0 24 24" version="1.1">
                        <g stroke="none" stroke-width="1">
                            <rect x="14" y="9" width="6" height="6" rx="3"
                                fill="red" />
                            <rect x="3" y="9" width="6" height="6" rx="3"
                                fill="red" fill-opacity="0.7" />
                        </g>
                    </svg>Live Order
                    <!--end::Svg Icon-->
                </span>
                {{-- || Invoice Aktif : {{ $datas->count() }} --}}
        </div>
        {{-- Invoice --}}
        <div class="invoice mt-1 accordion" id="exampleAccordion">
            @foreach ($datas as $key => $value)
                <div class="accordion {{ $value->status_pemesanan == 'selesai' ? 'd-none' : '' }}"
                    id="accordion{{ $value->invoice_number }}">
                    <div class="accordion-item mb-2">
                        <h2 class="accordion-header" id="heading-{{ $key }}">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#panelsStayOpen-{{ $key }}" aria-expanded="true"
                                aria-controls="panelsStayOpen-{{ $key }}">
                                {{ $value->order_at }} - {{ $value->invoice_number }}
                            </button>
                            <div class="invoice-detail p-3 d-flex">
                                <div>
                                    <h3>Nama : {{ $value->name }}</h3>
                                    <h3>Nomor Meja : {{ $value->no_table }}</h3>
                                    <h3>Kode Pesanan : {{ $value->invoice_code }}</h3>
                                    <h3>Total Pesanan : {{ $value->products->count() }}</h3>
                                    <h3>Daftar Pesanan :</h3>
                                </div>
                                <div class="ms-auto" id="button{{ $value->invoice_number }}">
                                    @if (Auth::user()->role_id != 1)
                                        @if ($value->status_pemesanan == 'diterima')
                                            <button class="btn btn-primary btn-md" id="bProses{{ $key }}"
                                                onclick="changeStatus(`{{ $value->invoice_number }}`, 'diproses', `{{ Auth::user()->id }}`)">Proses</button>
                                        @else
                                            <button class="btn btn-warning btn-md"
                                                onclick="changeStatus(`{{ $value->invoice_number }}`, 'selesai', `{{ Auth::user()->id }}` )"
                                                id="bFinish{{ $key }}">Selesai</button>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </h2>
                        <div id="panelsStayOpen-{{ $key }}"
                            class="accordion-collapse {{ $key == 0 ? 'show' : ' collapse' }}"
                            aria-labelledby="panelsStayOpen-{{ $key }}">
                            <div class="accordion-body">
                                <div class="row invoice">
                                    @foreach ($value->products as $k => $v)
                                        <div class="card border-success m-2"
                                            style="background-color: rgb(235, 253, 229);border-radius:5px;width:10rem">
                                            <div class="card-header p-1 mt-1"
                                                style="background-color: rgb(141, 184, 236);">
                                                {{ $v->outlet_name }}
                                            </div>
                                            <div class="card-body p-1">
                                                <div class="">
                                                    <div class="bd-highlight pr-2 product-name">
                                                        <h4 class="product-name">{{ $v->active_product_name }}</h4>
                                                        <h5 class="product-detail">Varian : {{ $v->varian_name }} </h5>
                                                        <h5 class="product-detail">Topping : {{ $v->topping_text }}
                                                        </h5>
                                                    </div>
                                                    <div class="ms-auto">
                                                        <h5 style="font-weight:600;font-size:small">Qty :
                                                            {{ $v->qty }}</h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            @endforeach


        </div>
        {{-- End Invoice --}}
    </div>



    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/live-order.js') . '?v=' . time() }}"></script>
    <script>
        setInterval(reloadData, 10000);
    </script>
</body>

</html>
