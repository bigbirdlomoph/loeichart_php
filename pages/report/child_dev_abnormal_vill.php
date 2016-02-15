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

$id=$_GET['id'];//id report
$table=$_GET['table'];
$ampcode=$_GET['ampcode'];
$hospcode=$_GET['hospcode'];
$subdistid=$_GET['subdistid'];
$fyear=$_GET['fyear'];

 $dbrpt=new Database(DB_HOST_TK,DB_USER_TK,DB_PASS_TK,DB_NAME_TK);//new object 
?>
<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
  <div class="container">
    <?php
 //select name report
  $dbrpt->Query("SELECT * FROM z42_sys_report WHERE id='$id' ORDER BY cat_id");
    while($arrrpt=$dbrpt->Fetch_array()){
		
		?>
		<h4><?php echo $arrrpt['report_name'];?></h4>
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
          <th class="text-center">หมู่บ้าน</th>
          <th class="text-center">จำนวน/คน</td>


          </tr>
     </thead>
     <tbody>             
</tbody>
<?php

 $dbrpt->Query(" 
 SELECT 
tb1.villname as VILLNAME,
tb1.vhid as VHID,
tb1.CCA as CCA
FROM
(
	SELECT 
	cv.villname,
	a.vhid,
	COUNT(a.cid) as CCA
	FROM $table as a
	LEFT OUTER JOIN co_village_loei as cv ON a.vhid = cv.villid
	WHERE a.hospcode='".$hospcode."'
	GROUP BY a.vhid

) as tb1 

UNION ALL
SELECT 
'รวม',
'',
SUM(tb1.CCA) AS CCA
FROM
(
	SELECT 
	cv.villname,
	a.vhid,
	COUNT(a.cid) as CCA
	FROM $table as a
	LEFT OUTER JOIN co_village_loei as cv ON a.vhid = cv.villid
	WHERE a.hospcode='".$hospcode."'
	GROUP BY a.vhid

) as tb1 

 ");
while($arr_rs=$dbrpt->Fetch_array())
{
	//$ampcode=$arr_rs['AMP_CODE'];
?>    
	<tr>
       
		<td class="bg-info" align="center">
         <a href="child_dev_abnormal_vill_cid.php?hospcode=<?php echo $hospcode;?>&vhid=<?php echo $arr_rs['VHID'];?>&id=<?php echo $id;?>&table=<?php echo $table;?>&fyear=<?php echo $fyear;?>"><?php echo $arr_rs['VILLNAME']; ?></a> 
		</td>
         <td align="center">
         <?php echo $arr_rs['CCA'];?>
        </td>
      
	</tr>
 
<?php }?>   
</table>
<a href="javascript:history.go(-1)" class="btn btn-default btn-sm " role="button">Back</a>

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
