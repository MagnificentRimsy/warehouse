<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class client extends Model
{
	protected $primaryKey = 'clid';

	public function Invoice() {
		return $this->hasMany(invoice::class,'clid','clid');
	}

	public function SalesRep()
	{
		return $this->belongsTo(salesrep::class,'srid','srid');
	}

	public function Staff()
	{
		return $this->belongsTo('App\User','uid','uid');
	}

}
