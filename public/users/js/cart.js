const content = document.getElementById('content-body');
var app_url = "127.0.0.1:8000";

console.log(content);

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

function generateContent() {
    var html = '';
    var carts = JSON.parse(localStorage.getItem("carts") || "[]");
    if (carts.length == 0) {
        html = `<p>Belum ada items dipilih</p>`;
    }
    for (var i = 0; i < carts.length; i++) {
        var varians = '';
        var toppings = '';
        var topping_text = '';
        if (carts[i].varian_id != null) {
            varians =
                `<p>Varian : ${carts[i].varian_name}</p>`;
        }
        if (carts[i].toppings.length > 0) {
            for (var j = 0; j < carts[i].toppings.length; j++) {
                toppings += carts[i].toppings[j].topping_name + ', ';
            }
            topping_text = `<p>Topping : ${toppings}</p>`;
        } else {
            topping_text = '';
        }
        html += `
        <div class="order-list" id="product${i}">
        <div class="d-flex bd-highlight">
            <div class="bd-highlight pr-2 product-name">
                ${carts[i].product_name}
                ${varians}
                ${topping_text}

                <p>Notes : ${carts[i].note}</p>
            </div>
            <div class="bd-highlight  ms-auto">
                <img loading="lazy" src="${carts[i].product_image}"
                    class="rounded float-start thumbnail-product mini" alt="...">
            </div>
        </div>
        <div class="d-flex bd-highlight mb-2">
            <div class="bd-highlight pr-2">
                <span class="price" id="price-${i}">Rp. ${number_format(carts[i].price * carts[i].qty)},-</span>
            </div>
            <div class="bd-highlight ms-auto pt-1">
                <div class="number-plus-minus ms-auto" style="width: 100px; height:35px">
                    <input disabled class="inputQty" name="product_qty" id="qty${i}" type="number" value=${carts[i].qty}
                        min=1 step="1" required />

                    <button type="button" id="${i}" onclick="plus(${i})" class="plus x-mini"></button>
                    <button type="button" id="${i}" onclick="minus(${i})" class="minus x-mini"></button>

                </div>
            </div>
        </div>
        <div class="line-1"></div>
    </div>
    `;
    }

    content.innerHTML = html;
}

// $(document).ready(function () {
var carts = JSON.parse(localStorage.getItem("carts") || "[]");
$('.minus').click(function () {
    const inputQtyProduct = $(this).parent().find('.inputQty');
    var count = parseInt(inputQtyProduct.val()) - 1;
    count = count < 1 ? 0 : count;
    console.log('id di klik - ', this.id);
    if (count == 0) {
        Swal.fire({
            title: 'Hapus Items?',
            // showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: 'Hapus',
            denyButtonText: `Batal`,
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            console.log(carts);
            if (result.isConfirmed) {
                var j = 0;
                var newCarts = [];
                for (var i = 0; i < carts.length; i++) {
                    if (i != this.id) {
                        console.log('array carts ', i, ' ', carts[i]);
                        newCarts[j] = carts[i];
                        j++;
                    }
                    else {
                    }
                }
                updateStorageCart(newCarts);
                // $(`#product${this.id}`).addClass('d-none');
                generateContent();
                var newCarts = [];
                Swal.fire('Berhasil!', '', 'success')
                return true
            } else if (result.isDenied) {
                Swal.fire('Changes are not saved', '', 'info')
                return true
            }
        })
        return true;
    }
    inputQtyProduct.val(count);
    inputQtyProduct.change();

    // Change Price
    var output = carts[this.id].price * count;
    // Update Cart On localStorage
    carts[this.id].qty = count;
    updateStorageCart(carts);
    var priceId = document.getElementById(`price-${this.id}`);
    output = number_format(output);
    priceId.innerHTML = `<span class="price" id="price-0">Rp. ${output},-</span>`;

    // Update Cart On Local Storage

    getTotalPrice()
    return false;
});
$('.plus').click(function () {
    var carts = JSON.parse(localStorage.getItem("carts") || "[]");
    console.log('id = ', + this.id)
    const inputQtyProduct = $(this).parent().find('.inputQty');
    var qty = parseInt(inputQtyProduct.val()) + 1;
    inputQtyProduct.val(qty);
    inputQtyProduct.change();

    // Change price
    var output = carts[this.id].price * qty;

    // Update Cart On localStorage
    carts[this.id].qty = qty;
    console.log(carts);
    updateStorageCart(carts);

    output = number_format(output);
    var priceId = document.getElementById(`price-${this.id}`);
    priceId.innerHTML = `<span class="price" id="price-0">Rp. ${output},-</span>`;


    getTotalPrice()
    return false;
});
// });

