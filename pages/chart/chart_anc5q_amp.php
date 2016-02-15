<?php
session_start() ;
if (!isset($_SESSION['login_true'])) {
     header("Location: login.php");//สั่งให้ redirect ไปหน้า login เมื่อไม่มีการ login แต่เรียกใช้หน้านี้
     exit;
}

?>
<?php
function __autoload($class_name){
	include'../class/class.'.$class_name.'.php';
}
set_time_limit(0);
include"../config/config.php";
////
$ystr=$_GET['ystr'];
$yend=$_GET['yend'];
$dbchr=new Database(DB_HOST_TK,DB_USER_TK,DB_PASS_TK,DB_NAME_TK);//new object
$dbchr->Query("
SELECT 
AMPNAME,
ROUND((sum(T_SUM)/sum(T_TARGET))*100,2) as RS,
LEFT(T_DATE,4)+543 as TY
FROM z42_chart_amp_anc5q
WHERE T_DATE BETWEEN'".$ystr."' AND'".$yend."' AND AMPCODE<>'' GROUP BY AMPCODE ORDER BY ROUND((sum(T_SUM)/sum(T_TARGET))*100,2) DESC;
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
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
           ['อำเภอ','ร้อยละ'],
        
            <?php echo $te2 ; ?>
        ]);

        var options = {
          title: 'ร้อยละหญิงตั้งครรภ์ที่ได้รับการดูแลก่อนคลอด 5 ครั้ง',  
          hAxis: {title: 'อำเภอ', titleTextStyle: {color: 'green'}}
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('chart_div2'));
        chart.draw(data, options);
      }
    </script>
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
    <div id="chart_div2" style="width:100%; height: 300px;"></div>
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
</html>