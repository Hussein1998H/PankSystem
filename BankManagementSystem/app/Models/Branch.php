<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Branch extends Model
{
    use HasFactory;
    protected $fillable=[
        'address',
        'phone',];
    public function users():HasMany
    {
        return $this->hasMany(User::class,'branch_id');
    }
    public function accounts():HasMany
    {
        return $this->hasMany(Account::class,'branch_id');
    }

    public function loans():HasMany
    {
        return $this->hasMany(Loan::class,'branch_id');
    }
}
