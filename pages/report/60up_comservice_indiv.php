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
include"../function/function.php"
////

?>
<?php
$vhid=$_GET['vhid'];
$hospcode=$_GET['hospcode'];
$tcode=$_GET['tcode'];
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
		<h4><?php echo $arrrpt['report_name'];?> 
        <a href="../exportxls/60up_comservice_indiv_export_excel.php?id=<?php echo $id;?>&hospcode=<?php echo $hospcode;?>&vhid=<?php echo $vhid;?>" class="btn btn-default btn-sm " role="button">Excel</a>
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
              
             <th>ลำดับ</th>
             <th>เลขบัตรประชาชน</th>
             <th>คำนำหน้า</th>				 
             <th>ชื่อ</th>	 
             <th>นามสกุล</th>
             <th>วันเกิด</th>	
			 <th>อายุ</th>             
             <th>วันที่ให้บริการ</th>
             <th>รหัสการให้บริการ</th>
             <th>กิจกรรมการให้บริการในชุมชน</th>                                 
			 <th>บ้านเลขที่</th>
			 <th>รหัสหมู่บ้าน</th>
             <th>TYPEAREA</th>              
             <th>วันที่ประมวลผล</th>           	
			 
          </tr>
     </thead>
     <tbody>             
</tbody>
<?php

 $i=1; 
 $dbrpt->Query("select * from z42_60up_comservice_t where HOSPCODE=$hospcode and VHID=$vhid and DATE_SERV is not null ORDER BY CID,DATE_SERV");
while($arr_rs=$dbrpt->Fetch_array())
{
	
?>    
	<tr>

		<td>
        <?php echo $i++; ?>
		</td>        		
		<td>
        <?php echo  $arr_rs['CID']; ?>
		</td>
        <td>
        <?php echo  $arr_rs['PRENAME']; ?>
		</td>
		<td>
        <?php echo  $arr_rs['NAME']; ?>
		</td>
        <td>
        <?php echo  $arr_rs['LNAME']; ?>
		</td>
		<td>
        <?php echo DateThai($arr_rs['BIRTH']); ?>
		</td>
		<td>
        <?php echo  $arr_rs['AGE']; ?>
		</td>        
		<td>
        <?php echo  DateThai($arr_rs['DATE_SERV']); ?>
		</td>
        <td>
        <?php echo  $arr_rs['COMSERVICE']; ?>
		</td>
        <td>
        <?php echo  $arr_rs['COMSERV_NAME']; ?>
		</td>             
		<td>
        <?php echo  $arr_rs['HOUSE']; ?>
		</td>
		<td>
        <?php echo  $arr_rs['VHID']; ?>
		</td>
        <td>
        <?php echo  $arr_rs['TYPEAREA']; ?>
		</td>
		<td>
        <?php echo  DateThai($arr_rs['DUPDATE']); ?>
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
