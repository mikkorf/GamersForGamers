<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class NewsPostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(mt_rand(2,8)), //default 6 kata
            'slug' => $this->faker->slug(),
            'excerpt' => $this->faker->paragraph(), //default 3 kalimat
            // 'body' => '<p>' . implode('</p><p>',$this->faker->paragraphs(mt_rand(5,10)) . '</p>', // random 5-10 paragraf
            'body' => collect($this->faker->paragraphs(mt_rand(5,10)))
                        ->map(fn($p) => "<p>$p</p>")
                        ->implode(''),
            'user_id' => mt_rand(1,5),
            'category_id' => mt_rand(1,5)
        ];
    }
}