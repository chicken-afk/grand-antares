<?php

namespace App\Repositories\Repository;

use App\Repositories\OrderInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use PDF;
use App\Exceptions\CustomException;
use Illuminate\Support\Facades\Storage;

class OrderRepository implements OrderInterface
{
    public function detail(string $invoice)
    {
        $invoice = DB::table('invoices')->where('invoice_number', $invoice)->first();
        $row['invoice'] = $invoice;
        $row['products'] = DB::table('invoice_products')->join('active_products', 'active_products.id', 'invoice_products.active_product_id')
            ->select('invoice_products.id', 'invoice_products.qty', 'invoice_products.price', 'invoice_products.active_product_id', 'active_products.active_product_name', 'active_products.product_image')
            ->where('invoice_products.invoice_id', $invoice->id)
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

        return $row;
    }

    public function all(array $query)
    {
        $payment_status = [0, 1];
        $search = "";
        if (isset($query['query']['generalSearch'])) {
            $search = $query['query']['generalSearch'];
        }
        if (isset($query['query']['payment_status'])) {
            $payment_status = $query['query']['payment_status'] == '1' ? [1] : [0];
        }
        if (Auth::user()->role_id == 3) {
            $invoice = DB::table('invoices')->where('invoices.company_id', Auth::user()->company_id)
                ->select('invoices.id', 'invoices.payment_method', 'invoices.type', 'invoices.keterangan', 'invoice_users.invoice_pdf', 'invoices.invoice_number', 'invoices.payment_charge', 'invoices.name', 'invoices.nomor_kamar', 'invoices.order_at', 'invoices.payment_status', 'invoices.payment_at', 'invoices.order_status')
                ->orderByDesc('invoices.id')
                ->whereIn('invoices.payment_status', $payment_status)
                ->where('invoice_outlets.outlet_id', Auth::user()->outlet_id)
                ->join('invoice_outlets', 'invoice_outlets.invoice_id', 'invoices.id')
                ->leftJoin('invoice_user_invoices', 'invoice_user_invoices.invoice_number', 'invoices.invoice_number')
                ->leftJoin('invoice_users', 'invoice_users.id', 'invoice_user_invoices.invoice_user_id')
                ->groupBy('invoices.id')
                ->where(function ($query) use ($search) {
                    $query->where('invoices.invoice_number', "LIKE", "%" . $search . "%")
                        ->orWhere('invoices.name', "LIKE", "%" . $search . "%")
                        ->orWhere('invoices.no_table', "LIKE", "%" . $search . "%");
                })
                ->get();
        } else {
            $invoice = DB::table('invoices')->where('company_id', Auth::user()->company_id)
                ->select('invoices.id', 'invoices.payment_method', 'invoices.type', 'invoices.keterangan', 'invoice_users.invoice_pdf', 'invoices.invoice_number', 'invoices.payment_charge', 'invoices.name', 'invoices.nomor_kamar', 'invoices.order_at', 'invoices.payment_status', 'invoices.payment_at', 'invoices.order_status')
                ->orderByDesc('invoices.id')
                ->whereIn('invoices.payment_status', $payment_status)
                ->leftJoin('invoice_user_invoices', 'invoice_user_invoices.invoice_number', 'invoices.invoice_number')
                ->leftJoin('invoice_users', 'invoice_users.id', 'invoice_user_invoices.invoice_user_id')
                ->groupBy('invoices.id')
                ->where(function ($query) use ($search) {
                    $query->where('invoices.invoice_number', "LIKE", "%" . $search . "%")
                        ->orWhere('invoices.name', "LIKE", "%" . $search . "%")
                        ->orWhere('invoices.no_table', "LIKE", "%" . $search . "%");
                })
                ->get();
        }

        return $invoice;
    }

