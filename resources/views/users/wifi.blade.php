@extends('users.main')
@section('content')
    <div style="margin-top: 80px"></div>
    <div class="container">
        <div class="wifi-list">
            <div class="badge bg-warning text-wrap text-dark" style="font-size:0.9rem">
                Harap sambungkan
                perangkat anda
                dengan salah
                satu wifi
                dibawah ini untuk
                melanjutkan:
            </div>
            {{-- <span class="text-dark bg-warning text-sm-start bd-dark my-4" style="font-size: 0.85rem"></span> --}}
            @foreach ($wifi as $value)
                <div class="text-nowrap bg-light border mt-2 mb-2" style="font-size: 0.8rem">
                    Nama Wifi : {{ $value->wifi_name }}
                </div>
            @endforeach
            <a href="{{ route('dashboardUser', $row['code']) }}" class="text-right" style="font-size: 0.7rem">Sudah tersambung?
                Klik disini</a>
        </div>
    </div>
@endsection
