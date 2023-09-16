@extends('master')

@section('header-name')
    Master Data Banner
@endsection
@section('menu-detail')
    Menu Data Banner
@endsection
@section('script')
    <script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script>
        $('#bannerTable').DataTable();
    </script>
@endsection

@section('content')
    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="card card-custom">
                <div class="card-header flex-wrap border-0 pt-6 pb-0">
                    <div class="card-title">
                        <span>Daftar Banner</span>
                    </div>
                    <div class="card-toolbar">
                        <a href="{{ route('addBanner') }}" class="btn btn-primary font-weight-bolder">
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
                            </span>Tambah Banner
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <table class="table table-separate table-head-custom table-checkable dataTable no-footer dtr-inline"
                        id="bannerTable">
                        <thead>
                            <th>Nama</th>
                            <th>Banner Image</th>
                            <th>Total Product</th>
                            <th>Product</th>
                            <th>Status Banner</th>
                            <Th>Action</Th>
                        </thead>
                        <tbody>
                            @forelse ($banners as $value)
                                <tr>
                                    <td><span>{{ $value->name }}</span></td>
                                    <td><img src="{{ asset($value->banner_image) }}"
                                            class="img-fluid max-h-70px max-w-140px" alt=""></td>
                                    <td><span>{{ $value->products_count }}</span></td>
                                    <td>
                                        <span>
                                            @foreach ($value->productList as $v)
                                                {{ $v->active_product_name }},
                                            @endforeach
                                        </span>
                                    </td>
                                    <td><span>{{ $value->is_active == 1 ? 'aktif' : 'tidak aktif' }}</span></td>
                                    <td nowrap="nowrap"><span class="dtr-data">
                                            <a class="btn btn-sm {{ $value->is_active == 1 ? 'btn-outline-danger' : 'btn-outline-success' }}"
                                                href="{{ route('changeBannerStatus', $value->id) }}">{{ $value->is_active == 1 ? 'nonaktifkan' : 'aktifkan' }}</a>
                                            <a href="{{ route('deleteBanner', $value->id) }}"
                                                class="btn btn-sm btn-outline-danger btn-icon" title="Delete"> <i
                                                    class="la la-trash"></i> </a>
                                        </span></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Banner Kosong</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
