<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function search(Request $request)
    {
        return Order::where('invoice_number', $request->invoice_number)->first();
    }
}
