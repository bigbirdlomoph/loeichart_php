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
  <div class="panel-heading">ร้อยละผู้ป่วย DM ที่มีภาวะไตเสื่อม (CKD) Stage5 อายุน้อยกว่า 65 ปี
  <a href="javascript:popup('../chart/chart_ckd_age_l65_stage5_amp.php?ystr=<?php echo $ystr;?>&yend=<?php echo $yend?>','',960,500)"class="btn btn-default btn-sm " role="button">
   View Chart
   </a>

</div>

     <div class="panel-body">
  A = จำนวนผู้ป่วย DM ที่ได้รับการคัดกรองภาวะแทรกซ้อนทางไตพบ CKD stage5 อายุน้อยกว่า 65 ปี <br>
  B = จำนวนผู้ป่วย DM ที่มีภาวะไตเสื่อม(CKD) Stage 3-5 ทั้งหมด
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
        tb2.A AS A,
        tb2.B AS B,
        tb2.P AS P,
        tb2.S3a as S3a,
        tb2.S3a_2 as S3a_2,
        tb2.S3b as S3b,
        tb2.S3b_2 as S3b_2,
        tb2.S4 as S4,
        tb2.S4_2 as S4_2,
        tb2.S5 as S5,
        tb2.S5_2 as S5_2
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
                SUM(stage5) as A,
                SUM(target) as B,
                ROUND((sum(stage5)/sum(target))*100,2) as P,
                SUM(stage3a) as S3a,
                SUM(stage3a_2)AS S3a_2,
                SUM(stage3b)AS S3b,
                SUM(stage3b_2) as S3b_2,
                SUM(stage4)AS S4,
                SUM(stage4_2)AS S4_2,
                SUM(stage5)AS S5,
                SUM(stage5_2)AS S5_2
                FROM s_ckd_dm_age
                LEFT OUTER JOIN z42_amp AS amp ON LEFT(s_ckd_dm_age.areacode,4)=amp.AMP_CODE
        WHERE b_year BETWEEN'$o_year' AND '$b_year' AND date_com BETWEEN'$ystr' AND'$yend' 
                GROUP BY LEFT(areacode,4)
) as tb2 ON tb1.AMP_CODE=tb2.AMPCODE 
GROUP BY tb1.AMP_CODE 
UNION ALL
    SELECT 
                'TOTAL' AS AMPNAME,'รวม' as AMPCODE,
                SUM(stage5) as A,
                SUM(target) as B,
                ROUND((sum(stage5)/sum(target))*100,2) as P,
                SUM(stage3a) as S3a,
                SUM(stage3a_2)AS S3a_2,
                SUM(stage3b)AS S3b,
                SUM(stage3b_2) as S3b_2,
                SUM(stage4)AS S4,
                SUM(stage4_2)AS S4_2,
                SUM(stage5)AS S5,
                SUM(stage5_2)AS S5_2
                FROM s_ckd_dm_age
                LEFT OUTER JOIN z42_amp AS amp ON LEFT(s_ckd_dm_age.areacode,4)=amp.AMP_CODE
                WHERE b_year BETWEEN'$o_year' AND '$b_year' AND date_com BETWEEN'$ystr' AND'$yend' ;
 ");
while($arr_rs=$dbrpt->Fetch_array())
{
	$ampcode=$arr_rs['AMPCODE'];
?>    
	<tr>
       
		<td align="center">
         <a href="javascript:popup('ckd_ncd_stage5_age_l65_pcu.php?ampcode=<?php echo $arr_rs['AMPCODE'];?>&id=<?php echo $id;?>
         &b_year=<?php echo $b_year;?>&ystr=<?php echo $ystr;?>&yend=<?php echo $yend;?>','',960,500)">
         <?php echo $arr_rs['AMPNAME']; ?></a>
      
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
        <!--<td align="center"><a href="../exportxls/teenage_anc_1014_export_excell.php?hcode=<?php echo $arr_rs['HCODE'];?>&id=<?php echo $id ;?>&b_year=<?php echo $b_year;?>&ystr=<?php echo $ystr;?>&yend=<?php echo $yend;?>" title="ส่งออก Excell"><i class="fa fa-file-excel-o"></i></a>
        </td>-->
	</tr>
    
<?php }?>   
</table>

</div>
</div>
</div>
 <!-- Core Scripts - Include with every page -->
   
</body>
</html>
