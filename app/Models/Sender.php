<?php

namespace App\Models;

class Sender
{
    private $http;

    public function __construct( $http )
    {
        $this->http = $http;
    }

    public function send( $msg )
    {
        return $this->http->post( $msg, [] );
    }
}