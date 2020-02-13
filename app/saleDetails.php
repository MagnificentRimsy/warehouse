<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class saleDetails extends Model
{
    protected $primaryKey = 'sdid';
    protected $table = 'sale_details';

	public function Sale() {
		return $this->belongsTo(sales::class,'salid','salid');
    }
	public function SalesRep() {
		return $this->belongsTo(salesrep::class,'srid','srid');
	}

	public function Client() {
		return $this->belongsTo(client::class,'clid','clid');
	}

	public function Product() {
		return $this->belongsTo(product::class,'pid','pid');
	}

}
