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
$tambon=$_GET['tambon'];
$o_year=$_GET['b_year']-1;
$b_year=$_GET['b_year'];
$ystr=$_GET['ystr'];;
$yend=$_GET['yend'];
$id=$_GET['id'];

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
<div class="panel-heading">ข้อมูล กลุ่มอายุ <?php echo $age;?> ปีขึ้นไป ระดับสถานบริการ 
<br>
 <a href="javascript:history.go(-1)" class="btn btn-default btn-sm " role="button">Back</a>
 <a href="../exportxls/age_group_vill_export_excel.php?id=<?php echo $id;?>&tambon=<?php echo $tambon;?>&table=<?php echo $table;?>&age=<?php echo $age;?>" class="btn btn-default btn-sm " role="button">Excel</a>
 </div>
 
<div class="panel-body">
<div class="table-responsive ">
<table class="table table-hover">
<thead>
          <tr>
              
             <th>ลำดับ</th>
             <th>รหัสพยาบาล</th>
             <th>สถานพยาบาล</th>
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
 $dbrpt->Query("
  SELECT 
										zag.HOSPCODE as HOSPCODE,
										42co.off_name as HOSPNAME,
										zag.HPID as HPID,
										zag.CID as CID,
										pr.prename as PRENAME,
										CONCAT(zag.NAME,'  ',zag.LNAME) AS FNAME,
										zag.BIRTH as BIRTH,
										zag.AGE as AGE,
										zag.HOUSE as HOUSE,
										zag.villname as VNAME,
										ztb.tambonname as TBNAME,
										zam.AMP_NAME as AMPNAME,
										CASE  WHEN zag.VILLAGE='01' THEN '1' 
										  WHEN zag.VILLAGE='02' THEN '2'
											WHEN zag.VILLAGE='03' THEN '3'
											WHEN zag.VILLAGE='04' THEN '4'
											WHEN zag.VILLAGE='05' THEN '5'
											WHEN zag.VILLAGE='06' THEN '6'
											WHEN zag.VILLAGE='07' THEN '7'
											WHEN zag.VILLAGE='08' THEN '8'
											WHEN zag.VILLAGE='09' THEN '9'
										  ELSE zag.VILLAGE END AS VNO,
										CONCAT(zag.TYPEAREA,'=',ct.typeareaname) as TYPENAME
										FROM $table as zag
										LEFT OUTER JOIN cprename as pr ON zag.PRENAME = pr.id_prename
										LEFT OUTER JOIN z42_tambon as ztb ON CONCAT(zag.CHANGWAT,zag.AMPUR,zag.TAMBON)=CONCAT(ztb.tamboncodefull)
										LEFT OUTER JOIN z42_amp AS zam ON  CONCAT(zag.CHANGWAT,AMPUR)=CONCAT(zam.AMP_CODE)
										LEFT OUTER JOIN 42co_office_loei as 42co ON zag.HOSPCODE=42co.off_id
										LEFT OUTER JOIN ctypearea as ct ON zag.TYPEAREA=ct.typeareacode
										WHERE CONCAT(zag.CHANGWAT,zag.AMPUR,zag.TAMBON) ='".$tambon."' AND AGE >='".$age."'GROUP BY zag.CID ORDER BY zag.HOSPCODE
 
 
 ");
while($arr_rs=$dbrpt->Fetch_array()){
	 
?>    
	<tr>
    		<td><?php echo  number_format($row ++);?></td>
	      <td><?php echo $arr_rs['HOSPCODE'];?></td>
          <td><?php echo $arr_rs['HOSPNAME'];?></td>
          <td><?php echo $arr_rs['HPID'];?></td>         
        <td><?php echo $arr_rs['CID'];?></td>
         <td><?php echo $arr_rs['PRENAME'];?></td>
           <td><?php echo $arr_rs['FNAME'];?></td>
        <td>
        <?php echo DateThai($arr_rs['BIRTH']) ?>
		</td>
          <td>
        <?php echo $arr_rs['AGE']; ?>
		</td>
         <td>
        <?php echo $arr_rs['HOUSE']; ?>
		</td>
         <td><?php echo $arr_rs['VNAME']; ?></td>
         <td><?php echo $arr_rs['VNO']; ?></td>
         <td><?php echo $arr_rs['TBNAME']; ?></td>
         <td><?php echo $arr_rs['AMPNAME']; ?></td>
         <td><?php echo $arr_rs['TYPENAME']; ?></td>
        
	</tr>
 
<?php } $dbrpt->Close_Conn();?>   
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
