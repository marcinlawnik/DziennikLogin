<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGradesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('grades', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('user_id');
			$table->integer('subject_id');
			$table->float('value');
			$table->tinyInteger('weight');
			$table->string('group', 160);
			$table->string('title', 160);
			$table->date('date');
			$table->string('abbreviation', 3);
			$table->tinyInteger('trimester');
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
		Schema::drop('grades');
	}

}
