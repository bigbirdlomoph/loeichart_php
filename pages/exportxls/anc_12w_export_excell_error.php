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
?>
<?php
$strExcelFileName=$hcode."anc_12_week_error.xls";
header("Content-Type: application/x-msexcel; name=\"$strExcelFileName\"");
header("Content-Disposition: inline; filename=\"$strExcelFileName\"");
header("Pragma:no-cache");

 $db=new Database(DB_HOST_TK,DB_USER_TK,DB_PASS_TK,DB_NAME_TK);
 $db->Query("
			 SELECT 
					zat.HOSPCODE as HOSPCODE,
					zat.CID as CID,
					zat.FULLNAME as FULLNAME,
					zat.BIRTH as BIRTH,
					zat.GRAVIDA as GRAVIDA,
					zat.FANC as FANC,
					zat.GA as GA,
					zat.ANC12 as ANC12,
					zat.DUPDATE as DUPDATE,
					zat.HOUSE as HOUSE,
					zat.VHID as VHID,
					cvl.villname as VILLNAME
					FROM z42_anc12w_t AS zat
					INNER JOIN co_village_loei as cvl ON zat.VHID=cvl.villid AND zat.HOSPCODE=cvl.hospcode
					WHERE GRAVIDA='' and zat.hospcode='$hcode' AND FANC BETWEEN'$ystr' AND'$yend'
			 
			 ");
 $num=$db->Numrow();
?>


<html xmlns:o="urn:schemas-microsoft-com:office:office"xmlns:x="urn:schemas-microsoft-com:office:excel"xmlns="http://www.w3.org/TR/REC-html40">
 
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
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
ANC12=0 ได้รับ ANC มากกว่า 12 สัปดาห์ &nbsp;&nbsp; ANC12=1 ได้รับ ANC น้อยกว่าหรือเท่ากับ 12 สัปดาห์ GRAVIDA เท่ากับค่าว่าง
<div id="SiXhEaD_Excel" align=center x:publishsource="Excel">
<table x:str border=1 cellpadding=0  width=100% style="border-collapse:collapse">
<tr>
<td width="94" height="30" align="center" valign="middle" ><strong>รหัสสถานพยาบาล</strong></td>
<td width="200" align="center" valign="middle" ><strong>เลขบัตรประชาชน</strong></td>
<td width="181" align="center" valign="middle" ><strong>ชื่อ-นามสกุล</strong></td>
<td width="181" align="center" valign="middle" ><strong>วันเดือนปีเกิด</strong></td>
<td width="181" align="center" valign="middle" ><strong>ครรภ์ที่</strong></td>
<td width="185" align="center" valign="middle" ><strong>วันที่มา ANC ครั้งแรก</strong></td>
<td width="185" align="center" valign="middle" ><strong>GA</strong></td>
<td width="185" align="center" valign="middle" ><strong>ANC12</strong></td>
<td width="185" align="center" valign="middle" ><strong>บ้านเลขที่</strong></td>
<td width="185" align="center" valign="middle" ><strong>หมู่ที่</strong></td>
<td width="185" align="center" valign="middle" ><strong>หมู่บ้าน</strong></td>
<td width="185" align="center" valign="middle" ><strong>DUPDATE</strong></td>
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
<td align="center" valign="middle" bgcolor="#FF0000"><?php echo $row['GRAVIDA'];?></td>
<td align="center" valign="middle"><?php echo $row['FANC'];?></td>
<td align="center" valign="middle"><?php echo $row['GA'];?></td>
<td align="center" valign="middle"><?php echo $row['ANC12'];?></td>
<td align="center" valign="middle"><?php echo $row['HOUSE'];?></td>
<td align="center" valign="middle"><?php echo substr($row['VHID'],6,2);?></td>
<td align="center" valign="middle"><?php echo $row['VILLNAME'];?></td>
<td align="center" valign="middle"><?php echo $row['DUPDATE'];?></td>
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