<?php
require "assets/security.php";
include "assets/rb-mysql.php";
date_default_timezone_set("Asia/Tehran");
//reqnuire ();
$serverame = "localhost";
$dbname="mydb";
$username = "root";
$password = "13681023";

R::setup("mysql:host=$servername;dbname=$dbname",$username,$password);
R::debug(false);
////////////
//echo "<pre>";
//var_dump(R::getAll( 'SELECT * FROM personel' ));
//die();

?>
<head>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" href="assets/css/dashbord.css"/>
    <link rel="stylesheet" href="assets/css/theme.css"/>
    <link rel="stylesheet" href="assets/css/tabulator.min.css"/>
    <link rel="stylesheet" href="assets/css/js-persian-cal.css"/>
    <link rel="stylesheet" href="assets/css/font.css"/>
    <link rel="stylesheet" href="assets/css/bootstrap-select.min.css"/>


    <script src="assets/js/jquery-3.3.1.min.js"></script>
    <script src="assets/js/jquery-ui.js"> </script>
    <script src="assets/js/tabulator.min.js"> </script>
    <script src="assets/js/bootstrap.min.js"> </script>
    <script src="assets/js/bootbox.min.js"> </script>
    <script src="assets/js/token.js"> </script>
    <script src="assets/js/js-persian-cal.min.js"> </script>
    <script src="assets/js/bootstrap-select.min.js"></script>
    <script src="assets/js/latin2Arabic.jquery.js"></script>
    <script src="assets/js/moment.js"></script>
    <script>
        $(document).ready(function () {
            setInterval(function () {
                $("#timeer").html($.latin2Arabic.toArabic(moment().format('h:mm:ss')));

            },1000);
            ///// clear icon ///
            // function setmenu(sel) {
                // $("#menu1").removeAttr("background-color");
                // $("#menu2").removeAttr("background-color");
                // $("#menu3").removeAttr("background-color");
                // $("#menu4").removeAttr("background-color");
                // $("#menu5").removeAttr("background-color");
                // $("#menu6").removeAttr("background-color");
                // switch (sel){
                //     case 1:
                //         $("#menu1").attr("background-color","#0000001a");
                //         break;
                //     case 2:
                //         $("#menu2").attr("background-color","#0000001a");
                //         break;
                //     case 3:
                //         $("#menu3").attr("background-color","#0000001a");
                //         break;
                //     case 4:
                //         $("#menu4").attr("background-color","#0000001a");
                //         break;
                //     case 5:
                //         $("#menu5").attr("background-color","#0000001a");
                //         break;
                //     case 6:
                //         $("#menu6").attr("background-color","#0000001a");
                //         break;
                //
                //
                // }
            // }
        });

    </script>

<!--    ///////-->
    <script>
        $(document).ready(function () {
            $("#new_pass1").keyup(function () {
                var  pass=$("#new_pass1").val();
                var token=$("#chg_pass_token").val();

                $.ajax({
                    url: "assets/ajax/changepss.php",
                    type: "POST",
                    data: {action: "chk", pass: pass,token: token},
                    dataType: "html",
                    'success': function (data) {
                        $("#errors_pass").empty();
                        if (data=="ok"){
                            $("#validpass2").addClass("has-success");
                            $("#validpass2").removeClass("has-error");

                        }else {
                            $("#validpass2").removeClass("has-success");
                            $("#validpass2").addClass("has-error");
                            var error=data.split("-");
                            $.each(error,function (index,item) {
                                $("#errors_pass").append("</li><li>"+item);
                            });
                        }
                    }

                });
            });
        });
        function changepass() {
            var currentpass=$("#current_pass").val();
            var new1=$("#new_pass1").val();
            var new2=$("#new_pass2").val();
            var token=$("#chg_pass_token").val();

            if (currentpass=="" || new1=="" || new2==""){
                bootbox.alert("???????? ???????? ???????????? ???? ???????? ????????");
            }else{
                if (new1!=new2){
                    bootbox.alert("???????????? ???????? ???????? ???????? ?????????? ????????????");
                }else{
                    if (new1.length<=8){
                        bootbox.alert("?????? ?????? ???????? ???????? ???? ?? ?????????????? ?????????? ????????");
                    }else {
                        $.ajax({
                            url: "assets/ajax/changepss.php",
                            type: "POST",
                            data: {action:"change",current_pass:currentpass,pass1:new1,pass2:new2,token:token},
                            dataType: "html",
                            'success':function (data) {
                                if (data=="ok"){
                                    $("#myModal").removeClass("in");
                                    $("#myModal").css("display","none");
                                    $("div").removeClass("modal-backdrop");
                                    bootbox.alert("?????? ???????? ???? ???????????? ?????????? ????????");

                                    $("#current_pass").val("");
                                    $("#new_pass1").val("");
                                    $("#new_pass2").val("");
                                    // refresht();
                                }else{
                                    bootbox.alert(data);
                                }
                            }
                        });
                    }

                }
            }
        }
    </script>
    <style>
        .backm{
            background-color: rgba(0, 0, 0, 0.15);
        }
        .modal-dialog{
            margin-top: 7%;!important;
        }
    </style>






