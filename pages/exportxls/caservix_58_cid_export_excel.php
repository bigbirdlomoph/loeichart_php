<?php
function __autoload($class_name){
	include'../class/class.'.$class_name.'.php';
}
set_time_limit(0);
include"../config/config.php";
//require("../gobal/gobal_var.php");
$hcode =$_GET['hcode'];
$id=$_GET['id'];
$o_year=$_GET['b_year']-1;
$b_year=$_GET['b_year'];
$ystr=$_GET['ystr'];
$yend=$_GET['yend'];
$villid=$_GET['villid'];
?>
<?php
$strExcelFileName=$hcode."caservix_58_indiv.xls";
header("Content-Type: application/x-msexcel; name=\"$strExcelFileName\"");
header("Content-Disposition: inline; filename=\"$strExcelFileName\"");
header("Pragma:no-cache");

 $db=new Database(DB_HOST_TK,DB_USER_TK,DB_PASS_TK,DB_NAME_TK);
 $db->Query("
            SELECT 
            c.HOSPCODE, c.CID, CONCAT(c.NAME,' ',c.lname)AS FULLNAME, 
            c.age_y, c.Date_diag, c.Diag, c.house, v.villname AS VILLNAME, 
            s.subdistname AS TUMBONNAME, a.AMP_NAME, c.vhid
            FROM z42_tc_cacervix c
            LEFT JOIN z42_co_office_loei o ON o.off_id = c.HOSPCODE
            LEFT JOIN z42_amp a ON a.AMP_CODE = o.distid
            LEFT JOIN z42_co_subdistrict s ON s.subdistid = LEFT(c.vhid,6)
            LEFT JOIN z42_co_village v ON v.villid = c.vhid
            WHERE c.HOSPCODE='$hcode' AND o.subdistid='$villid'
            ORDER BY c.Date_diag; 
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
จำนวนประชากรหญิงที่เป็นมะเร็งปากมดลูกแล้ว
<div id="SiXhEaD_Excel" align=center x:publishsource="Excel">
<table x:str border="1" cellpadding=0  width=100% style="border-collapse:collapse">
<tr>
<td width="90" height="30" align="center" valign="middle" ><strong>รหัสสถานพยาบาล</strong></td>
<td width="90" align="center" valign="middle" ><strong>เลขบัตรประชาชน</strong></td>
<td width="200" align="center" valign="middle" ><strong>ชื่อ-นามสกุล</strong></td>
<td width="50" align="center" valign="middle" ><strong>อายุ</strong></td>
<td width="100" align="center" valign="middle" ><strong>วันที่วินิจฉัย</strong></td>
<td width="100" align="center" valign="middle" ><strong>รหัสวินิจฉัย</strong></td>
<td width="100" align="center" valign="middle" ><strong>บ้านเลขที่</strong></td>
<td width="100" align="center" valign="middle" ><strong>หมู่บ้าน</strong></td>
<td width="100" align="center" valign="middle" ><strong>ตำบล</strong></td>
<td width="100" align="center" valign="middle" ><strong>อำเภอ</strong></td>
</tr>
<?php
if($num>0){
while($row=$dbarr=$db->Fetch_array()){
?>
<tr>
<td height="25" align="center" valign="middle" ><?php echo $row['HOSPCODE'];?></td>
<td align="center" valign="middle" ><?php echo $row['CID'];?></td>
<td align="center" valign="middle"><?php echo $row['FULLNAME'];?></td>
<td align="center" valign="middle"><?php echo $row['age_y'];?></td>
<td align="center" valign="middle"><?php echo $row['Date_diag'];?></td>
<td align="center" valign="middle"><?php echo $row['Diag'];?></td>
<td align="center" valign="middle"><?php echo $row['house'];?></td>
<td align="center" valign="middle"><?php echo $row['VILLNAME'];?></td>
<td align="center" valign="middle"><?php echo $row['TUMBONNAME'];?></td>
<td align="center" valign="middle"><?php echo $row['AMP_NAME'];?></td>
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