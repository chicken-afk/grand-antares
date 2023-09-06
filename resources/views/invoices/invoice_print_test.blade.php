<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
</head>
<style>
    body {
        font-family: "Helvetica" !important;
    }

    .fontHeader {
        font-size: 100px;
        color: rgb(0, 0, 0);
        margin: 0px;
    }

    .fontA {
        font-size: 60px;
        color: rgb(0, 0, 0);
        line-height: 1 !important;
        margin: 0px;
    }

    .font-success {
        font-size: 52px;
        color: rgb(0, 0, 0);
    }

    .line {
        height: 1px;
        background-color: white;
        margin-top: 15px;
        margin-bottom: 15px;
        border: 1px dashed black;
    }

    .invoice {
        font-size: 100px;
    }

    .products {
        font-size: 60px;
        color: rgb(0, 0, 0);
        text-transform: uppercase;
        margin: 0px;
        line-height: 1 !important;
    }

    span {
        font-size: 10px !important;
        line-height: 16px !important;
        font-weight: 600 !important;
    }

    .table {
        margin-bottom: 0px !important;
    }

    .table td,
    .table th {
        padding: 0rem !important;
        vertical-align: top;
        border-bottom: 1px solid #dee2e6 !important;
        border-top: none !important;
    }
</style>

<body>
    <h4 class="fontHeader" style="text-align: center">Warung Aceh Bang Ari</h4>
    <h4 class="font-success" style="text-align : center;">Jl. Tebet Barat Dalam V
        No.1, RW.3, Tebet Bar., Kec. Tebet, Kota
        Jakarta Selatan,
        Daerah Khusus Ibukota Jakarta
        12810</h4>
    <div class="line" style="margin-bottom: 20px"></div>
    <table>
        <tr>
            <td class="invoice">
                <h4 class="fontA">Invoice</h4>
            </td>
            <td class="invoice">
                <h4 class="fontA">:</h4>
            </td>
            <td class="invoice">
                <h4 class="fontA">{{ $row['invoice_number'] }}</h4>
            </td>
        </tr>
        <tr>
            <td class="invoice">
                <h4 class="fontA">Nama</h4>
            </td>
            <td class="invoice">
                <h4 class="fontA">:</h4>
            </td>
            <td class="invoice">
                <h4 class="fontA">{{ $row['name'] }}</h4>
            </td>
        </tr>
        <tr>
            <td class="invoice">
                <h4 class="fontA">Table</h4>
            </td>
            <td class="invoice">
                <h4 class="fontA">:</h4>
            </td>
            <td class="invoice">
                <h4 class="fontA">{{ $row['no_table'] }}</h4>
            </td>
        </tr>
        @if (isset($row['keterangan']))
            <td class="invoice">
                <h4 class="fontA">Keterangan</h4>
            </td>
            <td class="invoice">
                <h4 class="fontA">:</h4>
            </td>
            <td class="invoice">
                <h4 class="fontA">{{ $row['keterangan'] }}</h4>
            </td>
        @endif
    </table>
    <div class="line"></div>
    @foreach ($row['products'] as $key => $value)
        <h4 class="products fontA" style="margin-bottom: 0px">
            {{ $value['active_product_name'] ?? $value['product_name'] }}
        </h4>

        @if (isset($value['varian_name']) && $value['varian_name'] != '')
            <h4 class="products fontA" style="margin-bottom: 0px ;text-transform: none !important;">
                {{ $value['varian_name'] }}
            </h4>
        @endif
        @if (isset($value['topping_name']) && $value['topping_name'] != '')
            <h4 class="products fontA" style="margin-bottom: 0px;text-transform: none !important;">
                {{ $value['topping_name'] }}
            </h4>
        @endif
        <table class="products table">
            <tr>
                <td>{{ $value['qty'] }}x</td>
                <td>{{ $value['price'] }}</td>
                <td style="text-align: right">{{ $value['price'] * (int) $value['qty'] }}</td>
            </tr>
        </table>
    @endforeach
    <div class="line"></div>
    @if (isset($row['sub_total']))
        <table class="products table">
            <tr class="invoice">
                <td class="invoice">
                    <h4 class="fontA">Subtotal</h4>
                </td>
                <td class="invoice">
                    <h4 class="fontA">:</h4>
                </td>
                <td class="invoice" style="text-align: right">
                    <h4 class="fontA">{{ $row['sub_total'] }}</h4>
                </td>
            </tr>
            <tr class="invoice">
                <td class="invoice">
                    <h4 class="fontA">Pajak</h4>
                </td>
                <td class="invoice">
                    <h4 class="fontA">:</h4>
                </td>
                <td class="invoice" style="text-align: right">
                    <h4 class="fontA">{{ $row['tax'] }}</h4>
                </td>
            </tr>
            <tr class="invoice">
                <td class="invoice">
                    <h4 class="fontA">Total</h4>
                </td>
                <td class="invoice">
                    <h4 class="fontA">:</h4>
                </td>
                <td class="invoice" style="text-align: right">
                    <h4 class="fontA">{{ $row['payment_charge'] }}</h4>
                </td>
            </tr>
        </table>
    @endif
    <h4 style="text-align: center;" class="fontA">{{ date('H:i d/m/Y') }}</h4>
</body>

</html>
