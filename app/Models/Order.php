<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'customer_email',
        'order_products',
        'order_products_id',
        'order_products_quantity',
        'order_products_price',
        'total_price',
        'wefarm_tx_ref',
        'flw_tx_id',
        'flw_tx_ref',
        'order_status'
    ];
}