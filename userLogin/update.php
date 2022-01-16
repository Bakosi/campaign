<?php
session_start();

include("../phpclass.inc.php");
$obj = new PHPClass();

$obj->isLoginSessionExpired(); // check if session is expired

if(isset($_SESSION["user_id"])) {
	if($obj->isLoginSessionExpired()) {
		header("Location:../logout.php?session_expired=1");
	}
}
if(isset($_POST['submit'])){
	$cname  = mysqli_real_escape_string($obj->conndb(),$_POST['cname']);
	$date1  = mysqli_real_escape_string($obj->conndb(),$_POST['date1']);
	$date2  = mysqli_real_escape_string($obj->conndb(),$_POST['date2']);
	$tbudget= mysqli_real_escape_string($obj->conndb(),$_POST['tbudget']);
	$dbudget= mysqli_real_escape_string($obj->conndb(),$_POST['dbudget']);
	$img    = $_POST['img'];
	$user   = $_POST['user'];
	$create = $obj->editCampaign($cname,$date1,$date2,$tbudget,$dbudget,$img,$user);
	if($create){
		echo "<p>Campaign Edited</p>";
	}else{
		echo "No";
	}
}else{
	
}

mysqli_close($obj->conndb());
?>