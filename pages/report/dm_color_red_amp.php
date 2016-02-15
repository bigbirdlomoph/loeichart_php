<?php
session_start() ;
if (!isset($_SESSION['login_true'])) {
     header("Location: login.php");//สั่งให้ redirect ไปหน้า login เมื่อไม่มีการ login แต่เรียกใช้หน้านี้
     exit;
}

?>
<?php
function __autoload($class_name){
	include'../class/class.'.$class_name.'.php';
}
set_time_limit(0);
include"../config/config.php";
////

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

<title>LOEI CHART | REPORT DATA</title>
<script type="text/javascript" src="https://www.google.com/jsapi"></script> 
</head>

<body>
<?php

$id=$_POST['id'];;//id report
$o_year=substr($_POST['str_date'],0,4);//year_old 10,11,12
$b_year=substr($_POST['end_date'],0,4);//year_next 
$ystr=$_POST['str_date'];
$yend=$_POST['end_date'];
$dbrpt=new Database(DB_HOST_TK,DB_USER_TK,DB_PASS_TK,DB_NAME_TK);//new object 
?>


 <div class="panel panel-info">
  <div class="panel-heading">จำนวนผู้ป่วยเบาหวาน สีแดง 
  <a href="javascript:popup('../chart/chart_dm_color_red_amp.php?ystr=<?php echo $ystr;?>&yend=<?php echo $yend?>','',960,500)"class="btn btn-default btn-sm " role="button">
   View Chart
   </a>

</div>
     <div class="panel-body">
    A = จำนวนผู้ป่วยเบาหวานที่มีค่าน้ำตาลในเลือดอดอาหาร (ค่าน้ำตาลในเลือดอดอาหาร ≥ 183 mg/dl) ในรอบเดือน<br>
    B = จำนวนผู้ป่วยเบาหวานที่มารับบริการในคลินิกบริการในรอบเดือนนั้นทั้งหมด       
<div class="table-responsive ">
<table class="table table-bordered table-hover">
<thead align="center">
          <tr>
             
            <th><div align="center">อำเภอ</div></th>
            <th><div align="center">จำนวนผู้ป่วย DM</div></th>
            <th><div align="center">สีแดง</div></th>
            <th><div align="center">ร้อยละ</div></th>
<!--             <th>สีส้ม</th>
             <th>สีแดง</th>
             <th>สีดำ</th>
             <th>ม.ค.</th>
             <th>ก.พ.</th>
             <th>มี.ค.</th>
             <th>ม.ย.</th>
             <th>พ.ค.</th>
             <th>มิ.ย.</th>
             <th>ก.ค.</th>
             <th>ส.ค.</th>
             <th>ก.ย.</th>-->
             
          </tr>
     </thead>
     <tbody>             
</tbody>
<?php

 $dbrpt->Query("
 SELECT 
        tb1.AMP_CODE as AMPCODE,
        tb1.AMP_NAME as AMPNAME,
        tb2.A AS A,
        tb2.B AS B,
        tb2.P AS P,
        tb2.orange as orange,
        tb2.red as red,
        tb2.black as black
FROM(
     SELECT 
           AMP_CODE,AMP_NAME  
            FROM z42_amp 
      GROUP BY AMP_CODE 
) as tb1
LEFT JOIN
(
    SELECT 
        amp.AMP_NAME AS AMPNAME,left(areacode,4) as AMPCODE,
        SUM(red) as A,
        SUM(target) as B,
        ROUND((sum(red)/sum(target))*100,2) as P,
        SUM(orange) as orange,SUM(red)AS red,SUM(black)AS black
        FROM z42_s_dm_color
        LEFT OUTER JOIN z42_amp AS amp ON LEFT(z42_s_dm_color.areacode,4)=amp.AMP_CODE
        WHERE b_year BETWEEN '$o_year' AND '$b_year' AND date_com BETWEEN '$ystr' AND '$yend' 
        GROUP BY LEFT(areacode,4)
) as tb2 ON tb1.AMP_CODE=tb2.AMPCODE 
GROUP BY tb1.AMP_CODE 
UNION ALL
     SELECT 
        'TOTAL' AS AMPNAME,'รวม' as AMPCODE,
        SUM(red) as A,
        SUM(target) as B,
        ROUND((sum(red)/sum(target))*100,2) as P,
        SUM(orange) as orange,SUM(red)AS red,SUM(black)AS black
        FROM z42_s_dm_color
        LEFT OUTER JOIN z42_amp AS amp ON LEFT(z42_s_dm_color.areacode,4)=amp.AMP_CODE
        WHERE b_year BETWEEN '$o_year' AND '$b_year' AND date_com BETWEEN '$ystr' AND '$yend' ;
  
 ");
while($arr_rs=$dbrpt->Fetch_array())
{
	$ampcode=$arr_rs['AMPCODE'];
?>    
	<tr>
       
		<td align="center">
         <a href="javascript:popup('dm_color_red_pcu.php?ampcode=<?php echo $arr_rs['AMPCODE'];?>&id=<?php echo $id;?>&b_year=<?php echo $b_year;?>&ystr=<?php echo $ystr;?>&yend=<?php echo $yend;?>','',960,500)"><?php echo $arr_rs['AMPNAME']; ?></a>
      
		</td>
          <td align="center">
        <?php echo number_format($arr_rs['B']); ?>
		</td>
          <td align="center">
        <?php echo number_format($arr_rs['A']); ?>
		</td>

         <td align="center">
        <?php echo $arr_rs['P']; ?>
		</td>
<!--        <td align="center">
        <?php echo $arr_rs['orange']; ?>
		</td>
            <td align="center">
        <?php echo $arr_rs['red']; ?>
		</td>
            <td align="center">
        <?php echo $arr_rs['black']; ?>
		</td>-->

        
	</tr>

<?php }?>   
</table>

</div>
</div>
</div>
 <!-- Core Scripts - Include with every page -->
   
</body>
</html>
