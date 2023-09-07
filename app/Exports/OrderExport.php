<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithHeadings;

class OrderExport implements FromCollection, WithHeadings
{
    protected $startDate;
    protected $endDate;
    protected $paymentStatus;

    public function __construct($startDate, $endDate, $paymentStatus)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->paymentStatus = $paymentStatus;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // return Order::all();
        // Gunakan $this->startDate, $this->endDate, dan $this->paymentStatus untuk mengambil data yang sesuai dari database
        $query = Order::query();
        if ($this->startDate != null && $this->endDate != null) {
            $startDate = date('Y-m-d', strtotime($this->startDate)) . " 00:00:01";
            $endDate = date('Y-m-d', strtotime($this->endDate)) . " 23:59:00";
            $query = $query->whereBetween('created_at', [$startDate, $endDate]);
        }


        if ($this->paymentStatus !== 'semua') {
            $query->where('payment_status', $this->paymentStatus);
        }

        $invoiceId = $query->pluck('id');

        $row['products'] = DB::table('invoice_products')->join('active_products', 'active_products.id', 'invoice_products.active_product_id')
            ->select(
                'invoice_products.id',
                'invoices.created_at',
                'invoices.invoice_number',
                'active_products.active_product_name',
                'invoice_products.qty',
                'invoice_products.price',
            )
            ->join('invoices', 'invoices.id', 'invoice_products.invoice_id')
            ->whereIn('invoice_products.invoice_id', $invoiceId)
            ->where('invoice_products.deleted_at', null)
            ->get();

        foreach ($row['products'] as $key => $value) {
            $variant = DB::table('invoice_product_variants')
                ->join('variants', 'variants.id', 'invoice_product_variants.variant_id')
                ->where('invoice_product_variants.invoice_product_variants', $value->id)
                ->select('variants.varian_name')
                ->first();
            $row['products'][$key]->varian_name = $variant ? $variant->varian_name : '';
            $toppings = DB::table('invoice_product_toppings')
                ->join('toppings', 'toppings.id', 'invoice_product_toppings.topping_id')
                ->where('invoice_product_toppings.invoice_product_id', $value->id)
                ->select('toppings.topping_name')
                ->get();
            $topping_text = "";
            foreach ($toppings as $k => $v) {
                $topping_text = $topping_text . $v->topping_name . ", ";
            }
            $row['products'][$key]->topping_text = $topping_text;
        }

        return $row['products'];
        // return $data;
        // return $query->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Tanggal Beli',
            'Nomor Invoice',
            'Nama Produk',
            'Qty',
            'Harga',
            'Varian',
            'Topping',
            // Add more headings as needed
        ];
    }
}
