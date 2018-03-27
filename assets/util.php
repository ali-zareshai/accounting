<?php
require "rb-mysql.php";
require "Valid.php";
require_once "log2.php";
//require_once "security.php";
//reqnuire ();
$serverame = "localhost";
$dbname="mydb";
$username = "root";
$password = "13681023";

R::setup("mysql:host=$servername;dbname=$dbname",$username,$password);
R::debug(false);