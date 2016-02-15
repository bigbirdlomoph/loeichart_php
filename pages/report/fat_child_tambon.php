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
</head>

<body>
<?php
$ampcode=$_GET['ampcode'];
$hospcode=$_GET['hospcode'];
$id=$_GET['id'];
$ystr=$_GET['ystr'];;
$yend=$_GET['yend'];
$age=$_GET['age'];

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
   
		<h4><?php echo $arrrpt['report_name'];?> </h4>
		<?php
        }
?>
<a href="javascript:history.go(-1)" class="btn btn-default btn-sm " role="button">Back</a>
</div>
  <div class="panel-body">
<div class="table-responsive ">
<table class="table table-bordered table-hover">
<thead>
          <tr>
              
             <th>ตำบล</th>
             <th>รหัสพยาบาล</th>
            <th>จำนวนเด็กทั้งหมด</th>
              <th>จำนวนเด็กที่มาชั่งน้ำหนัก</th>
              <th>ร้อยละความครอบคุม</th>
               <th>จำนวนเด็กอ้วน</th>
            <!--<th>ร้อยละเด็กอ้วน</th>-->
             <th>ผอม</th>
             <th>ค่อนข้างผอม</th>
             <th>ปกติ</th>
             <th>ท้วม</th>
             <th>อ้วน</th>
             <th>อ้วนมาก</th>
             

          </tr>
     </thead>
     <tbody>             
