@extends('master')
@section('header-name')
    Dashboard
@endsection
@section('content')
    <div class="">
        @if (Auth::user()->role_id != 1)
            <div class="alert alert-danger mt-5">Anda Tidak Memiliki Akses ke Halaman ini</div>
        @else
            <div class="d-flex flex-column-fluid">
                <!--begin::Container-->
                <div class="container">
                    <!--begin::Dashboard-->
                    <div class="row">
                        <div class="col-xl-4">
                            <!--begin::List Widget 16-->
                            <div class="card card-custom gutter-b card-stretch">
                                <!--begin::Header-->
                                <div class="card-header border-0">
                                    <h3 class="card-title font-weight-bolder text-dark">Pesanan Baru</h3>
                                    <div class="card-toolbar">
                                        <a href="{{ route('getOrders') }}">Lihat Semua</a>
                                    </div>
                                </div>
                                <!--end:Header-->
                                <!--begin::Body-->
                                <div class="card-body pt-2">
                                    <!--begin::Item-->
                                    @foreach ($row['invoices'] as $key => $value)
                                        <div class="d-flex flex-wrap align-items-center pb-10">
                                            <!--begin::Symbol-->
                                            <div class="symbol symbol-50 symbol-2by3 flex-shrink-0 mr-4">
                                                <div class="symbol-label"
                                                    style="background-image: url('{{ $value->product_image }}')">
                                                </div>
                                            </div>
                                            <!--end::Symbol-->
                                            <!--begin::Title-->
                                            <div class="d-flex flex-column flex-grow-1 my-lg-0 my-2 mr-2">
                                                <a href="{{ route('getOrders') }}"
                                                    class="text-dark font-weight-bold text-hover-primary mb-1 font-size-lg">{{ $value->invoice_number }}</a>
                                                <span class="text-muted font-weight-bold">{{ $value->name }}</span>
                                            </div>
                                            <!--end::Title-->
                                            <!--begin::Btn-->
                                            <a href="{{ route('getOrders') }}" class="btn btn-icon btn-light btn-sm">
                                                <span class="svg-icon svg-icon-success">
                                                    <span class="svg-icon svg-icon-md">
                                                        <!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Arrow-right.svg-->
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                            height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none"
                                                                fill-rule="evenodd">
                                                                <polygon points="0 0 24 0 24 24 0 24"></polygon>
                                                                <rect fill="#000000" opacity="0.3"
                                                                    transform="translate(12.000000, 12.000000) rotate(-90.000000) translate(-12.000000, -12.000000)"
                                                                    x="11" y="5" width="2"
                                                                    height="14" rx="1"></rect>
                                                                <path
                                                                    d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z"
                                                                    fill="#000000" fill-rule="nonzero"
                                                                    transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997)">
                                                                </path>
                                                            </g>
                                                        </svg>
                                                        <!--end::Svg Icon-->
                                                    </span>
                                                </span>
                                            </a>
                                            <!--end::Btn-->
                                        </div>
                                    @endforeach
                                    <!--end::Item-->
                                </div>
                                <!--end::Body-->
                            </div>
                            <!--end::List Widget 13-->
                        </div>
                        <div class="col-xl-8">
                            <!--begin::Mixed Widget 5-->
                            <div class="card card-custom bg-radial-gradient-primary gutter-b card-stretch">
                                <!--begin::Header-->
                                <div class="card-header border-0 py-5">
                                    <h3 class="card-title font-weight-bolder text-white">
                                        Sales Progress</h3>
                                </div>
                                <!--end::Header-->
                                <!--begin::Body-->
                                <div class="card-body d-flex flex-column p-0" style="position: relative;">
                                    <!--begin::Stats-->
                                    <div class="card-spacer bg-white card-rounded flex-grow-1">
                                        <!--begin::Row-->
                                        <div class="row m-0 mb-2">
                                            <div class="col px-8 py-6 mr-8"
                                                style="background-color: #F1EDFF ; border-radius : 15px;">
                                                <div class="font-size-sm font-weight-bold">Total Omset</div>
                                                <div class="font-size-h4 font-weight-bolder">Rp.
                                                    {{ number_format($row['omset']) }},-</div>
                                            </div>
                                            <div class="col px-8 py-6"
                                                style="background-color: #F1EDFF ; border-radius : 15px;">
                                                <div class="font-size-sm font-weight-bold">
                                                    Penjualan Produk
                                                </div>
                                                <div class="font-size-h4 font-weight-bolder">
                                                    {{ $row['total_produk_terjual'] }}</div>
                                            </div>
                                        </div>
                                        <!--end::Row-->
                                        <!--begin::Row-->
                                        <div class="row m-0">
                                            <div class="col px-8 py-6 mr-8"
                                                style="background-color: #F1EDFF ; border-radius : 15px;">
                                                <div class="font-size-sm font-weight-bold">Produk Terlaris</div>
                                                <div class="font-size-h4 font-weight-bolder">
                                                    @if (count($row['produk_terlaris']) > 0)
                                                        {{ $row['produk_terlaris'][0]->active_product_name }}
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col px-8 py-6"
                                                style="background-color: #F1EDFF ; border-radius : 15px;">
                                                <div class="font-size-sm font-weight-bold">Total invoice</div>
                                                <div class="font-size-h4 font-weight-bolder">{{ $row['total_invoice'] }}
                                                </div>
                                            </div>
                                        </div>
                                        <!--end::Row-->
                                    </div>
                                    <!--end::Stats-->
                                    <div class="resize-triggers">
                                        <div class="expand-trigger">
                                            <div style="width: 344px; height: 521px;"></div>
                                        </div>
                                        <div class="contract-trigger"></div>
                                    </div>
                                </div>
                                <!--end::Body-->
                            </div>
                            <!--end::Mixed Widget 5-->
                        </div>
                    </div>
                    <!--end::Row-->
                    <div class="row">
                        <div class="col-lg-12">
                            <!--begin::Base Table Widget 2-->
                            <div class="card card-custom card-stretch gutter-b">
                                <!--begin::Header-->
                                <div class="card-header border-0 pt-5">
                                    <h3 class="card-title align-items-start flex-column">
                                        <span class="card-label font-weight-bolder text-dark">Produk Terlaris</span>
                                        {{-- <span class="text-muted mt-3 font-weight-bold font-size-sm">More than 400+
                                            Products</span> --}}
                                    </h3>
                                </div>
                                <!--end::Header-->
                                <!--begin::Body-->
                                <div class="card-body pt-2 pb-0 mt-n3">
                                    <div class="tab-content mt-5" id="myTabTables2">
                                        <!--begin::Tap pane-->
                                        <!--begin::Tap pane-->
                                        <div class="tab-pane fade show active" id="kt_tab_pane_2_3" role="tabpanel"
                                            aria-labelledby="kt_tab_pane_2_3">
                                            <!--begin::Table-->
                                            <div class="table-responsive">
                                                <table class="table table-borderless table-vertical-center">
                                                    <thead>
                                                        <tr>
                                                            <th class="p-0" style="width: 50px"></th>
                                                            <th class="p-0" style="min-width: 150px"></th>
                                                            <th class="p-0" style="min-width: 140px"></th>
                                                            <th class="p-0" style="min-width: 120px"></th>
                                                            <th class="p-0" style="min-width: 40px"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($row['produk_terlaris'] as $key => $value)
                                                            <tr>
                                                                <td class="pl-0 py-5">
                                                                    <div class="symbol symbol-50 symbol-light mr-2">
                                                                        <span class="symbol-label">
                                                                            <img src="{{ $value->product_image }}"
                                                                                class="h-50 align-self-center"
                                                                                alt="">
                                                                        </span>
                                                                    </div>
                                                                </td>
                                                                <td class="pl-0">
                                                                    <a href="#"
                                                                        class="text-dark font-weight-bolder text-hover-primary mb-1 font-size-lg">{{ $value->active_product_name }}</a>
                                                                    <span
                                                                        class="text-muted font-weight-bold d-block">{{ $value->sku }}</span>
                                                                </td>
                                                                <td class="text-right">
                                                                    <span
                                                                        class="text-muted font-weight-bold">{{ $value->description }}</span>
                                                                </td>
                                                                <td class="text-right">
                                                                    <span
                                                                        class="text-muted font-weight-bold">{{ $value->count }}
                                                                        Terjual</span>
                                                                </td>
                                                                <td class="text-right pr-0">
                                                                    <a href="{{ route('getProduct') }}"
                                                                        class="btn btn-icon btn-light btn-sm">
                                                                        <span
                                                                            class="svg-icon svg-icon-md svg-icon-success">
                                                                            <!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Arrow-right.svg-->
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                                width="24px" height="24px"
                                                                                viewBox="0 0 24 24" version="1.1">
                                                                                <g stroke="none" stroke-width="1"
                                                                                    fill="none" fill-rule="evenodd">
                                                                                    <polygon points="0 0 24 0 24 24 0 24">
                                                                                    </polygon>
                                                                                    <rect fill="#000000" opacity="0.3"
                                                                                        transform="translate(12.000000, 12.000000) rotate(-90.000000) translate(-12.000000, -12.000000)"
                                                                                        x="11" y="5"
                                                                                        width="2" height="14"
                                                                                        rx="1"></rect>
                                                                                    <path
                                                                                        d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z"
                                                                                        fill="#000000" fill-rule="nonzero"
                                                                                        transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997)">
                                                                                    </path>
                                                                                </g>
                                                                            </svg>
                                                                            <!--end::Svg Icon-->
                                                                        </span>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!--end::Table-->
                                        </div>
                                        <!--end::Tap pane-->
                                    </div>
                                </div>
                                <!--end::Body-->
                            </div>
                            <!--end::Base Table Widget 2-->
                        </div>
                    </div>
                    <!--end::Row-->
                    <!--end::Dashboard-->
                </div>
                <!--end::Container-->
            </div>
        @endif
    </div>
@endsection

@section('menu-detail')
    Menu Dashboard
@endsection
