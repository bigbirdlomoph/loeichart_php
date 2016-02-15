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
  <div class="panel-heading">  จำนวนผู้ป่วยมะเร็งเต้านม แยกรายอำเภอ ปีงบประมาณ 2558 (ข้อมูล ณ เดือนมิถุนายน 2558)
<!--  <a href="javascript:popup('../chart/chart_goalpap_58_amp.php?ystr=<?php echo $ystr;?>&yend=<?php echo $yend?>','',960,500)"class="btn btn-default btn-sm " role="button">
   View Chart   
   </a>
  <a href="../exportxls/caservix_58_amp_export_excel.php?hcode=<?php echo $arr_rs['HCODE'];?>&id=<?php echo $id ;?>&b_year=<?php echo $b_year;?>&ystr=<?php echo $ystr;?>&yend=<?php echo $yend;?>" class="btn btn-default btn-sm" role="button">ส่งออก Excel </a>-->
</div>

     <div class="panel-body">
จำนวนผู้ป่วยมะเร็งเต้านม แยกรายอำเภอ ปีงบประมาณ 2558 (ข้อมูล ณ เดือนมิถุนายน 2558) <br>
<div class="table-responsive ">
<table class="table table-bordered table-hover">
<thead class="bg-success">
  <tr>
    <td><div align="center">อำเภอ</div></td>
    <td><div align="center">จำนวนผู้ป่วยมะเร็งเต้านม</div></td>
    <!--<td><div align="center">A</div></td>
    <td><div align="center">ร้อยละ</div></td>-->
  </tr>
     </thead>
     <tbody>             
</tbody>
<?php

 $dbrpt->Query("
      SELECT 
          tb1.AMP_CODE as AMPCODE,
          tb1.AMP_NAME as AMPNAME,
          tb2.B as B
      FROM(
        SELECT 
                AMP_CODE,AMP_NAME  
            FROM z42_amp 
            GROUP BY AMP_CODE 
      ) as tb1
      LEFT OUTER JOIN
      (
          SELECT 
              a.AMP_NAME AS AMPNAME, 
              a.AMP_CODE AS AMPCODE,
              COUNT(CID)AS B
              FROM z42_tc_cacervix c
              LEFT JOIN z42_co_office_loei o ON o.off_id = c.HOSPCODE
              LEFT JOIN z42_amp a ON a.AMP_CODE = o.distid
              GROUP BY o.distid
      ) as tb2 ON tb1.AMP_CODE=tb2.AMPCODE 
      GROUP BY tb1.AMP_CODE 
      UNION ALL
          SELECT 
              'TOTAL' AS AMPNAME, 
              'TOTAL' AS AMPCODE,
              COUNT(CID)AS B
              FROM z42_tc_cacervix c
              LEFT JOIN z42_co_office_loei o ON o.off_id = c.HOSPCODE
              LEFT JOIN z42_amp a ON a.AMP_CODE = o.distid  ;
 ");
while($arr_rs=$dbrpt->Fetch_array())
{
  $ampcode=$arr_rs['AMPCODE'];
  $per=$arr_rs['P'];
?>    
	<tr>
       
		<td align="center">
         <a href="javascript:popup('caservix_58_pcu.php?ampcode=<?=$arr_rs['AMPCODE'];?>&id=<?php echo $id;?>
         &b_year=<?php echo $b_year;?>&ystr=<?php echo $ystr;?>&yend=<?php echo $yend;?>','',1000,500)">
         <?php echo $arr_rs['AMPNAME']; ?></a>
    </td>
         <td align="center">
        <?php echo number_format($arr_rs['B']); ?>
    </td>
        <!-- <td align="center">
        <?php echo number_format($arr_rs['A']); ?>
    </td>
        <td align="center">
        <?php 
        if($per<'20.00'){
        ?>
          <button type="button" class="btn btn-xs btn-danger"><b><?php echo $arr_rs['P'];?></b></button></td>
        <?php
          }else if($per>='20.00'){
        ?>
          <button type="button" class="btn btn-xs btn-success"><b><?php echo $arr_rs['P'];?></b></button></td>
        <?php    
          }
        ?>
        <?php echo $arr_rs['P']; ?>
    </td>-->
        <!--<td align="center">
        <a href="../exportxls/ht_ckd_stage1_export_excel.php?hcode=<?php echo $arr_rs['HCODE'];?>&id=<?php echo $id ;?>&b_year=<?php echo $b_year;?>&ystr=<?php echo $ystr;?>&yend=<?php echo $yend;?>" title="ส่งออก Excell"><i class="fa fa-file-excel-o"></i></a>
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
