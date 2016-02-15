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
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
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
$o_year=substr($_GET['ystr'],0,4);;
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
             <th>จำนวนหญิงที่มาฝากครรภ์</th>
             <th>น้อยกว่าหรือเท่ากับ 12 สัปดาห์</th>
           
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
					42loei.off_name AS HNAME,
					42loei.off_id AS HCODE,
					sum(target) as B,
					sum(result) as A,
					ROUND((sum(result)/sum(target))*100,2) as P,
					SUM(result10) as M10,SUM(result11)AS M11,SUM(result12)AS M12,
					SUM(result09) as M09,SUM(result08)AS M08,SUM(result07)AS M07,
					SUM(result06) as M06,SUM(result05)AS M05,SUM(result04)AS M04,
					SUM(result03) as M03,SUM(result02)AS M02,SUM(result01)AS M01
					FROM z42_anc12w_s 
					left  OUTER JOIN z42_co_office_loei AS 42loei on 42loei.off_id = z42_anc12w_s.hospcode
					WHERE b_year BETWEEN'$o_year' AND '$b_year' AND date_com BETWEEN'$ystr' AND'$yend' 
					AND left(areacode,4)=$ampcode GROUP BY hospcode;
				");
while($arr_rs=$dbrpt->Fetch_array()){
	
?>    
	<tr>
		<td>
         <a href="anc_report_12w_pcu_cid.php?hcode=<?php echo $arr_rs['HCODE'];?>&b_year=<?php echo $b_year;?>&ystr=<?php echo $ystr;?>&yend=<?php echo $yend;?>" ><?php echo $arr_rs['HNAME']; ?></a>     
		</td>
        <td><?php echo $arr_rs['HCODE'];?></td>
        <td>
        <?php echo $arr_rs['B']; ?>
		</td>
          <td>
        <?php echo $arr_rs['A']; ?>
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
         <td align="center"><a href="../exportxls/anc_12w_export_excell.php?hcode=<?php echo $arr_rs['HCODE'];?>&id=<?php echo $id ;?>&b_year=<?php echo $b_year;?>&ystr=<?php echo $ystr;?>&yend=<?php echo $yend;?>" title="ส่งออก Excell"><i class="fa fa-file-excel-o"></i></a></td>
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
