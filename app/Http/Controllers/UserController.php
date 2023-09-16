<?php

namespace App\Http\Controllers;

use App\Models\Csnumber;
use App\Models\Ipaddress;
use App\Models\PaymentMethod;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use PDF;
use App\Models\Banner;
use App\Models\BannerProduct;
use App\Models\Order;

class UserController extends Controller
{

    protected $company_id;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->company_id = 1;

            return $next($request);
        });
    }

    public function dashboard($code)
    {
        if ($code == config('appsetting.restaurant_code')) {
            $row['type'] = "restaurant";
        } elseif ($code == config('appsetting.room_code')) {
            $row['type'] = "room";
        } else {
            abort(404);
        }
        $row['categories'] = DB::table('categories')->where('is_active', 1)->get();
        $row['code'] = $code;
        $row['banners'] = Product::where('is_promo', 1)->whereNotNull('banner_promo')->select('id', 'uuid', 'banner_promo', 'active_product_name')->get();
        $row['slide_banners'] = Banner::active()->withCount('products')->get();
        $row['customer_services'] = Csnumber::where('is_active', 1)->get();
        return view('users.tamu', compact('row'));
    }

    public function view($code, Request $request)
    {
        $row['category_id'] = $request->has('category_id') ? $request->category_id : "semua";
        $query = DB::table('categories')->where('is_active', 1);
        /**Fillter */
        if ($request->has('category_id')) {
            $query = $request->category_id != 'promo' ? $query->where('id', $request->category_id) : $query;
        }
        /**End Fillter */
        $row['categories'] = $query->get();

        if ($code == config('appsetting.restaurant_code')) {
            foreach ($row['categories'] as $key => $value) {
                $q =  DB::table('active_products')
                    ->where('active_products.deleted_at', null)
                    ->where(function ($query) {
                        $query->where('active_products.price_display_restaurant', '!=', 0)->orWhere('price_display_restaurant', '!=', NULL);
                    })
                    ->where('active_products.category_id', $value->id)
                    ->select('active_products.*', 'active_products.price_display_restaurant as price_display', 'price_promo_restaurant as price_promo');
                if ($request->has('banner_id')) {
                    $productIdList = BannerProduct::where('banner_id', $request->banner_id)->pluck('product_id');
                    $q = $q->whereIn('active_products.id', $productIdList);
                    $row['banner_name'] = Banner::find($request->banner_id)->name;
                } else {
                    $q = $request->has('category_id') ? ($request->category_id == 'promo' ? $q->where('active_products.is_promo', 1) : $q) : $q;
                }
                $row['categories'][$key]->products = $q->get();
                foreach ($row['categories'][$key]->products as $k => $v) {
                    $row['categories'][$key]->products[$k]->toppings = DB::table('toppings')->where('master_product_id', $v->id)->where('deleted_at', null)->select('toppings.*', 'toppings.topping_price_restaurant as topping_price')->get();
                    $row['categories'][$key]->products[$k]->varians = DB::table('variants')->where('master_product_id', $v->id)->where('deleted_at', null)->select('variants.*', 'varian_price_restaurant as varian_price', 'varian_promo_restaurant as varian_promo')->get();
                }
            }
        } elseif ($code == config('appsetting.room_code')) {
            foreach ($row['categories'] as $key => $value) {
                $q = DB::table('active_products')
                    ->where('active_products.deleted_at', null)
                    ->where(function ($query) {
                        $query->where('active_products.price_display', '!=', 0)
                            ->orWhere('price_display', '!=', NULL);
                    })
                    ->where('active_products.category_id', $value->id)
                    ->select('active_products.*');
                if ($request->has('banner_id')) {
                    $productIdList = BannerProduct::where('banner_id', $request->banner_id)->pluck('product_id');
                    $q = $q->whereIn('active_products.id', $productIdList);
                    $row['banner_name'] = Banner::find($request->banner_id)->name;
                } else {
                    $q = $request->has('category_id') ? ($request->category_id == 'promo' ? $q->where('active_products.is_promo', 1) : $q) : $q;
                }
                $row['categories'][$key]->products = $q->get();
                foreach ($row['categories'][$key]->products as $k => $v) {
                    $row['categories'][$key]->products[$k]->toppings = DB::table('toppings')->where('master_product_id', $v->id)->where('deleted_at', null)->get();
                    $row['categories'][$key]->products[$k]->varians = DB::table('variants')->where('master_product_id', $v->id)->where('deleted_at', null)->get();
                }
            }
        } else {
            abort(404);
        }
        $row['cat'] = DB::table('categories')->where('is_active', 1)->whereNull('deleted_at')->get();
        $row['code'] = $code;
        $row['customer_services'] = Csnumber::where('is_active', 1)->get();
        $row['banners'] = Banner::active()->whereHas('products')->get();
        return view('users.dashboard', compact('row'));
    }

    public function viewBanner(Request $request)
    {
        dd('sinii');
    }

    public function carts($code)
    {
        $row['payment_methods'] = PaymentMethod::select('payment_method')->get();
        return view('users.cart', compact('code', 'row'));
    }

    public function storeCart(Request $request)
    {
        // Validation

        if ($request->code != config("appsetting.restaurant_code") && $request->code != config("appsetting.room_code")) {
            return response()->json([
                'status_code' => 422,
                'message' => 'Kode Salah Beda',
                'code' => $request->code,
            ], 422);
        }
        // End Validation

        /**
         * Store Data Invoice
         */
        $totalPrice = $this->validatePrice($request);
        if ($totalPrice == false) {
            return response()->json([
                'status_code' => 422,
                'message' => 'Harga Beda'
            ], 422);
        }

        /** End Get Total Price */

        $invoiceToday = DB::table('invoices')->whereDate('created_at', Carbon::today())->count();
        $invoice_code = $invoiceToday + 1;
        $invoice = strtoupper(Str::random(5)) . $invoice_code;
        /**Generate Tax */
        $tax = $totalPrice * config("appsetting.tax") / 100;
        $pwithoutTax = $totalPrice;
        $totalPrice = $pwithoutTax + $tax;
        $type = $request->code == config("appsetting.restaurant_code") ? "restaurant" : ($request->code == config("appsetting.room_code") ? "kamar" : "");
        /**End Generate Tax */
        $invoiceId = DB::table('invoices')->insertGetId([
            'qr_code_id' => 0,
            'type' => $type,
            'invoice_number' => $invoice,
            'company_id' => 1,
            'invoice_code' => $invoice_code,
            'whatsapp' => $request->whatsapp,
            'name' => $request->nama_pemesan,
            'keterangan' => $request->keterangan,
            'nomor_kamar' => $request->nomor_kamar,
            'payment_method' => $request->payment_method,
            'started_at' => now(),
            'order_at' => now(),
            'tax' => $tax,
            'charge_before_tax' => $pwithoutTax,
            'payment_charge' => $totalPrice,
            'created_at' => now(),
        ]);
        $outlets = array();
        $j = 0;
        foreach ($request->carts as $p => $q) {
            $q = collect($q);
            $product = DB::table('active_products')->where('uuid', $q['uuid'])->first();


            /**End insert invoice Outlets */

            $invoiceProductid = DB::table('invoice_products')->insertGetId([
                'invoice_id' => $invoiceId,
                'active_product_id' => $product->id,
                'qty' => $q['qty'],
                'notes' => $q['note'],
                'created_at' => now(),
                'price' => $q['price']
            ]);
            if ($q->has('varian_id')) {
                DB::table('invoice_product_variants')->insert([
                    'invoice_product_variants' => $invoiceProductid,
                    'active_product_id' => $product->id,
                    'variant_id' => $q['varian_id'],
                    'price' => $q['varian_price'],
                    'created_at' => now()
                ]);
            }
            if ($q->has('toppings')) {
                foreach ($q["toppings"] as $i => $j) {
                    DB::table('invoice_product_toppings')->insert([
                        'invoice_product_id' => $invoiceProductid,
                        'active_product_id' => $product->id,
                        'topping_id' => $j['topping_id'],
                        'price' => $j['topping_price'],
                        'created_at' => now()
                    ]);
                }
            }
        }


        return response()->json([
            'status_code' => 200,
            'invoice' => $invoice,
            'invoice_code' => $invoice_code
        ]);
    }

    public function invoice($code, Request $request)
    {
        if (!$request->has('invoice')) {
            abort(404);
        }

        $invoice = DB::table('invoices')->where('invoice_number', $request->invoice)->first();
        if (!$invoice) {
            abort(404);
        }


        $row['invoice'] = $invoice;

        $row['products'] = DB::table('invoice_products')->join('active_products', 'active_products.id', 'invoice_products.active_product_id')
            ->select('invoice_products.id', 'invoice_products.notes', 'invoice_products.qty', 'invoice_products.price', 'invoice_products.active_product_id', 'active_products.active_product_name')
            ->where('invoice_products.invoice_id', $invoice->id)
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

        $row['code'] = $code;

        // dd($row);
        return view('users.invoice', compact('row'));
    }

    /**
     * Function to validate if price from form input equals to on database
     */
    public function validatePrice($request)
    {
        $totalPrice = 0;
        if ($request->code == config("appsetting.restaurant_code")) {
            foreach ($request->carts as $key => $value) {
                $value = collect($value);
                $priceItem = 0;
                $product = DB::table('active_products')->where('uuid', $value['uuid'])->first();
                if ($value->has('varian_id')) {
                    $variants = DB::table('variants')->where('id', $value['varian_id'])->first();
                    if ($product->is_promo == 0) {
                        $priceItem += $variants->varian_price_restaurant;
                    } else {
                        $priceItem += $variants->varian_promo_restaurant;
                    }
                } else {
                    if ($product->is_promo == 0) {
                        $priceItem += $product->price_display_restaurant;
                    } else {
                        $priceItem += $product->price_promo_restaurant;
                    }
                }
                /**Get Price Toppings */
                if ($value->has('toppings')) {
                    foreach ($value['toppings'] as $i => $v) {
                        $topping = DB::table('toppings')->where('id', $v['topping_id'])->first();
                        $priceItem += $topping->topping_price_restaurant;
                    }
                }
                $priceItem = $priceItem * $value['qty'];
                $totalPrice += $priceItem;
            }

            if ($totalPrice != $request->invoice_charge) {
                /**Price isnt equal */
                return false;
            }
        } elseif ($request->code == config("appsetting.room_code")) {
            foreach ($request->carts as $key => $value) {
                $value = collect($value);
                $priceItem = 0;
                $product = DB::table('active_products')->where('uuid', $value['uuid'])->first();
                if ($value->has('varian_id')) {
                    $variants = DB::table('variants')->where('id', $value['varian_id'])->first();
                    if ($product->is_promo == 0) {
                        $priceItem += $variants->varian_price;
                    } else {
                        $priceItem += $variants->varian_promo;
                    }
                } else {
                    if ($product->is_promo == 0) {
                        $priceItem += $product->price_display;
                    } else {
                        $priceItem += $product->price_promo;
                    }
                }
                /**Get Price Toppings */
                if ($value->has('toppings')) {
                    foreach ($value['toppings'] as $i => $v) {
                        $topping = DB::table('toppings')->where('id', $v['topping_id'])->first();
                        $priceItem += $topping->topping_price;
                    }
                }
                $priceItem = $priceItem * $value['qty'];
                $totalPrice += $priceItem;
            }

            if ($totalPrice != $request->invoice_charge) {
                /**Price isnt equal */
                return false;
            }
        } else {
            return false;
        }

        /**Price Equals */
        return $totalPrice;
    }
    public function wifiPage($code)
    {
        if ($code == config('appsetting.restaurant_code')) {
            $row['type'] = "restaurant";
        } elseif ($code == config('appsetting.room_code')) {
            $row['type'] = "room";
        } else {
            abort(404);
        }
        $row['code'] = $code;

        $wifi = Ipaddress::where('is_active', 1)->get();
        return view('users.wifi', compact('wifi', 'row'));
    }

    public function checkInvoices(Request $request)
    {
        $invoice = Order::where('invoice_number', $request->invoices)->first();
        // dd($invoice, $request->invoice);
        if (!$invoice) abort(404);
        $code = $invoice->type == 'kamar' ? config('appsetting.room_code') : config('appsetting.restaurant_code');
        return redirect()->route('invoice', ["code" => $code, "invoice" => $invoice->invoice_number]);
    }
}
