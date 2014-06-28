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

        $content = Grade::where('user_id', '=', Sentry::getUser()->id)->orderBy('date', 'DESC')->take(10)->get();
          


        return View::make('dashboard.index')->withContent($content);

	}
}
