<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Customer extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded=[];
    protected $fillable = [
        'firstName',
        'lastName',
        'ID_number',
        'gender',
        'image',
        'address',
        'email',
        'phone',
        'role',
        'registrationDate',
        'email_verified_at',
        'phone_verified_at',
        'password',
    ];

    public function accounts():HasMany
    {
        return $this->hasMany(Account::class,'customer_id');
    }

    public function loans():HasMany
    {
        return $this->hasMany(Loan::class,'customer_id');
    }
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
