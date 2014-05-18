<?php

/**
 * Class ReportGeneratorWorker
 *
 * A mock-up of how should the report generator classes look like
 *
 */
abstract class ReportGeneratorWorker
{

    public $reportContent;

    public  $currentUser;

    public function setUser($user){
        $this->currentUser = $user;
    }

    public abstract function getNotSentGrades();

    public abstract function generateReport();

    public final function getReport(){
        $this->generateReport();
        return $this->reportContent;
    }

}