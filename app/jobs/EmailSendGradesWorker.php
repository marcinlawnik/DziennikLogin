<?php

class EmailSendGradesWorker extends SendGradesWorker
{

    public function fire($job, $data){
        $report = new TextReportGeneratorWorker();
        $report->setUser(User::find($data['user_id']));

        Log::info('Generated report', array('report' => $report->getReport()));

        $data = array(
            'grades' => $report->getNotSentGrades()
        );

        Log::info(View::make('emails.grades',$data)->render());

        Mail::send('emails.grades', $data, function($message)
        {
            $message->to('foo@example.com', 'John Smith')->subject('Welcome!');
        });

        $job->delete();

    }

}