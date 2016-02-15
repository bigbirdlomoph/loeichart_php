<?php
function __autoload($class_name){
	include'../class/class.'.$class_name.'.php';
}
set_time_limit(0);
include"../config/config.php";
require("../gobal/gobal_var.php");
 
 $table=$_GET['table'];
 $hospcode=$_GET['hospcode'];
 $fyear=$_GET['fyear'];
 $age=$_GET['age'];
 $ampcode=$_GET['ampcode'];

 
?>
<?php
$strExcelFileName="ตรวจพัฒนาการเด็ก.xls";
header("Content-Type: application/x-msexcel; name=\"$strExcelFileName\"");
header("Content-Disposition: inline; filename=\"$strExcelFileName\"");
header("Pragma:no-cache");

 
 $db=new Database(DB_HOST_TK,DB_USER_TK,DB_PASS_TK,DB_NAME_TK);
 $db->query("SELECT * FROM $table WHERE hospcode='".$hospcode."' and left(subdistid,4)='".$ampcode."'");
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
<thead >
          <tr class="bg-primary">
          <th rowspan="3" class="text-center">ตำบล </th>
          <th colspan="18" class="text-center"><?php echo ($fyear)-1;?></th>
          <th colspan="54" class="text-center"><?php echo $fyear;?></th>

          </tr>
          <tr class="bg-success" >
             
              <th colspan="6" class="text-center">ต.ค.</th>
              <th colspan="6" class="text-center">พ.ย.</th>
              <th colspan="6" class="text-center">ธ.ค.</th>
              <th colspan="6" class="text-center">ม.ค.</th>
             <th colspan="6" class="text-center">ก.พ.</th>
             <th colspan="6" class="text-center">มี.ค.</th>
             <th colspan="6"class="text-center" >เม.ย.</th>
             <th colspan="6" class="text-center">พ.ค.</th>
             <th colspan="6" class="text-center">มิ.ย.</th>
             <th colspan="6" class="text-center">ก.ค.</th>
             <th colspan="6" class="text-center">ส.ค.</th>
             <th colspan="6" class="text-center">ก.ย.</th>
                          
          </tr>
          <tr class="bg-info">
          <!--10-->
          		<td class="text-center">จำนวนเด็ก</td>
                <td class="text-center">ตรวจ</td>
            <td class="text-center">ร้อยละ</td>
            <td class="text-center">ปกติ</td>
            <td class="text-center">สงสัยช้ากว่าปกติ</td>
            <td class="text-center">ช้ากว่าปกติ</td>
            <!--11-->
          		<td class="text-center">จำนวนเด็ก</td>
                <td class="text-center">ตรวจ</td>
            <td class="text-center">ร้อยละ</td>
          <td class="text-center">ปกติ</td>
            <td class="text-center">สงสัยช้ากว่าปกติ</td>
            <td class="text-center">ช้ากว่าปกติ</td>

            <!--12-->
          		<td class="text-center">จำนวนเด็ก</td>
                <td class="text-center">ตรวจ</td>
            <td class="text-center">ร้อยละ</td>
            <td class="text-center">ปกติ</td>
            <td class="text-center">สงสัยช้ากว่าปกติ</td>
            <td class="text-center">ช้ากว่าปกติ</td>

            <!--1-->
          		<td class="text-center">จำนวนเด็ก</td>
                <td class="text-center">ตรวจ</td>
            <td class="text-center">ร้อยละ</td>
       		<td class="text-center">ปกติ</td>
            <td class="text-center">สงสัยช้ากว่าปกติ</td>
            <td class="text-center">ช้ากว่าปกติ</td>

          <!--2-->
          		<td class="text-center">จำนวนเด็ก</td>
                <td class="text-center">ตรวจ</td>
            <td class="text-center">ร้อยละ</td>
         	<td class="text-center">ปกติ</td>
            <td class="text-center">สงสัยช้ากว่าปกติ</td>
            <td class="text-center">ช้ากว่าปกติ</td>

          <!--3-->
          		<td class="text-center">จำนวนเด็ก</td>
                <td class="text-center">ตรวจ</td>
            <td class="text-center">ร้อยละ</td>
            <td class="text-center">ปกติ</td>
            <td class="text-center">สงสัยช้ากว่าปกติ</td>
            <td class="text-center">ช้ากว่าปกติ</td>

            <!--4-->
          		<td class="text-center">จำนวนเด็ก</td>
                <td class="text-center">ตรวจ</td>
            <td class="text-center">ร้อยละ</td>
             <td class="text-center">ปกติ</td>
            <td class="text-center">สงสัยช้ากว่าปกติ</td>
            <td class="text-center">ช้ากว่าปกติ</td>

             <!--5-->
          		<td class="text-center">จำนวนเด็ก</td>
                <td class="text-center">ตรวจ</td>
            <td class="text-center">ร้อยละ</td>
            <td class="text-center">ปกติ</td>
            <td class="text-center">สงสัยช้ากว่าปกติ</td>
            <td class="text-center">ช้ากว่าปกติ</td>

             <!--6-->
          		<td class="text-center">จำนวนเด็ก</td>
                <td class="text-center">ตรวจ</td>
            <td class="text-center">ร้อยละ</td>
             <td class="text-center">ปกติ</td>
            <td class="text-center">สงสัยช้ากว่าปกติ</td>
            <td class="text-center">ช้ากว่าปกติ</td>

             <!--7-->
          		<td class="text-center">จำนวนเด็ก</td>
                <td class="text-center">ตรวจ</td>
            <td class="text-center">ร้อยละ</td>
            <td class="text-center">ปกติ</td>
            <td class="text-center">สงสัยช้ากว่าปกติ</td>
            <td class="text-center">ช้ากว่าปกติ</td>

             <!--8-->
          		<td class="text-center">จำนวนเด็ก</td>
                <td class="text-center">ตรวจ</td>
            <td class="text-center">ร้อยละ</td>
			<td class="text-center">ปกติ</td>
            <td class="text-center">สงสัยช้ากว่าปกติ</td>
            <td class="text-center">ช้ากว่าปกติ</td>
          
             <!--9-->
          		<td class="text-center">จำนวนเด็ก</td>
                <td class="text-center">ตรวจ</td>
            <td class="text-center">ร้อยละ</td>
         	<td class="text-center">ปกติ</td>
            <td class="text-center">สงสัยช้ากว่าปกติ</td>
            <td class="text-center">ช้ากว่าปกติ</td>

          </tr>
     </thead>
   <tbody>     
