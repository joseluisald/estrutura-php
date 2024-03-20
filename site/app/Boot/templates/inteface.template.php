<?php

namespace App\Interfaces\{{themeUcfirst}};

interface {{name}}Interface
{
    /**
     * @return void
     */
    public function list();

    /**
     * @return void
     */
    public function new();

    /**
     * @param $data
     * @return void
     */
    public function edit($data);

    /**
     * @return void
     */
    public function post();

    /**
     * @return void
     */
    public function put();

    /**
     * @param $data
     * @return void
     */
    public function delete($data);
}