@extends('users.main-cart')

@section('js')
    <script src="{{ asset('users/js/cart.js') . '?v=' . time() }}"></script>
@endsection
@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
    <div class="container">
        <a href="{{ route('userPage', $code) }}" class="back-button">
            <div class="back-button">
                <i class='bx bx-arrow-back'>kembali</i>
            </div>
        </a>
        <div class="card card-orders">
            <div class="card-header">
                <h4 class="title-orders">
                    <div class="child"> Daftar Pesanan <p>Periksa Kembali Pesanan Anda</p>
                    </div>
                    <div class="child-2 ms-auto">
                        <a href="{{ route('userPage', $code) }}"><span>Tambah</span></a>
                    </div>

                </h4>
            </div>
            <div class="card-body mb-10" id="content-body">
                {{-- Append content using javascript --}}
            </div>
        </div>

        <div class="card card-orders" id="detailPemesan" style="margin-bottom : 100px !important;">
            <div class="card-header">
                <h4 class="title-orders">
                    <div class="child"> Detail Pemesan</div>
                </h4>
            </div>
            <div class="card-body detail-users">
                <div class="form-group">
                    <label>Dine In atau takeaway?</label>
                    <div class="radio-inline">
                        <label class="radio radio-lg">
                            <input type="radio" checked="checked" name="keterangan" value="Dine In">
                            <span></span>Dine In (Makan Ditempat)</label>
                        <label class="radio radio-lg">
                            <input type="radio" name="keterangan" value="Take Away">
                            <span></span>Take Away(Dibungkus)</label>
                    </div>
                </div>
                <div class="inpout-group mb-1">
                    <label for="">Nama Pemesan</label>
                    <p id="alert-user" class="d-none">Wajib Mengisi Nama</p>
                    <input id="nUser" type="text" class="form-control" placeholder="Nama Pemesan"
                        aria-label="Nama Pemesan" aria-describedby="basic-addon1" name="name" required>
                </div>
                <div class="inpout-group mb-1">
                    <label for="">Nomor HP/WHatsapp</label>
                    <p id="alert-user" class="d-none">Wajib Mengisi Nama</p>
                    <input id="nWhatsapp" type="text" class="form-control" placeholder="No HP" aria-label="Nama Pemesan"
                        aria-describedby="basic-addon1" name="whatsapp" required>
                </div>
                <input type="hidden" name="code" value="{{ $code }}" id="code">
                @if ($code == config('appsetting.room_code'))
                    <div class="inpout-group mb-1">
                        <label for="">Nomor Kamar</label>
                        <p id='alert-table' class="d-none mb-0">Wajib Mengisi Nomor Kamar</p>
                        {{-- <p class="bg-alert">Input nomor Kamar</p> --}}
                        <input id="nTable" type="number" class="form-control" placeholder="Nomor Kamar"
                            aria-label="Nomor Kamar" aria-describedby="basic-addon1" name="table_no">
                    </div>
                @endif
                <div class="form-group">
                    <label for="paymentMethod">Metode Pembayaran</label>
                    <select class="form-control form-control-sm" name="payment_method" id="paymentMethod">
                        @foreach ($row['payment_methods'] as $val)
                            <option value="{{ strtoupper($val->payment_method) }}">{{ strtoupper($val->payment_method) }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('footer')
    <div class="footer sticky-bottom">
        <button onclick="submitOrders()" id="buttonCheckout" type="button" class="btn btn-sm btn-primary">
            {{-- Generate Using Javascript --}}
        </button>
    </div>
@endsection
