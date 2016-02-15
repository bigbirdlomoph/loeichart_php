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
?>
<?php
$strExcelFileName=$age."ht_ckd_stage3b_age_m65_amp.xls";
header("Content-Type: application/x-msexcel; name=\"$strExcelFileName\"");
header("Content-Disposition: inline; filename=\"$strExcelFileName\"");
header("Pragma:no-cache");

 $db=new Database(DB_HOST_TK,DB_USER_TK,DB_PASS_TK,DB_NAME_TK);
 $db->Query("
 SELECT 
        tb1.AMP_CODE as AMPCODE,
        tb1.AMP_NAME as AMPNAME,
        tb2.A AS A,
        tb2.B AS B,
        tb2.P AS P,
        tb2.S3a as S3a,
        tb2.S3a_2 as S3a_2,
        tb2.S3b as S3b,
        tb2.S3b_2 as S3b_2,
        tb2.S4 as S4,
        tb2.S4_2 as S4_2,
        tb2.S5 as S5,
        tb2.S5_2 as S5_2
FROM(
     SELECT 
           AMP_CODE,AMP_NAME  
            FROM z42_amp 
      GROUP BY AMP_CODE 
) as tb1
LEFT JOIN
(
    SELECT 
                amp.AMP_NAME AS AMPNAME,
                left(areacode,4) as AMPCODE,
                SUM(stage3b_2) as A,
                SUM(target) as B,
                ROUND((sum(stage3b_2)/sum(target))*100,2) as P,
                SUM(stage3a) as S3a,
                SUM(stage3a_2)AS S3a_2,
                SUM(stage3b)AS S3b,
                SUM(stage3b_2) as S3b_2,
                SUM(stage4)AS S4,
                SUM(stage4_2)AS S4_2,
                SUM(stage5)AS S5,
                SUM(stage5_2)AS S5_2
                FROM s_ckd_ht_age
                LEFT OUTER JOIN z42_amp AS amp ON LEFT(s_ckd_ht_age.areacode,4)=amp.AMP_CODE
        WHERE b_year BETWEEN'$o_year' AND '$b_year' AND date_com BETWEEN'$ystr' AND'$yend' 
                GROUP BY LEFT(areacode,4)
) as tb2 ON tb1.AMP_CODE=tb2.AMPCODE 
GROUP BY tb1.AMP_CODE 
UNION ALL
    SELECT 
                'TOTAL' AS AMPNAME,'รวม' as AMPCODE,
                SUM(stage3b_2) as A,
                SUM(target) as B,
                ROUND((sum(stage3b_2)/sum(target))*100,2) as P,
                SUM(stage3a) as S3a,
                SUM(stage3a_2)AS S3a_2,
                SUM(stage3b)AS S3b,
                SUM(stage3b_2) as S3b_2,
                SUM(stage4)AS S4,
                SUM(stage4_2)AS S4_2,
                SUM(stage5)AS S5,
                SUM(stage5_2)AS S5_2
                FROM s_ckd_ht_age
                LEFT OUTER JOIN z42_amp AS amp ON LEFT(s_ckd_ht_age.areacode,4)=amp.AMP_CODE
                WHERE b_year BETWEEN'$o_year' AND '$b_year' AND date_com BETWEEN'$ystr' AND'$yend' ;
			 
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
<td width="94" height="30" align="center" valign="middle" ><strong>อำเภอ</strong></td>
<td width="200" align="center" valign="middle" ><strong>B</strong></td>
<td width="181" align="center" valign="middle" ><strong>A</strong></td>
<td width="181" align="center" valign="middle" ><strong>ร้อยละ</strong></td>

</tr>
<?php
if($num>0){
while($row=$dbarr=$db->Fetch_array()){
?>
<tr>
<td height="25" align="center" valign="middle" ><?php echo $row['AMPNAME'];?></td>
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