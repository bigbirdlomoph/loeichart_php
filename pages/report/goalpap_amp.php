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
  <div class="panel-heading">ร้อยละการคัดกรองมะเร็งปากมดลูก สะสม 5 ปี (QOF 2559)
  <a href="javascript:popup('../chart/chart_goalpap_amp.php?ystr=<?php echo $ystr;?>&yend=<?php echo $yend?>','',960,500)"class="btn btn-default btn-sm " role="button">
   View Chart   
   </a>
  <a href="../exportxls/goalpap_amp_export_excel.php?hcode=<?php echo $arr_rs['HCODE'];?>&id=<?php echo $id ;?>&b_year=<?php echo $b_year;?>&ystr=<?php echo $ystr;?>&yend=<?php echo $yend;?>" class="btn btn-default btn-sm" role="button">ส่งออก Excel </a>
</div>

     <div class="panel-body">
  A = ประชากรหญิง อายุ 30-60 ปี ที่ได้รับการคัดกรองมะเร็งปากมดลูก ตั้งแต่ 1 เมษายน 2554  <br>
  B = ประชากรหญิง อายุ 30-60 ปี ที่ได้รับการคัดกรองมะเร็งปากมดลูก <br>
  หมายเหตุ เกณฑ์ที่ผ่าน 80%
<div class="table-responsive ">
<table class="table table-bordered table-hover">
<thead class="bg-success">
  <tr>
    <td><div align="center">อำเภอ</div></td>
    <td><div align="center">B</div></td>
    <td><div align="center">A</div></td>
    <td><div align="center">ร้อยละ</div></td>
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
    tb2.P AS P
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
        sum(B) as B,
        sum(A) as A,
        ROUND((sum(A)/sum(B))*100,2) as P
        FROM s_goalpap
        LEFT OUTER JOIN z42_amp AS amp ON LEFT(s_goalpap.areacode,4)=amp.AMP_CODE
        #WHERE b_year BETWEEN'2014' AND '2015' AND date_com BETWEEN @date_start AND @date_end 
        GROUP BY LEFT(areacode,4)
) as tb2 ON tb1.AMP_CODE=tb2.AMPCODE 
GROUP BY tb1.AMP_CODE 
UNION ALL
    SELECT 
        'TOTAL' AS AMPNAME,'รวม' as AMPCODE,
        sum(B) as B,
        sum(A) as A,
        ROUND((sum(A)/sum(B))*100,2) as P
        FROM s_goalpap
        LEFT OUTER JOIN z42_amp AS amp ON LEFT(s_goalpap.areacode,4)=amp.AMP_CODE
        #WHERE b_year BETWEEN'2014' AND '2015' AND date_com BETWEEN @date_start AND @date_end  ;
 
  
 ");
while($arr_rs=$dbrpt->Fetch_array())
{
	$ampcode=$arr_rs['AMPCODE'];
?>    
	<tr>
       
		<td align="center">
         <a href="javascript:popup('goalpap_pcu.php?ampcode=<?=$arr_rs['AMPCODE'];?>&id=<?php echo $id;?>
         &b_year=<?php echo $b_year;?>&ystr=<?php echo $ystr;?>&yend=<?php echo $yend;?>','',960,500)">
         <?php echo $arr_rs['AMPNAME']; ?></a>
      
		</td>
         <td align="center">
        <?php echo number_format($arr_rs['B']); ?>
    </td>
         <td align="center">
        <?php echo number_format($arr_rs['A']); ?>
    </td>

        <!-- <td align="center">
        <?php echo $arr_rs['DM']; ?>
		</td>-->
        <td align="center">
        <?php 
        if($per<'80.00'){
        ?>
          <button type="button" class="btn btn-xs btn-danger"><b><?php echo $arr_rs['P'];?></b></button></td>
        <?php
          }else if($per>='80.00'){
        ?>
          <button type="button" class="btn btn-xs btn-success"><b><?php echo $arr_rs['P'];?></b></button></td>
        <?php    
          }
        ?>
        <!--<?php echo $arr_rs['P']; ?>-->
    </td>
	</tr>
    
<?php }?>   
</table>

</div>
</div>
</div>
 <!-- Core Scripts - Include with every page -->
   
</body>
</html>
