<?php

class GradesTableSeeder extends Seeder {

    public function run()
    {
        //DB::table('users')->delete();


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
        // Seed database with 50 random grades belonging to user_id ==1
        $i=0;
        while($i<50){
            $random_value = $values[array_rand($values)];
            $random_group = array_rand($groups_abbreviations);
            $random_abbrev = $groups_abbreviations[$random_group];
            $random_date = date("Y-m-d",rand(1378159200,1404684000));
            Grade::create(array(
                'user_id' => '1',
                'subject_id' => mt_rand(1,34),
                'value' => $random_value,
                'weight' => mt_rand(1,4),
                'group' => $random_group,
                'title' => 'ocena z '.$random_abbrev,
                'date' => $random_date,
                'abbreviation' => $random_abbrev,
                'trimester' => mt_rand(1,3),
            ));
            $i++;
        }

    }

}