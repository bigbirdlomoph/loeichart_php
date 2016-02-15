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
$strExcelFileName=$age."labor_teen1014_pcu.xls";
header("Content-Type: application/x-msexcel; name=\"$strExcelFileName\"");
header("Content-Disposition: inline; filename=\"$strExcelFileName\"");
header("Pragma:no-cache");

 $db=new Database(DB_HOST_TK,DB_USER_TK,DB_PASS_TK,DB_NAME_TK);
 $db->Query("
                SELECT 
                    42loei.off_name AS HNAME,
                    42loei.off_id AS HCODE,
                    sum(target) as B,
                    sum(result) as A,
                    ROUND((sum(result)/sum(target))*100,2) as P,
                    SUM(result10) as M10,SUM(result11)AS M11,SUM(result12)AS M12,
                    SUM(result09) as M09,SUM(result08)AS M08,SUM(result07)AS M07,
                    SUM(result06) as M06,SUM(result05)AS M05,SUM(result04)AS M04,
                    SUM(result03) as M03,SUM(result02)AS M02,SUM(result01)AS M01
                    FROM s_labor_1014 
                    LEFT OUTER JOIN z42_co_office_loei AS 42loei on 42loei.off_id = s_labor_1014.hospcode
                    WHERE b_year BETWEEN'$o_year' AND '$b_year' AND date_com BETWEEN'$ystr' AND'$yend' 
                    AND left(areacode,4)=$ampcode GROUP BY hospcode;
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
<td width="181" height="30" align="center" valign="middle" ><strong>ชื่อสถานบริการ</strong></td>
<td width="181" height="30" align="center" valign="middle" ><strong>รหัสสถานบริการ</strong></td>
<td width="94" align="center" valign="middle" ><strong>B</strong></td>
<td width="94" align="center" valign="middle" ><strong>A</strong></td>
<td width="94" align="center" valign="middle" ><strong>ร้อยละ</strong></td>
<td width="94" align="center" valign="middle" ><strong>ต.ค.</strong></td>
<td width="94" align="center" valign="middle" ><strong>พ.ย.</strong></td>
<td width="94" align="center" valign="middle" ><strong>ธ.ค.</strong></td>
<td width="94" align="center" valign="middle" ><strong>ม.ค.</strong></td>
<td width="94" align="center" valign="middle" ><strong>ก.พ.</strong></td>
<td width="94" align="center" valign="middle" ><strong>มี.ค.</strong></td>
<td width="94" align="center" valign="middle" ><strong>เม.ย.</strong></td>
<td width="94" align="center" valign="middle" ><strong>พ.ค.</strong></td>
<td width="94" align="center" valign="middle" ><strong>มิ.ย.</strong></td>
<td width="94" align="center" valign="middle" ><strong>ก.ค.</strong></td>
<td width="94" align="center" valign="middle" ><strong>ส.ค.</strong></td>
<td width="94" align="center" valign="middle" ><strong>ก.ย.</strong></td>

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