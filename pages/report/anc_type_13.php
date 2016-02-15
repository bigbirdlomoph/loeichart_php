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
<title>anc type 1 3</title>
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
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>      
</head>

<body>
<?php

$id=$_GET['id'];//id report
//$o_year=substr($_GET['str_date'],0,4);//year_old 10,11,12
//$b_year=substr($_GET['end_date'],0,4);//year_next 
//$ystr=$_GET['str_date'];
//$yend=$_GET['end_date'];
 $dbrpt=new Database(DB_HOST_TK,DB_USER_TK,DB_PASS_TK,DB_NAME_TK);//new object 
?>
<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
  <div class="container">
    <?php
 //select name report
  $dbrpt->Query("SELECT * FROM z42_sys_report WHERE id='$id' ORDER BY cat_id");
    while($arrrpt=$dbrpt->Fetch_array()){
		$sql_area=$arrrpt['query_areacode'];
		?>
		<h4><?php echo $arrrpt['report_name'];?></h4>
		<?php
        }
 
?>
  </div>
</nav>

<!---->
 <div class="panel panel-info">
  <div class="panel-heading">หญิงตั้งครรภ์ Type 1 3</div>
     <div class="panel-body">
            
<div class="table-responsive ">
<table class="table table-bordered table-hover">
<thead>
          <tr>
             
              <th>อำเภอ</th>
                        <th>จำนวนหญิงที่ฝากครรภ์</th>
             
          </tr>
     </thead>
     <tbody>             
</tbody>
<?php

 $dbrpt->Query("
SELECT 
		tb1.AMP_CODE as AMPCODE,
		tb1.AMP_NAME as AMPNAME,
    	tb2.anc_cc as ANC_CC
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
				left(anc_13.vhid,4) as AMPCODE,
        COUNT(anc_13.HOSPCODE_ANC) as anc_cc
				FROM tmplomoph_person_anc_type1_3 as anc_13
				LEFT OUTER JOIN z42_amp AS amp ON LEFT(anc_13.vhid,4)=amp.AMP_CODE
			   
				GROUP BY LEFT(anc_13.vhid,4)
) as tb2 ON tb1.AMP_CODE=tb2.AMPCODE 
GROUP BY tb1.AMP_CODE
UNION ALL

SELECT 
		'',
		'รวม',
    	SUM(tb2.anc_cc) as ANC_CC
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
				left(anc_13.vhid,4) as AMPCODE,
        COUNT(anc_13.HOSPCODE_ANC) as anc_cc
				FROM tmplomoph_person_anc_type1_3 as anc_13
				LEFT OUTER JOIN z42_amp AS amp ON LEFT(anc_13.vhid,4)=amp.AMP_CODE
			   
				GROUP BY LEFT(anc_13.vhid,4)
) as tb2 ON tb1.AMP_CODE=tb2.AMPCODE 
 ");
while($arr_rs=$dbrpt->Fetch_array())
{
	$ampcode=$arr_rs['AMPCODE'];
?>    
	<tr>
       
		<td>
     <a href="javascript:popup('anc_type_13_pcu.php?ampcode=<?php echo $arr_rs['AMPCODE'];?>&id=<?php echo $id;?>','',960,500)"><?php echo $arr_rs['AMPNAME']; ?></a>        
		</td>
         <td align="center">
        <?php echo $arr_rs['ANC_CC']; ?>
		</td>     
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
