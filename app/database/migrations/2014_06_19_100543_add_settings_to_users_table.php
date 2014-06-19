<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddSettingsToUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users', function(Blueprint $table)
		{
            //$table->renameColumn('is_changed', 'hash_is_changed');
            //A switch to mark job as active
            $table->boolean('job_is_active')->nullable()->after('is_changed');
            //In minutes, amount of time between jobs. Default: 15
            $table->integer('job_interval')->nullable()->after('job_is_active');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('users', function(Blueprint $table)
		{
            $table->renameColumn('hash_is_changed', 'is_changed');
            $table->dropColumn(['job_is_active', 'job_interval']);
		});
	}

}