</tbody>
<?php
if($age=='5'){
 $dbrpt->Query("
				######################SHOW areacode
SELECT 
		tb1.subdistid as subdistid,
		tb1.subdistname as subdistname,
	  tb1.hospcode,
		if(tb3.B IS NULL,'0',tb3.B) as B,
    if(tb5.A IS NULL,'0',tb5.A)  as A,
		ROUND((tb5.A/tb3.B)*100,2) as P,
    if(tb4.AF IS NULL,'0',tb4.AF) AS AF,
		ROUND((tb4.AF/tb5.A)*100,2) as PF,
    if(tb6.SM IS NULL ,'0',tb6.SM) as SM,
    if(tb7.SMM IS NULL,'0',tb7.SMM) as SMM,
    if(tb8.SMN IS NULL,'0',tb8.SMN) as SMN,
    if(tb9.SMA IS NULL,'0',tb9.SMA) as SMA,
    if(tb10.SMF IS NULL,'0',tb10.SMF) as SMF,
		IF(tb11.SMFF IS NULL,'0',tb11.SMFF) as SMFF

FROM(
	  SELECT  cv.villid as vhid,cs.subdistid as subdistid,cs.subdistname as subdistname,cv.hospcode as hospcode FROM `co_subdistrict` as cs
		LEFT OUTER JOIN co_village_loei as cv ON cs.subdistid=cv.subdistid 
    WHERE cs.distid='".$ampcode."' AND cv.hospcode='".$hospcode."'
		GROUP BY cv.subdistid,cv.hospcode
) as tb1
#####เป้า####
LEFT JOIN
(
  SELECT 
				LEFT(ns.areacode,6) as subdistid,
				sum(ns.target) as B
				FROM z42_nutri_s  as ns 
				WHERE  LEFT(ns.areacode,4)='".$ampcode."' AND ns.hospcode='".$hospcode."'
				GROUP BY ns.hospcode,LEFT(ns.areacode,6)
) as tb3 ON tb1.subdistid=tb3.subdistid
##reult เด็กอ้วo
LEFT JOIN
(
SELECT 
				LEFT(ns.areacode,6) as subdistid,
				sum(ns.result) as AF
				FROM z42_nutri_s  as ns 
				
				WHERE LEFT(ns.areacode,4)='".$ampcode."' AND ns.hospcode='".$hospcode."' AND ns.date_com BETWEEN'".$ystr."' AND '".$yend."' and ns.level_hw in('5','6')
GROUP BY ns.hospcode,LEFT(ns.areacode,6)
)as tb4 ON tb1.subdistid=tb4.subdistid
##ชังน้ำนก
LEFT JOIN
(
SELECT 
				LEFT(ns.areacode,6) as subdistid,
				sum(ns.target) as A
				FROM z42_nutri_s as ns 
				
				WHERE LEFT(ns.areacode,4)='".$ampcode."' AND ns.hospcode='".$hospcode."' AND ns.date_com BETWEEN'".$ystr."' AND'".$yend."' and ns.level_hw <>''
GROUP BY ns.hospcode,LEFT(ns.areacode,6)
)as tb5 ON tb1.subdistid=tb5.subdistid
##ชังน้ำนก
####เด็กผอม
LEFT JOIN
(
SELECT 
			 LEFT(ns.areacode,6) as subdistid,
				sum(ns.target) as SM
				FROM z42_nutri_s as ns 
				WHERE LEFT(ns.areacode,4)='".$ampcode."' AND ns.hospcode='".$hospcode."' AND ns.date_com BETWEEN'".$ystr."' AND'".$yend."' and ns.level_hw in ('2')
GROUP BY ns.hospcode,LEFT(ns.areacode,6)
)as tb6 ON tb1.subdistid=tb6.subdistid
####ค่อนข้างเด็กผอม
LEFT JOIN
(
SELECT 
			 LEFT(ns.areacode,6) as subdistid,
				sum(ns.target) as SMM
				FROM z42_nutri_s as ns 
				WHERE LEFT(ns.areacode,4)='".$ampcode."' AND ns.hospcode='".$hospcode."' AND ns.date_com BETWEEN'".$ystr."' AND'".$yend."' and ns.level_hw in ('1')
GROUP BY ns.hospcode,LEFT(ns.areacode,6)
)as tb7 ON tb1.subdistid=tb7.subdistid
####ปกติ
LEFT JOIN
(
SELECT 
			  LEFT(ns.areacode,6) as subdistid,
				sum(ns.target) as SMN
				FROM z42_nutri_s as ns 
				WHERE LEFT(ns.areacode,4)='".$ampcode."' AND ns.hospcode='".$hospcode."' AND ns.date_com BETWEEN'".$ystr."' AND'".$yend."' and ns.level_hw in ('3')
GROUP BY  ns.hospcode,LEFT(ns.areacode,6)
)as tb8 ON tb1.subdistid=tb8.subdistid
####ท้วม
LEFT JOIN
(
SELECT 
			  LEFT(ns.areacode,6) as subdistid,
				sum(ns.target) as SMA
				FROM z42_nutri_s as ns 
				WHERE LEFT(ns.areacode,4)='".$ampcode."' AND ns.hospcode='".$hospcode."' AND ns.date_com BETWEEN'".$ystr."' AND'".$yend."' and ns.level_hw in ('4')
GROUP BY ns.hospcode,LEFT(ns.areacode,6)
)as tb9 ON tb1.subdistid=tb9.subdistid
###อ้วน
LEFT JOIN
(
SELECT 
				LEFT(ns.areacode,6) as subdistid,
				sum(ns.target) as SMF
				FROM z42_nutri_s as ns 
				WHERE LEFT(ns.areacode,4)='".$ampcode."' AND ns.hospcode='".$hospcode."' AND ns.date_com BETWEEN'".$ystr."' AND'".$yend."' and ns.level_hw in ('5')
GROUP BY ns.hospcode,LEFT(ns.areacode,6)
)as tb10 ON tb1.subdistid=tb10.subdistid
###อ้วนมาก
LEFT JOIN
(
SELECT 
			  LEFT(ns.areacode,6) as subdistid,
				sum(ns.target) as SMFF
				FROM z42_nutri_s as ns 
				WHERE LEFT(ns.areacode,4)='".$ampcode."' AND ns.hospcode='".$hospcode."' AND ns.date_com BETWEEN'".$ystr."' AND'".$yend."' and ns.level_hw in ('6')
GROUP BY ns.hospcode,LEFT(ns.areacode,6)
)as tb11 ON tb1.subdistid=tb11.subdistid
GROUP BY tb1.hospcode,LEFT(tb1.subdistid,6)
UNION ALL
SELECT   
    '', 
    '',
		'รวม',
    
		SUM(tb3.B) as B,
    SUM(tb5.A)  as A,
		ROUND((SUM(tb5.A)/SUM(tb3.B))*100,2) as P,
    SUM(tb4.AF) AS AF,
		ROUND((SUM(tb4.AF)/SUM(tb5.A))*100,2) as PF,
    SUM(tb6.SM) as SM,
    SUM(tb7.SMM) as SMM,
    SUM(tb8.SMN) as SMN,
    SUM(tb9.SMA) as SMA,
    SUM(tb10.SMF) as SMF,
		SUM(tb11.SMFF) as SMFF
	FROM(
	  SELECT  cv.villid as vhid,cs.subdistid as subdistid,cs.subdistname as subdistname,cv.hospcode as hospcode FROM `co_subdistrict` as cs
		LEFT OUTER JOIN co_village_loei as cv ON cs.subdistid=cv.subdistid 
    WHERE cs.distid='".$ampcode."' AND cv.hospcode='".$hospcode."'
		GROUP BY cv.subdistid,cv.hospcode
) as tb1
#####เป้า####
LEFT JOIN
(
  SELECT 
				LEFT(ns.areacode,6) as subdistid,
				sum(ns.target) as B
				FROM z42_nutri_s  as ns 
				WHERE  LEFT(ns.areacode,4)='".$ampcode."' AND ns.hospcode='".$hospcode."'
				GROUP BY ns.hospcode,LEFT(ns.areacode,6)
) as tb3 ON tb1.subdistid=tb3.subdistid
##reult เด็กอ้วo
LEFT JOIN
(
SELECT 
				LEFT(ns.areacode,6) as subdistid,
				sum(ns.result) as AF
				FROM z42_nutri_s  as ns 
				
				WHERE LEFT(ns.areacode,4)='".$ampcode."' AND ns.hospcode='".$hospcode."' AND ns.date_com BETWEEN'".$ystr."' AND '".$yend."' and ns.level_hw in('5','6')
GROUP BY ns.hospcode,LEFT(ns.areacode,6)
)as tb4 ON tb1.subdistid=tb4.subdistid
##ชังน้ำนก
LEFT JOIN
(
SELECT 
				LEFT(ns.areacode,6) as subdistid,
				sum(ns.target) as A
				FROM z42_nutri_s as ns 
				
				WHERE LEFT(ns.areacode,4)='".$ampcode."' AND ns.hospcode='".$hospcode."' AND ns.date_com BETWEEN'".$ystr."' AND'".$yend."' and ns.level_hw <>''
GROUP BY ns.hospcode,LEFT(ns.areacode,6)
)as tb5 ON tb1.subdistid=tb5.subdistid
##ชังน้ำนก
####เด็กผอม
LEFT JOIN
(
SELECT 
			 LEFT(ns.areacode,6) as subdistid,
				sum(ns.target) as SM
				FROM z42_nutri_s as ns 
				WHERE LEFT(ns.areacode,4)='".$ampcode."' AND ns.hospcode='".$hospcode."' AND ns.date_com BETWEEN'".$ystr."' AND'".$yend."' and ns.level_hw in ('2')
GROUP BY ns.hospcode,LEFT(ns.areacode,6)
)as tb6 ON tb1.subdistid=tb6.subdistid
####ค่อนข้างเด็กผอม
LEFT JOIN
(
SELECT 
			 LEFT(ns.areacode,6) as subdistid,
				sum(ns.target) as SMM
				FROM z42_nutri_s as ns 
				WHERE LEFT(ns.areacode,4)='".$ampcode."' AND ns.hospcode='".$hospcode."' AND ns.date_com BETWEEN'".$ystr."' AND'".$yend."' and ns.level_hw in ('1')
GROUP BY ns.hospcode,LEFT(ns.areacode,6)
)as tb7 ON tb1.subdistid=tb7.subdistid
####ปกติ
LEFT JOIN
(
SELECT 
			  LEFT(ns.areacode,6) as subdistid,
				sum(ns.target) as SMN
				FROM z42_nutri_s as ns 
				WHERE LEFT(ns.areacode,4)='".$ampcode."' AND ns.hospcode='".$hospcode."' AND ns.date_com BETWEEN'".$ystr."' AND'".$yend."' and ns.level_hw in ('3')
GROUP BY  ns.hospcode,LEFT(ns.areacode,6)
)as tb8 ON tb1.subdistid=tb8.subdistid
####ท้วม
LEFT JOIN
(
SELECT 
			  LEFT(ns.areacode,6) as subdistid,
				sum(ns.target) as SMA
				FROM z42_nutri_s as ns 
				WHERE LEFT(ns.areacode,4)='".$ampcode."' AND ns.hospcode='".$hospcode."' AND ns.date_com BETWEEN'".$ystr."' AND'".$yend."' and ns.level_hw in ('4')
GROUP BY ns.hospcode,LEFT(ns.areacode,6)
)as tb9 ON tb1.subdistid=tb9.subdistid
###อ้วน
LEFT JOIN
(
SELECT 
				LEFT(ns.areacode,6) as subdistid,
				sum(ns.target) as SMF
				FROM z42_nutri_s as ns 
				WHERE LEFT(ns.areacode,4)='".$ampcode."' AND ns.hospcode='".$hospcode."' AND ns.date_com BETWEEN'".$ystr."' AND'".$yend."' and ns.level_hw in ('5')
GROUP BY ns.hospcode,LEFT(ns.areacode,6)
)as tb10 ON tb1.subdistid=tb10.subdistid
###อ้วนมาก
LEFT JOIN
(
SELECT 
			  LEFT(ns.areacode,6) as subdistid,
				sum(ns.target) as SMFF
				FROM z42_nutri_s as ns 
				WHERE LEFT(ns.areacode,4)='".$ampcode."' AND ns.hospcode='".$hospcode."' AND ns.date_com BETWEEN'".$ystr."' AND'".$yend."' and ns.level_hw in ('6')
GROUP BY ns.hospcode,LEFT(ns.areacode,6)
)as tb11 ON tb1.subdistid=tb11.subdistid
GROUP BY tb1.hospcode
		
				");
}else{

 $dbrpt->Query("
				######################SHOW areacode
SELECT 
		tb1.subdistid as subdistid,
		tb1.subdistname as subdistname,
	  tb1.hospcode,
		if(tb3.B IS NULL,'0',tb3.B) as B,
    if(tb5.A IS NULL,'0',tb5.A)  as A,
		ROUND((tb5.A/tb3.B)*100,2) as P,
    if(tb4.AF IS NULL,'0',tb4.AF) AS AF,
		ROUND((tb4.AF/tb5.A)*100,2) as PF,
    if(tb6.SM IS NULL ,'0',tb6.SM) as SM,
    if(tb7.SMM IS NULL,'0',tb7.SMM) as SMM,
    if(tb8.SMN IS NULL,'0',tb8.SMN) as SMN,
    if(tb9.SMA IS NULL,'0',tb9.SMA) as SMA,
    if(tb10.SMF IS NULL,'0',tb10.SMF) as SMF,
		IF(tb11.SMFF IS NULL,'0',tb11.SMFF) as SMFF

FROM(
	  SELECT  cv.villid as vhid,cs.subdistid as subdistid,cs.subdistname as subdistname,cv.hospcode as hospcode FROM `co_subdistrict` as cs
		LEFT OUTER JOIN co_village_loei as cv ON cs.subdistid=cv.subdistid 
    WHERE cs.distid='".$ampcode."' AND cv.hospcode='".$hospcode."'
		GROUP BY cv.subdistid,cv.hospcode
) as tb1
#####เป้า####
LEFT JOIN
(
  SELECT 
				LEFT(ns.areacode,6) as subdistid,
				sum(ns.target) as B
				FROM z42_nutri_05_s  as ns 
				WHERE  LEFT(ns.areacode,4)='".$ampcode."' AND ns.hospcode='".$hospcode."'
				GROUP BY ns.hospcode,LEFT(ns.areacode,6)
) as tb3 ON tb1.subdistid=tb3.subdistid
##reult เด็กอ้วo
LEFT JOIN
(
SELECT 
				LEFT(ns.areacode,6) as subdistid,
				sum(ns.result) as AF
				FROM z42_nutri_05_s  as ns 
				
				WHERE LEFT(ns.areacode,4)='".$ampcode."' AND ns.hospcode='".$hospcode."' AND ns.date_com BETWEEN'".$ystr."' AND '".$yend."' and ns.level_hw in('5','6')
GROUP BY ns.hospcode,LEFT(ns.areacode,6)
)as tb4 ON tb1.subdistid=tb4.subdistid
##ชังน้ำนก
LEFT JOIN
(
SELECT 
				LEFT(ns.areacode,6) as subdistid,
				sum(ns.target) as A
				FROM z42_nutri_05_s as ns 
				
				WHERE LEFT(ns.areacode,4)='".$ampcode."' AND ns.hospcode='".$hospcode."' AND ns.date_com BETWEEN'".$ystr."' AND'".$yend."' and ns.level_hw <>''
GROUP BY ns.hospcode,LEFT(ns.areacode,6)
)as tb5 ON tb1.subdistid=tb5.subdistid
##ชังน้ำนก
####เด็กผอม
LEFT JOIN
(
SELECT 
			 LEFT(ns.areacode,6) as subdistid,
				sum(ns.target) as SM
				FROM z42_nutri_05_s as ns 
				WHERE LEFT(ns.areacode,4)='".$ampcode."' AND ns.hospcode='".$hospcode."' AND ns.date_com BETWEEN'".$ystr."' AND'".$yend."' and ns.level_hw in ('2')
GROUP BY ns.hospcode,LEFT(ns.areacode,6)
)as tb6 ON tb1.subdistid=tb6.subdistid
####ค่อนข้างเด็กผอม
LEFT JOIN
(
SELECT 
			 LEFT(ns.areacode,6) as subdistid,
				sum(ns.target) as SMM
				FROM z42_nutri_05_s as ns 
				WHERE LEFT(ns.areacode,4)='".$ampcode."' AND ns.hospcode='".$hospcode."' AND ns.date_com BETWEEN'".$ystr."' AND'".$yend."' and ns.level_hw in ('1')
GROUP BY ns.hospcode,LEFT(ns.areacode,6)
)as tb7 ON tb1.subdistid=tb7.subdistid
####ปกติ
LEFT JOIN
(
SELECT 
			  LEFT(ns.areacode,6) as subdistid,
				sum(ns.target) as SMN
				FROM z42_nutri_05_s as ns 
				WHERE LEFT(ns.areacode,4)='".$ampcode."' AND ns.hospcode='".$hospcode."' AND ns.date_com BETWEEN'".$ystr."' AND'".$yend."' and ns.level_hw in ('3')
GROUP BY  ns.hospcode,LEFT(ns.areacode,6)
)as tb8 ON tb1.subdistid=tb8.subdistid
####ท้วม
LEFT JOIN
(
SELECT 
			  LEFT(ns.areacode,6) as subdistid,
				sum(ns.target) as SMA
				FROM z42_nutri_05_s as ns 
				WHERE LEFT(ns.areacode,4)='".$ampcode."' AND ns.hospcode='".$hospcode."' AND ns.date_com BETWEEN'".$ystr."' AND'".$yend."' and ns.level_hw in ('4')
GROUP BY ns.hospcode,LEFT(ns.areacode,6)
)as tb9 ON tb1.subdistid=tb9.subdistid
###อ้วน
LEFT JOIN
(
SELECT 
				LEFT(ns.areacode,6) as subdistid,
				sum(ns.target) as SMF
				FROM z42_nutri_05_s as ns 
				WHERE LEFT(ns.areacode,4)='".$ampcode."' AND ns.hospcode='".$hospcode."' AND ns.date_com BETWEEN'".$ystr."' AND'".$yend."' and ns.level_hw in ('5')
GROUP BY ns.hospcode,LEFT(ns.areacode,6)
)as tb10 ON tb1.subdistid=tb10.subdistid
###อ้วนมาก
LEFT JOIN
(
SELECT 
			  LEFT(ns.areacode,6) as subdistid,
				sum(ns.target) as SMFF
				FROM z42_nutri_05_s as ns 
				WHERE LEFT(ns.areacode,4)='".$ampcode."' AND ns.hospcode='".$hospcode."' AND ns.date_com BETWEEN'".$ystr."' AND'".$yend."' and ns.level_hw in ('6')
GROUP BY ns.hospcode,LEFT(ns.areacode,6)
)as tb11 ON tb1.subdistid=tb11.subdistid
GROUP BY tb1.hospcode,LEFT(tb1.subdistid,6)
UNION ALL
SELECT   
    '', 
    '',
		'รวม',
    
		SUM(tb3.B) as B,
    SUM(tb5.A)  as A,
		ROUND((SUM(tb5.A)/SUM(tb3.B))*100,2) as P,
    SUM(tb4.AF) AS AF,
		ROUND((SUM(tb4.AF)/SUM(tb5.A))*100,2) as PF,
    SUM(tb6.SM) as SM,
    SUM(tb7.SMM) as SMM,
    SUM(tb8.SMN) as SMN,
    SUM(tb9.SMA) as SMA,
    SUM(tb10.SMF) as SMF,
		SUM(tb11.SMFF) as SMFF
	FROM(
	  SELECT  cv.villid as vhid,cs.subdistid as subdistid,cs.subdistname as subdistname,cv.hospcode as hospcode FROM `co_subdistrict` as cs
		LEFT OUTER JOIN co_village_loei as cv ON cs.subdistid=cv.subdistid 
    WHERE cs.distid='".$ampcode."' AND cv.hospcode='".$hospcode."'
		GROUP BY cv.subdistid,cv.hospcode
) as tb1
#####เป้า####
LEFT JOIN
(
  SELECT 
				LEFT(ns.areacode,6) as subdistid,
				sum(ns.target) as B
				FROM z42_nutri_05_s  as ns 
				WHERE  LEFT(ns.areacode,4)='".$ampcode."' AND ns.hospcode='".$hospcode."'
				GROUP BY ns.hospcode,LEFT(ns.areacode,6)
) as tb3 ON tb1.subdistid=tb3.subdistid
##reult เด็กอ้วo
LEFT JOIN
(
SELECT 
				LEFT(ns.areacode,6) as subdistid,
				sum(ns.result) as AF
				FROM z42_nutri_05_s  as ns 
				
				WHERE LEFT(ns.areacode,4)='".$ampcode."' AND ns.hospcode='".$hospcode."' AND ns.date_com BETWEEN'".$ystr."' AND '".$yend."' and ns.level_hw in('5','6')
GROUP BY ns.hospcode,LEFT(ns.areacode,6)
)as tb4 ON tb1.subdistid=tb4.subdistid
##ชังน้ำนก
LEFT JOIN
(
SELECT 
				LEFT(ns.areacode,6) as subdistid,
				sum(ns.target) as A
				FROM z42_nutri_05_s as ns 
				
				WHERE LEFT(ns.areacode,4)='".$ampcode."' AND ns.hospcode='".$hospcode."' AND ns.date_com BETWEEN'".$ystr."' AND'".$yend."' and ns.level_hw <>''
GROUP BY ns.hospcode,LEFT(ns.areacode,6)
)as tb5 ON tb1.subdistid=tb5.subdistid
##ชังน้ำนก
####เด็กผอม
LEFT JOIN
(
SELECT 
			 LEFT(ns.areacode,6) as subdistid,
				sum(ns.target) as SM
				FROM z42_nutri_05_s as ns 
				WHERE LEFT(ns.areacode,4)='".$ampcode."' AND ns.hospcode='".$hospcode."' AND ns.date_com BETWEEN'".$ystr."' AND'".$yend."' and ns.level_hw in ('2')
GROUP BY ns.hospcode,LEFT(ns.areacode,6)
)as tb6 ON tb1.subdistid=tb6.subdistid
####ค่อนข้างเด็กผอม
LEFT JOIN
(
SELECT 
			 LEFT(ns.areacode,6) as subdistid,
				sum(ns.target) as SMM
				FROM z42_nutri_05_s as ns 
				WHERE LEFT(ns.areacode,4)='".$ampcode."' AND ns.hospcode='".$hospcode."' AND ns.date_com BETWEEN'".$ystr."' AND'".$yend."' and ns.level_hw in ('1')
GROUP BY ns.hospcode,LEFT(ns.areacode,6)
)as tb7 ON tb1.subdistid=tb7.subdistid
####ปกติ
LEFT JOIN
(
SELECT 
			  LEFT(ns.areacode,6) as subdistid,
				sum(ns.target) as SMN
				FROM z42_nutri_05_s as ns 
				WHERE LEFT(ns.areacode,4)='".$ampcode."' AND ns.hospcode='".$hospcode."' AND ns.date_com BETWEEN'".$ystr."' AND'".$yend."' and ns.level_hw in ('3')
GROUP BY  ns.hospcode,LEFT(ns.areacode,6)
)as tb8 ON tb1.subdistid=tb8.subdistid
####ท้วม
LEFT JOIN
(
SELECT 
			  LEFT(ns.areacode,6) as subdistid,
				sum(ns.target) as SMA
				FROM z42_nutri_05_s as ns 
				WHERE LEFT(ns.areacode,4)='".$ampcode."' AND ns.hospcode='".$hospcode."' AND ns.date_com BETWEEN'".$ystr."' AND'".$yend."' and ns.level_hw in ('4')
GROUP BY ns.hospcode,LEFT(ns.areacode,6)
)as tb9 ON tb1.subdistid=tb9.subdistid
###อ้วน
LEFT JOIN
(
SELECT 
				LEFT(ns.areacode,6) as subdistid,
				sum(ns.target) as SMF
				FROM z42_nutri_05_s as ns 
				WHERE LEFT(ns.areacode,4)='".$ampcode."' AND ns.hospcode='".$hospcode."' AND ns.date_com BETWEEN'".$ystr."' AND'".$yend."' and ns.level_hw in ('5')
GROUP BY ns.hospcode,LEFT(ns.areacode,6)
)as tb10 ON tb1.subdistid=tb10.subdistid
###อ้วนมาก
LEFT JOIN
(
SELECT 
			  LEFT(ns.areacode,6) as subdistid,
				sum(ns.target) as SMFF
				FROM z42_nutri_05_s as ns 
				WHERE LEFT(ns.areacode,4)='".$ampcode."' AND ns.hospcode='".$hospcode."' AND ns.date_com BETWEEN'".$ystr."' AND'".$yend."' and ns.level_hw in ('6')
GROUP BY ns.hospcode,LEFT(ns.areacode,6)
)as tb11 ON tb1.subdistid=tb11.subdistid
GROUP BY tb1.hospcode
				");
}
while($arr_rs=$dbrpt->Fetch_array()){
	
?>    
	<tr>
		<td>
         <a href="fat_child_vill.php?hospcode=<?php echo $arr_rs['hospcode'];?>&b_year=<?php echo $b_year;?>&ystr=<?php echo $ystr;?>&yend=<?php echo $yend;?>&age=<?php echo $age;?>&subdistid=<?php echo $arr_rs['subdistid']?>&ampcode=<?php echo $ampcode?>" ><?php echo $arr_rs['subdistname']; ?></a>     
		</td>
        <td><?php echo $arr_rs['hospcode'];?></td>
        <td align="center">
		<?php echo number_format($arr_rs['B']); ?> 
        </td>
         <td align="center">
        <?php echo number_format($arr_rs['A']); ?>
		</td>
          <td align="center">
        <?php echo $arr_rs['P']; ?>
		</td>
        <td align="center">
        <?php echo number_format($arr_rs['AF']); ?>
		</td>
        
            <td align="center">
        <?php echo number_format($arr_rs['SM']); ?>
		</td>
            <td align="center">
        <?php echo number_format($arr_rs['SMM']); ?>
		</td>
          <td align="center">
        <?php echo number_format($arr_rs['SMN']); ?>
		</td>
         <td align="center">
        <?php echo number_format($arr_rs['SMA']); ?>
		</td>
         <td align="center">
        <?php echo number_format($arr_rs['SMF']); ?>
		</td>
         <td align="center">
        <?php echo number_format($arr_rs['SMFF']); ?>
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
