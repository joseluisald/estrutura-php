<?php

use App\Middlewares\AuthenticationMiddleware;

/* DOCUMENTATION */
$router->group("documentation")->namespace("App\Controllers");
$router->get("/", "Documentation:index", "documentation.index");

/* OPS */
$router->group("ops")->namespace("App\Controllers");
$router->get("/{errcode}", "Error:error", "error.error");

/* API */
$router->group("", AuthenticationMiddleware::class)->namespace("App\Controllers\Api");
$router->get("/", "Api:index", "api.index");
$router->get("/allroutes", "Api:getAllRoutes", "api.getAllRoutes");
$router->get("/sitemap", "Api:sitemap", "api.sitemap");
