@extends('master')
@section('header-name')
    User Management
@endsection
@section('script')
    <script>
        const outlet = document.getElementById('roleName');
        // outlet.addEventListener('change', function() {
        //     console.log('masukkdasjf')
        // })
        outlet.addEventListener('change', function() {
            if (outlet.value == "3") {
                $("#outletName").removeClass('d-none')
            } else {
                $("#outletName").addClass('d-none')
            }
        })
        let table = new DataTable('#table');
    </script>
@endsection
@section('content')
    @if (Auth::user()->role_id != 1)
        <div class="alert alert-danger mt-5">Anda Tidak Memiliki Akses ke Halaman ini</div>
    @else
        <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
            <!--begin::Modal-->
            <div class="modal fade" id="subheader7Modal" data-backdrop="static" tabindex="-1" role="dialog"
                aria-labelledby="staticBackdrop" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Select Location</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <i aria-hidden="true" class="ki ki-close"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div id="kt_subheader_leaflet" style="height:450px; width: 100%;"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light-primary font-weight-bold"
                                data-dismiss="modal">Cancel</button>
                            <button id="submit" type="button" class="btn btn-primary font-weight-bold"
                                data-dismiss="modal">Apply</button>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Modal-->

            <!--begin::Entry-->
            <div class="d-flex flex-column-fluid">
                <!--begin::Container-->
                <div class="container">
                    <!--begin::Profile Overview-->
                    <div class="d-flex flex-row">

                        <!--begin::Content-->
                        <div class="flex-row-fluid">
                            <!--end::Row-->
                            <!--begin::Advance Table: Widget 7-->
                            <div class="card card-custom gutter-b">
                                <!--begin::Header-->
                                <div class="card-header border-0 pt-5">
                                    <h3 class="card-title align-items-start flex-column">
                                        <span class="card-label font-weight-bolder text-dark">Daftar Users</span>
                                        <span class="text-muted mt-3 font-weight-bold font-size-sm">Total Data :
                                            {{ $row['users']->count() }}</span>
                                    </h3>
                                    <div class="card-toolbar">
                                        <ul class="nav nav-pills nav-pills-sm nav-dark-75">
                                            <li class="nav-item">
                                                <!-- Button trigger modal-->
                                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                                    data-target="#addModal">
                                                    Tambah Data
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <!--end::Header-->
                                <!--begin::Body-->
                                <div class="card-body pt-2 pb-0 mt-n3">
                                    <div class="tab-content mt-5" id="myTabTables12">

                                        <!--begin::Tap pane-->
                                        <div class="tab-pane fade show active" id="kt_tab_pane_12_3" role="tabpanel"
                                            aria-labelledby="kt_tab_pane_12_3">
                                            <!--begin::Table-->
                                            <div class="table-responsive" id="table">
                                                <table class="table table-separate table-head-custom table-checkable">
                                                    <thead>
                                                        <tr>
                                                            <th class="p-0 min-w-200px">Nama</th>
                                                            <th class="p-0 min-w-200px">Email</th>
                                                            <th class="p-0 min-w-120px">Role</th>
                                                            <th class="p-0 min-w-120px">Outlet</th>
                                                            <th class="p-0 min-w-120px">Status</th>
                                                            <th class="p-0 min-w-120px">Tanggal</th>
                                                            <th class="p-0 min-w-120px text-center">Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($row['users'] as $key => $value)
                                                            <tr>
                                                                <td class="">
                                                                    <span
                                                                        class="font-weight-bold">{{ $value->name }}</span>
                                                                </td>
                                                                <td class="">
                                                                    <span
                                                                        class="font-weight-bold">{{ $value->email }}</span>
                                                                </td>
                                                                <td class="">
                                                                    <span
                                                                        class="font-weight-bold">{{ $value->role_name }}</span>
                                                                </td>
                                                                <td class="">
                                                                    <span
                                                                        class="font-weight-bold">{{ $value->outlet_name }}</span>
                                                                </td>
                                                                <td class="">
                                                                    @if ($value->is_active == 1)
                                                                        <span
                                                                            class="label label-lg label-light-primary label-inline">Aktif</span>
                                                                    @elseif($value->deleted_at != null)
                                                                        <span
                                                                            class="label label-lg label-light-danger label-inline">Tidak
                                                                            aktif</span>
                                                                    @else
                                                                        <span
                                                                            class="label label-lg label-light-danger label-inline">Tidak
                                                                            aktif</span>
                                                                    @endif
                                                                </td>
                                                                <td class="">
                                                                    <span
                                                                        class="font-weight-bold">{{ date('d-M-Y H:i:s', strtotime($value->created_at)) }}</span>
                                                                </td>
                                                                <td class="text-center">
                                                                    <button data-toggle="modal"
                                                                        data-target="#editModal{{ $value->id }}"
                                                                        class="btn btn-icon btn-light btn-hover-primary btn-sm mx-3">
                                                                        <span class="svg-icon svg-icon-md svg-icon-primary">
                                                                            <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Write.svg-->
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                                width="24px" height="24px"
                                                                                viewBox="0 0 24 24" version="1.1">
                                                                                <g stroke="none" stroke-width="1"
                                                                                    fill="none" fill-rule="evenodd">
                                                                                    <rect x="0" y="0"
                                                                                        width="24" height="24">
                                                                                    </rect>
                                                                                    <path
                                                                                        d="M12.2674799,18.2323597 L12.0084872,5.45852451 C12.0004303,5.06114792 12.1504154,4.6768183 12.4255037,4.38993949 L15.0030167,1.70195304 L17.5910752,4.40093695 C17.8599071,4.6812911 18.0095067,5.05499603 18.0083938,5.44341307 L17.9718262,18.2062508 C17.9694575,19.0329966 17.2985816,19.701953 16.4718324,19.701953 L13.7671717,19.701953 C12.9505952,19.701953 12.2840328,19.0487684 12.2674799,18.2323597 Z"
                                                                                        fill="#000000" fill-rule="nonzero"
                                                                                        transform="translate(14.701953, 10.701953) rotate(-135.000000) translate(-14.701953, -10.701953)">
                                                                                    </path>
                                                                                    <path
                                                                                        d="M12.9,2 C13.4522847,2 13.9,2.44771525 13.9,3 C13.9,3.55228475 13.4522847,4 12.9,4 L6,4 C4.8954305,4 4,4.8954305 4,6 L4,18 C4,19.1045695 4.8954305,20 6,20 L18,20 C19.1045695,20 20,19.1045695 20,18 L20,13 C20,12.4477153 20.4477153,12 21,12 C21.5522847,12 22,12.4477153 22,13 L22,18 C22,20.209139 20.209139,22 18,22 L6,22 C3.790861,22 2,20.209139 2,18 L2,6 C2,3.790861 3.790861,2 6,2 L12.9,2 Z"
                                                                                        fill="#000000" fill-rule="nonzero"
                                                                                        opacity="0.3"></path>
                                                                                </g>
                                                                            </svg>
                                                                            <!--end::Svg Icon-->
                                                                        </span>
                                                                    </button>


                                                                    <a href="{{ route('deleteUser', $value->id) }}"
                                                                        class="btn btn-icon btn-light btn-hover-primary btn-sm">
                                                                        <span
                                                                            class="svg-icon svg-icon-md svg-icon-primary">
                                                                            <!--begin::Svg Icon | path:assets/media/svg/icons/General/Trash.svg-->
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                                width="24px" height="24px"
                                                                                viewBox="0 0 24 24" version="1.1">
                                                                                <g stroke="none" stroke-width="1"
                                                                                    fill="none" fill-rule="evenodd">
                                                                                    <rect x="0" y="0"
                                                                                        width="24" height="24">
                                                                                    </rect>
                                                                                    <path
                                                                                        d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z"
                                                                                        fill="#000000"
                                                                                        fill-rule="nonzero">
                                                                                    </path>
                                                                                    <path
                                                                                        d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z"
                                                                                        fill="#000000" opacity="0.3">
                                                                                    </path>
                                                                                </g>
                                                                            </svg>
                                                                            <!--end::Svg Icon-->
                                                                        </span>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            {{-- /Modal Edit --}}

                                                            <div class="modal fade" id="editModal{{ $value->id }}"
                                                                tabindex="-1" role="dialog"
                                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title"
                                                                                id="exampleModalLabel">
                                                                                Edit Kategori</h5>
                                                                            <button type="button" class="close"
                                                                                data-dismiss="modal" aria-label="Close">
                                                                                <i aria-hidden="true"
                                                                                    class="ki ki-close"></i>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <div class="card card-custom">
                                                                                <!--begin::Form-->
                                                                                <form action="{{ route('updateUsers') }}"
                                                                                    method="POST">
                                                                                    @csrf
                                                                                    <input type="hidden" name="id"
                                                                                        value="{{ $value->id }}">
                                                                                    <div class="card-body">
                                                                                        <div class="form-group mb-2">
                                                                                            <div class="form-group">
                                                                                                <label>Nama Pengguna<span
                                                                                                        class="text-danger">*</span></label>
                                                                                                <input type="text"
                                                                                                    class="form-control"
                                                                                                    name="name"
                                                                                                    placeholder="Enter Name"
                                                                                                    required
                                                                                                    value="{{ $value->name }}" />
                                                                                                {{-- <span class="form-text text-muted">Nama Pengguna</span> --}}
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="form-group mb-2">
                                                                                            <div class="form-group">
                                                                                                <label>username<span
                                                                                                        class="text-danger">*</span></label>
                                                                                                <input class="form-control"
                                                                                                    name="email"
                                                                                                    placeholder="Enter Email"
                                                                                                    required
                                                                                                    value="{{ $value->email }}" />
                                                                                                {{-- <span class="form-text text-muted">Email Pengguna</span> --}}
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="form-group mb-2">
                                                                                            <div class="form-group">
                                                                                                <label>New Password<span
                                                                                                        class="text-danger">*</span></label>
                                                                                                <input type="password"
                                                                                                    class="form-control"
                                                                                                    name="password"
                                                                                                    placeholder="Enter Password"
                                                                                                    required />
                                                                                                {{-- <span class="form-text text-muted">Email Pengguna</span> --}}
                                                                                            </div>
                                                                                        </div>
                                                                                        <!--end::Form-->
                                                                                    </div>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button"
                                                                                    class="btn btn-light-primary font-weight-bold"
                                                                                    data-dismiss="modal">Close</button>
                                                                                <button type="submit"
                                                                                    class="btn btn-primary font-weight-bold">Save
                                                                                    changes</button>

                                                                            </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                {{-- End Modal Edit --}}
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!--end::Table-->
                                        </div>
                                        <!--end::Tap pane-->
                                    </div>
                                </div>
                                <!--end::Body-->
                            </div>
                            <!--end::Advance Table Widget 7-->
                        </div>
                        <!--end::Content-->
                    </div>
                    <!--end::Profile Overview-->
                </div>
                <!--end::Container-->
            </div>
            <!--end::Entry-->
        </div>


        {{-- Modal --}}
        <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah Data Users</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="card card-custom">
                            <!--begin::Form-->
                            <form action="{{ route('postUser') }}" method="POST">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group mb-2">
                                        <div class="form-group">
                                            <label>Nama Pengguna<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="name"
                                                placeholder="Enter Name" required />
                                            {{-- <span class="form-text text-muted">Nama Pengguna</span> --}}
                                        </div>
                                    </div>
                                    <div class="form-group mb-2">
                                        <div class="form-group">
                                            <label>Username<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="email"
                                                placeholder="Enter username" required />
                                            {{-- <span class="form-text text-muted">Email Pengguna</span> --}}
                                        </div>
                                    </div>
                                    <div class="form-group mb-2">
                                        <div class="form-group">
                                            <label>Password<span class="text-danger">*</span></label>
                                            <input type="password" class="form-control" name="password"
                                                placeholder="Enter Password" required />
                                            {{-- <span class="form-text text-muted">Email Pengguna</span> --}}
                                        </div>
                                    </div>
                                    <div class="form-group mb-2">
                                        <select class="form-select form-select-sm custom-select" name="role_id"
                                            id="roleName" required>
                                            <option selected>Pilih Role</option>
                                            @foreach ($row['roles'] as $k => $v)
                                                <option value="{{ $v->id }}">{{ $v->role_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group mb-2 d-none" id="outletName">
                                        <select class="form-select form-select-sm custom-select" name="outlet_id">
                                            <option value="false" selected>Pilih Outlet</option>
                                            @foreach ($row['outlets'] as $k => $v)
                                                <option value="{{ $v->id }}">{{ $v->outlet_name }}</option>
                                            @endforeach
                                        </select>
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
    @endif
@endsection

@section('menu-detail')
    Menu Mengelola Akun User
@endsection
