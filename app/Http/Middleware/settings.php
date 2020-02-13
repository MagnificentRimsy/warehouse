<?php

namespace App\Http\Middleware;

use App\product;
use App\websetting;
use Closure;

class settings
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

	    $webSettings = websetting::all()->last();

	    if(count($webSettings) <= 0){
		    $webSettings = new websetting();
		    $webSettings->topMenu = 0;
		    $webSettings->save();
	    }

	    $request->session()->flash('settings' , $webSettings);
	    $products = product::all();

	    $lowStock = array();
	    foreach ($products as $product){
		    if($product->quantity < $webSettings->lowStock){
			    array_push($lowStock,$product);
		    }
	    }


	    $request->session()->flash('lowStock' , $lowStock);

	    return $next($request);
    }
}
