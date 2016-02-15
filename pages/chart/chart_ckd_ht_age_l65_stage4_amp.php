<?php
function __autoload($class_name){
	include'../class/class.'.$class_name.'.php';
}
set_time_limit(0);
include"../config/config.php";
$ystr=$_GET['ystr'];
$yend=$_GET['yend'];
$dbchr=new Database(DB_HOST_TK,DB_USER_TK,DB_PASS_TK,DB_NAME_TK);//new object
$dbchr->Query("
SELECT 
AMPNAME,
if(ROUND((sum(T_SUM)/sum(T_TARGET))*100,2) IS NULL,'0.00',ROUND((sum(T_SUM)/sum(T_TARGET))*100,2)) as RS,
LEFT(T_DATE,4)+543 as TY
FROM chart_ckd_ht_age_l65_stage4
WHERE T_DATE BETWEEN'".$ystr."' AND'".$yend."' AND AMPCODE<>'' 
GROUP BY AMPCODE ORDER BY ROUND((sum(T_SUM)/sum(T_TARGET))*100,2) DESC;
");
while($dbarr2=$dbchr->Fetch_array()){
	$amp=$dbarr2['AMPNAME'];
	$cc=$dbarr2['RS'];
	
	$myurl2[]="['$amp',$cc]";
	}
    
   // print_r($myurl);
 $te2=implode(",", $myurl2);
 
?>
<html>
  <head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
           ['อำเภอ','ร้อยละ'],
        
            <?php echo $te2 ; ?>
        ]);

        var options = {
          title: 'ร้อยละผู้ป่วย DM ที่มีภาวะไตเสื่อม (CKD) Stage4 อายุน้อยกว่า 65 ปี',  
          hAxis: {title: 'อำเภอ', titleTextStyle: {color: 'green'}}
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('chart_div1'));
        chart.draw(data, options);
      }
    </script>
    
    <title>LOEI CHART | REPORT DATA</title>

     <!-- Bootstrap Core CSS -->
    <link href="../../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../../bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Timeline CSS -->
    <link href="../../dist/css/timeline.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="../../bower_components/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../../bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  </head>
  <body>
    <div id="chart_div1" style="width:100%; height: 300px;"></div>
    
<!-- jQuery -->
    <script src="../../bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../../bower_components/metisMenu/dist/metisMenu.min.js"></script>

    

    <!-- Custom Theme JavaScript -->
    <script src="../../dist/js/sb-admin-2.js"></script>
    <script src="../js/sb-admin.js"></script>
</body>
  </body>
</html>