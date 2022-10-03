<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Estate>
 */
class EstateFactory extends Factory
{


    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "title" => fake()->title,
            "deal_type" => fake()->numberBetween(1 ,3),
            "address" => fake()->address(),
            "image" => fake()->url(),
            "url" => fake()->url() ,
            "published" => fake()->dateTime(),
            "description" => fake()->text(),
            "description_full" => fake()->randomHtml(),
            "float" => fake()->randomFloat(2 , 10 , 1000),
            "float_total" => fake()->randomFloat(2 , 10 , 1000),
            "total_area" => fake()->randomFloat(2,  10 , 1000),
            "year" => fake()->numberBetween(1900 , 2000),
            "price" => fake()->randomFloat(2 , 10 , 1000),
            "price_per_m" => fake()->randomFloat(2 , 10 , 1000),
        ];
    }
}
