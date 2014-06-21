<?php

class CompareGradeSnapshotsJob
{

    public function fire($job, $data){

        $start_time = microtime(true);
        Log::debug('Job started_CompareGradeSnapshotsJob', array('start_time' => $start_time));

        //Find user
        $user = User::find($data['user_id']);

        //Latest snapshot - ID
        $snapshot_to = $user->snapshots()->orderBy('created_at', 'DESC')->first(['id']);
        //Snapshot before latest - ID
        $snapshot_from = $user->snapshots()->orderBy('created_at', 'DESC')->skip(1)->first(['id']);

        Log::debug('Comparing snapshots',[
            'snapshot_from' => $snapshot_from->id,
            'snapshot_to' => $snapshot_to->id
        ]);

        $comparator = new SnapshotComparator();

        //Check if not already done

        if(SnapshotChange::where('snapshot_id_from', '=', $snapshot_from->id)->where('snapshot_id_to', '=', $snapshot_to->id)->exists())
        {
            Log::debug('Not processing already processed snapshot difference');
            Log::debug('Job successful', array('time' => microtime(true), 'execution_time' => microtime(true) - $start_time));
            $job->delete();
            Log::debug('Job deleted', array('time' => microtime(true)));
        }

        $comparator->setSnapshotFrom($snapshot_from);
        $comparator->setSnapshotTo($snapshot_to);

        $comparator->setUser($user);

        $comparator->compare();
        $comparator->process();

        Log::debug('Job successful', [
            'time' => microtime(true),
            'execution_time' => microtime(true) - $start_time,
        ]);
        $job->delete();
        Log::debug('Job deleted', array('time' => microtime(true)));

    }

}