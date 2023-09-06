@extends('master')
@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('header-name')
    Tambah Bundle Produk
@endsection
@section('menu-detail')
    Menu Mengelola dan Menambahkan Bundle
@endsection
@section('script')
    <script src="{{ asset('js/pages/crud/file-upload/dropzonejs.js') . '?v=' . time() }}"></script>
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/pages/crud/forms/widgets/select2.js') }}"></script>
    <script src="{{ asset('js/addbundle.js') . '?v=' . time() }}"></script>
    <script>
        // In your Javascript (external .js resource or <script> tag)
        function deleteFormListItems(id) {
            console.log('masuk delete')
            const element = document.getElementById(id);
            element.remove();
        }
        $(document).ready(function() {
            function addFormItems(product_name, product_id) {
                var productId = product_id;
                var productName = product_name;
                if (productId != 0) {
                    var element = $(`
                                            <div class="row mt-2" id="${productId}">
                                                <input type="hidden" value="${productId}"" name="product_id[]">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <input class="form-control form-control-solid form-control-lg"
                                                            type="text" disabled value="${productName}">
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <input class="form-control form-control-solid form-control-lg"
                                                            type="text" name="qty[]" id="qty" required>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2">
                                                    <button onclick="deleteFormListItems(${productId})" class="btn btn-light-danger font-weight-bold mr-2">
                                                        <span class="svg-icon">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                                height="24px" viewBox="0 0 24 24" version="1.1">
                                                                <g stroke="none" stroke-width="1" fill="none"
                                                                    fill-rule="evenodd">
                                                                    <rect x="0" y="0" width="24"
                                                                        height="24" />
                                                                    <path
                                                                        d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z"
                                                                        fill="#000000" fill-rule="nonzero" />
                                                                    <path
                                                                        d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z"
                                                                        fill="#000000" opacity="0.3" />
                                                                </g>
                                                            </svg>
                                                        </span>
                                                    </button>
                                                    <!--end::Svg Icon-->
                                                    </span>
                                                </div>
                    `);

                    $('#itemLists').append(element);
                }
            }
            $('#kt_select2_4').select2({
                placeholder: "Select an Items"
            });
            $('#kt_select2_4').select2()
                .on("change", function(e) {
                    // mostly used event, fired to the original element when the value changes
                    var product_name = $("#kt_select2_4 option:selected").text();
                    var product_id = $("#kt_select2_4 option:selected")[0].value;
                    console.log(typeof product_name)
                    product_name = product_name.trim()
                    addFormItems(product_name, product_id);
                });

            var avatar5 = new KTImageInput('kt_image_5');

            avatar5.on('cancel', function(imageInput) {
                swal.fire({
                    title: 'Image successfully changed !',
                    type: 'success',
                    buttonsStyling: false,
                    confirmButtonText: 'Ok!',
                    confirmButtonClass: 'btn btn-primary font-weight-bold'
                });
            });

            avatar5.on('change', function(imageInput) {
                swal.fire({
                    title: 'Image successfully changed !',
                    type: 'success',
                    buttonsStyling: false,
                    confirmButtonText: 'Ok!',
                    confirmButtonClass: 'btn btn-primary font-weight-bold'
                });
            });

            avatar5.on('remove', function(imageInput) {
                const FR = new FileReader();
                FR.readAsDataURL(imageInput);
                console.log('image : ', imageInput)
                swal.fire({
                    title: 'Image successfully removed !',
                    type: 'error',
                    buttonsStyling: false,
                    confirmButtonText: 'Got it!',
                    confirmButtonClass: 'btn btn-primary font-weight-bold'
                });
            });

            function readFile() {

                if (!this.files || !this.files[0]) return;

                const FR = new FileReader();

                FR.addEventListener("load", function(evt) {
                    // document.querySelector("#img").src = evt.target.result;
                    // document.querySelector("#b64").textContent = evt.target.result;
                    // console.log(evt.target.result);
                    var data = evt.target.result;
                    $('#base64_image').val(data);
                });

                FR.readAsDataURL(this.files[0]);

            }

            document.querySelector("#product_image").addEventListener("change", readFile);

        });
    </script>
