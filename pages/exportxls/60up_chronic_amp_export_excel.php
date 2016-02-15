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
$strExcelFileName="60up_chronic_amp_export_excel.xls";
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
		     <th>ผู้ป่วยโรคเรื้อรัง_ชาย</th>
		     <th>ผู้ป่วยโรคเรื้อรัง_หญิง</th>
             <th>ผู้ป่วยโรคเรื้อรัง_รวม</th>
 		     <th>DM_ชาย</th>
		     <th>DM_หญิง</th>
             <th>DM_รวม</th>
             <th>HT_ชาย</th>
		     <th>HT_หญิง</th>
             <th>HT_รวม</th>
             <th>หัวใจขาดเลือด_ชาย</th>
		     <th>หัวใจขาดเลือด_หญิง</th>
             <th>หัวใจขาดเลือด_รวม</th>
             <th>หลอดเลือดสมอง_ชาย</th>
		     <th>หลอดเลือดสมอง_หญิง</th>
             <th>หลอดเลือดสมอง_รวม</th>              
             <th>โรคหัวใจ_ชาย</th>
		     <th>โรคหัวใจ_หญิง</th>
             <th>โรคหัวใจ_รวม</th>              
             <th>ถุงลมปอดโป่งพอง_ชาย</th>
		     <th>ถุงลมปอดโป่งพอง_หญิง</th>
             <th>ถุงลมปอดโป่งพอง_รวม</th>              
             <th>หอบหืด_ชาย</th>
		     <th>หอบหืด_หญิง</th>
             <th>หอบหืด_รวม</th>              
             <th>ไตวาย_ชาย</th>
		     <th>ไตวาย_หญิง</th>
             <th>ไตวาย_รวม</th>
             <th>ซึมเศร้า_ชาย</th>
		     <th>ซึมเศร้า_หญิง</th>
             <th>ซึมเศร้า_รวม</th>
             <th>ข้อเสื่อม_ชาย</th>
		     <th>ข้อเสื่อม_หญิง</th>
             <th>ข้อเสื่อม_รวม</th>                           
             <th>มากกว่า 1 โรค_ชาย</th>
		     <th>มากกว่า 1 โรค_หญิง</th>
             <th>มากกว่า 1 โรค_รวม</th>
			 
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
        <?php echo  number_format($arr_rs['CHRONIC_M']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['CHRONIC_FM']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['CHRONIC_TT']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['DM_M']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['DM_FM']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['DM_TT']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['HT_M']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['HT_FM']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['HT_TT']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['ISCHAEMIC_M']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['ISCHAEMIC_FM']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['ISCHAEMIC_TT']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['CVD_M']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['CVD_FM']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['CVD_TT']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['HEART_M']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['HEART_FM']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['HEART_TT']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['EMPHYSEMA_M']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['EMPHYSEMA_FM']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['EMPHYSEMA_TT']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['ASTHMA_M']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['ASTHMA_FM']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['ASTHMA_TT']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['RENAL_FAILURE_M']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['RENAL_FAILURE_FM']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['RENAL_FAILURE_TT']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['DEPRESS_M']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['DEPRESS_FM']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['DEPRESS_TT']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['ARTHROSIS_M']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['ARTHROSIS_FM']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['ARTHROSIS_TT']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['MORE1_M']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['MORE1_FM']); ?>
		</td>
		<td>
        <?php echo  number_format($arr_rs['MORE1_TT']); ?>
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