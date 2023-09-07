<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PaymentMethod;
use Illuminate\Support\Facades\DB;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data =  [
            "cash/tunai",
            "kartu debit",
            "ovo",
            "QRIS",
            "GOPAY"
        ];
        DB::table('payment_methods')->whereNotNull('id')->delete();

        foreach ($data as $value) {
            PaymentMethod::create([
                'payment_method' => $value
            ]);
        }
    }
}
