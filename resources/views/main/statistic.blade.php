@extends('master')
@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('header-name')
    Statistik
@endsection
@section('menu-detail')
    Halaman Statistik Penjualan
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-custom gutter-b">
                    <div class="card-header">
                        <div class="card-title">
                            <div class="card-label" style="width: 50rem">Laporan Penjualan Perhari</div>
                            <div class="text-right d-flex">
                                <div class="input-group date">
                                    <input type="text" class="form-control" readonly="readonly"
                                        value="{{ $row['startDate'] }}" id="kt_datepicker_3" name="start_date">
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="la la-calendar"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="input-group date">
                                    <input type="text" class="form-control" readonly="readonly"
                                        value="{{ $row['endDate'] }}" id="kt_datepicker_2" name="end_date">
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="la la-calendar"></i>
                                        </span>
                                    </div>
                                </div>
                                <button class="btn btn-sm btn-primary" onclick="refreshChart()">Fillter</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        {{-- Generate using Javascript --}}
                        <div id="statistic_1"></div>
                        <div class="card-title text-center">
                            <div class="card-label text-bold mt-10">
                                <h4>Grafik Penjualan Perhari</h4>
                            </div>
                        </div>
                        <div id="grafikPerhari"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-custom gutter-b">
                    <div class="card-header h-auto">
                        <div class="card-title py-5">
                            <div class="card-label">
                                Laporan Penjualan Per Bulan
                            </div>
                        </div>
                        <div class="d-flex text-right py-5">
                            <select class="form-select form-select-sm custom-select orderStatus mr-2" name="role_id"
                                id="yearFillter">
                                <option value="semua" selected>Semua</option>
                                @for ($row['firstYear']; $row['firstYear'] <= $row['lastYear']; $row['firstYear']++)
                                    <option value="{{ $row['firstYear'] }}">{{ $row['firstYear'] }}</option>
                                @endfor
                            </select>
                            <button onclick="changeYear()" class="btn btn-sm btn-primary ml-4px">Fillter</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="statistic_2"></div>
                        <!--begin::Chart-->
                        <div class="card-title text-center">
                            <div class="card-label text-bold mt-10">
                                <h4>Grafik Penjualan Perbulan</h4>
                            </div>
                        </div>
                        <div id="chart_1"></div>
                        <!--end::Chart-->
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-custom gutter-b d-flex align-items-center">
                    <div class="card-header h-auto">
                        <div class="card-title py-5">
                            <div class="card-label">
                                Statistik Penjualan Berdasarkan Produk
                            </div>
                        </div>
                    </div>
                    <div class="card-body text-center align-items-center">
                        <!--begin::Chart-->
                        <div id="chart_12"></div>
                        <!--end::Chart-->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <!--begin::Page Scripts(used by this page)-->
    <script src="{{ asset('/js/pages/features/charts/apexcharts.js') . '?v=' . time() }}"></script>
    <script src="{{ asset('js/pages/crud/forms/widgets/bootstrap-datepicker.js') }}"></script>
@endsection
