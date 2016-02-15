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
              
             <th>สถานบริการ</th>
             <th>ผู้สูงอายุ_ชาย</th>
             <th>ผู้สูงอายุ_หญิง</th>
             <th>ผู้สูงอายุ_รวม</th>
		     <th>ผู้ป่วยโรคเรื้อรัง_ชาย</th>
		     <th>ผู้ป่วยโรคเรื้อรัง_หญิง</th>
             <th>ผู้ป่วยโรคเรื้อรัง_รวม</th>
 		     <th>DM_ชาย</th>
		     <th>DM_หญิง</th>
             <th>DM_รวม</th>
             <th>HT_ชาย</th>
		     <th>HT_หญิง</th>
             <th>HT_รวม</th>
             <th>หัวใจขาดเลือด_ชาย</th>
		     <th>หัวใจขาดเลือด_หญิง</th>
             <th>หัวใจขาดเลือด_รวม</th>
             <th>หลอดเลือดสมอง_ชาย</th>
		     <th>หลอดเลือดสมอง_หญิง</th>
             <th>หลอดเลือดสมอง_รวม</th>              
             <th>โรคหัวใจ_ชาย</th>
		     <th>โรคหัวใจ_หญิง</th>
             <th>โรคหัวใจ_รวม</th>              
             <th>ถุงลมปอดโป่งพอง_ชาย</th>
		     <th>ถุงลมปอดโป่งพอง_หญิง</th>
             <th>ถุงลมปอดโป่งพอง_รวม</th>              
             <th>หอบหืด_ชาย</th>
		     <th>หอบหืด_หญิง</th>
             <th>หอบหืด_รวม</th>              
             <th>ไตวาย_ชาย</th>
		     <th>ไตวาย_หญิง</th>
             <th>ไตวาย_รวม</th>
             <th>ซึมเศร้า_ชาย</th>
		     <th>ซึมเศร้า_หญิง</th>
             <th>ซึมเศร้า_รวม</th>
             <th>ข้อเสื่อม_ชาย</th>
		     <th>ข้อเสื่อม_หญิง</th>
             <th>ข้อเสื่อม_รวม</th>                           
             <th>มากกว่า 1 โรค_ชาย</th>
		     <th>มากกว่า 1 โรค_หญิง</th>
             <th>มากกว่า 1 โรค_รวม</th>

          </tr>
     </thead>
     <tbody>             
</tbody>
<?php

 $dbrpt->Query("select * from z42_60up_chronic_pcu_s where ampcode=$ampcode");
while($arr_rs=$dbrpt->Fetch_array())
{
	
?>    
	<tr>
		<td>
         <a href="60up_chronic_tambon.php?ampcode=<?php echo $arr_rs['AMPCODE'];?>&id=<?php echo $id;?>&hospcode=<?php echo $arr_rs['HOSPCODE']?>"><?php echo $arr_rs['HOSPNAME']; ?></a>           
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
        <?php echo  number_format($arr_rs['CHRONIC_M']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['CHRONIC_FM']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['CHRONIC_TT']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['DM_M']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['DM_FM']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['DM_TT']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['HT_M']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['HT_FM']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['HT_TT']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['ISCHAEMIC_M']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['ISCHAEMIC_FM']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['ISCHAEMIC_TT']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['CVD_M']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['CVD_FM']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['CVD_TT']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['HEART_M']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['HEART_FM']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['HEART_TT']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['EMPHYSEMA_M']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['EMPHYSEMA_FM']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['EMPHYSEMA_TT']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['ASTHMA_M']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['ASTHMA_FM']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['ASTHMA_TT']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['RENAL_FAILURE_M']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['RENAL_FAILURE_FM']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['RENAL_FAILURE_TT']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['DEPRESS_M']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['DEPRESS_FM']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['DEPRESS_TT']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['ARTHROSIS_M']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['ARTHROSIS_FM']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['ARTHROSIS_TT']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['MORE1_M']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['MORE1_FM']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['MORE1_TT']); ?>
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
