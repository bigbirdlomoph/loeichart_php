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
include "../function/function.php";
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
$hcode=$_GET['hospcode'];
$id=$_GET['id'];
$table=$_GET['table'];
$age=$_GET['age'];
$fyear=$_GET['fyear'];
$i=1;

$dbrpt=new Database(DB_HOST_TK,DB_USER_TK,DB_PASS_TK,DB_NAME_TK);//new object 

?>

<div class="panel panel-info">
<div class="panel-heading">
<?php
 //select name report
  $dbrpt->Query("SELECT * FROM z42_sys_report WHERE id='$id' ORDER BY cat_id");
    while($arrrpt=$dbrpt->Fetch_array()){
		
		?>
		<h4>
		<?php echo $arrrpt['report_name'];?>
        <a href="../exportxls/child_develop_abnormal_cid_export_excel.php?id=<?php echo $id?>&age=<?php echo $age?>&table=<?php echo $table?>&hospcode=<?php echo $hcode;?>&vhid=<?php echo $vhid;?>"class="btn btn-default btn-sm " role="button">
   ส่งออก Excel
   </a>
        </h4>
		<?php
        }
 
?>

</div>
  <div class="panel-body">
<div class="table-responsive ">
<font size="1">
<table class="table table-bordered table-hover">
<thead>
          <tr class="bg-success">
          <th rowspan="3" class="text-center">ลำดับ</th> 
          <th colspan="14"></th> 
           <th colspan="6" class="text-center"><?php echo $fyear-1;?></th>
           <th colspan="18" class="text-center"><?php echo $fyear;?></th> 
           <th colspan="6"></th> 
          </tr>
          <tr class="bg-primary">
             <th colspan="14"></th>
             <th colspan="2" class="text-center">ต.ค.</th>
             <th colspan="2" class="text-center">พ.ย.</th>
             <th colspan="2" class="text-center">ธ.ค.</th>
              <th colspan="2" class="text-center">ม.ค.</th>
             <th colspan="2" class="text-center">ก.พ.</th>
             <th colspan="2" class="text-center">มี.ค.</th>
             <th colspan="2"class="text-center" >เม.ย.</th>
             <th colspan="2" class="text-center">พ.ค.</th>
             <th colspan="2" class="text-center">มิ.ย.</th>
             <th colspan="2" class="text-center">ก.ค.</th>
             <th colspan="2" class="text-center">ส.ค.</th>
             <th colspan="2" class="text-center">ก.ย.</th>
             <th colspan="6"></th>
          </tr>
          <tr class="bg-primary">
              
             <th>รหัสพยาบาล</th>
             <th>PID</th>
             <th>ชื่อ-สกุล</th>
              <th>สถานบริการที่เกิด</th>
             <th>วันเดือนปีเกิด</th>
             <th>อายุเดือน</th>
              <th>น้ำหนักแรกเกิด</th>
              <th>สถานบริการที่ลง ASPHYXAI</th>
               <th>ASPHYXAI</th>
               <th>สถานบริการที่วินิจฉัย</th>
               <th>Diag</th>
               <th>วันที่ Diag</th>
               <th>พัฒนาการ</th>
                <th>วันที่ตรวจ</th>
                
               <th>วันที่ตรวจ</th>
               <th>พัฒนาการ</th>
               <th>วันที่ตรวจ</th>
               <th>พัฒนาการ</th>
               <th>วันที่ตรวจ</th>
               <th>พัฒนาการ</th>
               <th>วันที่ตรวจ</th>
               <th>พัฒนาการ</th>
               <th>วันที่ตรวจ</th>
               <th>พัฒนาการ</th>
               <th>วันที่ตรวจ</th>
               <th>พัฒนาการ</th>
               <th>วันที่ตรวจ</th>
               <th>พัฒนาการ</th>
               <th>วันที่ตรวจ</th>
               <th>พัฒนาการ</th>
               <th>วันที่ตรวจ</th>
               <th>พัฒนาการ</th>
               <th>วันที่ตรวจ</th>
               <th>พัฒนาการ</th>
               <th>วันที่ตรวจ</th>
               <th>พัฒนาการ</th>
               <th>วันที่ตรวจ</th>
               <th>พัฒนาการ</th>
             <th>มารดา</th>
             <th>บ้านเลขที่</th>
             <th>หมู่ที่</th>
             <th>หมู่บ้าน</th>
              <th>ตำบล</th>
              <th>อำเภอ</th>
             

          </tr>
     </thead>
     <tbody>             
