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
$table=$_POST['table'];

 $dbrpt=new Database(DB_HOST_TK,DB_USER_TK,DB_PASS_TK,DB_NAME_TK);//new object 
?>
<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
  <div class="container">
    <?php
 //select name report
  $dbrpt->Query("SELECT * FROM z42_sys_report WHERE id='$id' ORDER BY cat_id");
    while($arrrpt=$dbrpt->Fetch_array()){
		$sql_area=$arrrpt['query_areacode'];
		?>
		<h4><?php echo $arrrpt['report_name'];?> </h4>
		<?php
        }
 
?>
  </div>
</nav>


<!--<div class="panel panel-success">
 <div class="panel-heading"><i class="fa fa-chain"></i> กราฟ</div>
  <div class="panel-body">

  <?php //include("../chart/chart_anc12w_amp.php")?>
  
  </div>
</div>
<!---->
 <div class="panel panel-info">
  <div class="panel-heading"><?php echo $arrrpt['report_name'];?></div>
     <div class="panel-body">
            
<div class="table-responsive ">
<table class="table table-bordered table-hover">
<thead>
          <tr>
             
              <th>อำเภอ</th>
              <th>จำนวนเด็กทั้งหมด</th>
              <th>จำนวนเด็กที่มาชั่งน้ำหนัก</th>
              <th>ร้อยละความครอบคุม</th>
            <!-- <th>จำนวนเด็กอ้วน</th>-->
            <!-- <th>ร้อยละเด็กอ้วน</th>-->
             <th>ผอม</th>
             <th>ค่อนข้างผอม</th>
             <th>ปกติ</th>
             <th>ท้วม</th>
             <th>อ้วน</th>
             <th>อ้วนมาก</th>
                          
          </tr>
     </thead>
     <tbody>             