    public function payment(array $data)
    {
        $request = $data;
        $invoice = DB::table('invoices')->where('invoice_number', $request['invoice'])->first();

        /**
         * Invoice Not Found
         */
        if (!$invoice) throw new CustomException("Invoice not Found", 404);

        /**
         * Update Payment
         */
        DB::table('invoices')->where('invoice_number', $request['invoice'])->update([
            'payment_method' => $request['payment_method'],
            'payment_change' => $request['payment_change'],
            'payment_at' => now(),
            'payment_status' => 1,
            'order_status' => 'selesai'
        ]);

        /**Change All Order Proses to selesai */
        DB::table('invoice_outlets')->where('invoice_id', $invoice->id)->update([
            'order_status' => 'selesai',
            'updated_at' => now()
        ]);

        /**Generate Data For Invoices pdf */
        $invoiceId = DB::table('invoice_users')->insertGetId([
            'user_id' => Auth::id(),
            'no_table' => $invoice->no_table,
            'payment_charge' => (int) $invoice->payment_charge,
            'tax' => ((int) $invoice->payment_charge / 1.1) * 0.1,
            'charge_before_tax' => (int) $invoice->payment_charge / 1.1,
            'created_at' => now()
        ]);

        DB::table('invoice_user_invoices')->insert([
            'invoice_user_id' => $invoiceId,
            'invoice_number' => $request['invoice'],
            'created_at' => now()
        ]);

        $row['invoice'] = $invoice;
        $row['products'] = DB::table('invoice_products')->join('active_products', 'active_products.id', 'invoice_products.active_product_id')
            ->select('invoice_products.id', 'invoice_products.qty', 'invoice_products.price', 'invoice_products.active_product_id', 'active_products.active_product_name', 'active_products.product_image')
            ->where('invoice_products.invoice_id', $invoice->id)
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
            $row['products'][$key]->active_product_name = $row['products'][$key]->active_product_name . " " . $row['products'][$key]->varian_name . " " . $topping_text;
        }
        /**Create Invoice PDF */
        $row['invoice_number'] = "INVC" . time();
        $row['name'] = $invoice->name;
        $row['no_table'] = $invoice->no_table;
        $row['payment_charge'] = $invoice->payment_charge;
        $row['sub_total'] = $invoice->charge_before_tax;
        $row['tax'] = $invoice->tax;

        /**Rubah menjadi Array */
        $row = json_decode(json_encode($row), true);
        /**Generate PDF Invoice */
        view()->share('row', $row);
        $pdf = PDF::loadView('invoices.invoice_print', $row)->setPaper([0, 0, 685.98, 215.772], 'landscape');
        $content = $pdf->download()->getOriginalContent();
        $name = \Str::random(20);
        Storage::disk('public')->put("invoices/$name.pdf", $content);

        /**insert Invoice PDF */
        DB::table('invoice_users')->where('id', $invoiceId)->update([
            'invoice_pdf' => "/storage/invoices/$name.pdf",
            'updated_at' => now()
        ]);

        $res['invoice_link'] = "/storage/invoices/$name.pdf";

