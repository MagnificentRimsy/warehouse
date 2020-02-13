<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class sales extends Model
{
    protected $primaryKey = 'salid';
    public $table = 'sales';

	public function Details() {
		return $this->hasMany(saleDetails::class,'salid','salid');
    }

	public function Receipts() {
		return $this->hasMany(receipt::class,'salid','salid');
    }
}
