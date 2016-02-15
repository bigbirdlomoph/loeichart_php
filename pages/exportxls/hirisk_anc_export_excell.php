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
$ystr=$_GET['ystr'];;
$yend=$_GET['yend'];
?>
<?php
$strExcelFileName=$hcode."hirisk_anc.xls";
header("Content-Type: application/x-msexcel; name=\"$strExcelFileName\"");
header("Content-Disposition: inline; filename=\"$strExcelFileName\"");
header("Pragma:no-cache");

 $db=new Database(DB_HOST_TK,DB_USER_TK,DB_PASS_TK,DB_NAME_TK);
 $db->Query("SELECT * FROM z42_anc_hr_t where HOSPCODE='$hcode' and result='1' and fanc BETWEEN '$ystr' AND '$yend'");
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

<div id="SiXhEaD_Excel" align=center x:publishsource="Excel">
<table x:str border=1 cellpadding=0  width=100% style="border-collapse:collapse">
<tr>
<td width="94" height="30" align="center" valign="middle" ><strong>รหัสสถานพยาบาล</strong></td>
<td width="200" align="center" valign="middle" ><strong>เลขบัตรประชาชน</strong></td>
<td width="181" align="center" valign="middle" ><strong>ชื่อ-นามสกุล</strong></td>
<td width="181" align="center" valign="middle" ><strong>วันเดือนปีเกิด</strong></td>
<td width="181" align="center" valign="middle" ><strong>ครรภ์ที่</strong></td>
<td width="185" align="center" valign="middle" ><strong>วันที่มา ANC ครั้งแรก</strong></td>
<td width="185" align="center" valign="middle" ><strong>LMP</strong></td>
<td width="185" align="center" valign="middle" ><strong>อายุ(ปี)</strong></td>
<td width="185" align="center" valign="middle" ><strong>รหัสโรค</strong></td>
<td width="185" align="center" valign="middle" ><strong>มีภาวะเสี่ยง</strong></td>
<td width="185" align="center" valign="middle" ><strong>บ้านเลขที่</strong></td>
<td width="185" align="center" valign="middle" ><strong>หมู่ที่</strong></td>
<td width="185" align="center" valign="middle" ><strong>DUPDATE</strong></td>
</tr>
<?php
if($num>0){
while($row=$dbarr=$db->Fetch_array()){
?>
<tr>
<td height="25" align="center" valign="middle" ><?php echo $row['hospcode'];?></td>
<td align="center" valign="middle" ><?php echo $row['cid'];?></td>
<td align="center" valign="middle"><?php echo $row['name']." ".$row['lname'];?></td>
<td align="center" valign="middle"><?php echo $row['birth'];?></td>
<td align="center" valign="middle"><?php echo $row['gravida'];?></td>
<td align="center" valign="middle"><?php echo $row['fanc'];?></td>
<td align="center" valign="middle"><?php echo $row['lmp'];?></td>
<td align="center" valign="middle"><?php echo $row['age_y'];?></td>
<td align="center" valign="middle"><?php echo $row['diagcode'];?></td>
<td align="center" valign="middle"><?php echo $row['result'];?></td>
<td align="center" valign="middle"><?php echo $row['house'];?></td>
<td align="center" valign="middle"><?php echo substr($row['vhid'],6,2);?></td>
<td align="center" valign="middle"><?php echo $row['dupdate'];?></td>
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