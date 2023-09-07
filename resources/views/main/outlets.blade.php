@extends('master')
@section('menu-detail')
    Menu Mengelola dan Menambahkan Outlet
@endsection
@section('header-name')
    Outlet
@endsection
@section('script')
    <script src="https://cdn.jsdelivr.net/npm/jsprintmanager@5.0.3/JSPrintManager.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bluebird/3.3.5/bluebird.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script>
        var clientPrinters = null;
        var _this = this;

        //WebSocket settings
        JSPM.JSPrintManager.auto_reconnect = true;
        JSPM.JSPrintManager.start();
        JSPM.JSPrintManager.WS.onStatusChanged = function() {
            if (jspmWSStatus()) {
                //get client installed printers
                JSPM.JSPrintManager.getPrintersInfo().then(function(printersList) {
                    clientPrinters = printersList;
                    var options = '';
                    for (var i = 0; i < clientPrinters.length; i++) {
                        options += '<option>' + clientPrinters[i].name + '</option>';
                    }
                    $('#lstPrinters').html(options);
                    $('.lstPrintersE').html(options);
                    _this.showSelectedPrinterInfo();
                });
            }
        };

        //Check JSPM WebSocket status
        function jspmWSStatus() {
            if (JSPM.JSPrintManager.websocket_status == JSPM.WSStatus.Open)
                return true;
            else if (JSPM.JSPrintManager.websocket_status == JSPM.WSStatus.Closed) {
                alert(
                    'JSPrintManager (JSPM) is not installed or not running! Download JSPM Client App from https://neodynamic.com/downloads/jspm'
                );
                return false;
            } else if (JSPM.JSPrintManager.websocket_status == JSPM.WSStatus.Blocked) {
                alert('JSPM has blocked this website!');
                return false;
            }
        }

        //Do printing...
        function print() {
            if (jspmWSStatus()) {
                console.log($('#lstPrinters').val());

                //Create a ClientPrintJob
                var cpj = new JSPM.ClientPrintJob();

                //Set Printer info
                var myPrinter = new JSPM.InstalledPrinter($('#lstPrinters').val());
                myPrinter.paperName = $('#lstPrinterPapers').val();
                myPrinter.trayName = $('#lstPrinterTrays').val();
                console.log('paper name :' + $('#lstPrinterPapers').val());
                console.log('Tray name :' + $('#lstPrinterTrays').val());

                cpj.clientPrinter = myPrinter;

                //Set PDF file
                var my_file = new JSPM.PrintFilePDF($('#txtPdfFile').val(), JSPM.FileSourceType.URL, 'MyFile.pdf', 1);
                my_file.printRotation = JSPM.PrintRotation[$('#lstPrintRotation').val()];
                my_file.printRange = $('#txtPagesRange').val();
                my_file.printAnnotations = $('#chkPrintAnnotations').prop('checked');
                my_file.printAsGrayscale = $('#chkPrintAsGrayscale').prop('checked');
                my_file.printInReverseOrder = $('#chkPrintInReverseOrder').prop('checked');

                cpj.files.push(my_file);

                //Send print job to printer!
                cpj.sendToClient();

            }
        }

        //Do printing...
        function printOwn() {
            if (jspmWSStatus()) {
                console.log('printinggg')
                var printerName = "OneNote (Desktop)";
                var paperName = "Letter";
                var trayName = null;

                //Create a ClientPrintJob
                var cpj = new JSPM.ClientPrintJob();

                //Set Printer info
                var myPrinter = new JSPM.InstalledPrinter(printerName);
                myPrinter.paperName = paperName;
                myPrinter.trayName = trayName;

                cpj.clientPrinter = myPrinter;

                //Set PDF file
                var my_file = new JSPM.PrintFilePDF($('#txtPdfFile').val(), JSPM.FileSourceType.URL, 'MyFile.pdf', 1);
                my_file.printRotation = JSPM.PrintRotation[$('#lstPrintRotation').val()];
                my_file.printRange = $('#txtPagesRange').val();
                my_file.printAnnotations = $('#chkPrintAnnotations').prop('checked');
                my_file.printAsGrayscale = $('#chkPrintAsGrayscale').prop('checked');
                my_file.printInReverseOrder = $('#chkPrintInReverseOrder').prop('checked');

                cpj.files.push(my_file);

                //Send print job to printer!
                cpj.sendToClient();

            }
        }

        function showSelectedPrinterInfo() {
            // get selected printer index
            var idx = $("#lstPrinters")[0].selectedIndex || $(".lstPrintersE")[0].selectedIndex;
            // get supported trays
            var options = '';
            for (var i = 0; i < clientPrinters[idx].trays.length; i++) {
                options += '<option>' + clientPrinters[idx].trays[i] + '</option>';
            }
            $('#lstPrinterTrays').html(options);
            $('#lstPrinterTraysE').html(options);
            // get supported papers
            options = '';
            for (var i = 0; i < clientPrinters[idx].papers.length; i++) {
                options += '<option>' + clientPrinters[idx].papers[i] + '</option>';
            }
            $('#lstPrinterPapers').html(options);
            $('.lstPrinterPapersE').html(options);
        }

        setInterval(() => {
            // print()
        }, 2000);
    </script>
