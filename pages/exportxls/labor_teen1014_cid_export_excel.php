<?php
function __autoload($class_name){
	include'../class/class.'.$class_name.'.php';
}
set_time_limit(0);
include"../config/config.php";
//require("../gobal/gobal_var.php");
$age =$_GET['age'];
$id=$_GET['id'];
$table=$_GET['table'];
$o_year=$_GET['b_year']-1;
$b_year=$_GET['b_year'];
$ystr=$_GET['ystr'];
$yend=$_GET['yend'];
$hcode=$_GET['hcode'];
?>
<?php
$strExcelFileName=$age."labor_teen1014_individual.xls";
header("Content-Type: application/x-msexcel; name=\"$strExcelFileName\"");
header("Content-Disposition: inline; filename=\"$strExcelFileName\"");
header("Pragma:no-cache");

 $db=new Database(DB_HOST_TK,DB_USER_TK,DB_PASS_TK,DB_NAME_TK);
 $db->Query("
    SELECT  
        t.HOSPCODE, t.CID,CONCAT(t.PRENAME,t.NAME,' ',t.LNAME)AS FULLNAME,
        t.BIRTH, t.AGE, a.GRAVIDA, MIN(a.DATE_SERV) AS FANC, a.GA,t.HOUSE, t.VHID,
        cvl.villname AS VILLNAME, t.BDATE, CONCAT(p.TYPEAREA,'-',c.typeareaname)AS TYPREAREA
        FROM t_labor_teen t
        INNER JOIN hdc.anc a ON a.HOSPCODE = t.HOSPCODE AND a.PID = t.PID
        INNER JOIN hdc.person p ON p.PID = t.PID AND p.HOSPCODE = t.HOSPCODE
        INNER JOIN loeichart.co_village_loei as cvl ON t.VHID=cvl.villid AND t.HOSPCODE=cvl.hospcode
        INNER JOIN loeichart.ctypearea c ON c.typeareacode=t.TYPEAREA
        WHERE t.BDATE BETWEEN'$ystr' AND'$yend' AND t.HOSPCODE='$hcode' 
        AND t.AGE BETWEEN '10' AND '14'
        GROUP BY t.CID;
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
<div id="SiXhEaD_Excel" align=center x:publishsource="Excel">
<table x:str border=1 cellpadding=0  width=100% style="border-collapse:collapse">
<tr>
<td width="100" height="30" align="center" valign="middle" ><strong>รหัสพยาบาล</strong></td>
<td width="94" align="center" valign="middle" ><strong>CID</strong></td>
<td width="94" align="center" valign="middle" ><strong>ชื่อ-นามสกุล</strong></td>
<td width="94" align="center" valign="middle" ><strong>วันเดือนปีเกิด</strong></td>
<td width="94" align="center" valign="middle" ><strong>อายุ</strong></td>
<td width="94" align="center" valign="middle" ><strong>ครรภ์ที่</strong></td>
<td width="94" align="center" valign="middle" ><strong>วันเดือนปีที่คลอด</strong></td>
<td width="94" align="center" valign="middle" ><strong>12 week</strong></td>
<td width="94" align="center" valign="middle" ><strong>อายุครรภ์</strong></td>
<td width="94" align="center" valign="middle" ><strong>บ้านเลขที่</strong></td>
<td width="94" align="center" valign="middle" ><strong>หมู่ที่</strong></td>
<td width="94" align="center" valign="middle" ><strong>ชื่อหมู่บ้าน</strong></td>
<td width="181" align="center" valign="middle" ><strong>สถานะบุคคล</strong></td>

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
<td align="center" valign="middle"><?php echo $row['GRAVIDA'];?></td>
<td align="center" valign="middle"><?php echo $row['BDATE'];?></td>
<td align="center" valign="middle"><?php echo $row['FANC'];?></td>
<td align="center" valign="middle"><?php echo $row['GA'];?></td>
<td align="center" valign="middle"><?php echo $row['HOUSE'];?></td>
<td align="center" valign="middle"><?php echo $row['VHID'];?></td>
<td align="center" valign="middle"><?php echo $row['VILLNAME'];?></td>
<td align="center" valign="middle"><?php echo $row['TYPREAREA'];?></td>

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