<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Role::factory()->create([
            'role_name' => 'admin', 
        ]);

        User::factory()->create([
            'first_name' => 'Sopanha', 
            'last_name' => 'Leavchum', 
            'gender' => 'Male', 
            'phone' => '085286538', 
            'email' => 'leavchumsopanha@gmail.com', 
            'password' => 'admin@123',
            'profile_picture' => 'https://shorturl.at/fUW38', 
            'role_id' => '1'
        ]);
    }
}
