<?php

namespace App\Repositories\Repository;

use App\Repositories\DashboardInterface;
use Illuminate\Support\Facades\DB;

class DashboardRepository implements DashboardInterface
{
    public function index()
    {
        $row['invoices'] = DB::table('invoices')
            ->join('invoice_products', 'invoice_products.invoice_id', 'invoices.id')
            ->join('active_products', 'active_products.id', 'invoice_products.active_product_id')
            ->groupBy('invoices.id')
            ->where('invoices.payment_status', 0)
            ->orderByDesc('invoices.id')->limit(5)->get();
        $row['omset'] = DB::table('invoices')->where('payment_status', 1)->sum('payment_charge');
        $row['produk_terlaris'] = DB::table('invoice_products')
            ->join('invoices', 'invoices.id', '=', 'invoice_products.invoice_id')
            ->join('active_products', 'active_products.id', 'invoice_products.active_product_id')
            ->where('invoices.payment_status', 1)
            ->select('invoices.invoice_number', 'invoice_products.active_product_id', 'active_products.*', DB::raw("sum(invoice_products.qty) as count"))
            ->groupBy('invoice_products.active_product_id')
            ->get();
        $row['total_produk_terjual'] = DB::table('invoice_products')
            ->join('invoices', 'invoices.id', '=', 'invoice_products.invoice_id')
            ->where('invoices.payment_status', 1)
            ->sum('qty');
        $row['total_invoice'] = DB::table('invoices')->where('payment_status', 1)->count();

        $row['produk_terlaris'] =  $row['produk_terlaris']->sortByDesc('count')->values();
        return $row;
    }
}
