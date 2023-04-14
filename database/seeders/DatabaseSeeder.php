<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('stores')->insert([
            'title' => 'My Store 1',
            'address' => 'Gota Ahmedabad',
            'latitude' => 23.1008572,
            'longitude' => 72.5229621,
        ]);

        DB::table('stores')->insert([
            'title' => 'My Store 2',
            'address' => 'Satellite Ahmedabad',
            'latitude' => 23.0304725,
            'longitude' => 72.4805246,
        ]);

        DB::table('stores')->insert([
            'title' => 'My Store 3',
            'address' => 'Vastral Ahmedabad',
            'latitude' => 22.9975926,
            'longitude' => 72.6532378,
        ]);

        DB::table('stores')->insert([
            'title' => 'My Store 4',
            'address' => 'Narol Ahmedabad',
            'latitude' => 22.9616366,
            'longitude' => 72.564075,
        ]);

        DB::table('stores')->insert([
            'title' => 'My Store 5',
            'address' => 'Kalupur Ahmedabad',
            'latitude' => 23.0288057,
            'longitude' => 72.5899423,
        ]);
    }
}
