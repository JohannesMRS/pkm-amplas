<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email'=>'customer@laundry.com'],
            [
                'name'=>'Budi',
                'password'=>Hash::make('budi123'),
                'phone'=>'082164310500',
                'address'=>'jl.pelita',
                'role'=>'customer',
                'email_verified_at'=>now(),
            ],
        );
    }
}
