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
    
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>   
    <!--data table fix head-->
      <!-- jQuery -->
    <script src="../js/jquery-1.11.3.min.js"></script>

  <script src="../../bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
  <script src="../../bower_components/datatables/media/js/dataTables.fixedColumns.min.js"></script>
  <link href="../../bower_components/datatables/media/css/fixedColumns.dataTables.min.css">
  <link href="../../bower_components/datatables/media/css/jquery.dataTables.min.css">
    <!-- Custom Fonts -->
    <link href="../../bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    

<script>
$(document).ready(function() {
    $('#table_fix').DataTable( {
        scrollY:        350,
        scrollX:        true,
        scrollCollapse: true,
        paging:         false,
        fixedColumns:   true,
		"bSort": false,
		"bFilter": false
    } );
} );
</script>
<style>
/* Ensure that the demo table scrolls */
    th, td { white-space: nowrap; }
    div.dataTables_wrapper {
        width: 100%;
        margin: 0 auto;
    }
</style>
<!--fixhead-->         
</head>

<body>
<?php

$id=$_GET['id'];//id report
$ampcode=$_GET['ampcode'];
$hospcode=$_GET['hospcode'];
$subdistid=$_GET['subdistid'];
$age=$_GET['age'];
$fyear=$_GET['fyear'];
$m=date("m");
$y=date("Y");
$y1=$y-1;
$y2=$y;
//check table 
if($fyear=='2558'){	
	if($age==9){$tb_vill="z42_child_dev_s_vill";}
	elseif($age==18){$tb_vill="z42_child_dev_s18_vill";}
	elseif($age==30){$tb_vill="z42_child_dev_s30_vill";}
	elseif($age==42){$tb_vill="z42_child_dev_s42_vill";}
}else{
		if($age==9){$tb_vill="z42_child_dev_s_".substr($fyear,2,2)."_vill";}
		elseif($age==18){$tb_vill="z42_child_dev_s18_".substr($fyear,2,2)."_vill";}
		elseif($age==30){$tb_vill="z42_child_dev_s30_".substr($fyear,2,2)."_vill";}
		elseif($age==42){$tb_vill="z42_child_dev_s42_".substr($fyear,2,2)."_vill";}
	
	}
//
 $dbrpt=new Database(DB_HOST_TK,DB_USER_TK,DB_PASS_TK,DB_NAME_TK);//new object 
?>
<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
  <div class="container">
    <?php
 //select name report
  $dbrpt->Query("SELECT * FROM z42_sys_report WHERE id='$id' ORDER BY cat_id");
    while($arrrpt=$dbrpt->Fetch_array()){
		
		?>
		<h4>
		<?php echo $arrrpt['report_name'];?>
       <a href="../exportxls/child_develop_vill_export_excel.php?id=<?php echo $id?>&fyear=<?php echo $fyear;?>&age=<?php echo $age?>&table=<?php echo $tb_vill?>&ampcode=<?php echo $ampcode;?>&hospcode=<?php echo $hospcode;?>&subdistid=<?php echo $subdistid;?>"class="btn btn-default btn-sm " role="button">
   ส่งออก Excel
   </a>
        </h4>
		<?php
        }
 
?>

  </div>
</nav>


<!--<div class="panel panel-success">
 <div class="panel-heading"><i class="fa fa-chain"></i> กราฟ</div>
  <div class="panel-body">

  <?php //include("../chart/chart_anc12w_amp.php")?>
  
  </div>
</div>
<!---->
 <div class="panel panel-info">
  <div class="panel-heading"><?php echo $arrrpt['report_name']; ?></div>
     <div class="panel-body">
    <br>
<div class="table-responsive ">
<font size="1">
<table id="table_fix" class="table table-bordered table-hover" cellspacing="0" width="100%"  >
<thead>
          <tr class="bg-primary">
          <th rowspan="3" class="text-center">หมู่บ้าน</th>
           <th colspan="18" class="text-center"><?php echo ($fyear)-1;?></td>
          <th colspan="54" class="text-center"><?php echo $fyear;?></td>

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

 $dbrpt->Query(" SELECT * FROM $tb_vill WHERE subdistid ='".$subdistid."' AND LEFT(subdistid,4)='".$ampcode."' AND HOSPCODE = '".$hospcode."'");
