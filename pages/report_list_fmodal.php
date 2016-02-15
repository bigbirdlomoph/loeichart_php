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
<title>Untitled Document</title>
</head>

<body>
<?php
function __autoload($class_name){
	include'class/class.'.$class_name.'.php';
}
set_time_limit(0);
include"config/config.php";
$cat_id=$_GET['catId'];
//$cat_name=$_POST['catName'];
 $db=new Database(DB_HOST_TK,DB_USER_TK,DB_PASS_TK,DB_NAME_TK);
 
?>
<div class="panel-body">
   <div class="panel-group" id="accordion">
    <?php 
   $db->Query("select * from z42_sys_report_group where cat_id='".$cat_id."'  order by id");
   while($arr_g=$db->Fetch_array()){
	   $catid=$arr_g['cat_id'];
	?>
    <div class="panel panel-info">
             <div class="panel-heading">
                 <h4 class="panel-title">
                       <a href="index.php" title="กลับเมนูหลัก"><i class="fa fa-angle-double-left"></i></a>  <?php echo $arr_g['cat_name'];?>                                  
                     </h4>
                </div>
            
              <div class="panel-body" >
               <div class="panel-group" id="accordion">   
               <?php 
   					$db->Query("select * from z42_sys_report_group_sub where cat_id='".$cat_id."' group by id_accord order by id_accord");
   						while($arr_g=$db->Fetch_array()){
	   					$catsub=$arr_g['cat_sub_group'];
						$id=$arr_g['id_accord'];
				?>   
                 <div class="panel panel-info">
                 <div class="panel-heading">
                 	<h4 class="panel-title">
                      <a data-toggle="collapse" data-parent="#accordion" href="#<?php echo $arr_g['accord']?>"><?php echo $catsub;?></a>                                 
                     </h4>
                </div>
                <div id="<?php echo $arr_g['accord']?>" class="panel-collapse collapse">
              <div class="panel-body" >
			<ul class="list-group"> 
			 <?php  
			  $dbreport=new Database(DB_HOST_TK,DB_USER_TK,DB_PASS_TK,DB_NAME_TK);
	 	      $dbreport->Query("SELECT * FROM z42_sys_report WHERE cat_id='$catid' and cat_sub_group='$catsub' and id_accord='$id' and active='1'   ORDER BY id_sort");
	   					       while($arrreport=$dbreport->Fetch_array()){
								  
	 				
					?>
                  
                  <li class="list-group-item <?php echo $arrreport['report_color'];?>">
               <a href="<?php echo $arrreport['source_file']?><?php echo $arrreport['para_meter'] ?>id=<?php echo $arrreport['id'];?>&table=<?php echo $arrreport['source_table_s'];?>" target="_blank"> <?php echo $arrreport['report_name'];?>&nbsp;<i class="fa fa-check"></i></a>
                
                  </li>
                
             
                <!---->
				<?php }?>
   										
                  </ul>

              </div>
                 </div>
                 <!--///-->
                 <?php }?>  
                              </div>
            </div>
</div><!--/panel-group-->  
<!--/panel body-->
  
   <?php
     $dbreport->Close_Conn();
	}
	?>        
</body>
</html>
