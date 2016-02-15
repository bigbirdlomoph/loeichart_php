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
<div class="panel-heading">ร้อยละการคัดกรองมะเร็งปากมดลูก สะสม 5 ปี (QOF 2559)
รายชื่อ
<a href="../exportxls/goalpap_cid_export_excel.php?villid=<?=$villid;?>&hcode=<?php echo $hcode ;?>&id=<?php echo $id;?>&b_year=<?php echo $b_year;?>&ystr=<?php echo $ystr;?>&yend=<?php echo $yend;?>" class="btn btn-default btn-sm" role="button">ส่งออก Excel </a>
<br> สถานะการคัดกรอง <br>
0 = ยังไม่ได้รับการคัดกรอง <br>
2 = คัดกรองแล้ว <br>
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
        <!--<th>วันเดือนปีเกิด</th>-->
        <th>อายุ</th>
        <th>สถานบริการที่คัดกรอง</th>
        <th>ผลการคัดกรอง</th>
        <th>รายละเอียดผลการคัดกรองไม่ปกติ</th>
        <th>ปีงบประมาณที่ได้รับการคัดกรอง</th>
        <th>สถานะการคัดกรอง</th>
        <th>บ้านเลขที่</th>
        <th>หมู่ที่</th>
        <th>หมู่บ้าน</th>
        <th>อำเภอ</th>
        <!--<th><div align="center">Excel</div></th>-->
    </tr>
     </thead>
     <tbody>             
</tbody>
<?php

 $dbrpt->Query("
            SELECT 
                a.hospcode, a.cid, CONCAT(a.NAME,' ',a.lname)AS FULLNAME, 
                a.birth, a.age_y, CONCAT(a.hospcode_pap,' : ', a.hospname_pap)AS HOSP_PAP, a.result, 
                a.details_ab, a.period, a.pap_ck, a.house, v.villno, v.villname, s.subdistname, v.villid AS VILLCODE,
                CASE WHEN a.pap_ck='0' THEN '#DC143C'   
                WHEN a.pap_ck='2' THEN '' ELSE 'PAP_SMEAR' END AS PAP_CHK
            FROM z42_tc_goalpap a
            LEFT JOIN z42_co_subdistrict s ON s.subdistid = LEFT(a.vhid,6)
            LEFT JOIN z42_co_village v ON v.villid = LEFT(a.vhid,8)
            WHERE v.villid='$villid' AND a.pap_ck<>'1'
            ORDER BY a.period DESC,a.age_y ;
		");
while($arr_rs=$dbrpt->Fetch_array()){
	  //$chkrow=$arr_rs['PAP_CHK'];
	  $papck=$arr_rs['pap_ck'];
?>    
    <!--<tr bgcolor="<?php echo $arr_rs['PAP_CHK']; ?>" align="center">-->
    <tr align="center">
        <td><?php echo $i++;?></td>
        <td><?php echo $arr_rs['hospcode']; ?></td>
        <td><?php echo $arr_rs['cid']; ?></td>
        <td><?php echo $arr_rs['FULLNAME']; ?></td>
        <!--<td>
        <?php echo $arr_rs['birth']; ?>
        </td>-->
        <td>
        <?php echo $arr_rs['age_y']; ?>
        </td>        
        <td>
        <?php echo $arr_rs['HOSP_PAP']; ?>
        </td>
        <td>
        <?php echo $arr_rs['result']; ?>
        </td>
         <td>
        <?php echo $arr_rs['details_ab']; ?>
        </td>
        <td>
        <?php echo $arr_rs['period']; ?>
        </td>
        <td>
                <?php
		if($papck=='0'){
        ?>
          <button type="button" class="btn btn-xs btn-danger"><b><?php echo $arr_rs['pap_ck'];?></b></button></td>
        <?php
          }else if($papck=='1'){
        ?>
          <button type="button" class="btn btn-xs btn-warning"><b><?php echo $arr_rs['pap_ck'];?></b></button></td>
        <?php  
		  }else if($papck=='2'){
        ?>
		  <button type="button" class="btn btn-xs btn-success"><b><?php echo $arr_rs['pap_ck'];?></b></button></td>
		<?php
          }
        ?>
        <!--<?php echo $arr_rs['pap_ck']; ?>-->
        </td>        
        <td>
        <?php echo $arr_rs['house']; ?>
        </td>
        <td>
        <?php echo ($arr_rs['villno']); ?>
        </td>
        <td>
        <?php echo $arr_rs['villname']; ?>
        </td>
        <td>
        <?php echo $arr_rs['subdistname']; ?>
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
