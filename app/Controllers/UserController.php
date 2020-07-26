<?php

namespace App\Controllers;

use App\Models\User;
use App\Models\Database;

class UserController
{
    private $database;

    public function __construct(  )
    {
        $this->database = new Database();
    }

    public function getByID( $id ): User
    {
        return $this->database->getByID( $id );
    }
}