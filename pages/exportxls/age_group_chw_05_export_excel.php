<?php
function __autoload($class_name){
	include'../class/class.'.$class_name.'.php';
}
set_time_limit(0);
include"../config/config.php";
include"../function/function.php";
//require("../gobal/gobal_var.php");
$age_st=$_GET['age_st'];
$age_end=$_GET['age_end'];
$id=$_GET['id'];
$table=$_GET['table'];
$tambon=$_GET['tambon'];
$o_year=$_GET['b_year']-1;
$b_year=$_GET['b_year'];
$ystr=$_GET['ystr'];
$yend=$_GET['yend'];
?>
<?php
$strExcelFileName=$age_st.$age_end."age_group.xls";
header("Content-Type: application/x-msexcel; name=\"$strExcelFileName\"");
header("Content-Disposition: inline; filename=\"$strExcelFileName\"");
header("Pragma:no-cache");

 $db=new Database(DB_HOST_TK,DB_USER_TK,DB_PASS_TK,DB_NAME_TK);
 $db->Query("
			SELECT 
				zag.HOSPCODE as HOSPCODE,
				42co.off_name as HOSPNAME,
				zag.HPID as HPID,
				zag.CID as CID,
				pr.prename as PRENAME,
				CONCAT(zag.NAME,'  ',zag.LNAME) AS FNAME,
				zag.BIRTH as BIRTH,
				zag.AGE as AGE,
				zag.AGE_MONTH as AGE_MONTH,
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
WHERE CONCAT(zag.CHANGWAT,zag.AMPUR,zag.TAMBON)='".$tambon."' AND zag.AGE BETWEEN'".$age_st."' AND '".$age_end."' GROUP BY zag.CID ORDER BY zag.AGE_MONTH;
			 
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
$i=1;
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
<td width="94" height="30" align="center" valign="middle" ><strong>ลำดับ</strong></td>
<td width="94" height="30" align="center" valign="middle" ><strong>รหัสสถานพยาบาล</strong></td>
<td width="200" align="center" valign="middle" ><strong>รหัสสถานพยาบาล</strong></td>
<td width="181" align="center" valign="middle" ><strong>HPID</strong></td>
<td width="181" align="center" valign="middle" ><strong>CID</strong></td>
<td width="181" align="center" valign="middle" ><strong>คำนำหน้า</strong></td>
<td width="181" align="center" valign="middle" ><strong>ชื่อ-สกุล</strong></td>
<td width="181" align="center" valign="middle" ><strong>วันเดือนปีเกิด</strong></td>
<td width="181" align="center" valign="middle" ><strong>อายุ/ปี</strong></td>
<td width="181" align="center" valign="middle" ><strong>บ้านเลขที่</strong></td>
<td width="181" align="center" valign="middle" ><strong>หมู่บ้าน</strong></td>
<td width="181" align="center" valign="middle" ><strong>ตำบล</strong></td>
<td width="181" align="center" valign="middle" ><strong>อำเภอ</strong></td>
<td width="181" align="center" valign="middle" ><strong>หมู่ที่</strong></td>
<td width="181" align="center" valign="middle" ><strong>Type Area</strong></td>
</tr>
<?php
if($num>0){
while($row=$dbarr=$db->Fetch_array()){
?>
<tr>
<td height="25" align="center" valign="middle" ><?php echo $i++;?></td>
<td height="25" align="center" valign="middle" ><?php echo $row['HOSPCODE'];?></td>
<td align="center" valign="middle" ><?php echo $row['HOSPNAME'];?></td>
<td align="center" valign="middle"><?php echo $row['HPID'];?></td>
<td align="center" valign="middle"><?php echo $row['CID'];?></td>
<td align="center" valign="middle"><?php echo $row['PRENAME'];?></td>
<td align="center" valign="middle"><?php echo $row['FNAME'];?></td>
<td align="center" valign="middle"><?php echo DateThai($row['BIRTH']);?></td>
<td align="center" valign="middle"><?php echo $row['AGE'];?></td>
<td align="center" valign="middle"><?php echo $row['HOUSE'];?></td>
<td align="center" valign="middle"><?php echo $row['VNAME'];?></td>
<td align="center" valign="middle"><?php echo $row['TBNAME'];?></td>
<td align="center" valign="middle"><?php echo $row['AMPNAME'];?></td>
<td align="center" valign="middle"><?php echo $row['VNO'];?></td>
<td align="center" valign="middle"><?php echo $row['TYPENAME'];?></td>



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