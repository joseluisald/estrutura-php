<?php

namespace App\Interfaces\Admin;

interface AuthInterface
{
    /**
     * @return void
     */
    public function login();

    /**
     * @return void
     */
    public function logout();
}