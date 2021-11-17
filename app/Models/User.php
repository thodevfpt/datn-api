<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use SoftDeletes;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $table = 'users';
    public $fillable = [
        'user_name',
        'email',
        'password',
        'avatar'
    ];

    public function info_user()
    {
        return $this->hasMany(InfoUser::class, 'user_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'carts', 'user_id', 'product_id')->withPivot('quantity');
    }

    public function carts()
    {
        return $this->hasMany(Cart::class, 'user_id');
    }

    public function vouchers()
    {
        return $this->belongsToMany(Vouchers::class, 'voucher_users', 'user_id', 'voucher_id');
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function setPasswordAttribute($value)
    {
        $hashed = bcrypt($value);
        $this->attributes['password'] = $hashed;
    }
}
