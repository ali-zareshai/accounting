<?php
session_start();
$form_name=$_POST["form_name"];
$token = md5(uniqid(rand(), TRUE));
$_SESSION['token'][$form_name] = $token;
echo $token;