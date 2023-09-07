const inputFiledProductName = document.getElementById('productName');
const inputFieldProductSKU = document.getElementById('productSKU');
const inputFieldProductDescription = document.getElementById('productDescription');
const inputFieldCategory = document.getElementById('productCategory');
const inputFieldPrice = document.getElementById('productPrice');
const inputFieldPriceRestaurant = document.getElementById('productPriceRestaurant');
const inputFieldimage = document.getElementById('productImage');

let data = {};


inputFiledProductName.addEventListener('input', function () {
    data['productName'] = inputFiledProductName.value;
    inputFieldProductSKU.value = data['productName'].replace(/\s+/g, '').toUpperCase();
    data['productSKU'] = inputFieldProductSKU.value;
    console.log(data); // will log the current value of the input field
});


inputFieldProductSKU.addEventListener('input', function () {
    data['productSKU'] = inputFieldProductSKU.value;
    data['productSKU'] = data['productSKU'].replace(/\s+/g, '');

    console.log(data); // will log the current value of the input field
});

inputFieldProductDescription.addEventListener('input', function () {
    data['productDescription'] = inputFieldProductDescription.value;
    console.log(data); // will log the current value of the input field
});

inputFieldPrice.addEventListener('input', function () {
    data['productPrice'] = inputFieldPrice.value;
    data['productPricePromo'] = inputFieldPrice.value;
    console.log(data); // will log the current value of the input field
});

inputFieldPriceRestaurant.addEventListener('input', function () {
    data['productPriceRestaurant'] = inputFieldPriceRestaurant.value;
    console.log(data); // will log the current value of the input field
});

inputFieldCategory.addEventListener('change', function () {
    console.log('masuk categori')
    data['category_name'] = inputFieldCategory.options[inputFieldCategory.selectedIndex].text;
    data['category_id'] = inputFieldCategory.value;
    generateSubCategory(data['category_id'])
    console.log(data); // will log the current value of the input field
});



function generatFormData() {
    data['varian'] = [];
    data['topping'] = [];
    data['varian_name'] = []
    data['varian_sku'] = []
    data['varian_price'] = []
    data['varian_price_restaurant'] = []
    data['topping_name'] = []
    data['topping_price'] = []
    data['topping_price_restaurant'] = []

    var input = document.getElementsByName('varian_name[]');
    var input1 = document.getElementsByName('varian_name[]');
    var input2 = document.getElementsByName('varian_price[]');
    var input5 = document.getElementsByName('varian_price_restaurant[]');
    var input3 = document.getElementsByName('topping_name[]');
    var input4 = document.getElementsByName('topping_price[]');
    var input6 = document.getElementsByName('topping_price_restaurant[]');

    // Varian Data Generat

    if (input.length > 0) {
        if (input)
            for (var i = 0; i < input.length; i++) {
                var a = input[i];
                var b = input1[i];
                var c = input2[i];
                var d = input5[i];
                if (a.value.length != 0 && b.value.length != 0 && c.value.length != 0) {
                    data.varian[i] = {
                        'varian_name': a.value,
                        'varian_sku': b.value.replace(/\s+/g, '').toUpperCase(),
                        'varian_price': c.value,
                        'varian_price_restaurant': d.value,
                    }
                }
            }
    }

    // Topping Data generate
    if (input3.length > 0) {
        for (var i = 0; i < input3.length; i++) {
            var d = input3[i];
            var e = input4[i];
            var f = input6[i];
            if (d.value.length != 0 && e.value.length != 0) {
                data.topping[i] = {
                    'topping_name': d.value,
                    'topping_price': e.value,
                    'topping_price_restaurant': f.value,
                }
            }
        }
    }

    console.log(data)
    generateReviewPage(data);
}

