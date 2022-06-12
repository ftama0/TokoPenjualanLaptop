<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{ 
    public function user()
	{
	      return $this->belongsTo('App\models\User','user_id', 'id');
	}

	public function pesanan_detail() 
	{
	     return $this->hasMany('App\models\PesananDetail','pesanan_id', 'id');
	}
}
