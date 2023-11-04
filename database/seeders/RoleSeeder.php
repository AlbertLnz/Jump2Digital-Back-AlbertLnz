<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role1 = Role::create(['name' => 'admin']);
        $role2 = Role::create(['name' => 'client']);

        // General Routes
        Permission::create(['name' => 'api.skins.available']);

        // Client Routes
        Permission::create(['name' => 'api.skins.buy'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'api.skins.myskins'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'api.skins.updateColor'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'api.skin.delete'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'api.skins.readOne'])->syncRoles([$role1, $role2]);

        // Admin Route
        Permission::create(['name' => 'api.skins.read'])->assignRole($role1);
        Permission::create(['name' => 'api.skins.create'])->assignRole($role1);
        Permission::create(['name' => 'api.skins.update'])->assignRole($role1);
        Permission::create(['name' => 'api.skins.delete'])->assignRole($role1);
    }
}
