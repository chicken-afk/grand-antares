"use strict";
// Class definition
var app_url = "127.0.0.1:8000";

function deleteProduct(id) {
    console.log(id);
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: `/delete-invoice-product/` + id,
        type: "GET",
        success: function (response) {

            console.log(response)

            //DIsplay None
            $(`#product${id}`).addClass("d-none");
            document.getElementById(`payment_charge${response.invoice_number}`).innerHTML = `${response.payment_charge}`;

            return true;
            // window.location = "/products"
        },
        error: function (response) {
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: 'Something went wrong, please contact developer',
            })
        }
    });


}

function deleteInvoice(id) {
    var response = JSON.parse(localStorage.getItem("response") || "[]");
    var j = 0;
    var newCarts = [];
    var name = [];
    var payment_charge = 0;
    console.log(response);
    for (var i = 0; i < response.invoices.length; i++) {
        if (i != id) {
            console.log('array carts ', i, ' ', response.invoices[i]);
            payment_charge += parseInt(response.invoices[i].payment_charge);
            name[i] = response.invoices[i].name;
            newCarts[j] = response.invoices[i];
            j++;
        }
        else {
        }
    }
    response = {
        "data": {
            "name": name,
            "no_table": response.data.no_table,
            "payment_charge": payment_charge,
        },
        "invoices": newCarts
    }
    console.log(response);
    localStorage.removeItem("response");
    localStorage.setItem("response", JSON.stringify(response));
    var html = generateContentMeja(response);
    document.getElementById('modalContentMeja').innerHTML = html;
    paymentChargeMeja();
}


function searchInvoice() {
    var tableNo = document.getElementById('nomor_meja').value;
    if (tableNo == "") {
        Swal.fire({
            icon: 'error',
            title: 'Gagal',
            text: 'Nomor Meja Belum Di isi',
        })
        return false
    }
    generateModalMeja(tableNo)
}

function generateModalMeja(tableNo) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: `/invoices?no_table=` + tableNo,
        type: "GET",
        success: function (response) {
            localStorage.removeItem("response");
            localStorage.setItem("response", JSON.stringify(response));
            if (response.invoices.length == 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Tidak ada invoice belum dibayar pada nomor meja ' + tableNo,
                })
                return false
            }

            var html = generateContentMeja(response);
            document.getElementById('modalContentMeja').innerHTML = html;
            paymentChargeMeja();
            $('#modalMeja').modal('show');


            return true;
            // window.location = "/products"
        },
        error: function (response) {
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: 'Something went wrong, please contact developer',
            })
        }
    });
}


/**
 * Function Payment Charge
 */

