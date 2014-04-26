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
			$table->float('grade_value');
			$table->tinyInteger('grade_weight');
			$table->string('grade_group', 160);
			$table->string('grade_title', 160);
			$table->date('grade_date');
			$table->string('grade_abbreviation', 3);
			$table->tinyInteger('grade_trimester');
			$table->dateTime('grade_download_date');
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
