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
$id=$_GET['id'];
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
		<h4><?php echo $arrrpt['report_name'];?>
        <a href="../exportxls/60up_functional_amp_export_excel.php?id=<?php echo $id;?>&table=<?php echo $table;?>" class="btn btn-default btn-sm " role="button">Excel</a>
        </h4>
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
              
             <th>อำเภอ</th>
             <th>ผู้สูงอายุ_ชาย</th>
             <th>ผู้สูงอายุ_หญิง</th>
             <th>ผู้สูงอายุ_รวม</th>
		     <th>ประเมินความบกพร่อง_ชาย</th>
		     <th>ประเมินความบกพร่อง_หญิง</th>
             <th>ประเมินความบกพร่อง_รวม</th>
 		     <th>Barthead ADL Index_ชาย</th>
		     <th>Barthead ADL Index_หญิง</th>
             <th>Barthead ADL Index_รวม</th>
             <th>IADL_ชาย</th>
		     <th>IADL_หญิง</th>
             <th>IADL_รวม</th>
             <th>Mental_ชาย</th>
		     <th>Mental_หญิง</th>
             <th>Mental_รวม</th>
             <th>Other_ชาย</th>
		     <th>Other_หญิง</th>
             <th>Other_รวม</th>              
             <th>Unspecified_ชาย</th>
		     <th>Unspecified_หญิง</th>
             <th>Unspecified_รวม</th>              
             <th>ไม่พึ่งพิง_ชาย</th>
		     <th>ไม่พึ่งพิง_หญิง</th>
             <th>ไม่พึ่งพิง_รวม</th>              
             <th>พึ่งพิงน้อย_ชาย</th>
		     <th>พึ่งพิงน้อย_หญิง</th>
             <th>พึ่งพิงน้อย_รวม</th>              
             <th>พึ่งพิงมาก_ชาย</th>
		     <th>พึ่งพิงมาก_หญิง</th>
             <th>พึ่งพิงมาก_รวม</th>

          </tr>
     </thead>
     <tbody>             
</tbody>
<?php

 $dbrpt->Query("select * from $table");
while($arr_rs=$dbrpt->Fetch_array())
{
	
?>    
	<tr>
		<td>
         <a href="javascript:popup('60up_functional_pcu.php?ampcode=<?php echo $arr_rs['AMPCODE'];?>&id=<?php echo $id;?>','',960,500)"><?php echo $arr_rs['AMPNAME']; ?></a>
		</td>
        
         <td>
        <?php echo  number_format($arr_rs['M']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['FM']); ?>
		</td>
        <td>
        <?php echo  number_format($arr_rs['TT']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['FUNC_M']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['FUNC_FM']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['FUNC_TT']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['ADL_M']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['ADL_FM']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['ADL_TT']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['IADL_M']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['IADL_FM']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['IADL_TT']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['MENTAL_M']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['MENTAL_FM']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['MENTAL_TT']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['OTHER_M']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['OTHER_FM']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['OTHER_TT']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['UNPS_M']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['UNPS_FM']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['UNPS_TT']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['DEPEN_no_M']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['DEPEN_no_FM']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['DEPEN_no_TT']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['DEPEN_less_M']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['DEPEN_less_FM']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['DEPEN_less_TT']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['DEPEN_more_M']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['DEPEN_more_FM']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['DEPEN_more_TT']); ?>
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
