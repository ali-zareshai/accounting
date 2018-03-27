<?php
require_once "../init.php";
Valid::checkToken("login",$_POST['token']);
if ($_SESSION['digit']==$_POST['cap']){
    echo checkusr($_POST['user'],$_POST['pass']);
}else{
    log2("hacker","wrong cap code");
    echo "cap";
}

//var_dump(checkusr($_POST['user'],$_POST['pass']));