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
$id=$_GET['id'];
$o_year=substr($_GET['ystr'],0,4);
$b_year=$_GET['b_year'];
$ystr=$_GET['ystr'];;
$yend=$_GET['yend'];
$dbrpt=new Database(DB_HOST_TK,DB_USER_TK,DB_PASS_TK,DB_NAME_TK);//new object 
?>
<div class="panel panel-info">
<div class="panel-heading"> <a href="javascript:history.go(-1)" class="btn btn-default btn-sm " role="button">Back</a></div>
<div class="panel-body">
<div class="table-responsive ">
<table class="table table-hover">
<thead>
          <tr>
              
             
             <th>รหัสพยาบาล</th>
             <th>CID</th>
             <th>ชื่อ-สกุล</th>
             <th>GRAVIDA</th>
             <th>วันมารับ ANC</th>
             <th>ANC 12 week</th>
             <th>ANC 5 ครั้ง</th>
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
						a5qt.hospcode as HOSPCODE,
						a5qt.cid as CID,
						CONCAT(a5qt.name,' ',a5qt.lname) as FULLNAME,
						a5qt.gravida as GRAVIDA,
						a5qt.lmp as LMP,
						a5qt.edc as EDC,
						a5qt.bdate as BDATE,
						a5qt.fanc AS FANC,
						a5qt.anc12 AS ANC12,
						a5qt.ancq as ANCQ,
						a5qt.house as HOUSE,
						a5qt.vhid as VHID,
						cvl.villname as VILLNAME
						
						FROM z42_anc5q_t as a5qt
						LEFT OUTER JOIN co_village_loei as cvl ON a5qt.vhid=cvl.villid AND a5qt.hospcode=cvl.hospcode
						WHERE a5qt.fanc BETWEEN '$ystr' AND'$yend' and a5qt.hospcode=$hcode

			
				");
while($arr_rs=$dbrpt->Fetch_array()){
	  $anc=$arr_rs['ANCQ'];
	  $anc12=$arr_rs['ANC12'];
?>    
	<tr>
      <td><?php echo $arr_rs['HOSPCODE'];?></td>
        <td><a href="anc5q_report_pcu_cid_list.php?cid=<?php echo $arr_rs['CID'];?>&fullname=<?php echo$arr_rs['FULLNAME'];?>"><?php echo $arr_rs['CID'];?></a></td>
           <td><?php echo $arr_rs['FULLNAME'];?></td>
        <td>
        <?php echo $arr_rs['GRAVIDA']; ?>
		</td>
        
          <td>
        <?php echo $arr_rs['FANC']; ?>
		</td>
    <?php if($anc12 <= '12'){?>
      <td><span class="label label-success"><i class="fa fa-check"></i></span></td>
      <?php }elseif($anc12 > '12'){?>
      <td><span class="label label-danger"><i class="fa fa-close"></i></span></td>
      
	  <?php }?>       
 
  <!--5q-->      
            
      <?php if($anc=='1'){?>
      <td><span class="label label-success"><i class="fa fa-check"></i></span></td>
      <?php }elseif($anc=='0'){?>
      <td><span class="label label-danger"><i class="fa fa-close"></i></span></td>
      
	  <?php }?>       
  
		
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
