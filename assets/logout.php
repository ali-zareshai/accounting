<?php
require_once "util.php";
log2("","logout from system");

session_start();

session_unset();

session_destroy();

header("location:../index.php");

exit();
