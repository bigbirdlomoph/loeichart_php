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
<div class="panel-body">
<div class="table-responsive ">
<table class="table table-hover">
<thead>
    <tr>
        <th>รหัสสถานพยาบาล</th>
        <th>CID</th>
        <th>ชื่อ</th>
        <th>สกุล</th>
        <th>วันเดือนปีเกิด</th>
        <th>น้ำหนักแรกเกิด</th>
        <th>ผล TSH</th>
        <th>พัฒนาการ</th>
        <th>วันรับคัดกรอง</th>
        <th>บ้านเลขที่</th>
        <th>หมู่</th>
        <!--<th>หมู่บ้าน</th>
        <th>TYPEAREA</th>-->
        <!--<th><div align="center">Excel</div></th>-->
    </tr>
     </thead>
     <tbody>             
</tbody>
<?php

 $dbrpt->Query("
        SELECT n.hospcode,n.cid,n.name,n.lname,n.birth,n.bweight,n.tshresult,
        n.d_develop,n.date_serv,n.house,n.vhid
        FROM z42_dv9_507 n
        WHERE n.date_serv BETWEEN '$ystr' AND '$yend' AND n.HOSPCODE='$hcode' AND n.childdevelop='1';
		");
while($arr_rs=$dbrpt->Fetch_array()){
	  $anc=$arr_rs['GA'];
?>    
    <tr>
        <td><?php echo $arr_rs['hospcode'];?></td>
        <td><?php echo $arr_rs['cid'];?></td>
        <td><?php echo $arr_rs['name'];?></td>
        <td><?php echo $arr_rs['lname'];?></td>
        <td>
        <?php echo $arr_rs['birth']; ?>
        </td>
        <td>
        <?php echo $arr_rs['bweight']; ?>
        </td>        
        <td>
        <?php echo $arr_rs['tshresult']; ?>
        </td>
        <td>
        <?php echo $arr_rs['d_develop']; ?>
        </td>
         <td>
        <?php echo $arr_rs['date_serv']; ?>
        </td>
        <!--<td>
        <?php echo $arr_rs['LABRESULT']; ?>
        </td>-->
        <td>
        <?php echo $arr_rs['house']; ?>
        </td>
        <td>
        <?php echo substr($arr_rs['vhid'],6,2); ?>
        </td>
        <!--<td>
        <?php echo $arr_rs['VILLNAME']; ?>
        </td>
        <td>
        <?php echo $arr_rs['TYPREAREA']; ?>-->
        </td>
        <!--<td align="center"><a href="../exportxls/ckd_stage1_export_excell.php?hcode=<?php echo $arr_rs['HCODE'];?>&id=<?php echo $id ;?>&b_year=<?php echo $b_year;?>&ystr=<?php echo $ystr;?>&yend=<?php echo $yend;?>" title="ส่งออก Excell"><i class="fa fa-file-excel-o"></i></a>
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
