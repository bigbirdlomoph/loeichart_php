<!doctype html>
<html>
<head>
 <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
<title>Untitled Document</title>

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
$uid=$_GET['uid'];
$m=$_GET['m'];
?>
<?php 
if($m=='1'){
?>
<div class="panel panel-default">
  <div class="panel-heading">User Setting</div>
  <div class="panel-body">
	<div id="myShow">

<form id="frm_chang">
  <input type="hidden" id="uid" value="<?php echo $uid;?>">
  <input type="hidden" id="m" value="<?php echo $m;?>">
  <div class="form-group">
    <label for="Username">Old Username</label>
    <input type="user" class="form-control" id="ouser" placeholder="Old Username">
  </div>
  <div class="form-group">
    <label for="Username">New Username</label>
    <input type="user" class="form-control" id="nuser" placeholder="New Username">
  </div>
     <button type="button" onClick="changuser();"class="btn btn-success">Save</button>
</form>

</div>
 
    </div>
</div>
<?php
}elseif($m=='2'){
?>

<div class="panel panel-default">
  <div class="panel-heading">Password Setting</div>
  <div class="panel-body">
	<div id="myShow">

<form id="frm_chang">
  <input type="hidden" id="uid" value="<?php echo $uid;?>">
  <div class="form-group">
    <label for="Username">Username</label>
    <input type="user" class="form-control" id="user" placeholder="Username">
  </div>
  <div class="form-group">
   <label for="Password">Old Password</label>
    <input type="password" class="form-control" id="opass" placeholder="Old Password">
  </div>
  <div class="form-group">
    <label for="Password">New Password</label>
    <input type="password" class="form-control" id="pass" placeholder="New Password">
  </div>
  <div class="form-group">
	<label for="Password again">New Password again</label>
    <input type="password" class="form-control" id="apass" placeholder="New Password again">
    
  </div>
     <button type="button" onClick="changpass();"class="btn btn-success">Save</button>
</form>

</div>
 
    </div>
</div>

<?php }?>       
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