function generateModalContent(data) {
    console.log(data);
    var modalHtml = "";
    var pesananHtml = "";
    var paymentHtml = `<h3 style="color:red;font-weight:700"> Sudah Dibayar <h3/>`;
    if (data.invoice.payment_status == 0) {
        paymentHtml = `
        <div class="mb-5" style="display: grid;grid-template-columns: 1fr 1fr 1fr 1fr; grid-gap: 20px;">
        <div class="input-group input-group-lg">
            <select name="payment_method" class="form-select form-control"
                aria-label="Default select example" id="paymentMethod">
                <option value="CASH" selected>Pilih Payment Method</option>
                <option value="CASH">CASH</option>
                <option value="QRIS">QRIS</option>
                <option value="OVO">OVO</option>
                <option value="KARTU DEBIT">KARTU DEBIT</option>
            </select>
        </div>
        <input type="hidden" id="paymentCharge" value="${data.invoice.payment_charge}">
        <input type="hidden" name="invoice" id="invoiceNumber"
            value="${data.invoice.invoice_number}">
        <div class="input-group input-group-lg">
            <span class="input-group-text" id="inputGroup-sizing-lg">Uang</span>
            <input type="number" class="form-control" aria-label="Sizing example input"
                aria-describedby="inputGroup-sizing-lg" name="payment_money" id="paymentMoney">
        </div>
        <div class="input-group input-group-lg">
            <span class="input-group-text" id="inputGroup-sizing-lg">Kembalian</span>
            <input disabled type="number" class="form-control" aria-label="Sizing example input"
                aria-describedby="inputGroup-sizing-lg" name="payment_change" id="paymentChange">
        </div>
        <button onclick="submitForm()" class="btn btn-success font-weight-bolder">
            <span class="svg-icon svg-icon-md">
                <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Flatten.svg-->
                <!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\legacy\metronic\theme\html\demo4\dist/../src/media/svg/icons\Shopping\Money.svg-->
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                    width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <rect x="0" y="0" width="24" height="24" />
                        <path
                            d="M2,6 L21,6 C21.5522847,6 22,6.44771525 22,7 L22,17 C22,17.5522847 21.5522847,18 21,18 L2,18 C1.44771525,18 1,17.5522847 1,17 L1,7 C1,6.44771525 1.44771525,6 2,6 Z M11.5,16 C13.709139,16 15.5,14.209139 15.5,12 C15.5,9.790861 13.709139,8 11.5,8 C9.290861,8 7.5,9.790861 7.5,12 C7.5,14.209139 9.290861,16 11.5,16 Z"
                            fill="#000000" opacity="0.3"
                            transform="translate(11.500000, 12.000000) rotate(-345.000000) translate(-11.500000, -12.000000) " />
                        <path
                            d="M2,6 L21,6 C21.5522847,6 22,6.44771525 22,7 L22,17 C22,17.5522847 21.5522847,18 21,18 L2,18 C1.44771525,18 1,17.5522847 1,17 L1,7 C1,6.44771525 1.44771525,6 2,6 Z M11.5,16 C13.709139,16 15.5,14.209139 15.5,12 C15.5,9.790861 13.709139,8 11.5,8 C9.290861,8 7.5,9.790861 7.5,12 C7.5,14.209139 9.290861,16 11.5,16 Z M11.5,14 C12.6045695,14 13.5,13.1045695 13.5,12 C13.5,10.8954305 12.6045695,10 11.5,10 C10.3954305,10 9.5,10.8954305 9.5,12 C9.5,13.1045695 10.3954305,14 11.5,14 Z"
                            fill="#000000" />
                    </g>
                </svg>
                <!--end::Svg Icon-->
            </span>Submit
        </button>
    </div>
        `;
    }
    for (var k = 0; k < data.products.length; k++) {
        var closeButton = '';
        if (data.invoice.payment_status == 0) {
            closeButton = ` <div class="card-toolbar ms-auto text-danger mb-1 text-right">
            <a onclick="deleteProduct(${data.products[k].id})" type="button" class="btn btn-sm btn-outline-danger"> X </a>
         </div>`;
        };
        pesananHtml += `
        <div class="card card-custom gutter-b card-stretch m-2" id="product${data.products[k].id}">
															<div class="card-body d-flex flex-column rounded justify-content-between">
                                                                    ${closeButton}
																<div class="text-center rounded mb-7">
																	<img src="${data.products[k].product_image}" class="mw-100 w-200px">
																</div>
																<div>
																	<h4 class="font-size-h5">
																		<a href="#" class="text-dark-75 font-weight-bolder">${data.products[k].active_product_name}</a>
																	</h4>
                                                                    <div class="font-size-h7 text-muted font-weight-bolder">Varian : ${data.products[k].varian_name}</div>
                                                                    <div class="font-size-h7 text-muted font-weight-bolder">Topping : ${data.products[k].topping_text}</div>
																	<div class="font-size-h6 text-muted font-weight-bolder">Rp. ${number_format(data.products[k].price * data.products[k].qty)},-</div>
                                                                    <div class="font-size-h6 text-muted font-weight-bolder">${data.products[k].qty} Pcs</div>
																</div>
															</div>
														</div>
        `;
    }
    modalHtml = `
    <div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Detail Invoice</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
        onclick="closeModalDetail()"></button>
</div>
<div class="modal-body" id="modalContent">
    <div style="display: grid;grid-template-columns: 1fr 0.1fr 1fr; grid-gap: 20px;">
        <h5 class="mb-0" style="width: 30rem">Invoice</h5>
        <h5 class="mb-0" style="width: 0.5rem">:</h5>
        <h5 class="mb-0">${data.invoice.invoice_number}</h5>
    </div>
    <div style="display: grid;grid-template-columns: 1fr 0.1fr 1fr; grid-gap: 20px;">
        <h5 class="mb-0" style="width: 30rem">Nama</h5>
        <h5 class="mb-0" style="width: 0.5rem">:</h5>
        <h5 class="mb-0">${data.invoice.name}</h5>
    </div>
    <div style="display: grid;grid-template-columns: 1fr 0.1fr 1fr; grid-gap: 20px;">
        <h5 class="mb-0" style="width: 30rem">Metode Pembayaran</h5>
        <h5 class="mb-0" style="width: 0.5rem">:</h5>
        <h5 class="mb-0">${data.invoice.payment_method}</h5>
    </div>
    <div style="display: grid;grid-template-columns: 1fr 0.1fr 1fr; grid-gap: 20px;">
        <h5 class="mb-1" style="width: 30rem">Nomor Kamar</h5>
        <h5 class="mb-1" style="width: 0.5rem">:</h5>
        <h5 class="mb-1"> ${data.invoice.nomor_kamar ?? 'Restaurant'}</h5>
    </div>
    <div style="display: grid;grid-template-columns: 1fr 0.1fr 1fr; grid-gap: 20px;">
        <h5 class="mb-1" style="width: 30rem">Harga Total</h5>
        <h5 class="mb-1" style="width: 0.5rem">:</h5>
        <h5 class="mb-1" style="font-weight: 900;font-size:2.4rem" id="payment_charge${data.invoice.invoice_number}"> Rp.
            ${number_format(data.invoice.payment_charge)},-</h5>
    </div>
    <h5 class="mb-1" style="width: 30rem">Bayar</h5>
        ${paymentHtml}
    <h5 class="mb-3">Pesanan :</h5>
    <div class="line-1"></div>
    <div class="row">
       ${pesananHtml}
    </div>
</div>
    `;

    document.getElementById('modalContent').innerHTML = modalHtml;
}

