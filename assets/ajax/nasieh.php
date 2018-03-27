<?php
require "../init.php";
require_once "../security.php";

$action=Valid::input($_POST['action']);
if ($action=="new"){
    Valid::checkToken("new_nasieh",$_POST['token']);
    $datef=Valid::input($_POST['datef']);
    $datee=Valid::input($_POST['datee']);
    $nemayndeh=Valid::input($_POST['nemayndeh']);
    $meterf=Valid::input($_POST['meterf']);
    $kala=Valid::input($_POST['kala']);
    $price_total=Valid::input($_POST["price_total"]);
    $daryafti=Valid::input($_POST["daryafti"]);
    //////// convert data to timestamp ///////////
    $arr=explode("-",$datee);
//    22-09-2008'
    $timestamp=strtotime($arr[2]."-".$arr[1]."-".$arr[0]);
    ////////////
    try{
        $row=    R::getRow( 'SELECT * FROM `kala` WHERE id=?',
            [ $kala ]
        );
//        var_dump($row);
        $mojodi=$row['meterg']-$row['meterf'];
        if ($mojodi<$meterf){
            echo "موجودی انبار کافی  نیست";
            die();
         }
         if ($daryafti>$price_total){
            echo "مبلغ دریافتی بیشتر از قیمت کل می باشد.";
            die();
         }
        $updatemf=$row['meterf']+$meterf;
        $updatepf=$row['pricef']+$price_total;

        ////////////////////////////
        $sta=R::dispense('nasieh');
        $sta->datef=$datef;
        $sta->nemayandeh=$nemayndeh;
        $sta->timestamp=$timestamp;
        $sta->meterf=$meterf;
        $sta->kala=$kala;
        $sta->price_total=$price_total;
        $sta->daryafti=$daryafti;

        log2("","add new nasieh ($nemayndeh--$datef)");
        $id=R::store($sta);
        ///////// Update table ///////////


        $res=R::exec("UPDATE `kala` SET `meterf`=$updatemf ,`pricef`=$updatepf WHERE `id`=$kala");
        echo "ok";


//        echo "ok";
    }catch (Exception $exception){
        echo "خطا در دیتابیس!!!";
    }

}elseif ($action=="table"){
    $table_json=R::getAll("SELECT * FROM `nasieh`");
//    var_dump(json_decode($table_json));
//    $table=json_decode($table_json);
    $table=array();
    foreach ($table_json as $row){
        $persnol=array();
        $persnol['date']=$row['datef'];

        $per=R::getRow("SELECT * FROM `personel` WHERE id=?",[ $row['nemayandeh'] ]);
        $persnol['name']=$per['user'];
        $persnol['tele']=$per['tele'];

//        $id=$row['kala'];
        $per=R::getRow("SELECT * FROM `kala` WHERE `id`=?",[ $row['kala'] ]);
        $persnol['code']=$per['code'];

        $persnol['meterf']=spiltnum($row['meterf']);

        $persnol['pricet']=spiltnum($row['price_total']);

        $persnol['daryaft']=spiltnum($row['daryafti']);
        ///////////
        array_push($table,$persnol);
    }
    echo json_encode($table);
//    print_r($table);
}