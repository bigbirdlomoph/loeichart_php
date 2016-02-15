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
          title: 'กลุ่มอายุ <?php echo $age;?> ปีขึ้นไป',  
          hAxis: {title: 'อำเภอ', titleTextStyle: {color: 'green'}}
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('chart_div1'));
        chart.draw(data, options);
      }
    </script>
  </head>
  <body>
    <div id="chart_div1" style="width:100%; height: 300px;"></div>
  </body>
</html>