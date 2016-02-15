<?php
include("../config/config.php");
$dbchr=new Database(DB_HOST_TK,DB_USER_TK,DB_PASS_TK,DB_NAME_TK);//new object
$dbchr->Query("SELECT * FROM $table_c");
while($dbarr2=$dbchr->Fetch_array()){
	$amp=$dbarr2['AMPNAME'];
	$cc=$dbarr2['SUMMARY'];
	$m=$dbarr2['MALE'];
	$fm=$dbarr2['FEMALE'];

	
	$myurl2[]="['$amp',$cc,$m,$fm]";
	}
    
   // print_r($myurl);
 $te2=implode(",", $myurl2);
 
?>
<html>
  
  <head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
           ['อำเภอ','จำนวน/คน','ชาย/คน','หญิง/คน'],
        
            <?php echo $te2 ; ?>
        ]);

        var options = {
          title: 'กลุ่มอายุ <?php echo $age_st;?>ถึง <?php echo $age_end;?> ปีขึ้นไป',  
          hAxis: {title: 'อำเภอ', titleTextStyle: {color: 'green'}}
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('chart_div1'));
        chart.draw(data, options);
      }
    </script>
     <!-- Core CSS - Include with every page -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../font-awesome/css/font-awesome.css" rel="stylesheet">

    <!-- Page-Level Plugin CSS - Dashboard -->
    <link href="../css/plugins/morris/morris-0.4.3.min.css" rel="stylesheet">
    <link href="../css/plugins/timeline/timeline.css" rel="stylesheet">

    <!-- SB Admin CSS - Include with every page -->
    <link href="../css/sb-admin.css" rel="stylesheet">
    
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>   
  </head>
  <body>
    <div id="chart_div1" style="width:100%; height: 300px;"></div>
    <!-- Core Scripts - Include with every page -->
<script src="../js/jquery-1.10.2.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/plugins/metisMenu/jquery.metisMenu.js"></script>

    <!-- Page-Level Plugin Scripts - Dashboard -->
<script src="../js/plugins/morris/raphael-2.1.0.min.js"></script>
<script src="../js/plugins/morris/morris.js"></script>

    <!-- SB Admin Scripts - Include with every page -->
<script src="../js/sb-admin.js"></script>
<script src="../js/back-to-top.js"></script>

    <!-- Page-Level Demo Scripts - Dashboard - Use for reference -->
<script src="../js/demo/dashboard-demo.js"></script>
  </body>
</html>