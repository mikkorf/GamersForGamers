<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewCommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'comment' => $this->faker->sentence(mt_rand(5,10)), //default 3 kalimat
            'user_id' => mt_rand(1,5),
            'reviewPost_id' => mt_rand(1,30),
        ];
    }
}
