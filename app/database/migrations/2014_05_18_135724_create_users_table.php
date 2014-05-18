<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table) {
			$table->increments('id');
			$table->string('email', 100)->unique();
			$table->string('password', 64);
			$table->string('remember_token', 60);
			$table->string('registerusername', 50)->unique();
			$table->binary('registerpassword');
			$table->string('grade_table_hash', 64);
			$table->boolean('is_changed');
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
	}

}
