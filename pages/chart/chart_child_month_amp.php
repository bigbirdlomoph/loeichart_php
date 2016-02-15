<?php
include("../config/config.php");
$dbchr=new Database(DB_HOST_TK,DB_USER_TK,DB_PASS_TK,DB_NAME_TK);//new object
$dbchr->Query("
SELECT 
		tb1.AMP_CODE AS AMPCODE ,
		tb1.AMP_NAME AS AMPNAME,
		CASE WHEN tb2.CC='' THEN '0' 
			 WHEN tb2.CC<>'' THEN tb2.CC
		ELSE '0' END AS SUMMARY,
		CASE WHEN tb3.M='' THEN '0' 
			 WHEN tb3.M<>'' THEN tb3.M
		ELSE '0' END AS MALE,
		CASE WHEN tb4.FM='' THEN '0' 
			 WHEN tb4.FM<>'' THEN tb4.FM
		ELSE '0' END AS FEMALE
		
FROM(
	   SELECT 
       AMP_CODE,AMP_NAME  
	   FROM z42_amp 
       GROUP BY AMP_CODE 
) as tb1
LEFT JOIN
(
		SELECT 
        CONCAT(CHANGWAT,AMPUR) as AMP_CODE,
	    COUNT(*) as CC
		FROM z42_age_group_vill_t_05y 
		WHERE AGE_MONTH = '".$age."'		
    GROUP BY CONCAT(CHANGWAT,AMPUR) 
) as tb2 ON tb1.AMP_CODE=tb2.AMP_CODE 
LEFT JOIN 
(
   SELECT 
		CONCAT(CHANGWAT,AMPUR) as AMP_CODE,		
		COUNT(*) as M
		FROM  z42_age_group_vill_t_05y 
    WHERE SEX='1' AND  AGE_MONTH ='".$age."' 
		GROUP BY CONCAT(CHANGWAT,AMPUR)
)as tb3 ON tb1.AMP_CODE=tb3.AMP_CODE 
LEFT JOIN 
(
SELECT 
		CONCAT(CHANGWAT,AMPUR) as AMP_CODE,		
		COUNT(*) as FM
		FROM  z42_age_group_vill_t_05y 
    WHERE SEX='2' AND  AGE_MONTH ='".$age."'  
    GROUP BY CONCAT(CHANGWAT,AMPUR)
)as tb4 ON tb1.AMP_CODE=tb4.AMP_CODE 
GROUP BY tb1.AMP_CODE
UNION ALL
SELECT 
		'',
		'รวม', 
		 SUM(tb2.CC) as SUMMARY,
		 SUM(tb3.M) as MALE,
		 SUM(tb4.FM) as FEMALE
		
FROM(
	   SELECT 
       AMP_CODE,AMP_NAME  
	   FROM z42_amp 
       GROUP BY AMP_CODE 
) as tb1
LEFT JOIN
(
		SELECT 
        CONCAT(CHANGWAT,AMPUR) as AMP_CODE,
	    COUNT(*) as CC
		FROM z42_age_group_vill_t_05y 
		WHERE AGE_MONTH ='".$age."'		
    GROUP BY CONCAT(CHANGWAT,AMPUR) 
) as tb2 ON tb1.AMP_CODE=tb2.AMP_CODE 
LEFT JOIN 
(
   SELECT 
		CONCAT(CHANGWAT,AMPUR) as AMP_CODE,		
		COUNT(*) as M
		FROM  z42_age_group_vill_t_05y 
    WHERE SEX='1' AND  AGE_MONTH ='".$age."' 
		GROUP BY CONCAT(CHANGWAT,AMPUR)
)as tb3 ON tb1.AMP_CODE=tb3.AMP_CODE 
LEFT JOIN 
(
SELECT 
		CONCAT(CHANGWAT,AMPUR) as AMP_CODE,		
		COUNT(*) as FM
		FROM  z42_age_group_vill_t_05y 
    WHERE SEX='2' AND  AGE_MONTH ='".$age."'  
    GROUP BY CONCAT(CHANGWAT,AMPUR)
)as tb4 ON tb1.AMP_CODE=tb4.AMP_CODE ;
");
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
          title: 'กลุ่มอายุ <?php echo $age;?> เดือน',  
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