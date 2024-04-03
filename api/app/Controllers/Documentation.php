<?php

namespace App\Controllers;

use App\Core\Controller;
use OpenApi\Generator;

class Documentation extends Controller
{
	/**
	 * @param $router
	 */
	public function __construct($router)
	{
		parent::__construct($router);
	}
	
	public function index()
	{
		$openapi = Generator::scan([dirname(__FILE__) . DS . 'Api']);
		
		header('Content-Type: application/json');
		echo $openapi->toJSON();
	}
}