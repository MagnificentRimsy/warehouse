<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    protected $primaryKey = 'pid';
    protected $guarded = ['_token'];

	public function Supplier() {
		return $this->belongsTo(supplier::class,'sid','sid');
    }
}
