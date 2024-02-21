<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            $createuser = Admin::create([
            'name' => 'Nur Koç',
            'email' => 'admin@gmail.com',
            'is_admin'=> '1',
            'password' => Hash::make('admin'),
        ]);
    }
}
