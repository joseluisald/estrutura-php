<?php

use App\Middlewares\AuthenticationMiddleware;

/* AUTH */
$router->group("", null)->namespace("App\Controllers\Admin");
$router->get("/logout", "Auth:logout", "auth.logout");
$router->get("/login", "Auth:login", "auth.login");

/* OPS */
$router->group("ops")->namespace("App\Controllers");
$router->get("/{errcode}", "Error:error", "error.error");

/* ADMIN */
$router->group("", AuthenticationMiddleware::class)->namespace("App\Controllers\Admin");
$router->get("/", "Admin:index", "admin.index");
$router->get("/allroutes", "Admin:getAllRoutes", "admin.getAllRoutes");
$router->get("/sitemap", "Admin:sitemap", "admin.sitemap");
