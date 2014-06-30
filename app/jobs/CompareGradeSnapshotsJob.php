<?php

class CompareGradeSnapshotsJob
{

    public function fire($job, $data){

//        try
//        {
            $start_time = microtime(true);
            Log::debug('Job started_CompareGradeSnapshotsJob', array('start_time' => $start_time));

            //Find user
            $user = User::find($data['user_id']);

            if($user->snapshots()->orderBy('created_at', 'DESC')->get()->count() === 0){
                throw new Exception('SnapshotTo does not exist');
            } else {
                //Latest snapshot - ID
                $snapshot_to = $user->snapshots()->orderBy('created_at', 'DESC')->first(['id']);
            }

            //Snapshot before latest - ID
            if($user->snapshots()->orderBy('created_at', 'DESC')->get()->count() < 2){
                //Set as null to let others know
                $snapshot_from = null;
                //dd($snapshot_from);
            } else {
                $snapshot_from = $user->snapshots()->orderBy('created_at', 'DESC')->skip(1)->take(1)->get(['id']);
            }

            Log::debug('Comparing snapshots',[
                'snapshot_from' => (!is_null($snapshot_from) ? $snapshot_from->first()->id : null),
                'snapshot_to' => $snapshot_to->id
            ]);

            $comparator = new SnapshotComparator();

            //Check if not already done

            if(SnapshotChange::where('snapshot_id_from', '=', (!is_null($snapshot_from) ? $snapshot_from->first()->id : null))->where('snapshot_id_to', '=', $snapshot_to->id)->exists())
            {
                Log::debug('Not processing already processed snapshot difference');
                Log::debug('Job successful', array('time' => microtime(true), 'execution_time' => microtime(true) - $start_time));
                $job->delete();
                Log::debug('Job deleted', array('time' => microtime(true)));
            }

            $comparator->setSnapshotFrom((!is_null($snapshot_from) ? $snapshot_from->first() : null));
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
//        }
//        catch(Exception $e)
//        {
//            Log::debug('Exception occurred'.$e->getMessage().$e->getLine());
//            Log::debug('Job NOT successful', array('time' => microtime(true), 'execution_time' => microtime(true) - $start_time));
//            $job->delete();
//            Log::debug('Job deleted', array('time' => microtime(true)));
//        }


    }

}