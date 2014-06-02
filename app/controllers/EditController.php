<?php

class EditController extends \BaseController {

    public function __construct() {
        $this->beforeFilter('csrf', array('on'=>'post'));
    }

    public function getPassword(){
        return View::make('edit.password');
    }

    public function postPassword(){
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
                return Redirect::to('edit/password')->with('error', 'Stare hasło nieprawidłowe!')->withInput();
            }
            $user->password = Hash::make(Input::get('password'));
            $user->save();
            Log::info('happens');
            Auth::logout();
            return Redirect::to('users/login')->with('message', 'Hasło zmienione, zaloguj się ponownie!');
        } else {
            return Redirect::to('edit/password')->withErrors($validator->errors())->withInput();
        }
    }


}