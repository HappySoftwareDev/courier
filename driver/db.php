<?php
define('DBhost', 'localhost');
define('DBuser', 'kundaita_mc_user');
define('DBname', 'kundaita_mc_db');
define('DBpass', '#;H}MXNXx(kB');

// FOR DEV ENV
// define('DBhost', 'localhost');
// define('DBuser', 'root');
// define('DBname', 'kundaita_mc_db');
// define('DBpass', '');

try {

    $DB_con = new PDO("mysql:host=" . DBhost . ";dbname=" . DBname, DBuser, DBpass);
} catch (PDOException $e) {

    die($e->getMessage());
}
