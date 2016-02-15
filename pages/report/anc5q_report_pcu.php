<?php
session_start() ;
if (!isset($_SESSION['login_true'])) {
     header("Location: login.php");//สั่งให้ redirect ไปหน้า login เมื่อไม่มีการ login แต่เรียกใช้หน้านี้
     exit;
}

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>LOEI CHART | REPORT DATA</title>

    <!-- Bootstrap Core CSS -->
    <link href="../../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../../bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Timeline CSS -->
    <link href="../../dist/css/timeline.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="../../bower_components/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../../bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
</head>

<body>
<?php
function __autoload($class_name){
	include'../class/class.'.$class_name.'.php';
}
set_time_limit(0);
include"../config/config.php";
?>
<?php
$ampcode=$_GET['ampcode'];
$id=$_GET['id'];
$o_year=substr($_GET['ystr'],0,4);
$b_year=$_GET['b_year'];
$ystr=$_GET['ystr'];;
$yend=$_GET['yend'];
//
$dbrpt=new Database(DB_HOST_TK,DB_USER_TK,DB_PASS_TK,DB_NAME_TK);//new object 

?>
<div class="panel panel-info">
<div class="panel-heading">
<?php
//select name report
  $dbrpt->Query("SELECT * FROM z42_sys_report WHERE id='$id' ORDER BY source_table");
    while($arrrpt=$dbrpt->Fetch_array()){
		?>
   
		<h4><?php echo $arrrpt['report_name'];?> วันที่ : <?php echo substr($ystr,8,2);?> /<?php echo substr($ystr,5,2);?> /<?php echo $o_year+543;?> ถึง <?php echo substr($yend,8,2);?> /<?php echo substr($yend,5,2);?> /<?php echo $b_year+543;?></h4>
		<?php
        }
?>

</div>

  <div class="panel-body">
<div class="table-responsive ">
<table class="table table-hover">
<thead>
          <tr>
              
             <th>สถานพยาบาล</th>
             <th>รหัสพยาบาล</th>
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
             <th>Excel</th>

          </tr>
     </thead>
     <tbody>             
</tbody>
<?php

 $dbrpt->Query("
				 SELECT 
		tb1.HCODE as HCODE,
		tb1.HNAME as HNAME,
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
           off_id as HCODE,
           off_name  as HNAME
			FROM z42_co_office_loei WHERE distid ='$ampcode' AND off_type IN('03','07','06')
      GROUP BY off_id 
) as tb1
LEFT JOIN
(
	SELECT 
					
					42loei.off_name AS HNAME,
					42loei.off_id AS HCODE,
					sum(target) as B,
					sum(result) as A,
					ROUND((sum(result)/sum(target))*100,2) as P,
					SUM(result10) as M10,SUM(result11)AS M11,SUM(result12)AS M12,
					SUM(result09) as M09,SUM(result08)AS M08,SUM(result07)AS M07,
					SUM(result06) as M06,SUM(result05)AS M05,SUM(result04)AS M04,
					SUM(result03) as M03,SUM(result02)AS M02,SUM(result01)AS M01
					FROM z42_anc5q_s 
					left  OUTER JOIN z42_co_office_loei AS 42loei on z42_anc5q_s.hospcode=42loei.off_id 
					WHERE b_year BETWEEN'$o_year' AND '$b_year' AND date_com BETWEEN'$ystr' AND'$yend' 
					AND left(areacode,4)=$ampcode GROUP BY hospcode
) as tb2 ON tb1.HCODE=tb2.HCODE
GROUP BY tb1.HCODE 
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
           off_id as HCODE,
           off_name  as HNAME
			FROM z42_co_office_loei WHERE distid ='$ampcode' AND off_type IN('03','07','06')
      GROUP BY off_id 
) as tb1
LEFT JOIN
(
	SELECT 
					
					42loei.off_name AS HNAME,
					42loei.off_id AS HCODE,
					sum(target) as B,
					sum(result) as A,
					ROUND((sum(result)/sum(target))*100,2) as P,
					SUM(result10) as M10,SUM(result11)AS M11,SUM(result12)AS M12,
					SUM(result09) as M09,SUM(result08)AS M08,SUM(result07)AS M07,
					SUM(result06) as M06,SUM(result05)AS M05,SUM(result04)AS M04,
					SUM(result03) as M03,SUM(result02)AS M02,SUM(result01)AS M01
					FROM z42_anc5q_s 
					left  OUTER JOIN z42_co_office_loei AS 42loei on z42_anc5q_s.hospcode=42loei.off_id 
					WHERE b_year BETWEEN'$o_year' AND '$b_year' AND date_com BETWEEN'$ystr' AND'$yend' 
					AND left(areacode,4)=$ampcode GROUP BY hospcode
) as tb2 ON tb1.HCODE=tb2.HCODE
				");
while($arr_rs=$dbrpt->Fetch_array()){
	
?>    
	<tr>
		<td>
         <a href="anc5q_report_pcu_cid.php?hcode=<?php echo$arr_rs['HCODE'];?>&b_year=<?php echo$b_year?>&ystr=<?php echo $ystr;?>&yend=<?php echo $yend;?>"><?php echo $arr_rs['HNAME']; ?></a>     
		</td>
        <td><?php echo $arr_rs['HCODE'];?></td>
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
        <?php echo $arr_rs['M10']; ?>
		</td>
            <td>
        <?php echo $arr_rs['M11']; ?>
		</td>
            <td>
        <?php echo $arr_rs['M12']; ?>
		</td>
            <td>
        <?php echo $arr_rs['M01']; ?>
		</td>
          <td>
        <?php echo $arr_rs['M02']; ?>
		</td>
         <td>
        <?php echo $arr_rs['M03']; ?>
		</td>
         <td>
        <?php echo $arr_rs['M04']; ?>
		</td>
         <td>
        <?php echo $arr_rs['M05']; ?>
		</td>
        <td>
        <?php echo $arr_rs['M06']; ?>
		</td>
         <td>
        <?php echo $arr_rs['M07']; ?>
		</td>
         <td>
        <?php echo $arr_rs['M08']; ?>
		</td>
         <td>
        <?php echo $arr_rs['M09']; ?>
		</td>
         <td align="center"><a href="../exportxls/anc5q_export_excell.php?hcode=<?php echo $arr_rs['HCODE'];?>&id=<?php echo $id ;?>&b_year=<?php echo $b_year;?>&ystr=<?php echo $ystr;?>&yend=<?php echo $yend;?>" title="ส่งออก Excell"><i class="fa fa-file-excel-o"></i></a></td>
	</tr>
 
<?php }?>   
</table>
</div>
</div>
</div>



<!-- jQuery -->
    <script src="../../bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../../bower_components/metisMenu/dist/metisMenu.min.js"></script>

    

    <!-- Custom Theme JavaScript -->
    <script src="../../dist/js/sb-admin-2.js"></script>
    <script src="../js/sb-admin.js"></script>

</body>
</html>
