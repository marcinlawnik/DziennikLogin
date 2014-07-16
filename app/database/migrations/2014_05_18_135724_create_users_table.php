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

            $table->engine = 'InnoDB';

            //Sentry user migrations added

			$table->increments('id');
			$table->string('email', 100)->unique();
			$table->string('password', 64);
            $table->text('permissions')->nullable();
            $table->boolean('activated')->default(0);
            $table->string('activation_code')->nullable();
            $table->timestamp('activated_at')->nullable();
            $table->timestamp('last_login')->nullable();
            $table->string('persist_code')->nullable();
            $table->string('reset_password_code')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
			$table->string('registerusername', 50)->unique();
			$table->binary('registerpassword');
			$table->string('grade_table_hash', 64);
			$table->boolean('is_changed');
			$table->timestamps();

            $table->index('activation_code');
            $table->index('reset_password_code');
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
