<?php

namespace App\Interfaces\Admin;

/**
 *
 */
interface AuthenticationInterface
{
    /**
     * @return mixed
     */
    public function oAuth2Callback($data);

    /**
     * @return object
     */
    public function getUserAccessParams();

    /**
     * @return mixed
     */
    public function getMe();

    /**
     * @return mixed
     */
    public function getUserToken();
}