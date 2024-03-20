<?php

namespace App\Supports;

/**
 *
 */
class SitemapGenerator
{
    /**
     * @var
     */
    private $router;

    /**
     * @param $router
     */
    public function __construct($router)
    {
        $this->router = $router;
    }

    /**
     * @return bool|string
     */
    public function generateSitemap()
    {
        $routes = $this->router->getRoutes();

        $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8" ?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"></urlset>');

        foreach ($routes as $route)
        {
            $urlElement = $xml->addChild('url');
            $urlElement->addChild('loc', htmlspecialchars($this->generateUrl($route)));
            $urlElement->addChild('lastmod', date('c'));
            $urlElement->addChild('changefreq', 'monthly');

            if($route->route == '') {
                $urlElement->addChild('priority', '1.0');
            } else {
                $urlElement->addChild('priority', '0.8');
            }
        }

        $formattedXml = $xml->asXML();
        return $formattedXml;
    }

    /**
     * @param $route
     * @return string
     */
    private function generateUrl($route)
    {
        return $this->router->home() . $route->route;
    }
}
