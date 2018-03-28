<?php
// **PREVENTING SESSION HIJACKING**
// Prevents javascript XSS attacks aimed to steal the session ID
ini_set('session.cookie_httponly', 1);

// **PREVENTING SESSION FIXATION**
// Session ID cannot be passed through URLs
ini_set('session.use_only_cookies', 1);

// Uses a secure connection (HTTPS) if possible
ini_set('session.cookie_secure', 1);
session_start();
require_once "assets/log2.php";
$addr=$_SERVER['SERVER_ADDR'];
//echo $addr;
log2($addr,"visit loggin page");




?>
<html dir="rtl">
<head xmlns="http://www.w3.org/1999/html">
    <script src="assets/js/jquery-3.3.1.min.js"></script>
    <script src="assets/js/bootstrap.min.js"> </script>
    <script src="assets/js/bootbox.min.js"> </script>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="assets/css/login.css"/>
    <link rel="stylesheet" href="assets/css/font.css"/>
    <link rel="stylesheet" href="assets/css/animate.css"/>
    <script src="assets/js/login.js"> </script>
    <script src="assets/js/token.js"> </script>
    <script>
        $(document).ready(function () {
           $("#showpass").hover(function () {
               $("#inputPassword").attr("type","text");
           }) ;
            $("#showpass").mouseout(function () {
                $("#inputPassword").attr("type","password");
            }) ;
        });
    </script>

</head>
<body>
<div class="container">
    <div class="card card-container bounceInDown animated">
        <!-- <img class="profile-img-card" src="//lh3.googleusercontent.com/-6V8xOA6M7BA/AAAAAAAAAAI/AAAAAAAAAAA/rzlHcD0KYwo/photo.jpg?sz=120" alt="" /> -->
        <img id="profile-img" class="profile-img-card" src="//ssl.gstatic.com/accounts/ui/avatar_2x.png" />
        <p id="profile-name" class="profile-name-card"></p>
        <form name="login" class="form-signin" method="post" action="">
            <span id="reauth-email" class="reauth-email"></span>
            <input name="user" type="text" id="inputuser" class="form-control" placeholder="نام کاربری" required autocomplete="off">
            <br>
            <div class="input-group" style="direction: ltr">
                <span class="input-group-addon"  id="basic-addon1"><img style="cursor: pointer" id="showpass" src="assets/img/eye.svg" alt="مشاهده رمز عبور" height="20" width="20"></span></span></span>
                <input aria-describedby="basic-addon1" style="direction: rtl;margin-bottom: 0%!important;" name="pass" type="password" id="inputPassword" class="form-control" placeholder="رمز عبور" required autocomplete="off">
            </div>
            <br>
            <div class="form-inline">
            <img style="margin-right: 25%" width="140" height="50" src="capthal.php" alt="CAPTCHA" >
            <input type="text" id="cap" class="form-control" placeholder="لطفا کد امنیتی را وارد کنید" >
            </div>

            <button onclick="login_form()" class="btn btn-lg btn-primary btn-block btn-signin" type="button"><img src="assets/img/sign-in-alt.svg" height="20" width="20" style="margin-left: 5%;">ورود</button>
            <div id="alert_div" class="alert-danger" role="alert" style="display: none"></div>
        </form><!-- /form -->
<!--        <a href="#" class="forgot-password">-->
<!--            Forgot the password?-->
<!--        </a>-->
    </div><!-- /card-container -->
</div><!-- /container -->
</body>

</html>