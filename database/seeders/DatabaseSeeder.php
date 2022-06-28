<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
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
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@email.com',
            'password' => bcrypt('password'),
            'role' => 'admin'
        ]);

        DB::table('plans')->insert(
            [
                'name' => 'Basic',
                'price' => 14,
                'bookings' => 1
            ],
            [
                'name' => 'Premium',
                'price' => 50,
                'bookings' => 4
            ]
        );
    }

}
