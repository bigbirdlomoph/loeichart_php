<?php
session_start() ;
if (!isset($_SESSION['login_true'])) {
     header("Location: login.php");//สั่งให้ redirect ไปหน้า login เมื่อไม่มีการ login แต่เรียกใช้หน้านี้
     exit;
}

?>
<?php 
//session_start();
function __autoload($class_name){
	include'class/class.'.$class_name.'.php';
}
set_time_limit(0);
include"config/config.php";
//include"modal.php";
$user_id=$_SESSION['login_true'];
?>
<!DOCTYPE html>
<html lang="en">

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



    <!-- Custom Fonts -->
    <link href="../bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    
   

</head>

<body>

    <div id="wrapper">
<?php
                $db=new Database(DB_HOST_TK,DB_USER_TK,DB_PASS_TK,DB_NAME_TK);
				$db->Query("SELECT * FROM z42_sys_config");
				$dbarr=$db->Fetch_array();
				$db->Query("SELECT * FROM z42_sys_member WHERE id='$user_id'");
				$dbarr_id=$db->Fetch_array();
				$db->Close_Conn();
				?>
        <!-- Navigation -->
        <nav class="navbar navbar navbar-default navbar-fixed-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php"><?php echo $dbarr['SITE_NAME'];?></a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
               <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i> <?php echo $dbarr_id['firstname'];?> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <!--<li><a href="#"><i class="fa fa-user fa-fw"></i>Chang</a></li>-->
                        <li><a data-toggle="modal" href="#" data-target="#m_setting"><i class="fa fa-gear fa-fw"></i> Settings</a>
                        </li>
                        <li class="divider"></li>
                        <li><a data-toggle="modal" href="#" data-target="#m_logout"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                 
        
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                       
                        <li>
                            <a href="index.php"><i class="fa fa-home fa-fw"></i> HOME</a>
                        </li>
                      
                      <li>
                            <a href="http://203.157.173.22/person_mid"><i class="fa fa-dashboard fa-fw"></i> ข้อมูลประชากรกลางปี</a>
                        </li>
                                                                    
                    </ul>
                    
 
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>
        <br><br><br>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                <div class="alert alert-success" role="alert">LOEI CHART | REPORT DATA  </div>    
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
           
            <div id="mySpan">
             <!--ประชากรกลางปี--> 
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-check fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                   <div>ข้อมูลประชากร</div>
                                    <div >กลางปี</div>
                                </div>
                            </div>
                        </div>
                        <a href="http://localhost:88/person_mid" target="new">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
              <!--ประชากร--> 
                             <?php 
								$dbrg=new Database(DB_HOST_TK,DB_USER_TK,DB_PASS_TK,DB_NAME_TK);
								$dbrg->Query("select sg.cat_name as ctname,sg.cat_id as ctid,COUNT(sr.cat_id) as cc
								     from z42_sys_report_group as sg 
									LEFT OUTER JOIN z42_sys_report as sr on sg.cat_id=sr.cat_id  
									where sr.cat_id='g1' and sr.active='1' order by sr.id");
								$rgname=$dbrg->Fetch_array();
								$dbrg->Close_Conn();
								?>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-male fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                   <div><?php echo $rgname['ctname']; ?></div>
                                    <div class="huge"><?php echo $rgname['cc']; ?></div>
                                </div>
                            </div>
                        </div>
                        <a href="JavaScript:doCallAjax('report_list_fmodal.php?catId=<?php echo $rgname['ctid'];?>')">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            <!--อนามัยแม่และเด็ก-->
             <?php 
								$dbrg=new Database(DB_HOST_TK,DB_USER_TK,DB_PASS_TK,DB_NAME_TK);
								$dbrg->Query("select sg.cat_name as ctname,sg.cat_id as ctid,COUNT(sr.cat_id) as cc
								     from z42_sys_report_group as sg 
									LEFT OUTER JOIN z42_sys_report as sr on sg.cat_id=sr.cat_id  
									where sr.cat_id='g2' and sr.active='1' order by sr.id");
								$rgname=$dbrg->Fetch_array();
								$dbrg->Close_Conn();
								?>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-child fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                     <div><?php echo $rgname['ctname']; ?></div>
                                    <div class="huge"><?php echo $rgname['cc']; ?></div>
                                   
                                </div>
                            </div>
                        </div>
                        <a href="JavaScript:doCallAjax('report_list_fmodal.php?catId=<?php echo $rgname['ctid'];?>')">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <!--การสร้างเสริมภูมิคุ้มกันโรค-->
                <?php 
							$dbrg=new Database(DB_HOST_TK,DB_USER_TK,DB_PASS_TK,DB_NAME_TK);
								$dbrg->Query("select sg.cat_name as ctname,sg.cat_id as ctid,COUNT(sr.cat_id) as cc
								     from z42_sys_report_group as sg 
									LEFT OUTER JOIN z42_sys_report as sr on sg.cat_id=sr.cat_id  
									where sr.cat_id='g3' and sr.active='1' order by sr.id");
								$rgname=$dbrg->Fetch_array();
								$dbrg->Close_Conn();
						   
								?>
               
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-medkit fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                <div><?php echo $rgname['ctname']; ?></div>
                                    <div class="huge"><?php echo $rgname['cc']; ?></div>
                                    
                                </div>
                            </div>
                        </div>
                        <a href="JavaScript:doCallAjax('report_list_fmodal.php?catId=<?php echo $rgname['ctid'];?>')">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
               
                <!---->
              
                <?php 
								$dbrg=new Database(DB_HOST_TK,DB_USER_TK,DB_PASS_TK,DB_NAME_TK);
								$dbrg->Query("select sg.cat_name as ctname,sg.cat_id as ctid,COUNT(sr.cat_id) as cc
								     from z42_sys_report_group as sg 
									LEFT OUTER JOIN z42_sys_report as sr on sg.cat_id=sr.cat_id  
									where sr.cat_id='g4' and sr.active='1' order by sr.id");
								$rgname=$dbrg->Fetch_array();
								$dbrg->Close_Conn();
								?>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-filter fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div><?php echo $rgname['ctname']; ?></div>
                                    <div class="huge"><?php echo $rgname['cc']; ?></div>
                                    
                                </div>
                            </div>
                        </div>
                        <a href="JavaScript:doCallAjax('report_list_fmodal.php?catId=<?php echo $rgname['ctid'];?>')">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <!---->
                <!---->
              
                <?php 
								$dbrg=new Database(DB_HOST_TK,DB_USER_TK,DB_PASS_TK,DB_NAME_TK);
								$dbrg->Query("select sg.cat_name as ctname,sg.cat_id as ctid,COUNT(sr.cat_id) as cc
								     from z42_sys_report_group as sg 
									LEFT OUTER JOIN z42_sys_report as sr on sg.cat_id=sr.cat_id  
									where sr.cat_id='g5' and sr.active='1' order by sr.id");
								$rgname=$dbrg->Fetch_array();
								$dbrg->Close_Conn();
								?>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-area-chart fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div><?php echo $rgname['ctname']; ?></div>
                                    <div class="huge"><?php echo $rgname['cc']; ?></div>
                                    
                                </div>
                            </div>
                        </div>
                        <a href="JavaScript:doCallAjax('report_list_fmodal.php?catId=<?php echo $rgname['ctid'];?>')">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <!---->
                             
            <!--mySpan main-->
            </div>
           
            <!-- /.row -->
        
        </div>
        <!-- /#page-wrapper -->
           <div class="row">
                <div class="col-lg-12">
                <div class="alert alert-info" role="alert">สงวนลิขสิทธ์ สำนักงานสาธารณสุขจังหวัดเลย @2014 All Rigth Revers</div>    
                </div>
                <!-- /.col-lg-12 -->
            </div>
    
    <!-- /#wrapper -->
  <!--MODAL setting-->
  <div class="modal fade" id="m_setting" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" onClick="history.go(0)" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Settings</h4>
      </div>
      <div class="modal-body">
       <span id="mySpan2">
        <li><a href="JavaScript:doCallAjaxSub('chang_pass.php?m=1&uid=<?php echo $user_id;?>')">เปลี่ยน User Name</a></li>
        <li><a href="JavaScript:doCallAjaxSub('chang_pass.php?m=2&uid=<?php echo $user_id;?>')">เปลี่ยนรหัสผ่าน</a></li>
        </span>
      </div>
      
      <div class="modal-footer">
        <button type="button" class="btn btn-default" onClick="history.go(0)" data-dismiss="modal">Close</button>
        
      </div>
    </div>
  </div>
</div>
       <!--end MODAl--> 
<!--MODAL Logout-->
  <div class="modal fade" id="m_logout" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Logout</h4>
      </div>
      <div class="modal-body">
         <button type="button" class="btn btn-default" onClick="logOut();">Confirm</button>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
       <!--end MODAl-->        
    <!-- jQuery -->
    <script src="../bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../bower_components/metisMenu/dist/metisMenu.min.js"></script>

    

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>
    <script src="js/sb-admin.js"></script>
  <script>
  
  <!---->
 $('#my_modal').on('show.bs.modal', function(e) {
    var catId = $(e.relatedTarget).data('cat-id');
	var catName = $(e.relatedTarget).data('cat-name');
    $(e.currentTarget).find('input[name="catId"]').val(catId);
	$(e.currentTarget).find('input[name="catName"]').val(catName);
});

  </script>
  

</body>

</html>
