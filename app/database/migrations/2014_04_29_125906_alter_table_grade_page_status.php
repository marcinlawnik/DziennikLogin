<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableGradePageStatus extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('grade_table_status', function(Blueprint $table)
        {
            $table->boolean('is_changed')->after('grade_table_hash');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('grade_table_status', function(Blueprint $table)
        {
            $table->dropColumn('is_changed');
        });
	}

}
