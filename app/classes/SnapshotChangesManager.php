<?php

class SnapshotChangesManager
{
    private $user;

    private $addedGrades;

    private $deletedGrades;

    private $snapshotChangesAdded;

    private $snapshotChangesDeleted;

    private $notifier;

    /**
     * @param mixed $notifier
     */
    public function setNotifier($notifier)
    {
        $this->notifier = strtolower($notifier);
    }

    /**
     * @return array
     */
    public function getAddedGrades()
    {
        return $this->addedGrades;
    }

    /**
     * @return array
     */
    public function getDeletedGrades()
    {
        return $this->deletedGrades;
    }

    /**
     * @param mixed $user
     */
    public function setUser(User $user)
    {
        $this->user = $user;
    }

    public function obtainNewChanges()
    {
        $this->snapshotChangesAdded = SnapshotChange::where('user_id', '=', $this->user->id)
            ->where('is_sent_'.$this->notifier, '=', 0)
            ->where('action', '=', 'add')->get();

        foreach($this->snapshotChangesAdded as $snapshotChangeAdded)
        {
            $this->addedGrades[] = Grade::where('id', '=', $snapshotChangeAdded->grade_id)->first();
        }

        $this->snapshotChangesDeleted = SnapshotChange::where('user_id', '=', $this->user->id)
            ->where('is_sent_'.$this->notifier, '=', 0)
            ->where('action', '=', 'delete')->get();

        foreach($this->snapshotChangesDeleted as $snapshotChangeDeleted)
        {
            $this->deletedGrades[] = Grade::where('id', '=', $snapshotChangeDeleted->grade_id)->first();
        }
    }

    public function markChangesAsSent()
    {

        $notifyFieldName = 'is_sent_'.$this->notifier;
        foreach($this->snapshotChangesAdded as $snapshotChangeAdded)
        {
            $snapshotChangeAdded->{$notifyFieldName} = 1;
            $snapshotChangeAdded->save();
        }

        foreach($this->snapshotChangesDeleted as $snapshotChangeDeleted)
        {
            $snapshotChangeDeleted->{$notifyFieldName} = 1;
            $snapshotChangeDeleted->save();
        }
    }
}