</tbody>
<?php

 $dbrpt->Query("
######################SHOW areacode
SELECT 
		tb1.AMP_CODE as AMPCODE,
		tb1.AMP_NAME as AMPNAME,
		if(tb3.B IS NULL,'0',tb3.B) as B,
    if(tb5.A IS NULL,'0',tb5.A)  as A,
		ROUND((tb5.A/tb3.B)*100,2) as P,
    if(tb4.AF IS NULL,'0',tb4.AF) AS AF,
		ROUND((tb4.AF/tb5.A)*100,2) as PF,
    if(tb6.SM IS NULL ,'0',tb6.SM) as SM,
    if(tb7.SMM IS NULL,'0',tb7.SMM) as SMM,
    if(tb8.SMN IS NULL,'0',tb8.SMN) as SMN,
    if(tb9.SMA IS NULL,'0',tb9.SMA) as SMA,
    if(tb10.SMF IS NULL,'0',tb10.SMF) as SMF,
		IF(tb11.SMFF IS NULL,'0',tb11.SMFF) as SMFF
		#tb2.M10 as M10,
		#tb2.M11 as M11,
		#tb2.M12 as M12,
		#tb2.M09 as M09,
		#tb2.M08 as M08,
		#tb2.M07 as M07,
		#tb2.M06 as M06,
		#tb2.M05 as M05,
		#tb2.M04 as M04,
		#tb2.M03 as M03,
		#tb2.M02 as M02,
		#tb2.M01 as M01
FROM(
	 SELECT 
           AMP_CODE,AMP_NAME  
			FROM z42_amp 
      GROUP BY AMP_CODE 
) as tb1
LEFT JOIN
(
	SELECT 
				amp.AMP_NAME  AS AMPNAME,
				left(areacode,4)  as AMPCODE,
				SUM(result10) as M10,SUM(result11)AS M11,SUM(result12)AS M12,
				SUM(result09) as M09,SUM(result08)AS M08,SUM(result07)AS M07,
				SUM(result06) as M06,SUM(result05)AS M05,SUM(result04)AS M04,
				SUM(result03) as M03,SUM(result02)AS M02,SUM(result01)AS M01
				FROM z42_nutri_s 
				LEFT OUTER JOIN z42_amp AS amp ON LEFT(z42_nutri_s.areacode,4)=amp.AMP_CODE
				WHERE  date_com BETWEEN'".$ystr."' AND'".$yend."' 
				GROUP BY LEFT(areacode,4)
) as tb2 ON tb1.AMP_CODE=tb2.AMPCODE
#####เป้า####
LEFT JOIN
(
  SELECT 
						amp.AMP_NAME  AS AMPNAME,
				 left(areacode,4)  as AMPCODE,
				sum(target) as B
				FROM z42_nutri_s 
				LEFT OUTER JOIN z42_amp AS amp ON LEFT(z42_nutri_s.areacode,4)=amp.AMP_CODE
				GROUP BY LEFT(areacode,4)
) as tb3 ON tb1.AMP_CODE=tb3.AMPCODE
##reult เด็กอ้วo
LEFT JOIN
(
SELECT 
				 amp.AMP_NAME  AS AMPNAME,
				left(areacode,4)  as AMPCODE,
				sum(result) as AF
				FROM z42_nutri_s 
				LEFT OUTER JOIN z42_amp AS amp ON LEFT(z42_nutri_s.areacode,4)=amp.AMP_CODE
				WHERE  date_com BETWEEN'".$ystr."' AND'".$yend."' and level_hw in('4','5','6')
GROUP BY LEFT(areacode,4)
)as tb4 ON tb1.AMP_CODE=tb4.AMPCODE
##ชังน้ำนก
LEFT JOIN
(
SELECT 
				 amp.AMP_NAME  AS AMPNAME,
				left(areacode,4)  as AMPCODE,

				sum(target) as A
				FROM z42_nutri_s 
				LEFT OUTER JOIN z42_amp AS amp ON LEFT(z42_nutri_s.areacode,4)=amp.AMP_CODE
				WHERE  date_com BETWEEN'".$ystr."' AND'".$yend."' and level_hw <>''
GROUP BY LEFT(areacode,4) 
)as tb5 ON tb1.AMP_CODE=tb5.AMPCODE
####เด็กผอม
LEFT JOIN
(
SELECT 
			  amp.AMP_NAME as AMPNAME,
				left(areacode,4)as AMPCODE,
				sum(target) as SM
				FROM z42_nutri_s 
				LEFT OUTER JOIN z42_amp AS amp ON LEFT(z42_nutri_s.areacode,4)=amp.AMP_CODE
				WHERE  date_com BETWEEN'".$ystr."' AND'".$yend."' and level_hw in ('1','2','3')
GROUP BY LEFT(areacode,4)
)as tb6 ON tb1.AMP_CODE=tb6.AMPCODE
####ค่อนข้างเด็กผอม
LEFT JOIN
(
SELECT 
			  amp.AMP_NAME as AMPNAME,
				left(areacode,4)as AMPCODE,
				sum(target) as SMM
				FROM z42_nutri_s 
				LEFT OUTER JOIN z42_amp AS amp ON LEFT(z42_nutri_s.areacode,4)=amp.AMP_CODE
				WHERE  date_com BETWEEN'".$ystr."' AND'".$yend."' and level_hw in ('1','2')
GROUP BY LEFT(areacode,4)
)as tb7 ON tb1.AMP_CODE=tb7.AMPCODE
####ปกติ
LEFT JOIN
(
SELECT 
			  amp.AMP_NAME as AMPNAME,
				left(areacode,4)as AMPCODE,
				sum(target) as SMN
				FROM z42_nutri_s 
				LEFT OUTER JOIN z42_amp AS amp ON LEFT(z42_nutri_s.areacode,4)=amp.AMP_CODE
				WHERE  date_com BETWEEN'".$ystr."' AND'".$yend."' and level_hw in ('3')
GROUP BY LEFT(areacode,4)
)as tb8 ON tb1.AMP_CODE=tb8.AMPCODE
####ท้วม
LEFT JOIN
(
SELECT 
			  amp.AMP_NAME as AMPNAME,
				left(areacode,4)as AMPCODE,
				sum(target) as SMA
				FROM z42_nutri_s 
				LEFT OUTER JOIN z42_amp AS amp ON LEFT(z42_nutri_s.areacode,4)=amp.AMP_CODE
				WHERE  date_com BETWEEN'".$ystr."' AND'".$yend."' and level_hw in ('4')
GROUP BY LEFT(areacode,4)
)as tb9 ON tb1.AMP_CODE=tb9.AMPCODE
###อ้วน
LEFT JOIN
(
SELECT 
			  amp.AMP_NAME as AMPNAME,
				left(areacode,4)as AMPCODE,
				sum(target) as SMF
				FROM z42_nutri_s 
				LEFT OUTER JOIN z42_amp AS amp ON LEFT(z42_nutri_s.areacode,4)=amp.AMP_CODE
				WHERE  date_com BETWEEN'".$ystr."' AND'".$yend."' and level_hw in ('5')
GROUP BY LEFT(areacode,4)
)as tb10 ON tb1.AMP_CODE=tb10.AMPCODE
###อ้วนมาก
LEFT JOIN
(
SELECT 
			  amp.AMP_NAME as AMPNAME,
				left(areacode,4)as AMPCODE,
				sum(target) as SMFF
				FROM z42_nutri_s 
				LEFT OUTER JOIN z42_amp AS amp ON LEFT(z42_nutri_s.areacode,4)=amp.AMP_CODE
				WHERE  date_com BETWEEN'".$ystr."' AND'".$yend."' and level_hw in ('6')
GROUP BY LEFT(areacode,4)
)as tb11 ON tb1.AMP_CODE=tb11.AMPCODE
GROUP BY tb1.AMP_CODE 
UNION ALL
######################SHOW areacode
SELECT 
		'',
		'รวม',
		SUM(tb3.B) as B,
    SUM(tb5.A)  as A,
		ROUND((SUM(tb5.A)/SUM(tb3.B))*100,2) as P,
    SUM(tb4.AF) AS AF,
		ROUND((SUM(tb4.AF)/SUM(tb5.A))*100,2) as PF,
    SUM(tb6.SM) as SM,
    SUM(tb7.SMM) as SMM,
    SUM(tb8.SMN) as SMN,
    SUM(tb9.SMA) as SMA,
    SUM(tb10.SMF) as SMF,
		SUM(tb11.SMFF) as SMFF
		#tb2.M10 as M10,
		#tb2.M11 as M11,
		#tb2.M12 as M12,
		#tb2.M09 as M09,
		#tb2.M08 as M08,
		#tb2.M07 as M07,
		#tb2.M06 as M06,
		#tb2.M05 as M05,
		#tb2.M04 as M04,
		#tb2.M03 as M03,
		#tb2.M02 as M02,
		#tb2.M01 as M01
FROM(
	 SELECT 
           AMP_CODE,AMP_NAME  
			FROM z42_amp 
      GROUP BY AMP_CODE 
) as tb1
LEFT JOIN
(
	SELECT 
				amp.AMP_NAME  AS AMPNAME,
				left(areacode,4)  as AMPCODE,
				SUM(result10) as M10,SUM(result11)AS M11,SUM(result12)AS M12,
				SUM(result09) as M09,SUM(result08)AS M08,SUM(result07)AS M07,
				SUM(result06) as M06,SUM(result05)AS M05,SUM(result04)AS M04,
				SUM(result03) as M03,SUM(result02)AS M02,SUM(result01)AS M01
				FROM z42_nutri_s 
				LEFT OUTER JOIN z42_amp AS amp ON LEFT(z42_nutri_s.areacode,4)=amp.AMP_CODE
				WHERE  date_com BETWEEN'".$ystr."' AND'".$yend."' 
				GROUP BY LEFT(areacode,4)
) as tb2 ON tb1.AMP_CODE=tb2.AMPCODE
#####เป้า####
LEFT JOIN
(
  SELECT 
					amp.AMP_NAME  AS AMPNAME,
				 left(areacode,4)  as AMPCODE,
				sum(target) as B
				FROM z42_nutri_s 
				LEFT OUTER JOIN z42_amp AS amp ON LEFT(z42_nutri_s.areacode,4)=amp.AMP_CODE
				GROUP BY LEFT(areacode,4)
) as tb3 ON tb1.AMP_CODE=tb3.AMPCODE
##reult เด็กอ้วo
LEFT JOIN
(
SELECT 
				 amp.AMP_NAME  AS AMPNAME,
				left(areacode,4)  as AMPCODE,
				sum(result) as AF
				FROM z42_nutri_s 
				LEFT OUTER JOIN z42_amp AS amp ON LEFT(z42_nutri_s.areacode,4)=amp.AMP_CODE
				WHERE  date_com BETWEEN'".$ystr."' AND'".$yend."' and level_hw in('4','5','6')
GROUP BY LEFT(areacode,4)
)as tb4 ON tb1.AMP_CODE=tb4.AMPCODE
##ชังน้ำนก
LEFT JOIN
(
SELECT 
				 amp.AMP_NAME  AS AMPNAME,
				left(areacode,4)  as AMPCODE,

				sum(target) as A
				FROM z42_nutri_s 
				LEFT OUTER JOIN z42_amp AS amp ON LEFT(z42_nutri_s.areacode,4)=amp.AMP_CODE
				WHERE  date_com BETWEEN'".$ystr."' AND'".$yend."' and level_hw <>''
GROUP BY LEFT(areacode,4) 
)as tb5 ON tb1.AMP_CODE=tb5.AMPCODE
####เด็กผอม
LEFT JOIN
(
SELECT 
			  amp.AMP_NAME as AMPNAME,
				left(areacode,4)as AMPCODE,
				sum(target) as SM
				FROM z42_nutri_s 
				LEFT OUTER JOIN z42_amp AS amp ON LEFT(z42_nutri_s.areacode,4)=amp.AMP_CODE
				WHERE  date_com BETWEEN'".$ystr."' AND'".$yend."' and level_hw in ('1','2','3')
GROUP BY LEFT(areacode,4)
)as tb6 ON tb1.AMP_CODE=tb6.AMPCODE
####ค่อนข้างเด็กผอม
LEFT JOIN
(
SELECT 
			  amp.AMP_NAME as AMPNAME,
				left(areacode,4)as AMPCODE,
				sum(target) as SMM
				FROM z42_nutri_s 
				LEFT OUTER JOIN z42_amp AS amp ON LEFT(z42_nutri_s.areacode,4)=amp.AMP_CODE
				WHERE  date_com BETWEEN'".$ystr."' AND'".$yend."' and level_hw in ('1','2')
GROUP BY LEFT(areacode,4)
)as tb7 ON tb1.AMP_CODE=tb7.AMPCODE
####ปกติ
LEFT JOIN
(
SELECT 
			  amp.AMP_NAME as AMPNAME,
				left(areacode,4)as AMPCODE,
				sum(target) as SMN
				FROM z42_nutri_s 
				LEFT OUTER JOIN z42_amp AS amp ON LEFT(z42_nutri_s.areacode,4)=amp.AMP_CODE
				WHERE  date_com BETWEEN'".$ystr."' AND'".$yend."' and level_hw in ('3')
GROUP BY LEFT(areacode,4)
)as tb8 ON tb1.AMP_CODE=tb8.AMPCODE
####ท้วม
LEFT JOIN
(
SELECT 
			  amp.AMP_NAME as AMPNAME,
				left(areacode,4)as AMPCODE,
				sum(target) as SMA
				FROM z42_nutri_s 
				LEFT OUTER JOIN z42_amp AS amp ON LEFT(z42_nutri_s.areacode,4)=amp.AMP_CODE
				WHERE  date_com BETWEEN'".$ystr."' AND'".$yend."' and level_hw in ('4')
GROUP BY LEFT(areacode,4)
)as tb9 ON tb1.AMP_CODE=tb9.AMPCODE
###อ้วน
LEFT JOIN
(
SELECT 
			  amp.AMP_NAME as AMPNAME,
				left(areacode,4)as AMPCODE,
				sum(target) as SMF
				FROM z42_nutri_s 
				LEFT OUTER JOIN z42_amp AS amp ON LEFT(z42_nutri_s.areacode,4)=amp.AMP_CODE
				WHERE  date_com BETWEEN'".$ystr."' AND'".$yend."' and level_hw in ('5')
GROUP BY LEFT(areacode,4)
)as tb10 ON tb1.AMP_CODE=tb10.AMPCODE
###อ้วนมาก
LEFT JOIN
(
SELECT 
			  amp.AMP_NAME as AMPNAME,
				left(areacode,4)as AMPCODE,
				sum(target) as SMFF
				FROM z42_nutri_s 
				LEFT OUTER JOIN z42_amp AS amp ON LEFT(z42_nutri_s.areacode,4)=amp.AMP_CODE
				WHERE  date_com BETWEEN'".$ystr."' AND'".$yend."' and level_hw in ('6')
GROUP BY LEFT(areacode,4)
)as tb11 ON tb1.AMP_CODE=tb11.AMPCODE;


 ");
while($arr_rs=$dbrpt->Fetch_array())
{
	$ampcode=$arr_rs['AMPCODE'];
?>    
	<tr>
       
		<td>
        <a href="javascript:popup('fat_child_pcu.php?ampcode=<?php echo $arr_rs['AMPCODE'];?>&id=<?php echo $id;?>&age=<?php echo $age?>&table=<?php echo $table_t?>','',960,500)"><?php echo $arr_rs['AMPNAME']; ?></a>     
		</td>
        <td align="center">
		<?php echo number_format($arr_rs['B']); ?> 
        </td>
         <td align="center">
        <?php echo number_format($arr_rs['A']); ?>
		</td>
          <td align="center">
        <?php echo $arr_rs['P']; ?>
		</td>
        
            <td align="center">
        <?php echo number_format($arr_rs['SM']); ?>
		</td>
            <td align="center">
        <?php echo number_format($arr_rs['SMM']); ?>
		</td>
          <td align="center">
        <?php echo number_format($arr_rs['SMN']); ?>
		</td>
         <td align="center">
        <?php echo number_format($arr_rs['SMA']); ?>
		</td>
         <td align="center">
        <?php echo number_format($arr_rs['SMF']); ?>
		</td>
         <td align="center">
        <?php echo number_format($arr_rs['SMFF']); ?>
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
