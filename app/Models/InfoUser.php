<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InfoUser extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table='info_users';
    protected $primarykey='id';
    protected $fillable=[
        'user_id',
        'phone',
        'address',
        'birthday',
        'gender',
    ];
}