function minus(id) {
    var carts = JSON.parse(localStorage.getItem("carts") || "[]");
    var inputQtyProduct = document.getElementById(`qty${id}`);
    var count = parseInt(inputQtyProduct.value) - 1;
    count = count < 1 ? 0 : count;
    if (count == 0) {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-sm btn-primary m-1',
                cancelButton: 'btn btn-sm btn-danger m-1'
            },
            buttonsStyling: false
        })

        swalWithBootstrapButtons.fire({
            title: '<p class="m-0" style="font-size : medium">Hapus Item?</p>',
            // showDenyButton: true,
            width: 300,
            showCancelButton: true,
            confirmButtonText: 'Hapus',
            denyButtonText: `Batal`,
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            console.log(carts);
            if (result.isConfirmed) {
                var j = 0;
                var newCarts = [];
                for (var i = 0; i < carts.length; i++) {
                    if (i != id) {
                        console.log('array carts ', i, ' ', carts[i]);
                        newCarts[j] = carts[i];
                        j++;
                    }
                    else {
                    }
                }
                updateStorageCart(newCarts);
                // $(`#product${this.id}`).addClass('d-none');
                generateContent();
                var newCarts = [];
                getTotalPrice()

                return true
            } else if (result.isDenied) {
                Swal.fire('Changes are not saved', '', 'info')
                return true
            }
        })
        return true;
    }
    inputQtyProduct.value = count;

    // Change Price
    var output = carts[id].price * count;
    // Update Cart On localStorage
    carts[id].qty = count;
    updateStorageCart(carts);
    var priceId = document.getElementById(`price-${id}`);
    output = number_format(output);
    priceId.innerHTML = `<span class="price" id="price-0">Rp. ${output},-</span>`;

    // Update Cart On Local Storage

    getTotalPrice()
    return false;
}

function plus(id) {
    var carts = JSON.parse(localStorage.getItem("carts") || "[]");
    console.log('id = ', + id)
    var inputQtyProduct = document.getElementById(`qty${id}`);
    console.log(inputQtyProduct)
    var qty = parseInt(inputQtyProduct.value) + 1;
    inputQtyProduct.value = qty;

    // Change price
    var output = carts[id].price * qty;

    // Update Cart On localStorage
    carts[id].qty = qty;
    console.log(carts);
    updateStorageCart(carts);

    output = number_format(output);
    var priceId = document.getElementById(`price-${id}`);
    priceId.innerHTML = `<span class="price" id="price-0">Rp. ${output},-</span>`;


    getTotalPrice()
    return false;
}

function getTotalPrice() {
    var sumPrice = 0;
    var carts = JSON.parse(localStorage.getItem("carts") || "[]");
    for (var i = 0; i < carts.length; i++) {
        var priceTotal = 0;
        priceTotal += carts[i].price;
        priceTotal = priceTotal * carts[i].qty;
        sumPrice += priceTotal;
    }
    var e = document.getElementById('buttonCheckout');
    e.innerHTML = `Buat Pesanan ( Rp. ${number_format(sumPrice)},- )`;
    return sumPrice;
}

function updateStorageCart(carts) {
    localStorage.removeItem("carts");
    localStorage.setItem("carts", JSON.stringify(carts));
}


