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
$hospcode=$_GET['hospcode'];
$vhid=$_GET['vhid'];
?>
<?php
$strExcelFileName="60up_disab_indiv_export_excel.xls";
header("Content-Type: application/x-msexcel; name=\"$strExcelFileName\"");
header("Content-Disposition: inline; filename=\"$strExcelFileName\"");
header("Pragma:no-cache");

 $db=new Database(DB_HOST_TK,DB_USER_TK,DB_PASS_TK,DB_NAME_TK);
 $db->Query("select * from z42_disab_t where HOSPCODE=$hospcode and VHID=$vhid and age>=60 ORDER BY HOSPCODE,CID");
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
              
             <th>ลำดับ</th>
             <th>เลขบัตรประชาชน</th>
             <th>คำนำหน้า</th>				 
             <th>ชื่อ</th>	 
             <th>นามสกุล</th>
             <th>วันเกิด</th>	
			 <th>อายุ</th>
             <th>วันทีขึ้นทะเบียนผู้พิการ (พม)</th>
             <th>เลขทะเบียนผู้พิการ</th>
			 <th>ประเภทความพิการ</th>
             <th>สาเหตุความพิการ</th>
             <th>วันทีเริ่มมีความพิการ</th>
			 <th>บ้านเลขที่</th>
			 <th>รหัสหมู่บ้าน</th>
             <th>TYPEAREA</th>              
             <th>วันที่ประมวลผล</th>  
			 
          </tr>
<?php
if($num>0){
while($row=$arr_rs=$db->Fetch_array()){
?>
	<tr>

		<td>
        <?php echo $i++; ?>
		</td>        		
		<td>
        <?php echo  $arr_rs['CID']; ?>
		</td>
        <td>
        <?php echo  $arr_rs['PRENAME']; ?>
		</td>
		<td>
        <?php echo  $arr_rs['NAME']; ?>
		</td>
        <td>
        <?php echo  $arr_rs['LNAME']; ?>
		</td>
		<td>
        <?php echo DateThai($arr_rs['BIRTH']); ?>
		</td>
		<td>
        <?php echo  $arr_rs['AGE']; ?>
		</td>
        <td>
        <?php echo  DateThai($arr_rs['DATE_DETECT']); ?>
		</td>
        <td>
        <?php echo  $arr_rs['DISABID']; ?>
		</td>
		<td>
        <?php echo  $arr_rs['DISAB_NAME']; ?>
		</td>
        <td>
        <?php echo  $arr_rs['DISABCAUSE']; ?>
		</td>
        <td>
        <?php echo  DateThai($arr_rs['DATE_DISAB']); ?>
		</td>
		<td>
        <?php echo  $arr_rs['HOUSE']; ?>
		</td>
		<td>
        <?php echo  $arr_rs['VHID']; ?>
		</td>
        <td>
        <?php echo  $arr_rs['TYPEAREA']; ?>
		</td>
		<td>
        <?php echo  DateThai($arr_rs['DUPDATE']); ?>
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