<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Loan extends Model
{
    use HasFactory;

    protected $fillable=['customer_id',
        'branch_id',
        'balance',
        'type',
        'description',
        'loan_date',
        'return_date',];

        public function customer():BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
    public function branch():BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }
}
