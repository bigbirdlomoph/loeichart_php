<?php
session_start() ;
if (!isset($_SESSION['login_true'])) {
     header("Location: login.php");//สั่งให้ redirect ไปหน้า login เมื่อไม่มีการ login แต่เรียกใช้หน้านี้
     exit;
}

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
</head>

<body>
<?php
function __autoload($class_name){
	include'../class/class.'.$class_name.'.php';
}
set_time_limit(0);
include"../config/config.php";
?>
<?php
$ampcode=$_GET['ampcode'];
$id=$_GET['id'];
$o_year=substr($_GET['ystr'],0,4);;
$b_year=$_GET['b_year'];
$ystr=$_GET['ystr'];;
$yend=$_GET['yend'];
$hcode=$_GET['hcode'];
$villid=$_GET['villid'];
//
$dbrpt=new Database(DB_HOST_TK,DB_USER_TK,DB_PASS_TK,DB_NAME_TK);//new object 

?>
<div class="panel panel-info">
<div class="panel-heading">ร้อยละการคัดกรองมะเร็งปากมดลูก สะสม 5 ปี (QOF 2559)
<?php
//select name report
  $dbrpt->Query("SELECT * FROM z42_sys_report WHERE id='$id' ORDER BY source_table");
    while($arrrpt=$dbrpt->Fetch_array()){
		?>
   
		<h4><?php echo $arrrpt['report_name'];?> วันที่ : <?php echo substr($ystr,8,2);?> /<?php echo substr($ystr,5,2);?> /<?php echo $o_year+543;?> ถึง <?php echo substr($yend,8,2);?> /<?php echo substr($yend,5,2);?> /<?php echo $b_year+543;?></h4>
		<?php
        }
?>
<a href="../exportxls/goalpap_vill_export_excel.php?villid=<?=$villid;?>&hcode=<?=$hcode;?>" class="btn btn-default btn-sm" role="button">ส่งออก Excel </a>
</div>
  <div class="panel-body">
  A = ประชากรหญิง อายุ 30-60 ปี ที่ได้รับการคัดกรองมะเร็งปากมดลูก ตั้งแต่ 1 เมษายน 2554  <br>
  B = ประชากรหญิง อายุ 30-60 ปี ที่ได้รับการคัดกรองมะเร็งปากมดลูก <br>
  หมายเหตุ เกณฑ์ที่ผ่าน 80%
<div class="table-responsive ">
<table class="table table-hover">
<thead class="bg-success">

 <tr>
    <th><div align="center">หมู่บ้าน</div></th>
    <th><div align="center">หมู่ที่</div></th>
    <th><div align="center">B</div></th>
    <th><div align="center">A</div></th>
    <th><div align="center">ร้อยละ</div></th>
  </tr>
     </thead>
     <tbody>             
</tbody>
<?php

 $dbrpt->Query("
        SELECT 
          a.villid AS VILLCODE,s.hospcode AS HCODE,
          a.villname AS VNAME,
          a.villno AS Moo,
          sum(B) as B,
          sum(A) as A,
          ROUND((sum(A)/sum(B))*100,2) as P
          FROM s_goalpap s
          LEFT OUTER JOIN z42_co_village a ON s.areacode = a.villid
          WHERE s.hospcode='$hcode' AND LEFT(s.areacode,6)='$villid'
          GROUP BY a.villid
        UNION
        SELECT 
          'รวม' AS VILLCODE,s.hospcode AS HCODE,
          'รวม' AS VNAME,
          '' AS Moo,
          sum(B) as B,
          sum(A) as A,
          ROUND((sum(A)/sum(B))*100,2) as P
          FROM s_goalpap s
          LEFT OUTER JOIN z42_co_village a ON s.areacode = a.villid
          WHERE s.hospcode='$hcode' AND LEFT(s.areacode,6)='$villid'
				");
while($arr_rs=$dbrpt->Fetch_array()){
	
?>    
	<tr>
		<td>
        <a href="javascript:popup('goalpap_pcu_cid.php?villid=<?php echo $arr_rs['VILLCODE'];?>&b_year=<?php echo $b_year;?>&ystr=<?php echo $ystr;?>&yend=<?php echo $yend;?>','',960,500)"><?php echo $arr_rs['VNAME']; ?></a></td>
        <td align="center"><?php echo $arr_rs['Moo'];?></td>
        <td align="center">
        <?php echo number_format($arr_rs['B']); ?>
		</td>
        <td align="center">
        <?php echo number_format($arr_rs['A']); ?>
		</td>
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
