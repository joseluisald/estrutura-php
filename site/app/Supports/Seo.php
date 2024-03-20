<?php

namespace App\Supports;

use CoffeeCode\Optimizer\Optimizer;

/**
 *
 */
class Seo
{
	/**
	 * @var mixed|Optimizer
	 */
	protected mixed $optmizer;

	/**
	 *
	 */
	public function __construct()
	{
		$this->optmizer = new Optimizer();
	}

	/**
	 * @param $title
	 * @param $desc
	 * @param $url
	 * @param $image
	 * @return string
	 */
	public function render($title = "", $desc = "", $url = "", $image = "")
	{
		$opTitle 			 	= (!empty($title)) ? $title . ' - ' . site("name") : site("name");
		$opSiteDescription		= (!empty($desc)) ? $desc : site("desc");
		$opSiteUrl 	 	 		= (!empty($url)) ? $url : site();
		$opImageSharer 	 		= (!empty($image)) ? $image : site("web", site("imageSharer"));

		return $this->optmizer->optimize(
			$opTitle,
			$opSiteDescription,
			$opSiteUrl,
			$opImageSharer
		)->openGraph(
			$opTitle,
			"pt_BR",
			"article"
		)->render();
	}
}
