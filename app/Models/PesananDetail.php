<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PesananDetail extends Model
{
    public function barang()
	{
	      return $this->belongsTo('App\models\Barang','barang_id', 'id');
	}

	public function pesanan() 
	{
	     return $this->belongsTo('App\models\Pesanan','pesanan_id', 'id');
	}
}
