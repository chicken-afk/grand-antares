<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $count = DB::table('categories')->count();
        $datas = array(
            array(
                "category_name" => "Makanan",
                "category_image" => "media/categories/food.svg"
            ),
            array(
                "category_name" => "Minuman",
                "category_image" => "media/categories/drink.svg"
            ),
            array(
                "category_name" => "Snack",
                "category_image" => "media/categories/snack.svg"
            )
        );
        if ($count == 0) {
            foreach ($datas as $value) {
                DB::table('categories')->insert([
                    'company_id' => 1,
                    'category_name' => $value['category_name'],
                    'category_image' => $value['category_image'],
                    'created_at' => now()
                ]);
            }
        }
    }
}
