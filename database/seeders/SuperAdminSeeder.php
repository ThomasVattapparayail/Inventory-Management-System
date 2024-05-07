<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class SuperAdminSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'first_name' => 'Super',
            'last_name' => 'Admin',
            'dob' => '1990-01-01', 
            'email' => 'superadmin@gmail.com',
            'mobile' => '954407052', 
            'address' => 'Address 1',
            'state' => 'kerala',
            'city' => 'wayanad',
            'pincode' => '123456', 
            'username' => 'superadmin',
            'password' => bcrypt('password'), 
            'role' => 'super_admin',
        ]);
    }
}
