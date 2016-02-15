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
include "../function/function.php";
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
</head>


<body>
<?php
$vhid=$_GET['vhid'];
$hcode=$_GET['hospcode'];
$id=$_GET['id'];
$age=$_GET['age'];
$fyear=$_GET['fyear'];
$m=$_GET['m'];
$i=1;
//check table 
if($fyear=='2558'){	
	if($age==9){$tb_pcu="z42_dv9";}
	elseif($age==18){$tb_pcu="z42_dv18";}
	elseif($age==30){$tb_pcu="z42_dv30";}
	elseif($age==42){$tb_pcu="z42_dv42";}
}else{
	if($age==9){$tb_pcu="z42_dv9_".substr($fyear,2,2);}
	elseif($age==18){$tb_pcu="z42_dv18_".substr($fyear,2,2);}
	elseif($age==30){$tb_pcu="z42_dv30_".substr($fyear,2,2);}
	elseif($age==42){$tb_pcu="z42_dv42_".substr($fyear,2,2);}
	}
//
//check date birth//
if($fyear){
	if($age=='9'){
		if($m==10){$b1=($fyear-543-1).'-01-01'; $b2=($fyear-543-1).'-01-31';}	
		if($m==11){$b1=($fyear-543-1).'-02-01'; $b2=($fyear-543-1).'-02-29';}	
		if($m==12){$b1=($fyear-543-1).'-03-01'; $b2=($fyear-543-1).'-03-31';}
		if($m==01){$b1=($fyear-543-1).'-04-01'; $b2=($fyear-543-1).'-04-30';}
		if($m==02){$b1=($fyear-543-1).'-05-01'; $b2=($fyear-543-1).'-05-31';}
		if($m==03){$b1=($fyear-543-1).'-06-01'; $b2=($fyear-543-1).'-06-30';}
		if($m==04){$b1=($fyear-543-1).'-07-01'; $b2=($fyear-543-1).'-07-31';}
		if($m==05){$b1=($fyear-543-1).'-08-01'; $b2=($fyear-543-1).'-08-31';}
		if($m==06){$b1=($fyear-543-1).'-09-01'; $b2=($fyear-543-1).'-09-30';}
		if($m==07){$b1=($fyear-543-1).'-10-01'; $b2=($fyear-543-1).'-10-31';}
		if($m==08){$b1=($fyear-543-1).'-11-01'; $b2=($fyear-543-1).'-11-30';}
		if($m==09){$b1=($fyear-543-1).'-12-01'; $b2=($fyear-543-1).'-12-31';}		
	}elseif($age=='18'){
		if($m==10){$b1=($fyear-543-2).'-04-01'; $b2=($fyear-543-2).'-04-30';}	
		if($m==11){$b1=($fyear-543-2).'-05-01'; $b2=($fyear-543-2).'-05-31';}	
		if($m==12){$b1=($fyear-543-2).'-06-01'; $b2=($fyear-543-2).'-06-30';}
		if($m==01){$b1=($fyear-543-2).'-07-01'; $b2=($fyear-543-2).'-07-31';}
		if($m==02){$b1=($fyear-543-2).'-08-01'; $b2=($fyear-543-2).'-08-31';}
		if($m==03){$b1=($fyear-543-2).'-09-01'; $b2=($fyear-543-2).'-09-30';}
		if($m==04){$b1=($fyear-543-2).'-10-01'; $b2=($fyear-543-2).'-10-31';}
		if($m==05){$b1=($fyear-543-2).'-11-01'; $b2=($fyear-543-2).'-11-30';}
		if($m==06){$b1=($fyear-543-2).'-12-01'; $b2=($fyear-543-2).'-12-31';}
		if($m==07){$b1=($fyear-543-1).'-10-01'; $b2=($fyear-543-1).'-10-31';}
		if($m==08){$b1=($fyear-543-1).'-11-01'; $b2=($fyear-543-1).'-11-30';}
		if($m==09){$b1=($fyear-543-1).'-12-01'; $b2=($fyear-543-1).'-12-31';}
	}elseif($age=='30'){
		if($m==10){$b1=($fyear-543-3).'-04-01'; $b2=($fyear-543-3).'-04-30';}	
		if($m==11){$b1=($fyear-543-3).'-05-01'; $b2=($fyear-543-3).'-05-31';}	
		if($m==12){$b1=($fyear-543-3).'-06-01'; $b2=($fyear-543-3).'-06-30';}
		if($m==01){$b1=($fyear-543-3).'-07-01'; $b2=($fyear-543-3).'-07-31';}
		if($m==02){$b1=($fyear-543-3).'-08-01'; $b2=($fyear-543-3).'-08-31';}
		if($m==03){$b1=($fyear-543-3).'-09-01'; $b2=($fyear-543-3).'-09-30';}
		if($m==04){$b1=($fyear-543-3).'-10-01'; $b2=($fyear-543-3).'-10-31';}
		if($m==05){$b1=($fyear-543-3).'-11-01'; $b2=($fyear-543-3).'-11-30';}
		if($m==06){$b1=($fyear-543-3).'-12-01'; $b2=($fyear-543-3).'-12-31';}
		if($m==07){$b1=($fyear-543-2).'-10-01'; $b2=($fyear-543-2).'-10-31';}
		if($m==08){$b1=($fyear-543-2).'-11-01'; $b2=($fyear-543-2).'-11-30';}
		if($m==09){$b1=($fyear-543-2).'-12-01'; $b2=($fyear-543-2).'-12-31';}
		
		
	}elseif($age=='42'){
		if($m==10){$b1=($fyear-543-4).'-04-01'; $b2=($fyear-543-4).'-04-30';}	
		if($m==11){$b1=($fyear-543-4).'-05-01'; $b2=($fyear-543-4).'-05-31';}	
		if($m==12){$b1=($fyear-543-4).'-06-01'; $b2=($fyear-543-4).'-06-30';}
		if($m==01){$b1=($fyear-543-4).'-07-01'; $b2=($fyear-543-4).'-07-31';}
		if($m==02){$b1=($fyear-543-4).'-08-01'; $b2=($fyear-543-4).'-08-31';}
		if($m==03){$b1=($fyear-543-4).'-09-01'; $b2=($fyear-543-4).'-09-30';}
		if($m==04){$b1=($fyear-543-4).'-10-01'; $b2=($fyear-543-4).'-10-31';}
		if($m==05){$b1=($fyear-543-4).'-11-01'; $b2=($fyear-543-4).'-11-30';}
		if($m==06){$b1=($fyear-543-4).'-12-01'; $b2=($fyear-543-4).'-12-31';}
		if($m==07){$b1=($fyear-543-3).'-10-01'; $b2=($fyear-543-3).'-10-31';}
		if($m==08){$b1=($fyear-543-3).'-11-01'; $b2=($fyear-543-3).'-11-30';}
		if($m==09){$b1=($fyear-543-3).'-12-01'; $b2=($fyear-543-3).'-12-31';}
		
		}

}
//
$dbrpt=new Database(DB_HOST_TK,DB_USER_TK,DB_PASS_TK,DB_NAME_TK);//new object 

