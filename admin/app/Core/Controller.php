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
	 * @var
	 */
	protected $router;
	/**
	 * @var Engine
	 */
	protected Engine $view;
	/**
	 * @var array
	 */
	protected array $renderOptions;
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
	 * @var Seo
	 */
	protected Seo $seo;
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
		$this->seo = new Seo();
		$this->htmlMin = new HtmlMin();
        $this->authentication = new Authentication($router);

		$this->router = $router;

		$this->view = new Engine(dirname(__DIR__, 1) . "/View");
		$this->renderOptions = [];
		$this->view->addData([
			"router" => $this->router,
			"siteName" => admin("name"),
			"siteUrl" => admin("root"),
			"siteDescription" => admin("description"),
			"imageSharer" => asset("web", admin("imageSharer")),
			"seo" => $this->seo->render(getFirstPathUrl()),
			"gtmHead" => ADMIN["gtmHead"],
			"gtmBody" => ADMIN["gtmBody"]
		]);

		$themesDir = dirname(__DIR__, 1) . "/View/";
		$themes = array_diff(scandir($themesDir), ['..', '.']);

		foreach ($themes as $theme) {
			$this->view->addFolder("$theme", $themesDir . "$theme", true);
		}
	}

	/**
	 * @param string $param
	 * @param mixed $values
	 * @return string
	 */
	public function decodeResponse(string $param, mixed $values): string
	{
		return json_encode([$param => $values]);
	}

	/**
	 * @param mixed $request
	 * @return string
	 */
	public function response(mixed $request): string
	{
		$response = ($request->Error == true) ? $this->decodeResponse("Error", $request) : $this->decodeResponse("Success", $request);
		return $response;
	}

	/**
	 * @param string $message
	 * @param string $type
	 * @return string
	 */
	public function ajaxMessage(string $message, string $type): string
	{
		return json_encode(["message" => "<div class=\"message {$type}\">{$message}</div>"]);
	}

	/**
	 * @param $index
	 * @return mixed
	 */
	public function getRenderOptions($index, $subIndex = null)
	{
		return !is_null($subIndex) ? $this->renderOptions[$index]->$subIndex : $this->renderOptions[$index];
	}
}
