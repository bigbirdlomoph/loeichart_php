<?php
function __autoload($class_name){
	include'../class/class.'.$class_name.'.php';
}
set_time_limit(0);
include"../config/config.php";
require("../gobal/gobal_var.php");
 
$table=$_GET['table'];
$vhid=$_GET['vhid'];
$hcode=$_GET['hospcode'];
$id=$_GET['id'];
$age=$_GET['age'];
$fyear=$_GET['fyear'];
$m=$_GET['m'];
$i=1;


 
?>
<?php
$strExcelFileName="ตรวจพัฒนาการเด็ก.xls";
header("Content-Type: application/x-msexcel; name=\"$strExcelFileName\"");
header("Content-Disposition: inline; filename=\"$strExcelFileName\"");
header("Pragma:no-cache");

 
 $db=new Database(DB_HOST_TK,DB_USER_TK,DB_PASS_TK,DB_NAME_TK);
 $db->query("
 SELECT 
a.hospcode as HOSPCODE,
a.pid as PID,
CONCAT(a.`name`,' ',a.lname) as FNAME,
a.birth as BIRTH,
a.agemonth as AGEM,
a.namemother as MOM,
a.hospcode_nb as HNB,
a.hospcode_dx as HDX,
a.diaglbw as DLBW,
a.date_diaglbw as DATE_DLW,
a.diagba as DBA,
a.date_diagba as DATE_DBA,
CASE WHEN a.bweight BETWEEN 500 AND 2499 THEN 'label label-danger'
		 WHEN a.bweight < 500 THEN 'label label-warning'
		 WHEN a.bweight >=2500 THEN ''
			ELSE '' END AS BWC,
a.bweight AS BW,
CASE WHEN a.asphyxia='1' THEN 'label label-danger' 
			WHEN a.asphyxia='2' THEN 'ไม่ขาด'
			WHEN a.asphyxia='9' THEN 'ไม่ทราบ'
			ELSE '' END AS SPHYC,
CASE WHEN a.asphyxia='1' THEN 'ขาด' 
			WHEN a.asphyxia='2' THEN 'ไม่ขาด'
			WHEN a.asphyxia='9' THEN 'ไม่ทราบ'
			ELSE '' END AS SPHY,
CASE WHEN a.childdevelop='1' THEN 'ปกติ' 
			WHEN a.childdevelop='2' THEN 'สงสัยช้ากว่าปกติ'
			WHEN a.childdevelop='2' THEN 'ช้ากว่าปกติ'
			ELSE '' END AS DEVP,
			CASE WHEN a.ck ='0' THEN '#DC143C'
			WHEN a.ck ='1' THEN ''
			ELSE 'ERROR' END AS CK_DEV,
a.nutridate_serv as NTDAT_SERV,
a.HOUSE as HOUSE,
				CASE WHEN RIGHT(a.vhid,2)='01' THEN '1' 
				  WHEN RIGHT(a.vhid,2)='02' THEN '2'
					WHEN RIGHT(a.vhid,2)='03' THEN '3'
					WHEN RIGHT(a.vhid,2)='04' THEN '4'
					WHEN RIGHT(a.vhid,2)='05' THEN '5'
					WHEN RIGHT(a.vhid,2)='06' THEN '6'
					WHEN RIGHT(a.vhid,2)='07' THEN '7'
					WHEN RIGHT(a.vhid,2)='08' THEN '8'
					WHEN RIGHT(a.vhid,2)='09' THEN '9'
				  ELSE RIGHT(a.vhid,2) END AS VNO,
cvl.villname as VNAME,
ztb.tambonname as TBNAME,
zam.AMP_NAME as AMPNAME

FROM $table as a
LEFT OUTER JOIN co_village_loei as cvl ON a.vhid=cvl.villid
LEFT OUTER JOIN z42_tambon as ztb ON LEFT(a.vhid,6)=CONCAT(ztb.tamboncodefull)
LEFT OUTER JOIN z42_amp AS zam ON  LEFT(a.vhid,4)=CONCAT(zam.AMP_CODE)
LEFT OUTER JOIN 42co_office_loei as 42co ON a.HOSPCODE=42co.off_id
WHERE  a.vhid IS NOT NULL AND a.vhid <>'' AND a.vhid='".$vhid."' AND a.hospcode='".$hcode."'
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
<thead>
          <tr>
             <th>ลำดับ</th>  
             <th>รหัสพยาบาล</th>
             <th>PID</th>
             <th>ชื่อ-สกุล</th>
             <th>วันเดือนปีเกิด</th>
             <th>อายุเดือน</th>
              <th>น้ำหนักแรกเกิด</th>
               <th>ASPHYXAI</th>
               <th>พัฒนาการ</th>
               <th>วันที่ตรวจ</th>
             <th>มารดา</th>
              <th>สถานบริการที่เกิด</th>
              <th>สถานบริการที่ Diag</th>
              <th>diag LBW</th>
              <th>วันที่ diag LBW</th>
              <th>diag BA</th>
              <th>วันที่ diag BA</th>
             <th>บ้านเลขที่</th>
             <th>หมู่ที่</th>
             <th>หมู่บ้าน</th>
              <th>ตำบล</th>
              <th>อำเภอ</th>
             

          </tr>
     </thead>
   <tbody>     
<?php
if($num>0){
while($row=$arr_rs=$db->Fetch_array()){
?>
 <tr bgcolor="<?php echo $arr_rs['CK_DEV']; ?>" align="center" >
		<td><?php echo $i++;?></td>
        <td><?php echo $arr_rs['HOSPCODE'];?></td>
        <td>
        <?php echo $arr_rs['PID']; ?>
		</td>
          <td>
        <?php echo $arr_rs['FNAME']; ?>
		</td>

         <td>
        <?php echo $arr_rs['BIRTH']; ?>
		</td>
        <td>
        <?php echo $arr_rs['AGEM']; ?>
		</td>
         <td>
         <span class="<?php echo $arr_rs['BWC']; ?>">
        <?php echo $arr_rs['BW']; ?>
         </span>
		</td>
         <td>
         <span class="<?php echo $arr_rs['SPHYC']; ?>">
        <?php echo $arr_rs['SPHY']; ?>
        </span>
		</td>
          <td >
        <?php echo $arr_rs['DEVP']; ?>
		</td>
            <td>
        <?php echo $arr_rs['NTDAT_SERV']; ?>
		</td>
        <td>
           <?php echo $arr_rs['MOM'];?>
        </td>
          <td>
           <?php echo $arr_rs['HNB'];?>
        </td>
          <td>
           <?php echo $arr_rs['HDX'];?>
        </td>
          <td>
           <?php echo $arr_rs['DLBW'];?>
        </td>
         <td>
           <?php echo $arr_rs['DATE_DLBW'];?>
        </td>
          <td>
           <?php echo $arr_rs['DBA'];?>
        </td>
         <td>
           <?php echo $arr_rs['DATE_DBA'];?>
        </td>
         <td>
        <?php echo $arr_rs['HOUSE']; ?>
		</td>
        <td>
        <?php echo $arr_rs['VNO']; ?>
		</td>
          <td>
        <?php echo $arr_rs['VNAME']; ?>
		</td>
        <td>
        <?php echo $arr_rs['TBNAME']; ?>
		</td>
		       <td>
        <?php echo $arr_rs['AMPNAME']; ?>
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