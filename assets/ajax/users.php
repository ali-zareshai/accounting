<?php
require "../util.php";
require_once "../security.php";
Valid::checkToken("new_user",$_POST['token']);
$action=Valid::input($_POST['action']);
if ($action=="new"){
    $name=Valid::string($_POST['name']);
    $username=Valid::input($_POST['username']);
    $pass=Valid::input($_POST['pass']);
    ///////// connect to DB ////
    if (strlen($pass) < 8) {
        $errors[] = "رمز عبور کمتر از ۸ کاراکتر است";
    }

    if (!preg_match("#[0-9]+#", $pass)) {
        $errors[] = "رمز عبور باید شامل اعداد هم باشد";
    }

    if (!preg_match("#[a-zA-Z]+#", $pass)) {
        $errors[] = "رمز عبور باید شامل حروف کوچک هم باشد";
    }
    if (!empty($errors)){
        echo implode("--",$errors);
        die();
    }
    ///
    $exict=R::getAll("SELECT * FROM user WHERE username=:user",[':user' => $username]);
    if ($exict!=null){
        echo " نام کاربری ".$username."  موجود می باشد";
        die();
    }
    try{
        $sta=R::dispense('user');
        $sta->name=$name;
        $sta->username=$username;
        $sta->pass=MD5($pass);
        $sta->level="1";
        $sta->login="0";


        $id=R::store($sta);
        log2("","add new user($username)");
        echo "ok";
    }catch (Exception $exception){
        echo "error in DB";
    }
}elseif ($action=="chkuser"){
    $username=Valid::input($_POST['user']);
    $exict=R::getAll("SELECT * FROM user WHERE username=:user",[':user' => $username]);
    if ($exict!=null){
        echo "no";
    }else{
        echo "ok";
    }
}elseif ($action=="chckpass"){
    $pwd=Valid::input($_POST['pass']);


    if (strlen($pwd) < 8) {
        $errors[] = "رمز عبور کمتر از ۸ کاراکتر است";
    }

    if (!preg_match("#[0-9]+#", $pwd)) {
        $errors[] = "رمز عبور باید شامل اعداد هم باشد";
    }

    if (!preg_match("#[a-zA-Z]+#", $pwd)) {
        $errors[] = "رمز عبور باید شامل حروف کوچک هم باشد";
    }
    if (empty($errors)){
        echo "ok";
    }else{
        echo implode(",",$errors);
    }


}