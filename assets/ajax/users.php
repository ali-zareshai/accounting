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
}