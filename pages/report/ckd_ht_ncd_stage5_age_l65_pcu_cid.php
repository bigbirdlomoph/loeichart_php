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
<title>LOEI CHART | REPORT DATA</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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

<body>
<?php
function __autoload($class_name){
	include'../class/class.'.$class_name.'.php';
}
set_time_limit(0);
include"../config/config.php";
$hcode=$_GET['hcode'];
$b_year=$_GET['b_year'];
$ystr=$_GET['ystr'];
$yend=$_GET['yend'];
$dbrpt=new Database(DB_HOST_TK,DB_USER_TK,DB_PASS_TK,DB_NAME_TK);//new object 
?>
<div class="panel panel-info">
<div class="panel-heading"></div>
<!--<a href="../exportxls/ht_ckd_stage3a_age_l65_cid_export_excel.php?hcode=<?php echo $arr_rs['HCODE'];?>&hcode=<?php echo $hcode ;?>&id=<?php echo $id ;?>&b_year=<?php echo $b_year;?>&ystr=<?php echo $ystr;?>&yend=<?php echo $yend;?>" class="btn btn-default btn-sm" role="button">ส่งออก Excel </a>-->
<!--<a href="../exportxls/ckd_stage3a_l65_export_excell.php?hcode=<?php echo $arr_rs['HCODE'];?>&id=<?php echo $id ;?>&b_year=<?php echo $b_year;?>&ystr=<?php echo $ystr;?>&yend=<?php echo $yend;?>" title="ส่งออก Excell"><i class="fa fa-file-excel-o"></i></a>-->
<div class="panel-body">
<a href="../exportxls/ht_ckd_stage4_age_l65_cid_export_excel.php?hcode=<?php echo $arr_rs['HCODE'];?>&hcode=<?php echo $hcode ;?>&id=<?php echo $id ;?>&b_year=<?php echo $b_year;?>&ystr=<?php echo $ystr;?>&yend=<?php echo $yend;?>" class="btn btn-default btn-sm" role="button">ส่งออก Excel </a>
<div class="table-responsive ">
<table class="table table-hover">
<thead>
    <tr>
        <th>รหัสสถานพยาบาล</th>
        <th>CID</th>
        <th>ชื่อ-สกุล</th>
        <th>วันเดือนปีเกิด</th>
        <th>อายุ</th>
        <th>เพศ</th>
        <th>ICD10</th>
        <th>วันมารับบริการตรวจ GFR</th>
        <th>ผล GFR</th>
        <th>บ้านเลขที่</th>
        <th>หมู่</th>
        <th>หมู่บ้าน</th>
        <th>TYPEAREA</th>
        <!--<th><div align="center">Excel</div></th>-->
    </tr>
     </thead>
     <tbody>             
</tbody>
<?php

 $dbrpt->Query("
    SELECT  
        t.HOSPCODE,t.CID,CONCAT(t.PRENAME,t.NAME,' ',t.LNAME)AS FULLNAME,
        t.BIRTH,t.AGE,s.sexname AS SEX,t.DATE_SERV,t.DIAG,t.LABRESULT,t.HOUSE,
        t.VHID,
        cvl.villname AS VILLNAME,CONCAT(t.TYPEAREA,'-',c.typeareaname)AS TYPREAREA
        FROM t_ckd_dm t
        INNER JOIN loeichart.co_village_loei as cvl ON t.VHID=cvl.villid AND t.HOSPCODE=cvl.hospcode
        INNER JOIN loeichart.ctypearea c ON c.typeareacode=t.TYPEAREA
        INNER JOIN hdc.csex s ON s.sex = t.SEX
        WHERE t.DATE_SERV BETWEEN '$ystr' AND '$yend' AND t.HOSPCODE='$hcode' 
        AND t.LABRESULT<'15.00' AND t.AGE<'65';
		");
while($arr_rs=$dbrpt->Fetch_array()){
	  $anc=$arr_rs['GA'];
?>    
    <tr>
        <td><?php echo $arr_rs['HOSPCODE'];?></td>
        <td><?php echo $arr_rs['CID'];?></td>
        <td><?php echo $arr_rs['FULLNAME'];?></td>
        <td>
        <?php echo $arr_rs['BIRTH']; ?>
        </td>
        <td>
        <?php echo $arr_rs['AGE']; ?>
        </td>        
        <td>
        <?php echo $arr_rs['SEX']; ?>
        </td>
        <td>
        <?php echo $arr_rs['DIAG']; ?>
        </td>
         <td>
        <?php echo $arr_rs['DATE_SERV']; ?>
        </td>
        <td>
        <?php echo $arr_rs['LABRESULT']; ?>
        </td>
        <td>
        <?php echo $arr_rs['HOUSE']; ?>
        </td>
        <td>
        <?php echo substr($arr_rs['VHID'],6,2); ?>
        </td>
        <td>
        <?php echo $arr_rs['VILLNAME']; ?>
        </td>
        <td>
        <?php echo $arr_rs['TYPREAREA']; ?>
        </td>
        <!--<td align="center"><a href="../exportxls/ht_ckd_stage3a_age_l65_cid_export_excel.php?hcode=<?php echo $arr_rs['HCODE'];?>&hcode=<?php echo $hcode ;?>&id=<?php echo $id ;?>&b_year=<?php echo $b_year;?>&ystr=<?php echo $ystr;?>&yend=<?php echo $yend;?>" class="btn btn-default btn-sm" role="button">ส่งออก Excel </a>
        </td>-->       
    </tr>
 
<?php }?>   
</table>

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
