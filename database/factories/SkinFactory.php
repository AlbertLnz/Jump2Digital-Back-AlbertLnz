<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Skin>
 */
class SkinFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "name" => "Rex",
            "types" => json_encode(["Dinosaur", "Human"]),
            "price" => 1200,
            "color" => "Green",
            "category" => "Outfit",
            "design_pattern" => "Scales",
            "rarity" => "Legendary",
        ];
    }
}
