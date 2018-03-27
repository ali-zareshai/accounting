<?php
require "main.php";
?>
<script>
    function newww() {
        var code=$("#code").val();
        var dataf=$("#pcal1").val();
        var datae=$("#extra").val();
        var meter=$("#meter_gharid").val();
        var price=$("#price_gharid").val();
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

<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
    جنس جدید
</button>

<!--<div class="col-md-3">-->
<!--    <button class="btn btn-success" id="download-xlsx">دانلود XLS</button>-->
<!--</div>-->

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel" style="margin-right: 50%">کالای جدید</h4>
            </div>
            <div class="modal-body">
                <form name="new_kala">
                    <div class="col-md-12">
                        <label class="text-primary">کد کالا:</label>
                        <input type="text" id="code" class="form-control" placeholder="کد کالا">
                    </div>
                    <div class="col-md-12">
                        <label class="text-primary">تاریخ:</label>
                        <input type="text" id="pcal1" class="form-control" placeholder="تاریخ">
                        <input type="hidden" id="extra" class="pdate">
                    </div>
                    <div class="col-md-12">
                        <label class="text-primary">متراژ خرید:</label>
                        <input type="text" id="meter_gharid" class="form-control" placeholder="متراژ خریداری(مترمربع)">
                    </div>
                    <div class="col-md-12" style="margin-bottom: 5%">
                        <label class="text-primary">فیمت خرید:</label>
                        <input type="text" id="price_gharid" class="form-control" placeholder="قیمت خریداری(تومان)">
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
<div class="col-md-12" style="z-index: 1">
    <div class="container" >
        <button class="btn btn-success" id="download-csv"style="float: left">خروجی اکسل</button>

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