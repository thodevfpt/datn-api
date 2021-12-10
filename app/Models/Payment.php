<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $table='payments';
    public $fillable=[
        'order_id',
        'paymentID',
        'transID',
        'amount',
        'resultCode',
        'message',
        'payType',
        'orderInfo',
        'requestType',
    ];
}
