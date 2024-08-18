<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=1; $i<20; $i++) {
            User::factory()->create([
                'email' => 'user'.$i.'@sample.com',
                'password' => bcrypt('user'.$i),
            ]);
        }
    }
}
