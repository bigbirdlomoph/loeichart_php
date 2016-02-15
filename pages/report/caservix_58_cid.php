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
$villid=$_GET['villid'];
$i=1;
$dbrpt=new Database(DB_HOST_TK,DB_USER_TK,DB_PASS_TK,DB_NAME_TK);//new object 
?>
<div class="panel panel-info">
<div class="panel-heading">
<a href="../exportxls/caservix_58_cid_export_excel.php?villid=<?=$villid;?>&hcode=<?php echo $hcode ;?>&id=<?php echo $id ;?>&b_year=<?php echo $b_year;?>&ystr=<?php echo $ystr;?>&yend=<?php echo $yend;?>" class="btn btn-default btn-sm" role="button">ส่งออก Excel </a>
<br> จำนวนผู้ป่วยมะเร็งเต้านม แยกรายอำเภอ ปีงบประมาณ 2558 (ข้อมูล ณ เดือนมิถุนายน 2558)
</div>
<div class="panel-body">
<div class="table-responsive ">
<table class="table table-hover">
<thead>
    <tr>
        <th>ลำดับ</th>
        <th>รหัสสถานพยาบาล</th>
        <th>CID</th>
        <th>ชื่อ-สกุล</th>
        <th>อายุ</th>
        <th>วันที่วินิจฉัย</th>
        <th>รหัสวินิจฉัย</th>
        <th>บ้านเลขที่</th>
        <th>หมู่บ้าน</th>
        <th>ตำบล</th>
        <th>อำเภอ</th>
    </tr>
     </thead>
     <tbody>             
</tbody>
<?php

 $dbrpt->Query("
            SELECT 
            c.HOSPCODE, c.CID, CONCAT(c.NAME,' ',c.lname)AS FULLNAME, 
            c.age_y, c.Date_diag, c.Diag, c.house, v.villname AS VILLNAME, 
            s.subdistname AS TUMBONNAME, a.AMP_NAME, c.vhid
            FROM z42_tc_cacervix c
            LEFT JOIN z42_co_office_loei o ON o.off_id = c.HOSPCODE
            LEFT JOIN z42_amp a ON a.AMP_CODE = o.distid
            LEFT JOIN z42_co_subdistrict s ON s.subdistid = LEFT(c.vhid,6)
            LEFT JOIN z42_co_village v ON v.villid = c.vhid
            WHERE c.HOSPCODE='$hcode' AND o.subdistid='$villid'
            ORDER BY c.Date_diag;

		");
while($arr_rs=$dbrpt->Fetch_array()){

?>    
    <!--<tr bgcolor="<?php echo $arr_rs['PAP_CHK']; ?>" align="center">-->
    <tr align="center">
        <td><?php echo $i++;?></td>
        <td><?php echo $arr_rs['HOSPCODE'];?></td>
        <td><?php echo $arr_rs['CID'];?></td>
        <td><?php echo $arr_rs['FULLNAME'];?></td>
        <td><?php echo $arr_rs['age_y']; ?></td>        
        <td><?php echo $arr_rs['Date_diag']; ?></td>
        <td><?php echo $arr_rs['Diag']; ?></td>
        <td><?php echo $arr_rs['house']; ?></td>
        <td><?php echo $arr_rs['VILLNAME']; ?></td>
        <td><?php echo $arr_rs['TUMBONNAME']; ?></td>
        <td><?php echo $arr_rs['AMP_NAME']; ?></td>      
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
