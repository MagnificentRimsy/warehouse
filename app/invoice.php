<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class invoice extends Model
{
	protected $primaryKey = 'invid';

	public function Client() {
		return $this->belongsTo('App\client','clid');
	}

	public function Details() {
		return $this->hasMany('App\invoice_detail','invid');
	}

	public function Receipts() {
		return $this->hasMany('App\receipt','invid');
	}

	public function Staff()
	{
		return $this->belongsTo('App\User','uid','uid');
	}

}
