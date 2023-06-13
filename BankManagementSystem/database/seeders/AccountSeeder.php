<?php

namespace Database\Seeders;

use App\Models\Account;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Account::create([
            'customer_id'=>1,
            'branch_id'=>1,
            'accountNumber'=>rand(000001, 999999),
            'balance'=>1000,
            'openingDate'=>now(),
            'type'=>'personal',
        ]);

        Account::create([
            'customer_id'=>2,
            'branch_id'=>2,
            'accountNumber'=>rand(000001, 999999),
            'balance'=>1000,
            'openingDate'=>now(),
            'type'=>'personal',
        ]);
    }
}
