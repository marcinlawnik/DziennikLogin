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

        if ($validator->passes()) {
            $user = new User;
            $user->email = Input::get('email');
            $user->password = Hash::make(Input::get('password'));
            $user->registerusername = Input::get('registerusername');
            $user->registerpassword = Crypt::encrypt(Input::get('registerpassword'));
            $user->save();

            return Redirect::to('users/login')->with('message', 'Zarejestrowano poprawnie!');
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

    public function getEdit(){
        return View::make('users.edit');
    }

    public function postEdit(){
        $rules = array(
            'oldpassword'=>'required|alpha_num|between:8,32',
            'password'=>'required|alpha_num|between:8,32|confirmed',
            'password_confirmation'=>'required|alpha_num|between:8,32'
        );
        $validator = Validator::make(Input::all(), $rules);
        $user = User::find(Auth::user()->id);
        $credentials = array(
            'email' => $user->email,
            'password' => Input::get('oldpassword')
        );

        if ($validator->passes()) {

            if(!Auth::validate($credentials)){
                return Redirect::to('users/edit')->with('error', 'Stare hasło nieprawidłowe!')->withInput();
            }
            $user->password = Hash::make(Input::get('password'));
            $user->save();
            Log::info('happens');
            Auth::logout();
            return Redirect::to('users/login')->with('message', 'Hasło zmienione, zaloguj się ponownie!');
        } else {
            return Redirect::to('users/edit')->withErrors($validator->errors())->withInput();
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
