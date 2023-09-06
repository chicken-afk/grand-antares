<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use function PHPSTORM_META\map;

class PrinterController extends Controller
{
    public function autoPrint()
    {
        $datas = DB::table('invoice_outlets')
            ->join('outlets', 'outlets.id', 'invoice_outlets.outlet_id')
            ->where('invoice_outlets.invoice_pdf', '!=', null)->where('invoice_outlets.is_get_for_print', 0)
            ->select('invoice_outlets.id', 'invoice_outlets.invoice_pdf', 'outlets.printer', 'outlets.paper')
            // ->where('outlets.printer', 'POS-80')
            ->limit(1)->get();

        foreach ($datas as $value) {
            DB::table('invoice_outlets')->where('id', $value->id)->update([
                'is_get_for_print' => 1
            ]);
        }

        return $datas;
    }

    public function isPrintedTrue($id)
    {
        DB::table('invoice_outlets')->where('id', $id)->update([
            'is_printed' => 1,
            'updated_at' => now()
        ]);
        return response()->json([
            'status_code' => 200,
            'message' => "Success Print $id"
        ]);
    }

    public function cashierPrinter(Request $request)
    {
        DB::table('roles')->where('role_name', 'cashier')->update([
            'printer' => $request->lstPrinters,
            'paper' => $request->lstPrinterPapers,
            'updated_at' => now()
        ]);
        alert('Success', "Printer Kasir Berubah menjadi $request->lstPrinters", 'success');
        return redirect()->back();
    }
}
