<?php 
session_start();
ob_start();
include("functions.php");
extract($_POST);

$group_codes=file($_SERVER["DOCUMENT_ROOT"] . "/reyesmagos/user_data/group_codes.txt");


if($group_data = check_group_code($onlylooking_code, $group_codes)){
	$_SESSION['user'] = $group_data[0];	
	$_SESSION['user_name'] = $group_data[1];	
	$_SESSION['privileges'] ="onlylooking";
	$_SESSION['group'] = $group_data[0];

	header("Location:http://{$_SERVER['HTTP_HOST']}/reyesmagos");
	
}else{
	header("Location:http://{$_SERVER['HTTP_HOST']}/reyesmagos/?err=2");
	
}
ob_end_flush();
?>