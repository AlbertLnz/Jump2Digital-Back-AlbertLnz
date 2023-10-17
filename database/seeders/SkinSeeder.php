<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SkinModel;

class SkinSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SkinModel::create([
            "name" => "Rex",
            "types" => json_encode(["Dinosaur", "Human"]),
            "price" => 1200,
            "color" => "Green",
            "category" => "Outfit",
            "design_pattern" => "Scales",
            "rarity" => "Legendary",
        ]);
        SkinModel::create([
            "name" => "Dark Bomber",
            "types" => json_encode(["Human"]),
            "price" => 1500,
            "color" => "Purple",
            "category" => "Outfit",
            "design_pattern" => "Dark Lightning",
            "rarity" => "Epic",
        ]);
    }
}
