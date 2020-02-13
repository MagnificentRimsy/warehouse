<?php


namespace App\Http\Controllers;
use App\category;
use App\client;
use App\expense;
use App\invoice;
use App\invoice_detail;
use App\item;
use App\product;
use App\receipt;
use App\saleDetails;
use App\sales;
use App\salesrep;
use App\supplier;
use App\User;
use App\websetting;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;



class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

	public function aboutMe(){
		return view('about');
	}
    public function index()
    {
    	$salesReps = salesrep::all()->count();
    	$products = product::all();
    	$sales = sales::all();
    	$salesValue = 0;
	    foreach($sales as $sale){
	    	$salesValue += $sale->amount * $sale->quantity;
	    }

	    $lowStock = array();
	    foreach ($products as $product){
	    	if($product->quantity < Session::get('settings')->lowStock){
	    		array_push($lowStock,$product);
		    }
	    }
	    $products = count($products);
	    $lowStock = count($lowStock);
        return view('home',[
        	'products' => $products,
	        'sales' => $salesValue,
	        'lowStock' => $lowStock,
	        'salesReps' => $salesReps
        ]);
    }

	public function addSupplier() {
		return view('addSupplier');
    }

	public function addSale() {
    	$products = product::all();
    	$salesReps = salesrep::all();
    	$clients = client::all();

		return view('sales.addSale',[
			'products' => $products,
			'salesReps' => $salesReps,
			'clients' => $clients
		]);
    }

	public function addSalesRep() {
		return view('addSalesRep');
    }
	public function viewSuppliers() {

		if(Input::has('term')){

			$term = Input::get('term');
			$by = Input::get('by');
			$suppliers = supplier::where($by,'like',"%$term%")->get();
		} else {
			$suppliers = supplier::all();
		}


		return view('viewSuppliers',[
			'suppliers' => $suppliers
		]);
    }

	public function addProduct() {
		$categories = category::all();
		$suppliers = supplier::all();

		return view('products.addProduct',[
			'categories' => $categories,
			'suppliers' => $suppliers
		]);
    }

	public function addClient() {
    	$salesreps = salesrep::all();

		return view('addClient',[
			'salesreps' => $salesreps
		]);
    }

	public function salesRepDetails( $srid ) {
		$salesRep = salesrep::find($srid);

		$totalValue = 0;

		foreach($salesRep->Sales as $item){
			$totalValue += $item->amount * $item->quantity;
		}

		foreach($salesRep->Clients as $client){
			foreach($client->Invoice as $item){
				$totalValue += $item->total;
			}

		}

		return view('salesreps.salesRepDetails',[
			'salesRep' => $salesRep,
			'totalValue' => $totalValue
		]);
    }

	public function supplierDetails( $sid ) {
		$supplier = supplier::find($sid);

		return view('supplierDetails',[
			'supplier' => $supplier
		]);
    }

	public function deleteCategory( Request $request, $catid ) {

		$category = category::find($catid);
		if(count($category->Products) > 0 ){
			$request->session()->flash('error','You have to remove all products associated with the category to be deleted.');
			return redirect('view-categories');
		}

		$status = category::destroy($catid);

		if($status)
		    $request->session()->flash('success','Category Deleted');
		else
		    $request->session()->flash('error','Sorry an error occurred');
		return redirect('view-categories');
    }

	public function clientDetails( $clid ) {
		$client = client::find($clid);

		// logic to get how much client has been billed in each currency
		$billedNGN = 0;
		$billedUSD = 0;
		$billedGHC = 0;

		foreach($client->Invoice as $item){

			if($item->currency == "NGN"){
				$billedNGN += $item->total;
			}

			if($item->currency == "USD"){
				$billedUSD += $item->total;
			}

			if($item->currency == "GHC"){
				$billedGHC += $item->total;
			}
		}
		// end bill check logic

		return view('clientDetails',[
			'client' => $client,
			'billedNGN' => $billedNGN,
			'billedUSD' => $billedUSD,
			'billedGHC' => $billedGHC
		]);

	}

	public function productDetails( $pid ) {
		$product = product::find($pid);
		$categories = category::all();
		$suppliers = supplier::all();

		return view('products.productDetails',[
			'product' => $product,
			'suppliers' => $suppliers,
			'categories' => $categories

		]);
    }

	public function export() {

    	$fullQuery = "";

    	$sales = sales::all();

		if(count($sales) > 0) {
			$sale       = sales::all()->first();
			$attributes = $sale->getAttributes();

			$keys = "";
			$keysArray = array();

			foreach ( $attributes as $k => $v ) {
				$keys .= $k . ",";
				array_push($keysArray,$k);
			}
			$keys = str_split( $keys, strlen( $keys ) - 1 );
			$keys = $keys[0];


			$query = "INSERT INTO sales ($keys) VALUES ";

			foreach ( $sales as $item ) {
				$query .= "(";

				foreach($keysArray as $keyItem){
					$query.= "'". $item->$keyItem . "',";
				}
				$query    = str_split( $query, strlen( $query ) - 1 );
				$query = $query[0];
				$query .= "),";
			}

			$query    = str_split( $query, strlen( $query ) - 1 );
			$query[0] .= ";";
			$fullQuery .= $query[0];
		}

		$categories = category::all();

		if(count($categories) > 0) {
			$category       = category::all()->first();
			$attributes = $category->getAttributes();

			$keys = "";
			$keysArray = array();

			foreach ( $attributes as $k => $v ) {
				$keys .= $k . ",";
				array_push($keysArray,$k);
			}
			$keys = str_split( $keys, strlen( $keys ) - 1 );
			$keys = $keys[0];


			$query = "INSERT INTO categories ($keys) VALUES ";

			foreach ( $categories as $item ) {
				$query .= "(";

				foreach($keysArray as $keyItem){
					$query.= "'". $item->$keyItem . "',";
				}
				$query    = str_split( $query, strlen( $query ) - 1 );
				$query = $query[0];
				$query .= "),";
			}

			$query    = str_split( $query, strlen( $query ) - 1 );
			$query[0] .= ";";
			$fullQuery .= $query[0];
		}

		$clients = client::all();

		if(count($clients) > 0) {
			$client       = client::all()->first();
			$attributes = $client->getAttributes();

			$keys = "";
			$keysArray = array();

			foreach ( $attributes as $k => $v ) {
				$keys .= $k . ",";
				array_push($keysArray,$k);
			}
			$keys = str_split( $keys, strlen( $keys ) - 1 );
			$keys = $keys[0];


			$query = "INSERT INTO clients ($keys) VALUES ";

			foreach ( $clients as $item ) {
				$query .= "(";

				foreach($keysArray as $keyItem){
					$query.= "'". $item->$keyItem . "',";
				}
				$query    = str_split( $query, strlen( $query ) - 1 );
				$query = $query[0];
				$query .= "),";
			}

			$query    = str_split( $query, strlen( $query ) - 1 );
			$query[0] .= ";";
			$fullQuery .= $query[0];
		}

		$expenses = expense::all();

		if(count($expenses) > 0) {
			$expense       = expense::all()->first();
			$attributes = $expense->getAttributes();

			$keys = "";
			$keysArray = array();

			foreach ( $attributes as $k => $v ) {
				$keys .= $k . ",";
				array_push($keysArray,$k);
			}
			$keys = str_split( $keys, strlen( $keys ) - 1 );
			$keys = $keys[0];


			$query = "INSERT INTO expenses ($keys) VALUES ";

			foreach ( $expenses as $item ) {
				$query .= "(";

				foreach($keysArray as $keyItem){
					$query.= "'". $item->$keyItem . "',";
				}
				$query    = str_split( $query, strlen( $query ) - 1 );
				$query = $query[0];
				$query .= "),";
			}

			$query    = str_split( $query, strlen( $query ) - 1 );
			$query[0] .= ";";
			$fullQuery .= $query[0];
		}


		$invoices = invoice::all();

		if(count($invoices) > 0) {
			$invoice       = invoice::all()->first();
			$attributes = $invoice->getAttributes();

			$keys = "";
			$keysArray = array();

			foreach ( $attributes as $k => $v ) {
				$keys .= $k . ",";
				array_push($keysArray,$k);
			}
			$keys = str_split( $keys, strlen( $keys ) - 1 );
			$keys = $keys[0];


			$query = "INSERT INTO invoices ($keys) VALUES ";

			foreach ( $invoices as $item ) {
				$query .= "(";

				foreach($keysArray as $keyItem){
					$query.= "'". $item->$keyItem . "',";
				}
				$query    = str_split( $query, strlen( $query ) - 1 );
				$query = $query[0];
				$query .= "),";
			}

			$query    = str_split( $query, strlen( $query ) - 1 );
			$query[0] .= ";";
			$fullQuery .= $query[0];
		}

		$invoiceDetails = invoice_detail::all();

		if(count($invoiceDetails) > 0) {
			$invoiceDetail       = invoice_detail::all()->first();
			$attributes = $invoiceDetail->getAttributes();

			$keys = "";
			$keysArray = array();

			foreach ( $attributes as $k => $v ) {
				$keys .= $k . ",";
				array_push($keysArray,$k);
			}
			$keys = str_split( $keys, strlen( $keys ) - 1 );
			$keys = $keys[0];


			$query = "INSERT INTO invoice_details ($keys) VALUES ";

			foreach ( $invoiceDetails as $item ) {
				$query .= "(";

				foreach($keysArray as $keyItem){
					$query.= "'". $item->$keyItem . "',";
				}
				$query    = str_split( $query, strlen( $query ) - 1 );
				$query = $query[0];
				$query .= "),";
			}

			$query    = str_split( $query, strlen( $query ) - 1 );
			$query[0] .= ";";
			$fullQuery .= $query[0];
		}


		$items = item::all();

		if(count($items) > 0) {
			$singleItem       = item::all()->first();
			$attributes = $singleItem->getAttributes();

			$keys = "";
			$keysArray = array();

			foreach ( $attributes as $k => $v ) {
				$keys .= $k . ",";
				array_push($keysArray,$k);
			}
			$keys = str_split( $keys, strlen( $keys ) - 1 );
			$keys = $keys[0];


			$query = "INSERT INTO items ($keys) VALUES ";

			foreach ( $items as $item ) {
				$query .= "(";

				foreach($keysArray as $keyItem){
					$query.= "'". $item->$keyItem . "',";
				}
				$query    = str_split( $query, strlen( $query ) - 1 );
				$query = $query[0];
				$query .= "),";
			}

			$query    = str_split( $query, strlen( $query ) - 1 );
			$query[0] .= ";";
			$fullQuery .= $query[0];
		}


		$products = product::all();

		if(count($products) > 0) {
		    $product       = product::all()->first();
		    $attributes = $product->getAttributes();

		    $keys = "";
		    $keysArray = array();

		    foreach ( $attributes as $k => $v ) {
		        $keys .= $k . ",";
		        array_push($keysArray,$k);
		    }
		    $keys = str_split( $keys, strlen( $keys ) - 1 );
		    $keys = $keys[0];


		    $query = "INSERT INTO products ($keys) VALUES ";

		    foreach ( $products as $item ) {
		        $query .= "(";

		        foreach($keysArray as $keyItem){
		            $query.= "'". $item->$keyItem . "',";
		        }
		        $query    = str_split( $query, strlen( $query ) - 1 );
		        $query = $query[0];
		        $query .= "),";
		    }

		    $query    = str_split( $query, strlen( $query ) - 1 );
		    $query[0] .= ";";
		    $fullQuery .= $query[0];
		}

	    $receipts = receipt::all();

	    if(count($receipts) > 0) {
	        $receipt       = receipt::all()->first();
	        $attributes = $receipt->getAttributes();

	        $keys = "";
	        $keysArray = array();

	        foreach ( $attributes as $k => $v ) {
	            $keys .= $k . ",";
	            array_push($keysArray,$k);
	        }
	        $keys = str_split( $keys, strlen( $keys ) - 1 );
	        $keys = $keys[0];


	        $query = "INSERT INTO receipts ($keys) VALUES ";

	        foreach ( $receipts as $item ) {
	            $query .= "(";

	            foreach($keysArray as $keyItem){
	                $query.= "'". $item->$keyItem . "',";
	            }
	            $query    = str_split( $query, strlen( $query ) - 1 );
	            $query = $query[0];
	            $query .= "),";
	        }

	        $query    = str_split( $query, strlen( $query ) - 1 );
	        $query[0] .= ";";
	        $fullQuery .= $query[0];
        }

        $salesreps = salesrep::all();

        if(count($salesreps) > 0) {
            $salesrep       = salesrep::all()->first();
            $attributes = $salesrep->getAttributes();

            $keys = "";
            $keysArray = array();

            foreach ( $attributes as $k => $v ) {
                $keys .= $k . ",";
                array_push($keysArray,$k);
            }
            $keys = str_split( $keys, strlen( $keys ) - 1 );
            $keys = $keys[0];


            $query = "INSERT INTO salesreps ($keys) VALUES ";

            foreach ( $salesreps as $item ) {
                $query .= "(";

                foreach($keysArray as $keyItem){
                    $query.= "'". $item->$keyItem . "',";
                }
                $query    = str_split( $query, strlen( $query ) - 1 );
                $query = $query[0];
                $query .= "),";
            }

            $query    = str_split( $query, strlen( $query ) - 1 );
            $query[0] .= ";";
            $fullQuery .= $query[0];
        }

        $suppliers = supplier::all();

        if(count($suppliers) > 0) {
            $supplier       = supplier::all()->first();
            $attributes = $supplier->getAttributes();

            $keys = "";
            $keysArray = array();

            foreach ( $attributes as $k => $v ) {
                $keys .= $k . ",";
                array_push($keysArray,$k);
            }
            $keys = str_split( $keys, strlen( $keys ) - 1 );
            $keys = $keys[0];


            $query = "INSERT INTO suppliers ($keys) VALUES ";

            foreach ( $suppliers as $item ) {
                $query .= "(";

                foreach($keysArray as $keyItem){
                    $query.= "'". $item->$keyItem . "',";
                }
                $query    = str_split( $query, strlen( $query ) - 1 );
                $query = $query[0];
                $query .= "),";
            }

            $query    = str_split( $query, strlen( $query ) - 1 );
            $query[0] .= ";";
            $fullQuery .= $query[0];
        }

        $users = User::all();

        if(count($users) > 0) {
            $user       = User::all()->first();
            $attributes = $user->getAttributes();

            $keys = "";
            $keysArray = array();

            foreach ( $attributes as $k => $v ) {
                $keys .= $k . ",";
                array_push($keysArray,$k);
            }
            $keys = str_split( $keys, strlen( $keys ) - 1 );
            $keys = $keys[0];


            $query = "INSERT INTO users ($keys) VALUES ";

            foreach ( $users as $item ) {
                $query .= "(";

                foreach($keysArray as $keyItem){
                    $query.= "'". $item->$keyItem . "',";
                }
                $query    = str_split( $query, strlen( $query ) - 1 );
                $query = $query[0];
                $query .= "),";
            }

            $query    = str_split( $query, strlen( $query ) - 1 );
            $query[0] .= ";";
            $fullQuery .= $query[0];
        }

        $websettings = websetting::all();

        if(count($websettings) > 0) {
            $websetting       = websetting::all()->first();
            $attributes = $websetting->getAttributes();

            $keys = "";
            $keysArray = array();

            foreach ( $attributes as $k => $v ) {
                $keys .= $k . ",";
                array_push($keysArray,$k);
            }
            $keys = str_split( $keys, strlen( $keys ) - 1 );
            $keys = $keys[0];


            $query = "INSERT INTO websettings ($keys) VALUES ";

            foreach ( $websettings as $item ) {
                $query .= "(";

                foreach($keysArray as $keyItem){
                    $query.= "'". $item->$keyItem . "',";
                }
                $query    = str_split( $query, strlen( $query ) - 1 );
                $query = $query[0];
                $query .= "),";
            }

            $query    = str_split( $query, strlen( $query ) - 1 );
            $query[0] .= ";";
            $fullQuery .= $query[0];
        }

        $file = fopen("STV_Export_". Carbon::now()->toFormattedDateString(). ".export",'w');
		fwrite($file,$fullQuery);
		fclose($file);
		return Response::download("STV_Export_". Carbon::now()->toFormattedDateString(). ".export", "STV_Export_". Carbon::now()->toFormattedDateString() . ".export");

	}


	public function import(Request $request) {

		$tables = DB::select('SHOW TABLES');

		foreach ($tables as $table) {
			foreach ($table as $key => $value)
				DB::statement("truncate $value");

		}


		if($request->hasFile('file')){
    		$fileName = $request->file('file')->getClientOriginalName();
    		$request->file('file')->move('imports',$fileName);
		    ob_start();
		    $file = fopen("imports/" . $fileName,'r');
			$data = fgets($file);

			$queries = explode(';',$data);

			array_pop($queries);
			$count = 0;

			foreach($queries as $query){
			try{
				$status = DB::statement($query);
				if($status) $count++;

			} catch (\Exception $e){
				$request->session()->flash('error','Sorry an error occurred. Try again.');
			}

			}


			if($count == count($queries)) // check if all queries ran
			$request->session()->flash('success','Import Successful');

	    } else {
			$request->session()->flash('error','Please attach an export file');
		}
		return redirect('/home');
    }


	public function addCategory() {
		return view('addCategory');
    }

	public function viewCategories() {

		if(Input::has('term')){

			$term = Input::get('term');
			$by = Input::get('by');
			$categories = category::where($by,'like',"%$term%")->get();
		} else {
			$categories = category::all();

		}


		return view('viewCategories',[
			'categories' => $categories
		]);
	}

	public function viewClients() {

		if(Input::has('term')){

			$term = Input::get('term');
			$by = Input::get('by');
			$clients = client::where($by,'like',"%$term%")->get();
		} else {

			$clients = client::all()->sort();

		}


		return view('viewClients',[
			'clients' => $clients
		]);
	}

	public function viewSalesReps() {

		if(Input::has('term')){

			$term = Input::get('term');
			$by = Input::get('by');
			$salesReps = salesrep::where($by,'like',"%$term%")->get();
		} else if(Input::has('min')){
			$min = Input::get('min');
			$max = Input::get('max');
			$salesReps = salesrep::where('credit','>=',$min)->where('credit','<=',$max)->get();
		}else {

			$salesReps = salesrep::all()->sort();
		}

		return view('viewSalesReps',[
			'salesReps' => $salesReps
		]);
	}

	public function returnSaleDetails( $salid ) {
		$sale = sales::find($salid);

		return view('sales.returnSaleDetails',[
			'sale' => $sale
		]);

	}
	public function returnSale() {

		if(Input::has('term')){

			if(Input::has('days')){
				$days = Input::get('days');
				$sales = sales::where('created_at','>=',Carbon::now()->subDays($days))->get();
			} else {
				$sales = sales::all();
			}

			$term = Input::get('term');
			$by = Input::get('by');

			$salesArray = array();

			foreach($sales as $item ){
				$name = strtolower($item->Product->$by);
				$term = strtolower($term);
				if( str_contains($name, $term)){
					array_push($salesArray,$item);
				};
			}

			$sales = $salesArray;
		}else if(Input::has('days') && !Input::has('term')){
			$days = Input::get('days');
			$sales = sales::where('created_at','>=',Carbon::now()->subDays($days))->get();
		} else if(Input::has('min') && Input::has('max')){
			$min = Input::get('min');
			$max = Input::get('max');
			$by = Input::get('by');

			$sales = sales::where($by,'>=',$min)->where($by,'<=',$max)->get();
		} else {

			$sales = sales::all();
		}



		$sales = $sales->reverse();
		$totalSales = 0;
		$vat = 0;

		$webSetting = websetting::all()->last();

		foreach($sales as $item){
			$totalSales += $item->total;

			foreach($item->Details as $detail){
				$vat += ($detail->Product->salePrice - $detail->Product->supplyPrice) * $detail->quantity;
			}
		}

		$vat = $vat * ($webSetting->vat / 100);

		return view('sales.returnSale',[
			'sales' => $sales,
			'totalSales' => $totalSales,
			'vat' => $vat
		]);
	}

	public function viewSales() {

		if(Input::has('term')){

			if(Input::has('days')){
				$days = Input::get('days');
				$sales = sales::where('created_at','>=',Carbon::now()->subDays($days))->get();
			} else {
				$sales = sales::all();
			}

			$term = Input::get('term');
			$by = Input::get('by');

			$salesArray = array();
			
			foreach($sales as $item ){
				foreach($item->Details as $detail){
					$name = strtolower($detail->Product->$by);
					$term = strtolower($term);
					if( str_contains($name, $term)){
						array_push($salesArray,$item);
					};
				}
			}

			$sales = $salesArray;

		} else if(Input::has('days') && !Input::has('term')){
			$days = Input::get('days');
			$sales = sales::where('created_at','>=',Carbon::now()->subDays($days))->get()->sortByDesc('created_at');
		} else if(Input::has('min') && Input::has('max')){
			$min = Input::get('min');
			$max = Input::get('max');
			$by = Input::get('by');

			$sales = sales::where($by,'>=',$min)->where($by,'<=',$max)->get()->sortByDesc('created_at');
		} else if(Input::has('from') && Input::has('to')){
			$from = Input::get('from');
			$to = Input::get('to');

			$from = Carbon::createFromFormat('m/d/Y',$from);
			$to = Carbon::createFromFormat('m/d/Y',$to);

			$sales = sales::where('created_at','>=',$from)->where('created_at','<=',$to)->get()->sortByDesc('created_at');


		} else {

			$sales = sales::all()->sortByDesc('created_at');
		}



		$totalSales = 0;
		$vat = 0;

		$webSetting = websetting::all()->last();

		foreach($sales as $sale){
			foreach($sale->Details as $item){
				$totalSales += ($item->Product->salePrice * $item->quantity);
				$vat += ($item->Product->salePrice - $item->Product->supplyPrice) * $item->quantity;
			}
		}

		$vat = $vat * ($webSetting->vat / 100);


		$paidArray = array();
		foreach($sales as $sale) {
			$paid = 0;
			foreach ( $sale->Receipts as $item ) {

				$paid += $item->amount;
			}
			array_push($paidArray,$paid);
		}


		return view('sales.viewSales',[
			'sales' => $sales,
			'totalSales' => $totalSales,
			'vat' => $vat,
			'paid' => $paidArray
		]);
	}

	public function saleDetails( $salid ) {
		$sale = sales::find($salid);
		$receipts = $sale->Receipts;

		$paid = 0;
		foreach($receipts as $item){
			$paid += $item->amount;
		}


		return view('sales.viewSaleDetails',[
			'sale' => $sale,
			'receipts' => $receipts,
			'paid' => $paid
		]);
	}

	public function viewSettings() {
    	if(websetting::all()->count() <= 0) {
    		$webSettings = new websetting();
    		$webSettings->vat = 5;
    		$webSettings->save();
	    }

	    $webSettings = websetting::all()->last();

		return view('viewSettings',[
			'webSettings' => $webSettings
		]);
	}

	public function viewProducts() {

		if(Input::has('term')){

			$term = Input::get('term');
			$by = Input::get('by');
			$products = product::where($by,'like',"%$term%")->get();
		}else if(Input::has('min')){
			$min = Input::get('min');
			$max = Input::get('max');
			$by = Input::get('numBy');
			$products = product::where($by,'>=',$min)->where($by,'<=',$max)->get();
		} else {

			$products = product::all();

		}

		return view('products.viewProducts',[
			'products' => $products,
			]);
	}


	public function createInvoice() {
		$clients = client::all()->sort();

		return view('createInvoice',[
			'clients' => $clients
		]);
	}

	public function createReceipt() {

		$sales = sales::all();
		return view('createReceipt',[
			'sales' => $sales
		]);

	}

	public function selectInvoice() {
		$invoices = invoice::all();
		return view('selectInvoice',[
			'invoices' => $invoices
		]);
	}

	public function invoiceDetails( $invid ) {
		$invoice = invoice::find($invid);
		$paid = 0;
		foreach($invoice->Receipts as $item){
			$paid += $item->amount;
		}


		return view('invoiceDetails',[
			'invoice' => $invoice,
			'paid' => $paid
		]);
	}

	public function viewInvoices() {
		$invoices = invoice::all();

		$paidArray = array();
		foreach($invoices as $invoice) {
			$paid = 0;
			foreach ( $invoice->Receipts as $item ) {

				$paid += $item->amount;
			}
			array_push($paidArray,$paid);
		}

		return view('viewInvoices',[
			'invoices' => $invoices,
			'paid' => $paidArray
		]);
	}

	public function viewReceipts() {
		$receipts = receipt::all()->sortByDesc('created_at');
		return view('viewReceipts',[
			'receipts' => $receipts
		]);
	}


	public function viewExpenses()
	{
		if(Input::has('term')){

			$term = Input::get('term');
			$by = Input::get('by');
			$expenses = expense::where($by,'like',"%$term%")->get();
		} else {

			$expenses = expense::all()->sortByDesc('created_at');
		}


		return view('expenses.home',[
			'expenses' => $expenses
		]);
	}


	public function getCreateExpense()
	{
		return view('expenses.createExpense');
	}


	public function expenseDetails($exid)
	{
		$expense = expense::find($exid);

		return view( 'expenses.expenseDetails',[
			'expense' => $expense
		]);
	}

	public function postCreateExpense(Request $request)
	{
		$isRecurring = $request->input('isRecurring');
		$expense = new expense();
		$expense->uid = Auth::user()->uid;
		$expense->shortDesc =$request->input('shortDesc');
		$expense->longDesc = $request->input('longDesc');
		$expense->amount = 0;

		$expense->schedule = $request->input('schedule');
		$expense->department = $request->input('department');


		if($isRecurring == "Yes"){
			$expense->isRecurring = 1;
			$schedule = $request->input('schedule');

			$expense->nextPayment = Carbon::now()->addDays($schedule);
		} else {
			$expense->isRecurring = 0;
		}

		$expense->save();


		$items = $request->input('item');
		$prices = $request->input('price');

		$totalAmount = 0;
		for($i = 0; $i < count($items); $i++){

			$item = new item();
			$item->exid = $expense->exid;
			$item->item = $items[$i];
			$item->amount = $prices[$i];
			$item->save();

			$totalAmount = $totalAmount + $prices[$i];
		}

		$expense->amount = $totalAmount;
		$expense->save();

		$request->session()->flash('success','Expense Created');
		return redirect('create-expense');
	}

	public function viewSchedule()
	{
		return view('ex.schedule');
	}


	public function postAddCategory( Request $request ) {
		$category = new category();
		$category->name = $request->input('name');
		$status = $category->save();

		if($status)
		    $request->session()->flash('success','Category Added Successfully.');
		else
		    $request->session()->flash('error','Sorry an error occurred');

		return redirect('add-category');
    }

	public function postReturnSale( Request $request ) {
		$salid = $request->input('salid');
		$pid = $request->input('pid');
		$srid = $request->input('srid');
		$quantity = $request->input('quantity');
		$amount = $request->input('amount');

		$sale = sales::find($salid);
		$sale->total -= $quantity * $amount;
		$status1 = $sale->save();

		foreach($sale->Details as $item ){
			if($item->Product->pid == $pid){
				$saleDetail = saleDetails::find($item->sdid);
				$saleDetail->quantity -= $quantity;
				$saleDetail->save();
			}
		}

		$product = product::find($pid);
		$product->quantity += $quantity;
		$status2 = $product->save();

		$salesRep = salesrep::find($srid);
		$salesRep->credit -= $quantity * $amount;
		$status3 = $salesRep->save();

		if($status1 && $status2 && $status3)
			$request->session()->flash('success','Product Returned.');
		else
			$request->session()->flash('error','Something went wrong please try again');

		return redirect('return-sale');

	}

	public function postAddSupplier( Request $request ) {
		$supplier = new supplier();
		$supplier->name = $request->input('name');
		$supplier->email = $request->input('email');
		$supplier->phone = $request->input('phone');
		$supplier->address = $request->input('address');
		$supplier->contactPersonName = $request->input('contactPersonName');
		$supplier->contactPersonPhone = $request->input('contactPersonPhone');
		$supplier->contactPersonEmail = $request->input('contactPersonEmail');
		$status = $supplier->save();

		if($status)
		    $request->session()->flash('success','Supplier Added.');
		else
		    $request->session()->flash('error','Sorry an error occurred. Try again.');


		return redirect('add-supplier');
    }



	public function postAddClient( Request $request ) {
		$client = new client();
		$client->companyName = $request->input('companyName');
		$client->address = $request->input('address');
		$client->phone = $request->input('phone');
		$client->email = $request->input('email');
		$client->uid = Auth::user()->uid;
		$client->srid = $request->input('srid');
		$status= $client->save();

		if($status)
			$request->session()->flash('success','Client successfully created');
		else
			$request->session()->flash('error','Something went wrong please try again');

		return redirect('add-client');

	}

	public function postAddProduct( Request $request ) {

    	try {
		    product::create( $request->all() );
		    $request->session()->flash('success','Product Added.');
		    return redirect('add-product');
	    } catch (\Exception $e){
    		$request->session()->flash('error','Un-successful. Please try again.');
		    return redirect('add-product')->withInput($request->all());
    	}

    }

	public function postAddSale( Request $request ) {

		$pids = $request->input('pid');
		$srid = $request->input('srid');
		$quantities = $request->input('quantity');
		$payment = $request->input('payment');
		$choice = $request->input('choice');
		$total = $request->input('total');

		if($choice == 'Sales Rep' && count($pids) ) {

			$sale = new sales();
			$sale->type = $choice;
			$sale->total = $total;
			$sale->save();


			$count = 0;

			for($i = 0; $i < count($pids); $i++){
				$product = product::find($pids[$i]);

				$sales = new saleDetails();
				$sales->salid = $sale->salid;
				$sales->pid = $pids[$i];
				$sales->srid = $srid;
				$sales->quantity = $quantities[$i];
				$sales->amount = $product->salePrice;
				$sales->uid = Auth::user()->uid;
				$status = $sales->save();

				$product->quantity -= $quantities[$i];
				$product->save();

				if($status) $count++;
			}

			if($payment == "Credit"){
				// add the credit to the sales rep
				$salesRep = salesrep::find($srid);
				$salesRep->credit += ($total);
				$salesRep->save();
			} else {
				// create the payment receipt
				$receipt = new receipt();
				$receipt->salid = $sale->salid;
				$receipt->uid = Auth::user()->uid;
				$receipt->amount = $total;
				$receipt->details = "Paid in Cash to " . Auth::user()->name;
				$receipt->save();
				}



			if($count == count($pids)){
				$data = "<a href='sale-details/" . $sale->salid . "'>View</a>";
				$request->session()->flash('success',"Sale Added. $data");
			}
			else
				$request->session()->flash('error','Something went wrong please try again');

		} else if($choice === "Client" && count($pids)){

			$sale = new sales();
			$sale->type = $choice;
			$sale->total = $total;
			$sale->save();


			$count = 0;

			for($i = 0; $i < count($pids); $i++){
				$product = product::find($pids[$i]);
				$clid = $request->input('clid');
				$client = client::find($clid);
				$srid = $client->SalesRep->srid;

				$sales = new saleDetails();
				$sales->salid = $sale->salid;
				$sales->pid = $pids[$i];
				$sales->clid = $client->clid;
				$sales->srid = $srid;
				$sales->quantity = $quantities[$i];
				$sales->amount = $product->salePrice;
				$sales->uid = Auth::user()->uid;
				$status = $sales->save();

				$product->quantity -= $quantities[$i];
				$product->save();

				if($payment == "Credit"){
					$salesRep = salesrep::find($srid);
					$salesRep->credit += ($product->salePrice * $quantities[$i]);
					$salesRep->save();
				}

				if($status) $count++;
			}


			if($count == count($pids))
				$request->session()->flash('success','Sale Added.');
			else
				$request->session()->flash('error','Something went wrong please try again');

		}

		return redirect('add-sale');
    }

	public function postAddSalesRep( Request $request ) {

		try {
			salesrep::create($request->all());
			$request->session()->flash('success','Sales Rep Added.');
			return redirect('add-salesrep');
		} catch (\Exception $e){
			$request->session()->flash('error','Un-successful. Please try again.');
			return redirect('add-salesrep')->withInput($request->all());
		}
    }



	public function postCreateInvoice(Request $request) {

		$items = $request->input('item');
		$prices = $request->input('price');

		$invoice = new invoice();
		$invoice->clid = $request->input('clid');
		$invoice->currency = $request->input('currency');
		$invoice->title = $request->input('title');
		$invoice->total = $request->input('total');
		$invoice->uid = Auth::user()->uid;
		$status = $invoice->save();

		for($i = 0; $i < count($items); $i++){
			$detail = new invoice_detail();
			$detail->description = $items[$i];
			$detail->price = $prices[$i];
			$detail->invid = $invoice->invid;
			$detail->save();
		}


		if($status)
			$request->session()->flash('success','Invoice successfully created');
		else
			$request->session()->flash('error','Something went wrong please try again');

		return redirect('create-invoice');
	}

	public function postCreateReceipt( Request $request ) {

		$salid = $request->input('salid');
		$amount = $request->input('amount');

		$receipt = new receipt();
		$receipt->salid = $salid;
		$receipt->uid = Auth::user()->uid;
		$receipt->amount = $request->input('amount');
		$receipt->details = $request->input('details');
		$status =  $receipt->save();  // saves the record

		if($amount > 0 ){

			$sale = sales::find($salid);
			// add the credit to the sales rep
			$salesRep = salesrep::find($sale->Details[0]->srid);
			$salesRep->credit -= ($amount);
			$salesRep->save();
		}


		if($status)
			$request->session()->flash('success','Receipt created successfully');
		else
			$request->session()->flash('error','Something went wrong. Please try again');


		return redirect('sale-details/' . $salid );
	}

	public function postSelectInvoice( Request $request ) {

		try {
			$invoice = invoice::find( $request->input( 'invid' ) );

			return redirect('invoice-details/' . $invoice->invid); // display receipt details if ID is valid

		} catch(Exception $e){

			$request->session()->flash('error',"Invalid invoice ID");
			return redirect('select-invoice'); // else return the user to the view with an error
		}

	}

	public function postSettings( Request $request ) {

		$topMenu = $request->input('topMenu');
		$lowStock = $request->input('lowStock');

		if($topMenu == 'on') $topMenu = 1;
		else $topMenu = 0;


		$websetting = new websetting();
		$websetting->topMenu = $topMenu;
		$websetting->lowStock = $lowStock;
		$websetting->vat = $request->input('vat');
		$status = $websetting->save();

		if($status)
		    $request->session()->flash('success','Setting Changed.');
		else
		    $request->session()->flash('error','Sorry an error occurred');

		return redirect('settings');
	}

	public function invoice($salid) {
		$sale = sales::find($salid);
		return view('invoice',[
			'sale' => $sale
		]);
	}

	public function postAddStock( Request $request ) {
		$pid = $request->input('pid');
		$product = product::find($pid);

		$product->quantity += $request->input('quantity');
		$status = $product->save();

		if($status)
		    $request->session()->flash('success','Product Stock Updated.');
		else
		    $request->session()->flash('error','Sorry an error occurred');

		return redirect('product/' . $pid);
    }

	public function postUpdateProduct( Request $request ) {
		$pid = $request->input('pid');
		$product = product::find($pid);

		$status = $product->update($request->all());

		if($status)
		    $request->session()->flash('success','Product Updated');
		else
		    $request->session()->flash('error','Sorry an error occurred');

		return redirect('product/' . $pid);
    }


	public function receipt( $recid ) {
		$receipt = receipt::find($recid);
		$invoice = $receipt->Invoice;
		$paid = 0;
		foreach($invoice->Receipts as $item){

			if($item->created_at <= $receipt->created_at)
				$paid += $item->amount;
		}

		$balance = $invoice->total - $paid;

		return view('receipt',[
			'receipt' => $receipt,
			'invoice' => $invoice,
			'balance' => $balance
		]);
	}


	public function invoicePDF($invid) {
		try {
			// instantiate and use the dompdf class
			$dompdf = new Dompdf();
			$dompdf->loadHtml( $this->invoice($invid) );

			// (Optional) Setup the paper size and orientation
			$dompdf->setPaper( 'A4', 'portrait' );
			$dompdf->set_option('isRemoteEnabled', 'true');


			// Render the HTML as PDF
			$dompdf->render();

			// Output the generated PDF to Browser
			$dompdf->stream("STV_Warehouse_Invoice_" . Carbon::now()->toDateString());
		} catch(Exception $e){
			echo "Something went wrong. Please try again.";
		}

	}

	public function receiptPDF($recid) {
		try {
			// instantiate and use the dompdf class
			$dompdf = new Dompdf();
			$dompdf->loadHtml( $this->receipt($recid) );

			// (Optional) Setup the paper size and orientation
			$dompdf->setPaper( 'A4', 'portrait' );
			$dompdf->set_option('isRemoteEnabled', 'true');


			// Render the HTML as PDF
			$dompdf->render();

			// Output the generated PDF to Browser
			$dompdf->stream("STV_Warehouse_Receipt_" . Carbon::now()->toDateString());
		} catch(Exception $e){
			echo "Something went wrong. Please try again.";
		}

	}



}
