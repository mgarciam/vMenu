<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FoodOrders extends Model
{	
	protected $table = "food_orders";
    protected $fillable = ['food_id', 'order_id', 'quantity'];
}
