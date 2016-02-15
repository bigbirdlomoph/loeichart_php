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
    <!--calendar-->
     <link type="text/css" rel="stylesheet" href="../plugins/dhtmlgoodies_calendar/dhtmlgoodies_calendar.css?random=20051112" media="screen"></LINK>
	<script type="text/javascript" src="../plugins/dhtmlgoodies_calendar/dhtmlgoodies_calendar.js?random=20060118"></script>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>      
</head>

<body>
<?php

$id=$_GET['id'];//id report
$table=$_GET['table'];
$age=$_GET['age'];

 $dbrpt=new Database(DB_HOST_TK,DB_USER_TK,DB_PASS_TK,DB_NAME_TK);//new object 
?>
<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
  <div class="container">
    <?php
 //select name report
  $dbrpt->Query("SELECT * FROM z42_sys_report WHERE id='$id' ORDER BY cat_id");
    $arrrpt=$dbrpt->Fetch_array();
		$sql_area=$arrrpt['query_areacode'];
		
		?>
         <ul class="nav navbar-top-links navbar-right">
         <li><a href="../index.php"><i class="fa fa-home fa-fw"></i> HOME</a>
         </ul>
		<h4><?php echo $arrrpt['report_name'];?> <?php echo $id_report;?></h4>
    

  </div>
</nav>


<div class="panel panel-success">
 <div class="panel-heading"><i class="fa fa-chain"></i></div>
  <div class="panel-body">
  <?php 
  $dbrpt->Query("SELECT max(YEARFULL) as YFULL FROM `z42_year`;");
  $arry=$dbrpt->Fetch_array();
  ?>
  <form class="form-inline"  role="form" name="fyear" id="fyear" action="" method="get" enctype="application/x-www-form-urlencoded" >
  <input type="hidden"name="idrep" id="idrep" value="<?php echo $id;?>"/>
  <input type="hidden" name="fdisp"id="fdisp" value="<?php echo $arrrpt['report_display'] ;?>"/>
  <input type="hidden"name="table" id="table" value="<?php echo $table;?>"/>
  <input type="hidden"name="age" id="age" value="<?php echo $age;?>"/>
  <span class="label label-info">ปีงบประมาณ</span>
 <select class="form-control" id="fy" name="fy">
<?PHP
	$year = date("Y")  ; 
	
	for ($i = 0; $i <= 5; $i++) {?>
    <option value="<?php echo $year ; ?>"><?php echo $year +543 ?></option>
	<?php $year++;}
?>
</select>
       	<button type="button" class="btn btn-info" onClick="Year_search();"><i class="fa fa-search" title="Search"></i></button>					
 </form>
  
  </div>
</div>
<div id="myShow"></div><!--<endshow-->
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
