<?php

namespace App\Controllers;

use App\Core\Controller;

/**
 *
 */
class Error extends Controller
{
    /**
     * @var string
     */
    protected $theme;

    /**
     * @param $router
     */
    public function __construct($router)
    {
        parent::__construct($router);
    }

    /**
     * @return void
     */
    public function error($data): void
    {
        echo $this->view->render("web::pages/error", [
            "title" => "Error",
            "page" => "error",
            "errcode" => $data['errcode']
        ]);
    }
}