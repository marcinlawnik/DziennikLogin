<?php

class DashboardController extends \BaseController
{
    /**
	 * Display main page of dashboard
	 *
	 * @return View
	 */
    public function getIndex()
    {
        $user = User::find(Sentry::getUser()->id);

        $snapshot = $user->snapshots()->orderBy('created_at', 'DESC')->first();

        $grades = $snapshot->grades()->orderBy('date', 'DESC')->take(10)->get();

        if ($grades->isEmpty() === true) {
            Session::flash(
                'message',
                'Nie posiadasz żadnych ocen! Kliknij '.
                link_to('jobs/check', 'tutaj').
                ', aby uruchomić proces pobierania.'
            );
        }

        $content = $grades;

        return View::make('dashboard.index')->withContent($content);

    }
}
