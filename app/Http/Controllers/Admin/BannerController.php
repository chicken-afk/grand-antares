<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::withCount('products')->with('productList')->get();
        // dd($banners);
        return view('main.banner', compact('banners'));
    }

    public function add()
    {
        $row['products'] = DB::table('active_products')->where('deleted_at', null)->where('is_active', 1)->select('id', 'active_product_name as product_name', 'sku')->get();
        return view('main.add-banner', compact('row'));
    }

    public function store(Request $request)
    {
        // dd($request);
        $imageName = "null";
        $image = $request->file('product_image');
        // Mengganti spasi dengan underscores
        $imageName = str_replace(' ', '_', $request->banner_name);

        // Menghapus karakter non-alfanumerik
        $imageName = preg_replace('/[^A-Za-z0-9_]/', '', $imageName);

        // Mengubah nama menjadi huruf kecil
        $imageName = strtolower($imageName) . "_" . auth()->user()->id . ".jpg";

        $image->storeAs('public/images/banners', $imageName);
        $imageName = "storage/images/banners/" . $imageName;
        $banner = Banner::create([
            'name' => $request->banner_name,
            'banner_image' => $imageName
        ]);
        if ($request->product_id != null) {
            foreach ($request->product_id as $value) {
                $banner->products()->create([
                    'product_id' => (int) $value
                ]);
            }
        }
        alert('Success', 'Berhasil Menambahkan banner', 'success');
        return redirect()->back();
    }

    public function delete($id)
    {
        $banner = Banner::findOrFail($id);
        $banner->is_active = 0;
        $banner->deleted_at = date('Y-m-d H:i:s');
        $banner->save();
        alert('Success', 'Berhasil Menghapus banner', 'success');
        return redirect()->back();
    }

    public function updateStatus($id)
    {
        $banner = Banner::findOrFail($id);
        $status = $banner->is_active == 0 ? 1 : 0;
        $banner->is_active = $status;
        $banner->save();
        alert('Success', 'Berhasil merubah status banner', 'success');
        return redirect()->back();
    }
}
