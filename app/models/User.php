<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;
use Cartalyst\Sentry\Users\Eloquent\User as SentryUser;

class User extends SentryUser implements UserInterface, RemindableInterface
{
    public static $rules = array(
        'email'=>'required|email|unique:users',
        'password'=>'required|alpha_num|between:8,32|confirmed',
        'password_confirmation'=>'required|alpha_num|between:8,32',
        'registerusername'=>'required|between:2,50|unique:users',
        'registerpassword'=>'required|alpha_num|confirmed|between:2,50',
        'registerpassword_confirmation' => 'required'
    );

    /**
     * The Eloquent group model.
     *
     * @var string
     */
    protected static $groupModel = 'UserGroup';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = array('password','registerpassword');


    /**
     * Returns the relationship between users and groups.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function groups()
    {
        return $this->belongsToMany(static::$groupModel, static::$userGroupsPivot, 'user_id', 'group_id');
    }


    public function grades()
    {
        return $this->hasMany('Grade');
    }

    public function subjects()
    {
        return $this->belongsToMany('Subject');
    }

    public function snapshots()
    {
        return $this->hasMany('Snapshot');
    }

    public function snapshotChanges()
    {
        return $this->hasMany('SnapshotChange');
    }

    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->password;
    }

    /**
     * Get the token value for the "remember me" session.
     *
     * @return string
     */
    public function getRememberToken()
    {
        return $this->persist_code;
    }

    /**
     * Set the token value for the "remember me" session.
     *
     * @param  string $value
     * @return void
     */
    public function setRememberToken($value)
    {
        $persistCode = $value ?: $this->getRandomString();

        $this->persist_code = $persistCode;
    }

    /**
     * Get the column name for the "remember me" token.
     *
     * @return string
     */
    public function getRememberTokenName()
    {
        return 'persist_code';
    }

    /**
     * Get the e-mail address where password reminders are sent.
     *
     * @return string
     */
    public function getReminderEmail()
    {
        return $this->email;
    }
}
