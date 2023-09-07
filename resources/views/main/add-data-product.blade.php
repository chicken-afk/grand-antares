@extends('master')
@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('css/pages/wizard/wizard-1.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="sweetalert2.min.css">
@endsection
@section('header-name')
    Tambah Produk
@endsection
@section('menu-detail')
    Menu Menambah Produk
@endsection
@section('script')
    {{-- <script src="sweetalert2.min.js"></script> --}}
    <script src="{{ asset('js/pages/custom/wizard/wizard-1.js') }}"></script>
    <script src="{{ asset('js/pages/crud/file-upload/dropzonejs.js') }}"></script>
    <script src="{{ asset('js/addproduct.js') . '?v=' . time() }}"></script>
@endsection
@section('content')
    @if (Auth::user()->role_id != 1)
        <div class="alert alert-danger mt-5">Anda Tidak Memiliki Akses ke Halaman ini</div>
    @else
        <div class="d-flex flex-column-fluid">
            <!--begin::Container-->
            <div class="container">
                @include('partials.masterdata.menu-2')
                <div class="d-flex flex-row">


                    <!--begin::Content-->

                    <div class="flex-row-fluid ml-lg-12">
                        <div class="card card-custom">
                            <div class="card-header flex-wrap border-0 pt-6 pb-0">
                                <div class="card-title">
                                    <h3 class="card-label text-uppercase">Tambah Product
                                    </h3>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <!--begin::Wizard-->
                                <div class="wizard wizard-1" id="kt_wizard" data-wizard-state="first"
                                    data-wizard-clickable="false">
                                    <!--begin::Wizard Nav-->
                                    <div class="wizard-nav border-bottom">
                                        <div class="wizard-steps p-8 p-lg-10">
                                            <!--begin::Wizard Step 1 Nav-->
                                            <div class="wizard-step" data-wizard-type="step" data-wizard-state="current">
                                                <div class="wizard-label">
                                                    <i class="wizard-icon flaticon-bag"></i>
                                                    <h3 class="wizard-title">1. Produk Detail</h3>
                                                </div>
                                                <span class="svg-icon svg-icon-xl wizard-arrow">
                                                    <!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Arrow-right.svg-->
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                        height="24px" viewBox="0 0 24 24" version="1.1">
                                                        <g stroke="none" stroke-width="1" fill="none"
                                                            fill-rule="evenodd">
                                                            <polygon points="0 0 24 0 24 24 0 24"></polygon>
                                                            <rect fill="#000000" opacity="0.3"
                                                                transform="translate(12.000000, 12.000000) rotate(-90.000000) translate(-12.000000, -12.000000)"
                                                                x="11" y="5" width="2" height="14"
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
                                            </div>
                                            <!--end::Wizard Step 1 Nav-->
                                            <!--begin::Wizard Step 2 Nav-->
                                            <div class="wizard-step" data-wizard-type="step" data-wizard-state="pending">
                                                <div class="wizard-label">
                                                    <i class="wizard-icon flaticon-list"></i>
                                                    <h3 class="wizard-title">2. Varian</h3>
                                                </div>
                                                <span class="svg-icon svg-icon-xl wizard-arrow">
                                                    <!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Arrow-right.svg-->
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                        height="24px" viewBox="0 0 24 24" version="1.1">
                                                        <g stroke="none" stroke-width="1" fill="none"
                                                            fill-rule="evenodd">
                                                            <polygon points="0 0 24 0 24 24 0 24"></polygon>
                                                            <rect fill="#000000" opacity="0.3"
                                                                transform="translate(12.000000, 12.000000) rotate(-90.000000) translate(-12.000000, -12.000000)"
                                                                x="11" y="5" width="2" height="14"
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
                                            </div>
                                            <!--end::Wizard Step 2 Nav-->
                                            <!--begin::Wizard Step 3 Nav-->
                                            <div class="wizard-step" data-wizard-type="step" data-wizard-state="pending">
                                                <div class="wizard-label">
                                                    <i class="wizard-icon flaticon-web"></i>
                                                    <h3 class="wizard-title">3. Tambahan</h3>
                                                </div>
                                                <span class="svg-icon svg-icon-xl wizard-arrow">
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
                                            </div>
                                            <!--end::Wizard Step 3 Nav-->

                                            <!--begin::Wizard Step 5 Nav-->
                                            <div class="wizard-step" data-wizard-type="step" data-wizard-state="pending">
                                                <div class="wizard-label">
                                                    <i class="wizard-icon flaticon-globe"></i>
                                                    <h3 class="wizard-title">5. Review and Submit</h3>
                                                </div>
                                                <span class="svg-icon svg-icon-xl wizard-arrow last">
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
                                            </div>
                                            <!--end::Wizard Step 5 Nav-->
                                        </div>
                                    </div>
                                    <!--end::Wizard Nav-->
                                    <!--begin::Wizard Body-->
                                    <div class="row justify-content-center my-10 px-8 my-lg-15 px-lg-10">
                                        <div class="col-xl-12 col-xxl-7">
                                            <!--begin::Wizard Form-->
                                            <form class="form fv-plugins-bootstrap fv-plugins-framework" id="kt_form">
                                                <!--begin::Wizard Step 1-->
                                                <div class="pb-5" data-wizard-type="step-content"
                                                    data-wizard-state="current">
                                                    <h3 class="mb-10 font-weight-bold text-dark">Masukan Detail Produk</h3>
                                                    <div class="row">
                                                        <div class="col-xl-6">
                                                            <!--begin::Input-->
                                                            <div class="form-group fv-plugins-icon-container has-success">
                                                                <label>Nama Produk</label>
                                                                <input id="productName" type="text"
                                                                    class="form-control form-control-solid form-control-lg"
                                                                    name="product_name" placeholder="Enter">
                                                                <span class="form-text text-muted">Please enter your
                                                                    product
                                                                    name.</span>
                                                                <div class="fv-plugins-message-container"></div>
                                                            </div>
                                                            <!--end::Input-->
                                                        </div>
                                                        <div class="col-xl-6">
                                                            <!--begin::Input-->
                                                            <div class="form-group fv-plugins-icon-container has-success">
                                                                <label>SKU</label>
                                                                <input style="text-transform:uppercase" type="text"
                                                                    class="form-control form-control-solid form-control-lg"
                                                                    name="sku" placeholder="Enter" id="productSKU">
                                                                <span class="form-text text-muted">Please enter product
                                                                    SKU.</span>
                                                                <div class="fv-plugins-message-container"></div>
                                                            </div>
                                                            <!--end::Input-->
                                                        </div>
                                                    </div>

                                                    <!--begin::Input-->
                                                    <div class="form-group fv-plugins-icon-container has-success">
                                                        <label>Deskripsi</label>
                                                        <input type="text"
                                                            class="form-control form-control-solid form-control-lg"
                                                            name="description" placeholder="Enter Description"
                                                            id="productDescription">
                                                        <span class="form-text text-muted">Deskripsi tentang produk.</span>
                                                        <div class="fv-plugins-message-container"></div>
                                                    </div>
                                                    <!--end::Input-->

                                                    <div class="row">
                                                        <div class="col-xl-6">
                                                            <!--begin::Select-->
                                                            <div class="form-group fv-plugins-icon-container has-success">
                                                                <label>Kategori</label>
                                                                <select name="category"
                                                                    class="form-control form-control-solid form-control-lg"
                                                                    id="productCategory">
                                                                    <option selected="selected"value="0"
                                                                        selected="selected">Pilih Kategori</option>
                                                                    @foreach ($row['categories'] as $key => $value)
                                                                        <option value="{{ $value->id }}">
                                                                            {{ $value->category_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <div class="fv-plugins-message-container"></div>
                                                            </div>
                                                            <!--end::Select-->
                                                        </div>
                                                        <div class="col-xl-6" id="subCategories">

                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-xl-6">
                                                            <!--begin::Input-->
                                                            <div class="form-group">
                                                                <label>Harga Kamar</label>
                                                                <input type="text"
                                                                    class="form-control form-control-solid form-control-lg"
                                                                    placeholder="Example : 30000" name="price_display"
                                                                    id="productPrice" value="0">
                                                                <span class="form-text text-muted">Please enter your
                                                                    Price.</span>
                                                            </div>

                                                            <!--end::Input-->
                                                        </div>
                                                        <div class="col-xl-6">
                                                            <div class="form-group">
                                                                <label>Harga Resto</label>
                                                                <input type="text"
                                                                    class="form-control form-control-solid form-control-lg"
                                                                    placeholder="Example : 28000"
                                                                    name="price_display_restaurant"
                                                                    id="productPriceRestaurant" value="0">
                                                                <span class="form-text text-muted">Please enter your
                                                                    Resto Price.</span>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <div class="form-group">
                                                        <label for="">Gambar Produk</label><br>
                                                        <div class="image-input image-input-empty image-input-outline"
                                                            id="kt_image_5">
                                                            <div class="image-input-wrapper"
                                                                style="width: 400px; height:400px
                                                        ">
                                                            </div>

                                                            <label
                                                                class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                                                data-action="change" data-toggle="tooltip" title=""
                                                                data-original-title="Change Image">
                                                                <i class="fa fa-pen icon-sm text-muted"></i>
                                                                <input type="file" id="product_image"
                                                                    name="product_image" accept=".png, .jpg, .jpeg"
                                                                    required />
                                                                <input type="hidden" name="profile_avatar_remove" />
                                                            </label>

                                                            <span
                                                                class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                                                data-action="cancel" data-toggle="tooltip"
                                                                title="Cancel avatar">
                                                                <i class="ki ki-bold-close icon-xs text-muted"></i>
                                                            </span>

                                                            <span
                                                                class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                                                data-action="remove" data-toggle="tooltip"
                                                                title="Remove avatar">
                                                                <i class="ki ki-bold-close icon-xs text-muted"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--end::Wizard Step 1-->
                                                <!--begin::Wizard Step 2-->
                                                <div class="pb-5" data-wizard-type="step-content">
                                                    <h4 class="mb-10 font-weight-bold text-dark">Masukan Varian
                                                        <span class="orm-text text-muted">*Tidak Wajib</span>
                                                        <div class="alert alert-warning" role="alert">
                                                            Kosongkan data dan tekan next untuk melewati
                                                        </div>
                                                    </h4>
                                                    <div id="input-varian">
                                                        <div class="row">
                                                            <div class="col-xl-4">
                                                                <!--begin::Input-->
                                                                <div
                                                                    class="form-group fv-plugins-icon-container has-success">
                                                                    <label>Variant Name</label>
                                                                    <input type="text"
                                                                        class="form-control form-control-solid form-control-lg"
                                                                        name="varian_name[]" id="varianName-0">
                                                                    <span class="form-text text-muted">Nama Varian.</span>
                                                                    <div class="fv-plugins-message-container"></div>
                                                                </div>
                                                                <!--end::Input-->
                                                            </div>

                                                            <div class="col-xl-4">
                                                                <!--begin::Input-->
                                                                <div
                                                                    class="form-group fv-plugins-icon-container has-success">
                                                                    <label>Harga Kamar</label>
                                                                    <input type="text"
                                                                        class="form-control form-control-solid form-control-lg"
                                                                        name="varian_price[]">
                                                                    <span class="form-text text-muted">Masukan harga varian
                                                                        untuk kamar.</span>
                                                                    <div class="fv-plugins-message-container"></div>
                                                                </div>
                                                                <!--end::Input-->
                                                            </div>

                                                            <div class="col-xl-4">
                                                                <!--begin::Input-->
                                                                <div
                                                                    class="form-group fv-plugins-icon-container has-success">
                                                                    <label>Harga Restaurant</label>
                                                                    <input type="text"
                                                                        class="form-control form-control-solid form-control-lg"
                                                                        name="varian_price_restaurant[]">
                                                                    <span class="form-text text-muted">Masukan harga varian
                                                                        untuk restaurant</span>
                                                                    <div class="fv-plugins-message-container"></div>
                                                                </div>
                                                                <!--end::Input-->
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <button type="button" class="btn btn-primary px-9 py-4"
                                                        onclick="addForm()">+</button>

                                                </div>
                                                <!--end::Wizard Step 2-->
                                                <!--begin::Wizard Step 3-->
                                                <div class="pb-5" data-wizard-type="step-content">
                                                    <h4 class="mb-10 font-weight-bold text-dark">Masukan Topping
                                                        <span class="orm-text text-muted">*Tidak Wajib</span>
                                                        <div class="alert alert-warning" role="alert">
                                                            Kosongkan data dan tekan next untuk melewati
                                                        </div>
                                                    </h4>
                                                    <div id="input-topping">
                                                        <div class="row">
                                                            <div class="col-xl-4">
                                                                <!--begin::Input-->
                                                                <div
                                                                    class="form-group fv-plugins-icon-container has-success">
                                                                    <label>Nama Topping</label>
                                                                    <input type="text"
                                                                        class="form-control form-control-solid form-control-lg"
                                                                        name="topping_name[]">
                                                                    <span class="form-text text-muted">Contoh : Telor
                                                                        Dadar,
                                                                        Keju dll</span>
                                                                    <div class="fv-plugins-message-container"></div>
                                                                </div>
                                                                <!--end::Input-->
                                                            </div>
                                                            <div class="col-xl-4">
                                                                <!--begin::Input-->
                                                                <div
                                                                    class="form-group fv-plugins-icon-container has-success">
                                                                    <label>Harga Kamar</label>
                                                                    <input type="text"
                                                                        class="form-control form-control-solid form-control-lg"
                                                                        name="topping_price[]">
                                                                    <span class="form-text text-muted">Masukan Harga
                                                                        Topping kamar</span>
                                                                    <div class="fv-plugins-message-container"></div>
                                                                </div>
                                                                <!--end::Input-->
                                                            </div>
                                                            <div class="col-xl-4">
                                                                <!--begin::Input-->
                                                                <div
                                                                    class="form-group fv-plugins-icon-container has-success">
                                                                    <label>Harga Restaurant</label>
                                                                    <input type="text"
                                                                        class="form-control form-control-solid form-control-lg"
                                                                        name="topping_price_restaurant[]">
                                                                    <span class="form-text text-muted">Masukan Harga Toping
                                                                        Restaurant</span>
                                                                    <div class="fv-plugins-message-container"></div>
                                                                </div>
                                                                <!--end::Input-->
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <button type="button" class="btn btn-primary px-9 py-4"
                                                        onclick="addFormToping()">+</button>
                                                    <!--end::Select-->
                                                </div>
                                                <!--end::Wizard Step 3-->
                                                <!--begin::Wizard Step 5-->
                                                <div class="pb-5" data-wizard-type="step-content" id="reviewPage">
                                                    {{-- REfresh page using javascript --}}
                                                </div>
                                                <!--end::Wizard Step 5-->
                                                <!--begin::Wizard Actions-->
                                                <div class="d-flex justify-content-between border-top mt-5 pt-10">
                                                    <div class="mr-2">
                                                        <button type="button"
                                                            class="btn btn-light-primary font-weight-bolder text-uppercase px-9 py-4"
                                                            data-wizard-type="action-prev">Previous</button>
                                                    </div>
                                                    <div>
                                                        <button onclick="postData()" type="button"
                                                            class="btn btn-success font-weight-bolder text-uppercase px-9 py-4"
                                                            data-wizard-type="action-submit">Submit</button>
                                                        <button onclick="generatFormData()" type="button"
                                                            class="btn btn-primary font-weight-bolder text-uppercase px-9 py-4"
                                                            data-wizard-type="action-next">Next</button>
                                                    </div>
                                                </div>
                                                <!--end::Wizard Actions-->
                                                <div>
                                                </div>
                                                <div>
                                                </div>
                                                <div>
                                                </div>
                                                <div>

                                                </div>

                                                <!--end::Wizard Form-->
                                        </div>
                                    </div>
                                    <!--end::Wizard Body-->
                                </div>
                                <!--end::Wizard-->
                            </div>
                            <!--end::Wizard-->
                        </div>
                    </div>
                    </form>
                </div>
            </div>
            <!--end::Container-->
        </div>
    @endif
@endsection
