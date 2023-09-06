<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SubCategory;
use Illuminate\Support\Facades\DB;

class SubCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = ['Dingin', 'Panas'];

        if (SubCategory::count() == 0) {
            $minuman = DB::table('categories')->where('category_name', 'minuman')->first();
            if ($minuman) {
                foreach ($data as $v) {
                    SubCategory::create([
                        'category_id' => $minuman->id,
                        'sub_category_name' => $v
                    ]);
                }
            }
        }
    }
}
