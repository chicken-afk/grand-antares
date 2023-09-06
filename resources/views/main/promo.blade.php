@extends('master')
@section('script')
    <script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script src="{{ asset('js/pages/promo.js') }}"></script>
    <script>
        $('#productTable').DataTable({
            order: [11, 'desc']
        });
    </script>
@endsection
@section('header-name')
    Master Data Promo
@endsection
@section('menu-detail')
    Menu Promo
@endsection
@section('css')
    <link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
            @include('partials.masterdata.menu-2')
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
                        <a onclick="openModal()" class="btn btn-primary font-weight-bolder">
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
                            </span>Tambah Promo
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <table
                        class="table table-separate table-head-custom table-checkable dataTable no-footer dtr-inline table-responsive"
                        id="productTable">
                        <thead>
                            <tr>
                                <th>IMAGE</th>
                                <th>NAMA PRODUCT</th>
                                <th>HARGA Promo Kamar/ Tidak Promo</th>
                                <th>HARGA Promo Restaurant/Tidak Promo</th>
                                <th>Varian Kamar</th>
                                <th>Varian Restaurant</th>
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
                                    <td>Rp. {{ number_format($value->price_promo) }} /
                                        <span style="text-decoration:line-through">Rp.
                                            {{ number_format($value->price_display) }}</span>
                                    </td>
                                    <td>Rp. {{ number_format($value->price_promo_restaurant) }} /
                                        <span style="text-decoration:line-through">Rp.
                                            {{ number_format($value->price_display_restaurant) }}</span>
                                    </td>
                                    <td>
                                        @if ($value->varian->count() > 0)
                                            @foreach ($value->varian as $k => $v)
                                                {{ $v->varian_name }} : Rp. {{ number_format($v->varian_promo) }}, Rp.
                                                <span
                                                    style="text-decoration:line-through">{{ number_format($v->varian_price) }}</span>
                                                <br>
                                            @endforeach
                                        @else
                                            <div class="text-danger">Tidak ada Varian</div>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($value->varian->count() > 0)
                                            @foreach ($value->varian as $k => $v)
                                                {{ $v->varian_name }} : Rp.
                                                {{ number_format($v->varian_promo_restaurant) }}, Rp.
                                                <span
                                                    style="text-decoration:line-through">{{ number_format($v->varian_price_restaurant) }}</span>
                                                <br>
                                            @endforeach
                                        @else
                                            <div class="text-danger">Tidak ada Varian</div>
                                        @endif
                                    </td>
                                    <td nowrap="nowrap"><span class="dtr-data">
                                            <button onclick="editFunction({{ $value->id }})"
                                                class="btn btn-sm btn-icon btn-outline-warning" title="Edit details"> <i
                                                    class="la la-edit"></i> </button>
                                            <a href="{{ route('deletePromo', $value->id) }}"
                                                class="btn btn-sm btn-outline-danger btn-icon" title="Delete"> <i
                                                    class="la la-trash"></i> </a>
                                        </span></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Modal --}}
            <div class="modal fade" id="modalSearch" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-fullscreen modal-xl modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content" id="modalContent">
                        <div class="row p-5">
                            <div class="col-md-12">
                                <div class="form-group fv-plugins-icon-container has-success">
                                    <label>Masukan Nama Produk</label>
                                    <input id="inputSearch" type="text"
                                        class="form-control form-control-solid form-control-lg autofocus"
                                        name="product_name" autofocus>
                                    <div class="fv-plugins-message-container"></div>
                                </div>
                                <div class="form-group">
                                    <div class="row" id="searchContent">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                            onclick="closeModalDetail()">Close</button>

                        {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                    </div>
                </div>
            </div>

            {{-- Modal Tambah Promo --}}
            <div class="modal fade" id="modalTambahPromo" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <form action="{{ route('storePromo') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-dialog modal-fullscreen modal-xl modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content" id="modalTambahPromoContent">

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                                onclick="closeModalDetail()">Close</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
@endsection
