<?php

class TextReportGeneratorWorker extends ReportGeneratorWorker
{

    public function getNotSentGradesIds(){

        $statuses = EmailSendStatus::where('user_id', '=', $this->currentUser->id)->where('status', '=', 0)->get();

        $grades_ids = array();

        foreach($statuses as $status){
            $grades_ids[] = $status->grade_id;
        }

        return $grades_ids;

    }

    public function getNotSentGrades(){

        $ids = $this->getNotSentGradesIds();

        if(!empty($ids)){
            return Grade::with('subject')->whereIn('id', $ids)->get();
        } else {
            return false;
        }

    }

    public function generateReport(){
        foreach($this->getNotSentGrades() as $grade){
            $report[]=$grade->id;
        }

        $this->reportContent = $report;
    }

}