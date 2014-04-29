<?php

class CheckIfUserNeedsGradeProcessJob extends GradeProcessJob
{
    //This currently does nothing
    public function fire($job, $data){
        Log::info('Job started', array('time' => microtime(true)));
        $request = $this->createRequest();
        $this->doLogin($request, $data['user_id']);
        $table = $this->getGradePage($request);
        Log::info($table);
        Log::info(Hash::make($table));
        $this->doLogout($request);
        $user = User::find($data['user_id']);
        if($user->grade_table_hash != Hash::make($table)){
            $user->grade_table_hash = Hash::make($table);
            $user->is_changed = 1;
            $user->save();
            Log::info('User grade page status updated');
            //TODO: push a new job to queue to process table
        } else {
            //No need to do anything as the table has not changed
        }

        Log::info('Job successful', array('time' => microtime(true)));
        //Log::info($table);
        $job->delete();
        Log::info('Job deleted', array('time' => microtime(true)));
    }
}
