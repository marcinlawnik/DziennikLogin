<?php

class GradesController extends \BaseController {


    public function getIndex()
    {
        // Show all grades belonging to user
        //$grades = Grade::with('subject')->where('user_id', '=', Sentry::getUser()->id)->get();
        $snapshot = Sentry::getUser()->snapshots()->orderBy('created_at', 'DESC')->first(['id']);
        $grades = Snapshot::find($snapshot->id)->grades();
        $subjects = array();

        foreach($grades as $grade) {
            if(!in_array($grade->subject_id, $subjects)) {
                $subjects[]=$grade->subject_id;
            }
        }

        $averages = array();

        foreach($subjects as $subject) {
            $averages[Subject::find($subject)->name]=Subject::calculateAverage($subject);
        }

        return View::make('grades.index')->withGrades($grades)->withAverages($averages);

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

        if($grades->isEmpty()){
            return Redirect::to('grades/index');
        } else {
            return View::make('grades.subject')
                ->withGrades($grades)
                ->withSubject(Subject::find($id)->name)
                ->withAverage(Subject::calculateAverage($id));
        }

    }

    public function getShow($id)
    {
        // Show detailed data about chosen grade
        // TODO:check if grade belongs to user
        $validator = Validator::make(
            array('id' => $id),
            array('id' => 'required|numeric')
        );
        if($validator->passes())
        {
            $grade = User::find(Sentry::getUser()->id)->grades()->where('id', '=', $id)->first();
            if($grade == ''){
                return Redirect::to('grades')->with('message', Lang::get('messages.gradenotfound'));
            }
            return View::make('grades.show')->withGrade($grade);
        } else {
            return Redirect::to('grades')->with('message', Lang::get('messages.gradenotfound'));
        }


    }

}
