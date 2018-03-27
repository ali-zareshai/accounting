<?php
require "../util.php";
require_once "../security.php";
$action=Valid::input($_POST['action']);
if ($action=="new"){
    Valid::checkToken("new_kala",$_POST['token']);
    $code=Valid::input($_POST['code']);
    $dataf=Valid::input($_POST['dataf']);
    $datae=Valid::input($_POST['datae']);
    $meter=Valid::input($_POST['meter']);
    $price=Valid::input($_POST["price"]);
    //////// convert data to timestamp ///////////
    $arr=explode("-",$datae);
//    22-09-2008'
    $timestamp=strtotime($arr[2]."-".$arr[1]."-".$arr[0]);
    ////////////
    try{
        $sta=R::dispense('kala');
        $sta->code=$code;
        $sta->dataf=$dataf;
        $sta->timestamp=$timestamp;
        $sta->meterg=$meter;
        $sta->priceg=$price;
        $sta->meterf="0";
        $sta->pricef="0";
        log2("","add new kala ($code)");

        $id=R::store($sta);
        echo "ok";
    }catch (Exception $exception){
        echo "error in DB";
    }

}elseif ($action=="table"){
    $kala=R::getAll( 'SELECT * FROM kala' );
    $kala2=array();
    foreach ($kala as $row){
        $r=array();
        $r['code']=$row["code"];
        $r['dataf']=$row['dataf'];
        $r['meterg']=$row['meterg'];
        $r['priceg']=$row['priceg'];
        $r['meterf']=$row['meterf'];
        $r['pricef']=$row['pricef'];
        $r['moj']=$row['meterg']-$row['meterf'];
        //////
        array_push($kala2,$r);
    }
    echo json_encode($kala2);
}