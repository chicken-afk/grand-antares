<?php

namespace App\Http\Controllers;

use App\Repositories\Repository\OrderRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use PDF;

use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{

    public function index(Request $request, OrderRepository $orderRepository)
    {
        if ($request->has('invoice')) {
            $row = $orderRepository->detail($request->invoice);
            return response()->json([
                'status_code' => 200,
                'data' => $row
            ]);
        }

        $cashier = DB::table('roles')->where('role_name', 'cashier')->first();

        return view('main.order', compact('cashier'));
    }

    public function orderData(Request $request, OrderRepository $orderRepository)
    {
        $query = $request->query();
        $invoice = $orderRepository->all($query);
        return response()->json([
            'status_code' => 200,
            'data' => $invoice
        ]);
    }

    public function payment(Request $request, OrderRepository $orderRepository)
    {

        $res = $orderRepository->payment($request->all());

        return response()->json([
            'status_code' => 200,
            'message' => 'payment success',
            'payment_method' => $request->payment_method,
            'payment_change' => $request->payment_change,
            'invoice_link' => $res['invoice_link']
        ]);
    }

    public function liveOrder(OrderRepository $orderRepository)
    {
        $datas = $orderRepository->liveOrder();
        return view('main.live-order', compact('datas'));
    }

    public function liveOrderData(OrderRepository $orderRepository)
    {
        $datas = $orderRepository->liveOrder();

        return response()->json([
            'status_code' => 200,
            'datas' =>  $datas,
            'total_data' => $datas->count(),
            'user_id' => Auth::user()->id
        ]);
    }

    public function editStatus(Request $request, OrderRepository $orderRepository)
    {
        if (auth()->user()->role_id != 1 && $request->order_status == 'dibatalkan') {
            return response()->json([
                'status_code' => 401,
                'message' => 'Gagal merubah status'
            ]);
        }
        $orderRepository->editStatus($request->all());
        return response()->json([
            'status_code' => 200,
            'message' => 'berhasil merubah status',
            'order_status' => $request->order_status,
            'invoice' => $request->invoice
        ]);
    }

    public function deleteProductInvoice($id, OrderRepository $orderRepository)
    {
        $data = $orderRepository->deleteProduct($id);
        return response()->json([
            'status_code' => 200,
            'message' => 'Success Delete Product',
            'payment_charge' => (int) $data['price'] + (int) $data['tax'],
            'invoice_number' => $data['invoice_number']
        ], 200);
    }

    public function getInvoices(Request $request, OrderRepository $orderRepository)
    {
        $data = $orderRepository->getInvoice($request->all());
        return response()->json([
            'status_code' => 200,
            'data' => $data['data'],
            'invoices' => $data['invoices'],
        ]);
    }

    public function paymentTable(Request $request, OrderRepository $orderRepository)
    {
        // $data = collect($request->data);
        // $invoices = collect($request->invoices);
        // /**Check Payment Money > Payment Charge */

        // /**End Check */

        // /**Generate Data For Invoices */
        // $invoiceId = DB::table('invoice_users')->insertGetId([
        //     'user_id' => Auth::id(),
        //     'no_table' => $data['no_table'],
        //     'payment_charge' => (int) $data['payment_charge'],
        //     'tax' => ((int) $data['payment_charge'] / 1.1) * 0.1,
        //     'charge_before_tax' => (int) $data['payment_charge'] / 1.1,
        //     'created_at' => now()
        // ]);

        // /** Change Invoices Payment status to true */
        // $i = 0;
        // $product = array();
        // foreach ($invoices as $key => $value) {
        //     $name = $value['name'];
        //     DB::table('invoices')->where('invoice_number', $value['invoice_number'])->update([
        //         'payment_method' => $data['payment_method'],
        //         'payment_change' => $data['payment_change'],
        //         'payment_at' => now(),
        //         'payment_status' => 1,
        //         'order_status' => 'selesai'
        //     ]);

        //     DB::table('invoice_user_invoices')->insert([
        //         'invoice_user_id' => $invoiceId,
        //         'invoice_number' => $value['invoice_number'],
        //         'created_at' => now()
        //     ]);

        //     /**Get Products List */
        //     foreach ($value['products'] as $k => $v) {
        //         $product[$i] =    array(
        //             'product_name' => $v['active_product_name'] . " " . $v['varian_name'] . " " . $v['topping_text'],
        //             'product_qty' => $v['qty'],
        //             'total_price' => $v['price']
        //         );
        //         $i++;
        //     }
        // }

        // /**Create Invoice */
        // $row['invoice_number'] = "INVC" . time();
        // $row['name'] = $name;
        // $row['no_table'] = $data['no_table'];
        // $row['payment_charge'] = $data['payment_charge'];
        // $row['sub_total'] = $data['payment_charge'] / 1.1;;
        // $row['tax'] = $row['sub_total'] * 0.1;
        // $row['products'] = $product;

        // view()->share('row', $row);
        // $pdf = PDF::loadView('invoices.invoice_print_satuan', $row)->setPaper([0, 0, 685.98, 215.772], 'landscape');
        // $content = $pdf->download()->getOriginalContent();
        // $name = \Str::random(20);
        // Storage::disk('public')->put("invoices/$name.pdf", $content);

        // /**insert Invoice PDF */
        // DB::table('invoice_users')->where('id', $invoiceId)->update([
        //     'invoice_pdf' => "/storage/invoices/$name.pdf",
        //     'updated_at' => now()
        // ]);
        $invoice = $orderRepository->paymentTable($request->data, $request->invoices);
        return $invoice;

        return response()->json([
            'status_code' => 200,
            'message' => 'Pembayaran Berhasil',
            'invoice_link' => $invoice
        ]);

        // return response()->json([
        //     'status_code' => 200,
        //     'message' => 'Pembayaran Berhasil',
        //     'invoice_link' => "/storage/invoices/$name.pdf"
        // ]);
    }
}
