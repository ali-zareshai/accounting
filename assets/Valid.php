<?php
require_once "util.php";
session_start();
class Valid
{
    static function string($str){
        if (is_string($str)){
            return htmlspecialchars(stripslashes(trim(strip_tags($str))));
        }else{
            return "ERROR IN VALID";
        }
    }

    static function integ($i){
        if (is_int($i)){
            return htmlspecialchars(stripslashes(trim(strip_tags($i))));
        }else{
            return "ERROR IN VALID";
        }
    }

    static function input($inpt){
        return htmlspecialchars(stripslashes(trim(strip_tags($inpt))));
    }

    ///// check token /////
    static function checkToken($form,$token){
        if ($_SESSION['token'][$form]!=$token){
            if (isset($_SERVER['name'])){
                log2($_SESSION['name'],"wrong token in $form");
            }else{
                log2("hacker","wrong token in $form");
            }
            die("ERROR IN TOKEN!!!!!");
//            echo $_SESSION['token'][$form];
        }
    }


}