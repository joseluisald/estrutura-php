<?php

namespace App\Controllers;

use App\Core\Controller;

/**
 *
 */
class Error extends Controller
{
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
        debug($data);
    }
}