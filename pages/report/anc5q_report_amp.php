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
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="description" content="">
<meta name="author" content="">
<title>ANC</title>
         
</head>

<body>
<?php
//
$id=$_POST['id'];;//id report
$o_year=substr($_POST['str_date'],0,4);//year_old 10,11,12
$b_year=substr($_POST['end_date'],0,4);//year_next 
$ystr=$_POST['str_date'];
$yend=$_POST['end_date'];
$dbrpt=new Database(DB_HOST_TK,DB_USER_TK,DB_PASS_TK,DB_NAME_TK);//new object 

//
?>
<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
  <div class="container">
    <?php
 //select name report
  $dbrpt->Query("SELECT * FROM z42_sys_report WHERE id='$id' ORDER BY cat_id");
    while($arrrpt=$dbrpt->Fetch_array()){
		$sql_area=$arrrpt['query_areacode'];
		?>
		<h4><?php echo $arrrpt['report_name'];?> วันที่ : <?php echo substr($ystr,8,2);?> /<?php echo substr($ystr,5,2);?> /<?php echo $o_year+543;?> ถึง <?php echo substr($yend,8,2);?> /<?php echo substr($yend,5,2);?> /<?php echo $b_year+543;?></h4>
		<?php
        }
 
?>
  </div>
</nav>

 <div class="panel panel-info">
  <div class="panel-heading">ร้อยละหญิงตั้งครรภ์ที่ได้รับการดูแลก่อนคลอด 5 ครั้ง ตามเกณฑ์
  <a href="javascript:popup('../chart/chart_anc5q_amp.php?ystr=<?php echo $ystr;?>&yend=<?php echo $yend?>','',960,500)"class="btn btn-default btn-sm " role="button">
   View Chart
   </a>
  </div>
     <div class="panel-body">
            
<div class="table-responsive ">
<table class="table table-hover">
<thead>
          <tr>
              
              <th>อำเภอ</th>
                        <th>จำนวนหญิงที่คลอดแล้ว</th>
             <th>จำนวนหญิงตั้งครรภ์ที่คลอดแล้วได้รับการดูแลก่อนคลอด 5 ครั้ง</th>
           
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
				FROM z42_anc5q_s 
				LEFT OUTER JOIN z42_amp AS amp ON LEFT(z42_anc5q_s.areacode,4)=amp.AMP_CODE
				WHERE b_year BETWEEN'$o_year' AND '$b_year' AND date_com BETWEEN'$ystr' AND'$yend' 
				GROUP BY LEFT(areacode,4)
) as tb2 ON tb1.AMP_CODE=tb2.AMPCODE 
GROUP BY tb1.AMP_CODE  
UNION ALL
SELECT 
		'',
		'รวม',
		SUM(tb2.B) as B,
		SUM(tb2.A) AS A,
		ROUND((sum(tb2.A)/sum(tb2.B))*100,2) as P,
		SUM(tb2.M10) as M10,
		SUM(tb2.M11) as M11,
		SUM(tb2.M12) as M12,
		SUM(tb2.M09) as M09,
		SUM(tb2.M08) as M08,
		SUM(tb2.M07) as M07,
		SUM(tb2.M06) as M06,
		SUM(tb2.M05) as M05,
		SUM(tb2.M04) as M04,
		SUM(tb2.M03) as M03,
		SUM(tb2.M02) as M02,
		SUM(tb2.M01) as M01
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
				FROM z42_anc5q_s 
				LEFT OUTER JOIN z42_amp AS amp ON LEFT(z42_anc5q_s.areacode,4)=amp.AMP_CODE
				WHERE b_year BETWEEN'$o_year' AND '$b_year' AND date_com BETWEEN'$ystr' AND'$yend' 
				GROUP BY LEFT(areacode,4)
) as tb2 ON tb1.AMP_CODE=tb2.AMPCODE ;

 ");
while($arr_rs=$dbrpt->Fetch_array())
{
	
?>    
	<tr>
		<td>
         <a href="javascript:popup('anc5q_report_pcu.php?ampcode=<?php echo $arr_rs['AMPCODE'];?>&id=<?php echo $id;?>&b_year=<?php echo $b_year;?>&ystr=<?php echo $ystr;?>&yend=<?php echo $yend;?>','',960,500)"><?php echo $arr_rs['AMPNAME']; ?></a>
       
        
		</td>
                  <td>
        <?php echo  number_format($arr_rs['B']); ?>
		</td>
          <td>
        <?php echo  number_format($arr_rs['A']); ?>
		</td>

         <td>
        <?php echo $arr_rs['P']; ?>
		</td>
        <td>
        <?php echo  number_format($arr_rs['M10']); ?>
		</td>
            <td>
        <?php echo  number_format($arr_rs['M11']); ?>
		</td>
            <td>
        <?php echo  number_format($arr_rs['M12']); ?>
		</td>
            <td>
        <?php echo  number_format($arr_rs['M01']); ?>
		</td>
          <td>
        <?php echo  number_format($arr_rs['M02']); ?>
		</td>
         <td>
        <?php echo  number_format($arr_rs['M03']); ?>
		</td>
         <td>
        <?php echo  number_format($arr_rs['M04']); ?>
		</td>
         <td>
        <?php echo  number_format($arr_rs['M05']); ?>
		</td>
        <td>
        <?php echo  number_format($arr_rs['M06']); ?>
		</td>
         <td>
        <?php echo  number_format($arr_rs['M07']); ?>
		</td>
         <td>
        <?php echo  number_format($arr_rs['M08']); ?>
		</td>
         <td>
        <?php echo  number_format($arr_rs['M09']); ?>
		</td>
	</tr>
 
<?php }?>   
</table>
</div>
</div>
</div>
 
</body>
</html>
