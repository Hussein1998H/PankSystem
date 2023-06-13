<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Branch::create([
            'address'=>'edlib' ,
            'phone'=>'023999'
        ]);
        Branch::create([
            'address'=>'aleppo' ,
            'phone'=>'021888'
        ]);
    }
}
