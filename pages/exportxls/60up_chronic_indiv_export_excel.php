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
$strExcelFileName="60up_chronic_indiv_export_excel.xls";
header("Content-Type: application/x-msexcel; name=\"$strExcelFileName\"");
header("Content-Disposition: inline; filename=\"$strExcelFileName\"");
header("Pragma:no-cache");

 $db=new Database(DB_HOST_TK,DB_USER_TK,DB_PASS_TK,DB_NAME_TK);
 $db->Query("select * from z42_60up_chronic_t where HOSPCODE=$hospcode and VHID=$vhid and chronic_ck='1' ");
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
             <th>DM</th>
             <th>HT</th>
			 <th>หัวใจขาดเลือด</th>
             <th>หลอดเลือดสมอง</th>
             <th>โรคหัวใจ</th>
             <th>ถุงลมปอดโป่งพอง</th>
             <th>หอบหืด</th>             
             <th>ไตวาย</th>
             <th>ซึมเศร้า</th>
             <th>ข้อเสื่อม</th>             
             <th>>1 โรค</th>           
			 <th>บ้านเลขที่</th>
			 <th>รหัสหมู่บ้าน</th>
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
        <?php echo  $arr_rs['DM']; ?>
		</td>
        <td>
        <?php echo  $arr_rs['HT']; ?>
		</td>
		<td>
        <?php echo  $arr_rs['ISCHAEMIC']; ?>
		</td>
        <td>
        <?php echo  $arr_rs['CVD']; ?>
		</td>
        <td>
        <?php echo  $arr_rs['HEART']; ?>  
		</td>
         <td>
        <?php echo  $arr_rs['EMPHYSEMA']; ?>  
		</td>
        <td>
        <?php echo  $arr_rs['ASTHMA']; ?>  
		</td>
        <td>
        <?php echo  $arr_rs['RENAL_FAILURE']; ?>  
		</td>
        <td>
        <?php echo  $arr_rs['DEPRESS']; ?>
		</td>
        <td>
        <?php echo  $arr_rs['ARTHROSIS']; ?>
		</td>
        <td>
        <?php echo  $arr_rs['MORE1']; ?>
		</td>
		<td>
        <?php echo  $arr_rs['HOUSE']; ?>
		</td>
		<td>
        <?php echo  $arr_rs['VHID']; ?>
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