@section('content')
    @if (Auth::user()->role_id != 1)
        <div class="alert alert-danger mt-5">Anda Tidak Memiliki Akses ke Halaman ini</div>
    @else
        <div class="d-flex flex-column-fluid">
            <!--begin::Container-->
            <div class="container">
                @include('partials.masterdata.menu-2')
                <div class="flex-row-fluid ml-lg-12">

                    <form action="{{ route('storeBundle') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card card-custom">
                            <div class="card-header flex-wrap border-0 pt-6 pb-0">
                                <div class="card-title">
                                    <h3 class="card-label text-uppercase text-dark-75">Buat Bundel
                                    </h3>
                                </div>
                                <div class="card-toolbar"> <button type="submit"
                                        class="btn btn-success font-weight-bolder text-uppercase px-9 py-4">Submit</button>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="row mg-lg-12">
                                    <div class="col-sm-12 col-md-6 pl-15">
                                        <div class="card card-custom gutter-b card-stretch">
                                            <div class="card-header border-0 pt-5">
                                                <div class="card-title">Bundle Information</div>

                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-xl-6">
                                                        <!--begin::Input-->
                                                        <div class="form-group fv-plugins-icon-container has-success">
                                                            <label>Nama Bundle</label>
                                                            <input id="bundleName" type="text"
                                                                class="form-control form-control-solid form-control-lg"
                                                                name="product_name" placeholder="Enter" required>
                                                            <span class="form-text text-muted">Please enter your product
                                                                name.</span>
                                                            <div class="fv-plugins-message-container"></div>
                                                        </div>
                                                        <!--end::Input-->
                                                    </div>
                                                    <div class="col-xl-6">
                                                        <!--begin::Input-->
                                                        <div class="form-group fv-plugins-icon-container has-success">
                                                            <label>productSKU</label>
                                                            <input required style="text-transform:uppercase" type="text"
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
                                                    <input required type="text"
                                                        class="form-control form-control-solid form-control-lg"
                                                        name="description" placeholder="Enter Description"
                                                        id="productDescription">
                                                    <span class="form-text text-muted">Deskripsi tentang produk.</span>
                                                    <div class="fv-plugins-message-container"></div>
                                                </div>
                                                <!--end::Input-->

                                                <div class="row">
                                                    <div class="col-xl-6">
                                                        <!--begin::Input-->
                                                        <div class="form-group fv-plugins-icon-container has-success">
                                                            <label>Outlet</label>
                                                            <select required name="outlet"
                                                                class="form-control form-control-solid form-control-lg"
                                                                id="productOutlet">
                                                                <option selected="selected" value="0"
                                                                    selected="selected">
                                                                    Pilih
                                                                    Outlet</option>
                                                                @foreach ($row['outlets'] as $key => $value)
                                                                    <option value="{{ $value->id }}">
                                                                        {{ $value->outlet_name }}</option>
                                                                @endforeach
                                                            </select>
                                                            <div class="fv-plugins-message-container"></div>
                                                        </div>
                                                        <!--end::Input-->
                                                    </div>
                                                    <div class="col-xl-6">
                                                        <!--begin::Select-->
                                                        <div class="form-group fv-plugins-icon-container has-success">
                                                            <label>Kategori</label>
                                                            <select required name="category"
                                                                class="form-control form-control-solid form-control-lg"
                                                                id="productCategory">
                                                                <option selected="selected"value="0"
                                                                    selected="selected">
                                                                    Pilih
                                                                    Kategori</option>
                                                                @foreach ($row['categories'] as $key => $value)
                                                                    <option value="{{ $value->id }}">
                                                                        {{ $value->category_name }}</option>
                                                                @endforeach
                                                            </select>
                                                            <div class="fv-plugins-message-container"></div>
                                                        </div>
                                                        <!--end::Select-->
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xl-6">
                                                        <!--begin::Input-->
                                                        <div class="form-group">
                                                            <label>Harga</label>
                                                            <input required type="text"
                                                                class="form-control form-control-solid form-control-lg"
                                                                placeholder="Example : 30000" name="price_display"
                                                                id="bundlePrice">
                                                            <span class="form-text text-muted">Please enter your
                                                                Price.</span>
                                                        </div>

                                                        <!--end::Input-->
                                                    </div>
                                                    <div class="col-xl-6">
                                                        <div class="form-group">
                                                            <label>Harga Promo</label>
                                                            <input required type="text"
                                                                class="form-control form-control-solid form-control-lg"
                                                                placeholder="Example : 28000" name="price_promo"
                                                                id="bundlePricePromo">
                                                            <span class="form-text text-muted">Please enter your Promo
                                                                Price.</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- Gambar --}}
                                                <div class="form-group">
                                                    <label for="">Gambar Produk</label><br>
                                                    <div class="image-input image-input-empty image-input-outline"
                                                        id="kt_image_5" {{-- style="background-image: url(assets/media/users/blank.png)" --}}>
                                                        <div class="image-input-wrapper"
                                                            style="width: 400px; height:400px
                                                    ">
                                                        </div>

                                                        <label
                                                            class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                                            data-action="change" data-toggle="tooltip" title=""
                                                            data-original-title="Change avatar">
                                                            <i class="fa fa-pen icon-sm text-muted"></i>
                                                            <input type="file" id="product_image" name="product_image"
                                                                accept=".png, .jpg, .jpeg" required />
                                                            <input type="hidden" name="base64_image" id="base64_image"
                                                                value="">
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
                                        </div>

                                    </div>
                                    <div class="col-sm-12 col-md-6 pl-15">
                                        <div class="card card-custom gutter-b card-stretch">
                                            <div class="card-header border-0 pt-5">
                                                <div class="card-title">Bundle Items</div>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-lg-12 col-sm-12" data-select2-id="38">
                                                        <select class="form-control select2 select2-hidden-accessible"
                                                            id="kt_select2_4" name="product_id"
                                                            data-select2-id="kt_select2_4" tabindex="-1"
                                                            aria-hidden="true">
                                                            <option value="0">
                                                                Pilih Items
                                                            </option>
                                                            @foreach ($row['products'] as $key => $value)
                                                                <option value="{{ $value->id }}">
                                                                    {{ $value->product_name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row mt-6 mb-0">
                                                    <div class="col-lg-6 mb-0">
                                                        <label for="Nama Items">Items</label>
                                                    </div>
                                                    <div class="col-lg-4 mb-0">
                                                        <label for="Qty">Qty</label>
                                                    </div>
                                                </div>

                                                <div id="itemLists">
                                                    <input type="hidden" name="product_id" required>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <code class="language-js">

        </code>
    @endif
@endsection
