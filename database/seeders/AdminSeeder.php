<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\User;

class AdminSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'first_name' => 'Admin',
            'last_name' => 'Admin',
            'dob' => '1990-01-01', 
            'email' => 'admin@gmail.com',
            'mobile' => '1204545620', 
            'address' => 'Address 2',
            'state' => 'kerala',
            'city' => 'wayanad',
            'pincode' => '123456', 
            'username' => 'admin',
            'password' => bcrypt('password'), 
            'role' => 'admin',
        ]);
    }
}