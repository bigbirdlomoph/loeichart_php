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

$id=$_GET['id'];//id report
$table=$_GET['table'];
$age_st=$_GET['age_st'];
$age_end=$_GET['age_end'];
$o_year=substr($_GET['str_date'],0,4);//year_old 10,11,12
$b_year=substr($_GET['end_date'],0,4);//year_next 
$ystr=$_GET['str_date'];
$yend=$_GET['end_date'];
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
<title>ข้อมูล กลุ่มอายุ <?php echo $age_st;?> ถึง <?php echo $age_end;?> ปีขึ้นไป ระดับอำเภอ</title>
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
		$sql_area=$arrrpt['query_areacode'];
		$table_c=$arrrpt['source_table_c'];
		?>
		<h4><?php echo $arrrpt['report_name'];?> </h4>
		<?php
        }
 
?>
  </div>
</nav>
<div class="panel panel-success">
 <div class="panel-heading"><i class="fa fa-chain"></i> กราฟ</div>
  <div class="panel-body">

  <?php include("../chart/chart_chw_amp.php")?>
  
  </div>
</div>
<!---->
<!---->
 <div class="panel panel-info">
  <div class="panel-heading">ข้อมูล กลุ่มอายุ <?php echo $age_st;?> ถึง <?php echo $age_end;?> ปีขึ้นไป ระดับอำเภอ
  <a href="../exportxls/age_group_chw_export_excel.php?id=<?php echo $id?>&age_st=<?php echo $age_st?>&age_end=<?php echo $age_end?>&table=<?php echo $table?>"class="btn btn-default btn-sm " role="button">
   ส่งออก Excel
   </a>
  </div>
     <div class="panel-body">
            
<div class="table-responsive ">
<table id="myTable"  class="table table-hover">
<thead>
          <tr>
              
             <th>อำเภอ</th>
           <th>จำนวนประชากร</th>
            <th>ชาย</th>
             <th>หญิง</th>
             

          </tr>
     </thead>
     <tbody>             
</tbody>
<?php

 $dbrpt->GET_AGE_GROUP_CHW_AMP($table);
while($arr_rs=$dbrpt->Fetch_array())
{
	
?>    
	<tr>
		<td>
         <a href="javascript:popup('age_group_chw_tambon.php?ampcode=<?php echo $arr_rs['AMPCODE'];?>&id=<?php echo $id;?>&age_st=<?php echo $age_st;?>&age_end=<?php echo $age_end;?>','',960,500)"><?php echo $arr_rs['AMPNAME']; ?></a>
       
        
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
<!--contex-->
<ul id="contextMenu" class="dropdown-menu" role="menu" style="display:none" >
    <li><a tabindex="-1" href="#"><i class="fa fa-file-excel-o">&nbsp;</i>Excel</a></li>
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
