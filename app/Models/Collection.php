<?php

namespace App\Models;

class Collection
{
    private $items = [];

    public function __construct()
    {

    }

    public function get()
    {
        return $this->items;
    }

    public function put( array $items )
    {
        $this->items = array_merge( $this->items, $items );
    }

    public function count()
    {
        return \count( $this->items );
    }
}