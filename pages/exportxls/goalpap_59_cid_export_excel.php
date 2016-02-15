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
$strExcelFileName=$hcode."papsmear_QOF_59_indiv.xls";
header("Content-Type: application/x-msexcel; name=\"$strExcelFileName\"");
header("Content-Disposition: inline; filename=\"$strExcelFileName\"");
header("Pragma:no-cache");

 $db=new Database(DB_HOST_TK,DB_USER_TK,DB_PASS_TK,DB_NAME_TK);
 $db->Query("
            SELECT 
                a.hospcode, a.cid, CONCAT(a.NAME,' ',a.lname)AS FULLNAME, 
                a.birth, a.age_y, CONCAT(a.hospcode_pap,' : ', a.hospname_pap)AS HOSP_PAP, a.result, 
                a.details_ab, a.period, a.pap_ck, a.house, v.villno, v.villname, s.subdistname, 
                v.villid AS VILLCODE, RIGHT(a.age_y,1)AS age_chk
            FROM z42_tc_goalpap_58 a
            LEFT JOIN z42_co_subdistrict s ON s.subdistid = LEFT(a.vhid,6)
            LEFT JOIN z42_co_village v ON v.villid = LEFT(a.vhid,8)
            WHERE v.villid='$villid' AND a.pap_ck IN('0','3')
            ORDER BY a.pap_ck, a.age_y ;	 
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
หมายเหตุ <br>
อายุประชากรหญิงที่ลงท้ายด้วย 0 และ 5 และ สถานะการคัดกรอง = 0 เป็นเป้าหมายในการคัดกรองในปี QOF 2559 นี้ (1 เม.ย.2558 ถึง 31 มี.ค.2559)
<div id="SiXhEaD_Excel" align=center x:publishsource="Excel">
<table x:str border="1" cellpadding=0  width=100% style="border-collapse:collapse">
<tr>
<td width="90" height="30" align="center" valign="middle" ><strong>รหัสสถานพยาบาล</strong></td>
<td width="90" align="center" valign="middle" ><strong>เลขบัตรประชาชน</strong></td>
<td width="200" align="center" valign="middle" ><strong>ชื่อ-นามสกุล</strong></td>
<td width="100" align="center" valign="middle" ><strong>วันเดือนปีเกิด</strong></td>
<td width="50" align="center" valign="middle" ><strong>อายุ</strong></td>
<td width="100" align="center" valign="middle" ><strong>สถานบริการที่คัดกรอง</strong></td>
<td width="100" align="center" valign="middle" ><strong>ผลการคัดกรอง</strong></td>
<td width="100" align="center" valign="middle" ><strong>ผลการตัดกรองไม่ปกติ</strong></td>
<td width="100" align="center" valign="middle" ><strong>ปีงบประมาณที่ได้รับการคัดกรอง</strong></td>
<td width="100" align="center" valign="middle" ><strong>สถานะการคัดกรอง</strong></td>
<td width="100" align="center" valign="middle" ><strong>บ้านเลขที่</strong></td>
<td width="100" align="center" valign="middle" ><strong>หมู่ที่</strong></td>
<td width="100" align="center" valign="middle" ><strong>หมู่บ้าน</strong></td>
<td width="100" align="center" valign="middle" ><strong>อำเภอ</strong></td>
</tr>
<?php
if($num>0){
while($row=$dbarr=$db->Fetch_array()){
?>
<tr>
<td height="25" align="center" valign="middle" ><?php echo $row['hospcode'];?></td>
<td align="center" valign="middle"><?php echo $row['cid'];?></td>
<td align="center" valign="middle"><?php echo $row['FULLNAME'];?></td>
<td align="center" valign="middle"><?php echo $row['birth'];?></td>
<td align="center" valign="middle"><?php echo $row['age_y'];?></td>
<td align="center" valign="middle"><?php echo $row['HOSP_PAP'];?></td>
<td align="center" valign="middle"><?php echo $row['result'];?></td>
<td align="center" valign="middle"><?php echo $row['details_ab'];?></td>
<td align="center" valign="middle"><?php echo $row['period'];?></td>
<td align="center" valign="middle"><?php echo $row['pap_ck'];?></td>
<td align="center" valign="middle"><?php echo $row['house'];?></td>
<td align="center" valign="middle"><?php echo $row['villno'];?></td>
<td align="center" valign="middle"><?php echo $row['villname'];?></td>
<td align="center" valign="middle"><?php echo $row['subdistname'];?></td>
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