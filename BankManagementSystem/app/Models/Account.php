<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Account extends Model
{
    use HasFactory;

    protected $fillable=[
        'customer_id',
        'branch_id',
        'accountNumber',
//        'balance',
        'openingDate',
        'type',
        'isActive',
    ];

        public function customer():BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
    public function branch():BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }
    public function transachs():HasMany
    {
        return $this->hasMany(Transaction::class,'account_id');
    }

    public function withdraws():HasMany
    {
        return $this->hasMany(Withdraw::class,'account_id');
    }

    public function deposits():HasMany
    {
        return $this->hasMany(Deposit::class,'account_id');
    }
    public function accmonies():HasMany{
            return $this->hasMany(Acc_money::class,'acc_id');
    }
//    public function transacs():HasMany
//    {
//        return $this->hasMany(Transaction::class,'account_to_id');
//    }
//    public function account_type():BelongsTo
//    {
//        return $this->belongsTo()
//    }
}
