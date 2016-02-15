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
//$hcode=$_GET['hcode'];
//$b_year=$_GET['b_year'];

//$ystr=($b_year-1)."-10-01";
//$yend=$b_year."-09-30";
$cid=$_GET['cid'];
$fullname=$_GET['fullname'];
$dbrpt=new Database(DB_HOST_TK,DB_USER_TK,DB_PASS_TK,DB_NAME_TK);//new object 
?>
<div class="panel panel-info">
<div class="panel-heading"></a>
 <div class="panel-title"><?php echo $fullname;?> <br> <a href="javascript:history.go(-1)" class="btn btn-default btn-sm " role="button">Back</a></div>
</div>
<div class="panel-body">
<div class="table-responsive ">
<table class="table table-hover">
<thead>
          <tr>
              
             
             <th>รหัสพยาบาล</th>
             <th>CID</th>
             <th>GRAVIDA</th>
             <th>LMP</th>
             <th>EDC</th>
             <th>BDATE</th>
              <th>DATE_SERV</th>


          </tr>
     </thead>
     <tbody>             
</tbody>
<?php

 $dbrpt->Query("SELECT * from z42_anc5q_t where cid='$cid'");
while($arr_rs=$dbrpt->Fetch_array()){
?>    
	<tr>
      <td><?php echo $arr_rs['hospcode'];?></td>
        <td><?php echo $arr_rs['cid'];?></td>
        <td>
        <?php echo $arr_rs['gravida']; ?>
		</td>
          <td>
        <?php echo $arr_rs['lmp']; ?>
		</td>
        <td>
        <?php echo $arr_rs['edc']; ?>
		</td>
        <td><?php echo $arr_rs['bdate']; ?></td>
	     <td><?php echo $arr_rs['fanc']; ?></td> 		        
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
