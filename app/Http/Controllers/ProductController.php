<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use App\Services\RandomData;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    protected int $user_id;
    protected int $company_id;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user_id = Auth::id();
            $this->company_id = Auth::user()->company_id;

            return $next($request);
        });
    }

    public function index(RandomData $random, Request $request)
    {
        $row['datas'] = DB::table('active_products')->where('active_products.company_id', $this->company_id)
            ->join('categories', 'categories.id', 'active_products.category_id')
            ->leftJoin('sub_categories', 'sub_categories.id', 'active_products.sub_category_id')
            ->leftJoin('outlets', 'outlets.id', 'active_products.outlet_id')
            ->select('active_products.*', 'sub_categories.sub_category_name','categories.category_name', 'outlets.outlet_name')
            ->where('active_products.deleted_at', null)
            ->orderByDesc('active_products.id')
            ->get();
        // dd($row['datas']);

        foreach ($row['datas'] as $key => $value) {
            $varian = DB::table('variants')->where('master_product_id', $value->id)->select('varian_name', 'varian_price', 'varian_price_restaurant')->get();
            $toppings = DB::table('toppings')->where('master_product_id', $value->id)->select('topping_name', 'topping_price', 'topping_price_restaurant')->get();
            $items = DB::table('active_product_items')->where('active_product_items.master_product_id', $value->id)->join('active_products', 'active_products.id', 'active_product_items.active_product_id')
                ->select('active_products.active_product_name', 'active_products.sku', 'active_product_items.qty')->get();


            $row['datas'][$key]->varian = $varian;
            $row['datas'][$key]->topping = $toppings;
            $row['datas'][$key]->product_items = $items;
        }

        $row['categories'] = DB::table('categories')->where('company_id', $this->company_id)->select('id', 'category_name')->get();
        $row['sub_categories'] = DB::table('sub_categories')->select('id', 'sub_category_name')->get();
        $row['outlets'] = DB::table('outlets')->where('company_id', $this->company_id)->select('id', 'outlet_name')->get();
        // dd($row["datas"][0]->product_items[0]);

        // dd($row['datas']);
        return view('main.product', compact('row'));
    }

    public function deleteProduct($uuid)
    {
        // /For Testing only
        $product = DB::table('active_products')->where('uuid', $uuid)->first();
        if (!$product) {
            Alert::error('Success', 'Produk tidak ditemukan');
        } {
            DB::table('active_products')->where('uuid', $uuid)->update([
                'deleted_at' => now()
            ]);;
            DB::table('variants')->where('master_product_id', $product->id)->update([
                'deleted_at' => now()
            ]);;
            DB::table('toppings')->where('master_product_id', $product->id)->update([
                'deleted_at' => now()
            ]);;
        }

        Alert::success('Success', 'Berhasil Menghapus Product');

        return redirect()->back();
    }

    public function store(Request $request, RandomData $random)
    {
        // Validator disini nanti

        // End Validator
        $uuid = $random->uuid('active_products');
        $rSku = rand(10, 100);

        $imageL = "";
        $base64_image = $request->product_image;
        if (preg_match('/^data:image\/(\w+);base64,/', $base64_image)) {
            $data = substr($base64_image, strpos($base64_image, ',') + 1);

            $data = base64_decode($data);
            $imageL = "images/product/" . $uuid . ".png";
            Storage::disk('public')->put($imageL, $data);
        }

        $mProductId = DB::table('active_products')->insertGetid([
            'uuid' => $uuid,
            'is_bundle' => 0,
            'outlet_id' => $request->outlet_id,
            'category_id' => $request->category_id,
            'sub_category_id' => $request->sub_category_id,
            'active_product_name' => $request->productName,
            'product_image' => "storage/" . $imageL,
            "sku" => $request->productSKU . "::" . $rSku,
            'price_display' => $request->productPrice,
            'price_display_restaurant' => $request->productPriceRestaurant,
            'is_active' => 1,
            'is_available' => 1,
            'user_id' => $this->user_id,
            'company_id' => $this->company_id,
            'created_at' => now(),
            'description' => $request->productDescription,
        ]);

        // Insert Varian
        if ($request->has('varian')) {
            foreach ($request->varian as $value) {
                DB::table('variants')->insert([
                    'master_product_id' => $mProductId,
                    'user_id' => $this->user_id,
                    'varian_price' => $value["varian_price"],
                    'varian_price_restaurant' => $value["varian_price_restaurant"],
                    'varian_sku' => $value["varian_sku"] . "-" . $rSku,
                    'varian_name' => $value["varian_name"],
                    'varian_description' => 'null',
                    'varian_promo' => $value["varian_price"],
                    'created_at' => now()
                ]);
            }
        }
        // Insert Topping
        if ($request->has('topping')) {
            foreach ($request->topping as $value) {
                DB::table('toppings')->insert([
                    'topping_name' => $value["topping_name"],
                    'topping_price' => $value["topping_price"],
                    'topping_price_restaurant' => $value["topping_price_restaurant"],
                    'created_at' => now(),
                    'master_product_id' => $mProductId,
                ]);
            }
        }

        return response()->json([
            'status_code' => 200,
            'message' => "Berhasil Menambahkan Data"
        ], 200);
    }

    public function addProductPage()
    {
        $row['categories'] = DB::table('categories')->where('is_active', 1)->select('id', 'category_name')->get();
        $row['outlets'] = DB::table('outlets')->where('is_active', 1)->select('id', 'outlet_name')->get();
        return view('main.add-data-product', compact('row'));
    }

    public function editStock($uuid)
    {
        $pAvail = DB::table('active_products')->where('uuid', $uuid)->first()->is_available;
        $isAvail = $pAvail == 0 ? 1 : 0;
        DB::table('active_products')->where('uuid', $uuid)->update([
            'is_available' => $isAvail,
            'updated_at' => now()
        ]);
        Alert::success('Success', 'Berhasil Merubah Stock');
        return redirect()->back();
    }

    public function createBundlePage()
    {
        $row['categories'] = DB::table('categories')->where('is_active', 1)->select('id', 'category_name')->get();
        $row['outlets'] = DB::table('outlets')->where('is_active', 1)->select('id', 'outlet_name')->get();
        $row['products'] = DB::table('active_products')->where('deleted_at', null)->where('is_bundle', 0)->select('id', 'active_product_name as product_name', 'sku')->get();
        return view('main.add-bundle-product', compact('row'));
    }

    public function storeBundle(Request $request, RandomData $random)
    {
        // dd($request);
        $uuid = $random->uuid('active_products');
        $rSku = rand(10, 100);

        $base64_image = $request->base64_image;
        if (preg_match('/^data:image\/(\w+);base64,/', $base64_image)) {
            $data = substr($base64_image, strpos($base64_image, ',') + 1);

            $data = base64_decode($data);
            $imageL = "images/product/" . $uuid . ".png";
            Storage::disk('public')->put($imageL, $data);
        }

        $mProductId = DB::table('active_products')->insertGetid([
            'uuid' => $uuid,
            'is_bundle' => 1,
            'outlet_id' => $request->outlet,
            'category_id' => $request->category,
            'active_product_name' => $request->product_name,
            'product_image' => "storage/" . $imageL,
            "sku" => $request->sku . "::" . $rSku,
            'price_display' => $request->price_display,
            'is_active' => 1,
            'is_available' => 1,
            'user_id' => $this->user_id,
            'company_id' => $this->company_id,
            'created_at' => now(),
            'description' => $request->description,
        ]);

        // Active Product Items
        if ($request->product_id != null) {
            foreach ($request->product_id as $key => $value) {
                DB::table('active_product_items')->insert([
                    'master_product_id' => $mProductId,
                    'active_product_id' => $value,
                    'qty' => $request->qty[$key],
                    'created_at' => now()
                ]);
            }
            Alert::success('Sukses', "Berhasil Membuat Bundle $request->product_name");
            return redirect()->route('getProduct');
        } else {
            Alert::error('Gagal', 'Minimal 1 produk item di isi');
            return redirect()->back();
        }
    }

    public function editPageProduct($id)
    {
        $row['categories'] = DB::table('categories')->where('is_active', 1)->select('id', 'category_name')->get();
        $row['sub_categories'] = DB::table('sub_categories')->select('id', 'sub_category_name')->get();
        $row['product'] = DB::table('active_products')->where('id', $id)->first();
        $row['varians'] = DB::table('variants')->where('master_product_id', $id)->get();
        $row['toppings'] = DB::table('toppings')->where('master_product_id', $id)->get();
        return view('main.edit-product', compact('row'));
    }

    public function postEditProduct(Request $request)
    {
        // dd($request);
        $product = DB::table('active_products')->where('id', $request->id)->first();
        if($product)
        {
            $imageName = $product->product_image;
            if($request->file('product_image')){
                $image = $request->file('product_image');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->storeAs('public/images/products', $imageName);
                $imageName = "storage/images/products/" . $imageName;
            }
            DB::table('active_products')->where('id', $request->id)->update([
                'active_product_name' => $request->product_name,
                'product_image' => $imageName,
                'price_display' => (int) $request->price_display,
                'price_display_restaurant' => (int) $request->price_display_restaurant,
                'description' => $request->description,
                'category_id' => (int) $request->category,
                'sub_category_id' => $request->subCategoryId,
                'updated_at' => now()
            ]);
            DB::table('variants')->where('master_product_id', $request->id)->delete();
            if($request->has('varian_name'))
            {
                foreach($request->varian_name as $i => $v)
                {
                    $rSku = rand(10, 100);
                    DB::table('variants')->insert([
                        'varian_name' => $v,
                        'varian_sku' => $product->sku."::$rSku",
                        'varian_price' => $request->varian_price[$i],
                        'varian_price_restaurant' => $request->varian_price_restaurant[$i],
                        'master_product_id' => $request->id,
                        'user_id' => auth()->user()->id,
                        'created_at' => now()
                    ]);
                }
            }
            if($request->has('topping_name')) {
                DB::table('toppings')->where('master_product_id', $request->id)->delete();
                foreach($request->topping_name as $i => $v)
                {
                    DB::table('toppings')->insert([
                        'topping_name' => $v,
                        'topping_price' => $request->topping_price[$i],
                        'topping_price_restaurant' => $request->topping_price_restaurant[$i],
                        'master_product_id' => $request->id,
                        'created_at' => now()
                    ]);
                }
            }
            Alert::success('Success', 'Berhasil Merubah Produk');
            return redirect()->back();
        } else {
            Alert::error('Gagal', 'Produk tidak ditemukan');
            return redirect()->back();
        }

    }
}
