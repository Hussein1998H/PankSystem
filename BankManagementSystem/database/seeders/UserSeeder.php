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
    public function run(): void
    {
        //
        User::create([
            'branch_id'=>1,
            'firstName'=>'admin',
            'lastName'=>'admin',
            'gender'=>'male',
            'address'=>'syria',
            'email'=>'husseinhussein87@gmail.com',
            'phone'=>'00352681121031',
            'role'=>'admin',
            'DateOfHiring'=>now(),
            'password'=>Hash::make('123456789'),
        ]);
        User::create([
            'branch_id'=>2,
            'firstName'=>'user',
            'lastName'=>'user',
            'gender'=>'male',
            'address'=>'syria',
            'email'=>'kaheralahzan89@gmail.com',
            'phone'=>'+352681121031',
            'role'=>'user',
            'DateOfHiring'=>now(),
            'password'=>Hash::make('123456789'),
        ]);
    }
}
