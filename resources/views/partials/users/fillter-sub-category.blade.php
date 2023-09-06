@foreach ($products as $val)
    @if ($val->price_display != 0)
        <div class="product_list" data-bs-toggle="modal" data-bs-target="#productModal{{ $val->uuid }}">
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
        <div class="modal fade" data-easein="flipXIn" id="productModal{{ $val->uuid }}" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-fullscreen modal-dialog-scrollable">
                <div class="modal-content modal-product">
                    <div class="modal-body">
                        <button type="button" class="btn-close close-modal" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                        <div class="justify-content-center text-center" style="">
                            <img loading="lazy" src="{{ asset($val->product_image) }}" class="rounded img-fluid"
                                alt="...">
                        </div>
                        {{-- <div class="justify-content-center text-center" style="">
                    <img loading="lazy" src="" alt="product image" class="rounded img-fluid"
                        alt="...">
                </div> --}}
                        <div class="product-detail">
                            <input type="hidden" id="uuid-{{ $val->uuid }}" value="{{ $val->uuid }}">
                            <input type="hidden" id="product_name-{{ $val->uuid }}"
                                value="{{ $val->active_product_name }}">
                            <input type="hidden" id="description-{{ $val->uuid }}"
                                value="{{ $val->description }}">
                            <input type="hidden" name="product_image" id="image-{{ $val->uuid }}"
                                value="{{ asset($val->product_image) }}">
                            <h4>{{ $val->active_product_name }}</h4>
                            <p>{{ $val->description }}</p>
                            <input type="hidden" name="price_promo" id="price-promo-{{ $val->uuid }}"
                                value="{{ $val->price_promo }}">
                            <input type="hidden" name="price_display" id="price-display-{{ $val->uuid }}"
                                value="{{ $val->price_display }}">
                            @if ($val->is_available == 0)
                                <span class="text-danger">Habis</span>
                            @else
                                @if ($val->price_promo == null)
                                    <span>Rp. {{ number_format($val->price_display) }},-</span>
                                @else
                                    <h5 class="slice">Rp. {{ number_format($val->price_display) }},-</h5>
                                    <span>Rp. {{ number_format($val->price_promo) }},-</span>
                                @endif
                            @endif
                            <div>
                                <div class="varian">
                                    <div class="d-flex justify-content-center mt-1000">
                                        <div class="number-plus-minus">
                                            <input disabled class="inputQty" name="product_qty"
                                                id="qty-{{ $val->uuid }}" type="number" value=1 min=1
                                                step="1" required />

                                            <button onclick="submitPlus('{{ $val->uuid }}')"
                                                id="{{ $val->uuid }}" type="button" class="plus"></button>
                                            <button onclick="submitMin('{{ $val->uuid }}')"
                                                id="{{ $val->uuid }}" type="button" class="minus"></button>

                                        </div>
                                    </div>
                                </div>
                                <div>
                                    @if ($val->varians->count() > 0)
                                        <div class="varian" id="add-form{{ $val->uuid }}">
                                            <h4>Varian</h4>
                                            <p id="requiredvarian{{ $val->uuid }}" class="text-danger mb-2 d-none">
                                                Wajib
                                                memilih varian</p>
                                            <div class="swappy-radios" role="radiogroup"
                                                aria-labelledby="swappy-radios-label">
                                                @foreach ($val->varians as $i)
                                                    <label>
                                                        @php
                                                            $varPrice = $val->is_promo == 0 ? $i->varian_price : $i->varian_promo;
                                                        @endphp
                                                        <input
                                                            value="{{ $i->id }}|{{ $i->varian_name }}|{{ $varPrice }}"
                                                            type="radio" name="varian-{{ $val->uuid }}"
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
                                                    <div class="line-1" style="margin-bottom : 20px;">
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                    @if ($val->toppings->count() > 0)
                                        <div class="varian" id="toppings-{{ $val->uuid }}">
                                            <h4>Topping</h4>
                                            @foreach ($val->toppings as $p => $q)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                        value="{{ $q->id }}|{{ $q->topping_name }}|{{ $q->topping_price }}"
                                                        id="flexCheckDefault">
                                                    <label class="form-check-label" for="flexCheckDefault">
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
                                            name="note-{{ $val->uuid }}" placeholder="Masukan note">
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
