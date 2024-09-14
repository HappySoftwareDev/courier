<?php
define('DBhost', 'localhost');
define('DBuser', 'root');
define('DBname', 'mcdb');
define('DBpass', '');

// FOR DEV ENV
// define('DBhost', 'localhost');
// define('DBuser', 'root');
// define('DBname', 'kundaita_mc_db');
// define('DBpass', '');

try {

    $Connect = new PDO("mysql:host=" . DBhost . ";dbname=" . DBname, DBuser, DBpass);
} catch (PDOException $e) {

    die($e->getMessage());
}
