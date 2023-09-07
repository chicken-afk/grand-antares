@extends('master')
@section('script')
    <script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script>
        $('#productTable').DataTable({
            order: [11, 'desc']
        });
    </script>
@endsection
@section('header-name')
    Master Data Produk
@endsection
@section('menu-detail')
    Menu Mengelola Produk
@endsection
@section('css')
    <link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    @if (Auth::user()->role_id != 1)
        <div class="alert alert-danger mt-5">Anda Tidak Memiliki Akses ke Halaman ini</div>
    @else
        <div class="d-flex flex-column-fluid">
            <!--begin::Container-->
            <div class="container">
                @include('partials.masterdata.menu-2')
                <!--end::Notice-->
                <!--begin::Card-->
                <div class="card card-custom">
                    <div class="card-header flex-wrap border-0 pt-6 pb-0">
                        <div class="card-title">
                            <h3 class="card-label text-uppercase">Daftar Product

                            </h3>
                        </div>
                        <div class="card-toolbar">
                            <!--begin::Dropdown-->
                            <!--end::Dropdown-->
                            <!--begin::Button-->
                            <a href="{{ route('addProductPage') }}" class="btn btn-primary font-weight-bolder">
                                <span class="svg-icon svg-icon-md">
                                    <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Flatten.svg-->
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="0" y="0" width="24" height="24">
                                            </rect>
                                            <circle fill="#000000" cx="9" cy="15" r="6">
                                            </circle>
                                            <path
                                                d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z"
                                                fill="#000000" opacity="0.3"></path>
                                        </g>
                                    </svg>
                                    <!--end::Svg Icon-->
                                </span>Tambah Produk
                            </a>
                            <!--end::Button-->
                            <!--begin::Button-->
                            {{-- <a href="{{ route('createBundlePage') }}" class="btn btn-secondary font-weight-bolder"
                                style="margin-left:5px">
                                <span class="svg-icon svg-icon-md">
                                    <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Flatten.svg-->
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="0" y="0" width="24" height="24">
                                            </rect>
                                            <circle fill="#000000" cx="9" cy="15" r="6">
                                            </circle>
                                            <path
                                                d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z"
                                                fill="#000000" opacity="0.3"></path>
                                        </g>
                                    </svg>
                                    <!--end::Svg Icon-->
                                </span>Buat Bundle
                            </a> --}}
                            <!--end::Button-->
                        </div>
                    </div>
                    <div class="card-body">
                        <!--begin: Datatable-->
                        <!--begin: Datatable-->
                        <table
                            class="table table-separate table-head-custom table-checkable dataTable no-footer dtr-inline table-responsive"
                            id="productTable">
                            <thead>
                                <tr>
                                    <th>IMAGE</th>
                                    <th>NAMA PRODUCT</th>
                                    <th>DESCRIPTION</th>
                                    <th>HARGA Kamar</th>
                                    <th>HARGA Restaurant</th>
                                    <th>Stock</th>
                                    <th class="p-0 min-w-200px">Varian</th>
                                    <th>Topping</th>
                                    <th>created at</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($row['datas'] as $key => $value)
                                    <tr>
                                        <td>
                                            <a href="{{ $value->product_image }}" target="_blank">
                                                <img src="{{ asset($value->product_image) }}" alt="productimage"
                                                    class="img-thumbnail max-h-100px" loading="lazy"> </a>
                                        </td>
                                        <td>{{ $value->active_product_name }}</td>
                                        <td>{{ $value->description }}</td>
                                        <td>Rp. {{ number_format($value->price_display) }}</td>
                                        <td>Rp. {{ number_format($value->price_display_restaurant) }}</td>
                                        <td>
                                            @if ($value->is_available == 1)
                                                <span class="switch switch-success">
                                                    <label>
                                                        {{-- <a href="{{ route('editStock', $value->uuid) }}"> --}}
                                                        <input type="checkbox" checked="checked" name="select"
                                                            onClick="location.href=`{{ route('editStock', $value->uuid) }}`">
                                                        {{-- </a> --}}
                                                        <span></span>
                                                    </label>
                                                </span>
                                                {{-- <a href="{{ route('editStock', $value->uuid) }}" title="Edit stock"><span
                                                    class="label label-lg font-weight-bold label-light-info label-inline">Tersedia</span></a> --}}
                                            @else
                                                {{-- <a href="{{ route('editStock', $value->uuid) }}" title="Edit stock"> --}}
                                                <span class="switch">
                                                    <label>
                                                        <input type="checkbox" name="select"
                                                            onClick="location.href=`{{ route('editStock', $value->uuid) }}`">
                                                        <span></span>
                                                    </label>
                                                </span>
                                                {{-- </a> --}}
                                            @endif
                                        </td>
                                        <td>
                                            @if ($value->varian->count() > 0)
                                                @foreach ($value->varian as $k => $v)
                                                    {{ $v->varian_name }} : Rp. {{ number_format($v->varian_price) }}, Rp.
                                                    {{ number_format($v->varian_price_restaurant) }} <br>
                                                @endforeach
                                            @else
                                                <div class="text-danger">Tidak ada Varian</div>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($value->topping->count() > 0)
                                                @foreach ($value->topping as $k => $v)
                                                    {{ $v->topping_name }} : Rp. {{ number_format($v->topping_price) }},
                                                    Rp. {{ number_format($v->topping_price_restaurant) }}
                                                    <br>
                                                @endforeach
                                            @else
                                                <div class="text-danger">Tidak ada topping</div>
                                            @endif
                                        </td>
                                        <td>{{ date('d - m - Y', strtotime($value->created_at)) }}</td>
                                        <td nowrap="nowrap"><span class="dtr-data">
                                                <a href="{{ route('editPageProduct', $value->id) }}"
                                                    class="btn btn-sm btn-icon btn-outline-warning" title="Edit details"> <i
                                                        class="la la-edit"></i> </a>
                                                <a href="{{ route('deleteProduct', $value->uuid) }}"
                                                    class="btn btn-sm btn-outline-danger btn-icon" title="Delete"> <i
                                                        class="la la-trash"></i> </a>
                                            </span></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!--end: Datatable-->
                        {{-- </div> --}}
                        <!--end::Container-->
                    </div>
    @endif
@endsection
