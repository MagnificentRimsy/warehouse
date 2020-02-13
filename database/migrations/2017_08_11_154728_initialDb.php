<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InitialDb extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

	    Schema::defaultStringLength(255);

	    Schema::create('products', function(Blueprint $table){
		    $table->increments('pid');
		    $table->integer('sid');
		    $table->integer('catid');
		    $table->string('name');
		    $table->integer('quantity');
		    $table->integer('supplyPrice');
		    $table->integer('salePrice');
		    $table->string('description',2000)->nullable();
		    $table->timestamps();


	    });

	    Schema::create('suppliers', function(Blueprint $table){
		    $table->increments('sid');
		    $table->string('name');
		    $table->string('phone');
		    $table->string('email');
		    $table->string('address',2000);
		    $table->string('contactPersonName');
		    $table->string('contactPersonEmail');
		    $table->string('contactPersonPhone');
		    $table->timestamps();
	    });

	    Schema::create('categories', function(Blueprint $table){
		    $table->increments('catid');
		    $table->string('name');
		    $table->timestamps();
	    });

	    Schema::create('salesreps', function(Blueprint $table){
		    $table->increments('srid');
		    $table->string('name');
		    $table->string('email');
		    $table->string('phone');
		    $table->integer('credit')->default(0);
		    $table->timestamps();
	    });

	    Schema::create('websettings', function(Blueprint $table){
		    $table->increments('wsid');
		    $table->integer('vat')->default(5);
		    $table->integer('lowStock')->default(10);
		    $table->integer('topMenu')->default(1);
		    $table->timestamps();
	    });



	    Schema::create('expenses', function (Blueprint $table){
		    $table->increments('exid');
		    $table->integer('uid');
		    $table->string('department');
		    $table->string('shortDesc');
		    $table->string('longDesc', 2000);
		    $table->decimal('amount');
		    $table->enum('currency',['NGN,GHC,USD']);
		    $table->boolean('isRecurring')->default('0');
		    $table->integer('schedule'); // make nullable
		    $table->timestamp('nextPayment');
		    $table->timestamps();
	    });




	    Schema::create('items', function (Blueprint $table){
		    $table->increments('itid');
		    $table->integer('exid');
		    $table->string('item');
		    $table->string('amount');
		    $table->timestamps();
	    });



	    Schema::create('sales', function(Blueprint $table){
		    $table->increments('salid');
		    $table->enum('type',['Sales Rep','Client']);
		    $table->integer('total');
		    $table->timestamps();
	    });

	    Schema::create('sale_details', function(Blueprint $table){
		    $table->increments('sdid');
		    $table->integer('salid');
		    $table->integer('clid')->nullable();
		    $table->integer('pid');
		    $table->integer('srid');
		    $table->integer('uid');
		    $table->integer('quantity');
		    $table->integer('amount');
		    $table->timestamps();
	    });

	    Schema::create( 'clients', function ( Blueprint $table ) {
		    $table->increments( 'clid' );
		    $table->string( 'companyName' );
		    $table->string( 'address', 2000 );
		    $table->string( 'phone' );
		    $table->string( 'email' )->nullable();
		    $table->integer('srid');
		    $table->integer('uid');
		    $table->timestamps();


	    } );


	    Schema::create( 'invoices', function ( Blueprint $table ) {
		    $table->increments( 'invid' );
		    $table->integer( 'clid' );
		    $table->string( 'title' );
		    $table->integer('uid');
		    $table->enum( 'currency', [ 'NGN', 'USD' ] )->default('NGN');
		    $table->decimal( 'total' );
		    $table->timestamps();

	    } );

	    Schema::create( 'invoice_details', function ( Blueprint $table ) {
		    $table->increments( 'indid' );
		    $table->integer( 'invid' );
		    $table->string( 'description', 2000 );
		    $table->decimal( 'price' );
		    $table->timestamps();

	    } );

	    Schema::create( 'receipts', function ( Blueprint $table ) {
		    $table->increments( 'recid' );
		    $table->integer( 'salid' );
		    $table->integer( 'uid' );
		    $table->decimal( 'amount' );
		    $table->string( 'details' );
		    $table->timestamps();
	    } );


	    Schema::create('users', function (Blueprint $table) {
		    $table->increments('uid');
		    $table->string('name');
		    $table->enum('role',['Manager','Owner'])->default('Owner');
		    $table->string('phone');
		    $table->string('email',191)->unique();
		    $table->string('password');
		    $table->rememberToken();
		    $table->timestamps();
	    });

	    Schema::create('password_resets', function (Blueprint $table) {
		    $table->string('email',191)->index();
		    $table->string('token');
		    $table->timestamp('created_at')->nullable();
	    });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	    Schema::dropIfExists('clients');
	    Schema::dropIfExists('invoices');
	    Schema::dropIfExists('invoice_details');
	    Schema::dropIfExists('receipts');
	    Schema::dropIfExists('products');
        Schema::dropIfExists('suppliers');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('salesreps');
        Schema::dropIfExists('sales');
        Schema::dropIfExists('users');
	    Schema::dropIfExists('expenses');
	    Schema::dropIfExists('items');
	    Schema::dropIfExists('password_resets');
    }
}
