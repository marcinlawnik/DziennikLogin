<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class DeleteEmailSendStatusesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::drop('email_send_statuses');
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::create('email_send_statuses', function(Blueprint $table)
		{
            $table->integer('grade_id');
            $table->integer('user_id');
            $table->boolean('status');
            $table->timestamps();
		});
	}

}
