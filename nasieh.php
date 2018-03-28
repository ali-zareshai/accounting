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

    /////////////////////////////
    $(document).ready(function () {
        $("#menu1").removeClass("backm");
        $("#menu2").removeClass("backm");
        $("#menu3").removeClass("backm");
        $("#menu4").removeClass("backm");
        $("#menu5").removeClass("backm");
        $("#menu6").removeClass("backm");
        $("#menu3").addClass("backm");


        $("#price_total").keyup(function () {
            $("#price_total").val(ToRial($("#price_total").val()));
        });

        $("#daryafti").keyup(function () {
            $("#daryafti").val(ToRial($("#daryafti").val()));
        });

        $("#meterf").keyup(function () {
            $("#meterf").val(ToRial($("#meterf").val()));
        });
        ///// Save Btn //////
        $("#save").click(function () {
            var datef=$("#pcal1").val();
            var datee=$("#extra").val();
            var nemayndeh=$("#nemayandeh").val();
            var kala=$("#kala").val();
            var meterf=$("#meterf").val().replace(",","");
            var price_total=$("#price_total").val().replace(",","");
            var daryafti=$("#daryafti").val().replace(",","");
            var token=$("#new_nasieh_token").val();

            if (datef=="" || nemayndeh=="" || kala=="" || meterf=="" || price_total=="" || daryafti=="")
            {
                bootbox.alert("لطفا تمام فیلد ها را وارد کنید");
            }else{
                $.ajax({
                    url: "assets/ajax/nasieh.php",
                    type: "POST",
                    data: {action : "new",datef:datef,datee:datee,nemayndeh:nemayndeh,kala:kala,meterf:meterf,price_total:price_total,daryafti:daryafti,token:token},
                    dataType: "html",
                    'success':function (data) {
                        if (data=="ok"){
                            $("#myModal").removeClass("in");
                            $("#myModal").css("display","none");
                            $("div").removeClass("modal-backdrop");
                            refresht();

                        }else {
                            bootbox.alert(data);
                        }
                    }
                });
            }



        });
        var Calcdaryaft = function(values, data, calcParams){
            var calc = 0;
            values.forEach(function(value){
                calc+=parseInt(value.replace(",",""));
            });
            $("#daryaft").val(calc);
            myalert();

            return " کل : "+ToRial(calc.toString());
        };
        var foroshcal = function(values, data, calcParams){
            var calc = 0;
            values.forEach(function(value){
                calc+=parseInt(value.replace(",",""));
            });
            $("#daryaft").val(calc);
            myalert();

            return " کل : "+ToRial(calc.toString());
        };
        var Calctotal = function(values, data, calcParams){
            var calc = 0;
            values.forEach(function(value){
                calc+=parseInt(value.replace(",",""));
            });
            $("#total").val(calc);
            myalert();

            return " کل : "+ToRial(calc.toString());
        };


        $("#example-table").tabulator({
            height:"530px",
            layout:"fitColumns",
            pagination:"local",
            paginationSize:13,
            movableColumns:true,
            columns:[
                {title:"تاریخ", field:"date", width:100, headerFilter:"input", align:"center"},
                {title:"نسیه کننده", field:"name", headerFilter:"input", align:"center"},
                {title:"کد کالا", field:"code", headerFilter:"input", align:"center"},
                {title:"متراژ فروش(مترمربع)", field:"meterf", align:"center", bottomCalc:foroshcal},
                {title:"قیمت کل(تومان)", field:"pricet", align:"center", bottomCalc:Calctotal},
                {title:"تلفن", field:"tele", align:"center"},
                {title:"وجه دریافتی(تومان)", field:"daryaft", align:"center", bottomCalc:Calcdaryaft},
            ],
        });





        $("#download-csv").click(function(){
            $("#example-table").tabulator("download", "csv", "nasieh.csv");
        });


        refresht();



    });
    function refresht() {
        $.ajax({
            url: "assets/ajax/nasieh.php",
            type: "POST",
            data: {action : "table"},
            dataType: "html",
            'success':function (data) {
                $("#example-table").tabulator("setData", data);
            }
        });
    }
    function myalert() {
        var daryaft=$("#daryaft").val();
        var total=$("#total").val();
        var res=total-daryaft;
        if (res>0){
            $("#alert").removeClass("alert-success");
           $("#alert").addClass("alert-danger");

        }else{
            $("#alert").addClass("alert-success");
            $("#alert").removeClass("alert-danger");
        }
        res=Math.abs(res).toString();
        str = res.replace(/\,/g, '');
        var objRegex = new RegExp('(-?[0-9]+)([0-9]{3})');

        while (objRegex.test(str)) {
            str = str.replace(objRegex, '$1,$2');
        }

        $("#alert").html("وضعیت بدهکاری : "+str+" تومان ");

    }
