<?php

class DashboardController extends \BaseController {

	/**
	 * Display main page of dashboard
	 *
	 * @return View
	 */
	public function getIndex()
	{
		return View::make('dashboard.index');
	}
}