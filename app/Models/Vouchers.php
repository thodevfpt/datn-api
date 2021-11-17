<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vouchers extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table='vouchers';
    public $fillable=[
        'classify_voucher_id',
        'title',
        'code',
        'sale',
        'customer_type',
        'condition',
        'expiration',
        'active',
        'planning',
        'times',
        'start_day',
        'end_day'
    ];
}
