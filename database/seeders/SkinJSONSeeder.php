<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Skin;

class SkinJSONSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jsonContent = file_get_contents(database_path('skins.json'));
        $skins = json_decode($jsonContent, true);

        foreach ($skins as $skin) {
            Skin::create([
                "name" => $skin['name'],
                "types" =>  json_encode($skin['types']),
                "price" => $skin['price'],
                "color" => $skin['color'],
                "category" => $skin['category'],
                "design_pattern" => $skin['design_pattern'],
                "rarity" => $skin['rarity'],
                "bought" => false,
            ]);
        }
    }
}
