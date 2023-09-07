@extends('users.main')

@section('header-content')
    <div class="container fillter-section">
        <div class="row">
            <div class="col-sm-12">
                <select onchange="navigateToRoute(this)" class="form-select bg-light form-select-sm fillter-category"
                    aria-label="Default select example">
                    <option value="{{ route('userPage', $row['code']) }}"
                        {{ $row['category_id'] == 'semua' ? 'selected' : null }}>Semua</option>
                    <option value="{{ route('userPage', ['code' => $row['code'], 'category_id' => 'promo']) }}"
                        {{ $row['category_id'] == 'promo' ? 'selected' : null }}>
                        Promo</option>
                    @foreach ($row['cat'] as $key => $value)
                        <option {{ $row['category_id'] == $value->id ? 'selected' : null }}
                            value="{{ route('userPage', ['code' => $row['code'], 'category_id' => $value->id]) }}">
                            {{ $value->category_name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
@endsection


@section('content')
    <div class="container">
        <div style="margin-top: 100px"></div>
        @php $c = 0; @endphp
        @foreach ($row['categories'] as $key => $value)
            @if ($row['categories'][$key]->products->count() != 0)
                @php $c++ @endphp
                <div class="product-wrap">
                    @php
                        $subCategories = DB::table('sub_categories')
                            ->where('category_id', $value->id)
                            ->get();
                    @endphp
                    <div class="row">
                        <div class="col">
                            <h3 class="category-title">{{ $value->category_name }}</h3>
                        </div>
                        <div class="col text-right" style="text-align: right">
                            @if ($subCategories->count() > 0)
                                <select name="subCategoryId" data-category-id="{{ $value->id }}"
                                    data-menu-key="menu{{ $key }}" onchange="changeDataProduct(this)">
                                    <option value="semua">Semua</option>
                                    @foreach ($subCategories as $sub)
                                        <option value="{{ $sub->id }}">{{ $sub->sub_category_name }}</option>
                                    @endforeach
                                </select>
                            @endif
                        </div>
                    </div>

                    <div id="menu{{ $key }}">
                        @foreach ($row['categories'][$key]->products as $val)
                            @if ($val->price_display != 0)
                                <div class="product_list" data-bs-toggle="modal"
                                    data-bs-target="#productModal{{ $val->uuid }}">
                                    <div class="d-flex">
                                        <div class="p-2 wrapper_image">
                                            <img loading="lazy" src="{{ asset($val->product_image) }}"
                                                class="rounded float-start thumbnail-product" alt="...">
                                        </div>
                                        {{-- <div class="p-2 wrapper_image">
                                        <img loading="lazy" src="" alt="product image"
                                            class="rounded float-start thumbnail-product" alt="...">
                                    </div> --}}
                                        <div class="p-0 product_detail pt-2">
                                            <h4>{{ $val->active_product_name }}</h4>
                                            <p>{{ $val->description }}</p>
                                            @if ($val->is_available == 0)
                                                <span class="text-danger">Habis</span>
                                            @else
                                                @if ($val->is_promo == 0)
                                                    <span>Rp. {{ number_format($val->price_display) }},-</span>
                                                @else
                                                    <h5 class="slice">Rp. {{ number_format($val->price_display) }},-</h5>
                                                    <span>Rp. {{ number_format($val->price_promo) }},-</span>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="line-1"></div>
                                {{-- Modal FullScreen --}}
                                <!-- Full screen modal -->
                                <!-- Modal -->
                                <div class="modal fade" data-easein="flipXIn" id="productModal{{ $val->uuid }}"
                                    tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-fullscreen modal-dialog-scrollable">
                                        <div class="modal-content modal-product">
                                            <div class="modal-body">
                                                <button type="button" class="btn-close close-modal" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                                <div class="justify-content-center text-center" style="">
                                                    <img loading="lazy" src="{{ asset($val->product_image) }}"
                                                        class="rounded img-fluid" alt="...">
                                                </div>
                                                {{-- <div class="justify-content-center text-center" style="">
                                                <img loading="lazy" src="" alt="product image" class="rounded img-fluid"
                                                    alt="...">
                                            </div> --}}
                                                <div class="product-detail">
                                                    <input type="hidden" id="uuid-{{ $val->uuid }}"
                                                        value="{{ $val->uuid }}">
                                                    <input type="hidden" id="product_name-{{ $val->uuid }}"
                                                        value="{{ $val->active_product_name }}">
                                                    <input type="hidden" id="description-{{ $val->uuid }}"
                                                        value="{{ $val->description }}">
                                                    <input type="hidden" name="product_image"
                                                        id="image-{{ $val->uuid }}"
                                                        value="{{ asset($val->product_image) }}">
                                                    <h4>{{ $val->active_product_name }}</h4>
                                                    <p>{{ $val->description }}</p>
                                                    <input type="hidden" name="price_promo"
                                                        id="price-promo-{{ $val->uuid }}"
                                                        value="{{ $val->price_promo }}">
                                                    <input type="hidden" name="price_display"
                                                        id="price-display-{{ $val->uuid }}"
                                                        value="{{ $val->price_display }}">
                                                    @if ($val->is_available == 0)
                                                        <span class="text-danger">Habis</span>
                                                    @else
                                                        @if ($val->price_promo == null)
                                                            <span>Rp. {{ number_format($val->price_display) }},-</span>
                                                        @else
                                                            <h5 class="slice">Rp.
                                                                {{ number_format($val->price_display) }},-
                                                            </h5>
                                                            <span>Rp. {{ number_format($val->price_promo) }},-</span>
                                                        @endif
                                                    @endif
                                                    <div>
                                                        <div class="varian">
                                                            <div class="d-flex justify-content-center mt-1000">
                                                                <div class="number-plus-minus">
                                                                    <input disabled class="inputQty" name="product_qty"
                                                                        id="qty-{{ $val->uuid }}" type="number" value=1
                                                                        min=1 step="1" required />

                                                                    <button onclick="submitPlus('{{ $val->uuid }}')"
                                                                        id="{{ $val->uuid }}" type="button"
                                                                        class="plus"></button>
                                                                    <button onclick="submitMin('{{ $val->uuid }}')"
                                                                        id="{{ $val->uuid }}" type="button"
                                                                        class="minus"></button>

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            @if ($val->varians->count() > 0)
                                                                <div class="varian" id="add-form{{ $val->uuid }}">
                                                                    <h4>Varian</h4>
                                                                    <p id="requiredvarian{{ $val->uuid }}"
                                                                        class="text-danger mb-2 d-none">Wajib
                                                                        memilih varian</p>
                                                                    <div class="swappy-radios" role="radiogroup"
                                                                        aria-labelledby="swappy-radios-label">
                                                                        @foreach ($val->varians as $i)
                                                                            @if ($i->varian_price != 0 || $i->varian_price != null)
                                                                                <label>
                                                                                    @php
                                                                                        $varPrice = $val->is_promo == 0 ? $i->varian_price : $i->varian_promo;
                                                                                    @endphp
                                                                                    <input
                                                                                        value="{{ $i->id }}|{{ $i->varian_name }}|{{ $varPrice }}"
                                                                                        type="radio"
                                                                                        name="varian-{{ $val->uuid }}"
                                                                                        required />
                                                                                    <span class="radio"></span>
                                                                                    <span
                                                                                        class="d-flex align-item-center varian_name">{{ $i->varian_name }}
                                                                                        -
                                                                                        <div
                                                                                            class="@php if($val->is_promo == 1) echo 'slice' @endphp">
                                                                                            Rp.
                                                                                            {{ number_format($i->varian_price) }},-
                                                                                        </div>
                                                                                        @if ($val->is_promo == 1)
                                                                                            Rp.
                                                                                            {{ number_format($i->varian_promo) }},-
                                                                                        @endif
                                                                                    </span>
                                                                                </label>
                                                                                <div class="line-1"
                                                                                    style="margin-bottom : 20px;">
                                                                                </div>
                                                                            @endif
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                            @endif

                                                            @if ($val->toppings->count() > 0)
                                                                <div class="varian" id="toppings-{{ $val->uuid }}">
                                                                    <h4>Topping</h4>
                                                                    @foreach ($val->toppings as $p => $q)
                                                                        <div class="form-check">
                                                                            <input class="form-check-input"
                                                                                type="checkbox"
                                                                                value="{{ $q->id }}|{{ $q->topping_name }}|{{ $q->topping_price }}"
                                                                                id="flexCheckDefault">
                                                                            <label class="form-check-label"
                                                                                for="flexCheckDefault">
                                                                                {{ $q->topping_name }} +Rp.
                                                                                {{ number_format($q->topping_price) }}
                                                                            </label>
                                                                        </div>
                                                                        <div class="line-1"></div>
                                                                    @endforeach
                                                                </div>
                                                            @endif
                                                            <div class="varian">
                                                                <h4>Notes</h4>
                                                                <input id="notes-{{ $val->uuid }}" type="text"
                                                                    class="form-control form-control-solid form-control-sm"
                                                                    name="note-{{ $val->uuid }}"
                                                                    placeholder="Masukan note">
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer sticky-bottom">
                                                @if ($val->is_available == 1)
                                                    <button onclick="addToCart(`{{ $val->uuid }}`)" type="button"
                                                        class="btn btn-sm btn-primary">Tambah Ke
                                                        Keranjang</button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- End Modal Fullscreen --}}
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif
        @endforeach
        @if ($c == 0)
            <h3 style="margin-top: 120px;font-size: 1rem;"> Mohon maaf, produk tidak
                tersedia</h3>
        @endif
    </div>


    {{-- Floating Button --}}
    <a href="{{ route('cartPage', $row['code']) }}" class="float">
        <span id="totalCart"></span>
        <i class='bx bx-cart my-float'></i>
    </a>
    {{-- End Floating --}}

    {{-- Floating Button --}}
    <a data-bs-toggle="modal" data-bs-target="#whatsappModal" class="float-whatsapp">
        <i class='bx bxl-whatsapp my-float'></i>
    </a>
    {{-- Modal --}}
    <div class="modal fade" id="whatsappModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <span class="modal-title font-size-sm" id="exampleModalLabel">Customer Service</span>
                    </button>
                </div>
                <div class="modal-body">
                    @forelse ($row['customer_services'] as $cs)
                        <div class="row">
                            <div class="col-12 text-center">
                                <a target="_blank" class="text-dark-75"
                                    href="https://wa.me/{{ $cs->whatsapp }}">+{{ $cs->whatsapp }}</a>
                            </div>
                        </div>
                    @empty
                        <span>Belum Ada Customer Service</span>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="//cdn.jsdelivr.net/npm/velocity-animate@2.0/velocity.min.js"></script>
    <script>
        function totalCart() {
            var carts = JSON.parse(localStorage.getItem("carts") || "[]");
            $("#totalCart").html(carts.length);
        }

        // add the animation to the modal
        $(".product_list").on('click', function(index) {
            const inputQtyProduct = $('.inputQty');
            inputQtyProduct.val(1);
            inputQtyProduct.change();
        });



        // $(document).ready(function() {
        // $('.minus').click(function() {
        //     const inputQtyProduct = $(this).parent().find('.inputQty');
        //     var count = parseInt(inputQtyProduct.val()) - 1;
        //     count = count < 1 ? 1 : count;
        //     inputQtyProduct.val(count);
        //     inputQtyProduct.change();
        //     addedForm(this.id, count)
        //     return false;
        // });
        // $('.plus').click(function() {
        //     const inputQtyProduct = $(this).parent().find('.inputQty');
        //     console.log(inputQtyProduct)
        //     var qty = parseInt(inputQtyProduct.val()) + 1;
        //     inputQtyProduct.val(qty);
        //     inputQtyProduct.change();
        //     addedForm(this.id, qty)
        //     return false;
        // });

        function submitMin(id) {
            console.log('masuk min')
            const inputQtyProduct = document.getElementById("qty-" + id);
            var count = parseInt(inputQtyProduct.value) - 1;
            qty = count < 1 ? 1 : count;
            inputQtyProduct.value = qty;
            $("#qty-" + id).val(qty);
            addedForm(this.id, qty)
            return false;
        }

        function submitPlus(id) {
            console.log('masuk plusss')
            const inputQtyProduct = document.getElementById("qty-" + id);
            console.log(inputQtyProduct)
            var qty = parseInt(inputQtyProduct.value) + 1;
            inputQtyProduct.value = qty;
            $("#qty-" + id).val(qty);
            console.log("#qty-" + id)
            // addedForm(this.id, qty)
            return false;
        }

        function addedForm(uuid, qty) {
            console.log('qty = ', qty);
            var eId = 'add-form' + uuid;
            var element = document.getElementById(eId);
            console.log(eId)
            element.appendChild = '';
        }

        // });

        // Add to cart
        function addToCart(uuid) {
            var data = {};
            var total_price = 0;
            var varians = $(`input[name="varian-${uuid}"]:checked`).val();
            if ($(`#add-form${uuid}`).length) {
                if (varians == null) {
                    console.log('masuk sini');
                    var sVarian = document.getElementById(`add-form${uuid}`);
                    sVarian.scrollIntoView({
                        behavior: 'smooth'
                    }, true);
                    $(`#requiredvarian${uuid}`).removeClass("d-none");
                    return false
                } else {
                    $(`#requiredvarian${uuid}`).addClass("d-none");
                }
            }
            data['product_image'] = $(`#image-${uuid}`).val();
            var price_promo = parseInt($(`#price-promo-${uuid}`).val());
            var price_display = parseInt($(`#price-display-${uuid}`).val());
            data['uuid'] = $(`#uuid-${uuid}`).val();
            data['product_name'] = $(`#product_name-${uuid}`).val();
            data['description'] = $(`#description-${uuid}`).val();
            data['qty'] = parseInt($(`#qty-${uuid}`).val());
            data['note'] = $(`#notes-${uuid}`).val();

            if (varians != null) {
                var varianArray = varians.split("|");
                data['varian_id'] = parseInt(varianArray[0]);
                data['varian_name'] = varianArray[1];
                data['varian_price'] = parseInt(varianArray[2]);
            } else {
                console.log(price_display, price_promo)
                if (price_promo == null || isNaN(price_promo)) {
                    console.log('sama')
                    data['varian_price'] = price_display;
                } else {
                    console.log('beda')
                    data['varian_price'] = price_promo;
                }
                console.log(data)
            }
            total_price += data['varian_price'];


            var searchCheckbox = $(`#toppings-${uuid} input:checkbox:checked`).map(function() {
                return $(this).val();
            }).get();
            var toppings = [];
            for (var i = 0; i < searchCheckbox.length; i++) {
                var myArray = searchCheckbox[i].split("|");
                toppings[i] = {
                    "topping_name": myArray[1],
                    "topping_price": parseInt(myArray[2]),
                    "topping_id": parseInt(myArray[0])
                }
                total_price += parseInt(myArray[2]);
            }
            var price = total_price;
            total_price = total_price * data['qty'];
            data['toppings'] = toppings;
            data['total_price'] = total_price;
            data['price'] = price;
            var carts = JSON.parse(localStorage.getItem("carts") || "[]");
            console.log('cart awal :', carts)
            carts.push(data);
            console.log('carts after push', carts);
            localStorage.setItem("carts", JSON.stringify(carts));
            totalCart();
            $(`input[name="varian-${uuid}"]`).attr('checked', false);
            $(`#toppings-${uuid} input:checkbox`).attr('checked', false);
            // Swal.fire({
            //     icon: 'success',
            //     // title: 'Berhasil',
            //     text: 'Berhasil Menambahkan Produk Ke keranjang!',
            //     footer: '<a href="/carts">Lihat Keranjang</a>'
            // });
            Swal.fire({
                // title: 'Berhasil',
                position: 'center',
                title: '<p class="m-0" style="font-size : small; padding : 1px; color : black;">Berhasil Menambahkan Produk Ke keranjang!</p>',
                // width: 300,
                showConfirmButton: false,
                timer: 1500,
                background: '#FFFFFF'
            });

        }

        function scrollToId() {
            console.log('masuk');
            var selectBox = document.getElementById("selectBox");
            var selectedValue = selectBox.options[selectBox.selectedIndex].value;
            console.log(selectedValue)
            var access = document.getElementById(selectedValue);
            console.log(access)
            access.scrollIntoView({
                behavior: 'smooth',
                block: "end",
                inline: "nearest"
            }, true);
        }

        totalCart();

        function navigateToRoute(selectElement) {
            var selectedValue = selectElement.value;
            if (selectedValue) {
                window.location.href = selectedValue;
            }
        }
    </script>


    <script>
        $(document).ready(function() {
            if ("{{ Request::get('promo_product_id') }}" !== "") {
                let productPromoUuid = `{{ Request::get('promo_product_id') }}`;
                let modalId = `#productModal${productPromoUuid}`
                console.log(modalId)
                $(modalId).modal('show');
            }
        });
    </script>
    <script>
        let code = `{{ $row['code'] }}`;

        function changeDataProduct(selectElement) {
            // Mendapatkan nilai dari atribut data-category-id menggunakan dataset
            var categoryId = selectElement.dataset.categoryId;

            // Mendapatkan nilai dari atribut data-menu-key menggunakan dataset
            var menuKey = selectElement.dataset.menuKey;

            // Mendapatkan nilai yang dipilih dari elemen <select> menggunakan properti value
            var selectedValue = selectElement.value;

            // Menampilkan nilai-nilai yang telah diambil
            console.log('categoryId:', categoryId);
            console.log('menuKey:', menuKey);
            console.log('selectedValue:', selectedValue);

            // Lakukan apa yang perlu Anda lakukan dengan data ini di sini
            document.getElementById(`${menuKey}`).innerHTML = "";

            $.ajax({
                url: `/user-product?sub_category_id=${selectedValue}&code=${code}&category_id=${categoryId}`,
                type: "GET",
                success: function(response) {

                    console.log(response)
                    if (response.status_code == 422) {
                        Swal.fire({
                            icon: 'Error',
                            title: 'Gagal',
                            text: 'Data Tidak Ditemukan',
                        })
                        return false;
                    }
                    document.getElementById(`${menuKey}`).innerHTML = response;
                    return true;
                    // window.location = "/products"
                },
                error: function(response) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Something went wrong, please contact developer',
                    })
                }
            });
        }
    </script>
@endsection
