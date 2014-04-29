<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableGrades extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('grades', function(Blueprint $table)
        {
            $table->boolean('is_sent_email')->after('trimester');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('grades', function(Blueprint $table)
        {
            $table->dropColumn('is_sent_email');
        });
	}

}
