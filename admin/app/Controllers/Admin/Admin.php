<?php

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Interfaces\Admin\AdminInterface;
use App\Supports\SitemapGenerator;

/**
 * class Admin
 */
class Admin extends Controller implements AdminInterface
{
	/**
	 * @var string
	 */
	protected $theme;
	/**
	 * @var string
	 */
	protected $page;
	/**
	 * @var mixed|null
	 */
	protected $me;

	/**
	 * @param $router
	 */
	public function __construct($router)
	{
		parent::__construct($router);

        $this->me = [];

		$this->theme = "admin";
		$this->page = "admin";
		$this->renderOptions = array_merge($this->renderOptions, [
			"theme" => $this->theme,
			"page" => $this->page,
			"cssFile"	=> getCss($this->theme, $this->page),
			"jsFile" => getJS($this->theme, $this->page),
			"me" => $this->me
		]);
	}

	/**
	 * @return void
	 */
	public function index()
	{
		$html = $this->view->addData($this->renderOptions)->render("$this->theme::pages/index");
		echo $this->htmlMin->minify($html);
	}

	/**
	 * @return void
	 */
	public function getAllRoutes()
	{
		$routes = $this->router->getRoutes(true);
		print_r($routes);
	}

	/**
	 * @return void
	 */
	public function sitemap()
	{
		$sitemapGenerator = new SitemapGenerator($this->router);
		$sitemap = $sitemapGenerator->generateSitemap();
		header('Content-Type: application/xml');
		echo $sitemap;
	}
}
