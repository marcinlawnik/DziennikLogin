<?php

class OAuthController extends Controller
{

    /**
     * Generate access token
     *
     * @return string
     */
    public function postToken()
    {
        return AuthorizationServer::performAccessTokenFlow();
    }

}