<?php
if($num>0){
while($row=$arr_rs=$db->Fetch_array()){
?>
<tr>
       
		<td class="bg-info">
         <?php echo $arr_rs['subdistname']; ?> 
		</td>
        <td align="center">
		<?php echo number_format($arr_rs['m10']); ?> 
        </td>
         <td align="center">
        <?php echo number_format($arr_rs['m10_t']); ?>
		</td>
          <td align="center">
        <?php echo $arr_rs['P10']; ?>
		</td>  
  		<td align="center">
        <?php echo number_format($arr_rs['m10_1']); ?>
		</td>
        <td align="center">
        <?php echo number_format($arr_rs['m10_2']); ?>
		</td>
        <td align="center">
        <?php echo number_format($arr_rs['m10_3']); ?>
		</td>
        <td align="center">
		<?php echo number_format($arr_rs['m11']); ?> 
        </td>
         <td align="center">
        <?php echo number_format($arr_rs['m11_t']); ?>
		</td>
          <td align="center">
        <?php echo $arr_rs['P11']; ?>
		</td>  
        <td align="center">
        <?php echo number_format($arr_rs['m11_1']); ?>
		</td>
		<td align="center">
        <?php echo number_format($arr_rs['m11_2']); ?>
		</td>
		<td align="center">
        <?php echo number_format($arr_rs['m11_3']); ?>
		</td>

        <td align="center">
		<?php echo number_format($arr_rs['m12']); ?> 
        </td>
         <td align="center">
        <?php echo number_format($arr_rs['m12_t']); ?>
		</td>
          <td align="center">
        <?php echo $arr_rs['P12']; ?>
		</td> 
        <td align="center">
        <?php echo number_format($arr_rs['m12_1']); ?>
		</td>
        <td align="center">
        <?php echo number_format($arr_rs['m12_2']); ?>
		</td>
		<td align="center">
        <?php echo number_format($arr_rs['m12_3']); ?>
		</td>


        <td align="center">
		<?php echo number_format($arr_rs['m1']); ?> 
        </td>
         <td align="center">
        <?php echo number_format($arr_rs['m1_t']); ?>
		</td>
          <td align="center">
        <?php echo $arr_rs['P1']; ?>
		</td>  
         <td align="center">
        <?php echo number_format($arr_rs['m1_1']); ?>
		</td>
		<td align="center">
        <?php echo number_format($arr_rs['m1_2']); ?>
		</td>
		<td align="center">
        <?php echo number_format($arr_rs['m1_3']); ?>
		</td>

         <td align="center">
		<?php echo number_format($arr_rs['m2']); ?> 
        </td>
         <td align="center">
        <?php echo number_format($arr_rs['m2_t']); ?>
		</td>
          <td align="center">
        <?php echo $arr_rs['P2']; ?>
		</td>
         <td align="center">
        <?php echo number_format($arr_rs['m2_1']); ?>
		</td>
        <td align="center">
        <?php echo number_format($arr_rs['m2_2']); ?>
		</td>
		<td align="center">
        <?php echo number_format($arr_rs['m2_3']); ?>
		</td>


         <td align="center">
		<?php echo number_format($arr_rs['m3']); ?> 
        </td>
         <td align="center">
        <?php echo number_format($arr_rs['m3_t']); ?>
		</td>
          <td align="center">
        <?php echo $arr_rs['P3']; ?>
		</td>
        <td align="center">
        <?php echo number_format($arr_rs['m3_1']); ?>
		</td>
		<td align="center">
        <?php echo number_format($arr_rs['m3_2']); ?>
		</td>
        <td align="center">
        <?php echo number_format($arr_rs['m3_3']); ?>
		</td>


         <td align="center">
		<?php echo number_format($arr_rs['m4']); ?> 
        </td>
         <td align="center">
        <?php echo number_format($arr_rs['m4_t']); ?>
		</td>
          <td align="center">
        <?php echo $arr_rs['P4']; ?>
		</td>
        <td align="center">
        <?php echo number_format($arr_rs['m4_1']); ?>
		</td>
        <td align="center">
        <?php echo number_format($arr_rs['m4_2']); ?>
		</td>
        <td align="center">
        <?php echo number_format($arr_rs['m4_3']); ?>
		</td>
           <td align="center">
		<?php echo number_format($arr_rs['m5']); ?> 
        </td>
         <td align="center">
        <?php echo number_format($arr_rs['m5_t']); ?>
		</td>
          <td align="center">
        <?php echo $arr_rs['P5']; ?>
		</td>
        <td align="center">
        <?php echo number_format($arr_rs['m5_1']); ?>
		</td>
        <td align="center">
        <?php echo number_format($arr_rs['m5_2']); ?>
		</td>
        <td align="center">
        <?php echo number_format($arr_rs['m5_3']); ?>
		</td>
          <td align="center">
		<?php echo number_format($arr_rs['m6']); ?> 
        </td>
         <td align="center">
        <?php echo number_format($arr_rs['m6_t']); ?>
		</td>
          <td align="center">
        <?php echo $arr_rs['P6']; ?>
		</td>
         <td align="center">
        <?php echo number_format($arr_rs['m6_1']); ?>
		</td>
         <td align="center">
        <?php echo number_format($arr_rs['m6_2']); ?>
		</td>
         <td align="center">
        <?php echo number_format($arr_rs['m6_3']); ?>
		</td>
          <td align="center">
		<?php echo number_format($arr_rs['m7']); ?> 
        </td>
         <td align="center">
        <?php echo number_format($arr_rs['m7_t']); ?>
		</td>
          <td align="center">
        <?php echo $arr_rs['P7']; ?>
		</td>
         <td align="center">
        <?php echo number_format($arr_rs['m7_1']); ?>
		</td>
         <td align="center">
        <?php echo number_format($arr_rs['m7_2']); ?>
		</td>
         <td align="center">
        <?php echo number_format($arr_rs['m7_3']); ?>
		</td>
          <td align="center">
		<?php echo number_format($arr_rs['m8']); ?> 
        </td>
         <td align="center">
        <?php echo number_format($arr_rs['m8_t']); ?>
		</td>
          <td align="center">
        <?php echo $arr_rs['P8']; ?>
		</td>
        <td align="center">
        <?php echo number_format($arr_rs['m8_1']); ?>
		</td>
        <td align="center">
        <?php echo number_format($arr_rs['m8_2']); ?>
		</td>
        <td align="center">
        <?php echo number_format($arr_rs['m8_3']); ?>
		</td>
          <td align="center">
		<?php echo number_format($arr_rs['m9']); ?> 
        </td>
         <td align="center">
        <?php echo number_format($arr_rs['m9_t']); ?>
		</td>
          <td align="center">
        <?php echo $arr_rs['P9']; ?>
		</td>
                 <td align="center">
        <?php echo number_format($arr_rs['m9_1']); ?>
		</td>
                 <td align="center">
        <?php echo number_format($arr_rs['m9_2']); ?>
		</td>
                 <td align="center">
        <?php echo number_format($arr_rs['m9_3']); ?>
		</td>
	</tr>
<?php
}
}
?>
</tbody>
</table>
</div>
<script>
window.onbeforeunload = function(){return false;};
setTimeout(function(){window.close();}, 10000);
</script>
</body>
</html>