<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Skin;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class SkinSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for($i=0 ; $i<1000 ; $i++){
            Skin::create([
                "name" => "Rex",
                "types" => json_encode(["Dinosaur", "Human"]),
                "price" => 1200,
                "color" => "Green",
                "category" => "Outfit",
                "design_pattern" => "Scales",
                "rarity" => "Legendary",
                "stock" => rand(0, 100),
            ]);

            DB::table('skin_user')->insert([
                "user_id" => intval(User::inRandomOrder()->first()->id),
                'skin_id' => intval(Skin::latest()->first()->id),
            ]);
        }
    }
}
