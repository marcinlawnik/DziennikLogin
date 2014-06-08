<?php

class UsersController extends BaseController {

    protected $layout = "users.main";

    public function __construct() {
        $this->beforeFilter('csrf', array('on'=>'post'));
    }

    public function getRegister() {
        $this->layout->content = View::make('users.register');
    }

    public function postCreate() {
        $validator = Validator::make(Input::all(), User::$rules);

//        $registerPasswordChecker = new GradeProcessWorker();
//
//        $registerPasswordCheckResult = $registerPasswordChecker->checkCredentials(Input::get('registerusername'), Input::get('registerpassword'));


        if ($validator->passes()) {
            //if($registerPasswordCheckResult === true){
                $user = new User;
                $user->email = Input::get('email');
                $user->password = Hash::make(Input::get('password'));
                $user->registerusername = Input::get('registerusername');
                $user->registerpassword = Crypt::encrypt(Input::get('registerpassword'));
                $user->save();

                $setting = new Setting;
                $setting->user_id = $user->id;

                //Setting the defults
                $setting->job_is_active = 1;
                $setting->job_interval = 15;

                //Saving
                $setting->save();

                Log::info('New user registered', ['user_id' => $user->id]);

                return Redirect::to('users/login')->with('message', 'Zarejestrowano poprawnie!');
            //} else {
                return Redirect::to('users/register')->with('error', 'Dane dostępowe do dziennika nie są poprawne!')->withInput();
            //}
        } else {
            return Redirect::to('users/register')->with('message', 'Wystąpiły błędy:')->withErrors($validator)->withInput();
        }
    }

    public function getLogin() {
        if (Auth::check()){
            $this->layout = null;
            return Redirect::action('DashboardController@getIndex')->with('message', 'Już jesteś zalogowany!');
        } else {
            $this->layout->content = View::make('users.login');
        }
    }

    public function postSignin() {
        if (Auth::attempt(array('email'=>Input::get('email'), 'password'=>Input::get('password')))) {
            return Redirect::action('DashboardController@getIndex')->with('message', 'Zalogowano!');
        } else {
            return Redirect::to('users/login')
                ->with('error', 'Email i/lub hasło niepoprawne!')
                ->withInput();
        }
    }

    public function getLogout() {
        if(Auth::check()){
            Auth::logout();
            return Redirect::to('/')->with('message', 'Wylogowano poprawnie!');
        } else {
            return Redirect::to('users/login');
        }

    }
}
