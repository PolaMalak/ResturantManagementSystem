<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrdersData extends Model
{
    public function user(){
    return $this->belongsTo('App\User');
	}
}
