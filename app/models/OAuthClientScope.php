<?php

class OAuthClientScope extends \Eloquent {
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'oauth_client_scopes';

    protected $guarded = [''];
}