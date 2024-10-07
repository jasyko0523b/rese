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

        for($i= 0; $i< count($shops) -3; $i++){
            Review::factory(10)->create([
                'shop_id' => $shops[$i]->id,
            ]);
        }
    }
}
