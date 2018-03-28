<?php
require "../util.php";
require_once "../security.php";
session_start();

$current_pass=Valid::input($_POST['current_pass']);
$pass1=Valid::input($_POST['pass1']);
$pass2=Valid::input($_POST['pass2']);
///
if (strlen($pass1) < 8) {
    $errors[] = "رمز عبور کمتر از ۸ کاراکتر است";
}

if (!preg_match("#[0-9]+#", $pass1)) {
    $errors[] = "رمز عبور باید شامل اعداد هم باشد";
}

if (!preg_match("#[a-zA-Z]+#", $pass1)) {
    $errors[] = "رمز عبور باید شامل حروف کوچک هم باشد";
}
if (!empty($errors)){
    echo implode("--",$errors);
    die();
}
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
