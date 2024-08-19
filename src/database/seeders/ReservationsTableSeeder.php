<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Reservation;
use App\Models\Shop;

class ReservationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $shops = Shop::all();
        foreach($shops as $shop){
            Reservation::factory(10)->create([
                'shop_id' => $shop->id,
            ]);
        }
    }
}
