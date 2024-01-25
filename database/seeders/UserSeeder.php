<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Model::unguard();
        $userArray = [
            [
                'full_name' => 'Admin',
                'user_name' => 'adminOffice',
                'email' => 'admin@gmail.com',
                'mobile_number' => '9876543211',
                'email_verified_at' => '2022-05-23 00:00:00',
                'password' => Hash::make('admin@123'),
                'role' => 'admin',
                'status' => 'active',
            ],
            [
                'full_name' => 'Employee',
                'user_name' => 'employeeOffice',
                'email' => 'employee@gmail.com',
                'mobile_number' => '9876543212',
                'email_verified_at' => '2022-05-23 00:00:00',
                'password' => Hash::make('employee@123'),
                'role' => 'employee',
                'status' => 'active',
            ],
        ];
        User::insert(
            $userArray
        );
    }
}
