<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class salesrep extends Model
{
    protected $primaryKey = 'srid';
    public $table = 'salesreps';
	protected $guarded = ['_token'];

	public function Clients() {
		return $this->hasMany(client::class,'srid','srid');
	}

	public function Sales() {
		return $this->hasManyThrough(sales::class,saleDetails::class, 'srid','salid');
	}
}
