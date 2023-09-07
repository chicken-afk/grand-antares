<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;

class GenerateInvoice extends Controller
{
    public function generate()
    {
        $row['no_table'] = "6";
        $row['sub_total'] = 30000;
        $row['tax'] = 3000;
        $row['payment_charge'] = 33000;
        $row['invoice_number'] = "INVC12345";
        $row['name'] = "Andika";
        $row['products'] = array(
            array(
                'active_product_name' => "Nasi Goreng Spesial",
                'product_sku' => 'NASGOR2923',
                'qty' => '1',
                'notes' => 'note ya',
                'price' => '39000'
            ),
            array(
                'active_product_name' => "Es Teh",
                'product_sku' => 'ESTEH234',
                'qty' => '1',
                'notes' => 'note ya',
                'price' => '5000'
            ),
            array(
                'active_product_name' => "Americano",
                'product_sku' => 'AMRCN132',
                'qty' => '2',
                'notes' => 'note ya',
                'price' => '22000'
            )
        );
        $row['products'] = collect($row['products']);

        // return view('invoices.invoice_print_test', compact('row'));
        view()->share('row', $row);
        PDF::setBasePath(public_path());
        $pdf = PDF::loadView('invoices.invoice_print_test', $row)->setPaper([0, 0, 685.98, 215.772], 'landscape');
        // download PDF file with download method
        return $pdf->download('pdf23_file.pdf');
    }
}
