<?php
require "../util.php";
require_once "../security.php";
session_start();

$current_pass=Valid::input($_POST['current_pass']);
$pass1=Valid::input($_POST['pass1']);
$pass2=Valid::input($_POST['pass2']);
///////check pass //
$id=$_SESSION['user_id'];
$row=R::getAll("SELECT * FROM user WHERE id=$id");

if ($row[0]['pass']!=MD5($current_pass)){
    log2(""," wrong cuurrnt pass in change password");
    echo "رمز عبور فعلی اشتباه است";
}else{
    if ($pass1==$pass2){
        $hash_pass=MD5($pass1);
        R::exec("UPDATE user SET pass='$hash_pass' WHERE id=$id");
        log2(""," success change password");
        echo "رمز عبور با موفقیت تغییر یافت";
    }else{
        echo "Erroe!!!!";
    }
}
