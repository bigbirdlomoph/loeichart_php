<?php
/*
session_start() ;
if (!isset($_SESSION['login_true'])) {
     header("Location: login.php");//สั่งให้ redirect ไปหน้า login เมื่อไม่มีการ login แต่เรียกใช้หน้านี้
     exit;
}
*/
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
function __autoload($class_name){
	include'class/class.'.$class_name.'.php';
}
set_time_limit(0);
include"config/config.php";
$cat_id=$_GET['cat_id'];
$str_date=$_POST['str_date'];
$end_date=$_POST['end_date'];
//$b_year=$_POST['b_year'];
//$o_year=$b_year-1;
 $db=new Database(DB_HOST_TK,DB_USER_TK,DB_PASS_TK,DB_NAME_TK);
?>
<!--//-->
<div class="panel-body">
   <div class="panel-group" id="accordion">
    <?php 
   $db->Query("select * from z42_sys_report_group where cat_id='".$cat_id."' order by id");
   while($arr_g=$db->Fetch_array()){
	   $catid=$arr_g['cat_id'];
	?>
    <div class="panel panel-info">
             <div class="panel-heading">
                 <h4 class="panel-title">
                      <a data-toggle="collapse" data-parent="#accordion" href="#<?php echo $arr_g['accord']?>"><?php echo $arr_g['cat_name'];?></a>                                 
                     </h4>
                </div>
            <div id="<?php echo $arr_g['accord']?>" class="panel-collapse collapse">
              <div class="panel-body" >
                      
					<?php  
					 $dbreport=new Database(DB_HOST_TK,DB_USER_TK,DB_PASS_TK,DB_NAME_TK);
	 				 $dbreport->Query("SELECT * FROM z42_sys_report WHERE cat_id='$catid' ORDER BY cat_id");
	   					       while($arrreport=$dbreport->Fetch_array()){
								  
	 				
					?>
             <li>
               <a href="<?php echo $arrreport['source_file']?><?php echo $arrreport['para_meter'] ?>id=<?php echo $arrreport['id']?>&str_date=<?php echo $str_date?>&end_date=<?php echo $end_date?>" target="new"> <?php echo $arrreport['report_name'];?></a>
                
                  </li>
                
             
                <!---->
				<?php }?>
   			</li>									
                 
              </div>
            </div>
</div><!--/panel-group-->  
<!--/panel body-->
  
   <?php }?>                           
<!--//-->


<!-- /#wrapper -->

    <!-- jQuery -->
    <script src="../bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../bower_components/metisMenu/dist/metisMenu.min.js"></script>

    

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>
    <script src="js/sb-admin.js"></script>
</body>
</html>
