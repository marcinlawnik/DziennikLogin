<?php

class ExecuteGradeProcessWorker extends GradeProcessWorker
{

    public $gradePageDom;

    public $currentTrimester;

    public $subjectsArray;

    public $currentSubject;

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

        $this->currentSubject = trim(str_replace('&nbsp;', '', $cell->plaintext));
        Log::info('Processing new subject',
            array(
                'name' => $this->currentSubject,
                'id_from_database' => Subject::where('name', '=', $this->currentSubject)->first()->id
            ));

    }

    private function processGradeCell($cell){

        Log::info('processing new grade cell');

    }

    private function processAverageCell($cell){

        //do nothing, we don't yet have an use for it

        Log::info('processing new average cell');

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
