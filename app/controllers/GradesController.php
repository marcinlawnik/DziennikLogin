<?php

class GradesController extends \BaseController {


    public function getIndex()
    {
        // Show all grades belonging to user
        //$grades = Grade::with('subject')->where('user_id', '=', Sentry::getUser()->id)->get();
        $snapshot = User::find(Sentry::getUser()->id)->snapshots()->orderBy('created_at', 'DESC')->first(['id']);
        $grades = Snapshot::find($snapshot->id)->grades()->get();
        if ($grades->isEmpty()) {
            return Redirect::to('dashboard/index')->with('message', 'Nie posiadasz jeszcze żadnych ocen!');
        }
        $subjects = array();
        $subjectsIds = [];
        foreach ($grades as $grade) {
            if (!in_array($grade->subject_id, $subjectsIds)) {
                $subjectsIds[]=$grade->subject_id;
                $subjects[]=Subject::find($grade->subject_id);
            }
        }

        return View::make('grades.index')
            ->withGrades($grades)
            ->withSubjects($subjects);

    }

    public function getSubject($id)
    {

        //Get current snapshot
        $snapshot = User::find(Sentry::getUser()->getId())->snapshots()->orderBy('created_at', 'DESC')->first(['id']);
        // Show all grades belonging to user in said subject
        $grades = Grade::with('subject')
            ->where('user_id', '=', Sentry::getUser()->id)
            ->where('subject_id', '=', $id)
            ->where('snapshot_id', '=', $snapshot->id)
            ->get();

        if ($grades->isEmpty()) {
            return Redirect::to('grades/index');
        } else {
            return View::make('grades.subject')
                ->withGrades($grades)
                ->withSubject(Subject::find($id))
                ->withAverage(GradeCalculator::calculateAverage($grades));
        }

    }
}
