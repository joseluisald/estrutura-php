<?php

namespace App\Core;

use App\Supports\Input;
use App\Supports\Seo;
use App\Supports\Session;
use League\Plates\Engine;
use App\Supports\HtmlMin;

/**
 *
 */
abstract class Controller
{
	/**
	 * @var $router
	 */
	protected $router;
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
	 * @var HtmlMin
	 */
	protected HtmlMin $htmlMin;
    /**
     * @var Authentication
     */
    protected Authentication $authentication;

	/**
	 * @param $router
	 */
	public function __construct($router)
	{
		$this->session = new Session();
		$this->input = new Input();
		$this->http = new Http();
		$this->htmlMin = new HtmlMin();
		$this->authentication = new Authentication($router);
		$this->router = $router;
	}
}
