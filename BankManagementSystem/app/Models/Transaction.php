<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable=[
       'account_from_id',
        'account_to_id',
       'trans_date',
       'balance',
        'type',
        'description',
        'account_id'
        ];
//    public function users():BelongsTo
//    {
//        return $this->belongsTo(User::class);
//    }
    public function account():BelongsTo
    {
        return $this->belongsTo(Account::class);
    }
}
