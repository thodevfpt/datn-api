<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;use SoftDeletes;
    protected $table='products';
    public $fillable=[
        'cate_id',
        'name',
        'image',
        'price',
        'sale',
        'quantity',
        'desc_short',
        'description'
       
    ];

    // public function category(){
    //     return $this->belongsTo(Category::class,'cate_id');
    //  }
    
}
