<?php

namespace App\Services\{{themeUcfirst}};

use App\Core\Service;

/**
 * class {{name}}Service
 */
class {{name}}Service extends Service
{
    /**
     * @var $endpoint
     */
    private $endpoint;

    /**
     * {{name}}Service construct
     */
    public function __construct()
    {
        parent::__construct();

        $this->endpoint = "/{{nameLc}}";
    }

    /**
     * @param $params
     * @return mixed
     */
    public function getByParameters($params)
    {
        return $this->http->get($this->api . $this->endpoint, $this->user_token, $params);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getById($id)
    {
        return $this->http->get($this->api . $this->endpoint . "/$id", $this->user_token);
    }

    /**
     * @param $data
     * @return \stdClass
     */
    public function add($data)
    {
        return $this->http->post($this->api . $this->endpoint, $data, $this->user_token);
    }

    /**
     * @param $data
     * @return \stdClass
     */
    public function update($data)
    {
        return $this->http->post($this->api . $this->endpoint . "/update", $data, $this->user_token);
    }

    /**
     * @param $id
     * @return \stdClass
     */
    public function delete($id)
    {
        return $this->http->post($this->api . $this->endpoint . "/delete/$id", [], $this->user_token);
    }
}

