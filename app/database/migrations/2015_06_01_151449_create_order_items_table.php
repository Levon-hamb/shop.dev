<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderItemsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('order_items', function($table)
		{
			$table->increments('id', true);
			$table->integer('product_id')->unsigned();
			$table->integer('qty');
			$table->integer('price');
			$table->integer('order_id')->unsigned();

		});

		Schema::table('order_items', function($table) {
			$table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');;
			$table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');;
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
	}

}
