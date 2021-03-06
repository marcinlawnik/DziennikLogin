<?php

/**
 * Class DziennikHandler
 *
 * This class allows interaction with the school register
 *
 */
class DziennikHandler
{

    protected $request;

    protected $username;

    protected $password;

    public $gradePageDom;

    protected $cookieFileName;

    /**
     * @return mixed
     */
    public function getGradePageDom()
    {
        return $this->gradePageDom;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function __construct()
    {
        //Create request to be used later
        $this->request = $this->createRequest();
    }

    /**
     * Takes login data as parameters and returns POST string used to log into register
     *
     * @param $username
     * @param $password
     * @return string
     */

    public function getPostDataByCredentials($username, $password)
    {
        return 'user_name=' . $username . '&user_passwd=' . $password . '&con=e-dziennik-szkola01.con';
    }

    /**
     * Generate a random string.
     *
     * This function is taken from cartalyst/sentry
     *
     * @param int $length
     * @return string
     * @throws RuntimeException
     */

    public function getRandomString($length = 42)
    {
        // We'll check if the user has OpenSSL installed with PHP. If they do
        // we'll use a better method of getting a random string. Otherwise, we'll
        // fallback to a reasonably reliable method.
        if (function_exists('openssl_random_pseudo_bytes')) {
            // We generate twice as many bytes here because we want to ensure we have
            // enough after we base64 encode it to get the length we need because we
            // take out the "/", "+", and "=" characters.
            $bytes = openssl_random_pseudo_bytes($length * 2);

            // We want to stop execution if the key fails because, well, that is bad.
            if ($bytes === false) {
                throw new \RuntimeException('Unable to generate random string.');
            }

            return substr(str_replace(array('/', '+', '='), '', base64_encode($bytes)), 0, $length);
        }

        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        return substr(str_shuffle(str_repeat($pool, 5)), 0, $length);
    }

    public function generateCookieFileName()
    {
        $this->cookieFileName = $this->getRandomString(32).'.txt';
    }

    /**
     * Creates a cURL request with necessary options
     *
     * @return Request
     */
    public function createRequest()
    {
        $request = new jyggen\Curl\Request('https://92.55.225.11/dbviewer/login.php');
        //Ignore SSL because certificate is messed up - poses a MiTM threat but who cares about poor grades
        $request->setOption(CURLOPT_SSL_VERIFYPEER, false);
        $request->setOption(CURLOPT_SSL_VERIFYHOST, false);
        //Setting useragent string - this one is my laptop
        $request->setOption(
            CURLOPT_USERAGENT,
            'Mozilla/5.0 (X11; Linux i686) '.
            'AppleWebKit/537.22 (KHTML, like Gecko) '.
            'Ubuntu Chromium/25.0.1364.160 '.
            'Chrome/25.0.1364.160 Safari/537.22'
        );
        //Already set in class by default - http://docs.jyggen.com/curl/request
        //$request->setOption(CURLOPT_RETURNTRANSFER, 1);
        //Follow redirects
        $request->setOption(CURLOPT_FOLLOWLOCATION, 1);
        //Allow the register some time to think, because it's slow as hell
        $request->setOption(CURLOPT_TIMEOUT, 60);
        //Who stole the cookies from the cookie jar?
        //insert path of storage by laravel
        $request->setOption(CURLOPT_COOKIEJAR, storage_path('cookies/'.$this->cookieFileName));
        $request->setOption(CURLOPT_COOKIEFILE, storage_path('cookies/'.$this->cookieFileName));
        Log::debug('Request created'); // array('context' => $request->getInfo())

        return $request;
    }

    /**
     * Requests login into register for user.
     * Returns true on success, false otherwise.
     *
     * @return bool
     */
    public function doLogin()
    {
        return $this->doLoginByCredentials($this->username, $this->password);
    }

    /**
     * Requests login into register for user by credentials.
     * Returns true on success, false otherwise.
     *
     * @param $username
     * @param $password
     * @return bool
     */
    public function doLoginByCredentials($username, $password)
    {

        //We will be supplying post data
        $this->request->setOption(CURLOPT_POST, 1);
        //The actual post data
        $this->request->setOption(CURLOPT_POSTFIELDS, $this->getPostDataByCredentials($username, $password));
        //Aaaand - execute!
        $this->request->execute();
        //If it twerks then it works ;)
        if ($this->request->isSuccessful() && strpos($this->request->getRawResponse(), 'logowania') === false) {
            Log::debug('Request to login successful');
            //Log::info($request->getInfo());
            //Log::info($this->request->getRawResponse());
            return true;
        } else {
            Log::error('Request to login failed', array('error' => $this->request->getErrorMessage()));

            return false;
        }

    }

    /**
     * Requests logout out of register. Does not require specifying user as all is done in one request.
     * Returns true on success, false otherwise.
     *
     * @return bool
     */
    public function doLogout()
    {
        //Set logout URL
        $this->request->setOption(
            CURLOPT_URL,
            'https://92.55.225.11/dbviewer/logout.php?con=e-dziennik-szkola01.con&location=..'
        );
        //FIRE!
        $this->request->execute();
        //If it works...
        if ($this->request->isSuccessful()) {
            Log::debug('Logout successful.');

            return true;
        } else {
            Log::error('Logout failed.', array('error' => $this->request->getErrorMessage()));

            return false;
        }
    }

    /**
     * Obtains grade page for specific user.
     *
     * @return bool
     */
    public function obtainGradePage()
    {

        $this->request->setOption(
            CURLOPT_URL,
            'https://92.55.225.11/dbviewer/view_data.php?view_name=uczen_uczen_arkusz_ocen_semestr.view'
        );
        $this->request->setOption(CURLOPT_REFERER, 'https://92.55.225.11/dbviewer/login.php');
        $this->request->execute();
        if ($this->request->isSuccessful()) {
            $response = $this->request->getResponse();
            //Strip http header - 12 lines -
            //http://stackoverflow.com/questions/758488/php-delete-first-four-lines-from-the-top-in-content-stored-in-a-variable
            $response = implode("\n", array_slice(explode("\n", $response), 12));
            //transcode to utf8 because register uses ancient iso
            $response = mb_convert_encoding($response, "UTF-8", "UTF-8,ISO-8859-2");
            Log::debug('Grade page request successful');
            $this->gradePageDom = new Htmldom($response);

            return true;
        } else {
            Log::error('Grade page request failed', array('error' => $this->request->getErrorMessage));

            return false;
        }

    }

    /**
     * Returns table with grades for user
     *
     * @return string
     */
    public function getGradeTableRawHtml()
    {
        return $this->gradePageDom->find('table', 4)->outertext;
    }

    /**
     * Check if credentials are correct
     *
     * @param $username
     * @param $password
     * @return bool
     */

    public function checkCredentials($username, $password)
    {
        $response = $this->doLoginByCredentials($username, $password);

        if ($response) {
            $this->doLogout();
        }

        return $response;

    }
}