function addForm() {
    var e = $(
        `
        <div class="row">
                                                <div class="col-xl-4">
                                                    <!--begin::Input-->
                                                    <div class="form-group fv-plugins-icon-container has-success">
                                                        <label>Variant Name</label>
                                                        <input type="text" class="form-control form-control-solid form-control-lg" name="varian_name[]">
                                                        <span class="form-text text-muted">Please enter your Package Height in CM.</span>
                                                    <div class="fv-plugins-message-container"></div></div>
                                                    <!--end::Input-->
                                                </div>
                                                <div class="col-xl-4">
                                                    <!--begin::Input-->
                                                    <div class="form-group fv-plugins-icon-container has-success">
                                                        <label>Harga</label>
                                                        <input type="text" class="form-control form-control-solid form-control-lg" name="varian_price[]">
                                                        <span class="form-text text-muted">Please enter your Package Length in CM.</span>
                                                    <div class="fv-plugins-message-container"></div></div>
                                                    <!--end::Input-->
                                                </div>
                                                <div class="col-xl-4">
                                                    <!--begin::Input-->
                                                    <div
                                                        class="form-group fv-plugins-icon-container has-success">
                                                        <label>Harga Restaurant</label>
                                                        <input type="text"
                                                            class="form-control form-control-solid form-control-lg"
                                                            name="varian_price_restaurant[]">
                                                        <span class="form-text text-muted">Masukan harga varian
                                                            untuk restaurant</span>
                                                        <div class="fv-plugins-message-container"></div>
                                                    </div>
                                                    <!--end::Input-->
                                                </div>
                                            </div>
        `);
    $('#input-varian').append(e);
    e.attr('id', 'myid');
}

function addFormToping() {
    var e = $(
        `
        <div class="row">
        <div class="col-xl-4">
        <!--begin::Input-->
        <div
            class="form-group fv-plugins-icon-container has-success">
            <label>Nama Topping</label>
            <input type="text"
                class="form-control form-control-solid form-control-lg"
                name="topping_name[]">
            <span class="form-text text-muted">Contoh : Telor
                Dadar,
                Keju dll</span>
            <div class="fv-plugins-message-container"></div>
        </div>
        <!--end::Input-->
    </div>
    <div class="col-xl-4">
        <!--begin::Input-->
        <div
            class="form-group fv-plugins-icon-container has-success">
            <label>Harga Kamar</label>
            <input type="text"
                class="form-control form-control-solid form-control-lg"
                name="topping_price[]">
            <span class="form-text text-muted">Masukan Harga
                Topping kamar</span>
            <div class="fv-plugins-message-container"></div>
        </div>
        <!--end::Input-->
    </div>
    <div class="col-xl-4">
        <!--begin::Input-->
        <div
            class="form-group fv-plugins-icon-container has-success">
            <label>Harga Restaurant</label>
            <input type="text"
                class="form-control form-control-solid form-control-lg"
                name="topping_price_restaurant[]">
            <span class="form-text text-muted">Masukan Harga Toping
                Restaurant</span>
            <div class="fv-plugins-message-container"></div>
        </div>
        <!--end::Input-->
    </div>
                                            </div>
        `);
    $('#input-topping').append(e);
    e.attr('id', 'myid');
}

function generateReviewPage(data) {
    console.log('Masuk ke generate review page');
    console.log(data)
    console.log('Topping panjang :', data.topping.length)
    let varian_text = "";
    let topping_text = "";
    if (data.varian.length == 0) {
        varian_text = `
            <tr>
                <td colspan="3">Tidak Ada Varian</td>
            </tr>`;
    } else {
        for (let i = 0; i < data.varian.length; i++) {
            varian_text += ` 
            <tr>
                <td>${data.varian[i].varian_name}</td>
                <td>${data.varian[i].varian_sku}</td>
                <td>${data.varian[i].varian_price}</td>
                <td>${data.varian[i].varian_price_restaurant}</td>
            </tr>`
        }
    }
    if (data.topping.length == 0) {
        topping_text = `
            <tr>
                <td colspan="2">Tidak Ada Topping</td>
            </tr>`;
    } else {
        for (let i = 0; i < data.topping.length; i++) {
            topping_text += ` 
            <tr>
                <td>${data.topping[i].topping_name}</td>
                <td>${data.topping[i].topping_price}</td>
                <td>${data.topping[i].topping_price_restaurant}</td>
            </tr>`
        }
    }
    let html = `
        <!--begin::Section-->
        <h4 class="mb-10 font-weight-bold text-dark">Review your Details and Submit</h4>
        <h6 class="font-weight-bolder mb-3">Produk Detail:</h6>
        <div class="font-weight-bolder line-height-lg">
            <div class="row">
                <div class="col-md-3">Nama</div>
                <div class="col-md-1">:</div>
                <div class="col-md-8">${data.productName}</div>
            </div>
            <div class="row">
                <div class="col-md-3">Deskripsi</div>
                <div class="col-md-1">:</div>
                <div class="col-md-8">${data.productDescription}</div>
            </div>
            <div class="row">
                <div class="col-md-3">Harga Kamar</div>
                <div class="col-md-1">:</div>
                <div class="col-md-8">Rp. ${data.productPrice},-</div>
            </div>
            <div class="row">
                <div class="col-md-3">Harga Restaurant</div>
                <div class="col-md-1">:</div>
                <div class="col-md-8">Rp.  ${data.productPriceRestaurant},-</div>
            </div>
            <div class="row">
                <div class="col-md-3">Kategori</div>
                <div class="col-md-1">:</div>
                <div class="col-md-8"> ${data.category_name}</div>
            </div>
            
        </div>
        <div class="separator separator-dashed my-5"></div>
        <!--end::Section-->
        <!--begin::Section-->
        <h6 class="font-weight-bolder mb-3">Varian:</h6>
        <div class="font-weight-bolder line-height-lg">
        <table class="table table-borderless table-vertical-center table-responsive">
            <thead>
                <th>SKU</th>
                <th>Varian</th>
                <th>Harga Kamar</th>
                <th>Harga Restaurant</th>
            </thead>
            <tbody>
                ${varian_text}
            </tbody>
        </table>
            
        </div>
        <!--end::Section-->
        <div class="separator separator-dashed my-5"></div>
    <!--begin::Section-->
    <h6 class="font-weight-bolder mb-3">Toping:</h6>
    <div class="font-weight-bolder line-height-lg">
        <table class="table table-borderless table-vertical-center table-responsive">
        <thead>
            <th>Topping</th>
            <th>Harga Kamar</th>
            <th>Harga Restaurant</th>
        </thead>
        <tbody>
            ${topping_text}
        </tbody>
        </table>
        
    </div>
    <!--end::Section-->
    `;
    document.getElementById('reviewPage').innerHTML = html;
    console.log('sukses menambahkan html');
}

