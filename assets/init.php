<?php
session_start();
require "util.php";

    #valid username & pass
    function checkusr($user,$pass){
    	$username = Valid::input($user);
        $password = Valid::input($pass);
        // echo md5($password);
        $book  = R::getAll("select * from user where username = :name ",[':name' => $username]);
//        var_dump($book[0]['pass']);
//        die();
        if ($book!=null){
            if ($book[0]['pass']==MD5($password)){
                $_SESSION["login"] = "ok";
                $_SESSION['name']=$book[0]['name'];
                log2($book[0]['name'],"login to system");
                $id=$_SESSION['user_id']=$book[0]['id'];
                $time=time();

                R::exec("UPDATE user SET login=$time WHERE id=$id");
//            var_dump($book[0]['name']) ;
                echo "ok";
            }
            else{
                log2("hacker","wrong password for login to system");
                echo "no";
            }

        }
        else{
            $_SESSION["login"] = "error";
            log2("hacker","wrong username for login to system");
            echo "no";
        }


//        if ($number_of_rows!=null){
//            $_SESSION["login"] = "ok";
//            require "util.php";
//            $book  = R::findOne( 'user', ' username = ? ', [ $username ] );
////            $rows=R::getRow("select * from user where username = :name AND pass=:pass",[':name' => $username,':pass'=>md5($password)]);
//            $_SESSION['name']=$book;
////            $_SESSION['user_id']=$rows['id'];
//            $_SESSION["id"] = $number_of_rows;
//            echo "ok";
//        }else{
//            $_SESSION["login"] = "error";
//            echo "no";
//        }

    	
            }

            function spiltnum($number){
                $price_text = (string)$number; // convert into a string
                $arr = str_split($price_text, "3"); // break string in 3 character sets

                $price_new_text = implode(",", $arr);  // implode array with comma

                return $price_new_text;
            }
    
    