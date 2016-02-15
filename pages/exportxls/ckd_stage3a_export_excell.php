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
?>
<?php
$strExcelFileName=$hcode."ckd_stage2.xls";
header("Content-Type: application/x-msexcel; name=\"$strExcelFileName\"");
header("Content-Disposition: inline; filename=\"$strExcelFileName\"");
header("Pragma:no-cache");

 $db=new Database(DB_HOST_TK,DB_USER_TK,DB_PASS_TK,DB_NAME_TK);
 $db->Query("
    SELECT  
        t.HOSPCODE,t.CID,CONCAT(t.PRENAME,t.NAME,' ',t.LNAME)AS FULLNAME,
        t.BIRTH,t.AGE,s.sexname AS SEX,t.DATE_SERV,t.DIAG,t.LABRESULT,t.HOUSE,
        t.VHID,
        cvl.villname AS VILLNAME,CONCAT(t.TYPEAREA,'-',c.typeareaname)AS TYPREAREA
        FROM t_ckd_dm t
        INNER JOIN loeichart.co_village_loei as cvl ON t.VHID=cvl.villid AND t.HOSPCODE=cvl.hospcode
        INNER JOIN loeichart.ctypearea c ON c.typeareacode=t.TYPEAREA
        INNER JOIN hdc.csex s ON s.sex = t.SEX
        WHERE t.DATE_SERV BETWEEN '$ystr' AND '$yend' AND t.HOSPCODE='$hcode' 
        AND t.LABRESULT BETWEEN '45.00' AND '59.99' ;       
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
จำนวนผู้ป่วย DMHT ที่ได้รับการตรวจไต Stage3a (eGFR 45-59)
<div id="SiXhEaD_Excel" align=center x:publishsource="Excel">
<table x:str border="1" cellpadding=0  width=100% style="border-collapse:collapse">
<tr>
<td width="94" height="30" align="center" valign="middle" ><strong>รหัสสถานพยาบาล</strong></td>
<td width="200" align="center" valign="middle" ><strong>เลขบัตรประชาชน</strong></td>
<td width="181" align="center" valign="middle" ><strong>ชื่อ-นามสกุล</strong></td>
<td width="181" align="center" valign="middle" ><strong>วันเดือนปีเกิด</strong></td>
<td width="181" align="center" valign="middle" ><strong>อายุ</strong></td>
<td width="185" align="center" valign="middle" ><strong>เพศ</strong></td>
<td width="185" align="center" valign="middle" ><strong>ICD10</strong></td>
<td width="185" align="center" valign="middle" ><strong>วันมารับบริการตรวจ GFR</strong></td>
<td width="185" align="center" valign="middle" ><strong>ผล GFR</strong></td>
<td width="185" align="center" valign="middle" ><strong>บ้านเลขที่</strong></td>
<td width="185" align="center" valign="middle" ><strong>หมู่ที่</strong></td>
<td width="185" align="center" valign="middle" ><strong>หมู่บ้าน</strong></td>
<td width="185" align="center" valign="middle" ><strong>TYPEAREA</strong></td>
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
<td align="center" valign="middle"><?php echo $row['SEX'];?></td>
<td align="center" valign="middle"><?php echo $row['DIAG'];?></td>
<td align="center" valign="middle"><?php echo $row['DATE_SERV'];?></td>
<td align="center" valign="middle"><?php echo $row['LABRESULT'];?></td>
<td align="center" valign="middle"><?php echo $row['HOUSE'];?></td>
<td align="center" valign="middle"><?php echo substr($row['VHID'],6,2);?></td>
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