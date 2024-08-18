<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Review;
use App\Models\Shop;

class ReviewsTableSeeder extends Seeder
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
            Review::factory(10)->create([
                'shop_id' => $shop->id,
            ]);
        }
    }
}
