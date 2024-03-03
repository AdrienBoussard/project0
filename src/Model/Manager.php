<?php

namespace Project\Model;

class Manager
{
    public function dbConnect()
    {
        $db = new \PDO('mysql:host=localhost;dbname=project0;charset=utf8', 'root', '');
        return $db;
    }
}