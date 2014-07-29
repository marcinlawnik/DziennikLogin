<?php

class ExecuteGradeProcessJob
{

    public $gradePageDom;

    public $currentTrimester;

    public $subjectsArray;

    public $currentSubjectName;

    public $currentSubjectId;

    public $snapshot;

    private $userObject;

    /**
     * Returns all cells from grades table for user
     *
     * @return object
     */
    public function getGradeCells()
    {
        $response = $this->gradePageDom->find('table', 4)->find('tr td');

        return $response;

    }

    private function setCurrentTrimester()
    {
        //trimester:
        $gradeTrimester = $this->gradePageDom->find('b', 1)->plaintext;

        if (strstr($gradeTrimester, 'III ')) {
            $this->currentTrimester = 3;
        } elseif (strstr($gradeTrimester, 'II ')) {
            $this->currentTrimester = 2;
        } elseif (strstr($gradeTrimester, 'I ')) {
            $this->currentTrimester = 1;
        } else {
            $this->currentTrimester = 9; //Something is not right ;)
            Log::error('Trimester detection failed, setting trimester as 9');
        }

        Log::debug('Obtaining current trimester', array('trimester' => $this->currentTrimester));

    }

    private function createSubjectsArray()
    {
        //2. Powinieneś najpierw spróbować pobrać za jednym zamachem wszystkie ID przedmiotów na podstawie ich nazw.
        //Dopiero w następnym kroku utworzyć nowe rekordy w bazie dla nieistniejących jeszcze przedmiotów.
        //Get all subjects from database
        $subjects = Subject::get();

        //Create table suitable for us
        if (!$subjects->isEmpty()) {
            foreach ($subjects as $subject) {
                $this->subjectsArray[$subject->id] = $subject->name;
            }
        } else {
            $this->subjectsArray = array();
        }
        Log::debug('Obtained subjects array', array('subjectsArray' => $this->subjectsArray));

    }

    private function processSubjectCell($cell)
    {
        $this->currentSubjectName = trim(str_replace('&nbsp;', '', $cell->plaintext));
        if (in_array($this->currentSubjectName, $this->subjectsArray)) {

            $this->currentSubjectId = Subject::where('name', '=', $this->currentSubjectName)->first()->id;

            Log::debug(
                'Processing subject',
                array(
                    'name' => $this->currentSubjectName,
                    'id_from_database' => $this->currentSubjectId,
                )
            );

        } else {

            Log::debug('Creating new subject');

            $subject = Subject::create(array('name' => $this->currentSubjectName));

            $this->currentSubjectId = $subject->id;

            $this->createSubjectsArray();

            Log::debug(
                'Processing NEW subject',
                array(
                    'name' => $this->currentSubjectName,
                    'id_from_database' => $this->currentSubjectId,
                )
            );

        }

    }

    private function processGradeCell($cell)
    {
        //get all the needed values
        //grade abbreviation (the text from cell)
        $gradeAbbreviation = strtoupper(trim(substr($cell->plaintext, 0, 3)));

        //grade numerical value (the number from cell)
        $gradeValue = filter_var($cell->plaintext, FILTER_SANITIZE_NUMBER_INT);
        //See if it has +, add a 0,5 then
        //TODO: fix if some teacher puts plus in description
        if (strpos($cell->plaintext, '+') !== false) {
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
        //check if gradeWeight is really a number, if not, then its 1
        if (strcspn($gradeWeight, '0123456789') == strlen($gradeWeight)) {
            $gradeWeight = '1';
        } else {
            $gradeWeight = round($gradeWeight);
        }

        Grade::create(array(
            'user_id' => $this->userObject->id,
            'snapshot_id' => $this->snapshot->id,
            'subject_id' => $this->currentSubjectId,
            'value' => $gradeValue,
            'weight' => $gradeWeight,
            'group' => $gradeGroup,
            'title' => $gradeTitle,
            'date' => $gradeDate,
            'abbreviation' => $gradeAbbreviation,
            'trimester' => $this->currentTrimester,
        ));

    }

    private function processAverageCell($cell)
    {
        //do nothing, we don't yet have an use for it

        $average = trim($cell->plaintext);

        if ($average >= 1.00) {
            Log::debug(
                'Processing new average cell',
                array(
                    'subject' => $this->currentSubjectName,
                    'average' => $average
                )
            );
        } else {
            Log::debug('Processing empty average cell', array('subject' => $this->currentSubjectName));
        }

    }

    private function processGradePage($cells)
    {
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

                //grade: has number inside and isn't empty
                $this->processGradeCell($cell);

            }
        }

    }

    //this simply fires
    public function fire($job, $data)
    {
        $start_time = microtime(true);
        Log::debug('Job started_ExecuteGradeProcessJob', array('start_time' => $start_time));

        //Create new handler
        $dziennikHandler = new DziennikHandler();

        //Find user
        $this->userObject = User::find($data['user_id']);

        //Pass credentials to handler
        $dziennikHandler->setUsername($this->userObject->registerusername);
        $dziennikHandler->setPassword(Crypt::decrypt($this->userObject->registerpassword));

        //Login
        $dziennikHandler->doLogin();

        //Grab grade page
        $dziennikHandler->obtainGradePage();

        //Take the Htmldom object of it
        $this->gradePageDom = $dziennikHandler->getGradePageDom();

        //Logout
        $dziennikHandler->doLogout();

        $this->setCurrentTrimester();
        $this->createSubjectsArray();

        //Create snapshot
        $this->snapshot = new Snapshot();
        $this->snapshot->hash = md5($dziennikHandler->getGradeTableRawHtml());
        $this->snapshot->user_id = $this->userObject->id;
        $this->snapshot->table_html = $dziennikHandler->getGradeTableRawHtml();
        $this->snapshot->save();

        $this->processGradePage($this->getGradeCells());

        //Mark job as done
        $this->userObject->is_changed = 0;
        $this->userObject->save();
        //Push new email job for user
        //TODO: Options to get email whenever they want
        Log::debug('Pushing Snapshot comparison job for user', array('user_id' => $data['user_id']));
        //$time = Carbon::now()->addMinutes(5);
        Queue::push('CompareGradeSnapshotsJob', array('user_id' => $data['user_id']), 'grade_process');
        //Some logs
        Log::debug('Job successful', ['time' => microtime(true), 'execution_time' => microtime(true) - $start_time]);
        //Log::info($table);
        $job->delete();
        Log::debug('Job deleted', array('time' => microtime(true)));

    }
}
