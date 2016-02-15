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
$subdistid=$_GET['tambon'];
$hcode=$_GET['hcode'];
$id=$_GET['id'];
$age=$_GET['age'];
$table=$_GET['table'];
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
<title>ข้อมูล กลุ่มอายุ <?php echo $age;?> ปีขึ้นไป ระดับหมู่บ้าน</title>
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
		?>
   
		<h4><?php echo $arrrpt['report_name'];?> </h4>
		<?php
        }
?>
</div>
  <div class="panel-body">
<div class="table-responsive ">
<table class="table table-hover">
<thead>
          <tr>
              
             <th>หมู่บ้าน</th>
           <th>จำนวนประชากร</th>
            <!--<th>ชาย</th>-->
             <th>หญิง</th>
          

          </tr>
     </thead>
     <tbody>             
</tbody>
<?php

 $dbrpt->query("
    SELECT 
      c.villname AS VNAME,a.VHID,
      SUM(CASE WHEN a.CID<>'' THEN 1 ELSE 0 END)AS POP_T,
      SUM(CASE WHEN a.CID<>'' AND a.SEX='2' THEN 1 ELSE 0 END)AS POP_FM
      FROM z42_age_group_3060_t a
      INNER JOIN loeichart.co_village_loei c ON c.villid=LEFT(a.VHID,8)
      WHERE LEFT(a.VHID,6)='$subdistid'
      GROUP BY c.villid
    UNION ALL
    SELECT 
      'TOTAL','',
      SUM(CASE WHEN a.CID<>'' THEN 1 ELSE 0 END)AS POP_T,
      SUM(CASE WHEN a.CID<>'' AND a.SEX='2' THEN 1 ELSE 0 END)AS POP_FM
      FROM z42_age_group_3060_t a
      INNER JOIN loeichart.co_village_loei c ON c.villid=LEFT(a.VHID,8)
      WHERE LEFT(a.VHID,6)='$subdistid'
  ");
while($arr_rs=$dbrpt->Fetch_array()){
	
?>    
	<tr>
		<td>
    <a href="javascript:popup('age_group_3060_cid.php?vhid=<?php echo $arr_rs['VHID'];?>&age=<?php echo $age;?>&table=<?php echo $table;?>','',960,500)"><?php echo $arr_rs['VNAME']; ?></a>     
		</td>
        <td>
        <?php echo $arr_rs['POP_T']; ?>
		</td>
        <!--<td>
        <?php echo $arr_rs['MALE']; ?>
        </td>-->
  		<td>
        <?php echo $arr_rs['POP_FM']; ?>
        </td>

	</tr>
 
<?php }?>   
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
