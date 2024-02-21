<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $createuser = User::create([
            'name' => 'Nur Koç',
            'email' => 'nur@email.com',
            'is_admin'=> '1',
            'password' => Hash::make('123'),
            'email_verified_at' => now(),
        ]);

       
    }
}