function closeModalDetail() {
    document.getElementById('modalContent').innerHTML = `
    `;

    $("#modalDetail").modal('hide');
}

function openModalDetail(invoice) {
    var html = `<p>Check Data</p>`;
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: `/orders?invoice=` + invoice,
        type: "GET",
        success: function (response) {

            console.log(response)
            if (response.status_code == 422) {
                Swal.fire({
                    icon: 'Error',
                    title: 'Gagal',
                    text: 'Data Tidak Ditemukan',
                })
                return false;
            }
            console.log(response.data);

            generateModalContent(response.data);
            if (response.data.invoice.payment_status == 0) {
                paymentCharge();
            }
            $("#modalDetail").modal('show');
            return true;
            // window.location = "/products"
        },
        error: function (response) {
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: 'Something went wrong, please contact developer',
            })
        }
    });
}

function number_format(number, decimals, dec_point, thousands_sep) {
    // Strip all characters but numerical ones.
    number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
    var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
        s = '',
        toFixedFix = function (n, prec) {
            var k = Math.pow(10, prec);
            return '' + Math.round(n * k) / k;
        };
    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');
    }
    return s.join(dec);
}
var KTEcommerceMyOrders = function () {
    // Private functions
    var demo = function () {
        var datatable = $('#kt_datatable').KTDatatable({
            // datasource definition
            data: {
                type: 'remote',
                source: {
                    read: {
                        method: 'GET',
                        url: '/order-datas',
                        // sample custom headers
                        // headers: {'x-my-custom-header': 'some value', 'x-test-header': 'the value'},
                        map: function (raw) {
                            // sample data mapping
                            console.log(raw)
                            var dataSet = raw;
                            if (typeof raw.data !== 'undefined') {
                                dataSet = raw.data;
                            }
                            return dataSet;
                        },
                    },
                },
                pageSize: 10,
                serverPaging: false,
                serverFiltering: true,
                serverSorting: true,
            },

            // layout definition
            layout: {
                scroll: true,
                footer: false,
                responsive: true, // Aktifkan fitur responsif
            },

            // column sorting
            sortable: true,

            pagination: true,

            search: {
                input: $('#kt_datatable_search_query'),
                key: 'generalSearch'
            },

            // dom: 'Bfrtip',
            // buttons: [
            //     'copyHtml5',
            //     'excelHtml5',
            //     'csvHtml5',
            //     'pdfHtml5'
            // ],

            // columns definition
            columns: [{
                field: 'invoice_number',
                title: 'Invoice',
                sortable: 'asc',
            },
            {
                field: 'type',
                title: 'Tipe',
                width: 70,
            },
            {
                field: 'payment_charge',
                title: 'Harga',
                template: function (row) {
                    return "Rp. " + number_format(row.payment_charge) + ",-"
                }
            },
            {
                field: 'payment_method',
                title: 'Metode Bayar',
            },
            {
                field: 'name',
                title: 'Nama',
                width: 50,
            },
            {
                field: 'keterangan',
                title: 'Keterangan',
                width: 50,
            },
            {
                field: 'nomor_kamar',
                title: 'Kamar',
                width: 50,
            },
            {
                field: 'order_at',
                title: 'Tanggal Pemesanan',
                type: 'date',
                format: 'H:i:s MM/DD/YYYY',
            },
            {
                field: 'order_status',
                title: 'Status Pesanan',
                template: function (row) {
                    let selSelesai = row.order_status == 'selesai' ? 'selected' : '';
                    let selditerima = row.order_status == 'diterima' ? 'selected' : '';
                    let seldiproses = row.order_status == 'diproses' ? 'selected' : '';
                    let seldicancel = row.order_status == 'dibatalkan' ? 'selected' : '';
                    return `
                    <div class="form-group mb-2">
                    <select onchange='changeStatus(${JSON.stringify(this)}, ${row.invoice_number})' class="form-select form-select-sm custom-select orderStatus" name="role_id"
                        id="${row.invoice_number}" required>
                        <option ${selditerima} value="diterima">diterima</option>
                        <option ${seldiproses} value="diproses">diproses</option>
                        <option ${selSelesai} value="selesai">selesai</option>
                        <option ${seldicancel} value="dibatalkan">dibatalkan</option>
                    </select>
                </div>
                    `
                },
            },
            {
                field: 'payment_status',
                title: 'Status Pembayaran',
                width: 80,
                // callback function support for column rendering
                template: function (row) {
                    var status = {
                        0: {
                            'title': 'Belum',
                            'class': ' label-light-danger'
                        },
                        1: {
                            'title': 'Sudah',
                            'class': ' label-light-success'
                        },
                    };
                    return '<span class="label font-weight-bold label-lg ' + status[row.payment_status].class + ' label-inline">' + status[row.payment_status].title + '</span>';
                },
            },
            // {
            //     field: 'payment_at',
            //     title: 'Tanggal Pembayaran',
            //     type: 'date',
            //     format: 'H:i:s MM/DD/YYYY',
            // },
            {
                field: 'Actions',
                title: 'Actions',
                sortable: false,
                autoHide: false,
                template: function (row) {
                    console.log(row);
                    if (row.payment_status == 0) {
                        return `\
                        <a onclick="openModalDetail('${row.invoice_number}')" href="#" class="btn btn-sm btn-success font-weight-bolder">
                        <span class="svg-icon svg-icon-md">
                            <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Flatten.svg-->
                            <!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\legacy\metronic\theme\html\demo4\dist/../src/media/svg/icons\Shopping\Money.svg-->
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24" />
                                    <path
                                        d="M2,6 L21,6 C21.5522847,6 22,6.44771525 22,7 L22,17 C22,17.5522847 21.5522847,18 21,18 L2,18 C1.44771525,18 1,17.5522847 1,17 L1,7 C1,6.44771525 1.44771525,6 2,6 Z M11.5,16 C13.709139,16 15.5,14.209139 15.5,12 C15.5,9.790861 13.709139,8 11.5,8 C9.290861,8 7.5,9.790861 7.5,12 C7.5,14.209139 9.290861,16 11.5,16 Z"
                                        fill="#000000" opacity="0.3"
                                        transform="translate(11.500000, 12.000000) rotate(-345.000000) translate(-11.500000, -12.000000) " />
                                    <path
                                        d="M2,6 L21,6 C21.5522847,6 22,6.44771525 22,7 L22,17 C22,17.5522847 21.5522847,18 21,18 L2,18 C1.44771525,18 1,17.5522847 1,17 L1,7 C1,6.44771525 1.44771525,6 2,6 Z M11.5,16 C13.709139,16 15.5,14.209139 15.5,12 C15.5,9.790861 13.709139,8 11.5,8 C9.290861,8 7.5,9.790861 7.5,12 C7.5,14.209139 9.290861,16 11.5,16 Z M11.5,14 C12.6045695,14 13.5,13.1045695 13.5,12 C13.5,10.8954305 12.6045695,10 11.5,10 C10.3954305,10 9.5,10.8954305 9.5,12 C9.5,13.1045695 10.3954305,14 11.5,14 Z"
                                        fill="#000000" />
                                </g>
                            </svg>
                            <!--end::Svg Icon-->
                        </span>Bayar</a>
                        `;
                    }
                    else {
                        return `
                        <a href="#" class="btn btn-sm btn-warning mb-2 font-weight-bolder" onclick="openModalDetail('${row.invoice_number}')">
                        <span class="svg-icon svg-icon-md">
                            <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Flatten.svg-->
                            <!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\legacy\metronic\theme\html\demo4\dist/../src/media/svg/icons\Shopping\Money.svg-->
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24"/>
                                    <path d="M5,2 L19,2 C20.1045695,2 21,2.8954305 21,4 L21,6 C21,7.1045695 20.1045695,8 19,8 L5,8 C3.8954305,8 3,7.1045695 3,6 L3,4 C3,2.8954305 3.8954305,2 5,2 Z M11,4 C10.4477153,4 10,4.44771525 10,5 C10,5.55228475 10.4477153,6 11,6 L16,6 C16.5522847,6 17,5.55228475 17,5 C17,4.44771525 16.5522847,4 16,4 L11,4 Z M7,6 C7.55228475,6 8,5.55228475 8,5 C8,4.44771525 7.55228475,4 7,4 C6.44771525,4 6,4.44771525 6,5 C6,5.55228475 6.44771525,6 7,6 Z" fill="#000000" opacity="0.3"/>
                                    <path d="M5,9 L19,9 C20.1045695,9 21,9.8954305 21,11 L21,13 C21,14.1045695 20.1045695,15 19,15 L5,15 C3.8954305,15 3,14.1045695 3,13 L3,11 C3,9.8954305 3.8954305,9 5,9 Z M11,11 C10.4477153,11 10,11.4477153 10,12 C10,12.5522847 10.4477153,13 11,13 L16,13 C16.5522847,13 17,12.5522847 17,12 C17,11.4477153 16.5522847,11 16,11 L11,11 Z M7,13 C7.55228475,13 8,12.5522847 8,12 C8,11.4477153 7.55228475,11 7,11 C6.44771525,11 6,11.4477153 6,12 C6,12.5522847 6.44771525,13 7,13 Z" fill="#000000"/>
                                    <path d="M5,16 L19,16 C20.1045695,16 21,16.8954305 21,18 L21,20 C21,21.1045695 20.1045695,22 19,22 L5,22 C3.8954305,22 3,21.1045695 3,20 L3,18 C3,16.8954305 3.8954305,16 5,16 Z M11,18 C10.4477153,18 10,18.4477153 10,19 C10,19.5522847 10.4477153,20 11,20 L16,20 C16.5522847,20 17,19.5522847 17,19 C17,18.4477153 16.5522847,18 16,18 L11,18 Z M7,20 C7.55228475,20 8,19.5522847 8,19 C8,18.4477153 7.55228475,18 7,18 C6.44771525,18 6,18.4477153 6,19 C6,19.5522847 6.44771525,20 7,20 Z" fill="#000000"/>
                                </g>
                            </svg>
                            <!--end::Svg Icon-->
                        </span>Detail</a>

                        `;
                    }
                },
            }],

        });

        $('#kt_datatable_search_status').on('change', function () {
            console.log($(this).val().toLowerCase());
            datatable.search($(this).val().toLowerCase(), 'payment_status');
        });

        $('#kt_datatable_search_type').on('change', function () {
            datatable.search($(this).val().toLowerCase(), 'Type');
        });

        $('#kt_datatable_search_status, #kt_datatable_search_type').selectpicker();
    };

    return {
        // public functions
        init: function () {
            demo();
        },
    };
}();

