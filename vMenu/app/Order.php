<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
	protected $fillable = ['guest_id', 'total'];

    public function guest() {
    	return $this->belongsTo('App\Guest');
    }

    public function foods() {
    	return $this->belongsToMany('App\Food');
    }
}
