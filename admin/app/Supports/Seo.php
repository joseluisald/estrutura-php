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
		$opTitle 			 	= (!empty($title)) ? $title . ' - ' . admin("name") : admin("name");
		$opSiteDescription		= (!empty($desc)) ? $desc : admin("desc");
		$opSiteUrl 	 	 		= (!empty($url)) ? $url : admin();
		$opImageSharer 	 		= (!empty($image)) ? $image : admin("web", admin("imageSharer"));

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