</tbody>
<?php

 $dbrpt->Query("
SELECT 				
a.hospcode as HOSPCODE,
a.pid as PID,
CONCAT(a.`name`,' ',a.lname) as FNAME,
a.hospcode_nb as HOSNB,
a.birth as BIRTH,
a.agemonth as AGEM,
a.namemother as MOM,
a.bweight as BW,
a.hospcode_dx as HOS_DX,
			CASE WHEN a.asphyxia='1' THEN 'ขาด' 
			WHEN a.asphyxia='2' THEN 'ไม่ขาด'
			WHEN a.asphyxia='9' THEN 'ไม่ทราบ'
			ELSE '' END AS SPHY,
a.hospcode_dxdv as HCOD_DXDV,#รพ
a.diagdv as diagdv,
a.date_diagdv as date_diagdv,
CASE WHEN a.childdevelop_2_3 ='1' THEN 'ปกติ' 
			WHEN a.childdevelop_2_3 ='2' THEN 'สงสัยช้ากว่าปกติ'
			WHEN a.childdevelop_2_3 ='3' THEN 'ช้ากว่าปกติ'
			WHEN a.childdevelop_2_3 ='' THEN ''			
			ELSE a.childdevelop_2_3  END AS CHD23,
a.nutridate_serv_2_3 as ndate_serv23,

#m10
CASE WHEN a.childdevelop10 ='1' THEN 'ปกติ' 
			WHEN a.childdevelop10 ='2' THEN 'สงสัยช้ากว่าปกติ'
			WHEN a.childdevelop10 ='3' THEN 'ช้ากว่าปกติ'
			WHEN a.childdevelop10 ='' THEN ''			
			ELSE a.childdevelop10  END AS ch_dev10,
a.nutridate_serv10  as M10,
#m11
CASE WHEN a.childdevelop11 ='1' THEN 'ปกติ' 
			WHEN a.childdevelop11 ='2' THEN 'สงสัยช้ากว่าปกติ'
			WHEN a.childdevelop11 ='3' THEN 'ช้ากว่าปกติ'
			WHEN a.childdevelop11 ='' THEN ''			
			ELSE a.childdevelop11  END AS ch_dev11,
a.nutridate_serv11  as M11,
#m12
CASE WHEN a.childdevelop12 ='1' THEN 'ปกติ' 
			WHEN a.childdevelop12 ='2' THEN 'สงสัยช้ากว่าปกติ'
			WHEN a.childdevelop12 ='3' THEN 'ช้ากว่าปกติ'
			WHEN a.childdevelop12 ='' THEN ''			
			ELSE a.childdevelop12  END AS ch_dev12,
a.nutridate_serv12  as M12,
#m1
CASE WHEN a.childdevelop01 ='1' THEN 'ปกติ' 
			WHEN a.childdevelop01 ='2' THEN 'สงสัยช้ากว่าปกติ'
			WHEN a.childdevelop01 ='3' THEN 'ช้ากว่าปกติ'
			WHEN a.childdevelop01 ='' THEN ''			
			ELSE a.childdevelop01  END AS ch_dev1,
a.nutridate_serv01  as M1,
#m2
CASE WHEN a.childdevelop02 ='1' THEN 'ปกติ' 
			WHEN a.childdevelop02 ='2' THEN 'สงสัยช้ากว่าปกติ'
			WHEN a.childdevelop02 ='3' THEN 'ช้ากว่าปกติ'
			WHEN a.childdevelop02 ='' THEN ''			
			ELSE a.childdevelop02  END AS ch_dev2,
a.nutridate_serv02  as M2,
#m3
CASE WHEN a.childdevelop03 ='1' THEN 'ปกติ' 
			WHEN a.childdevelop03 ='2' THEN 'สงสัยช้ากว่าปกติ'
			WHEN a.childdevelop03 ='3' THEN 'ช้ากว่าปกติ'
			WHEN a.childdevelop03 ='' THEN ''			
			ELSE a.childdevelop03  END AS ch_dev3,
a.nutridate_serv03  as M3,
#m4
CASE WHEN a.childdevelop04 ='1' THEN 'ปกติ' 
			WHEN a.childdevelop04 ='2' THEN 'สงสัยช้ากว่าปกติ'
			WHEN a.childdevelop04 ='3' THEN 'ช้ากว่าปกติ'
			WHEN a.childdevelop04 ='' THEN ''			
			ELSE a.childdevelop04  END AS ch_dev4,
a.nutridate_serv04  as M4,
#m5
CASE WHEN a.childdevelop05 ='1' THEN 'ปกติ' 
			WHEN a.childdevelop05 ='2' THEN 'สงสัยช้ากว่าปกติ'
			WHEN a.childdevelop05 ='3' THEN 'ช้ากว่าปกติ'
			WHEN a.childdevelop05 ='' THEN ''			
			ELSE a.childdevelop05  END AS ch_dev5,
a.nutridate_serv05  as M5,
#m6
CASE WHEN a.childdevelop06 ='1' THEN 'ปกติ' 
			WHEN a.childdevelop06 ='2' THEN 'สงสัยช้ากว่าปกติ'
			WHEN a.childdevelop06 ='3' THEN 'ช้ากว่าปกติ'
			WHEN a.childdevelop06 ='' THEN ''			
			ELSE a.childdevelop06  END AS ch_dev6,
a.nutridate_serv06  as M6,
#m7
CASE WHEN a.childdevelop07 ='1' THEN 'ปกติ' 
			WHEN a.childdevelop07 ='2' THEN 'สงสัยช้ากว่าปกติ'
			WHEN a.childdevelop07 ='3' THEN 'ช้ากว่าปกติ'
			WHEN a.childdevelop07 ='' THEN ''			
			ELSE a.childdevelop07  END AS ch_dev7,
a.nutridate_serv07  as M7,
#m9
CASE WHEN a.childdevelop09 ='1' THEN 'ปกติ' 
			WHEN a.childdevelop09 ='2' THEN 'สงสัยช้ากว่าปกติ'
			WHEN a.childdevelop09 ='3' THEN 'ช้ากว่าปกติ'
			WHEN a.childdevelop09 ='' THEN ''			
			ELSE a.childdevelop09  END AS ch_dev9,
a.nutridate_serv09  as M9,
a.HOUSE as HOUSE,
				CASE WHEN RIGHT(a.vhid,2)='01' THEN '1' 
				  WHEN RIGHT(a.vhid,2)='02' THEN '2'
					WHEN RIGHT(a.vhid,2)='03' THEN '3'
					WHEN RIGHT(a.vhid,2)='04' THEN '4'
					WHEN RIGHT(a.vhid,2)='05' THEN '5'
					WHEN RIGHT(a.vhid,2)='06' THEN '6'
					WHEN RIGHT(a.vhid,2)='07' THEN '7'
					WHEN RIGHT(a.vhid,2)='08' THEN '8'
					WHEN RIGHT(a.vhid,2)='09' THEN '9'
				  ELSE RIGHT(a.vhid,2) END AS VNO,
cvl.villname as VNAME,
ztb.tambonname as TBNAME,
zam.AMP_NAME as AMPNAME

FROM $table as a
LEFT OUTER JOIN co_village_loei as cvl ON a.vhid=cvl.villid
LEFT OUTER JOIN z42_tambon as ztb ON LEFT(a.vhid,6)=CONCAT(ztb.tamboncodefull)
LEFT OUTER JOIN z42_amp AS zam ON  LEFT(a.vhid,4)=CONCAT(zam.AMP_CODE)
LEFT OUTER JOIN 42co_office_loei as 42co ON a.HOSPCODE=42co.off_id
WHERE  a.vhid IS NOT NULL AND a.vhid <>'' AND a.vhid='".$vhid."' AND a.hospcode='".$hcode."'
				");

while($arr_rs=$dbrpt->Fetch_array()){
	$chkrow=$arr_rs['CK_DEV'];
	
?>    

    <tr bgcolor="<?php echo $arr_rs['CK_DEV']; ?>" align="center" >
		<td class="bg-warning"><?php echo $i++;?></td>
        <td><?php echo $arr_rs['HOSPCODE'];?></td>
        <td>
        <?php echo $arr_rs['PID']; ?>
		</td>
          <td>
        <?php echo $arr_rs['FNAME']; ?>
		</td>
         <td>
        <?php echo $arr_rs['HOSNB']; ?>
		</td>
         <td>
        <?php echo $arr_rs['BIRTH']; ?>
		</td>
        <td>
        <?php echo $arr_rs['AGEM']; ?>
		</td>
         <td>
        <?php echo $arr_rs['BW']; ?>
		</td>
        <td>
        <?php echo $arr_rs['HOS_DX']; ?>
		</td>
                 <td>
        <?php echo $arr_rs['SPHY']; ?>
		</td>
         <td>
        <?php echo $arr_rs['HCOD_DXDV']; ?>
		</td>
        <td>
        <?php echo $arr_rs['diagdv']; ?>
		</td>
         <td>
        <?php echo $arr_rs['date_diagdv']; ?>
		</td>
        <td>
        <?php echo $arr_rs['CHD23']; ?>
		</td>
        <td>
        <?php echo $arr_rs['ndate_serv23']; ?>
		</td>
         <td>
        <?php echo $arr_rs['M10']; ?>
		</td>
          <td >
        <?php echo $arr_rs['ch_dev10']; ?>
		</td>
        <td>
        <?php echo $arr_rs['M11']; ?>
		</td>
          <td >
        <?php echo $arr_rs['ch_dev11']; ?>
		</td>
        <td>
        <?php echo $arr_rs['M12']; ?>
		</td>
          <td >
        <?php echo $arr_rs['ch_dev12']; ?>
		</td>
<td>
        <?php echo $arr_rs['M1']; ?>
		</td>
          <td >
        <?php echo $arr_rs['ch_dev1']; ?>
		</td>
        <td>
        <?php echo $arr_rs['M2']; ?>
		</td>
          <td >
        <?php echo $arr_rs['ch_dev2']; ?>
		</td>
        <td>
        <?php echo $arr_rs['M3']; ?>
		</td>
          <td >
        <?php echo $arr_rs['ch_dev3']; ?>
		</td>
        <td>
        <?php echo $arr_rs['M4']; ?>
		</td>
          <td >
        <?php echo $arr_rs['ch_dev4']; ?>
		</td>
        <td>
        <?php echo $arr_rs['M5']; ?>
		</td>
          <td >
        <?php echo $arr_rs['ch_dev5']; ?>
		</td>
        <td>
        <?php echo $arr_rs['M6']; ?>
		</td>
          <td >
        <?php echo $arr_rs['ch_dev6']; ?>
		</td>
        <td>
        <?php echo $arr_rs['M7']; ?>
		</td>
          <td >
        <?php echo $arr_rs['ch_dev7']; ?>
		</td>
        <td>
        <?php echo $arr_rs['M8']; ?>
		</td>
          <td >
        <?php echo $arr_rs['ch_dev8']; ?>
		</td>
        <td>
        <?php echo $arr_rs['M9']; ?>
		</td>
          <td >
        <?php echo $arr_rs['ch_dev9']; ?>
		</td>
        <td>
           <?php echo $arr_rs['MOM'];?>
        </td>
         <td>
        <?php echo $arr_rs['HOUSE']; ?>
		</td>
        <td>
        <?php echo $arr_rs['VNO']; ?>
		</td>
          <td>
        <?php echo $arr_rs['VNAME']; ?>
		</td>
        <td>
        <?php echo $arr_rs['TBNAME']; ?>
		</td>
		       <td>
        <?php echo $arr_rs['AMPNAME']; ?>
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
