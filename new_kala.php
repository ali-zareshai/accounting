<?php
require "main.php";
?>
<script>
    function ToRial(str) {

        str = str.replace(/\,/g, '');
        var objRegex = new RegExp('(-?[0-9]+)([0-9]{3})');

        while (objRegex.test(str)) {
            str = str.replace(objRegex, '$1,$2');
        }

        return str;
    }



    function newww() {
        var code=$("#code").val();
        var dataf=$("#pcal1").val();
        var datae=$("#extra").val();
        var meter=$("#meter_gharid").val().replace(",","");
        var price=$("#price_gharid").val().replace(",","");
        var token=$("#new_kala_token").val();
        ///////////
        if (code=="" || dataf=="" || datae=="" || meter=="" || price==""){
            bootbox.alert("لطفا تمام فیلد ها را وارد کنید...");
        }else {
            $.ajax({
                url:"assets/ajax/newkala.php",
                type:"POST",
                data:{
                    action:"new",
                    code:code,
                    dataf:dataf,
                    datae:datae,
                    meter:meter,
                    price:price,
                    token:token
                },
                datatype:"html",
                success:function (data) {
                    $("#wait").css("display","none");
                   if (data=="ok"){
                       $("#myModal").removeClass("in");
                       $("#myModal").css("display","none");
                       $("div").removeClass("modal-backdrop");
                       refresht();
                   }else{
                       bootbox.alert(data);
                   }
                },
                beforesend:function () {
                    $("#wait").css("display","block");
                }
            });
        }

    }
    /////////////////////// table //////////////
    $(document).ready(function() {
        $("#menu1").removeClass("backm");
        $("#menu2").removeClass("backm");
        $("#menu3").removeClass("backm");
        $("#menu4").removeClass("backm");
        $("#menu5").removeClass("backm");
        $("#menu6").removeClass("backm");
        $("#menu5").addClass("backm");

        $("#example-table").tabulator({
            height:"511px",
            layout:"fitColumns",
            pagination:"local",
            paginationSize:16,
            movableColumns:true,
            columns:[
                {title:"کد جنس", field:"code"},
                {title:"تاریخ", field:"dataf"},
                {title:"متراژ خرید", field:"meterg", align:"center"},
                {title:"قیمت خرید", field:"priceg"},
                {title:"متراژ فروش", field:"meterf", align:"center", bottomCalc:"sum"},
                {title:"قیمت فروش", field:"pricef", align:"center", bottomCalc:"sum"},
                {title:"موجودی", field:"moj", align:"center", sorter:"number"},
                {title:"عملیات", field:"car", align:"center"}
            ]
        });
        //trigger download of data.csv file
        $("#download-csv").click(function(){
            $("#example-table").tabulator("download", "csv", "data.csv");
        });

        refresht();
         //// Add point to input /////
        $("#meter_gharid").keyup(function () {
            $("#meter_gharid").val(ToRial($("#meter_gharid").val()));
        });

        $("#price_gharid").keyup(function () {
            $("#price_gharid").val(ToRial($("#price_gharid").val()));
        });

    });

    function refresht() {
        $.ajax({
            url: "assets/ajax/newkala.php",
            type: "POST",
            data: {action : "table"},
            dataType: "html",
            'success':function (data) {
                $("#example-table").tabulator("setData", data);
            }
        });
    }


</script>

<style>
    .col-md-12{
        margin-top: 3%!important;
    }
</style>
<button style="margin-top: 6%" type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
    جنس جدید<img style="margin-right: 10%;" src="assets/img/add.png" width="20" height="20">
</button>

<!--<div class="col-md-3">-->
<!--    <button class="btn btn-success" id="download-xlsx">دانلود XLS</button>-->
<!--</div>-->

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button  type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel" style="margin-right: 50%">کالای جدید</h4>
            </div>
            <div class="modal-body" style="margin-bottom: 22%;">
                <form name="new_kala">
                    <div class="col-md-12">
                        <label class="text-primary">کد کالا:</label>
                        <input type="text" id="code" class="form-control" placeholder="کد کالا">
                    </div>
                    <div class="col-md-12">
                        <label class="text-primary">تاریخ:</label>
                        <div class="input-group" style="direction: ltr">
                            <span id="basic-addon1" class="input-group-addon"><img src="assets/img/calendar-alt.svg" height="20" width="20"></span>
                        <input style="direction: rtl;margin-bottom: -4%;" type="text" id="pcal1" class="form-control" placeholder="تاریخ">
                        <input type="hidden" id="extra" class="pdate">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label class="text-primary">متراژ خرید:</label>
                        <div class="input-group" style="direction: ltr">
                            <span class="input-group-addon">مترمربع</span>
                            <input style="direction: rtl" type="text" id="meter_gharid" class="form-control" placeholder="متراژ خریداری(مترمربع)">
                    </div>
                    </div>
                    <div class="col-md-12" style="margin-bottom: 5%">
                        <label class="text-primary">قیمت خرید:</label>
                        <div class="input-group" style="direction: ltr">
                            <span class="input-group-addon">تومان</span>
                        <input style="direction: rtl" type="text" id="price_gharid" class="form-control" placeholder="قیمت خریداری(تومان)">
                    </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">بستن<img style="margin-right: 10%;" src="assets/img/del.png" width="20" height="20"></button>
                <button onclick="newww()" type="button" class="btn btn-primary" style="margin-right: 5%">ذخیره<img src="assets/img/save.svg" width="20" height="20" style="margin-right: 15%"></button>
                <img src="assets/img/Waitinggif" width="40" height="40" style="display: none" id="wait">
            </div>
        </div>
    </div>
</div>
<div class="col-md-12" style="z-index: 1">
    <div class="container" >
        <button class="btn btn-info" id="download-csv"style="float: left">خروجی اکسل<img style="margin-right: 10%;" src="assets/img/Excel.ico" width="20" height="20"></button>

        <div class="panel panel-primary" style="margin-top: 5%;">
            <div class="form-inline panel-body">
                <div id="example-table"></div>



            </div>

        </div>
    </div>
</div>

<script>
    var objCal1 = new AMIB.persianCalendar( 'pcal1',
        { extraInputID: "extra", extraInputFormat: "YYYY-MM-DD" }
    );
</script>