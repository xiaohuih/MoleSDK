<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'currency',
        'amount',
        'game_id',
        'user_id',
        'product_id',
        'product_name',
        'cp_order_id',
        'callback_url',
        'callback_info',
    ];
}
