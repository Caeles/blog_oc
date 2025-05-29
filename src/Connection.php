<?php
namespace App;
use \PDO;
class Connection
{
    public static function getPDO()
    {
        $pdo = new PDO('mysql:host=127.0.0.1;dbname=blog', 'root', '', [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ]);
        return $pdo;
    }
}