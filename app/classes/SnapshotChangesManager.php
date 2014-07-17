<?php

class SnapshotChangesManager
{
    private $user;

    private $added;

    /**
     * @return array
     */
    public function getAdded()
    {
        return $this->added;
    }

    /**
     * @return array
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

    private $deleted;

    /**
     * @param mixed $user
     */
    public function setUser(User $user)
    {
        $this->user = $user;
    }

    public function obtainNewChanges($notifier)
    {
        $addedGrades = SnapshotChange::where('user_id', '=', $this->user->id)
            ->where('is_sent_'.strtolower($notifier), '=', 0)
            ->where('action', '=', 'add')->get(['id']);

        foreach($addedGrades as $addedGrade)
        {
            $this->added[] = Grade::where('id', '=', $addedGrade->id)->first()->toArray();
        }

        $deletedGrades = SnapshotChange::where('user_id', '=', $this->user->id)
            ->where('is_sent_'.$notifier, '=', 0)
            ->where('action', '=', 'delete')->get(['id']);

        foreach($deletedGrades as $deletedGrade)
        {
            $this->deleted[] = Grade::where('id', '=', $deletedGrade->id)->first()->toArray();
        }
    }
}