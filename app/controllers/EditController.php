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
        $user = Sentry::getUser();

        if ($validator->passes()) {

            if( ! $user->checkPassword(Input::get('oldpassword'))){
                return Redirect::to('edit/password')->with('error', 'Stare hasło nieprawidłowe!');
            }
            $userProvider = Sentry::getUserProvider()->findById($user->id);
            $userProvider->password = Input::get('password');
            $userProvider->save();
            Log::debug('User changed password', ['user_id' => $user->id]);
            Sentry::logout();
            return Redirect::to('users/login')->with('message', 'Hasło zmienione, zaloguj się ponownie!');
        } else {
            return Redirect::to('edit/password')->withErrors($validator->errors());
        }
    }


}