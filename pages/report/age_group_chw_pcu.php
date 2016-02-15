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
?>
<?php
$tambon=$_GET['tambon'];
$id=$_GET['id'];
$age_st=$_GET['age_st'];
$age_end=$_GET['age_end'];
$o_year=$_GET['b_year']-1;
$b_year=$_GET['b_year'];
$ystr=$_GET['ystr'];;
$yend=$_GET['yend'];
//
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
<title>ข้อมูล กลุ่มอายุ <?php echo $age_st;?> ถึง <?php echo $age_end;?> ปีขึ้นไป ระดับสถานบริการ</title>
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

<div class="panel panel-info">
<div class="panel-heading">
<?php
//select name report
  $dbrpt->Query("SELECT * FROM z42_sys_report WHERE id='$id' ORDER BY source_table");
    while($arrrpt=$dbrpt->Fetch_array()){
		  $table=$arrrpt['source_table'];
		?>
   
		<h4><?php echo $arrrpt['report_name'];?> </h4>
		<?php
        }
?>
 <a href="javascript:history.go(-1)" class="btn btn-default btn-sm " role="button">Back</a>
</div>
  <div class="panel-body">
<div class="table-responsive ">
<table class="table table-hover">
<thead>
          <tr>
              
             <th>สถานบริการ</th>
           <th>จำนวนประชากร</th>
            <th>ชาย</th>
             <th>หญิง</th>
          

          </tr>
     </thead>
     <tbody>             
</tbody>
<?php

 $dbrpt->GET_AGE_GROUP_CHW_PCU($table,$age_st,$age_end,$tambon);
while($arr_rs=$dbrpt->Fetch_array()){
	
?>    
	<tr>
		<td>
         <a href="age_group_chw_vill.php?hcode=<?php echo $arr_rs['HOSPCODE'];?>&id=<?php echo $id;?>&age_st=<?php echo $age_st;?>&age_end=<?php echo $age_end;?>&table=<?php echo $table;?>&tambon=<?php echo $tambon;?>"><?php echo $arr_rs['HOSPNAME']; ?></a>     
		</td>
        <td>
        <?php echo  number_format($arr_rs['SUMMARY']); ?>
		</td>
        <td>
        <?php echo  number_format($arr_rs['MALE']); ?>
        </td>
  		<td>
        <?php echo  number_format($arr_rs['FEMALE']); ?>
        </td>

	</tr>
 
<?php } $dbrpt->Close_Conn();?>   
</table>
</div>
</div>
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
