<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class receipt extends Model
{
	protected $primaryKey = 'recid';


	public function Invoice() {
		return $this->hasOne(sales::class,'salid','salid');
	}

	public function Staff()
	{
		return $this->belongsTo('App\User','uid','uid');
	}

}
