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
$strExcelFileName=$age."ht_ckd_stage1_pcu.xls";
header("Content-Type: application/x-msexcel; name=\"$strExcelFileName\"");
header("Content-Disposition: inline; filename=\"$strExcelFileName\"");
header("Pragma:no-cache");

 $db=new Database(DB_HOST_TK,DB_USER_TK,DB_PASS_TK,DB_NAME_TK);
 $db->Query("
        SELECT 
          42loei.off_name AS HNAME,
          42loei.off_id AS HCODE,
          sum(target) as B,
          sum(stage1) as A,
          ROUND((sum(stage1)/sum(target))*100,2) as P,
          SUM(stage1)AS S1
          FROM s_ckd_ht 
          left  OUTER JOIN z42_co_office_loei AS 42loei on 42loei.off_id = s_ckd_ht.hospcode
          WHERE b_year BETWEEN'$o_year' AND '$b_year' AND date_com BETWEEN'$ystr' AND'$yend' 
          AND left(areacode,4)=$ampcode GROUP BY hospcode 
       UNION ALL
        SELECT 
          'รวม' AS HNAME,
          '' AS HCODE,
          sum(target) as B,
          sum(stage1) as A,
          ROUND((sum(stage1)/sum(target))*100,2) as P,
          SUM(stage1)AS S1
          FROM s_ckd_ht 
          left  OUTER JOIN z42_co_office_loei AS 42loei on 42loei.off_id = s_ckd_ht.hospcode
          WHERE b_year BETWEEN'$o_year' AND '$b_year' AND date_com BETWEEN'$ystr' AND'$yend' 
          AND left(areacode,4)=$ampcode ;
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
<td width="94" height="30" align="center" valign="middle" ><strong>ชื่อสถานบริการ</strong></td>
<td width="94" height="30" align="center" valign="middle" ><strong>รหัสสถานบริการ</strong></td>
<td width="200" align="center" valign="middle" ><strong>B</strong></td>
<td width="181" align="center" valign="middle" ><strong>A</strong></td>
<td width="181" align="center" valign="middle" ><strong>ร้อยละ</strong></td>

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