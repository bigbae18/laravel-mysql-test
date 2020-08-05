<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
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
        DB::table('users')->insert([[
            'name' => Str::random(10),
            'surname' => Str::random(12),
            'email' => Str::random(8) . '@outlook.com',
            'phone' => mt_rand(111111111, 999999999),
            'password' => Hash::make('password')
        ],
        [
            'name' => Str::random(10),
            'surname' => Str::random(12),
            'email' => Str::random(8) . '@gmail.com',
            'phone' => mt_rand(111111111, 999999999),
            'password' => Hash::make('password')
        ],
        [
            'name' => Str::random(10),
            'surname' => Str::random(12),
            'email' => Str::random(8) . '@outlook.es',
            'phone' => mt_rand(111111111, 999999999),
            'password' => Hash::make('password')
        ],
        [
            'name' => Str::random(10),
            'surname' => Str::random(12),
            'email' => Str::random(8) . '@outlook.com',
            'phone' => mt_rand(111111111, 999999999),
            'password' => Hash::make('password')
        ]]);
    }
}