        return $res;
    }

    public function liveOrder()
    {
        if (Auth::user()->role_id == 3) {
            $datas = DB::table('invoices')
                ->join('invoice_outlets', 'invoice_outlets.invoice_id', 'invoices.id')
                ->where('invoices.order_status', '!=', 'selesai')
                ->where('invoice_outlets.order_status', '!=', 'selesai')
                ->orderBy('invoices.id', 'asc')
                ->where('invoice_outlets.outlet_id', Auth::user()->outlet_id)
                ->select('invoices.*', 'invoice_outlets.order_status as status_pemesanan')->get();
        } else {
            $datas = DB::table('invoices')->where('order_status', '!=', 'selesai')->select('invoices.*', 'invoices.order_status as status_pemesanan')->orderBy('id', 'asc')->get();
        }

        foreach ($datas as $p => $q) {
            $invoice = $q;
            if (Auth::user()->role_id == 3) {
                $row['products'] = DB::table('invoice_products')
                    ->join('active_products', 'active_products.id', 'invoice_products.active_product_id')
                    ->join('outlets', 'outlets.id', 'active_products.outlet_id')
                    ->where('invoice_products.invoice_id', $invoice->id)
                    ->where('active_products.outlet_id', Auth::user()->outlet_id)
                    ->where('invoice_products.deleted_at', null)
                    ->select('outlets.id as outlet_id', 'outlets.outlet_name', 'invoice_products.id', 'invoice_products.qty', 'invoice_products.price', 'invoice_products.active_product_id', 'active_products.active_product_name')
                    ->get();
            } else {
                $row['products'] = DB::table('invoice_products')
                    ->join('active_products', 'active_products.id', 'invoice_products.active_product_id')
                    ->join('outlets', 'outlets.id', 'active_products.outlet_id')
                    ->select('outlets.id as outlet_id', 'outlets.outlet_name', 'invoice_products.id', 'invoice_products.qty', 'invoice_products.price', 'invoice_products.active_product_id', 'active_products.active_product_name')
                    ->where('invoice_products.invoice_id', $invoice->id)
                    ->where('invoice_products.deleted_at', null)
                    ->get();
            }

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
            $datas[$p]->products = $row['products'];
        }
        return $datas;
    }

    public function editStatus(array $data)
    {
        $invoice = DB::table('invoices')->where('invoice_number', $data['invoice'])->first();
        $user = DB::table('users')->where('id', auth()->user()->id)->first();
        DB::table('invoices')->where('invoice_number', $data['invoice'])->update([
            'order_status' => $data['order_status'],
            'updated_at' => now()
        ]);

        return true;
    }

    public function deleteProduct(int $id)
    {
        $product = DB::table('invoice_products')->where('id', $id)->first();

        /**product Not found */
        if (!$product) throw new CustomException("product not found", 404);


        DB::table('invoice_products')->where('id', $id)->update([
            'deleted_at' => now()
        ]);

        //Generate New Total Price//
        $price = 0;
        $listProduct = DB::table('invoice_products')->where('invoice_id', $product->invoice_id)->where('deleted_at', null)->get();
        foreach ($listProduct as $value) {
            $price += $value->qty * $value->price;
        }
        $tax = $price * config("appsetting.tax") / 100;
        DB::table('invoices')->where('id', $product->invoice_id)->update([
            'tax' => $tax,
            'payment_charge' => $price + $tax,
            'charge_before_tax' => $price,
            'updated_at' => now()
        ]);

        $invoice = DB::table('invoices')->where('id', $product->invoice_id)->first();

        $data = array("price" => $price, "tax" => $tax, "invoice_number" => $invoice->invoice_number);

        return $data;
    }

    public function getInvoice(array $data)
    {

        if (!isset($data['no_table'])) throw new CustomException("No table wajib di isi", 422);

        $data['payment_charge'] = DB::table('invoices')->where('payment_status', 0)->where('no_table', $data['no_table'])->sum('payment_charge');
        $data['name'] = DB::table('invoices')->where('payment_status', 0)->where('no_table', $data['no_table'])->select('name')->pluck('name');
        $data['no_table'] = $data['no_table'];

        $invoices = DB::table('invoices')->where('payment_status', 0)->where('no_table', $data['no_table'])->get();
        foreach ($invoices as $index => $invoice) {
            $row['products'] = DB::table('invoice_products')->join('active_products', 'active_products.id', 'invoice_products.active_product_id')
                ->select('invoice_products.id', 'invoice_products.notes', 'invoice_products.qty', 'invoice_products.price', 'invoice_products.active_product_id', 'active_products.active_product_name', 'active_products.product_image')
                ->where('invoice_products.invoice_id', $invoice->id)
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
            $invoices[$index]->products = $row['products'];
        }

        $datas = array("data" => $data, "invoices" => $invoices);

        return $datas;
    }

    public function paymentTable(array $data, array $invoices)
    {

        /**Generate Data For Invoices */
        $invoiceId = DB::table('invoice_users')->insertGetId([
            'user_id' => Auth::id(),
            'no_table' => $data['no_table'],
            'payment_charge' => (int) $data['payment_charge'],
            'tax' => ((int) $data['payment_charge'] / 1.1) * 0.1,
            'charge_before_tax' => (int) $data['payment_charge'] / 1.1,
            'created_at' => now()
        ]);

        /** Change Invoices Payment status to true */
        $i = 0;
        $product = array();
        foreach ($invoices as $key => $value) {
            $name = $value['name'];
            DB::table('invoices')->where('invoice_number', $value['invoice_number'])->update([
                'payment_method' => $data['payment_method'],
                'payment_change' => $data['payment_change'],
                'payment_at' => now(),
                'payment_status' => 1,
                'order_status' => 'selesai'
            ]);

            DB::table('invoice_user_invoices')->insert([
                'invoice_user_id' => $invoiceId,
                'invoice_number' => $value['invoice_number'],
                'created_at' => now()
            ]);

            /**Get Products List */
            foreach ($value['products'] as $k => $v) {
                $product[$i] =    array(
                    'active_product_name' => $v['active_product_name'] . " " . $v['varian_name'] . " " . $v['topping_text'],
                    'qty' => $v['qty'],
                    'price' => $v['price'],
                    'notes' => $v['notes']
                );
                $i++;
            }
        }

        /**Create Invoice */
        $row['invoice_number'] = "INVC" . time();
        $row['name'] = $name;
        $row['no_table'] = $data['no_table'];
        $row['payment_charge'] = $data['payment_charge'];
        $row['sub_total'] = $data['payment_charge'] / 1.1;;
        $row['tax'] = $row['sub_total'] * 0.1;
        $row['products'] = $product;

        view()->share('row', $row);
        $pdf = PDF::loadView('invoices.invoice_print', $row)->setPaper([0, 0, 685.98, 215.772], 'landscape');
        $content = $pdf->download()->getOriginalContent();
        $name = \Str::random(20);
        Storage::disk('public')->put("invoices/$name.pdf", $content);

        /**insert Invoice PDF */
        DB::table('invoice_users')->where('id', $invoiceId)->update([
            'invoice_pdf' => "/storage/invoices/$name.pdf",
            'updated_at' => now()
        ]);

        return "/storage/invoices/$name.pdf";
    }
}
