<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'name' => 'hoge',
            'email' => 'hogehoge@gmail.com', 'password' => bcrypt('hoge'), 'favorite' => '[1, 2]'
        ];
        DB::table('users')->insert($param);
    }
}
