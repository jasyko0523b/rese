<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Shop;
use App\Models\User;

class ReservationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'shop_id' => Shop::inRandomOrder()->first()->id,
            'user_id' => User::inRandomOrder()->first()->id,
            'date' => date('Y-m-d H:i:s', strtotime($this->faker->dateTimeBetween('1day', '+1 week')->format('Y-m-d') . ' ' . $this->faker->numberBetween(17, 20) . ':00')),
            'number' => $this->faker->numberBetween(1,6),
        ];
    }
}
