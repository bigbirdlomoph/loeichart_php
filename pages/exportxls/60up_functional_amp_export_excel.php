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
$strExcelFileName="60up_functional_amp_export_excel.xls";
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
             <th>ผู้สูงอายุ_ชาย</th>
             <th>ผู้สูงอายุ_หญิง</th>
             <th>ผู้สูงอายุ_รวม</th>
		     <th>ประเมินความบกพร่อง_ชาย</th>
		     <th>ประเมินความบกพร่อง_หญิง</th>
             <th>ประเมินความบกพร่อง_รวม</th>
 		     <th>Barthead ADL Index_ชาย</th>
		     <th>Barthead ADL Index_หญิง</th>
             <th>Barthead ADL Index_รวม</th>
             <th>IADL_ชาย</th>
		     <th>IADL_หญิง</th>
             <th>IADL_รวม</th>
             <th>Mental_ชาย</th>
		     <th>Mental_หญิง</th>
             <th>Mental_รวม</th>
             <th>Other_ชาย</th>
		     <th>Other_หญิง</th>
             <th>Other_รวม</th>              
             <th>Unspecified_ชาย</th>
		     <th>Unspecified_หญิง</th>
             <th>Unspecified_รวม</th>              
             <th>ไม่พึ่งพิง_ชาย</th>
		     <th>ไม่พึ่งพิง_หญิง</th>
             <th>ไม่พึ่งพิง_รวม</th>              
             <th>พึ่งพิงน้อย_ชาย</th>
		     <th>พึ่งพิงน้อย_หญิง</th>
             <th>พึ่งพิงน้อย_รวม</th>              
             <th>พึ่งพิงมาก_ชาย</th>
		     <th>พึ่งพิงมาก_หญิง</th>
             <th>พึ่งพิงมาก_รวม</th>
			 
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
        <?php echo  number_format($arr_rs['M']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['FM']); ?>
		</td>
        <td>
        <?php echo  number_format($arr_rs['TT']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['FUNC_M']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['FUNC_FM']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['FUNC_TT']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['ADL_M']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['ADL_FM']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['ADL_TT']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['IADL_M']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['IADL_FM']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['IADL_TT']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['MENTAL_M']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['MENTAL_FM']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['MENTAL_TT']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['OTHER_M']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['OTHER_FM']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['OTHER_TT']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['UNPS_M']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['UNPS_FM']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['UNPS_TT']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['DEPEN_no_M']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['DEPEN_no_FM']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['DEPEN_no_TT']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['DEPEN_less_M']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['DEPEN_less_FM']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['DEPEN_less_TT']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['DEPEN_more_M']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['DEPEN_more_FM']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['DEPEN_more_TT']); ?>
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