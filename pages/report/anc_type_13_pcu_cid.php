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
</head>

<body>
<?php
function __autoload($class_name){
	include'../class/class.'.$class_name.'.php';
}
set_time_limit(0);
include"../config/config.php";
$hcode=$_GET['hcode'];
$b_year=$_GET['b_year'];

$ystr=$_GET['ystr'];
$yend=$_GET['yend'];
$dbrpt=new Database(DB_HOST_TK,DB_USER_TK,DB_PASS_TK,DB_NAME_TK);//new object 
?>
<div class="panel panel-info">
<div class="panel-heading"></div>
<div class="panel-body">
<div class="table-responsive ">
<table class="table table-hover">
<thead>
          <tr>
              
             
             <th>รหัสพยาบาลที่รับ ANC</th>
             <th>รหัสพยาบาล TYPE 1,3</th>
             <th>CID</th>
             <th>บ้านเลขที่</th>
             <th>VHID</th>
             <th>หมู่บ้าน</th>
   			 <th>TYPE AREA</th>
          </tr>
     </thead>
     <tbody>             
</tbody>
<?php

 $dbrpt->Query("
				
		SELECT 
				anc_13.HOSPCODE_ANC as HOSPCODE_ANC,
				anc_13.HOSPCODE_1_3 as HOSPCODE,
				anc_13.cid as CID,
				anc_13.house as HOUSE,
				anc_13.vhid as VHID,
				anc_13.TYPEAREA as TYPE_AREA, 
				cvl.villname as VILLNAME
				FROM  tmplomoph_person_anc_type1_3 as anc_13
				INNER JOIN co_village_loei as cvl ON anc_13.vhid=cvl.villid AND anc_13.HOSPCODE_1_3=cvl.hospcode
				WHERE  anc_13.HOSPCODE_1_3='$hcode' 
			
				");
while($arr_rs=$dbrpt->Fetch_array()){
	  $anc=$arr_rs['ANC12'];
?>    
	<tr>
	      <td><?php echo $arr_rs['HOSPCODE_ANC'];?></td>
          <td><?php echo $arr_rs['HOSPCODE'];?></td>
        <td><a href="javascript:popup('#?hcode=<?php echo $arr_rs['HOSPCODE'];?>','',960,500)"><?php echo $arr_rs['CID'];?></a></td>
           
        <td>
        <?php echo $arr_rs['HOUSE']; ?>
		</td>
           <td>
        <?php echo substr($arr_rs['VHID'],6,2); ?>
		</td>

         <td>
        <?php echo $arr_rs['VILLNAME']; ?>
		</td>
          <td>
        <?php echo $arr_rs['TYPE_AREA']; ?>
		</td>	
        
         
        
	</tr>
 
<?php }?>   
</table>

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
