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
<!--    ///////-->
    <script>
        function changepass() {
            var currentpass=$("#current_pass").val();
            var new1=$("#new_pass1").val();
            var new2=$("#new_pass2").val();
            var token=$("#token").val();

            if (currentpass=="" || new1=="" || new2==""){
                bootbox.alert("لطفا تمام فیلدها را کامل کنید");
            }else{
                if (new1!=new2){
                    bootbox.alert("رمزهای عبور جدید باهم برابر نیستند");
                }else{
                    if (new1.length<=8){
                        bootbox.alert("طول رمز عبور کمتر از ۸ کاراکتر نباید باشد");
                    }else {
                        $.ajax({
                            url: "assets/ajax/changepss.php",
                            type: "POST",
                            data: {current_pass:currentpass,pass1:new1,pass2:new2,token:token},
                            dataType: "html",
                            'success':function (data) {
                                if (data=="ok"){
                                    $("#myModal").removeClass("in");
                                    $("#myModal").css("display","none");
                                    $("div").removeClass("modal-backdrop");
                                    bootbox.alert("رمز عبور با موفقیت تغییر یافت");
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






</head>

<body dir="rtl">
<div class="container-fluid">
    <!-- Second navbar for categories -->
    <nav class="navbar navbar-default">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <div style="margin-top: 7%" class="dropdown">
                    <button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        <?=$_SESSION['name'] ?>
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                        <li><a href="#">تنظیمات</a></li>
                        <li><a href="#" data-toggle="modal" data-target=".bs-example-modal-sm">تغییر رمز عبور</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="assets/logout.php">خروج</a></li>
                    </ul>
                </div>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="dashbord.php">داشبورد</a></li>
                    <li><a href="new_kala.php">اجناس وارداتی</a></li>
                    <li><a href="nemayandeh.php">نمایندگان</a></li>
                    <li><a href="nasieh.php">نسیه ها</a></li>
                    <li><a href="report.php">گزارشات</a></li>
                    <li><a href="users.php">کاربران</a></li>
                    <li>
                        <a class="btn btn-default btn-outline btn-circle collapsed"  data-toggle="collapse" href="#nav-collapse1" aria-expanded="false" aria-controls="nav-collapse1">Categories</a>
                    </li>
                </ul>
                <ul class="collapse nav navbar-nav nav-collapse" id="nav-collapse1">
                    <li><a href="#">Web design</a></li>
                    <li><a href="#">Development</a></li>
                    <li><a href="#">Graphic design</a></li>
                    <li><a href="#">Print</a></li>
                    <li><a href="#">Motion</a></li>
                    <li><a href="#">Mobile apps</a></li>
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
                    <h4 class="modal-title" id="myModalLabel" style="margin-right: 50%">تغییر رمز عبور</h4>
                </div>
                <div class="modal-body">
                    <form name="chg_pass">
                        <div class="col-md-12">
                            <label class="text-primary">رمز عبور فعلی:</label>
                            <input type="password" id="current_pass" class="form-control" placeholder="رمز عبور فعلی" autocomplete="off">
                        </div>
                        <hr>
                        <div class="col-md-12" style="margin-top: 10%">
                            <label class="text-primary">رمز عبور جدید:</label>
                            <input type="password" id="new_pass1" class="form-control" placeholder="رمز عبور جدید" autocomplete="off">
                        </div>
                        <div class="col-md-12" style="margin-top: 5%">
                            <label class="text-primary">تکرار رمز عبور:</label>
                            <input type="password" id="new_pass2" class="form-control" placeholder="تکرار رمز عبور" autocomplete="off">
                        </div>


                    </form>
                </div>
                <div class="modal-footer" style="margin-top: 5%">
                    <button style="margin-top: 10%" type="button" class="btn btn-default" data-dismiss="modal">بستن</button>
                    <button style="margin-top: 10%" onclick="changepass()" type="button" class="btn btn-success" style="margin-right: 5%">تغییر رمز عبور</button>
                    <img src="assets/img/Waitinggif" width="40" height="40" style="display: none" id="wait">
                </div>
            </div>
        </div>
    </div>


</body>