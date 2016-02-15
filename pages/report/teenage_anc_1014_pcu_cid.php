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
              
             
             <th>รหัสพยาบาล</th>
             <th>CID</th>
             <th>ชื่อ-สกุล</th>
             <th>วันเดือนปีเกิด</th>
             <th>GRAVIDA</th>
   			 <th>วันมารับบริการครั้งแรก</th>
             <th>GA</th>
             <th>ANC 12 WEEK</th>
              <th>บ้านเลขที่</th>
                <th>หมู่</th>
                 <th>หมู่บ้าน</th>

          </tr>
     </thead>
     <tbody>             
</tbody>
<?php

 $dbrpt->Query("
				
		SELECT 
                zat.HOSPCODE,zat.CID,CONCAT(c.prename,zat.NAME,'  ',zat.LNAME) as FULLNAME,
                zat.BIRTH,zat.GRAVIDA,zat.DATE_SERV AS FANC,
                zat.GA,zat.DUPDATE as DUPDATE,
                zat.HOUSE,zat.VHID,cvl.VILLNAME
                FROM z42_anc_teenage AS zat
        INNER JOIN co_village_loei as cvl ON zat.VHID=cvl.villid AND zat.HOSPCODE=cvl.hospcode
        INNER JOIN loeichart.cprename c ON c.id_prename = zat.PRENAME
		WHERE zat.DATE_SERV BETWEEN '$ystr' AND'$yend' and zat.hospcode='$hcode' 
        AND zat.CK2='1'
			
				");
while($arr_rs=$dbrpt->Fetch_array()){
	  $anc=$arr_rs['GA'];
?>    
	<tr>
	      <td><?php echo $arr_rs['HOSPCODE'];?></td>
        <td><a href="javascript:popup('anc_report_12w_where_anc.php?hcode=<?php echo $arr_rs['HCODE'];?>&b_year=<?php echo $b_year;?>&ystr=<?php echo $ystr;?>&yend=<?php echo $yend;?>&cid=<?php echo $arr_rs['CID'];?>&gravida=<?php echo $arr_rs['GRAVIDA'];?>','',960,500)" title="ตรวสอบสถานที่รับ ANC"><?php echo $arr_rs['CID'];?></a></td>
           <td><?php echo $arr_rs['FULLNAME'];?></td>
        <td>
        <?php echo $arr_rs['BIRTH']; ?>
		</td>
          <td>
        <?php echo $arr_rs['GRAVIDA']; ?>
		</td>

         <td>
        <?php echo $arr_rs['FANC']; ?>
		</td>
        <td>
        <?php echo $arr_rs['GA']; ?>
        </td>
        
        <?php
		 if($anc<='12'){
			 ?>
			 <td><button class="btn btn-xs btn-success btn-circle"><i class="fa fa-check"></i></button></td>
	    <?php
          }else if($anc>'12'){
		 ?>
         <td><button class="btn btn-xs btn-danger btn-circle"><i class="fa fa-ban" ></i></button></td>
         <?php	  
			  
			  }
		 ?>
		
               <td>
        <?php echo $arr_rs['HOUSE']; ?>
		</td>
        		
               <td>
        <?php echo substr($arr_rs['VHID'],6,2); ?>
		</td>
         <td>
        <?php echo $arr_rs['VILLNAME']; ?>
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
