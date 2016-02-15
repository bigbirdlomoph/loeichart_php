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

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="description" content="">
<meta name="author" content="">
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
    
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>      
</head>

<body>
<?php

$id=$_POST['id'];//id report
$o_year=substr($_POST['str_date'],0,4);//year_old 10,11,12
$b_year=substr($_POST['end_date'],0,4);//year_next 
$ystr=$_POST['str_date'];
$yend=$_POST['end_date'];
 $dbrpt=new Database(DB_HOST_TK,DB_USER_TK,DB_PASS_TK,DB_NAME_TK);//new object 
?>

<!---->
 <div class="panel panel-info">
  <div class="panel-heading">หญิงตั้งครรภ์ที่มีภาวะเสี่ยง ได้รับการเยี่ยมบ้าน
  
  </div>
     <div class="panel-body">
            
<div class="table-responsive ">
<table class="table table-hover">
<thead>
          <tr>
              
             <th>อำเภอ</th>
              <th>จำนวนหญิงตั้งครรภ์ที่มีภาวะเสี่ยง</th>
           <th>จำนวนหญิงตั้งครรภ์ที่มีภาวะเสี่ยงได้รับการเยี่ยมบ้าน</th>
          
             <th>ต.ค.</th>
             <th>พ.ย.</th>
             <th>ธ.ค.</th>
             <th>ม.ค.</th>
             <th>ก.พ.</th>
             <th>มี.ค.</th>
             <th>ม.ย.</th>
             <th>พ.ค.</th>
             <th>มิ.ย.</th>
             <th>ก.ค.</th>
             <th>ส.ค.</th>
             <th>ก.ย.</th>
             

          </tr>
     </thead>
     <tbody>             
</tbody>
<?php

 $dbrpt->Query("
 SELECT 
		tb1.AMP_CODE as AMPCODE,
		tb1.AMP_NAME as AMPNAME,
		tb2.B as B,
		tb2.A AS A,
		tb2.P AS P,
		tb2.M10 as M10,
		tb2.M11 as M11,
		tb2.M12 as M12,
		tb2.M09 as M09,
		tb2.M08 as M08,
		tb2.M07 as M07,
		tb2.M06 as M06,
		tb2.M05 as M05,
		tb2.M04 as M04,
		tb2.M03 as M03,
		tb2.M02 as M02,
		tb2.M01 as M01
FROM(
	 SELECT 
           AMP_CODE,AMP_NAME  
			FROM z42_amp 
      GROUP BY AMP_CODE 
) as tb1
LEFT JOIN
(
	SELECT 
				amp.AMP_NAME AS AMPNAME,
				left(areacode,4) as AMPCODE,
				sum(target) as B,
				sum(result) as A,
				ROUND((sum(result)/sum(target))*100,2) as P,
				SUM(result10) as M10,SUM(result11)AS M11,SUM(result12)AS M12,
				SUM(result09) as M09,SUM(result08)AS M08,SUM(result07)AS M07,
				SUM(result06) as M06,SUM(result05)AS M05,SUM(result04)AS M04,
				SUM(result03) as M03,SUM(result02)AS M02,SUM(result01)AS M01
				FROM  z42_anc_hr_visit_s 
				LEFT OUTER JOIN z42_amp AS amp ON LEFT(z42_anc_hr_visit_s.areacode,4)=amp.AMP_CODE
				WHERE b_year BETWEEN'$o_year' AND '$b_year' AND date_com BETWEEN'$ystr' AND'$yend' 
				GROUP BY LEFT(areacode,4)
) as tb2 ON tb1.AMP_CODE=tb2.AMPCODE 
GROUP BY tb1.AMP_CODE  
UNION ALL
SELECT 
		'',
		'รวม',
		SUM(tb2.B) as B,
		SUM(tb2.A) AS A,
		ROUND(SUM(tb2.A)/SUM(tb2.B)*100,2) AS P,
		SUM(tb2.M10) as M10,
		sum(tb2.M11) as M11,
		sum(tb2.M12) as M12,
		SUM(tb2.M09) as M09,
		SUM(tb2.M08) as M08,
		SUM(tb2.M07) as M07,
		SUM(tb2.M06) as M06,
		SUM(tb2.M05) as M05,
		SUM(tb2.M04) as M04,
		sum(tb2.M03) as M03,
		SUM(tb2.M02) as M02,
		SUM(tb2.M01) as M01
FROM(
	 SELECT 
           AMP_CODE,AMP_NAME  
			FROM z42_amp 
      GROUP BY AMP_CODE 
) as tb1
LEFT JOIN
(
	SELECT 
				amp.AMP_NAME AS AMPNAME,
				left(areacode,4) as AMPCODE,
				sum(target) as B,
				sum(result) as A,
				ROUND((sum(result)/sum(target))*100,2) as P,
				SUM(result10) as M10,SUM(result11)AS M11,SUM(result12)AS M12,
				SUM(result09) as M09,SUM(result08)AS M08,SUM(result07)AS M07,
				SUM(result06) as M06,SUM(result05)AS M05,SUM(result04)AS M04,
				SUM(result03) as M03,SUM(result02)AS M02,SUM(result01)AS M01
				FROM  z42_anc_hr_visit_s 
				LEFT OUTER JOIN z42_amp AS amp ON LEFT(z42_anc_hr_visit_s.areacode,4)=amp.AMP_CODE
				WHERE b_year BETWEEN'$o_year' AND '$b_year' AND date_com BETWEEN'$ystr' AND'$yend' 
				GROUP BY LEFT(areacode,4)
) as tb2 ON tb1.AMP_CODE=tb2.AMPCODE ;
");
while($arr_rs=$dbrpt->Fetch_array())
{
	
?>    
	<tr>
		<td>
         <a href="javascript:popup('hirisk_anc_homecare_pcu.php?ampcode=<?php echo $arr_rs['AMPCODE'];?>&id=<?php echo $id;?>&b_year=<?php echo $b_year;?>&ystr=<?php echo $ystr;?>&yend=<?php echo $yend;?>','',960,500)"><?php echo $arr_rs['AMPNAME']; ?></a>
       
        
		</td>
 <td align="center">
        <?php echo $arr_rs['B']; ?>
		</td>
          <td align="center">
        <?php echo $arr_rs['A']; ?>
		</td>
        <td align="center">
        
		<?php echo $arr_rs['M10']; ?>
		</td>
            <td align="center">
        <?php echo $arr_rs['M11']; ?>
		</td>
            <td align="center">
        <?php echo $arr_rs['M12']; ?>
		</td>
            <td align="center">
        <?php echo $arr_rs['M01']; ?>
		</td>
          <td align="center">
        <?php echo $arr_rs['M02']; ?>
		</td>
         <td align="center">
        <?php echo $arr_rs['M03']; ?>
		</td>
         <td align="center">
        <?php echo $arr_rs['M04']; ?>
		</td>
         <td align="center">
        <?php echo $arr_rs['M05']; ?>
		</td>
        <td align="center">
        <?php echo $arr_rs['M06']; ?>
		</td>
         <td align="center">
        <?php echo $arr_rs['M07']; ?>
		</td>
         <td align="center">
        <?php echo $arr_rs['M08']; ?>
		</td>
         <td align="center">
        <?php echo $arr_rs['M09']; ?>
		</td>
	</tr>
 
<?php }?>   
</table>
</div>
</div>
</div>
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
