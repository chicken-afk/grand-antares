@extends('master')

@section('header-name')
    Profile Setting
@endsection
@section('menu-detail')
    Menu Mengelola Profile Information
@endsection

@section('content')
    <div class="container">
        <div class="flex-row-fluid">
            <!--begin::Card-->
            <div class="row my-6">
                <div class="col-md-6">

                    <div class="card card-custom card-stretch my-2">
                        <!--begin::Header-->
                        <div class="card-header py-3">
                            <div class="card-title align-items-start flex-column">
                                <h3 class="card-label font-weight-bolder text-dark">Customer Service</h3>
                                <span class="text-muted font-weight-bold font-size-sm mt-1">Data Nomor Whatsapp Customer
                                    Service</span>
                            </div>

                            <form class="form" autocomplete="off" action="{{ route('saveWhatsapp') }}" method="POST">
                                @csrf
                                <div class="card-toolbar d-flex justify-content-end align-items-right text-right">
                                    {{-- <p class="text-dark text-weight-bolder font-size-sm">Tambah Whatsapp CS</p> --}}
                                    <input type="text" name="name" class="form-control flex-grow-1 mr-2 my-2"
                                        placeholder="Nama" required>
                                    <input type="text" name="whatsapp" class="form-control flex-grow-1 mr-2 my-2"
                                        placeholder="Masukan Nomor Whatsapp CS" required>
                                    <button type="submit" class="btn btn-sm btn-primary my-2">Simpan</button>
                                </div>
                            </form>
                        </div>
                        <!--end::Header-->
                        <!--begin::Form-->
                        <!--begin::Body-->
                        <div class="card-body">
                            <table
                                class="table table-separate table-head-custom table-checkable dataTable no-footer dtr-inline">
                                <thead>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Nomor Whatsapp</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </thead>
                                <tbody>
                                    @forelse ($row['customer_services'] as $key => $cs)
                                        <tr>
                                            <td class="text-dark"><span>{{ $key + 1 }}</span></td>
                                            <td class="text-dark"><span>{{ $cs->name }}</span></td>
                                            <td class="text-dark"><span>{{ $cs->whatsapp }}</span></td>
                                            <td class="text-dark">
                                                <span>{{ $cs->is_active == 1 ? 'Aktif' : 'Tidak Aktif' }}</span>
                                            </td>
                                            <td class="text-dark">
                                                <a class="btn btn-sm {{ $cs->is_active == 1 ? 'btn-outline-danger' : 'btn-outline-success' }}"
                                                    href="{{ route('whatsappChangeStatus', $cs->id) }}">{{ $cs->is_active == 1 ? 'nonaktifkan' : 'aktifkan' }}</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">
                                                Data Kosong
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <!--end::Body-->
                        <!--end::Form-->
                    </div>
                </div>
                <div class="col-md-6">

                    <div class="card card-custom card-stretch my-2">
                        <!--begin::Header-->
                        <div class="card-header py-3">
                            <div class="card-title align-items-start flex-column">
                                <h3 class="card-label font-weight-bolder text-dark">IP Address</h3>
                                <span class="text-muted font-weight-bold font-size-sm mt-1">Daftar Ip Address yang bisa
                                    akses menu tamu</span>
                            </div>
                            <div class="card-toolbar d-flex justify-content-end align-items-right text-right">
                                <button type="submit" class="btn btn-sm btn-primary my-2" data-toggle="modal"
                                    data-target="#addModal">+Tambah</button>
                            </div>
                        </div>
                        <!--end::Header-->
                        <!--begin::Form-->
                        <!--begin::Body-->
                        <div class="card-body">
                            <table
                                class="table table-separate table-head-custom table-checkable dataTable no-footer dtr-inline">
                                <thead>
                                    <th>No</th>
                                    <th>Nama Wifi</th>
                                    <th>IP Address</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </thead>
                                <tbody>
                                    @forelse ($row['ip_address'] as $key => $ip)
                                        <tr>
                                            <td class="text-dark"><span>{{ $key + 1 }}</span></td>
                                            <td class="text-dark"><span>{{ $ip->wifi_name }}</span></td>
                                            <td class="text-dark"><span>{{ $ip->ip_address }}</span></td>
                                            <td class="text-dark">
                                                <span>{{ $ip->is_active == 1 ? 'Aktif' : 'Tidak Aktif' }}</span>
                                            </td>
                                            <td class="text-dark">
                                                <a class="btn btn-sm {{ $ip->is_active == 1 ? 'btn-outline-danger' : 'btn-outline-success' }}"
                                                    href="{{ route('wifiChangeStatus', $ip->id) }}">{{ $ip->is_active == 1 ? 'nonaktifkan' : 'aktifkan' }}</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">
                                                Data Kosong
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <!--end::Body-->
                        <!--end::Form-->
                    </div>
                </div>
            </div>
            <!--begin::Card-->
            <div class="card card-custom card-stretch my-2">
                <!--begin::Header-->
                <div class="card-header py-3">
                    <div class="card-title align-items-start flex-column">
                        <h3 class="card-label font-weight-bolder text-dark">Personal Information</h3>
                        <span class="text-muted font-weight-bold font-size-sm mt-1">Update your personal informaiton</span>
                    </div>

                    <form class="form" autocomplete="off" action="{{ route('saveSetting') }}" method="POST">
                        <div class="card-toolbar">
                            <button type="submit" class="btn btn-primary mr-2">Save Changes</button>
                            {{-- <button type="reset" class="btn btn-secondary">Cancel</button> --}}
                        </div>
                </div>
                <!--end::Header-->
                <!--begin::Form-->
                <!--begin::Body-->
                <div class="card-body">
                    @csrf
                    <div class="row">
                        <label class="col-xl-3"></label>
                        <div class="col-lg-9 col-xl-6">
                            <h5 class="font-weight-bold mb-6">Profile Info</h5>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label">Name</label>
                        <div class="col-lg-9 col-xl-6">
                            <input class="form-control form-control-lg form-control-solid" type="text"
                                value="{{ Auth::user()->name }}" name="name">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label">Email</label>
                        <div class="col-lg-9 col-xl-6">
                            <input class="form-control form-control-lg form-control-solid" type="text"
                                value="{{ Auth::user()->email }}" name="email">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label">Role</label>
                        <div class="col-lg-9 col-xl-6">
                            <input class="form-control form-control-lg form-control-solid" type="text"
                                value="{{ $row['users']->role_name }}" disabled>
                            <span class="form-text text-muted"></span>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-xl-3"></label>
                        <div class="col-lg-9 col-xl-6">
                            <h5 class="font-weight-bold mt-10 mb-6">Password</h5>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label">New Password</label>
                        <div class="col-lg-9 col-xl-6">
                            <div class="input-group input-group-lg input-group-solid">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        {{-- <i class="la la-phone"></i> --}}
                                    </span>
                                </div>
                                <input type="password" class="form-control form-control-lg form-control-solid"
                                    name="new_password" placeholder="Password" autocomplete="off">
                            </div>
                            <span class="form-text text-muted">Insert Your New Password.</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label">Password Confirmation</label>
                        <div class="col-lg-9 col-xl-6">
                            <div class="input-group input-group-lg input-group-solid">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        {{-- <i class="la la-phone"></i> --}}
                                    </span>
                                </div>
                                <input type="text" class="form-control form-control-lg form-control-solid"
                                    name="new_password_confirmation" placeholder="Password Confirmation"
                                    autocomplete="off">
                            </div>
                            <span class="form-text text-muted">Insert Your New Password.</span>
                        </div>
                    </div>

                </div>
                <!--end::Body-->
                </form>
                <!--end::Form-->
            </div>

        </div>
        {{-- Modal --}}
        <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah Data Wifi</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="card card-custom">
                            <!--begin::Form-->
                            <form action="{{ route('postIpAddress') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group mb-8">
                                        <div class="form-group">
                                            <label>Nama Wifi<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="wifi_name"
                                                placeholder="Masukan Nama WIfi" required />
                                        </div>
                                        <div class="form-group">
                                            <label>IP Address Wifi<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="ip_address"
                                                placeholder="Masukan Ip Address Wifi" required />
                                        </div>
                                    </div>
                                    <!--end::Form-->
                                </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light-primary font-weight-bold"
                                data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary font-weight-bold">Save changes</button>

                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
