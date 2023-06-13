<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Customer::create([
            'firstName'=>'customer1',
            'lastName'=>'customer1',
            'gender'=>'maale',
            'address'=>'hazzano',
            'email'=>'customer1@gmail.com',
            'phone'=>'0960919254',
            'registrationDate'=>now(),
            'password'=>Hash::make('123456789'),
        ]);
        Customer::create([
            'firstName'=>'customer2',
            'lastName'=>'customer2',
            'gender'=>'maale',
            'address'=>'syria',
            'email'=>'customer2@gmail.com',
            'phone'=>'0999462635',
            'registrationDate'=>now(),
            'password'=>Hash::make('123456789'),
        ]);
    }
}
