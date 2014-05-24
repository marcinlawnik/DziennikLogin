<?php

class PushGradeProcessWorker
{

    public function fire($job, $data){

        $users = User::whereIn('id', $data['id'])->get();

        foreach($users as $user){
            Queue::push('CheckIfUserNeedsGradeProcessWorker', array('user_id' => $user->id), 'grade_check');
        }

        $job->delete();


    }

}