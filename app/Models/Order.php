<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory;use SoftDeletes;
    protected $table='orders';
    public $fillable=[
        'user_id',
        'status',
        'total_price',
        'customer_note',
        'customer_name',
        'customer_phone',
        'customer_address',
    ];
    public function order_details(){
        return $this->hasMany(OrderDetail::class,'order_id');
     }
}
