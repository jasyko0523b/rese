<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AreasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('areas')->insert(['name' => '東京都']);
        DB::table('areas')->insert(['name' => '大阪府']);
        DB::table('areas')->insert(['name' => '福岡県']);
    }
}
