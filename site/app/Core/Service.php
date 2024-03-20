<?php

namespace App\Core;

use App\Supports\Cookie;
use App\Supports\Input;
use App\Supports\Session;

/**
 *
 */
class Service
{
    /**
     * @var Cookie
     */
    protected Cookie $cookie;
    /**
     * @var Session
     */
    protected Session $session;
    /**
     * @var Http
     */
    protected Http $http;
    /**
     * @var Input
     */
    protected Input $input;
    /**
     * @var string
     */
    protected string $user_token;
    /**
     * @var object
     */
    protected object $user_access_params;
    /**
     * @var string
     */
    protected string $api;
    /**
     * @var object
     */
    protected object $me;

    /**
     *
     */
    public function __construct()
	{
        $this->cookie = new Cookie();
        $this->session = new Session();
        $this->input = new Input();
        $this->http = new Http();

        $this->user_token = $this->session->has("access_token") ? $this->getUserToken() : "";
        $this->user_access_params =  $this->session->has("meAdmin") ? $this->getUserAccessParams() : (object)[];
        $this->me = $this->session->has("meAdmin") ? $this->getMe() : (object)[];

        $this->api = api();
	}

    /**
     * @return object
     */
    public function getUserAccessParams(): object
    {
        $me = $this->getMe();

        return (object)[
            'PersonId' => @$me->Id
        ];
    }

    /**
     * @return mixed|null
     */
    public function getMe()
    {
        return $this->session->__get("meAdmin");
    }

    /**
     * @return mixed|null
     */
    public function getUserToken()
    {
        return $this->session->__get("access_token");
    }
}
