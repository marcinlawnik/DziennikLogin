<?php

class ExecuteGradesProcessJob extends GradeProcessJob
{
    //this simply fires
    public function fire($job, $data){
        Log::info('Job started', array('time' => microtime(true)));
        $request = $this->createRequest();
        $this->doLogin($request, $data['user_id']);
        $table = $this->getGradePage($request);
        Log::info($table);
        $this->doLogout($request);
        Log::info('Job successful', array('time' => microtime(true)));
        //Log::info($table);
        $job->delete();
        Log::info('Job deleted', array('time' => microtime(true)));
    }
}
