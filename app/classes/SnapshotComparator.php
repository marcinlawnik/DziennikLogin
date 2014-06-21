<?php

/**
 * Class SnapshotComparator
 */
class SnapshotComparator
{
    /**
     * @var
     */
    private $snapshotFrom;

    /**
     * @var
     */
    private $snapshotTo;

    /**
     * @var
     */
    private $added = [];

    /**
     * @var
     */
    private $user;

    /**
     * @var
     */
    private $deleted = [];

    /**
     * @return mixed
     */
    public function getAdded()
    {
        return $this->added;
    }

    /**
     * @return mixed
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

    /**
     * @param User $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }



    /**
     * @param Snapshot $snapshotFrom
     */
    public function setSnapshotFrom(Snapshot $snapshotFrom)
    {
        $this->snapshotFrom = $snapshotFrom;
    }

    /**
     * @param Snapshot $snapshotTo
     */
    public function setSnapshotTo(Snapshot $snapshotTo)
    {
        $this->snapshotTo = $snapshotTo;
    }

    /**
     * @param $a
     * @param $b
     * @return int
     */
    static private function udiffCompareGradesInArrays($a, $b)
    {
        return strcmp(implode("",$a), implode("",$b));
    }

    /**
     *
     */
    public function compare()
    {

        //Get grades for each snapshot
        $snapshotToGrades =
            $this->snapshotTo
            ->grades()
            ->get(['subject_id', 'value', 'weight', 'group', 'title', 'date', 'abbreviation', 'trimester'])
            ->toArray();

        $snapshotFromGrades =
            $this->snapshotFrom
            ->grades()
            ->get(['subject_id', 'value', 'weight', 'group', 'title', 'date', 'abbreviation', 'trimester'])
            ->toArray();

        //Added grades
        $addedGrades = array_udiff($snapshotFromGrades,$snapshotToGrades, 'self::udiffCompareGradesInArrays');

        foreach($addedGrades as $id => $grade){
            $this->added[] = Grade::find($id);
        }
        //Deleted grades
        $deletedGrades = array_udiff($snapshotToGrades, $snapshotFromGrades, 'self::udiffCompareGradesInArrays');

        foreach($deletedGrades as $id => $grade){
            $this->deleted[] = Grade::find($id);
        }

    }

    /**
     *
     */
    public function process()
    {
        foreach($this->added as $grade)
        {
            $snapshotChange = new SnapshotChange([
                'snapshot_id_from' => $this->snapshotFrom->id,
                'snapshot_id_to' => $this->snapshotTo->id,
                'action' => 'add',
                'is_sent_email' => 0
            ]);

            $snapshotChange->user()->associate($this->user);

            $snapshotChange->grade()->associate($grade);

            $snapshotChange->save();
        }

        foreach($this->deleted as $grade)
        {
            $snapshotChange = new SnapshotChange([
                'snapshot_id_from' => $this->snapshotFrom->id,
                'snapshot_id_to' => $this->snapshotTo->id,
                'action' => 'delete',
                'is_sent_email' => 0
            ]);

            $snapshotChange->user()->associate($this->user);

            $snapshotChange->grade()->associate($grade);

            $snapshotChange->save();
        }
    }

}