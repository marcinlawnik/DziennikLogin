<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddSnapshotChangesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('snapshot_changes', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('user_id');
            $table->integer('snapshot_id_from')->nullable();
            $table->integer('snapshot_id_to');
            $table->integer('grade_id');
            //Either add or delete
            $table->string('action');
            $table->integer('is_sent_email');
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
		Schema::drop('snapshot_changes');
	}

}
