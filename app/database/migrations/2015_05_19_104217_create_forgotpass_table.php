<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForgotpassTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{

		Schema::create('forgot_pass', function($table)
		{
			$table->text('token');
			$table->integer('user_id')->unsigned();
		});

		Schema::table('forgot_pass', function($table) {
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');;
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
