<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!DB::table('roles')->first()) {
            $roles = ["superadmin", "cashier"];
            foreach ($roles as $key => $value) {
                DB::table('roles')->insert([
                    'id' => $key + 1,
                    'role_name' => $value,
                    'created_at' => now()
                ]);
            }
        }
    }
}
