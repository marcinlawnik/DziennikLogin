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

        if ($validator->passes()) {

            if (BetaCode::where('beta_code', '=', Input::get('betacode'))->where('available', '=', true)->first()) {

                $user = Sentry::register([
                    'email' => Input::get('email'),
                    'password' => Input::get('password'),
                    'registerusername' => Input::get('registerusername'),
                    'registerpassword' => Crypt::encrypt(Input::get('registerpassword')),
                    'job_is_active' => 1,
                    'job_interval' => 15
                ], true);

                Log::info('New user registered', ['user_id' => $user->getId()]);

                //Mark beta code as used
                $code = BetaCode::where('beta_code', '=', Input::get('betacode'))->first();

                $code->available = 0;
                $code->activated_at = Carbon::now();
                $code->user_id = $user->getId();

                $code->save();

                return Redirect::to('users/login')->with('message', 'Zarejestrowano poprawnie!');

            } else {

                return Redirect::to('users/register')
                    ->with('error_bang', 'Kod do bety niepoprawny!')
                    ->withInput();

            }

        } else {
            return Redirect::to('users/register')
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
