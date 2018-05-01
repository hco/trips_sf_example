<?php

namespace App\Response;

class CreatedResponse extends Response
{
    public $message = "Created";
    public $data;

    public function __construct($data = null)
    {
        $this->data = $data;
    }
}