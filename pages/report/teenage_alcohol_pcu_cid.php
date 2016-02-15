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

</head>

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
              
             
             <th>รหัสพยาบาล</th>
             <th>CID</th>
             <th>ชื่อ-สกุล</th>
             <th>วันเดือนปีเกิด</th>
             <th>อายุ</th>
             <th>ดื่มสุรา</th>
             <th>วันที่คัดกรอง</th>
             <th>บ้านเลขที่</th>
             <th>หมู่</th>
             <th>หมู่บ้าน</th>
             <th>สถานะบุคคล</th>

          </tr>
     </thead>
     <tbody>             
</tbody>
<?php

 $dbrpt->Query("
				
SELECT 
    zat.HOSPCODE,
    zat.CID,
    CONCAT(cp.prename,zat.NAME,' ',zat.LNAME)AS FULLNAME,
    zat.BIRTH,zat.AGE,
    zat.DATE_SERV,
    c.alcohol,
    zat.HOUSE as HOUSE,
    zat.VHID as VHID,
    cvl.villname as VILLNAME,
    zat.DUPDATE,CONCAT(zat.TYPEAREA,'-',c2.typeareaname)AS TYPEAREA
FROM z42_tmp_smoke_alcohol AS zat
INNER JOIN co_village_loei as cvl ON zat.VHID=cvl.villid AND zat.HOSPCODE=cvl.hospcode
INNER JOIN hdc.calcohol c ON c.id_alcohol=zat.ALCOHOL
INNER JOIN loeichart.cprename cp ON cp.id_prename = zat.PRENAME
INNER JOIN hdc.ctypearea c2 ON c2.typeareacode = zat.TYPEAREA
				WHERE YEAR(zat.DATE_SERV) BETWEEN '$ystr' AND'$yend' and zat.hospcode='$hcode'
                AND zat.ALCOHOL IN('2','3','4') 
			
				");
while($arr_rs=$dbrpt->Fetch_array()){
	  $anc=$arr_rs['ANC12'];
?>    
	<tr>
	      <td><?php echo $arr_rs['HOSPCODE'];?></td>
          <td><a href="javascript:popup('#.php?hcode=<?php echo $arr_rs['HCODE'];?>&b_year=<?php echo $b_year;?>&ystr=<?php echo $ystr;?>&yend=<?php echo $yend;?>&cid=<?php echo $arr_rs['CID'];?>&gravida=<?php echo $arr_rs['GRAVIDA'];?>','',960,500)" title="ตรวสอบสถานที่รับ ANC">
            <?php echo $arr_rs['CID'];?></a></td>
           <td><?php echo $arr_rs['FULLNAME'];?></td>
        <td>
        <?php echo $arr_rs['BIRTH']; ?>
		</td>
          <td>
        <?php echo $arr_rs['AGE']; ?>
		</td>
          <td>
            <?php echo $arr_rs['alcohol']; ?>
        </td>
          <td>
            <?php echo $arr_rs['DATE_SERV']; ?>
        </td>
        <!--
        <?php
		 if($anc=='1'){
			 ?>
			 <td><button class="btn btn-xs btn-success btn-circle"><i class="fa fa-check"></i></button></td>
	    <?php
          }else if($anc=='0'){
		 ?>
         <td><button class="btn btn-xs btn-danger btn-circle"><i class="fa fa-ban" ></i></button></td>
         <?php	  
			  
			  }
		 ?>-->
		
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
        <?php echo $arr_rs['TYPEAREA']; ?>
        </td>
        
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
