<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class mony extends Model
{
    use HasFactory;
    protected $fillable=[
      'type'
    ];


    public function moniesacc():HasMany{
        return $this->hasMany(Acc_money::class,'money_id');
    }
}
