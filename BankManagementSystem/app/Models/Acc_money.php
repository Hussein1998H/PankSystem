<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Acc_money extends Model
{
    use HasFactory;
    protected $table='acc_monies';
    protected $fillable=[
        'acc_id',
        'money_id',
        'balance' ,
    ];
    public function account():BelongsTo{
        return $this->belongsTo(Account::class);
    }
    public function money():BelongsTo{
        return $this->belongsTo(mony::class);
    }
}
