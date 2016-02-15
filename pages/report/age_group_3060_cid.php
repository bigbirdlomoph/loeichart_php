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
include"../function/function.php";
$vhid=$_GET['vhid'];
$age=$_GET['age'];
$table=$_GET['table'];
$o_year=$_GET['b_year']-1;
$b_year=$_GET['b_year'];
$ystr=$_GET['ystr'];;
$yend=$_GET['yend'];

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
<title>ข้อมูล กลุ่มอายุ <?php echo $age;?> ปีขึ้นไป ระดับสถานบริการ</title>
   

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
<div class="panel-heading">ข้อมูล กลุ่มอายุ <?php echo $age;?> ปีขึ้นไป ระดับสถานบริการ</div>
<div class="panel-body">
<div class="table-responsive ">
<table class="table table-hover">
<thead>
          <tr>
              
             <th>ลำดับ</th>
             <th>รหัสสถานพยาบาล</th>
             <!--<th>หมู่บ้าน</th>-->
             <th>HPID</th>
             <th>CID</th>
              <th>คำนำหน้า</th>
             <th>ชื่อ-สกุล</th>
             <th>วันเดือนปีเกิด</th>
             <th>อายุ</th>
              <th>บ้านเลขที่</th>
               <th>หมู่บ้าน</th>
                <th>หมู่ที่</th>
               <th>ตำบล</th>
                <th>อำเภอ</th>
                 <th>TYPE AREA</th>

          </tr>
     </thead>
     <tbody>             
</tbody>
<?php
$row=1;
 $dbrpt->query("
        SELECT 
            a.HOSPCODE,a.HPID,a.CID,cp.prename AS PRENAME,
            CONCAT(a.`NAME`,' ',a.LNAME)AS FULLNAME,a.BIRTH,a.AGE,
            IF(a.SEX='2','หญิง',NULL)AS SEX,
            a.HOUSE,a.VILLAGE,c.villname AS VNAME,c2.subdistname AS TBNAME,
            c3.AMP_NAME,a.VHID,t.typeareaname AS TYPENAME
        FROM z42_age_group_3060_t a
        INNER JOIN loeichart.z42_co_village c ON c.villid=LEFT(a.VHID,8)
        INNER JOIN loeichart.z42_co_subdistrict c2 ON c2.subdistid=LEFT(a.VHID,6)
        INNER JOIN loeichart.z42_amp c3 ON c3.AMP_CODE=LEFT(a.VHID,4)
        INNER JOIN loeichart.cprename cp ON cp.id_prename=a.PRENAME
        INNER JOIN loeichart.ctypearea t ON t.typeareacode=a.TYPEAREA
        WHERE LEFT(a.VHID,8)='$vhid'
        AND a.SEX='2'
        GROUP BY a.CID
    ");
while($arr_rs=$dbrpt->Fetch_array()){
	 
?>    
	<tr>
    		<td><?php echo $row ++;?></td>
	      <td><?php echo $arr_rs['HOSPCODE'];?></td>
          <!--<td><?php echo $arr_rs['VNAME'];?></td>-->
          <td><?php echo $arr_rs['HPID'];?></td>         
        <td><?php echo $arr_rs['CID'];?></td>
         <td><?php echo $arr_rs['PRENAME'];?></td>
           <td><?php echo $arr_rs['FULLNAME'];?></td>
        <td><?php echo DateThai($arr_rs['BIRTH']) ?></td>
          <td><?php echo $arr_rs['AGE']; ?></td>
         <td><?php echo $arr_rs['HOUSE']; ?></td>
         <td><?php echo $arr_rs['VNAME']; ?></td>
         <td><?php echo $arr_rs['VILLAGE']; ?></td>
         <td><?php echo $arr_rs['TBNAME']; ?></td>
         <td><?php echo $arr_rs['AMP_NAME']; ?></td>
         <td><?php echo $arr_rs['TYPENAME']; ?></td>
        
	</tr>
 
<?php }?>   
</table>

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