function postData() {
    let inputSubCategory = document.getElementById("subCategoryId") ?? null;
    console.log(inputSubCategory)
    if (inputSubCategory != null) {
        data['sub_category_id'] = inputSubCategory.value;
    }
    else {
        data['sub_category_id'] = null;
    }
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: `/product-post`,
        type: "POST",
        data: data,
        success: function (response) {
            var inputs = document.querySelectorAll("input");
            inputs.forEach(function (element) {
                element.value = "";
            })
            Swal.fire(
                'Good job!',
                'Data Berhasil Disimpan!',
                'success'
            );
            console.log(response)
            window.location = "/products"
        },
        error: function (response) {
            console.log("Error gan")
        }
    });
}

var avatar5 = new KTImageInput('kt_image_5');

avatar5.on('cancel', function (imageInput) {
    swal.fire({
        title: 'Image successfully changed !',
        type: 'success',
        buttonsStyling: false,
        confirmButtonText: 'Ok!',
        confirmButtonClass: 'btn btn-primary font-weight-bold'
    });
});

avatar5.on('change', function (imageInput) {
    swal.fire({
        title: 'Image successfully changed !',
        type: 'success',
        buttonsStyling: false,
        confirmButtonText: 'Ok!',
        confirmButtonClass: 'btn btn-primary font-weight-bold'
    });
});

avatar5.on('remove', function (imageInput) {
    const FR = new FileReader();
    FR.readAsDataURL(imageInput);
    console.log('image : ', imageInput)
    swal.fire({
        title: 'Image successfully removed !',
        type: 'error',
        buttonsStyling: false,
        confirmButtonText: 'Got it!',
        confirmButtonClass: 'btn btn-primary font-weight-bold'
    });
});

function readFile() {

    if (!this.files || !this.files[0]) return;

    const FR = new FileReader();

    FR.addEventListener("load", function (evt) {
        // document.querySelector("#img").src = evt.target.result;
        // document.querySelector("#b64").textContent = evt.target.result;
        // console.log(evt.target.result);
        data['product_image'] = evt.target.result;
        console.log(data);
    });

    FR.readAsDataURL(this.files[0]);

}

document.querySelector("#product_image").addEventListener("change", readFile);

generateReviewPage(data);

console.log("data awal :", data)

function generateSubCategory(categoryId) {
    console.log('masuk get subcat')
    document.getElementById("subCategories").innerHTML = "";
    $.ajax({
        url: `/categories/` + categoryId,
        type: "GET",
        success: function (response) {
            let option = "";
            console.log(response)
            if (response.length > 0) {
                response.forEach((item) => {
                    option += `
                    <option value="${item.id}">${item.sub_category_name}</option>
                    `;
                })
                document.getElementById("subCategories").innerHTML = `
                <label>Sub Kategori</label>
                <select name="subCategoryId"
                    class="form-control form-control-solid form-control-lg"
                    id="subCategoryId">
                    ${option}
                </select>
                `;
            }

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