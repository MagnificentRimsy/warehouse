<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class expense extends Model
{
	protected $primaryKey = 'exid';


	public function items()
	{
		return $this->hasMany(item::class, 'exid');

	}

}
