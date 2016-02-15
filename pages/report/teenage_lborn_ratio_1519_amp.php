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

<title>LOEI CHART | REPORT DATA</title>
<script type="text/javascript" src="https://www.google.com/jsapi"></script> 
</head>

<body>
<?php

$id=$_POST['id'];;//id report
$o_year=substr($_POST['str_date'],0,4);//year_old 10,11,12
$b_year=substr($_POST['end_date'],0,4);//year_next 
$ystr=$_POST['str_date'];
$yend=$_POST['end_date'];
$dbrpt=new Database(DB_HOST_TK,DB_USER_TK,DB_PASS_TK,DB_NAME_TK);//new object 
?>


 <div class="panel panel-info">
  <div class="panel-heading">อัตราการคลอดโดยมารดาอายุ 15-19 ปี
  <a href="javascript:popup('../chart/chart_teenage_lborn_1519_amp.php?ystr=<?php echo $ystr;?>&yend=<?php echo $yend?>','',960,500)"class="btn btn-default btn-sm " role="button">
   View Chart
   </a>

</div>

     <div class="panel-body">
  A = จำนวนการคลอดมีชีพโดยมารดาอายุ 15 – 19 ปี (นับเฉพาะการคลอดมีชีพ) <br>
  B = จำนวนหญิงอายุ 15 – 19 ปี ทั้งหมด (จำนวนประชากรกลางปีจากฐานข้อมูลทะเบียนราษฎร์)
<div class="table-responsive ">
<table class="table table-bordered table-hover">
<thead class="bg-success">
  <tr>
    <td colspan="4">&nbsp;</td>
    <td colspan="3"><div align="center"><strong>ไตรมาส 1</strong></div></td>
    <td colspan="3"><div align="center"><strong>ไตรมาส 2</strong></div></td>
    <td colspan="3"><div align="center"><strong>ไตรมาส 3</strong></div></td>
    <td colspan="3"><div align="center"><strong>ไตรมาส 4</strong></div></td>
    <!--<td>&nbsp;</td>-->
  </tr>
  <tr>
    <td><div align="center">อำเภอ</div></td>
    <td><div align="center">B</div></td>
    <td><div align="center">A</div></td>
    <td><div align="center">อัตรา</div></td>
    <td><div align="center">ต.ค.</div></td>
    <td><div align="center">พ.ย.</div></td>
    <td><div align="center">ธ.ค.</div></td>
    <td><div align="center">ม.ค.</div></td>
    <td><div align="center">ก.พ.</div></td>
    <td><div align="center">มี.ค.</div></td>
    <td><div align="center">เม.ย.</div></td>
    <td><div align="center">พ.ค.</div></td>
    <td><div align="center">มิ.ย.</div></td>
    <td><div align="center">ก.ค.</div></td>
    <td><div align="center">ส.ค.</div></td>
    <td><div align="center">ก.ย.</div></td>
    <!--<td><div align="center">Excel</div></td>-->
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
		tb2.RATIO AS RATIO,
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
				ROUND((sum(result)/sum(target))*1000,2) as RATIO,
				SUM(result10) as M10,SUM(result11)AS M11,SUM(result12)AS M12,
				SUM(result09) as M09,SUM(result08)AS M08,SUM(result07)AS M07,
				SUM(result06) as M06,SUM(result05)AS M05,SUM(result04)AS M04,
				SUM(result03) as M03,SUM(result02)AS M02,SUM(result01)AS M01
				FROM s_labor_midyear_1519 
				LEFT OUTER JOIN z42_amp AS amp ON LEFT(s_labor_midyear_1519.areacode,4)=amp.AMP_CODE
				WHERE b_year BETWEEN '$o_year' AND '$b_year' AND date_com BETWEEN '$ystr' AND'$yend' 
				GROUP BY LEFT(areacode,4)
) as tb2 ON tb1.AMP_CODE=tb2.AMPCODE 
GROUP BY tb1.AMP_CODE 
UNION ALL
    SELECT 
                'TOTAL','รวมทุกอำเภอ',
                sum(target) as B,
                sum(result) as A,
                ROUND((sum(result)/sum(target))*1000,2) as RATIO,
                SUM(result10) as M10,SUM(result11)AS M11,SUM(result12)AS M12,
                SUM(result09) as M09,SUM(result08)AS M08,SUM(result07)AS M07,
                SUM(result06) as M06,SUM(result05)AS M05,SUM(result04)AS M04,
                SUM(result03) as M03,SUM(result02)AS M02,SUM(result01)AS M01
                FROM s_labor_midyear_1519 
                LEFT OUTER JOIN z42_amp AS amp ON LEFT(s_labor_midyear_1519.areacode,4)=amp.AMP_CODE
                WHERE b_year BETWEEN '$o_year' AND '$b_year' AND date_com BETWEEN'$ystr' AND'$yend'   ;
  
 ");
while($arr_rs=$dbrpt->Fetch_array())
{
	$ampcode=$arr_rs['AMPCODE'];
?>    
	<tr>
       
		<td align="center">
         <a href="javascript:popup('teenage_lborn_ratio_1519_pcu.php?ampcode=<?php echo $arr_rs['AMPCODE'];?>&id=<?php echo $id;?>
         &b_year=<?php echo $b_year;?>&ystr=<?php echo $ystr;?>&yend=<?php echo $yend;?>','',960,500)">
         <?php echo $arr_rs['AMPNAME']; ?></a>
      
		</td>
          <td align="center">
        <?php echo $arr_rs['B']; ?>
		</td>
          <td align="center">
        <?php echo $arr_rs['A']; ?>
		</td>

         <td align="center">
        <?php echo $arr_rs['RATIO']; ?>
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
        <!--<td align="center"><a href="../exportxls/teenage_anc_1014_export_excell.php?hcode=<?php echo $arr_rs['HCODE'];?>&id=<?php echo $id ;?>&b_year=<?php echo $b_year;?>&ystr=<?php echo $ystr;?>&yend=<?php echo $yend;?>" title="ส่งออก Excell"><i class="fa fa-file-excel-o"></i></a>
         </td>-->
	</tr>
     <div class="list-group">
     </div>
<?php }?>   
</table>

</div>
</div>
</div>
 <!-- Core Scripts - Include with every page -->
   
</body>
</html>
