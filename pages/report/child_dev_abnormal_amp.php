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
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
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
    
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>          
</head>

<body>
<?php

$id=$_POST['id'];//id report
$age=$_POST['age'];
$table=$_POST['table'];
$fyear=$_POST['fy']+543;
//chk table
if($age==9){
	if($fyear==2558){
     	$table=$_POST['table'];
	}else{
		$table=substr($table=$_POST['table'],0,6).$age.substr($table=$_POST['table'],-9,9).'_'.substr($fyear,2,2);
	}
}else{
	if($fyear==2558){
     	$table=$_POST['table'];
	}else{
		$table=substr($table=$_POST['table'],0,6).$age.substr($table=$_POST['table'],-9,9).'_'.substr($fyear,2,2);
	}
		
	}
//
$m=date("m");
$y=date("Y");
 $dbrpt=new Database(DB_HOST_TK,DB_USER_TK,DB_PASS_TK,DB_NAME_TK);//new object 
?>
<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
  <div class="container">
    <?php
 //select name report
  $dbrpt->Query("SELECT * FROM z42_sys_report WHERE id='$id' ORDER BY cat_id");
    while($arrrpt=$dbrpt->Fetch_array()){
		
		?>
		<h4><?php echo $arrrpt['report_name'];?>  </h4>
		<?php
        }
 
?>
  </div>
</nav>


<!--<div class="panel panel-success">
 <div class="panel-heading"><i class="fa fa-chain"></i> กราฟ</div>
  <div class="panel-body">

  <?php //include("../chart/chart_anc12w_amp.php")?>
  
  </div>
</div>
<!---->
 <div class="panel panel-info">
  <div class="panel-heading"><?php echo $arrrpt['report_name']; ?></div>
     <div class="panel-body">
    <br>
<div class="table-responsive ">
<font size="1">
<table class="table table-bordered table-hover">
<thead>
          <tr class="bg-primary">
          <th class="text-center">อำเภอ</th>
          <th class="text-center">จำนวน/คน</td>


          </tr>
     </thead>
     <tbody>             
</tbody>
<?php

 $dbrpt->Query("
  SELECT 
tb1.AMP_NAME as AMP_NAME,
tb1.AMP_CODE as AMP_CODE,
tb1.CCA as CCA
FROM
(
SELECT 
co_d.distname as AMP_NAME,
co_d.distid as AMP_CODE,
COUNT(a.cid) as CCA
FROM $table as a
LEFT OUTER JOIN co_district as co_d ON LEFT(a.vhid,4)=co_d.distid
GROUP BY LEFT(a.vhid,4)

) as tb1 

UNION ALL
SELECT 
'รวม',
'',
SUM(tb1.CCA) AS CCA
FROM
(
SELECT 
co_d.distname as AMP_NAME,
co_d.distid as AMP_CODE,
COUNT(a.cid) as CCA
FROM $table as a
LEFT OUTER JOIN co_district as co_d ON LEFT(a.vhid,4)=co_d.distid
GROUP BY LEFT(a.vhid,4)

) as tb1 


 ");
while($arr_rs=$dbrpt->Fetch_array())
{
	$ampcode=$arr_rs['AMP_CODE'];
?>    
	<tr>
       
		<td align="center">
         <a href="javascript:popup('child_dev_abnormal_pcu.php?id=<?php echo $id;?>&ampcode=<?php echo $ampcode;?>&table=<?php echo $table;?>&fyear=<?php echo $fyear;?>','',960,500)"><?php echo $arr_rs['AMP_NAME']; ?></a> 
		</td>
        <td align="center">
         <?php echo $arr_rs['CCA'];?>
        </td>

	</tr>
 
<?php }?>   
</table>
</font>
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
