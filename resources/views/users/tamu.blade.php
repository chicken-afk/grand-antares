@extends('users.main')

@section('css')
    <style>
        .slider {
            width: 100%;
            height: 21vh;
            position: relative;
        }

        .slider img {
            width: 100%;
            height: 20vh;
            position: absolute;
            top: 0;
            left: 0;
            /* transition: all 0.5s ease-in-out; */
        }

        .slider img:first-child {
            z-index: 1;
        }

        .slider img:nth-child(2) {
            z-index: 0;
        }

        .navigation-button {
            text-align: center;
            position: relative;
        }

        .dot {
            cursor: pointer;
            height: 10px;
            width: 10px;
            margin: 0 2px;
            background-color: #bbb;
            border-radius: 50%;
            display: inline-block;
        }

        .active,
        .dot:hover {
            background-color: #717171;
        }
    </style>
@endsection
@section('js')
    <script>
        function searchInvoice() {
            let invoice = document.getElementById('invoiceNumber').value ?? null;
            console.log(invoice)
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: `/invoice-search?invoice_number=${invoice}`,
                type: "GET",
                success: function(response) {
                    if (response == '') {
                        document.getElementById("alertSearch").innerHTML =
                            `<p style="font-size: 0.75rem" class="text-bold alert alert-warning mt-2">Invoice ${invoice} tidak ditemukan</p>`;
                        return 0
                    }
                    console.log(response)
                    let text = "";
                    if (response.order_status == 'diterima') {
                        text = `Pesanan ${invoice} diterima kasir`
                    } else if (response.order_status = 'diproses') {
                        text = `Pesanan ${invoice} sedang diproses`
                    } else {
                        text = `Pesanan ${invoice} selesai diproses`
                    }
                    document.getElementById("alertSearch").innerHTML =
                        `<p style="font-size: 0.75rem" class="text-bold alert alert-warning mt-2">${text}
                            <a href="/cek-invoices?invoices=${invoice}">Lihat pesanan<a>
                            </p>
                        `;

                    // document.getElementById("searchContent").innerHTML = html;
                },
                error: function(response) {
                    console.log("Error gan")
                }
            });
        }
    </script>
    <script>
        let currentSlide = 0;
        const slides = document.querySelectorAll('.slider img');
        const dots = document.querySelectorAll('.dot');
        let touchStartX = 0;
        let touchEndX = 0;

        function showSlide(index) {
            if (index < 0) {
                index = slides.length - 1;
            } else if (index >= slides.length) {
                index = 0;
            }

            slides.forEach((slide) => {
                slide.style.display = 'none';
            });

            dots.forEach((dot) => {
                dot.classList.remove('active');
            });

            slides[index].style.display = 'block';
            dots[index].classList.add('active');
            currentSlide = index;
        }

        function changeSlide(index) {
            showSlide(index);
        }

        function nextSlide() {
            showSlide(currentSlide + 1);
        }

        function prevSlide() {
            showSlide(currentSlide - 1);
        }

        function handleTouchStart(event) {
            touchStartX = event.touches[0].clientX;
        }

        function handleTouchMove(event) {
            touchEndX = event.touches[0].clientX;
        }

        function handleTouchEnd() {
            if (touchEndX < touchStartX) {
                nextSlide();
            } else if (touchEndX > touchStartX) {
                prevSlide();
            }
        }

        setInterval(nextSlide, 5000); // Ganti slide setiap 5 detik

        showSlide(currentSlide); // Tampilkan slide pertama saat halaman dimuat

        // Menambahkan event listeners untuk mendeteksi swipe
        // const sliderElement = document.querySelector('.slider');
        // sliderElement.addEventListener('touchstart', handleTouchStart);
        // sliderElement.addEventListener('touchmove', handleTouchMove);
        // sliderElement.addEventListener('touchend', handleTouchEnd);
    </script>
    <script>
        var invoices = JSON.parse(localStorage.getItem("invoices") || "[]");
        var listHtml = "";
        invoices.forEach(element => {
            listHtml += `
            <p class="mt-1 mb-1 ml-3" style="font-size: 0.6rem;font-weight:600">${element}</p>
            `;
        });
        document.getElementById('listInvoices').innerHTML = listHtml;
    </script>
@endsection

