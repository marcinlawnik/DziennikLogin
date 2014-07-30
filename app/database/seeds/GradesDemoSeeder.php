<?php

class GradesDemoSeeder extends Seeder {

    public function run()
    {
        Snapshot::create(
            [
                'hash' => md5('testsnapshot1'),
                'user_id' => 1,
                'table_html' => '<html>'
            ]
        );


        $values = array(
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

        $groups_abbreviations = array(
            'kartkówki' => 'KKE',
            'sprawdziany' => 'SPR',
            'egzaminy próbne' => 'EPR',
            'kartkówki elementarne' => 'KKE',
            'dłuższe odpowiedzi ustne' => 'DOU',
            'skomplikowane zadanie domowe' => 'SZD',
            'prace klasowe' => 'PK',
            'Poprawy prac klasowych' => 'PPK',

        );
        // Seed database with 50 random grades belonging to user_id == 1
        $i=0;
        $grades = array();
        while ($i<=50) {
            $random_value = $values[array_rand($values)];
            $random_group = array_rand($groups_abbreviations);
            $random_abbrev = $groups_abbreviations[$random_group];
            $random_date = date("Y-m-d", rand(1378159200, 1404684000));
            $grades[] = array(
                'user_id' => 1,
                'snapshot_id' => 1,
                'subject_id' => mt_rand(1, 34),
                'value' => $random_value,
                'weight' => mt_rand(1, 4),
                'group' => $random_group,
                'title' => 'ocena z '.$random_abbrev,
                'date' => $random_date,
                'abbreviation' => $random_abbrev,
                'trimester' => 1,
            );
            $i++;
        }

        $gradesSnapshot1 = $grades;

        foreach ($gradesSnapshot1 as $grade) {
            Grade::create(
                $grade
            );
        }

        Snapshot::create(
            [
                'hash' => md5('testsnapshot2'),
                'user_id' => 1,
                'table_html' => '<html2>'
            ]
        );

        // Suppose you need to delete 4 items.
        $keys = array_rand($grades, 2);

        // Loop through the generated keys
        foreach ($keys as $key) {
            unset($grades[$key]);
        }

        foreach ($grades as $grade) {
            $grade['snapshot_id'] = 2;
        }

        $gradesSnapshot2 = $grades;

        foreach ($gradesSnapshot2 as $grade) {
            Grade::create(
                $grade
            );
        }

        Snapshot::create(
            [
                'hash' => md5('testsnapshot3'),
                'user_id' => 1,
                'table_html' => '<html3>'
            ]
        );

        while ($i<=3) {
            $random_value = $values[array_rand($values)];
            $random_group = array_rand($groups_abbreviations);
            $random_abbrev = $groups_abbreviations[$random_group];
            $random_date = date("Y-m-d", rand(1378159200, 1404684000));
            $grades[] = array(
                'user_id' => 1,
                'snapshot_id' => 1,
                'subject_id' => mt_rand(1, 34),
                'value' => $random_value,
                'weight' => mt_rand(1, 4),
                'group' => $random_group,
                'title' => 'ocena z '.$random_abbrev,
                'date' => $random_date,
                'abbreviation' => $random_abbrev,
                'trimester' => 1,
            );
            $i++;
        }

        foreach ($grades as $grade) {
            $grade['snapshot_id'] = 3;
        }

        $gradesSnapshot3 = $grades;

        foreach ($gradesSnapshot3 as $grade) {
            Grade::create(
                $grade
            );
        }


    }
}
