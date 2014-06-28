<?php

class DashboardController extends \BaseController {

	/**
	 * Display main page of dashboard
	 *
	 * @return View
	 */
	public function getIndex()
	{

        $grades = Grade::where('user_id', '=', Sentry::getUser()->id)->get();

        if($grades->isEmpty() === true){
            Session::flash('message', 'Nie posiadasz żadnych ocen! Kliknij '.link_to('firejob', 'tutaj').', aby uruchomić proces pobierania.');
        }

//        $job_is_active = 1;
//        $content = User::with('Settings')->whereHas('Settings',
//                function($query) use ($job_is_active) {
//                    $query->where('job_is_active', '=', $job_is_active);
//                })
//                ->get();

        $content = Grade::where('user_id', '=', Sentry::getUser()->id)->orderBy('date', 'DESC')->take(10)->get();
          


        return View::make('dashboard.index')->withContent($content);

	}
}
