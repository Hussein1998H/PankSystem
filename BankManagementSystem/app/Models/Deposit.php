<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Deposit extends Model
{
    use HasFactory;


    protected $fillable=[
        'account_id',
        'user_id',
        'balance',
        'type',
        'deposit_date',
    ];
    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function account():BelongsTo
    {
        return $this->belongsTo(Account::class);
    }
}