</script>
<!-- Button trigger modal -->
<div style="margin-top: 6%">
<div class="alert alert-danger" role="alert" id="alert"></div>
<input type="hidden" id="daryaft">
<input type="hidden" id="total">
<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
    نسیه جدید
</button>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel" style="margin-right: 50%">نسیه جدید</h4>
            </div>
            <div class="modal-body">
                <form name="new_nasieh">
                <div class="col-md-12">
                    <label class="text-primary">تاریخ:</label>
                    <div class="input-group" style="direction: ltr">
                        <span id="basic-addon1" class="input-group-addon"><img src="assets/img/calendar-alt.svg" height="20" width="20"></span>
                    <input aria-describedby="basic-addon1" style="direction: rtl;margin-bottom: -20px" class="form-control" id="pcal1" placeholder="تاریخ" autofocus="autofocus">
                        <input type="hidden" id="extra" class="pdate">
                    </div>
                </div>
                    <br>
                    <div class="col-md-12" style="margin-top: 6%;">
                        <div class="col-md-9">
                            <select style="margin-right: 10%" size="6" class="selectpicker" data-live-search="true" id="nemayandeh">
                                <?php
                                $list=R::getAll( 'SELECT * FROM personel' );
                                foreach ($list as $value){ ?>
                                    <option value="<?= $value['id'] ?>"><?= $value['user'] ?></option>
                                <?php  }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="text-primary">نسیه کننده: </label>
                        </div>


                    </div>
                    <div class="col-md-12" style="margin-top: 3%">
                        <div class="col-md-9">
                            <select style="margin-right: 10%" size="6" class="selectpicker" id="kala" data-live-search="true">
                                <?php
                                $list=R::getAll( 'SELECT * FROM kala' );
                                foreach ($list as $value){ ?>
                                    <option value="<?= $value['id'] ?>"><?= $value['code'] ?></option>
                                <?php  }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="text-primary">کد کالا: </label>
                        </div>
                    </div>
                        <div class="col-md-12" style="margin-top: 5%">
                            <label class="text-primary">متراژ فروش:</label>
                            <div class="input-group" style="direction: ltr">
                                <span class="input-group-addon">مترمربع</span>
                                <input style="direction: rtl" class="form-control" type="text" id="meterf" placeholder="متراژ فروش(مترمربع)">
                            </div>
                        </div>
                    <div class="col-md-12" style="margin-top: 3%">
                        <label class="text-primary">جمع کل قیمت:</label>
                        <div class="input-group" style="direction: ltr">
                            <span class="input-group-addon">تومان</span>
                            <input style="direction: rtl" class="form-control" placeholder="قیمت کل(تومان)" id="price_total" type="text">
                        </div>

                    </div>
                    <div class="col-md-12" style="margin-top: 3%;;margin-bottom: 5%">
                        <label class="text-primary">وجه دریافتی:</label>
                        <div class="input-group" style="direction: ltr">
                            <span class="input-group-addon">تومان</span>
                            <input style="direction: rtl" value="" class="form-control" type="text" id="daryafti" placeholder="وجه دریافتی(تومان)">
                        </div>

                    </div>

                </form>
            </div>
            <div class="modal-footer" style="margin-top: 5%;margin-bottom: 2%">
                <button type="button" class="btn btn-default" data-dismiss="modal">لغو</button>
                <button id="save" type="button" class="btn btn-primary" style="margin-right: 10%;width: 20%">ذخیره<img src="assets/img/save.svg" width="20" height="20" style="margin-right: 15%"> </button>
                <img src="assets/img/Waitinggif" width="40" height="40" id="wait" style="display: none;margin-right: 50%">
            </div>
        </div>
    </div>
</div>
<div class="col-md-12">
    <div class="panel">
        <button class="btn btn-success" id="download-csv" style="float: left">خروجی اکسل</button>
        <div id="example-table" style="margin-top: 5%"></div>
    </div>
</div>
</div>
<script>
    var objCal1 = new AMIB.persianCalendar( 'pcal1',
        { extraInputID: "extra", extraInputFormat: "YYYY-MM-DD" }
    );
</script>
