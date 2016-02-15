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
<title>anc12week</title>
   
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
$cid=$_GET['cid'];
$gravida=$_GET['gravida'];
$ystr=$_GET['ystr'];
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
             <th>GRAVIDA</th>
             <th>วันมารับ ANC</th>
   			 <th>GA</th>
              <th>TYPE AREA</th>
                

          </tr>
     </thead>
     <tbody>             
</tbody>
<?php

 $dbrpt->Query("
				
		SELECT * FROM z42_anc_all where CID='$cid' and GRAVIDA='$gravida' ORDER BY DATE_SERV ASC
			
				");
while($arr_rs=$dbrpt->Fetch_array()){
	  $anc=$arr_rs['ANC12'];
?>    
	<tr>
	      <td><?php echo $arr_rs['HOSPCODE'];?></td>
           <td><?php echo $arr_rs['CID'];?></td>
        <td>
        <?php echo $arr_rs['GRAVIDA']; ?>
		</td>
          <td>
        <?php echo $arr_rs['DATE_SERV']; ?>
		</td>

         <td>
        <?php echo $arr_rs['GA']; ?>
		</td>

      	
               <td>
        <?php echo $arr_rs['TYPE_AREA']; ?>
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
