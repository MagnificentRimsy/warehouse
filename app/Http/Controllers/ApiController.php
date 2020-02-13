<?php

namespace App\Http\Controllers;

use App\product;
use Illuminate\Http\Request;

class ApiController extends Controller
{

	public function getProducts() {
		$products = product::all();
		return $products;
	}
}
