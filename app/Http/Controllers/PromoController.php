<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Variant;

class PromoController extends Controller
{
    public function index()
    {
        $row['datas'] = DB::table('active_products')->whereNull('deleted_at')->where('is_promo', 1)->get();
        foreach ($row['datas'] as $key => $value) {
            $varian = DB::table('variants')->where('master_product_id', $value->id)->select('varian_name', 'varian_price', 'varian_price_restaurant', 'varian_promo', 'varian_promo_restaurant')->get();
            $items = DB::table('active_product_items')->where('active_product_items.master_product_id', $value->id)->join('active_products', 'active_products.id', 'active_product_items.active_product_id')
                ->select('active_products.active_product_name', 'active_products.sku', 'active_product_items.qty')->get();


            $row['datas'][$key]->varian = $varian;
            $row['datas'][$key]->product_items = $items;
        }
        return view('main.promo', compact('row'));
    }

    public function searchProduk(Request $request)
    {
        $data = Product::with('variants')->where('active_product_name', 'like', "%$request->search%")->where('is_promo', 0)->limit(9)->get();
        return $data;
    }

    public function storePromo(Request $request)
    {

        $product = Product::findOrFail($request->id);
        if ($request->bannerPromo != null) {
            $image = $request->file('bannerPromo');
            $imageName = time() . '_' . auth()->user()->id . ".jpg";
            $image->storeAs('public/images/bannerpromo', $imageName);
            $imageName = "/storage/images/bannerpromo/" . $imageName;
            $product->banner_promo = $imageName;
        }
        $product->price_promo = $request->harga_promo_kamar;
        $product->price_promo_restaurant = $request->harga_promo_restaurant;
        $product->is_promo = 1;
        $product->save();

        if ($request->has('variant')) {
            foreach ($request->variant as $index => $v) {
                Variant::where('id', $index)->update([
                    'varian_promo' => $v['harga_promo_kamar'],
                    'varian_promo_restaurant' => $v['harga_promo_restaurant']
                ]);
            }
        }
        alert('Success', 'Berhasil Menambah Promo', 'success');
        return redirect()->back();
    }

    public function detailProduct($id)
    {
        return Product::where('id', $id)->with('variants')->first();
    }

    public function delete($id)
    {
        Product::where('id', $id)->update([
            'is_promo' => 0,
            'price_promo' => null,
            'price_promo_restaurant' => null,
            'banner_promo' => null
        ]);

        Variant::where('master_product_id', $id)->update([
            'varian_promo' => null,
            'varian_promo_restaurant' => null
        ]);
        alert('Success', 'Berhasil Menghapus Promo', 'success');
        return redirect()->back();
    }
}
