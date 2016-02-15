<?php
function __autoload($class_name){
	include'../class/class.'.$class_name.'.php';
}
set_time_limit(0);
include"../config/config.php";
require("../gobal/gobal_var.php");
$hcode =$_GET['hcode'];
$id=$_GET['id'];
$o_year=$_GET['b_year']-1;
$b_year=$_GET['b_year'];
$ystr=$_GET['ystr'];
$yend=$_GET['yend'];
$age=$_GET['age'];
?>
<?php
$strExcelFileName=$hcode."fat_child.xls";
header("Content-Type: application/x-msexcel; name=\"$strExcelFileName\"");
header("Content-Disposition: inline; filename=\"$strExcelFileName\"");
header("Pragma:no-cache");

 $db=new Database(DB_HOST_TK,DB_USER_TK,DB_PASS_TK,DB_NAME_TK);
 if($age=='6'){
 $db->Query("
			 SELECT 
				znut.HOSPCODE as HOSPCODE,
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
	 
	 $db->Query("SELECT 
				znut.HOSPCODE as HOSPCODE,
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
 $num=$db->Numrow();
?>


<html xmlns:o="urn:schemas-microsoft-com:office:office"xmlns:x="urn:schemas-microsoft-com:office:excel"xmlns="http://www.w3.org/TR/REC-html40">
 
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
<title>fatchild</title>
</head>
<body>
<?php
//select name report
$dbrpt=new Database(DB_HOST_TK,DB_USER_TK,DB_PASS_TK,DB_NAME_TK);
  $dbrpt->Query("SELECT * FROM z42_sys_report WHERE id='$id' ORDER BY source_table");
    while($arrrpt=$dbrpt->Fetch_array()){
		?>
   
		<strong><?php echo $arrrpt['report_name'];?></strong>
		<?php
        }
?>
<br>
ภาวะโภชนาการเด็กอ้วน
<div id="SiXhEaD_Excel" align=center x:publishsource="Excel">
<table x:str border=1 cellpadding=0  width=100% style="border-collapse:collapse">
<tr>
<td width="94" height="30" align="center" valign="middle" ><strong>รหัสสถานพยาบาล</strong></td>
<td width="200" align="center" valign="middle" ><strong>เลขบัตรประชาชน</strong></td>
<td width="181" align="center" valign="middle" ><strong>ชื่อ-นามสกุล</strong></td>
<td width="181" align="center" valign="middle" ><strong>วันเดือนปีเกิด</strong></td>
<td width="181" align="center" valign="middle" ><strong>อายุ</strong></td>
<td width="185" align="center" valign="middle" ><strong>อายุที่มาชั่งน้ำหนัก</strong></td>
<td width="185" align="center" valign="middle" ><strong>วันมารับบริการ</strong></td>
<td width="185" align="center" valign="middle" ><strong>บ้านเลขที่</strong></td>
<td width="185" align="center" valign="middle" ><strong>หมู่</strong></td>
<td width="185" align="center" valign="middle" ><strong>หมู่บ้าน</strong></td>
</tr>
<?php
if($num>0){
while($row=$dbarr=$db->Fetch_array()){
?>
<tr>
<td height="25" align="center" valign="middle" ><?php echo $row['HOSPCODE'];?></td>
<td align="center" valign="middle" ><?php echo $row['CID'];?></td>
<td align="center" valign="middle"><?php echo $row['FULLNAME'];?></td>
<td align="center" valign="middle"><?php echo $row['BIRTH'];?></td>
<td align="center" valign="middle"><?php echo $row['AGE'];?></td>
<td align="center" valign="middle"><?php echo $row['AGE_SERVICE'];?></td>
<td align="center" valign="middle"><?php echo $row['DATESERV'];?></td>
<td align="center" valign="middle"><?php echo $row['HOUSE'];?></td>
<td align="center" valign="middle"><?php echo substr($row['VHID'],6,2);?></td>
<td align="center" valign="middle"><?php echo $row['VILLNAME'];?></td>

</tr>
<?php
}
}
?>
</table>
</div>
<script>
window.onbeforeunload = function(){return false;};
setTimeout(function(){window.close();}, 10000);
</script>
</body>
</html>