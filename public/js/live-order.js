const dataContent = document.getElementById('exampleAccordion');
var contentHtml = ``;

function reloadData() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: `/live-order-data`,
        type: "GET",
        success: function (response) {
            var contentHtml = "";

            console.log(response);

            for (var i = 0; i < response.datas.length; i++) {
                var productHtml = "";
                var buttonHtml = "";
                var invoice = response.datas[i];

                if (invoice.status_pemesanan == 'diterima') {
                    buttonHtml = `
                    <button class="btn btn-primary btn-md" id="bProses{{ $key }}"
                    onclick="changeStatus('${invoice.invoice_number}', 'diproses', '${response.user_id}')">Proses</button>
                    `;
                } else {
                    buttonHtml = `
                    <button class="btn btn-warning btn-md"
                    onclick="changeStatus('${invoice.invoice_number}', 'selesai', '${response.user_id}' )"
                    id="bFinish{{ $key }}">Selesai</button>
                    `;
                }
                // Get Product On Invoice
                for (var j = 0; j < response.datas[i].products.length; j++) {
                    var products = response.datas[i].products[j];
                    productHtml += `
                    <div class="card border-success m-2"
                    style="background-color: rgb(235, 253, 229);border-radius:5px;width:10rem">
                    <div class="card-header p-1 mt-1"
                        style="background-color: rgb(141, 184, 236);">
                        ${products.outlet_name}
                    </div>
                    <div class="card-body p-1">
                        <div class="">
                            <div class="bd-highlight pr-2 product-name">
                                <h4 class="product-name">${products.active_product_name}</h4>
                                <h5 class="product-detail">Varian : ${products.varian_name} </h5>
                                <h5 class="product-detail">Topping : ${products.topping_text}
                                </h5>
                            </div>
                            <div class="ms-auto">
                                <h5 style="font-weight:600;font-size:small">Qty : ${products.qty}</h5>
                            </div>
                        </div>
                    </div>
                </div>
                    `;
                }

                contentHtml += `
                <div class="accordion"
                id="accordion${invoice.invoice_number}">
                <div class="accordion-item mb-2">
                    <h2 class="accordion-header" id="heading-${i}">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                            data-bs-target="#panelsStayOpen-${i}" aria-expanded="true"
                            aria-controls="panelsStayOpen-${i}">
                            ${invoice.order_at} - ${invoice.invoice_number}
                        </button>
                        <div class="invoice-detail p-3 d-flex">
                            <div>
                                <h3>Nama : ${invoice.name}</h3>
                                <h3>Nomor Meja : ${invoice.no_table}</h3>
                                <h3>Kode Pesanan : ${invoice.invoice_code}</h3>
                                <h3>Total Pesanan : ${invoice.products.length}</h3>
                                <h3>Daftar Pesanan :</h3>
                            </div>
                            <div class="ms-auto" id="button${invoice.invoice_number}">
                             ${buttonHtml}
                            </div>
                        </div>
                    </h2>
                    <div id="panelsStayOpen-${i}"
                        class="accordion-collapse"
                        aria-labelledby="panelsStayOpen-${i}">
                        <div class="accordion-body">
                            <div class="row invoice">
                            ${productHtml}
                            </div>
                        </div>
                    </div>
                </div>

            </div>
                `;
            }

            dataContent.innerHTML = contentHtml;

            return true

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

function changeStatus(invoice, order_status, user_id) {
    var data = {
        "invoice": invoice,
        "order_status": order_status,
        "user_id": user_id,
    };
    console.log(data)
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: `/change-status`,
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
            reloadData();
            if (response.status_pemesanan == 'diproses') {
                document.getElementById(`button${invoice}`).innerHTML = `
                <button class="btn btn-warning btn-md" onclick="changeStatus('${invoice}', 'selesai', '${response.user_id}' )" id="bFinish{{ $key }}">Selesai</button>
                `;
            }
            else if (response.status_pemesanan == 'selesai') {
                $(`#accordion${invoice}`).addClass('fade-out');
                displayNone(`${invoice}`);
            }

            return true

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

function sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}

async function displayNone(invoice) {
    await sleep(1000);
    $(`#accordion${invoice}`).addClass('d-none');
}