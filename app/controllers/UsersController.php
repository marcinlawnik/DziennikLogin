<?php

class UsersController extends BaseController
{
    public function __construct()
    {
        $this->beforeFilter('csrf', array('on'=>'post'));
    }

    public function getRegister()
    {
        return View::make('users.register');
    }

    public function postCreate()
    {
        $validator = Validator::make(Input::all(), User::$rules);

//        $registerPasswordChecker = new GradeProcessWorker();
//
//        $registerPasswordCheckResult = $registerPasswordChecker->checkCredentials(Input::get('registerusername'), Input::get('registerpassword'));

        if ($validator->passes()) {

            $user = Sentry::register([
                'email' => Input::get('email'),
                'password' => Input::get('password'),
                'registerusername' => Input::get('registerusername'),
                'registerpassword' => Crypt::encrypt(Input::get('registerpassword')),
                'job_is_active' => 1,
                'job_interval' => 15
            ], true);
            //if ($registerPasswordCheckResult === true) {
//                $user = new User;
//                $user->email = ;
//                $user->password = Hash::make();
//                $user->registerusername = );
//                $user->registerpassword = ;
//                //Setting the defults
//                $user->job_is_active = 1;
//                $user->job_interval = 15;
//                $user->save();

                Log::info('New user registered', ['user_id' => $user->getId()]);

                return Redirect::to('users/login')->with('message', 'Zarejestrowano poprawnie!');
            //} else {
                //return Redirect::to('users/register')->with('error', 'Dane dostępowe do dziennika nie są poprawne!')->withInput();
            //}
        } else {
            return Redirect::to('users/register')
                ->with('message', 'Wystąpiły błędy:')
                ->withErrors($validator)
                ->withInput();
        }
    }

    public function getLogin()
    {
        if (Sentry::check()) {
            return Redirect::action('DashboardController@getIndex')->with('message', 'Już jesteś zalogowany!');
        } else {
            return View::make('users.login');
        }
    }

    public function postSignin()
    {
        try {
            if (Sentry::authenticate(['email'=>Input::get('email'), 'password'=>Input::get('password')])) {
                Log::debug('User logged in', ['email' => Input::get('email')]);

                return Redirect::action('DashboardController@getIndex')->with('message', 'Zalogowano!');
            } else {
                Log::debug('User failed to login', ['email' => Input::get('email')]);
            }
        } catch (Cartalyst\Sentry\Users\LoginRequiredException $e) {
            return Redirect::to('users/login')->with('error', 'Email i/lub hasło niepoprawne!')->withInput();
        } catch (Cartalyst\Sentry\Users\PasswordRequiredException $e) {
            return Redirect::to('users/login')->with('error', 'Email i/lub hasło niepoprawne!')->withInput();
        } catch (Cartalyst\Sentry\Users\WrongPasswordException $e) {
            return Redirect::to('users/login')->with('error', 'Email i/lub hasło niepoprawne!')->withInput();
        } catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
            return Redirect::to('users/login')->with('error', 'Email i/lub hasło niepoprawne!')->withInput();
        } catch (Cartalyst\Sentry\Users\UserNotActivatedException $e) {
            return Redirect::to('users/login')->with('error', 'Konto nie zostało aktywowane!')->withInput();
        }

        // The following is only required if the throttling is enabled
        catch (Cartalyst\Sentry\Throttling\UserSuspendedException $e) {
            return Redirect::to('users/login')->with('error', 'Email i/lub hasło niepoprawne!');
        } catch (Cartalyst\Sentry\Throttling\UserBannedException $e) {
            return Redirect::to('users/login')->with('error', 'Użytkownik zbanowany!');
        }

    }

    public function getLogout()
    {
        if (Sentry::check()) {
            Log::debug('User logged out', ['email' => User::find(Sentry::getUser()->id)->email]);
            Sentry::logout();
            return Redirect::to('/')->with('message', 'Wylogowano poprawnie!');
        } else {
            return Redirect::to('users/login')->with('message', 'Zaloguj się!');
        }

    }
}
