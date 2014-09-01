<?php

class GradesDemoSeeder extends Seeder
{


    public $grades = [];

    public $trimester;

    public $snapshotId;

    public $userId;

    public $values = array(
    '1',
    '1.5',
    '2',
    '2.5',
    '3',
    '3.5',
    '4',
    '4.5',
    '5',
    '5.5',
    '6',
    );

    public $groupsAbbreviations = array(
    'kartkówki' => 'KKE',
    'sprawdziany' => 'SPR',
    'egzaminy próbne' => 'EPR',
    'kartkówki elementarne' => 'KKE',
    'dłuższe odpowiedzi ustne' => 'DOU',
    'skomplikowane zadanie domowe' => 'SZD',
    'prace klasowe' => 'PK',
    'Poprawy prac klasowych' => 'PPK',

    );

    public function addRandomGrades($amount = 50)
    {
        //Add random grades to array
        $i=1;
        while ($i<=$amount) {
            $randomValue = $this->values[array_rand($this->values)];
            $randomGroup = array_rand($this->groupsAbbreviations);
            $randomAbbrev = $this->groupsAbbreviations[$randomGroup];
            $randomDate = date("Y-m-d", rand(1378159200, 1404684000));
            $this->grades[] = array(
                'user_id' => $this->userId,
                'snapshot_id' => $this->snapshotId,
                'subject_id' => mt_rand(1, 24),
                'value' => $randomValue,
                'weight' => mt_rand(1, 4),
                'group' => $randomGroup,
                'title' => 'Ocena z '.$randomAbbrev,
                'date' => $randomDate,
                'abbreviation' => $randomAbbrev,
                'trimester' => $this->trimester,
            );
            $i++;
        }
    }

    public function putGradesToDatabase()
    {
        $this->updateSnapshotId();
        $this->updateTrimester();
        foreach ($this->grades as $grade) {
            Grade::create(
                $grade
            );
        }
    }

    public function deleteRandomGrades($amount = 2)
    {
        // Suppose you need to delete 2 items.
        $keys = array_rand($this->grades, $amount);

        // Loop through the generated keys
        foreach ($keys as $key) {
            unset($this->grades[$key]);
        }
    }

    public function updateSnapshotId()
    {
        foreach ($this->grades as $grade) {
            $grade['snapshot_id'] = $this->snapshotId;
            $this->grades[] = $grade;
        }
    }

    public function updateTrimester()
    {
        foreach ($this->grades as $grade) {
            $grade['trimester'] = $this->trimester;
            $this->grades[] = $grade;
        }
    }

    public function createSnapshot()
    {
        $snapshot = Snapshot::create(
            [
                'hash' => md5('testsnapshot'.$this->snapshotId),
                'user_id' => $this->userId,
                'table_html' => '<html'.$this->snapshotId.'>'
            ]
        );
        $this->snapshotId = $snapshot->id;
    }

    public function run()
    {

        $trimesters = [
            '1',
            '1',
            '2',
            '2',
            '2',
            '3',
            '3',
            '3',
            '3',
            '3'
        ];

        $users = [
            '1',
            '2'
        ];

        foreach ($users as $user) {
            $this->userId = $user;
            $i=0;
            while ($i <= 9) {
                $this->createSnapshot();
                $this->trimester = $trimesters[$i];
                if ($i === 0) {
                    $this->addRandomGrades(50);
                    $this->putGradesToDatabase();
                } else {
                    $rand = mt_rand(0, 100);
                    if ($rand > 50) {
                        //add
                        $this->addRandomGrades();
                    } else {
                        //delete
                        $this->deleteRandomGrades();
                    }
                    $this->putGradesToDatabase();
                }

                $i++;
            }
        }
    }
}