@endsection
@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">

        <!--begin::Entry-->
        <div class="d-flex flex-column-fluid">
            <!--begin::Container-->
            <div class="container">
                @include('partials.masterdata.menu-2')
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
                                    <span class="card-label font-weight-bolder text-dark">Outlets</span>
                                    <span class="text-muted mt-3 font-weight-bold font-size-sm">Total Data :
                                        {{ $row['datas']->count() }}</span>
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
                                        <div class="table-responsive">
                                            <table class="table table-separate table-head-custom table-checkable">
                                                <thead>
                                                    <tr>
                                                        <th class="p-0 min-w-200px">Nama Outlet</th>
                                                        <th class="p-0 min-w-200px">Printer</th>
                                                        <th class="p-0 min-w-200px">Paper</th>
                                                        <th class="p-0 min-w-120px">Ditambahkan oleh</th>
                                                        <th class="p-0 min-w-120px">Status</th>
                                                        <th class="p-0 min-w-120px">Tanggal</th>
                                                        <th class="p-0 min-w-120px text-center">Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($row['datas'] as $key => $value)
                                                        <tr>
                                                            <td class="">
                                                                <span
                                                                    class="font-weight-bold">{{ $value->outlet_name }}</span>
                                                            </td>
                                                            <td class="">
                                                                <span class="font-weight-bold">{{ $value->printer }}</span>
                                                            </td>
                                                            <td class="">
                                                                <span class="font-weight-bold">{{ $value->paper }}</span>
                                                            </td>
                                                            <td class="">
                                                                <span class="font-weight-bold">{{ $value->name }}</span>
                                                            </td>
                                                            <td class="">
                                                                @if ($value->is_active == 1)
                                                                    <span
                                                                        class="label label-lg label-light-primary label-inline">Aktif</span>
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
                                                                    class="btn btn-icon btn-light btn-hover-warning btn-sm mx-3">
                                                                    <span class="svg-icon svg-icon-md svg-icon-warning">
                                                                        <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Write.svg-->
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                            xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                            width="24px" height="24px"
                                                                            viewBox="0 0 24 24" version="1.1">
                                                                            <g stroke="none" stroke-width="1"
                                                                                fill="none" fill-rule="evenodd">
                                                                                <rect x="0" y="0"
                                                                                    width="24" height="24"></rect>
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


                                                                <a href="{{ route('deleteOutlet', $value->id) }}"
                                                                    class="btn btn-icon btn-light btn-hover-danger btn-sm">
                                                                    <span class="svg-icon svg-icon-md svg-icon-danger">
                                                                        <!--begin::Svg Icon | path:assets/media/svg/icons/General/Trash.svg-->
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                            xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                            width="24px" height="24px"
                                                                            viewBox="0 0 24 24" version="1.1">
                                                                            <g stroke="none" stroke-width="1"
                                                                                fill="none" fill-rule="evenodd">
                                                                                <rect x="0" y="0"
                                                                                    width="24" height="24"></rect>
                                                                                <path
                                                                                    d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z"
                                                                                    fill="#000000" fill-rule="nonzero">
                                                                                </path>
                                                                                <path
                                                                                    d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z"
                                                                                    fill="#000000" opacity="0.3"></path>
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
                                                            <div class="modal-dialog modal-dialog-centered"
                                                                role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalLabel">
                                                                            Edit Outlet</h5>
                                                                        <button type="button" class="close"
                                                                            data-dismiss="modal" aria-label="Close">
                                                                            <i aria-hidden="true" class="ki ki-close"></i>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="card card-custom">
                                                                            <!--begin::Form-->
                                                                            <form action="{{ route('updateOutlet') }}"
                                                                                method="POST">
                                                                                @csrf
                                                                                <input type="hidden" name="id"
                                                                                    value="{{ $value->id }}">
                                                                                <div class="card-body">
                                                                                    <div class="form-group mb-8">
                                                                                        <div class="form-group">
                                                                                            <label>Nama Outlet<span
                                                                                                    class="text-danger">*</span></label>
                                                                                            <input type="text"
                                                                                                class="form-control"
                                                                                                name="outlet_name"
                                                                                                value="{{ $value->outlet_name }}"
                                                                                                placeholder="Enter Kategori Name"
                                                                                                required />
                                                                                            <span
                                                                                                class="form-text text-muted">Nama
                                                                                                Outlet, contoh : "Makanan",
                                                                                                "Minuman", "Desert"</span>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="form-group mb-8">
                                                                                        <label>Printers<span
                                                                                                class="text-danger">*</span></label>
                                                                                        <select
                                                                                            class="form-control lstPrintersE"
                                                                                            name="lstPrinters"
                                                                                            id="lstPrintersE"
                                                                                            onchange="showSelectedPrinterInfo();">
                                                                                        </select>
                                                                                    </div>
                                                                                    <div class="form-group mb-8">
                                                                                        <label>Paper<span
                                                                                                class="text-danger">*</span></label>
                                                                                        <select
                                                                                            class="form-control lstPrinterPapersE"
                                                                                            name="lstPrinterPapers"
                                                                                            id="lstPrinterPapersE">
                                                                                        </select>
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
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Data Outlet</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card card-custom">
                        <!--begin::Form-->
                        <form action="{{ route('postOutlet') }}" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="form-group mb-8">
                                    <div class="form-group">
                                        <label>Nama Outlets<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="outlet_name"
                                            placeholder="Enter Outlet Name" required />
                                        <span class="form-text text-muted">Nama Outlet, contoh : "Warung Bakmi",
                                            "Warung Bang Asep"</span>
                                    </div>
                                </div>
                                <div class="form-group mb-8">
                                    <label>Printers<span class="text-danger">*</span></label>
                                    <select class="form-control" name="lstPrinters" id="lstPrinters"
                                        onchange="showSelectedPrinterInfo();">
                                    </select>
                                </div>
                                <div class="form-group mb-8">
                                    <label>Paper<span class="text-danger">*</span></label>
                                    <select class="form-control" name="lstPrinterPapers" id="lstPrinterPapers">
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
    @endsection
