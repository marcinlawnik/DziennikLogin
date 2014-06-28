<?php

class CheckIfUserNeedsGradeProcessJob
{

    public function fire($job, $data){
        $start_time = microtime(true);
        Log::debug('Job started_CheckIfUserNeedsGradeProcessJob', array('time' => $start_time));

        $dziennikHandler = new DziennikHandler();

        $user = User::find($data['user_id']);

        $dziennikHandler->setUsername($user->registerusername);
        $dziennikHandler->setPassword(Crypt::decrypt($user->registerpassword));

        $dziennikHandler->doLogin();

        $dziennikHandler->obtainGradePage();

        $table = $dziennikHandler->getGradeTableRawHtml();

        $dziennikHandler->doLogout();

        if($user->grade_table_hash != md5($table)){
            Log::debug('User grade page status updated', array('old_hash' => $user->grade_table_hash, 'hash' => md5($table)));
            $user->grade_table_hash = md5($table);
            $user->is_changed = 1;
            $user->save();
            //Push a new job to queue to process table
            Log::debug('Pushing ExecuteGradeProcessJob to stack for user.', ['user_id' => $user->id]);
            Queue::push('ExecuteGradeProcessJob', array('user_id' => $user->id), 'grade_process');
        } else {
            //No need to do anything as the table has not changed
            Log::debug('User grade page status not changed', array('user_id' => $user->id, 'hash' => md5($table)));
        }

        Log::debug('Job successful', array('time' => microtime(true), 'execution_time' => microtime(true) - $start_time));
        $job->delete();
        Log::debug('Job deleted', array('time' => microtime(true)));
    }

}