while($arr_rs=$dbrpt->Fetch_array())
{
	//$ampcode=$arr_rs['AMP_CODE'];
?>    
	<tr>
       <?php
       if($fyear=='2558'){
		?>
		<td class="bg-info">
         <a href="child_develop_vill_cid58.php?hospcode=<?php echo $hospcode;?>&vhid=<?php echo $arr_rs['vhid'];?>&id=<?php echo $id;?>&age=<?php echo $age;?>&fyear=<?php echo $fyear;?>"><?php echo $arr_rs['villname']; ?></a> 
		</td>
        <td align="center">
		<a href="javascript:popup('child_develop_vill_cid58.php?hospcode=<?php echo $hospcode;?>&vhid=<?php echo $arr_rs['vhid'];?>&id=<?php echo $id;?>&age=<?php echo $age;?>&fyear=<?php echo $fyear;?>&m=10','',960,500)"><?php echo number_format($arr_rs['m10']); ?></a> 
        </td>
        <?php
           }else{
	   ?>
		<td class="bg-info">
         <a href="child_develop_vill_cid.php?hospcode=<?php echo $hospcode;?>&vhid=<?php echo $arr_rs['vhid'];?>&id=<?php echo $id;?>&age=<?php echo $age;?>&fyear=<?php echo $fyear;?>"><?php echo $arr_rs['villname']; ?></a> 
		</td>
        <td align="center">
		<a href="javascript:popup('child_develop_vill_cid.php?hospcode=<?php echo $hospcode;?>&vhid=<?php echo $arr_rs['vhid'];?>&id=<?php echo $id;?>&age=<?php echo $age;?>&fyear=<?php echo $fyear;?>&m=10','',960,500)"><?php echo number_format($arr_rs['m10']); ?></a> 
        </td>
        <?php }?>
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
        <a href="javascript:popup('child_develop_vill_cid.php?hospcode=<?php echo $hospcode;?>&vhid=<?php echo $arr_rs['vhid'];?>&id=<?php echo $id;?>&age=<?php echo $age;?>&fyear=<?php echo $fyear;?>&m=11','',960,500)">
		<?php echo number_format($arr_rs['m11']); ?> 
        </a>
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
        <a href="javascript:popup('child_develop_vill_cid.php?hospcode=<?php echo $hospcode;?>&vhid=<?php echo $arr_rs['vhid'];?>&id=<?php echo $id;?>&age=<?php echo $age;?>&fyear=<?php echo $fyear;?>&m=12','',960,500)">
		<?php echo number_format($arr_rs['m12']); ?> 
        </a>
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
        <a href="javascript:popup('child_develop_vill_cid.php?hospcode=<?php echo $hospcode;?>&vhid=<?php echo $arr_rs['vhid'];?>&id=<?php echo $id;?>&age=<?php echo $age;?>&fyear=<?php echo $fyear;?>&m=01','',960,500)">
		<?php echo number_format($arr_rs['m1']); ?> 
        </a>
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
         <a href="javascript:popup('child_develop_vill_cid.php?hospcode=<?php echo $hospcode;?>&vhid=<?php echo $arr_rs['vhid'];?>&id=<?php echo $id;?>&age=<?php echo $age;?>&fyear=<?php echo $fyear;?>&m=02','',960,500)">
		<?php echo number_format($arr_rs['m2']); ?> 
        </a>
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
         <a href="javascript:popup('child_develop_vill_cid.php?hospcode=<?php echo $hospcode;?>&vhid=<?php echo $arr_rs['vhid'];?>&id=<?php echo $id;?>&age=<?php echo $age;?>&fyear=<?php echo $fyear;?>&m=03','',960,500)">
		<?php echo number_format($arr_rs['m3']); ?> 
        </a>
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
         <a href="javascript:popup('child_develop_vill_cid.php?hospcode=<?php echo $hospcode;?>&vhid=<?php echo $arr_rs['vhid'];?>&id=<?php echo $id;?>&age=<?php echo $age;?>&fyear=<?php echo $fyear;?>&m=04','',960,500)">
		<?php echo number_format($arr_rs['m4']); ?> 
        </a>
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
           <a href="javascript:popup('child_develop_vill_cid.php?hospcode=<?php echo $hospcode;?>&vhid=<?php echo $arr_rs['vhid'];?>&id=<?php echo $id;?>&age=<?php echo $age;?>&fyear=<?php echo $fyear;?>&m=05','',960,500)">
		<?php echo number_format($arr_rs['m5']); ?> 
        </a>
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
          <a href="javascript:popup('child_develop_vill_cid.php?hospcode=<?php echo $hospcode;?>&vhid=<?php echo $arr_rs['vhid'];?>&id=<?php echo $id;?>&age=<?php echo $age;?>&fyear=<?php echo $fyear;?>&m=06','',960,500)">
		<?php echo number_format($arr_rs['m6']); ?> 
        </a>
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
          <a href="javascript:popup('child_develop_vill_cid.php?hospcode=<?php echo $hospcode;?>&vhid=<?php echo $arr_rs['vhid'];?>&id=<?php echo $id;?>&age=<?php echo $age;?>&fyear=<?php echo $fyear;?>&m=07','',960,500)">
		<?php echo number_format($arr_rs['m7']); ?> 
        </a>
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
          <a href="javascript:popup('child_develop_vill_cid.php?hospcode=<?php echo $hospcode;?>&vhid=<?php echo $arr_rs['vhid'];?>&id=<?php echo $id;?>&age=<?php echo $age;?>&fyear=<?php echo $fyear;?>&m=80','',960,500)">
		<?php echo number_format($arr_rs['m8']); ?> 
        </a>
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
          <a href="javascript:popup('child_develop_vill_cid.php?hospcode=<?php echo $hospcode;?>&vhid=<?php echo $arr_rs['vhid'];?>&id=<?php echo $id;?>&age=<?php echo $age;?>&fyear=<?php echo $fyear;?>&m=09','',960,500)">
		<?php echo number_format($arr_rs['m9']); ?> 
        </a>
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
 
<?php }?>  
</tbody> 
</table>
<a href="javascript:history.go(-1)" class="btn btn-default btn-sm " role="button">Back</a>
</font>
</div>
</div>
</div>
 
    <!-- Bootstrap Core JavaScript -->
    <script src="../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../../bower_components/metisMenu/dist/metisMenu.min.js"></script>

    

    <!-- Custom Theme JavaScript -->
    <script src="../../dist/js/sb-admin-2.js"></script>
    <script src="../js/sb-admin.js"></script>
</body>
</html>
