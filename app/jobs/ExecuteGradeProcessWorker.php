<?php

class ExecuteGradeProcessWorker extends GradeProcessWorker
{

    public $gradePageDom;

    public $currentTrimester;

    public $subjectsArray;

    public $currentSubjectName;

    public $currentSubjectId;

    private function createGradePageDom($request){
        $this->gradePageDom = new Htmldom($this->getGradePage($request));
    }

    /**
     * Returns all cells from grades table for user
     *
     * @return object
     */
    public function getGradeCells() {

        $response = $this->gradePageDom->find('table', 4)->find('tr td');
        return $response;

    }

    private function setCurrentTrimester() {

        //trimester:
        $gradeTrimester = $this->gradePageDom->find('b', 1)->plaintext;

        if (strstr($gradeTrimester,'III ')){
            $this->currentTrimester = 3;
        }elseif(strstr($gradeTrimester,'II ')){
            $this->currentTrimester = 2;
        }elseif(strstr($gradeTrimester,'I ')){
            $this->currentTrimester = 1;
        }else{
            $this->currentTrimester = 9; //Something is not right ;)
            Log::error('Trimester detection failed, setting trimester as 9');
        }

        Log::info('Obtaining current trimester', array('trimester' => $this->currentTrimester));

    }

    private function createSubjectsArray(){

        //2. Powinieneś najpierw spróbować pobrać za jednym zamachem wszystkie ID przedmiotów na podstawie ich nazw.
        //Dopiero w następnym kroku utworzyć nowe rekordy w bazie dla nieistniejących jeszcze przedmiotów.

        //get all subjects from db
        $subjects = Subject::all();

        //Create table suitable for us
        foreach($subjects as $subject){
            $subjectsArray[$subject->id] = $subject->name;
        }

        Log::info('Obtained subjects array', array('subjectsArray' => $subjectsArray));

        return $subjectsArray;

    }

    private function processSubjectCell($cell){

        $this->currentSubjectName = trim(str_replace('&nbsp;', '', $cell->plaintext));
        if(in_array($this->currentSubjectName, $this->subjectsArray)){

            $this->currentSubjectId = Subject::where('name', '=', $this->currentSubjectName)->first()->id;

            Log::info('Processing subject',
                array(
                    'name' => $this->currentSubjectName,
                    'id_from_database' => $this->currentSubjectId,
                ));


        } else {

            Log::info('Creating new subject');

            $subject = Subject::create(array('name' => $this->currentSubjectName));

            $this->currentSubjectId = $subject->id;

            $this->createSubjectsArray();

            Log::info('Processing NEW subject',
                array(
                    'name' => $this->currentSubjectName,
                    'id_from_database' => $this->currentSubjectId,
                ));

        }

    }

    private function processGradeCell($cell){

        //get all the needed values
        $gradeAbbrev = strtoupper(trim(substr($cell->plaintext, 0, 3))); //grade abbreviation (the text from cell)
        $gradeValue = filter_var($cell->plaintext, FILTER_SANITIZE_NUMBER_INT); //grade numerical value (the number from cell)
        //See if it has +, add a 0,5 then
        //TODO: fix if some teacher puts plus in description
        if (strpos($cell->plaintext, '+') !== FALSE) {
            $gradeValue = $gradeValue[0] + 0.5;
        }
        //now we need to dive into the onmouseover attribute
        $onMouseOverDom = new Htmldom();
        $onMouseOverDom->load($cell->onmouseover);
        $gradeDate = date('Y-m-d', strtotime($onMouseOverDom->find('td', '1')->plaintext)); //date of grade
        @$gradeTitle = $onMouseOverDom->find('i', '1')->plaintext; //title of grade
        if (is_null($gradeTitle)) {
            $gradeTitle = 'BRAK OPISU OCENY'; //dirty hack around those lazy teachers that don't set the title
        }
        $gradeGroup = $onMouseOverDom->find('p', '1')->plaintext; //group of grade
        $gradeWeight = trim($onMouseOverDom->find('td', '3')->plaintext); //weight of grade
        //free up resources
        $onMouseOverDom->clear();
        unset($onMouseOverDom);
        if (strcspn($gradeWeight, '0123456789') == strlen($gradeWeight)) {//check if gradeWeight is really a number, if not, then its 1
            $gradeWeight = '1';
        } else {
            $gradeWeight = round($gradeWeight);
        }

        Log::info('processing new grade cell',
            array(
                'subject' => $this->currentSubjectName,
                'abbrev' => $gradeAbbrev,
                'value' => $gradeValue,
                'date' => $gradeDate,
                'title' => $gradeTitle,
                'weight' => $gradeWeight,
                'group' => $gradeGroup,
            ));



    }

    private function processAverageCell($cell){

        //do nothing, we don't yet have an use for it

        $average = trim($cell->plaintext);

        Log::info('processing new average cell', array('subject' => $this->currentSubjectName, 'average' => $average));

    }

    private function processGradePage($cells){

        foreach ($cells as $cell) {

            //switch depending on the type of the cell: subject name, average or grade cell
            //in that order, or else average is detected as grade
            if (!isset($cell->class) && !isset($cell->onmouseover) && $cell->plaintext != '') {

                //subject name: has text inside and no attributes
                //echo 'subject name:' . ' ' . $cell->plaintext;
                $this->processSubjectCell($cell);

            } elseif ($cell->class == 'cell-style-srednia') {

                //average: class: cell-style-srednia
                //echo'srednia:' . ' ' . $cell->plaintext;
                $this->processAverageCell($cell);

            } elseif (strcspn($cell->plaintext, '0123456789') != strlen($cell->plaintext)) {

                //grade: has number inside and isnt empty
                $this->processGradeCell($cell);

            }
        }

    }
    //this simply fires
    public function fire($job, $data){

        $start_time = microtime(true);
        Log::info('Job started_ExecuteGradeProcessWorker', array('start_time' => $start_time));
        $request = $this->createRequest();
        $this->doLogin($request, $data['user_id']);
        $this->createGradePageDom($request);
        $this->doLogout($request);
        $this->setCurrentTrimester();
        $this->subjectsArray = $this->createSubjectsArray();
        $this->processGradePage($this->getGradeCells());
        Log::info('Job successful', array('time' => microtime(true), 'execution_time' => microtime(true) - $start_time));
        //Log::info($table);
        $job->delete();
        Log::info('Job deleted', array('time' => microtime(true)));

    }
}
