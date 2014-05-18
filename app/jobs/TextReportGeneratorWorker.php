<?php

class TextReportGeneratorWorker extends ReportGeneratorWorker
{

    public function getNotSentGrades(){

        $statuses = EmailSendStatus::where('user_id', '=', $this->currentUser->id)->where('status', '=', 0)->get();

        foreach($statuses as $status){
            $grades_ids[] = $status->grade_id;
        }

        return Grade::whereIn('id', $grades_ids)->get();

    }

    public function generateReport(){
        foreach($this->getNotSentGrades() as $grade){
            $report[]=$grade->id;
        }

        $this->reportContent = $report;
    }

}