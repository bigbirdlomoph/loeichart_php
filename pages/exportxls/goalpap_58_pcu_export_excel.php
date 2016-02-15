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
$ampcode=$_GET['ampcode'];
?>
<?php
$strExcelFileName=$age."summary_papsmear_58_pcu.xls";
header("Content-Type: application/x-msexcel; name=\"$strExcelFileName\"");
header("Content-Disposition: inline; filename=\"$strExcelFileName\"");
header("Pragma:no-cache");

 $db=new Database(DB_HOST_TK,DB_USER_TK,DB_PASS_TK,DB_NAME_TK);
 $db->Query("
        SELECT 
          42loei.off_name AS HNAME,LEFT(areacode,6)AS AREACODE,
          42loei.off_id AS HCODE,
          sum(B) as B,
          sum(A) as A,
          ROUND((sum(A)/sum(B))*100,2) as P
          FROM s_goalpap_58 
          INNER JOIN z42_co_office_loei AS 42loei on 42loei.off_id = s_goalpap_58.hospcode
          #WHERE b_year BETWEEN'$o_year' AND '$b_year' AND date_com BETWEEN'$ystr' AND'$yend' 
          AND left(areacode,4)='$ampcode' GROUP BY hospcode 
       UNION ALL
        SELECT 
          'รวม' AS HNAME,LEFT(areacode,6)AS AREACODE,
          '' AS HCODE,
          sum(B) as B,
          sum(A) as A,
          ROUND((sum(A)/sum(B))*100,2) as P
          FROM s_goalpap_58 
          INNER JOIN z42_co_office_loei AS 42loei on 42loei.off_id = s_goalpap_58.hospcode
          #WHERE b_year BETWEEN'$o_year' AND '$b_year' AND date_com BETWEEN'$ystr' AND'$yend' 
          AND left(areacode,4)='$ampcode';
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
<td width="150" height="30" align="center" valign="middle" ><strong>ชื่อสถานบริการ</strong></td>
<td width="100" height="30" align="center" valign="middle" ><strong>รหัสสถานบริการ</strong></td>
<td width="90" align="center" valign="middle" ><strong>B</strong></td>
<td width="90" align="center" valign="middle" ><strong>A</strong></td>
<td width="90" align="center" valign="middle" ><strong>ร้อยละ</strong></td>

</tr>
<?php
if($num>0){
while($row=$dbarr=$db->Fetch_array()){
?>
<tr>
<td height="25" align="center" valign="middle" ><?php echo $row['HNAME'];?></td>
<td height="25" align="center" valign="middle" ><?php echo $row['HCODE'];?></td>
<td align="center" valign="middle" ><?php echo $row['B'];?></td>
<td align="center" valign="middle"><?php echo $row['A'];?></td>
<td align="center" valign="middle"><?php echo $row['P'];?></td>

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