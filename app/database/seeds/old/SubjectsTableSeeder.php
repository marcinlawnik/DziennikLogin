<?php

class SubjectsTableSeeder extends Seeder {

    public function run()
    {
        //DB::table('users')->delete();

        $subjects = array(
            array(
                'id' => '1',
                'name' => 'biologia',
            ),
            array(
                'id' => '2',
                'name' => 'chemia',
            ),
            array(
                'id' => '3',
                'name' => 'fizyka',
            ),
            array(
                'id' => '4',
                'name' => 'geografia',
            ),
            array(
                'id' => '5',
                'name' => 'historia',
            ),
            array(
                'id' => '6',
                'name' => 'j. niemiecki',
            ),
            array(
                'id' => '7',
                'name' => 'j. polski',
            ),
            array(
                'id' => '8',
                'name' => 'matematyka',
            ),
            array(
                'id' => '9',
                'name' => 'plastyka',
            ),
            array(
                'id' => '10',
                'name' => 'wos',
            ),
            array(
                'id' => '11',
                'name' => 'wf',
            ),
            array(
                'id' => '12',
                'name' => 'j. angielski z',
            ),
            array(
                'id' => '13',
                'name' => 'religia',
            ),
            array(
                'id' => '14',
                'name' => 'lekcja wychowawcza',
            ),
            array(
                'id' => '15',
                'name' => 'wn biomedycyna',
            ),
            array(
                'id' => '16',
                'name' => 'informatyka',
            ),
            array(
                'id' => '17',
                'name' => 'j. angielski k',
            ),
            array(
                'id' => '18',
                'name' => 'wi',
            ),
            array(
                'id' => '19',
                'name' => 'edukacja dla bezpieczeństwa',
            ),
            array(
                'id' => '20',
                'name' => 'chemia pz',
            ),
            array(
                'id' => '21',
                'name' => 'fizyka pz',
            ),
            array(
                'id' => '22',
                'name' => 'j. niemiecki pz',
            ),
            array(
                'id' => '23',
                'name' => 'matematyka pz',
            ),
            array(
                'id' => '24',
                'name' => 'wn informatyka',
            ),
            array(
                'id' => '25',
                'name' => 'zajęcia artystyczne',
            ),
            array(
                'id' => '26',
                'name' => 'zajęcia techniczne',
            ),
            array(
                'id' => '27',
                'name' => 'wn piłka halowa',
            ),
            array(
                'id' => '28',
                'name' => 'wn robotyka',
            ),
            array(
                'id' => '29',
                'name' => 'j. angielski p',
            ),
            array(
                'id' => '30',
                'name' => 'zajęcia artystyczne gr.2',
            ),
            array(
                'id' => '31',
                'name' => 'wn teatr',
            ),
            array(
                'id' => '32',
                'name' => 'w klub psychologiczny',
            ),
            array(
                'id' => '33',
                'name' => 'przyroda',
            ),
            array(
                'id' => '34',
                'name' => 'muzyka',
            ),

        );


        foreach ($subjects as $subject) {
            Subject::create($subject);
        }

    }

}