function submitOrders() {
    var carts = JSON.parse(localStorage.getItem("carts") || "[]");
    var data = {};
    if (carts.length == 0) {
        Swal.fire({
            icon: 'error',
            title: 'Keranjang Kosong',
            text: 'Tambah items dulu ya',
        })
        return false
    }
    var valError = false;
    var keteranganValue = getSelectedKeterangan();
    var nUser = document.getElementById('nUser');
    var nTable = document.getElementById('nTable') ?? null;
    var code = document.getElementById('code').value;
    var paymentMethod = document.getElementById('paymentMethod').value;
    var whatsapp = document.getElementById('nWhatsapp').value ?? null;
    if (keteranganValue == 'Take Away') {
        console.log('take away')
        console.log('value', nUser.value)
        if (nUser.value == '') {
            $("#alert-user").removeClass("d-none");
            $("#alert-table").addClass("d-none");
            var access = document.getElementById("detailPemesan");
            access.scrollIntoView({ behavior: 'smooth' }, true);
            return true
        }
    } else {
        if (nTable == null) {
            console.log("nama" + nUser.value)
            if (nUser.value == '') {
                $("#alert-user").removeClass("d-none");
                var access = document.getElementById("detailPemesan");
                access.scrollIntoView({ behavior: 'smooth' }, true);
                return true
            }
            console.log("gak masuk if")

            $("#alert-user").removeClass("d-none");
            var access = document.getElementById("detailPemesan");
            access.scrollIntoView({ behavior: 'smooth' }, true);
        }
        else {
            if (nUser.value == '' || nTable.value == '') {
                if (nUser.value != '' && nTable.value == '') {
                    $("#alert-user").addClass("d-none");
                    $("#alert-table").removeClass("d-none");
                    var access = document.getElementById("detailPemesan");
                    access.scrollIntoView({ behavior: 'smooth' }, true);
                    return true
                }
                if (nUser.value == '' && nTable.value != '') {
                    $("#alert-user").removeClass("d-none");
                    $("#alert-table").addClass("d-none");
                    var access = document.getElementById("detailPemesan");
                    access.scrollIntoView({ behavior: 'smooth' }, true);
                    return true
                }

                $("#alert-user").removeClass("d-none");
                $("#alert-table").removeClass("d-none");
                var access = document.getElementById("detailPemesan");
                access.scrollIntoView({ behavior: 'smooth' }, true);
                return true
            }
        }
    }

    $("#alert-user").addClass("d-none");
    $("#alert-table").addClass("d-none");
    var kamar = "";
    if (nTable != null) {
        kamar = nTable.value;
    }
    data = {
        "nama_pemesan": nUser.value,
        "nomor_kamar": kamar,
        "whatsapp": whatsapp,
        "payment_method": paymentMethod,
        "code": code,
        "invoice_charge": getTotalPrice(),
        "keterangan": keteranganValue,
        "carts": carts
    }
    console.log(data)
    // Send Data Using AJax


    // End Send Data Using Ajax

    Swal.fire({
        title: '<p class="m-0" style="font-size : medium; padding : 1px">Pastikan pesanan sudah sesuai?</p>',
        // showDenyButton: true,
        showCancelButton: true,
        confirmButtonText: 'Sudah',
        denyButtonText: `Don't save`,
        customClass: {
            confirmButton: 'btn btn-sm btn-primary m-1',
            cancelButton: 'btn btn-sm btn-danger m-1'
        },
        buttonsStyling: false,
        width: 300
    }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
            $("#loader-wrapper").removeClass("d-none");
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: `/carts`,
                type: "POST",
                data: data,
                success: function (response) {

                    if (response.status_code == 422) {
                        Swal.fire({
                            icon: 'Error',
                            title: 'Gagal',
                            text: 'Something went wrong',
                        })
                        return false;
                    }

                    localStorage.removeItem('carts');
                    localStorage.setItem('invoice', response.invoice);
                    generateContent();
                    $("#loader-wrapper").addClass("d-none");
                    window.location = "/invoice/" + code + "?invoice=" + response.invoice
                },
                error: function (response) {
                    console.log(response)
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Something went wrong, please contact cashier',
                    })
                }
            });

        } else if (result.isDenied) {
            Swal.fire('Changes are not saved', '', 'info')
        }
    })

}

function getSelectedKeterangan() {
    var radios = document.querySelectorAll('input[name="keterangan"]');
    var selectedValue = '';

    radios.forEach(function (radio) {
        if (radio.checked) {
            selectedValue = radio.value;
        }
    });

    return selectedValue;
}


getTotalPrice();

generateContent();