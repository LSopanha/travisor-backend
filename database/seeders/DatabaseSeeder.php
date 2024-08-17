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
            'username' => 'panha', 
            'gender' => 'Male', 
            'phone' => '085286538', 
            'email' => 'leavchumsopanha@gmail.com', 
            'password' => 'admin@123',
            'profile_picture' => 'https://media.licdn.com/dms/image/D5603AQGt-IShA7RBVA/profile-displayphoto-shrink_800_800/0/1718490460401?e=1729728000&v=beta&t=Dvgda8ZohXvEzIv_5RAsNH45z_kBeona63i00oB9QsU', 
            'role_id' => '1'
        ]);
    }
}
