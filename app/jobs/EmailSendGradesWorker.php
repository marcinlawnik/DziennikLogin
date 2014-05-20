<?php

class EmailSendGradesWorker extends SendGradesWorker
{

    public function fire($job, $data){
        $report = new TextReportGeneratorWorker();
        $this->userObject = User::find($data['user_id']);
        $report->setUser($this->userObject);

        Log::info('Generated report', array('report' => $report->getReport()));

        $data = array(
            'grades' => $report->getNotSentGrades()
        );

        Log::info(View::make('emails.grades',$data)->render());

        Mail::send('emails.grades', $data, function($message)
        {
            $message->to($this->userObject->email)->subject('Oceny z DziennikLogin - '. date('Y - m - d H:i'));
        });

        Log::info('Deleting job', array());

        $job->delete();

    }

}