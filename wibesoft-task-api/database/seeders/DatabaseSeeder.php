<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Permission::create(['name' => 'add tasks']);
        Permission::create(['name' => 'update tasks']);
        Permission::create(['name' => 'delete tasks']);
    
        // Roller tanımla
        $adminRole = Role::create(['name' => 'Admin']);
        $adminRole->givePermissionTo(['add tasks', 'update tasks', 'delete tasks']);

        $this->call(UserSeeder::class);
        $this->call(AdminSeeder::class);

    }
}
