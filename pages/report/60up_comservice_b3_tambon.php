<?php
session_start() ;
if (!isset($_SESSION['login_true'])) {
     header("Location: login.php");//สั่งให้ redirect ไปหน้า login เมื่อไม่มีการ login แต่เรียกใช้หน้านี้
     exit;
}

?>
  <?php
function __autoload($class_name){
	include'../class/class.'.$class_name.'.php';
}
set_time_limit(0);
include"../config/config.php";
////

?>
<?php
$ampcode=$_GET['ampcode'];
$hospcode=$_GET['hospcode'];
$id=$_GET['id'];
//$age=$_GET['age'];
$table=$_GET['table'];
 $dbrpt=new Database(DB_HOST_TK,DB_USER_TK,DB_PASS_TK,DB_NAME_TK);//new object 
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="description" content="">
<meta name="author" content="">
<title></title>
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
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>      
</head>

<body>

<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
  <div class="container">
    <?php
 //select name report
  $dbrpt->Query("SELECT * FROM z42_sys_report WHERE id='$id' ORDER BY cat_id");
    while($arrrpt=$dbrpt->Fetch_array()){
		
		?>
		<h4><?php echo $arrrpt['report_name'];?> </h4>
		<?php
        }
 
?>
  </div>
</nav>
<br>
<!---->
 <div class="panel panel-info">
  <div class="panel-heading"></div>
     <div class="panel-body">
            
<div class="table-responsive ">
<table id="myTable"  class="table table-hover">
<thead>
          <tr>
              
             <th>ตำบล</th>
             <th>ผู้สูงอายุเตียง 3_ชาย</th>
             <th>ผู้สูงอายุเตียง 3_หญิง</th>
             <th>ผู้สูงอายุเตียง 3_รวม</th>
		     <th>เยี่ยมบ้าน_ชาย</th>
		     <th>เยี่ยมบ้าน_หญิง</th>
             <th>เยี่ยมบ้าน_รวม</th>
 		     <th>เยี่ยมผู้สูงอายุ 3 รหัส_ชาย</th>
		     <th>เยี่ยมผู้สูงอายุ 3 รหัส_หญิง</th>
             <th>เยี่ยมผู้สูงอายุ 3 รหัส_รวม</th>

          </tr>
     </thead>
     <tbody>             
</tbody>
<?php

 $dbrpt->Query("select * from z42_60up_comservice_b3_tambon_s where ampcode=$ampcode and hospcode=$hospcode");
while($arr_rs=$dbrpt->Fetch_array())
{
	
?>    
	<tr>
		<td>
         <a href="60up_comservice_b3_vill.php?ampcode=<?php echo $arr_rs['AMPCODE'];?>&tcode=<?php echo $arr_rs['TCODE'];?>&id=<?php echo $id;?>&hospcode=<?php echo $arr_rs['HOSPCODE']?>"><?php echo $arr_rs['TNAME']; ?></a>               
		</td>

         <td>
        <?php echo  number_format($arr_rs['BED3_M']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['BED3_FM']); ?>
		</td>
        <td>
        <?php echo  number_format($arr_rs['BED3_TT']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['COMSERVICE_M']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['COMSERVICE_FM']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['COMSERVICE_TT']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['COMSERVICE3_M']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['COMSERVICE3_FM']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['COMSERVICE3_TT']); ?>
		</td>
		
	</tr>
 
<?php } $dbrpt->Close_Conn();?>   
</table>
<!--contex-->
<ul id="contextMenu" class="dropdown-menu" role="menu" style="display:none" >
    <li><a tabindex="-1" href="#">Action</a></li>
    <li><a tabindex="-1" href="#">Another action</a></li>
    <li><a tabindex="-1" href="#">Something else here</a></li>
    <li class="divider"></li>
    <li><a tabindex="-1" href="#">Separated link</a></li>
</ul>
<!--contex-->
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
