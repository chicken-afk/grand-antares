<?php

namespace App\Http\Controllers;

use App\Exports\OrderExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportOrderController extends Controller
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function export(Request $request)
    {
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        $paymentStatus = $request->payment_status;
        // return Excel::download(new OrderExport, 'orders.xlsx');

        // Buat instance OrderExport dengan data yang diperlukan
        $orderExport = new OrderExport($startDate, $endDate, $paymentStatus);

        // Lakukan pengunduhan Excel\
        $name = "order_" . date("d_m_Y") . ".xlsx";
        return Excel::download($orderExport, $name);
    }
}
