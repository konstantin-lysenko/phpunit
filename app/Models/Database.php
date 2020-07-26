<?php

namespace App\Models;

use App\Models\User;

class Database
{
    public function getByID( $id )
    {
        return new User();
    }

    public function returnArg( $arg )
    {
        return $arg;
    }
}