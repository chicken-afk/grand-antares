<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserProductController extends Controller
{
    public function index(Request $request)
    {
        $code = $request->code;
        if ($request->has('sub_category_id')) {
            if ($code == config('appsetting.restaurant_code')) {
                $q =  DB::table('active_products')
                    ->where('category_id', $request->category_id)
                    ->where('active_products.deleted_at', null)
                    ->where(function ($query) {
                        $query->where('active_products.price_display_restaurant', '!=', 0)->orWhere('price_display_restaurant', '!=', NULL);
                    });
                if ($request->sub_category_id != 'semua') {
                    $q = $q->where('active_products.sub_category_id', $request->sub_category_id);
                }

                $products = $q->select('active_products.*', 'active_products.price_display_restaurant as price_display', 'price_promo_restaurant as price_promo')
                    ->get();
                foreach ($products as $k => $v) {
                    $products[$k]->toppings = DB::table('toppings')->where('master_product_id', $v->id)->where('deleted_at', null)->select('toppings.*', 'toppings.topping_price_restaurant as topping_price')->get();
                    $products[$k]->varians = DB::table('variants')->where('master_product_id', $v->id)->where('deleted_at', null)->select('variants.*', 'varian_price_restaurant as varian_price', 'varian_promo_restaurant as varian_promo')->get();
                }
            } elseif ($code == config('appsetting.room_code')) {
                $q =  DB::table('active_products')
                    ->where('category_id', $request->category_id)
                    ->where('active_products.deleted_at', null)
                    ->where(function ($query) {
                        $query->where('active_products.price_display', '!=', 0)->orWhere('price_display', '!=', NULL);
                    });
                if ($request->sub_category_id != 'semua') {
                    $q = $q->where('active_products.sub_category_id', $request->sub_category_id);
                }
                $products = $q->select('active_products.*')
                    ->get();
                foreach ($products as $k => $v) {
                    $products[$k]->toppings = DB::table('toppings')->where('master_product_id', $v->id)->where('deleted_at', null)->select('toppings.*', 'toppings.topping_price_restaurant as topping_price')->get();
                    $products[$k]->varians = DB::table('variants')->where('master_product_id', $v->id)->where('deleted_at', null)->select('variants.*', 'varian_price_restaurant as varian_price', 'varian_promo_restaurant as varian_promo')->get();
                }
            } else {
                abort(404);
            }

            if ($products->count() == 0) {
                return "<p class='text-center'>Produk Kosong</p>";
            }
            return view('partials.users.fillter-sub-category', compact('products'))->render();
        }
    }
}
