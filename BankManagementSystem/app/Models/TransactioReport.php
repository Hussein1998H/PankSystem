<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactioReport extends Model
{
    use HasFactory;

    protected $fillable=[
        'FromCustomer',
        'ToCustomer',
        'AccountNumberFrom',
        'AccountNumberTo',
        'trans_date',
        'balance',
        'description',
    ];
}
