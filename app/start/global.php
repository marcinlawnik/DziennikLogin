<?php

/*
|--------------------------------------------------------------------------
| Register The Laravel Class Loader
|--------------------------------------------------------------------------
|
| In addition to using Composer, you may use the Laravel class loader to
| load your controllers and models. This is useful for keeping all of
| your classes in the "global" namespace without Composer updating.
|
*/

ClassLoader::addDirectories(array(

	app_path().'/commands',
	app_path().'/controllers',
	app_path().'/models',
	app_path().'/database/seeds',

));

/*
|--------------------------------------------------------------------------
| Application Error Logger
|--------------------------------------------------------------------------
|
| Here we will configure the error logger setup for the application which
| is built on top of the wonderful Monolog library. By default we will
| build a basic log file setup which creates a single file for logs.
|
*/

//Log::useFiles(storage_path().'/logs/laravel.log');

//Using daily log files

$logFile = 'log-'.php_sapi_name().'.txt';

Log::useDailyFiles(storage_path().'/logs/'.$logFile);

/*
|--------------------------------------------------------------------------
| Application Error Handler
|--------------------------------------------------------------------------
|
| Here you may handle any errors that occur in your application, including
| logging them or displaying custom views for specific errors. You may
| even register several error handlers to handle different types of
| exceptions. If nothing is returned, the default error view is
| shown, which includes a detailed stack trace during debug.
|
*/

App::error(function(Exception $exception, $code)
{
	Log::error($exception);
});

/*
|--------------------------------------------------------------------------
| 404 Not Found Handler
|--------------------------------------------------------------------------
|
| Here we are handling 404 errors. Currently redirecting to index.
| TODO:Crete a custom 404 error page
|
*/

App::missing(function($exception)
{
    // return Response::view('errors.missing', array(), 404);
    return Redirect::to('/');
});
/*
|--------------------------------------------------------------------------
| Maintenance Mode Handler
|--------------------------------------------------------------------------
|
| The "down" Artisan command gives you the ability to put an application
| into maintenance mode. Here, you will define what is displayed back
| to the user if maintenance mode is in effect for the application.
|
| NOTE: If the Closure passed to the down method returns NULL,
|       maintenance mode will be ignored for that request.
|
*/

App::down(function()
{
	return Response::view('maintenance', array() , 503);
});

/*
|--------------------------------------------------------------------------
| Require The Filters File
|--------------------------------------------------------------------------
|
| Next we will load the filters file for the application. This gives us
| a nice separate location to store our route and application filter
| definitions instead of putting them all in the main routes file.
|
*/

require app_path().'/filters.php';

/*
|--------------------------------------------------------------------------
| Add Cron Jobs
|--------------------------------------------------------------------------
|
| Adding cron jobs here instead of crontab, courtesy liebig/cron
|
*/

Event::listen('cron.collectJobs', function() {

    Log::debug('event fired cron.collectJobs');

    Cron::add('CronPushGradeCheckToQueueEvery5Minutes', '*/5 * * * *', function() {

        $users = User::with('Settings')->whereHas('Settings',
            function($query) {
                $query->where('job_is_active', '=', 1);
                $query->where('job_interval', '=', 5);
            })
            ->get();

        $counter = 0;

        $ids = array();

        foreach($users as $user){
            Queue::push('CheckIfUserNeedsGradeProcessWorker', array('user_id' => $user->id), 'grade_check');
            $counter++;
            $ids[] = $user->id;
        }

        Log::info('Pushed check jobs for users (every 5 minutes)', array('users_amount' => $counter, 'users_ids' => $ids));

        return null;
    });

    Cron::add('CronPushGradeCheckToQueueEvery15Minutes', '*/15 * * * *', function() {

        $users = User::with('Settings')->whereHas('Settings',
            function($query) {
                $query->where('job_is_active', '=', 1);
                $query->where('job_interval', '=', 15);
            })
            ->get();

        $counter = 0;

        $ids = array();

        foreach($users as $user){
            Queue::push('CheckIfUserNeedsGradeProcessWorker', array('user_id' => $user->id), 'grade_check');
            $counter++;
            $ids[] = $user->id;
        }

        Log::info('Pushed check jobs for users (every 15 minutes)', array('users_amount' => $counter, 'users_ids' => $ids));

        return null;
    });

});