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
$hcode=$_GET['hcode'];
$villid=$_GET['villid'];
?>
<?php
$strExcelFileName=$age."summary_papsmear_59_vill.xls";
header("Content-Type: application/x-msexcel; name=\"$strExcelFileName\"");
header("Content-Disposition: inline; filename=\"$strExcelFileName\"");
header("Pragma:no-cache");

 $db=new Database(DB_HOST_TK,DB_USER_TK,DB_PASS_TK,DB_NAME_TK);
 $db->Query("
        SELECT 
          a.villid AS VILLCODE,s.hospcode AS HCODE,
          a.villname AS VNAME,
          a.villno AS Moo,
          sum(B) as B,
          sum(A) as A,
          ROUND((sum(A)/sum(B))*100,2) as P
          FROM s_goalpap_59 s
          LEFT OUTER JOIN z42_co_village a ON s.areacode = a.villid
          WHERE s.hospcode='$hcode' AND LEFT(s.areacode,6)='$villid'
          GROUP BY a.villid
        UNION
        SELECT 
          'รวม' AS VILLCODE,s.hospcode AS HCODE,
          'รวม' AS VNAME,
          '' AS Moo,
          sum(B) as B,
          sum(A) as A,
          ROUND((sum(A)/sum(B))*100,2) as P
          FROM s_goalpap_59 s
          LEFT OUTER JOIN z42_co_village a ON s.areacode = a.villid
          WHERE s.hospcode='$hcode' AND LEFT(s.areacode,6)='$villid' 
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
<td width="94" height="30" align="center" valign="middle" ><strong>หมู่บ้าน</strong></td>
<td width="94" height="30" align="center" valign="middle" ><strong>หมู่ที่</strong></td>
<td width="200" align="center" valign="middle" ><strong>B</strong></td>
<td width="181" align="center" valign="middle" ><strong>A</strong></td>
<td width="181" align="center" valign="middle" ><strong>ร้อยละ</strong></td>

</tr>
<?php
if($num>0){
while($row=$dbarr=$db->Fetch_array()){
?>
<tr>
<td height="25" align="center" valign="middle" ><?php echo $row['VNAME'];?></td>
<td height="25" align="center" valign="middle" ><?php echo $row['Moo'];?></td>
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