<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        // consults_types
        DB::table('consultations')->insert([
            'name' => 'Medical consultations'
        ]);
        DB::table('consultations')->insert([
            'name' => 'Professional consulting'
        ]);
        DB::table('consultations')->insert([
            'name' => 'Psychological counseling'
        ]);
        DB::table('consultations')->insert([
            'name' => 'Family counseling'
        ]);
        DB::table('consultations')->insert([
            'name' => 'Business consulting'
        ]);
    }
}
