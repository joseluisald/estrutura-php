<?php

namespace App\Core;

use App\Supports\Session;

/**
 *
 */
class Authentication
{
	/**
	 * @var Session
	 */
	protected Session $session;
	/**
	 * @var Http
	 */
	protected Http $http;
	/**
	 * @var $router
	 */
	protected $router;

	/**
	 * @param $router
	 */
	public function __construct($router)
	{
		$this->session = new Session();
		$this->http = new Http();

		$this->router = $router;
	}
}
