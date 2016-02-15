<?php 
session_start();
function __autoload($class_name){
	include'class/class.'.$class_name.'.php';
}
set_time_limit(0);
include"config/config.php";
?>

<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<body>
<?php

$user=$_POST['user'];
$pass=md5($_POST['pass']);
$sdate =date("Y-m-d H:i:s");
//
if($user =='@admin'){
	$_SESSION['login_admin'] = $user; 
?>
<script language="javascript">
    window.location.href = "backend/index-admin.php"
</script>
<?   
}else{
//	
if(isset($user) and isset($pass)) {
	    $index="index.php";
		$dbsms=new Database(DB_HOST_TK,DB_USER_TK,DB_PASS_TK,DB_NAME_TK);
		$dbsms->Query("select * from z42_sys_member where username='$user' AND password='$pass' AND status='yes'");
		$dbarr=$dbsms->Fetch_array();		
		$num_rows=$dbsms->Numrow();
		$row=$dbsms->Fetch_row();
		//$user_acc=$dbarr['ACCESS_BOX'];
        $user_id=$dbarr['id'];
		//$ubid=$dbarr['BOX_ID'];

	if($num_rows==1)
	{
		
		
        //insert log
	    $dbsms->Query("insert into z42_log_login(user,date_time,date_login) 		 value('$user','$sdate','$sdate')");

       //
	   $dbsms->Query("update z42_sys_member set lastlogin='".$sdate."' where id='".$user_id."'");
	   //user status
	  	   
	   $_SESSION['login_true'] = $user_id;      
		 
		?>
   <script langquage='javascript'>
window.location="index.php";
</script>
       <?php	
	}
	else
	{
			
			$code_error="<span class=style2><font size=2 color=red> Login Error try again
			</font></span>";
	session_register("code_error");
	?>
<script langquage='javascript'>
window.location="login.php";
</script>
<?php
	}
	}
}
?>
</body>
</html>
