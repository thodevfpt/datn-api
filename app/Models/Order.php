<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'orders';
    public $fillable = [
        'user_id',
        'voucher_id',
        'shipper_id',
        'order_process_id',
        'total_price',
        'customer_name',
        'customer_phone',
        'customer_address',
        'customer_note',
        'transportation_costs',
        'payments',
        'shop_confirm',
        'shipper_confirm',
        'shop_note',
        'cancel_note',
    ];
    public function order_details()
    {
        return $this->hasMany(OrderDetail::class, 'order_id');
    }
}
