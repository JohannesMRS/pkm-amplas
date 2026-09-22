<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email'=>'admin@laundry.com'],
            [
                'name'=>'Admin',
                'password'=>Hash::make('johannes123'),
                'phone'=>'081266254708',
                'address'=>'jl.suluh',
                'role'=>'admin',
                'email_verified_at'=>now(),
            ],
        );
    }
}
