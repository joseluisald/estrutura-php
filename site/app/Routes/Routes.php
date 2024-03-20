<?php

use App\Middlewares\AuthenticationMiddleware;

/* AUTH */
$router->group("admin", null)->namespace("App\Controllers\Admin");
$router->get("/logout", "Auth:logout", "auth.logout");
$router->get("/login", "Auth:login", "auth.login");

/* OPS */
$router->group("ops")->namespace("App\Controllers");
$router->get("/{errcode}", "Error:error", "error.error");

/* WEB */
$router->group("")->namespace("App\Controllers\Web");
$router->get("/", "Web:index", "web.index");

/* ADMIN */
$router->group("admin", AuthenticationMiddleware::class)->namespace("App\Controllers\Admin");
$router->get("/", "Admin:index", "admin.index");
$router->get("/allroutes", "Admin:getAllRoutes", "admin.getAllRoutes");
$router->get("/sitemap", "Admin:sitemap", "admin.sitemap");
