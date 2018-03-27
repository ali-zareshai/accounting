<?php
require "../util.php";
require_once "../security.php";
$action=Valid::input($_POST['action']);
if ($action=="new"){
//    $conn=$GLOBALS['conn'];
Valid::checkToken("new_nemayndeh",$_POST['token']);
try{

    $name= Valid::input($_POST['name']);
    $user =Valid::input($_POST['user']) ;
    $tele = Valid::input($_POST['tele']);
    $mobil = Valid::input($_POST['mobile']);
    $address = Valid::input($_POST['address']);
//
//    $stmt->execute();

    $sta=R::dispense('personel');
    $sta->name=$name;
    $sta->user=$user;
    $sta->tele=$tele;
    $sta->mobile=$mobil;
    $sta->address=$address;

    log2("","add new nemayandeh ($name)");
    $id=R::store($sta);
    echo "ok";
}catch (Exception $exception){
    var_dump($exception);
}

}elseif ($action=="deleth"){
    $id=$_POST['id'];
    try{
        $book = R::load( 'personel', $id ); //reloads our book
        R::trash( $book );
        echo "ok";
    }catch (Exception $exception){
        echo "error";
    }
}