</head>

<body dir="rtl">
<div class="container-fluid">
    <!-- Second navbar for categories -->
    <nav class="navbar navbar-default" style="position: fixed;z-index: 99999;width: 100%;">
        <div class="container" style="width: 100%">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <div style="display: inline-flex;margin-top: 3%;margin-left: 15%">

                <div style="margin-top: 1%;margin-left: 20%">
                    <span class="text-warning" id="timeer" style="font-size: 20px"></span>
                </div>
                <div  class="dropdown">
                    <button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        <img style="margin-right: 10%;" src="assets/img/user2.png" width="20" height="20">
                        <?=$_SESSION['name'] ?>
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1" style="margin-right: -5%;">
                        <li><a href="#">??????????????<img style="margin-right: 10%;" src="assets/img/option.png" width="20" height="20"></a></li>
                        <li><a href="#" data-toggle="modal" data-target=".bs-example-modal-sm">?????????? ?????? ????????<img style="margin-right: 10%;" src="assets/img/pass.png" width="20" height="20"></a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="assets/logout.php">????????<img style="margin-right: 10%;" src="assets/img/logout.png" width="20" height="20"></a></li>
                    </ul>
                </div>
                </div>

            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li id="menu6"><a style="display: inline-flex;margin-right: 10%;margin-left: 10%;" href="dashbord.php"><img style="margin-right: 10%;margin-left: 15%" src="assets/img/dashboard.png" width="20" height="20">??????????????</a></li>
                    <li id="menu5"><a style="display: inline-flex;margin-right: 10%;margin-left: 10%;" href="new_kala.php"><img style="margin-right: 10%;margin-left: 15%" src="assets/img/Import.png" width="20" height="20">??????????</a></li>
                    <li id="menu4"><a style="display: inline-flex;margin-right: 10%;margin-left: 10%;" href="nemayandeh.php"><img style="margin-right: 10%;margin-left: 15%" src="assets/img/nema.png" width="20" height="20">??????????????????</a></li>
                    <li id="menu3"><a style="display: inline-flex;margin-right: 10%;margin-left: 10%;" href="nasieh.php"><img style="margin-right: 10%;margin-left: 15%" src="assets/img/nasi.svg" width="20" height="20">????????</a></li>
                    <li id="menu2"><a style="display: inline-flex;margin-right: 10%;margin-left: 10%;" href="report.php"><img style="margin-right: 10%;margin-left: 15%" src="assets/img/report.png" width="20" height="20">??????????????</a></li>
                    <li id="menu1"><a style="display: inline-flex;margin-right: 10%;margin-left: 10%;" href="users.php"><img style="margin-right: 10%;margin-left: 15%" src="assets/img/users.png" width="20" height="20">??????????????</a></li>

                </ul>

            </div><!-- /.navbar-collapse -->

        </div><!-- /.container -->
    </nav><!-- /.navbar -->
<!--    /////////// box-->

    <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel" style="margin-right: 50%">?????????? ?????? ????????</h4>
                </div>
                <div class="modal-body">
                    <form name="chg_pass">
                        <div class="col-md-12">
                            <label class="text-primary">?????? ???????? ????????:</label>
                            <input type="password" id="current_pass" class="form-control" placeholder="?????? ???????? ????????" autocomplete="off">
                        </div>
                        <hr>
                        <div class="col-md-12" style="margin-top: 10%">
                            <div class="form-group" id="validpass2">
                            <label class="text-primary">?????? ???????? ????????:</label>
                            <input type="password" id="new_pass1" class="form-control" placeholder="?????? ???????? ????????" autocomplete="off">
                        <ul id="errors_pass" style="margin-top: 3%" class="text-danger">

                        </ul>
                            </div>
                        </div>

                        <div class="col-md-12" style="margin-top: 5%">
                            <label class="text-primary">?????????? ?????? ????????:</label>
                            <input type="password" id="new_pass2" class="form-control" placeholder="?????????? ?????? ????????" autocomplete="off">
                        </div>


                    </form>
                </div>
                <div class="modal-footer" style="margin-top: 5%">
                    <button style="margin-top: 10%" type="button" class="btn btn-default" data-dismiss="modal">????????</button>
                    <button style="margin-top: 10%" onclick="changepass()" type="button" class="btn btn-success" style="margin-right: 5%">?????????? ?????? ????????</button>
                    <img src="assets/img/Waitinggif" width="40" height="40" style="display: none" id="wait">
                </div>
            </div>
        </div>
    </div>


</body>
