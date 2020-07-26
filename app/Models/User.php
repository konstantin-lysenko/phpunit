<?php

namespace App\Models;

class User
{
    private $id;

    private $firstName;

    private $lastName;

    public function __construct( $id = null )
    {
        $this->id = $id;
    }

    public function setID( $id )
    {
        $this->id = $id;
    }

    public function setFirstName( $firstName )
    {
        $this->firstName = $firstName;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function setLastName( $lastName )
    {
        $this->lastName = $lastName;
    }

    public function getLastName()
    {
        return $this->lastName;
    }
}