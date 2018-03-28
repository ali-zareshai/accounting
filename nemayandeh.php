<?php
require "main.php";
?>
<script>
    function regiter() {
       var name=$("#name").val();
        var user=$("#user").val();
        var tel=$("#tele").val();
        var mobile=$("#mobile").val();
        var addre=$("#address").val();
        var token=$("#new_nemayndeh_token").val();
        if (name=="" || user=="" || tel=="" || mobile=="" || addre==""){
            bootbox.alert({
                message: "لطفا تمام فیلدها را بر کنید",
                size: 'small'
            });
        }else {

            $.ajax({
                url: "assets/ajax/nemayandeh.php",
                type: "POST",
                data: {action : "new",name:name,user:user,tele:tel,mobile:mobile,address:addre,token:token},
                dataType: "html",
                'success' : function(data) {
                    $("#wait").css("display","none");
                    if (data=="ok"){
                        $("#myModal").removeClass("in");
                        $("#myModal").css("display","none");
                        $("div").removeClass("modal-backdrop");
                        refresh();
                        window.location.reload();

                        bootbox.alert({
                            message: "با موفقیت ثبت شد",
                            size: 'small'
                        });
                        $("#name").val("");
                        $("#user").val("");
                        $("#tele").val("");
                        $("#mobile").val("");
                        $("#address").val("");
                    }else {
                        bootbox.alert({
                            message: " خطا در ثبت اطلاعات",
                            size: 'small'
                        });
                    }
                },
                beforesend:function () {
                    $("#wait").css("display","block");
                }
            });
        }


    }
    function refresh() {
        $("#example-table").tabulator("setData", <?= json_encode(R::getAll( 'SELECT * FROM personel' )) ?>);

    }
    $(document).ready(function() {
        $("#menu1").removeClass("backm");
        $("#menu2").removeClass("backm");
        $("#menu3").removeClass("backm");
        $("#menu4").removeClass("backm");
        $("#menu5").removeClass("backm");
        $("#menu6").removeClass("backm");
        $("#menu4").addClass("backm");
        $("#example-table").tabulator({
            height:505, // set height of table (in CSS or here), this enables the Virtual DOM and improves render speed dramatically (can be any valid css height value)
            layout:"fitColumns",
            fitColumns:true,
            pagination:"local",
            paginationSize:15,
            movableColumns:true,
            columns:[ //Define Table Columns
                {title:"حذف",field:"id",align:"center", cellClick:function(e, cell){
                        bootbox.confirm({
                            message: "آیا می خواهید این نماینده را حذف کنید؟",
                            buttons: {
                                confirm: {
                                    label: 'بله',
                                    className: 'btn-success'
                                },
                                cancel: {
                                    label: 'لغو',
                                    className: 'btn-danger'
                                }
                            },
                            callback: function (result) {
                                if (result){
                                    $.ajax({
                                        url: "assets/ajax/nemayandeh.php",
                                        type: "POST",
                                        data: {
                                            action: "deleth",
                                            id:cell.getValue()
                                        },
                                        dataType: "html",
                                        'success': function (data) {
                                            if(data=="ok"){
                                                bootbox.alert("با موفقیت حذف شد");
                                                window.location.reload();
                                            }else {
                                                bootbox.alert("خطا در حذف");
                                            }

                                        }
                                    });
                                }
                            }
                        });
                }},
                {title:"نام", field:"name", align:"center"},
                {title:"نام کاربری", field:"user", align:"right"},
                {title:"تلفن", field:"tele", align:"center"},
                {title:"موبایل", field:"mobile", align:"center"},
                {title:"آدرس", field:"address"}
            ],
//            rowClick:function(e, row){ //trigger an alert message when the row is clicked
//                alert("Row " + row.getIndex()+ " Clicked!!!!");
//            },
        });
        ///

        refresh();

    } );
</script>
<style>
    .col-md-12{
        margin-top: 2%!important;
    }
</style>
<button style="margin-top: 6%" type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
    نماینده جدید
</button>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title col-md-offset-4" id="myModalLabel" style="margin-right: 50%">نماینده جدید</h4>
            </div>
            <div class="modal-body" style="height: 66%">
                <form method="post" action=""  name="new_nemayndeh">
                    <div class="col-md-12" >
                        <label class="text-primary">نام:</label>
                        <input id="name" type="text" name="name" class="form-control" PLACEHOLDER="نام" >
                    </div>
                    <br>
                    <div class="col-md-12">
                        <label class="text-primary">نام کاریری:</label>
                        <input id="user" type="text" name="user" class="form-control" PLACEHOLDER="نام کاربری" >
                    </div>
                    <br>

                    <div class="col-md-12">
                        <label class="text-primary">تلفن:</label>
                        <div class="input-group" style="direction: ltr">
                        <span class="input-group-addon"><img src="assets/img/telephone-of-old-design.svg" width="20" height="20"></span>
                        <input style="direction: rtl" id="tele" type="text" name="tele" class="form-control" PLACEHOLDER="تلفن" >
                    </div>
                    </div>
                    <div class="col-md-12">
                        <label class="text-primary">موبایل:</label>
                        <div class="input-group" style="direction: ltr">
                            <span class="input-group-addon"><img src="assets/img/smartphone.svg" width="20" height="20"></span>
                        <input style="direction: rtl" id="mobile" type="text" name="mobile" class="form-control" PLACEHOLDER="موبایل" >
                    </div>
                    </div>
                    <div class="col-md-12">
                        <label class="text-primary">آدرس:</label>
                        <div class="input-group" style="direction: ltr">
                            <span class="input-group-addon"><img src="assets/img/location-pin.svg" width="20" height="20"></span>
                        <input style="direction: rtl" id="address" type="text" name="address" class="form-control" PLACEHOLDER="آدرس"  >
                    </div>
                    </div>
                </form>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">بستن</button>
                <button style="margin-right: 6%" type="button" class="btn btn-primary" onclick="regiter()">ذخیره<img src="assets/img/save.svg" width="20" height="20" style="margin-right: 15%"></button>
                <img src="assets/img/Waitinggif" width="40" height="40" style="display: none" id="wait">
            </div>
        </div>
    </div>
</div>
<div class="col-md-12" style="z-index: 1">
    <div class="container" >

        <div class="panel panel-primary" style="margin-top: 15px;">
            <div class="form-inline panel-body">
                <div id="example-table"></div>



                </div>

            </div>
        </div>
    </div>
</div>
