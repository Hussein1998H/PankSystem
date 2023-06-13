<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $guarded=[];
    protected $fillable = [
        'branch_id',
        'firstName',
        'ID_number',
        'lastName',
        'gender',
        'image',
        'address',
        'email',
        'phone',
        'role',
        'DateOfHiring',
        'email_verified_at',
        'phone_verified_at',
        'password',
    ];
    //    public function trans():HasMany
//    {
//        return $this->hasMany(Transaction::class,'user_id');
//    }
//
    public function branch():BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }
    public function withdraws():HasMany
    {
        return $this->hasMany(Withdraw::class,'user_id');
    }

    public function deposits():HasMany
    {
        return $this->hasMany(Deposit::class,'user_id');
    }
//
//    public function roles():BelongsToMany
//    {
//        return $this->belongsToMany(Role::class,'user_role');
//    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
