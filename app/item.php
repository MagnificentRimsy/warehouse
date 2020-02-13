<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class item extends Model
{
	protected $primaryKey = 'itid';


	public function expense()
	{
		return $this->belongsTo(expense::class, 'exid');
	}

}
