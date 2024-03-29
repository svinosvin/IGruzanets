<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $guard = 'user';
    protected $table = 'users';

    protected $guarded = false;

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function company(){
        return $this->belongsTo(Company::class);
    }

    public function orders(){
        return $this->hasMany(Order::class, 'user_id', 'id');
    }
    public function getNewOrdersAttribute(){
        $orders = $this->orders()->orderBy("order_at", "desc")->get();
        return $orders;
    }

    public function reviews(){
        return $this->hasMany(Review::class);
    }
}
