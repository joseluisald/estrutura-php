<?php

namespace App\Controllers\Web;

use App\Core\Controller;

/**
 * class Web
 */
class Web extends Controller
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

        $this->theme = "web";
        $this->renderOptions = array_merge($this->renderOptions, [
            "theme" => $this->theme
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
}