<?php

class EmailSendGradesWorker extends SendGradesWorker
{

    public function fire($job, $data){

        $start_time = microtime(true);
        Log::info('Job started_EmailSendGradesWorker', array('start_time' => $start_time));

        $report = new TextReportGeneratorWorker();

        $this->userObject = User::find($data['user_id']);

        $report->setUser($this->userObject);

        $grades =  $report->getNotSentGrades();

        if($grades !== false){
            $data = array(
                'grades' => $grades
            );

            Log::info(View::make('emails.grades', $data)->render());

            if(!empty($data['grades'])){
                Mail::send('emails.grades', $data, function($message)
                {
                    $message->to($this->userObject->email)->subject('Oceny z DziennikLogin - ' . date('Y - m - d H:i'));
                });

                //Mark grades as sent
                EmailSendStatus::where('user_id', '=', $this->userObject->id)
                    ->whereIn('grade_id', $report->getNotSentGradesIds())
                    ->update(array('status' => '1'));

                Log::info('Email sent');

            }

        } else {

            Log::info('No grades to send');

        }



        //Delete the job
        $job->delete();
        //Some logs
        Log::info('Job successful', array('time' => microtime(true), 'execution_time' => microtime(true) - $start_time));
    }

}