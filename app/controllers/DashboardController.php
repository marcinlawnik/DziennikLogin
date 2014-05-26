<?php

class DashboardController extends \BaseController {

	/**
	 * Display main page of dashboard
	 *
	 * @return View
	 */
	public function getIndex()
	{

        $grades = Grade::where('user_id', '=', Auth::user()->id)->get();

        if($grades->isEmpty() === true){
            Session::flash('message', 'Nie posiadasz żadnych ocen! Kliknij '.link_to('firejob', 'tutaj').', aby uruchomić proces pobierania.');
        }

        return View::make('dashboard.index');

	}
}