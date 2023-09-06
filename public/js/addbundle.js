$(document).ready(function () {
    const inputFieldBundleName = document.getElementById('bundleName');
    const inputFieldProductSKU = document.getElementById('productSKU');
    const inputFieldPrice = document.getElementById('bundlePrice');
    const inputFieldPricePromo = document.getElementById('bundlePricePromo');

    console.log(inputFieldPrice)

    inputFieldBundleName.addEventListener('input', function () {
        inputFieldProductSKU.value = inputFieldBundleName.value.replace(/\s+/g, '').toUpperCase();
    });

    inputFieldPrice.addEventListener('input', function () {
        inputFieldPricePromo.value = inputFieldPrice.value;
    });
})