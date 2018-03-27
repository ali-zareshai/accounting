<?php
require "main.php";
?>
<script src="assets/js/amcharts.js"></script>
<!--<script src="assets/js/xy.js"></script>-->
<script src="assets/js/serial.js"></script>
<script src="assets/js/export.min.js"></script>
<link rel="stylesheet" href="assets/css/export.css"/>
<script src="assets/js/light.js"></script>

<script>
    $(document).ready(function () {
        $(document).ready(function () {
            // setmenu(1);
            $("#menu1").removeClass("backm");
            $("#menu2").removeClass("backm");
            $("#menu3").removeClass("backm");
            $("#menu4").removeClass("backm");
            $("#menu5").removeClass("backm");
            $("#menu6").removeClass("backm");
            $("#menu2").addClass("backm");

        });
    });
    function daychart() {
        var chart = AmCharts.makeChart("chartdiv", {
            "type": "serial",
            "theme": "light",
            "legend": {
                "useGraphSettings": true
            },
            "dataProvider": <?php echo json_encode(R::getAll("SELECT datef as year, SUM(meterf) as uk FROM (SELECT * FROM nasieh ORDER BY `timestamp` ASC ) AS `table` GROUP BY datef LIMIT 365"));?>,
            "valueAxes": [{
                "integersOnly": true,
                // "maximum": 6,
                // "minimum": 1,
                "reversed": false,
                "axisAlpha": 0,
                "dashLength": 5,
                "gridCount": 10,
                "position": "left",
                "title": "فروش روزانه (مترمربع)"
            }],
            "startDuration": 0.5,
            "graphs": [ {
                "balloonText": "[[category]]:<b>[[value]]</b>",
                "bullet": "round",
                "title": "فروش روزانه(مترمربع)",
                "valueField": "uk",
                "fillAlphas": 0
            }],
            "chartCursor": {
                "cursorAlpha": 0,
                "zoomable": false
            },
            "categoryField": "year",
            "categoryAxis": {
                "gridPosition": "start",
                "axisAlpha": 0,
                "fillAlpha": 0.05,
                "fillColor": "#000000",
                "gridAlpha": 0,
                "position": "top"
            },
            "export": {
                "enabled":false,
                "position": "top-right"
            }
        });

    }
    ////////// anbar chart //////////////
    function mojoditop() {
        var chart = AmCharts.makeChart("chartdiv", {
            "type": "serial",
            "theme": "light",
            "marginRight": 70,
            "dataProvider": <?php echo json_encode(R::getAll("SELECT CODE AS country,(meterg-meterf) AS visits FROM `kala` ORDER BY `visits` ASC LIMIT 25 ")); ?>,
            "valueAxes": [{
                "axisAlpha": 0,
                "position": "left",
                "title": "موجودی انبار (25 تا بیشتر)"
            }],
            "startDuration": 1,
            "graphs": [{
                "balloonText": "<b>[[category]]: [[value]]</b>",
                "fillColorsField": "color",
                "fillAlphas": 0.9,
                "lineAlpha": 0.2,
                "type": "column",
                "valueField": "visits"
            }],
            "chartCursor": {
                "categoryBalloonEnabled": false,
                "cursorAlpha": 0,
                "zoomable": false
            },
            "categoryField": "country",
            "categoryAxis": {
                "gridPosition": "start",
                "labelRotation": 45
            },
            "export": {
                "enabled": false
            }

        });
    }
    ////
    function mojodidown() {
        var chart = AmCharts.makeChart("chartdiv", {
            "type": "serial",
            "theme": "light",
            "marginRight": 70,
            "dataProvider": <?php echo json_encode(R::getAll("SELECT CODE AS country,(meterg-meterf) AS visits FROM `kala` ORDER BY `visits` DESC LIMIT 25 ")); ?>,
            "valueAxes": [{
                "axisAlpha": 0,
                "position": "left",
                "title": "موجودی انبار (25 تا کمتر)"
            }],
            "startDuration": 1,
            "graphs": [{
                "balloonText": "<b>[[category]]: [[value]]</b>",
                "fillColorsField": "color",
                "fillAlphas": 0.9,
                "lineAlpha": 0.2,
                "type": "column",
                "valueField": "visits"
            }],
            "chartCursor": {
                "categoryBalloonEnabled": false,
                "cursorAlpha": 0,
                "zoomable": false
            },
            "categoryField": "country",
            "categoryAxis": {
                "gridPosition": "start",
                "labelRotation": 45
            },
            "export": {
                "enabled": false
            }

        });
    }
</script>
<style>
    #chartdiv {
        width	: 100%;
        height	: 500px;
    }
</style>
<script>
    $(document).ready(function () {
        $("#type").change(function () {
            var type=$("#type").val();
            if (type=="day"){
                daychart();
            }else if (type=="mojtop"){
                mojoditop();
            }else if (type=="mojdow"){
                mojodidown();
            }
        })
    })
</script>

<div class="col-md-12" style="margin-top: 6%">
    <div class="col-md-2 " style="float: right">
    <select class="form-control" id="type">
        <option>انتخاب نوع گزارش </option>
        <option value="day">فروش روزانه</option>
        <option value="mojtop">موجودی انبار (بیشترین)</option>
        <option value="mojdow">موجودی انبار (کمترین)</option>

    </select>
    </div>
</div>
<div class="col-md-12" style="margin-top: 5%">
    <div class="panel">
        <div class="panel-title">
        </div>
        <div class="panel-body">
            <div id="chartdiv"></div>
        </div>
    </div>
</div>

<!--////////
SELECT datef, SUM(meterf) FROM nasieh GROUP BY datef
-->
