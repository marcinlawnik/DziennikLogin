<?php

class CheckIfUserNeedsGradeProcessWorker extends GradeProcessWorker
{

    public function fire($job, $data){
        $start_time = microtime(true);
        Log::info('Job started_CheckIfUserNeedsGradeProcessWorker', array('time' => $start_time));
        $request = $this->createRequest();
        $this->doLogin($request, $data['user_id']);
        $table = $this->getGradeTable($request);
        //Log::info($table);
        //Log::info(md5($table));
        $this->doLogout($request);
        $user = User::find($data['user_id']);
        if($user->grade_table_hash != md5($table)){
            Log::info('User grade page status updated', array('old_hash' => $user->grade_table_hash, 'hash' => md5($table)));
            $user->grade_table_hash = md5($table);
            $user->is_changed = 1;
            $user->save();
            //Push a new job to queue to process table
            Log::info('Pushing ExecuteGradeProcessWorker to stack for user.');
            Queue::push('ExecuteGradeProcessWorker', array('user_id' => $user->id));
        } else {
            //No need to do anything as the table has not changed
            Log::info('User grade page status not changed', array('hash' => md5($table)));
        }

        Log::info('Job successful', array('time' => microtime(true), 'execution_time' => microtime(true) - $start_time));
        //Log::info($table);
        $job->delete();
        Log::info('Job deleted', array('time' => microtime(true)));
    }

}
