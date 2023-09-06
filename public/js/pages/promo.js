const inputSearch = document.getElementById('inputSearch');
document.getElementById("inputSearch").autofocus;

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

inputSearch.addEventListener('input', function () {
    var search = inputSearch.value;
    document.getElementById("searchContent").innerHTML = '';
    if (search.length > 2) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: `/promo/search-product?search=${search}`,
            type: "GET",
            success: function (response) {
                var html = "";
                if (response.length == 0) {
                    html = `
                    <div class="col-md-12 text-center align-item-center mt-4 mb-4"> Produk tidak ditemukan</div>
                    `;
                } else {
                    response.forEach(element => {
                        data = JSON.stringify(element);
                        html += `
                        <div class="col-md-4 text-center align-item-center mt-4 mb-4">
                        <img src="${element.product_image}"
                        alt = "imageProduct" class="img-thumbnail max-h-150px" >
                        <p class="text-bold" style="font-size: 1rem">${element.active_product_name}</p>
                        <button onclick='openModalDetail(${data})' class="button btn btn-sm btn-warning">Tambah Promo</button>
                    </div>
                            `;
                    });
                }
                document.getElementById("searchContent").innerHTML = html;
            },
            error: function (response) {
                console.log("Error gan")
            }
        });
    }
})

function editFunction(id) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: `/promo/product/${id}`,
        type: "GET",
        success: function (response) {
            console.log(response)
            openModalDetail(response)
        },
        error: function (response) {
            console.log("Error gan")
        }
    });
}

function openModal() {
    $('#modalSearch').modal('show');
}

function isNullCheck(data) {
    if (data != null) {
        return `value="${data}"`
    }
}
function openModalDetail(data) {
    console.log(data)
    let html = "";
    let variantHtml = "";
    if (data.variants.length > 0) {
        variantHtml = `<h4 class="mt-4 mb-4">Varian</h4>`;
        data.variants.forEach(item => {
            variantHtml += `
            <div class="row">
                <div class="col-md-3">
                    <label>Harga Normal Kamar</label>
                    <input type="text"
                        class="form-control form-control-solid form-control-lg"
                        value="Rp. ${number_format(item.varian_price)}" disabled>
                </div>
                <div class="col-md-3">
                    <label>Harga Promo Kamar</label>
                    <input type="text"
                        class="form-control form-control-solid form-control-lg"
                        name="variant[${item.id}][harga_promo_kamar]"
                        placeholder="Masukan Harga Promo Kamar" ${isNullCheck(item.varian_promo)} required>
                </div>
                <div class="col-md-3">
                    <label>Harga Normal Restaurant</label>
                    <input type="text"
                        class="form-control form-control-solid form-control-lg"
                        value="Rp. ${number_format(item.varian_price_restaurant)}" disabled>
                </div>
                <div class="col-md-3">
                    <label>Harga Promo Restaurant</label>
                    <input type="text"
                        class="form-control form-control-solid form-control-lg"
                        name="variant[${item.id}][harga_promo_restaurant]"
                        placeholder="Masukan Harga Promo Restaurant" ${isNullCheck(item.varian_promo_restaurant)} required>
                </div>
            </div>
            `;
        })
    }

    html = `
    <input type="hidden" name="id" value="${data.id}">
    <div class="row p-5">
    <div class="col-md-12">
        <div class="form-group fv-plugins-icon-container has-success">
            <h3>Tambah Promo</h3>
            <h4>${data.active_product_name}</h4>
        </div>
        <div class="form-group fv-plugins-icon-container has-success">
            <div class="row">
                <div class="col-md-6">
                    <label>Harga Normal Kamar</label>
                    <input type="text"
                        class="form-control form-control-solid form-control-lg"
                        value="Rp. ${number_format(data.price_display)}" disabled>
                </div>
                <div class="col-md-6">
                    <label>Harga Promo Kamar</label>
                    <input type="text"
                        class="form-control form-control-solid form-control-lg"
                        name="harga_promo_kamar" ${isNullCheck(data.price_promo)} placeholder="Masukan Harga Promo Kamar"
                        required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label>Harga Normal Restaurant</label>
                    <input type="text"
                        class="form-control form-control-solid form-control-lg"
                        value="Rp. ${number_format(data.price_display_restaurant)}" disabled>
                </div>
                <div class="col-md-6">
                    <label>Harga Promo Restaurant</label>
                    <input type="text"
                        class="form-control form-control-solid form-control-lg"
                        name="harga_promo_restaurant" ${isNullCheck(data.price_promo_restaurant)} placeholder="Masukan Harga Promo Kamar"
                        required>
                </div>
            </div>
            ${variantHtml}
        </div>
        
        <div class="row my-6">
            <div class="col-md-12">
                <label for="bannerPromo">Banner Promo</label><br>
                <input type="file" name="bannerPromo">
            </div>
         </div>
        <div class="row mt-10">
        <div class="col-md-12 text-center align-item-center">
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </div>
    </div>
</div>
    `;
    document.getElementById("modalTambahPromoContent").innerHTML = html;
    $('#modalSearch').modal('hide');
    $('#modalTambahPromo').modal('show');
}