function paymentCharge() {
    var paymentMethod = document.getElementById('paymentMethod');
    var paymentMoney = document.getElementById('paymentMoney');
    var paymentChange = document.getElementById('paymentChange');
    var invoiceNumber = document.getElementById('invoiceNumber');
    var paymentCharge = document.getElementById('paymentCharge');
    $("#paymentMethod").change(function () {
        console.log('onchange jalan')
        if (paymentMethod.value != 'cash' && paymentMethod.value != 'payment_method') {
            paymentMoney.value = paymentCharge.value;
            paymentChange.value = 0;
        } else {
            payment_change();
        }
    });

    paymentMoney.addEventListener('input', function () {
        console.log('event listener')
        payment_change();
    });

}

function payment_change() {
    var paymentMethod = document.getElementById('paymentMethod');
    var paymentMoney = document.getElementById('paymentMoney');
    var paymentChange = document.getElementById('paymentChange');
    var invoiceNumber = document.getElementById('invoiceNumber');
    var paymentCharge = document.getElementById('paymentCharge');

    var change = paymentMoney.value - paymentCharge.value;
    paymentChange.value = change;
}

function paymentChargeMeja() {
    var paymentMethod = document.getElementById('paymentMethodMeja');
    var paymentMoney = document.getElementById('paymentMoneyMeja');
    console.log(paymentMoney);
    var paymentChange = document.getElementById('paymentChangeMeja');
    var paymentCharge = document.getElementById('paymentChargeMeja');
    $("#paymentMethodMeja").change(function () {
        console.log('onchange jalan')
        if (paymentMethod.value != 'cash' && paymentMethod.value != 'payment_method') {
            paymentMoney.value = paymentCharge.value;
            paymentChange.value = 0;
        } else {
            payment_change_meja();
        }
    });

    paymentMoney.addEventListener('input', function () {
        console.log('event listener')
        payment_change_meja();
    });

}

