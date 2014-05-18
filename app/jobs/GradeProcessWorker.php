<?php

class GradeProcessWorker
{

    public $currentUserObject;

    /**
     * Takes User object as a parameter and returns POST string used to log into register
     *
     * @param $user
     * @return string
     */
    public function getPostData($user){
        return 'user_name=' . $user->registerusername . '&user_passwd=' . Crypt::decrypt($user->registerpassword) . '&con=e-dziennik-szkola01.con';
    }

    /**
     * Creates a cURL request with necessary options
     *
     * @return Request
     */
    public function createRequest(){
        $request = new jyggen\Curl\Request('https://92.55.225.11/dbviewer/login.php');
        //Ignore SSL because certificate is messed up - poses a MiTM threat but who cares about poor grades
        $request->setOption(CURLOPT_SSL_VERIFYPEER, false);
        $request->setOption(CURLOPT_SSL_VERIFYHOST, false);
        //Setting useragent string - this one is my laptop
        $request->setOption(CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Linux i686) AppleWebKit/537.22 (KHTML, like Gecko) Ubuntu Chromium/25.0.1364.160 Chrome/25.0.1364.160 Safari/537.22');
        //Already set in class by default - http://docs.jyggen.com/curl/request
        //$request->setOption(CURLOPT_RETURNTRANSFER, 1);
        //Follow redirects
        $request->setOption(CURLOPT_FOLLOWLOCATION, 1);
        //Allow the register some time to think, because it's slow as hell
        $request->setOption(CURLOPT_TIMEOUT, 60);
        //Who stole the cookies from the cookie jar?
        $request->setOption(CURLOPT_COOKIEJAR, storage_path('cookie.txt'));//insert path of storage by laravel
        $request->setOption(CURLOPT_COOKIEFILE, storage_path('cookie.txt'));//insert path of storage by laravel
        Log::info('Request created');// array('context' => $request->getInfo())
        return $request;
    }

    /**
     * Requests login into register for specified user.
     * Returns true on success, false otherwise.
     * @param $request
     * @param $user_id
     * @return bool
     */
    public function doLogin($request, $user_id){
        //Find the user
        $this->currentUserObject = User::find($user_id);
        if($this->currentUserObject == ''){
            Log::error('User not found.', array('user_id' => $user_id));
            return false;
        } else {
            Log::info('User found.', array('user_id' => $user_id));
        }

        //We will be supplying post data
        $request->setOption(CURLOPT_POST, 1);
        //The actual post data
        $request->setOption(CURLOPT_POSTFIELDS, $this->getPostData($this->currentUserObject));
        //Aaaand - execute!
        $request->execute();
        //If it twerks then it works ;)
        if($request->isSuccessful()){
            Log::info('Request to login successful');
            //Log::info($request->getInfo());
            //Log::info($request->getRawResponse());
            return true;
        } else {
            Log::error('Request to login failed', array('error' => $request->getErrorMessage()));
            return false;
        }

    }

    /**
     * Requests logout out of register. Does not require specifying user as all is done in one request.
     * Returns true on success, false otherwise.
     *
     * @param $request
     * @return bool
     */
    public function doLogout($request){
        //Set logout URL
        $request->setOption(CURLOPT_URL, 'https://92.55.225.11/dbviewer/logout.php?con=e-dziennik-szkola01.con&location=..');
        //FIRE!
        $request->execute();
        //If it works...
        if($request->isSuccessful()){
            Log::info('Logout successful.');
            return true;
        } else {
            Log::error('Logout failed.', array('error' => $request->getErrorMessage()));
            return false;
        }
    }

    /**
     * Requests grade page for specific user.
     * Returns grade page on success, false otherwise
     *
     *
     * @param $request
     * @return string
     */
    public function getGradePage($request){

        $request->setOption(CURLOPT_URL, 'https://92.55.225.11/dbviewer/view_data.php?view_name=uczen_uczen_arkusz_ocen_semestr.view');
        $request->setOption(CURLOPT_REFERER, 'https://92.55.225.11/dbviewer/login.php');
        $request->execute();
        if($request->isSuccessful()){
            $response = $request->getResponse();
            //Log::info($response);
            //Strip http header - 12 lines -http://stackoverflow.com/questions/758488/php-delete-first-four-lines-from-the-top-in-content-stored-in-a-variable
            $response = implode("\n", array_slice(explode("\n", $response), 12));
            //Log::info($response);
            //transcode to utf8 because register uses ancient iso
            $response = mb_convert_encoding($response, "UTF-8", "UTF-8,ISO-8859-2");
            Log::info('Grade page request successful'/*, array('table_content' => $response_final) */);
            return $response;
        } else {
            Log::error('Grade page request failed', array('error' => $request->getErrorMessage));
        }

    }

    /**
     * Returns table with grades for user
     *
     * @param $request
     * @return string
     */
    public function getGradeTable($request) {
        $gradePage = $this->getGradePage($request);
        ////Log::info($response);
        $parser = new Htmldom($gradePage);
        $response = $parser->find('table', 4)->outertext;
        //Below does not affect performance. It seems the memory leak was fixed in some php version
        //$parser->clear();
        return $response;
    }

}