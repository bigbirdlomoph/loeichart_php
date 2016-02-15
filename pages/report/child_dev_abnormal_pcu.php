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
$ampcode=$_GET['ampcode'];
$id=$_GET['id'];//id report
$table=$_GET['table'];
$fyear=$_GET['fyear'];
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
          <th class="text-center">สถานบริการ</th>
          <th class="text-center">จำนวน/คน</td>


          </tr>
     </thead>
     <tbody>             
</tbody>
<?php

 $dbrpt->Query("
  SELECT 
tb1.off_name as HOSPNAME,
tb1.hospcode as HOSPCODE,
tb1.CCA as CCA
FROM
(
	SELECT 
	cf.off_name ,
	a.hospcode,
	COUNT(a.cid) as CCA
	FROM $table as a
	LEFT OUTER JOIN z42_co_office_loei as cf ON a.hospcode = cf.off_id
	WHERE LEFT(a.vhid,4)='".$ampcode."'
	GROUP BY a.hospcode

) as tb1 

UNION ALL
SELECT 
'รวม',
'',
SUM(tb1.CCA) AS CCA

FROM
(
	SELECT 
	a.hospcode,
	COUNT(a.cid) as CCA
	FROM $table as a
	WHERE LEFT(a.vhid,4)='".$ampcode."'
	GROUP BY a.hospcode

) as tb1 

 ");
while($arr_rs=$dbrpt->Fetch_array())
{
	$ampcode=$arr_rs['AMP_CODE'];
?>    
	<tr>
       
		<td align="center">
         <a href="child_dev_abnormal_vill.php?id=<?php echo $id;?>&ampcode=<?php echo $ampcode;?>&hospcode=<?php echo $arr_rs['HOSPCODE'];?>&table=<?php echo $table?>&fyear=<?php echo $fyear;?>"><?php echo $arr_rs['HOSPNAME']; ?></a> 
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
