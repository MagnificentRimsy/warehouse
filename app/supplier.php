<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class supplier extends Model
{
    protected $primaryKey = 'sid';

	public function Products() {
		return $this->hasMany(product::class,'sid','sid');
    }
}
