<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Review;
use App\Models\User;

class ReviewFactory extends Factory
{

    protected $model = Review::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $maxNbChars = random_int(20,200);
        return [
            'shop_id' => $this->faker->numberBetween(1,20),
            'user_id' => User::inRandomOrder()->first()->id,
            'rank' => $this->faker->numberBetween(1,5),
            'comment' => $this->faker->realText($maxNbChars, 5),
        ];
    }
}
