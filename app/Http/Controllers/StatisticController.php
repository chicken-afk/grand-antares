<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatisticController extends Controller
{
    public function view()
    {
        $firstOrder = Order::where('payment_status', 1)->orderBy('id', 'asc')->first();
        $lastOrder = Order::where('payment_status', 1)->orderBy('id', 'desc')->first();
        $row['startDate'] = $firstOrder ? date('m/d/Y', strtotime($firstOrder->payment_at)) : null;
        $row['endDate'] = $lastOrder ? date('m/d/Y', strtotime($lastOrder->payment_at)) : null;
        $row['firstYear'] = $firstOrder ? (int) date('Y', strtotime($firstOrder->payment_at)) : null;
        $row['lastYear'] = $lastOrder ? (int) date('Y', strtotime($lastOrder->payment_at)) : null;

        return view('main.statistic', compact('row'));
    }

    public function statisticOmset(Request $request)
    {
        $query = DB::table('invoices')->where('payment_status', 1);
        if ($request->has('year')) {
            $query->whereYear('payment_at', $request->year);
        }

        $datas = $query->select(DB::raw('sum(payment_charge) as `omset`'), DB::raw("DATE_FORMAT(payment_at, '%M-%Y') new_date"),  DB::raw('YEAR(payment_at) year, MONTH(payment_at) month'))
            ->groupby('year', 'month')
            ->get();
        return response()->json([
            'status_code' => 200,
            'data' => $datas
        ]);
    }

    public function statisticOmsetDat(Request $request)
    {
        $query = DB::table('invoices')->where('payment_status', 1);
        if ($request->has('start_date')) {
            $startDate = date('Y-m-d', strtotime($request->start_date)) . " 00:00:01";
            $endDate = date('Y-m-d', strtotime($request->end_date)) . " 23:59:00";
            $query = $query->whereBetween('payment_at', [$startDate, $endDate]);
        }
        $datas = $query->select(DB::raw('sum(payment_charge) as `omset`'), DB::raw("DATE_FORMAT(payment_at, '%d-%M-%Y') new_date"),  DB::raw('Day(payment_at) day, YEAR(payment_at) year, MONTH(payment_at) month'))
            ->groupby('day', 'year', 'month')
            ->orderBy('payment_at', 'asc')
            ->get();
        return response()->json([
            'status_code' => 200,
            'data' => $datas
        ]);
    }

    public function statisticOutlet()
    {
        $datas = DB::table('invoices')->where('invoices.payment_status', 1)
            ->join('invoice_products', 'invoice_products.invoice_id', 'invoices.id')
            ->join('active_products', 'active_products.id', 'invoice_products.active_product_id')
            ->join('outlets', 'outlets.id', 'active_products.outlet_id')
            ->select('outlets.outlet_name', DB::raw('sum(invoice_products.qty) as `data`'))
            ->groupBy('outlets.id')
            ->get();
        $datas = $datas->sortByDesc('data')->values();
        return response()->json([
            'status_code' => 200,
            'data' => $datas
        ]);
    }
    public function statisticProduct()
    {
        $datas = DB::table('invoices')->where('invoices.payment_status', 1)
            ->join('invoice_products', 'invoice_products.invoice_id', 'invoices.id')
            ->join('active_products', 'active_products.id', 'invoice_products.active_product_id')
            ->select('active_products.active_product_name', DB::raw('sum(invoice_products.qty) as `data`'))
            ->groupBy('invoice_products.active_product_id')
            ->get();
        $datas = $datas->sortByDesc('data')->values();
        return response()->json([
            'status_code' => 200,
            'data' => $datas
        ]);
    }
}
