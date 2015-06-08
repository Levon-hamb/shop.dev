<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsCategoriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('products_categories', function($table)
		{
			$table->integer('product_id')->unsigned();
			$table->integer('category_id')->unsigned();
		});

		Schema::table('products_categories', function($table) {
			$table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');;
			$table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');;
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
//		Schema::drop('products_categories');
	}

}
