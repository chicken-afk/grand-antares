<?php

namespace App\Http\Controllers;

use App\Models\Kritik;
use App\Models\Order;
use Illuminate\Http\Request;

class KritikController extends Controller
{
    public function store(Request $request)
    {
        $kritik = Kritik::create(['order_id' => $request->order_id, 'kritik' => $request->kritik]);
        // alert('Berhasil', 'Berhasil menyampaikan kritik dan saran', 'success');
        Order::where('id', $request->order_id)->update(['is_kritik' => 1]);
        return redirect()->back();
    }

    public function indexAdmin()
    {
        $row['datas'] = Kritik::with('order')->orderBy('id', 'desc')->paginate(10);


        return view('main.kritik', compact('row'));
    }
}
