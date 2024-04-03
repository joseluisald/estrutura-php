<?php

namespace App\Controllers\Api;

use App\Core\Controller;
use App\Interfaces\Api\ApiInterface;
use App\Supports\SitemapGenerator;
use OpenApi\Annotations as OA;

/**
 * @OA\Swagger(
 *     basePath="/api",
 *     schemes={"http", "https"},
 *     @OA\Info(
 *         version="1.0.0",
 *         title="My API",
 *         description="API documentation for My API",
 *         @OA\Contact(name="My Company"),
 *         @OA\License(name="MIT")
 *     )
 * )
 */
class Api extends Controller implements ApiInterface
{
	/**
	 * @param $router
	 */
	public function __construct($router)
	{
		parent::__construct($router);
	}
	
	/**
	 * @OA\Get(
	 *     path="/api/",
	 *     summary="This index method",
	 *     tags={"Api"},
	 *     @OA\Response(response="200",  description="The data"),
	 *     @OA\Response(response="404",  description="Not found")
	 * )
	 */
	public function index()
	{
		$routes = $this->router->getRoutes(true);
		print_r($routes);
	}
	
	/**
	 * @OA\Get(
	 *     path="/api/allroutes",
	 *     summary="This get all routes present in api",
	 *     tags={"Api"},
	 *     @OA\Response(response="200",  description="The data"),
	 *     @OA\Response(response="404",  description="Not found")
	 * )
	 */
	public function getAllRoutes()
	{
		$routes = $this->router->getRoutes(true);
		print_r($routes);
	}
	
	/**
	 * @OA\Get(
	 *     path="/api/sitemap",
	 *     summary="This sitemap generator",
	 *     tags={"Api"},
	 *     @OA\RequestBody(
	 *     		@OA\MediaType(
	 *     			mediaType="xml"
	 * 			)
	 * 		),
	 *     @OA\Response(response="200",  description="The data"),
	 *     @OA\Response(response="404",  description="Not found")
	 * )
	 */
	public function sitemap()
	{
		$sitemapGenerator = new SitemapGenerator($this->router);
		$sitemap = $sitemapGenerator->generateSitemap();
		echo $sitemap;
	}
}
