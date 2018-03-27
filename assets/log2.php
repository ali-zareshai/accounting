<?php
require_once "util.php";
function log2($agent="",$msg){
    $sta=R::dispense('log');
    if ($agent==""){
        $agent=$_SESSION['name'];
    }
    $sta->agent=$agent;
    $sta->msg=$msg;
    $sta->time=date("Y/m/d H-i-s");



    $id=R::store($sta);
}