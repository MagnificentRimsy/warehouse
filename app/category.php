<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class category extends Model
{
    protected $primaryKey = 'catid';
    public $table = 'categories';

	public function Products() {
		return $this->hasMany(product::class,'catid','catid');
    }
}
