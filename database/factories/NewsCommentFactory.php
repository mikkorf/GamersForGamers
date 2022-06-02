<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class NewsCommentFactory extends Factory
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
            'newsPost_id' => mt_rand(1,30),
        ];
    }
}