?>
<div class="panel panel-info">
<div class="panel-heading">
 <?php
 //select name report
  $dbrpt->Query("SELECT * FROM z42_sys_report WHERE id='$id' ORDER BY cat_id");
    while($arrrpt=$dbrpt->Fetch_array()){
		
		?>
		<h4><?php echo $arrrpt['report_name'];?></h4>
		<?php
        }
 
?>
<?php 
if($m==''){
?>	
<a href="javascript:history.go(-1)" class="btn btn-default btn-sm " role="button">Back</a>
<?php	
	}else{
?>
<a href="javascript:window.open('','_self');window.close()" class="btn btn-default btn-sm " role="button" >Close</a>  

<?php
}

?>
</div>
  <div class="panel-body">
<div class="table-responsive ">
<font size="1">
<table class="table table-bordered table-hover">
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
              
             <th>บ้านเลขที่</th>
             <th>หมู่ที่</th>
             <th>หมู่บ้าน</th>
              <th>ตำบล</th>
              <th>อำเภอ</th>
             

          </tr>
     </thead>
     <tbody>             
</tbody>
<?php
if($m==''){
 $dbrpt->Query("
 				SELECT 
a.hospcode as HOSPCODE,
a.pid as PID,
CONCAT(a.`name`,' ',a.lname) as FNAME,
a.birth as BIRTH,
a.agemonth as AGEM,
a.namemother as MOM,

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

FROM $tb_pcu as a
LEFT OUTER JOIN co_village_loei as cvl ON a.vhid=cvl.villid
LEFT OUTER JOIN z42_tambon as ztb ON LEFT(a.vhid,6)=CONCAT(ztb.tamboncodefull)
LEFT OUTER JOIN z42_amp AS zam ON  LEFT(a.vhid,4)=CONCAT(zam.AMP_CODE)
LEFT OUTER JOIN 42co_office_loei as 42co ON a.HOSPCODE=42co.off_id
WHERE  a.vhid IS NOT NULL AND a.vhid <>'' AND a.vhid='".$vhid."' AND a.hospcode='".$hcode."'
				");
}else{
	$dbrpt->Query("
 				SELECT 
a.hospcode as HOSPCODE,
a.pid as PID,
CONCAT(a.`name`,' ',a.lname) as FNAME,
a.birth as BIRTH,
a.agemonth as AGEM,
a.namemother as MOM,

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

FROM $tb_pcu as a
LEFT OUTER JOIN co_village_loei as cvl ON a.vhid=cvl.villid
LEFT OUTER JOIN z42_tambon as ztb ON LEFT(a.vhid,6)=CONCAT(ztb.tamboncodefull)
LEFT OUTER JOIN z42_amp AS zam ON  LEFT(a.vhid,4)=CONCAT(zam.AMP_CODE)
LEFT OUTER JOIN 42co_office_loei as 42co ON a.HOSPCODE=42co.off_id
WHERE  a.vhid IS NOT NULL AND a.vhid <>'' AND a.vhid='".$vhid."' AND a.hospcode='".$hcode."' and a.BIRTH BETWEEN '$b1' AND '$b2'
				");
	}
//Query	
while($arr_rs=$dbrpt->Fetch_array()){
	$chkrow=$arr_rs['CK_DEV'];
	
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
 
<?php }?> 
</table>
</font>
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
