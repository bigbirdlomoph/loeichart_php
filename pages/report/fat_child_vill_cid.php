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
$vhid=$_GET['vhid'];
$hcode=$_GET['hcode'];
$id=$_GET['id'];
$o_year=$_GET['b_year']-1;
$b_year=$_GET['b_year'];
$ystr=$_GET['ystr'];;
$yend=$_GET['yend'];
$age=$_GET['age'];
$i=1;
if($age=='5'){$rename="5-14 ปี";}else{$rename="0-5 ปี";}
//
$dbrpt=new Database(DB_HOST_TK,DB_USER_TK,DB_PASS_TK,DB_NAME_TK);//new object 

?>
<div class="panel panel-info">
<div class="panel-heading">

<a href="javascript:history.go(-1)" class="btn btn-default btn-sm " role="button">Back</a>
</div>
  <div class="panel-body">
<div class="table-responsive ">
<table class="table table-bordered table-hover">
<thead>
          <tr>
             <th>ลำดับ</th>  
             <th>รหัสพยาบาล</th>
             <th>CID</th>
             <th>ชื่อ-สกุล</th>
             <th>วันเดือนปีเกิด</th>
             <th>อายุเดือน</th>
              <th>น้ำหนัก</th>
               <th>ส่วนสูง</th>
               <th>พัฒนาการ</th>
             <th>วันมารับบริการ</th>
             <th>บ้านเลขที่</th>
             <th>VHID</th>
             <th>หมู่บ้าน</th>
             

          </tr>
     </thead>
     <tbody>             
</tbody>
<?php
if($age=='5'){
 $dbrpt->Query("
			    SELECT 
				znut.HOSPCODE as HCODE,
				znut.CID as CID,
				CONCAT(znut.`name`,' ',znut.lname) as FULLNAME,
				znut.birth as BIRTH,
				znut.agemonth as AGE,
				znut.nutridate_serv as DATESERV,
				znut.weight as weight,
				znut.height  as height,
				case when znut.childdev = '1' then 'ปกติ'
				  when  znut.childdev = '2' then 'สงสัยล่าช้า'
				  when  znut.childdev = '3' then 'ล่าช้า'
				  when  znut.childdev = '0' then 'ไม่ตรวจ'
				  ELSE 'ไม่ตรวจ'  END as  childdev,
				  
				znut.HOUSE as HOUSE,
				znut.VHID as VHID,
				cvl.villname as VILLNAME
				FROM z42_nutri_person_5_14 AS znut
				LEFT OUTER JOIN co_village_loei as cvl ON znut.VHID=cvl.villid AND znut.HOSPCODE=cvl.hospcode
				WHERE znut.nutridate_serv BETWEEN '$ystr' AND'$yend' and znut.hospcode='$hcode' AND znut.level_hw IN('1','2','3','4','5','6') AND vhid='$vhid'
				");
}else{

 $dbrpt->Query("
				SELECT 
				znut.HOSPCODE as HCODE,
				znut.CID as CID,
				CONCAT(znut.`name`,' ',znut.lname) as FULLNAME,
				znut.birth as BIRTH,
				znut.agemonth as AGE,
				znut.nutridate_serv as DATESERV,
				znut.weight as weight,
				znut.height  as height,
				case when znut.childdev = '1' then 'ปกติ'
				  when  znut.childdev = '2' then 'สงสัยล่าช้า'
				  when  znut.childdev = '3' then 'ล่าช้า'
				  when  znut.childdev = '0' then 'ไม่ตรวจ'
				  ELSE 'ไม่ตรวจ'  END as  childdev,
				  
				znut.HOUSE as HOUSE,
				znut.VHID as VHID,
				cvl.villname as VILLNAME
				FROM z42_nutri_person_0_5 AS znut
				LEFT OUTER JOIN co_village_loei as cvl ON znut.VHID=cvl.villid AND znut.HOSPCODE=cvl.hospcode
				WHERE znut.nutridate_serv BETWEEN '$ystr' AND'$yend' and znut.hospcode='$hcode' AND znut.level_hw IN('1','2','3','4','5','6') AND vhid='$vhid'

				");
}

while($arr_rs=$dbrpt->Fetch_array()){
	
?>    
	<tr>
		<td><?php echo $i++;?></td>
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
        <?php echo $arr_rs['weight']; ?>
		</td>
                 <td>
        <?php echo $arr_rs['height']; ?>
		</td>
          <td>
        <?php echo $arr_rs['childdev']; ?>
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
