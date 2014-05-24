<?php

try{

    $users = User::all();

    $counter = 0;

    $ids = array();

    foreach($users as $user){
        Queue::push('CheckIfUserNeedsGradeProcessWorker', array('user_id' => $user->id), 'grade_check');
        $counter++;
        $ids[] = $user->id;
    }

    Log::info('Pushed check jobs for users', array('users_amount' => $counter, 'users_ids' => $ids));

} catch (Exception $e){

    Log::error('Something bad happened at pushing jobs.');

}
