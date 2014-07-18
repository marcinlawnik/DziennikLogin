<?php

use Cartalyst\Sentry\Groups\Eloquent\Group as SentryGroup;

class UserGroup extends SentryGroup
{


    protected $guarded = [''];

    /**
     * The Eloquent user model.
     *
     * @var string
     */
    protected static $userModel = 'User';

}