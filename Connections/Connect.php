<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_Connect = "localhost";
$database_Connect = "kundaita_mc_db";
$username_Connect = "kundaita_mc_user";
$password_Connect = "#;H}MXNXx(kB";

// FOR DEVELOPMENT ENVIRONMENT
// $hostname_Connect = "localhost";
// $database_Connect = "kundaita_mc_db";
// $username_Connect = "root";
// $password_Connect = "";
$Connect = mysqli_connect($hostname_Connect, $username_Connect, $password_Connect) or trigger_error(mysql_error(), E_USER_ERROR);
