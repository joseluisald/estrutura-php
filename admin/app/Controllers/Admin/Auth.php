<?php

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Interfaces\Admin\AuthInterface;
use App\Supports\Input;
use App\Supports\Session;

/**
 * class Auth
 */
class Auth extends Controller implements AuthInterface
{
	/**
	 * @var Session
	 */
	protected Session $session;
	/**
	 * @var Input
	 */
	protected Input $input;
	/**
	 * @var $router
	 */
	protected $router;
	/**
	 * @var string
	 */
	protected $theme;
	/**
	 * @var string
	 */
	protected $page;

	/**
	 * @param $router
	 */
	public function __construct($router)
	{
		$this->session = new Session();
		$this->input = new Input();

		parent::__construct($router);

		$this->theme = "admin";
		$this->page = "auth";
		$this->renderOptions = array_merge($this->renderOptions, [
			"theme" => $this->theme,
			"page" => $this->page,
			"cssFile"	=> getCss($this->theme, $this->page),
			"jsFile" => getJS($this->theme, $this->page),
			"breadcrumb" => addBreadcrumb()
		]);
	}

	/**
	 * @return void
	 */
	public function logout()
	{
		$this->session->unset('meAdmin');
		$this->session->unset('access_token');
		$this->session->unset('expires_in');
		$this->session->destroy();

		$this->router->redirect("auth.login");
	}

	/**
	 * @return void
	 */
	public function login()
	{
		$html = $this->view->addData($this->renderOptions)->render("$this->theme::pages/login");
		echo $this->htmlMin->minify($html);
	}
}