@section('content')
    {{-- banner Promo --}}
    <div class="banner">
        <div class="slider">
            @php $keyBanner = 0; @endphp
            @foreach ($row['slide_banners'] as $key => $banner)
                @if ($banner->products_count == 0)
                    <a href="#" style="text-decoration: none" href="">
                        <img id="img-{{ $keyBanner }}" src="{{ asset($banner->banner_image) }}"
                            alt="Image {{ $keyBanner }}" />
                    </a>
                @else
                    <a href="{{ route('userPage', ['code' => $row['code'], 'banner_id' => $banner->id, 'banner' => 'true']) }}"
                        style="text-decoration: none" href="">
                        <img id="img-{{ $keyBanner }}" src="{{ asset($banner->banner_image) }}"
                            alt="Image {{ $keyBanner }}" />
                    </a>
                @endif
                @php $keyBanner++; @endphp
            @endforeach
            @foreach ($row['banners'] as $key => $banner)
                <a href="{{ route('userPage', ['code' => $row['code'], 'category_id' => 'promo', 'is_promo_product' => true, 'promo_product_id' => $banner->uuid]) }}"
                    style="text-decoration: none" href="">
                    <img id="img-{{ $keyBanner }}" src="{{ asset($banner->banner_promo) }}"
                        alt="Image {{ $keyBanner }}" />
                </a>
                @php $keyBanner++; @endphp
            @endforeach
        </div>
        <div class="navigation-button">
            @php $ind = 0; @endphp
            @for ($keyBanner; $keyBanner > $ind; $ind++)
                <span class="dot active" onclick="changeSlide({{ $ind }})"></span>
            @endfor
        </div>
    </div>
    {{-- end banner promo --}}
    <div class="container">
        <div class="product-wrap mt-2">
            @if ($row['type'] == 'room')
                <h3 class="category-title">Room Service:</h3>
            @else
                <h3 class="category-title">Restaurant Service:</h3>
            @endif
        </div>
        <div class="row">
            <div class="col-4 d-flex flex-column align-items-center justify-content-center pt-4">
                <a class="block p-1" href="{{ route('userPage', ['code' => $row['code'], 'category_id' => 'promo']) }}">
                    <div class="image-container">
                        <img src="{{ asset('media/categories/discount.svg') }}"
                            class="rounded float-start thumbnail-category" alt="">
                    </div>
                    <div class="category-detail">
                        <span>Promo</span>
                    </div>
                </a>
            </div>
            @foreach ($row['categories'] as $value)
                <div class="col-4 d-flex flex-column align-items-center justify-content-center pt-4">
                    <a class="block p-1"
                        href="{{ route('userPage', ['code' => $row['code'], 'category_id' => $value->id]) }}">
                        <img src="{{ asset("$value->category_image") }}" class="rounded float-start thumbnail-category"
                            alt="">
                        <div class="category-detail">
                            <span>{{ $value->category_name }}</span>
                        </div>
                    </a>
                </div>
            @endforeach
            <div class="col-4 d-flex flex-column align-items-center justify-content-center pt-4">
                <a class="block p-1" href="{{ route('userPage', $row['code']) }}">
                    <img src="{{ asset('media/categories/category-all.svg') }}"
                        class="rounded float-start thumbnail-category" alt="">
                    <div class="category-detail">
                        <span>Semua</span>
                    </div>
                </a>
            </div>
        </div>
        <div class="row mt-4 block pb-2">
            <div class="col-md-12">
                <p class="mt-3 mb-1" style="font-size: 0.75rem;font-weight:600">Cek Status Pesanan</p>
                <div class="form-group text-align-right" style="text-align: right">
                    <input type="text" class="form-control" placeholder="Masukan Nomor Invoice" id="invoiceNumber">
                    <button onclick="searchInvoice()" class="btn btn-sm btn-primary mt-2">Cari</button>
                </div>
                <div id="alertSearch">

                </div>
                <p class="mt-1 mb-1" style="font-size: 0.75rem;font-weight:600">Daftar kode pesanan:</p>
                <div id="listInvoices" class="ml-2" style="margin-left: 4px">
                    <p class="mt-1 mb-1 ml-3" style="font-size: 0.6rem;font-weight:600">INVD38</p>
                </div>
            </div>
        </div>

    </div>
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
                            <div class="col-5 text-center">
                                <span>{{ $cs->name }} : </span>
                            </div>
                            <div class="col-7">
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
    {{-- End Floating --}}
@endsection
