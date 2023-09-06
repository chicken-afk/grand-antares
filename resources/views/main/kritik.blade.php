@extends('master')

@section('header-name')
    Kritik dan Saran
@endsection
@section('menu-detail')
    Menu Melihat Kritk dan Saran
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/pagination.css') }}">
@endsection

@section('content')
    <div class="container">
        <div class="flex-row-fluid">
            <div class="card card-custom card-stretch">
                <div class="card-header py-3">
                    <div class="card-title align-items-start flex-column">
                        <h3 class="card-label font-weight-bolder text-dark">Kritik dan Saran</h3>
                        <span class="text-muted font-weight-bold font-size-sm mt-1">Data Kritik dan Saran dari
                            pengguna</span>
                    </div>
                </div>

                <div class="card-body py-3">
                    <table class="table table-head-custom">
                        <thead>
                            <tr>
                                <th class="p-0 min-w-200px">Nama</th>
                                <th class="p-0 min-w-200px">Kritik dan Saran</th>
                                <th class="p-0 min-w-120px">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($row['datas'] as $val)
                                <tr>
                                    <td>
                                        {{ $val->order->name }}
                                    </td>
                                    <td>{{ $val->kritik }}</td>
                                    <td>{{ date('H:i:s m-d-Y', strtotime($val->created_at)) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td>Data Kosong</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="row pb-5">
                        <div class="pagination">
                            {{ $row['datas']->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
