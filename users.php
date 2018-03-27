<?php
require "main.php";
require "assets/jdf.php";
?>
<script>
    $(document).ready(function () {
        // setmenu(1);
        $("#menu1").removeClass("backm");
        $("#menu2").removeClass("backm");
        $("#menu3").removeClass("backm");
        $("#menu4").removeClass("backm");
        $("#menu5").removeClass("backm");
        $("#menu6").removeClass("backm");
        $("#menu1").addClass("backm");

    });

    function newww() {
        var name=$("#name").val();
        var username=$("#username").val();
        var pass1=$("#pass1").val();
        var pass2=$("#pass2").val();
        var token=$("#new_user_token").val();
        // alert(token);

        if (name=="" || username=="" || pass1=="" || pass2==""){
            bootbox.alert("لطفا تمام فیلدها را کامل کنید‍!!!");
        }else{
            if (pass1!=pass2){
                bootbox.alert("رمزهای عبور با هم برابر نیستند.");
            }else{
                if (pass1.length<=8){
                    bootbox.alert("رمز عبور نباید کمتر از ۸ کاراکتر باشد");
                }else{
                    $.ajax({
                        url: "assets/ajax/users.php",
                        type: "POST",
                        data: {action : "new",name:name,username:username,pass:pass1,token:token},
                        dataType: "html",
                        'success':function (data) {
                            if (data=="ok"){
                                $("#myModal").removeClass("in");
                                $("#myModal").css("display","none");
                                $("div").removeClass("modal-backdrop");
                                // refresht();
                                window.location.href=window.location.href;
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
<button style="margin-top: 6%" type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
    کاربر جدید
</button>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel" style="margin-right: 50%">کاربر جدید</h4>
            </div>
            <div class="modal-body">
                <form name="new_user">
                    <div class="col-md-12">
                        <label class="text-primary">نام ونام خانوادگی:</label>
                        <input type="text" id="name" class="form-control" placeholder="نام ونام خانوادگی">
                    </div>
                    <div class="col-md-12">
                        <label class="text-primary">نام کاربری:</label>
                        <input type="text" id="username" class="form-control" placeholder="نام کاربری">
                    </div>
                    <div class="col-md-12">
                        <label class="text-primary">رمز عبور:</label>
                        <input type="password" id="pass1" class="form-control" placeholder="رمز عبور">
                    </div>
                    <div class="col-md-12" style="margin-bottom: 5%">
                        <label class="text-primary">تکرار رمز عبور:</label>
                        <input type="password" id="pass2" class="form-control" placeholder="تکرار رمز عبور">
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">بستن</button>
                <button onclick="newww()" type="button" class="btn btn-primary" style="margin-right: 5%">اضافه کردن</button>
                <img src="assets/img/Waitinggif" width="40" height="40" style="display: none" id="wait">
            </div>
        </div>
    </div>
</div>
<div class="col-md-12" style="margin-top: 2%;margin-top: 3%">
    <div class="panel">
        <table class="table table-hover">
            <thead>
            <tr>
                <td>نام</td>
                <td>نام کاربری</td>
                <td>آخرین لاگین</td>
            </tr>
            </thead>
            <tbody>
            <?php
            $arr=R::getAll( 'SELECT * FROM user' );
            foreach ($arr as $value){
                ?>
                <tr>
                    <td><?=$value["name"] ?></td>
                    <td><?=$value["username"] ?></td>
                    <td><?=jdate("j F Y - H:i:s", $value["login"]); ?></td>
                </tr>
            <?php
            }
            ?>
            </tbody>
        </table>
    </div>
</div>
