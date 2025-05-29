<?php

use App\Connection;

require dirname(__DIR__ ). '/vendor/autoload.php';


$pdo = Connection::getPDO();


$password = password_hash('admin', PASSWORD_BCRYPT);
$pdo->exec("INSERT into user SET username='admin' , password='$password'");
