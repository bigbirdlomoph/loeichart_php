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
$hcode=$_GET['hcode'];
$tambon=$_GET['tambon'];
$table=$_GET['table'];
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
<title>ข้อมูล กลุ่มอายุ <?php echo $age_st;?> ถึง <?php echo $age_end;?> ปีขึ้นไป ระดับหมู่บ้าน</title>
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
<?php
///check age//
if($age_st=='0')
     {
	?>
</div>
  <div class="panel-body">
<div class="table-responsive ">
<table class="table table-bordered">
<thead>
          <tr class="success">
              
             <th class="text-center" rowspan="2">หมู่บ้าน</th>
           <th class="text-center" rowspan="2">จำนวนประชากร</th>
            <th class="text-center" rowspan="2">ชาย</th>
             <th class="text-center" rowspan="2">หญิง</th>
          	<th class="text-center" colspan="2">อายุ 9 เดือน</th>
            <th class="text-center" colspan="2">อายุ 18 เดือน</th>
            <th class="text-center" colspan="2">อายุ 30 เดือน</th>
            <th class="text-center" colspan="2">อายุ 42 เดือน</th>

          </tr>
 	   <tr class="success">
            <td class="text-center">ชาย</td>
            <td class="text-center">หญิง</td>
	         <td class="text-center">ชาย</td>
            <td class="text-center">หญิง</td>
            <td class="text-center">ชาย</td>
            <td class="text-center">หญิง</td>
            <td class="text-center">ชาย</td>
            <td class="text-center">หญิง</td>
    </tr>

     </thead>
     <tbody>             
</tbody>
 	<?php

 $dbrpt->GET_AGE_GROUP_CHW_VILL_M($table,$hcode,$age_st,$age_end);
		
while($arr_rs=$dbrpt->Fetch_array()){

?>    

    
    <tr>
     <?php 
	  if($arr_rs['VILLNAME']!='รวม'){
	  ?>
		<td class="text-center">
         <a href="age_group_chw_cid.php?vhid=<?php echo $arr_rs['VHID'];?>&age_st=<?php echo $age_st;?>&age_end=<?php echo $age_end?>&table=<?php echo $table?>"><?php echo $arr_rs['VILLNAME']; ?></a>     
		</td>
        <?php }else{?>
        <td align="center">
         <a href="age_group_chw_cid_all.php?id=<?php echo $id;?>&tambon=<?php echo $tambon;?>&table=<?php echo $table;?>&age_st=<?php echo $age_st;?>&age_end=<?php echo $age_end;?>"><?php echo $arr_rs['VILLNAME']; ?></a>     
		</td>
        <?php }?>
        <td class="text-center">
        <?php echo number_format($arr_rs['SUMMARY']); ?>
		</td>
        <td class="text-center">
        <?php echo number_format($arr_rs['MALE']); ?>
        </td>
  		<td class="text-center">
        <?php echo number_format($arr_rs['FEMALE']); ?>
        </td>
        <td class="text-center">
        <?php echo number_format($arr_rs['AGE_MALE_M9']); ?>
        </td>
        <td class="text-center">
        <?php echo number_format($arr_rs['AGE_FEMALE_M9']); ?>
        </td>
         <td class="text-center">
        <?php echo number_format($arr_rs['AGE_MALE_M18']); ?>
        </td>
        <td class="text-center">
        <?php echo number_format($arr_rs['AGE_FEMALE_M18']); ?>
        </td>
        <td class="text-center">
        <?php echo number_format($arr_rs['AGE_MALE_M30']); ?>
        </td>
        <td class="text-center">
        <?php echo number_format($arr_rs['AGE_FEMALE_M30']); ?>
        </td>
         <td class="text-center">
        <?php echo number_format($arr_rs['AGE_MALE_M42']); ?>
        </td>
        <td class="text-center">
        <?php echo number_format($arr_rs['AGE_FEMALE_M42']); ?>
        </td>

	</tr>

<?php } $dbrpt->Close_Conn();?>   
</table>
	 
<?php	 
}###############################################################end age month########################################
else
{
?>
</div>
  <div class="panel-body">
<div class="table-responsive ">
<table class="table table-hover">
<thead>
          <tr>
              
             <th>หมู่บ้าน</th>
           <th>จำนวนประชากร</th>
            <th>ชาย</th>
             <th>หญิง</th>
          

          </tr>
     </thead>
     <tbody>             
</tbody>
<?php

 $dbrpt->GET_AGE_GROUP_CHW_VILL($table,$hcode,$age_st,$age_end);
		
while($arr_rs=$dbrpt->Fetch_array()){

?>    
 	
    <tr>
     <?php 
	  if($arr_rs['VILLNAME']!='รวม'){
	  ?>
		<td>
         <a href="age_group_chw_cid.php?vhid=<?php echo $arr_rs['VHID'];?>&age_st=<?php echo $age_st;?>&age_end=<?php echo $age_end?>&table=<?php echo $table?>"><?php echo $arr_rs['VILLNAME']; ?></a>     
		</td>
        <?php }else{?>
        <td>
         <a href="age_group_chw_cid_all.php?id=<?php echo $id;?>&tambon=<?php echo $tambon;?>&table=<?php echo $table;?>&age_st=<?php echo $age_st;?>&age_end=<?php echo $age_end;?>"><?php echo $arr_rs['VILLNAME']; ?></a>      
		</td>
		<?php }?>
        <td>
        <?php echo number_format($arr_rs['SUMMARY']); ?>
		</td>
        <td>
        <?php echo number_format($arr_rs['MALE']); ?>
        </td>
  		<td>
        <?php echo number_format($arr_rs['FEMALE']); ?>
        </td>

	</tr>

<?php } $dbrpt->Close_Conn();?>   
</table>
<?php
}	///end check age//
?>
</div>
</div>
</div>
<!--contex-->
<ul id="contextMenu" class="dropdown-menu" role="menu" style="display:none" >
    <li><a tabindex="-1" href="#"></a></li>
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
