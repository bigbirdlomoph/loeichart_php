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
  <div class="panel-heading">ร้อยละหญิง อายุ 10 - 14 ปี คลอดมีชีพ 
  <a href="javascript:popup('../chart/chart_teenage_anc_1014_amp.php?ystr=<?php echo $ystr;?>&yend=<?php echo $yend?>','',960,500)"class="btn btn-default btn-sm " role="button">
   View Chart
   </a>

</div>
     <div class="panel-body">
            
<div class="table-responsive ">
<table class="table table-bordered table-hover">
<thead>
          <tr>
             
              <th>อำเภอ</th>
                        <th>หญิงอายุ 10-14 ปี ตั้งครรภ์</th>
             <th>คลอดมีชีพ</th>
           
             <th>ร้อยละ</th>
             <th>ต.ค.</th>
             <th>พ.ย.</th>
             <th>ธ.ค.</th>
             <th>ม.ค.</th>
             <th>ก.พ.</th>
             <th>มี.ค.</th>
             <th>ม.ย.</th>
             <th>พ.ค.</th>
             <th>มิ.ย.</th>
             <th>ก.ค.</th>
             <th>ส.ค.</th>
             <th>ก.ย.</th>
             
          </tr>
     </thead>
     <tbody>             
</tbody>
<?php

 $dbrpt->Query("
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
				SUM(result10) as M10,SUM(result11)AS M11,SUM(result12)AS M12,
				SUM(result09) as M09,SUM(result08)AS M08,SUM(result07)AS M07,
				SUM(result06) as M06,SUM(result05)AS M05,SUM(result04)AS M04,
				SUM(result03) as M03,SUM(result02)AS M02,SUM(result01)AS M01
				FROM z42_anc_teenage_1014_s 
				LEFT OUTER JOIN z42_amp AS amp ON LEFT(z42_anc_teenage_1014_s.areacode,4)=amp.AMP_CODE
				WHERE b_year BETWEEN'$o_year' AND '$b_year' AND date_com BETWEEN'$ystr' AND'$yend' 
				GROUP BY LEFT(areacode,4)
) as tb2 ON tb1.AMP_CODE=tb2.AMPCODE 
GROUP BY tb1.AMP_CODE  ;
  
 ");
while($arr_rs=$dbrpt->Fetch_array())
{
	$ampcode=$arr_rs['AMPCODE'];
?>    
	<tr>
       
		<td align="center">
         <a href="javascript:popup('teenage_anc_1014_pcu.php?ampcode=<?php echo $arr_rs['AMPCODE'];?>&id=<?php echo $id;?>
         &b_year=<?php echo $b_year;?>&ystr=<?php echo $ystr;?>&yend=<?php echo $yend;?>','',960,500)">
         <?php echo $arr_rs['AMPNAME']; ?></a>
      
		</td>
          <td align="center">
        <?php echo $arr_rs['B']; ?>
		</td>
          <td align="center">
        <?php echo $arr_rs['A']; ?>
		</td>

         <td align="center">
        <?php echo $arr_rs['P']; ?>
		</td>
        <td align="center">
        <?php echo $arr_rs['M10']; ?>
		</td>
            <td align="center">
        <?php echo $arr_rs['M11']; ?>
		</td>
            <td align="center">
        <?php echo $arr_rs['M12']; ?>
		</td>
            <td align="center">
        <?php echo $arr_rs['M01']; ?>
		</td>
          <td align="center">
        <?php echo $arr_rs['M02']; ?>
		</td>
         <td align="center">
        <?php echo $arr_rs['M03']; ?>
		</td>
         <td align="center">
        <?php echo $arr_rs['M04']; ?>
		</td>
         <td align="center">
        <?php echo $arr_rs['M05']; ?>
		</td>
        <td align="center">
        <?php echo $arr_rs['M06']; ?>
		</td>
         <td align="center">
        <?php echo $arr_rs['M07']; ?>
		</td>
         <td align="center">
        <?php echo $arr_rs['M08']; ?>
		</td>
         <td align="center">
        <?php echo $arr_rs['M09']; ?>
		</td>
        
	</tr>
     <div class="list-group">
     
      <?php 
	  $dbrpt_e=new Database(DB_HOST_TK,DB_USER_TK,DB_PASS_TK,DB_NAME_TK);
	  $dbrpt_e->Query("
				SELECT 
				amp.AMP_NAME AS AMPNAME,
				left(areacode,4) as AMPCODE,
				sum(target) as Be,
				sum(result) as Ae,
				ROUND((sum(result)/sum(target))*100,2) as Pe,
				SUM(result10) as M10e,SUM(result11)AS M11e,SUM(result12)AS M12e,
				SUM(result09) as M09e,SUM(result08)AS M08e,SUM(result07)AS M07e,
				SUM(result06) as M06e,SUM(result05)AS M05e,SUM(result04)AS M04e,
				SUM(result03) as M03e,SUM(result02)AS M02e,SUM(result01)AS M01e
				FROM z42_anc12w_s_error 
				LEFT OUTER JOIN z42_amp AS amp ON LEFT(z42_anc12w_s_error.areacode,4)=amp.AMP_CODE
				WHERE b_year BETWEEN'$o_year' AND '$b_year' AND date_com BETWEEN'$ystr' AND'$yend' 
				AND LEFT(areacode,4)='$ampcode' 
	");
	$arr_e=$dbrpt_e->Fetch_array();
	  ?>
      
    <tr class="bg-danger">
     <td align="center">
         <a href="javascript:popup('anc_report_12w_pcu_error.php?ampcode=<?php echo $arr_e['AMPCODE'];?>&id=<?php echo $id;?>&b_year=<?php echo $b_year;?>&ystr=<?php echo $ystr;?>&yend=<?php echo $yend;?>','',960,500)">ข้อมูลมีปัญหา</a>
       
        
		</td>
     </td>
         <td align="center">
        <?php echo $arr_e['Be']; ?>
		</td>
          <td align="center">
        <?php echo $arr_e['Ae']; ?>
		</td>

         <td align="center">
        <?php echo $arr_e['Pe']; ?>
		</td>
        <td align="center">
        <?php echo $arr_e['M10e']; ?>
		</td>
            <td align="center">
        <?php echo $arr_e['M11e']; ?>
		</td>
            <td align="center">
        <?php echo $arr_e['M12e']; ?>
		</td>
            <td align="center">
        <?php echo $arr_e['M01e']; ?>
		</td>
          <td align="center">
        <?php echo $arr_e['M02e']; ?>
		</td>
         <td align="center">
        <?php echo $arr_e['M03e']; ?>
		</td>
         <td align="center">
        <?php echo $arr_e['M04e']; ?>
		</td>
         <td align="center">
        <?php echo $arr_e['M05e']; ?>
		</td>
        <td align="center">
        <?php echo $arr_e['M06e']; ?>
		</td>
         <td align="center">
        <?php echo $arr_e['M07e']; ?>
		</td>
         <td align="center">
        <?php echo $arr_e['M08e']; ?>
		</td>
         <td align="center">
        <?php echo $arr_e['M09e']; ?>
		</td>
    </tr>
     </div>
<?php }?>   
</table>

</div>
</div>
</div>
 <!-- Core Scripts - Include with every page -->
   
</body>
</html>
