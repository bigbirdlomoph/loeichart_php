<?php
function __autoload($class_name){
	include'../class/class.'.$class_name.'.php';
}
set_time_limit(0);
include"../config/config.php";
$id=$_GET['id'];
$table=$_GET['table'];
$o_year=$_GET['b_year']-1;
$b_year=$_GET['b_year'];
$ystr=$_GET['ystr'];
$yend=$_GET['yend'];
?>
<?php
$strExcelFileName=$hcode."labor_teen1014.xls";
header("Content-Type: application/x-msexcel; name=\"$strExcelFileName\"");
header("Content-Disposition: inline; filename=\"$strExcelFileName\"");
header("Pragma:no-cache");

 $db=new Database(DB_HOST_TK,DB_USER_TK,DB_PASS_TK,DB_NAME_TK);
 $db->Query("
 SELECT 
        tb1.AMP_CODE as AMPCODE,
        tb1.AMP_NAME as AMPNAME,
        tb2.B as B,
        tb2.A AS A,
        tb2.P AS P,
        tb2.M10 as M10,
        tb2.M11 as M11,
        tb2.M12 as M12,
        tb2.M09 as M09,
        tb2.M08 as M08,
        tb2.M07 as M07,
        tb2.M06 as M06,
        tb2.M05 as M05,
        tb2.M04 as M04,
        tb2.M03 as M03,
        tb2.M02 as M02,
        tb2.M01 as M01
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
                sum(target) as B,
                sum(result) as A,
                ROUND((sum(result)/sum(target))*100,2) as P,
                SUM(result10) AS M10,SUM(result11) AS M11,SUM(result12) AS M12,
                SUM(result09) AS M09,SUM(result08) AS M08,SUM(result07) AS M07,
                SUM(result06) AS M06,SUM(result05) AS M05,SUM(result04) AS M04,
                SUM(result03) AS M03,SUM(result02) AS M02,SUM(result01) AS M01
                FROM s_labor_1014 
                LEFT OUTER JOIN z42_amp AS amp ON LEFT(s_labor_1014.areacode,4)=amp.AMP_CODE
                WHERE b_year BETWEEN '$o_year' AND '$b_year' AND date_com BETWEEN '$ystr' AND'$yend' 
                GROUP BY LEFT(areacode,4)
) as tb2 ON tb1.AMP_CODE=tb2.AMPCODE 
GROUP BY tb1.AMP_CODE
UNION ALL
    SELECT 
                'TOTAL' AS AMPNAME,'รวม',
                sum(target) as B,
                sum(result) as A,
                ROUND((sum(result)/sum(target))*100,2) as P,
                SUM(result10) AS M10,SUM(result11)AS M11,SUM(result12)AS M12,
                SUM(result09) AS M09,SUM(result08)AS M08,SUM(result07)AS M07,
                SUM(result06) AS M06,SUM(result05)AS M05,SUM(result04)AS M04,
                SUM(result03) AS M03,SUM(result02)AS M02,SUM(result01)AS M01
                FROM s_labor_1014 
                LEFT OUTER JOIN z42_amp AS amp ON LEFT(s_labor_1014.areacode,4)=amp.AMP_CODE
                WHERE b_year BETWEEN '$o_year' AND '$b_year' AND date_com BETWEEN '$ystr' AND'$yend'  ;
   
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
จำนวนหญิงคลอด อายุ 15-19 ปี
<div id="SiXhEaD_Excel" align=center x:publishsource="Excel">
<table x:str border=1 cellpadding=0  width=100% style="border-collapse:collapse">
<tr>
<td width="94" height="30" align="center" valign="middle" ><strong>อำเภอ</strong></td>
<td width="200" align="center" valign="middle" ><strong>B</strong></td>
<td width="181" align="center" valign="middle" ><strong>A</strong></td>
<td width="181" align="center" valign="middle" ><strong>ร้อยละ</strong></td>
<td width="181" align="center" valign="middle" ><strong>ต.ค.</strong></td>
<td width="181" align="center" valign="middle" ><strong>พ.ย.</strong></td>
<td width="185" align="center" valign="middle" ><strong>ธ.ค.</strong></td>
<td width="185" align="center" valign="middle" ><strong>ม.ค.</strong></td>
<td width="185" align="center" valign="middle" ><strong>ก.พ.</strong></td>
<td width="185" align="center" valign="middle" ><strong>มี.ค.</strong></td>
<td width="185" align="center" valign="middle" ><strong>เม.ย.</strong></td>
<td width="185" align="center" valign="middle" ><strong>พ.ค.</strong></td>
<td width="185" align="center" valign="middle" ><strong>มิ.ย.</strong></td>
<td width="185" align="center" valign="middle" ><strong>ก.ค.</strong></td>
<td width="185" align="center" valign="middle" ><strong>ส.ค.</strong></td>
<td width="185" align="center" valign="middle" ><strong>ก.ย.</strong></td>
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
<td align="center" valign="middle"><?php echo $row['M10'];?></td>
<td align="center" valign="middle"><?php echo $row['M11'];?></td>
<td align="center" valign="middle"><?php echo $row['M12'];?></td>
<td align="center" valign="middle"><?php echo $row['M01'];?></td>
<td align="center" valign="middle"><?php echo $row['M02'];?></td>
<td align="center" valign="middle"><?php echo $row['M03'];?></td>
<td align="center" valign="middle"><?php echo $row['M04'];?></td>
<td align="center" valign="middle"><?php echo $row['M05'];?></td>
<td align="center" valign="middle"><?php echo $row['M06'];?></td>
<td align="center" valign="middle"><?php echo $row['M07'];?></td>
<td align="center" valign="middle"><?php echo $row['M08'];?></td>
<td align="center" valign="middle"><?php echo $row['M09'];?></td>
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