@extends('master')
@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
@endsection
@section('header-name')
    Pesanan
@endsection
@section('menu-detail')
    Menu Mengelola Pesanan dan Pembayaran Pesanan
@endsection
@section('script')
    <script src="{{ asset('js/pages/custom/ecommerce/my-orders.js') . '?v=' . time() }}"></script>
    <script src="{{ asset('js/pages/crud/forms/widgets/bootstrap-datepicker.js') }}"></script>
@endsection

@section('content')
    @if (!Auth::user())
        <div class="alert alert-danger mt-5">Anda Tidak Memiliki Akses ke Halaman ini</div>
    @else
        <div class="container">
            <embed type="application/pdf" class="d-none" src="" id="pdfDocument" width="100%" height="100%" />
            <!--begin::Teachers-->
            <div class="d-flex flex-row">

                <!--begin::Content-->
                <div class="flex-row-fluid">
                    <!--begin::Card-->
                    <div class="card card-custom">
                        <!--begin::Header-->
                        <div class="card-header flex-wrap border-0 pt-6 pb-0">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label font-weight-bolder font-size-h3 text-dark">Data Pesanan</span>
                                <span class="text-muted mt-1 font-weight-bold font-size-sm">Kelola Pesanan</span>
                            </h3>
                            <div class="card-toolbar">
                                <a class="btn btn-light-primary font-weight-bolder" data-toggle="modal"
                                    data-target="#exportModal">
                                    <span class="svg-icon svg-icon-md">
                                        <!--begin::Svg Icon | path:assets/media/svg/icons/Design/PenAndRuller.svg-->
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                            width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24"></rect>
                                                <path
                                                    d="M3,16 L5,16 C5.55228475,16 6,15.5522847 6,15 C6,14.4477153 5.55228475,14 5,14 L3,14 L3,12 L5,12 C5.55228475,12 6,11.5522847 6,11 C6,10.4477153 5.55228475,10 5,10 L3,10 L3,8 L5,8 C5.55228475,8 6,7.55228475 6,7 C6,6.44771525 5.55228475,6 5,6 L3,6 L3,4 C3,3.44771525 3.44771525,3 4,3 L10,3 C10.5522847,3 11,3.44771525 11,4 L11,19 C11,19.5522847 10.5522847,20 10,20 L4,20 C3.44771525,20 3,19.5522847 3,19 L3,16 Z"
                                                    fill="#000000" opacity="0.3"></path>
                                                <path
                                                    d="M16,3 L19,3 C20.1045695,3 21,3.8954305 21,5 L21,15.2485298 C21,15.7329761 20.8241635,16.200956 20.5051534,16.565539 L17.8762883,19.5699562 C17.6944473,19.7777745 17.378566,19.7988332 17.1707477,19.6169922 C17.1540423,19.602375 17.1383289,19.5866616 17.1237117,19.5699562 L14.4948466,16.565539 C14.1758365,16.200956 14,15.7329761 14,15.2485298 L14,5 C14,3.8954305 14.8954305,3 16,3 Z"
                                                    fill="#000000"></path>
                                            </g>
                                        </svg>
                                        <!--end::Svg Icon-->
                                    </span>Export Data</a>

                                <!--end::Button-->

                                <!--end::Button-->
                            </div>
                        </div>
                        <!--end::Header-->
                        <!--begin::Body-->
                        <div class="card-body">
                            <!--begin: Search Form-->
                            <!--begin::Search Form-->
                            <div class="mb-10">
                                <div class="row align-items-center">
                                    <div class="col-lg-6 col-xl-6">
                                        <div class="row align-items-center">
                                            <div class="col-md-6 my-2 my-md-0">
                                                <div class="input-icon">
                                                    <input type="text" class="form-control form-control-solid"
                                                        placeholder="Search..." id="kt_datatable_search_query" />
                                                    <span>
                                                        <i class="flaticon2-search-1 text-muted"></i>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-md-4 my-2 my-md-0">
                                                <select class="form-control form-control-solid"
                                                    id="kt_datatable_search_status">
                                                    <option value="">Status Pembayaran</option>
                                                    <option value="">Semua</option>
                                                    <option value="0">Belum Dibayar</option>
                                                    <option value="1">Sudah Dibayar</option>
                                                </select>
                                            </div>
                                            {{-- <div class="col-md-4 my-2 my-md-0">
                                            <select class="form-control form-control-solid" id="kt_datatable_search_type">
                                                <option value="">Type</option>
                                                <option value="4">Success</option>
                                                <option value="5">Info</option>
                                                <option value="6">Danger</option>
                                            </select>
                                        </div> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Search Form-->
                            <!--end: Search Form-->
                            <!--begin: Datatable-->
                            {{-- <table class="table-responsive"> --}}
                            <div class="table table-separate table-head-custom table-checkable dataTable no-footer dtr-inline table-responsive"
                                id="kt_datatable">
                            </div>
                            {{-- </table> --}}
                            <!--end: Datatable-->
                        </div>
                        <!--end::Body-->
                    </div>
                    <!--end::Card-->
                </div>
                <!--end::Content-->
            </div>
            <!--end::Teachers-->
            <!-- Modal -->
            <div class="modal fade" id="modalDetail" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-fullscreen modal-xl modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content" id="modalContent">
                        {{-- Generate Content using jquery --}}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                            onclick="closeModalDetail()">Close</button>
                        {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                    </div>
                </div>
            </div>


        </div>

        </div>
        {{-- Modal --}}
        <div class="modal fade" id="exportModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Export Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="card card-custom">
                            <!--begin::Form-->
                            <form action="{{ route('exportOrder') }}" method="GET" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group mb-8">
                                        <label>Dari<span class="text-danger">*</span></label>
                                        <div class="input-group date">
                                            <input type="text" class="form-control" readonly="readonly"
                                                value="" id="kt_datepicker_3" name="start_date" required>
                                            <div class="input-group-append">
                                                <span class="input-group-text">
                                                    <i class="la la-calendar"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mb-8">
                                        <label>Sampai<span class="text-danger">*</span></label>
                                        <div class="input-group date">
                                            <input type="text" class="form-control" readonly="readonly"
                                                value="" id="kt_datepicker_2" name="end_date" required>
                                            <div class="input-group-append">
                                                <span class="input-group-text">
                                                    <i class="la la-calendar"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mb-8">
                                        <label for="">Status Pembayaran</label>
                                        <select class="form-control form-control-solid" name="payment_status">
                                            <option value="semua">Semua</option>
                                            <option value="0">Belum Dibayar</option>
                                            <option value="1">Sudah Dibayar</option>
                                        </select>
                                    </div>
                                    <!--end::Form-->
                                </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light-primary font-weight-bold"
                                data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary font-weight-bold">Export Data</button>

                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
