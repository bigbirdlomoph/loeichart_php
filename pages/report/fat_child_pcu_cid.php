<?php
session_start() ;
if (!isset($_SESSION['login_true'])) {
     header("Location: login.php");//สั่งให้ redirect ไปหน้า login เมื่อไม่มีการ login แต่เรียกใช้หน้านี้
     exit;
}

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<title>fatchild</title>
    <!-- Core CSS - Include with every page -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../font-awesome/css/font-awesome.css" rel="stylesheet">

    <!-- Page-Level Plugin CSS - Dashboard -->
    <link href="../css/plugins/morris/morris-0.4.3.min.css" rel="stylesheet">
    <link href="../css/plugins/timeline/timeline.css" rel="stylesheet">

    <!-- SB Admin CSS - Include with every page -->
    <link href="../css/sb-admin.css" rel="stylesheet">
</head>

<body>
<?php
function __autoload($class_name){
	include'../class/class.'.$class_name.'.php';
}
set_time_limit(0);
include"../config/config.php";
?>
<?php
$hcode=$_GET['hcode'];
$id=$_GET['id'];
$o_year=$_GET['b_year']-1;
$b_year=$_GET['b_year'];
$ystr=$_GET['ystr'];;
$yend=$_GET['yend'];
$age=$_GET['age'];
if($age=='5'){$rename="0-5 ปี";}else{$rename="6-14 ปี";}
//
$dbrpt=new Database(DB_HOST_TK,DB_USER_TK,DB_PASS_TK,DB_NAME_TK);//new object 

?>
<div class="panel panel-info">
<div class="panel-heading">
<?php
//select name report
  $dbrpt->Query("SELECT * FROM z42_sys_report WHERE id='$id' ORDER BY source_table");
    while($arrrpt=$dbrpt->Fetch_array()){
		?>
   
		<h4><?php echo $arrrpt['report_name'];?> <?php echo $rename;?> วันที่ : <?php echo substr($ystr,8,2);?> /<?php echo substr($ystr,5,2);?> /<?php echo $o_year+543;?> ถึง <?php echo substr($yend,8,2);?> /<?php echo substr($yend,5,2);?> /<?php echo $b_year+543;?></h4>
		<?php
        }
?>
</div>
  <div class="panel-body">
<div class="table-responsive ">
<table class="table table-hover">
<thead>
          <tr>
              
             <th>รหัสพยาบาล</th>
             <th>CID</th>
             <th>ชื่อ-สกุล</th>
             <th>วันเดือนปีเกิด</th>
             <th>อายุ</th>
             <th>อายุที่มาชั่งน้ำหนัก</th>
             <th>วันมารับบริการ</th>
             <th>บ้านเลขที่</th>
             <th>VHID</th>
             <th>หมู่บ้าน</th>
             

          </tr>
     </thead>
     <tbody>             
</tbody>
<?php
if($age=='6'){
 $dbrpt->Query("
			SELECT 
				znut.HOSPCODE as HCODE,
				znut.CID as CID,
				CONCAT(znut.`name`,' ',znut.lname) as FULLNAME,
				znut.birth as BIRTH,
				znut.age_now as AGE,
        		znut.age_service as AGE_SERVICE,
				znut.nutridate_serv as DATESERV,
				znut.HOUSE as HOUSE,
				znut.VHID as VHID,
				cvl.villname as VILLNAME
				FROM z42_nutri_t AS znut
				INNER JOIN co_village_loei as cvl ON znut.VHID=cvl.villid AND znut.HOSPCODE=cvl.hospcode
				WHERE znut.nutridate_serv BETWEEN '$ystr' AND'$yend' and znut.hospcode='$hcode' 
				AND age_service IN('6','7','8','9','10','11','12','13','14') AND znut.level_hw IN('5','6')


				");
}else{

 $dbrpt->Query("
				SELECT 
				znut.HOSPCODE as HCODE,
				znut.CID as CID,
				CONCAT(znut.`name`,' ',znut.lname) as FULLNAME,
				znut.birth as BIRTH,
				znut.age_now as AGE,
                znut.age_service as AGE_SERVICE,
				znut.nutridate_serv as DATESERV,
				znut.HOUSE as HOUSE,
				znut.VHID as VHID,
				cvl.villname as VILLNAME
				FROM z42_nutri_t AS znut
				INNER JOIN co_village_loei as cvl ON znut.VHID=cvl.villid AND znut.HOSPCODE=cvl.hospcode
				WHERE znut.nutridate_serv BETWEEN '$ystr' AND'$yend' and znut.hospcode='$hcode' 
				AND age_service IN('0','1','2','3','4','5') AND znut.level_hw IN('5','6')

				");
}
while($arr_rs=$dbrpt->Fetch_array()){
	
?>    
	<tr>
		
        <td><?php echo $arr_rs['HCODE'];?></td>
        <td>
        <?php echo $arr_rs['CID']; ?>
		</td>
          <td>
        <?php echo $arr_rs['FULLNAME']; ?>
		</td>

         <td>
        <?php echo $arr_rs['BIRTH']; ?>
		</td>
        <td>
        <?php echo $arr_rs['AGE']; ?>
		</td>
            <td>
        <?php echo $arr_rs['AGE_SERVICE']; ?>
		</td>
            <td>
        <?php echo $arr_rs['DATESERV']; ?>
		</td>
         <td>
        <?php echo $arr_rs['HOUSE']; ?>
		</td>
        <td>
        <?php echo $arr_rs['VHID']; ?>
		</td>
          <td>
        <?php echo $arr_rs['VILLNAME']; ?>
		</td>

	</tr>
 
<?php }?> 
</table>
</div>
</div>
</div>



<!-- Core Scripts - Include with every page -->
    <script src="../js/jquery-1.10.2.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/plugins/metisMenu/jquery.metisMenu.js"></script>

    <!-- Page-Level Plugin Scripts - Dashboard -->
    <script src="../js/plugins/morris/raphael-2.1.0.min.js"></script>
    <script src="../js/plugins/morris/morris.js"></script>

    <!-- SB Admin Scripts - Include with every page -->
    <script src="../js/sb-admin.js"></script>
    <script src="../js/back-to-top.js"></script>

    <!-- Page-Level Demo Scripts - Dashboard - Use for reference -->
    <script src="../js/demo/dashboard-demo.js"></script>

</body>
</html>
