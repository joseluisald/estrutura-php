<?php

namespace App\Controllers\{{themeUcfirst}};

use App\Core\Controller;
use App\Interfaces\{{themeUcfirst}}\{{name}}Interface;
use App\Services\{{themeUcfirst}}\{{name}}Service;

/**
 * class {{name}}
 */
class {{name}} extends Controller implements {{name}}Interface
{
    /**
     * @var string
     */
    protected $theme;
    /**
     * @var string
     */
    protected $page;
    /**
     * @var {{name}}Service
     */
    protected {{name}}Service ${{nameLc}}Service;
    /**
     * @var mixed|null
     */
	protected $me;

    /**
     * @param $router
     */
    public function __construct($router)
    {
        parent::__construct($router);

        $this->me = $this->authentication->getMe();
        $this->{{nameLc}}Service = new {{name}}Service();

        $this->theme = "{{theme}}";
        $this->page = "{{nameLc}}";
        $this->renderOptions = array_merge($this->renderOptions, [
            "theme" => $this->theme,
            "page" => $this->page,
            "cssFile"	=> getCss($this->theme, $this->page),
            "jsFile" => getJS($this->theme, $this->page),
            "breadcrumb" => addBreadcrumb(),
            "me" => $this->me
        ]);
    }

    /**
     * @return void
     */
    public function index()
    {
        $html = $this->view->addData($this->renderOptions)->render("$this->theme::pages/$this->page/index");
        echo $this->htmlMin->minify($html);
    }
}