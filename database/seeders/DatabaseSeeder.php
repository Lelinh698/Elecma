<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        DB::table('admins')->insert([
            ['username'=>'lequanglinh', 'password'=>bcrypt('123456789')],
            ['username'=>'abcd', 'password'=>bcrypt('987654321')],
        ]);

        DB::table('departments')->insert([
            ['name'=>'Chi nhánh Hai Bà Trưng', 'address'=>'Hai Bà Trưng'],
            ['name'=>'Chi nhánh Hồ Hoàn Kiếm', 'address'=>'Hồ Hoàn Kiếm'],
            ['name'=>'Chi nhánh Thanh Xuân', 'address'=>'Thanh Xuân'],
        ]);

        DB::table('electricity_prices')->insert([
            ['from_number'=>'0', 'to_number'=>'50', 'price'=>'1678'],
            ['from_number'=>'51', 'to_number'=>'100', 'price'=>'1734'],
            ['from_number'=>'101', 'to_number'=>'200', 'price'=>'2014'],
            ['from_number'=>'201', 'to_number'=>'300', 'price'=>'2536'],
            ['from_number'=>'301', 'to_number'=>'400', 'price'=>'2834'],
            ['from_number'=>'401', 'to_number'=>'9999', 'price'=>'2927'],
        ]);

        $this->call(CustomerSeeder::class);
    }
}
