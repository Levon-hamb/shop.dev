<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('products', function($table)
		{
			$table->increments('id');
			$table->integer('user_id')->unsigned();
			$table->integer('qty');
			$table->integer('sold_qty')->default(0);
			$table->boolean('status')->default(1);
			$table->string('product_name');
			$table->text('product_description');
			$table->integer('product_price');
			$table->string('price_currency');
			$table->text('photo_path');
		});

		Schema::table('products', function($table)
		{
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('products');
	}

}
