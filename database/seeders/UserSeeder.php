<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!DB::table('users')->where('email', 'superadmin@grandantares.com')->first()) {
            DB::table('users')->insert([
                'company_id' => 1,
                'role_id' => 1,
                'name' => 'superadmin',
                'email' => 'superadmin@grandantares.com',
                'password' => bcrypt('superadmin2023'),
                'is_superadmin' => 1,
                'created_at' => now(),
                'is_active' => 1
            ]);
        }
    }
}