function payment_change_meja() {
    var paymentMoney = document.getElementById('paymentMoneyMeja');
    var paymentChange = document.getElementById('paymentChangeMeja');
    var paymentCharge = document.getElementById('paymentChargeMeja');

    var change = paymentMoney.value - paymentCharge.value;
    paymentChange.value = change;
}

function submitForm() {
    var data = {};
    var paymentMethod = document.getElementById('paymentMethod');
    var paymentMoney = document.getElementById('paymentMoney');
    var paymentChange = document.getElementById('paymentChange');
    var invoiceNumber = document.getElementById('invoiceNumber');
    var paymentCharge = document.getElementById('paymentCharge');
    console.log(paymentMoney.value);
    if (paymentMoney.value == '') {
        Swal.fire({
            icon: 'error',
            'title': "Validation Error",
            text: 'Uang Pembayaran Wajib di isi'
        });
        return false
    }

    if (paymentMoney.value < paymentCharge.value) {
        Swal.fire({
            icon: 'error',
            'title': "Validation Error",
            text: 'Uang Pembayaran Harus Lebih Besar atau sama dengan Total Harga'
        });
        return false
    }

    data = {
        "invoice": invoiceNumber.value,
        "payment_money": paymentMoney.value,
        "payment_change": paymentChange.value,
        "payment_method": paymentMethod.value
    }
    Swal.showLoading()
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: `/payment`,
        type: "POST",
        data: data,
        success: function (response) {
            if (response.status_code == 404) {
                Swal.fire({
                    icon: 'Error',
                    title: 'Gagal',
                    text: 'Invoice tidak Ditemukan',
                })
                return false;
            }

            invoiceNumber.value = '';
            paymentMoney.value = '';
            paymentChange.value = '';
            Swal.close()
            $("#modalDetail").modal('hide');
            Swal.fire({
                // confirmButtonText: 'Print Invoice',
                icon: 'success',
                title: 'Berhasil',
                text: 'Berhasil Melakukan Pembayaran'
            }).then((result) => {
                if (result.isConfirmed) {
                    print(printer, paper, response.invoice_link)
                }
            });
            console.log(KTEcommerceMyOrders.datatable)
            $('#kt_datatable').KTDatatable().reload();

            return true

            // window.location = "/products"
        },
        error: function (response) {
            console.log(response)
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: 'Something went wrong, please contact developer',
            })
        }
    });

}

jQuery(document).ready(function () {
    KTEcommerceMyOrders.init();

});

function refreshData() {
    $('#kt_datatable').KTDatatable().reload();
    console.log('refresh data done')
}


setInterval(refreshData, 60000);


function changeStatus(selected, invoiceNumber) {
    let invoice = invoiceNumber.id;
    let order_status = invoiceNumber.value;
    console.log(invoice, order_status);
    let data = {
        "invoice": invoice,
        "order_status": order_status
    }
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: `/change-status-order`,
        type: "POST",
        data: data,
        success: function (response) {
            console.log(response)
            if (response.status_code == 401) {
                $('#kt_datatable').KTDatatable().reload();
                Swal.fire(
                    'Gagal!',
                    'Hubungi superadmin untuk membatalkan pesanan!',
                    'error'
                );
                // alert('Gagal membatalkan pesanan, hubungi superadmin untuk membatalkan pesanan')
            }
        },
        error: function (response) {
            Swal.fire(
                'Gagal!',
                'Gagal Merubah Status Pesanan',
                'error'
            );
        }
    });

}

