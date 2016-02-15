<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<body>
<html>
<head>
<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>LOEI CHART | REPORT DATA</title>

    <!-- Bootstrap Core CSS -->
    <link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Timeline CSS -->
    <link href="../dist/css/timeline.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="../bower_components/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    
   
</head>
<body>
<?php	
    $dt=date("Y-m-d H:i:s");
	$dbc=new Database(DB_HOST_TK,DB_USER_TK,DB_PASS_TK,DB_NAME_TK);

	//*** Select วันที่ในตาราง Counter ว่าปัจจุบันเก็บของวันที่เท่าไหร่  ***//
	//*** ถ้าเป็นของเมื่อวานให้ทำการ Update Counter ไปยังตาราง daily และลบข้อมูล เพื่อเก็บของวันปัจจุบัน ***//
	$dbc->Query(" SELECT DATE FROM counter LIMIT 0,1");
	$objResult=$dbc->Fetch_array();
	if($objResult["DATE"] != date("Y-m-d"))
	{
		//*** บันทึกข้อมูลของเมื่อวานไปยังตาราง daily ***//
		$dbc->Query(" INSERT INTO daily (DATE,NUM) SELECT '".date('Y-m-d',strtotime("-1 day"))."',COUNT(*) AS intYesterday FROM  counter WHERE 1 AND DATE = '".date('Y-m-d',strtotime("-1 day"))."'");
		//*** ลบข้อมูลของเมื่อวานในตาราง counter ***//
		$dbc->Query(" DELETE FROM counter WHERE DATE != '".date("Y-m-d")."' ");
		
	}

	//*** Insert Counter ปัจจุบัน ***//
	#$dbc->Query(" INSERT INTO counter (DATE,IP) VALUES ('".date("Y-m-d")."','".$_SERVER["REMOTE_ADDR"]."') ");
	$dbc->Query(" INSERT INTO counter (DATE,IP) VALUES ('".date("Y-m-d")."','".$dt."') ");
	

	//******************** Get Counter ************************//

	// Today //
	$dbc->Query(" SELECT COUNT(DATE) AS CounterToday FROM counter WHERE DATE = '".date("Y-m-d")."' ");
	$objResult=$dbc->Fetch_array();
	$strToday = $objResult["CounterToday"];

	// Yesterday //
	$dbc->Query(" SELECT NUM FROM daily WHERE DATE = '".date('Y-m-d',strtotime("-1 day"))."' ");
	$objResult=$dbc->Fetch_array();
	$strYesterday = $objResult["NUM"];

	// This Month //
	$dbc->Query(" SELECT SUM(NUM) AS CountMonth FROM daily WHERE DATE_FORMAT(DATE,'%Y-%m')  = '".date('Y-m')."' ");
	$objResult=$dbc->Fetch_array();
	$strThisMonth = $objResult["CountMonth"];

	// Last Month //
	$dbc->Query(" SELECT SUM(NUM) AS CountMonth FROM daily WHERE DATE_FORMAT(DATE,'%Y-%m')  = '".date('Y-m',strtotime("-1 month"))."' ");
     $objResult=$dbc->Fetch_array();
    	$strLastMonth = $objResult["CountMonth"];

	// This Year //
	$dbc->Query(" SELECT SUM(NUM) AS CountYear FROM daily WHERE DATE_FORMAT(DATE,'%Y')  = '".date('Y')."' ");
    $objResult=$dbc->Fetch_array();
	 $strThisYear = $objResult["CountYear"];

	// Last Year //
	$dbc->Query(" SELECT SUM(NUM) AS CountYear FROM daily WHERE DATE_FORMAT(DATE,'%Y')  = '".date('Y',strtotime("-1 year"))."' ");
	$objResult=$dbc->Fetch_array();
	$strLastYear = $objResult["CountYear"];

	//*** Close MySQL ***//
	$dbc->Close_Conn();
?>

<div class="table-responsive ">
<table class="table table-hover" >
  <tr class="danger">
    <td colspan="2"><div align="center">Statistics</div></td>
  </tr>
   <tr class="info">
    <td >Today</td>
    <td ><div align="center"><?php echo number_format($strToday,0);?></div></td>
  </tr>
 <tr class="success">
    <td>Yesterday</td>
    <td><div align="center"><?php echo number_format($strYesterday,0);?></div></td>
  </tr>
 <tr class="success">
    <td>This Month </td>
    <td><div align="center"><?php echo number_format($strThisMonth,0);?></div></td>
  </tr>
  <tr class="success">
    <td>Last Month </td>
    <td><div align="center"><?php echo number_format($strLastMonth,0);?></div></td>
  </tr>
 <tr class="success">
    <td>This Year </td>
    <td><div align="center"><?php echo number_format($strThisYear,0);?></div></td>
  </tr>
  <tr class="success">
    <td>Last Year </td>
    <td><div align="center"><?php echo number_format($strLastYear,0);?></div></td>
  </tr>
</table>
</div>
</body>
<html>
</body>
</html>
