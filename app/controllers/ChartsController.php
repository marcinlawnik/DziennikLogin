<?php

class ChartsController extends \BaseController
{
    public function getGradesBarChart($id = null)
    {
        $user = User::find(Sentry::getUser()->id);
        $snapshot = $user->snapshots()->orderBy('created_at', 'DESC')->first();
        if (is_null($id)) {
            $grades = $snapshot->grades;
        } else {
            $grades = $snapshot->grades()->where('subject_id', '=', $id)->get();
        }

        $gradeArrayTemplate = [
            '1.00' => 0,
            '1.50' => 0,
            '2.00' => 0,
            '2.50' => 0,
            '3.00' => 0,
            '3.50' => 0,
            '4.00' => 0,
            '4.50' => 0,
            '5.00' => 0,
            '5.50' => 0,
            '6.00' => 0,
        ];

        $gradeArray = $gradeArrayTemplate;

        foreach ($grades as $grade) {
            $gradeArray[$grade->value] = $gradeArray[$grade->value] + $grade->weight;
        }

        if ($gradeArrayTemplate === $gradeArray) {
            return Response::make(File::get(storage_path('charts/empty.png')), 200, ['content-type' => 'image/png']);
        }

        $chartGenerator = new GradeChartGenerator();
        $chartGenerator->fileName = storage_path('charts/'.md5($user->id.$id).'.png');
        $chartGenerator->generateGradeBarChart($gradeArray);

        return Response::make(File::get($chartGenerator->fileName), 200, ['content-type' => 'image/png']);
    }
}
