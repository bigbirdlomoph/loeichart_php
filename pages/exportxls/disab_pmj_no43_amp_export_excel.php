<?php
function __autoload($class_name){
	include'../class/class.'.$class_name.'.php';
}
set_time_limit(0);
include"../config/config.php";
include"../function/function.php";
//require("../gobal/gobal_var.php");
$age =$_GET['age'];
$id=$_GET['id'];
$table=$_GET['table'];
?>
<?php
$strExcelFileName="disab_pmj_no43_amp_export_excel.xls";
header("Content-Type: application/x-msexcel; name=\"$strExcelFileName\"");
header("Content-Disposition: inline; filename=\"$strExcelFileName\"");
header("Pragma:no-cache");

 $db=new Database(DB_HOST_TK,DB_USER_TK,DB_PASS_TK,DB_NAME_TK);
 $db->Query("select * from $table");
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
              
             <th>อำเภอ</th>
             <th>จำนวนคนพิการ</th>
             <th>ชาย</th>
             <th>หญิง</th>
			 
          </tr>
<?php
if($num>0){
while($row=$arr_rs=$db->Fetch_array()){
?>
	<tr>
         
         <td>
         <?php echo $arr_rs['AMPNAME']; ?>
		</td>      
        <td>
        <?php echo  number_format($arr_rs['CC']); ?>
		</td>
         <td>
        <?php echo  number_format($arr_rs['M']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['FM']); ?>
		</td>
		
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