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
$user=$_POST['user'];
$pass=$_POST['pass'];
$opass=$_POST['opass'];
$apass=$_POST['apass'];
$uid=$_POST['uid'];
//new
$nuser=$_POST['nuser'];
$ouser=$_POST['ouser'];
echo $m=$_POST['m'];
if($m==''){
		$db=new Database(DB_HOST_TK,DB_USER_TK,DB_PASS_TK,DB_NAME_TK);
		$db->Query("SELECT * FROM z42_sys_member WHERE id='$uid'");
		$arr=$db->Fetch_array();
		$id=$arr[0];
		$user_=$arr[5];
		if($uid==$id && $user==$user_){
			   $db->Query("UPDATE z42_sys_member SET password=MD5('".$pass."') WHERE id='".$uid."'");
				   
				   echo"เปลี่ยนรหัสเรียบร้อย";
				  
			}else{
			echo "ขออภัยไม่มี User ในระบบ";	
			}
			$db->Close_conn();
}else{
//Update user
$db=new Database(DB_HOST_TK,DB_USER_TK,DB_PASS_TK,DB_NAME_TK);
		$db->Query("SELECT * FROM z42_sys_member WHERE id='$uid'");
		$arr=$db->Fetch_array();
		$id=$arr[0];
		$user_=$arr[5];
		if($uid==$id && $ouser==$user_){
			   $db->Query("UPDATE z42_sys_member SET username='".$nuser."' WHERE id='".$uid."'");
				   
				   echo"เปลี่ยน user เรียบร้อย";
				  
			}else{
			echo "ขออภัยไม่มี User ในระบบ";	
			}
			$db->Close_conn();

	
	}
?>

</body>
</html>
