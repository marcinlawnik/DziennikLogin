<?php

class GradeChangesEmailNotifyJob extends NotifyJob
{

    function __construct()
    {
        $this->notifier = 'Email';
    }

    public function fire ($job, $data)
    {
        $start_time = microtime(true);
        Log::debug('Job started_GradeChangesEmailNotifyJob', array('start_time' => $start_time));

        $user = User::find($data['user_id']);

        //Set the recipient
        $this->recipient = $user->email;
        //Obtain the necessary data
        $manager = new SnapshotChangesManager();
        $manager->setUser($user);
        $manager->obtainNewChanges($this->notifier);
        //Set the message (array of data in this case, templates handled by notifier)
        $this->message = ['added' => $manager->getAdded(), 'deleted' => $manager->getDeleted()];

        dd($this->message);

        //Send the notification
        $this->executeNotifying();

        Log::debug('Job successful', [
            'time' => microtime(true),
            'execution_time' => microtime(true) - $start_time,
        ]);
        $job->delete();
        Log::debug('Job deleted', array('time' => microtime(true)));
    }
}