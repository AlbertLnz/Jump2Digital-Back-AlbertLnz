<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RoleSeeder::class); // assing roles
        $this->call(UserSeeder::class); // create an admin 
        User::factory(9)->create(); // create 9 clients
        // $this->call(SkinSeeder::class); // generate 1000 same skins
        $this->call(SkinJSONSeeder::class); // import JSON data of skins into my database
    }
}
