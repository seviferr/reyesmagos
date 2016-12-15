<?php 
session_start();
ob_start();
include("functions.php");
include("definitions.php");
extract($_POST);

$users=file( $_SERVER['DOCUMENT_ROOT'] . "/reyesmagos/user_data/user_codes.txt");

$id_and_privileges=checkPass($name, $pass, $users);


if($name!='' && $pass!='' && $id_and_privileges){
	$_SESSION['user'] = $id_and_privileges[0];	
	$_SESSION['user_name'] = $name;	
	$_SESSION['privileges'] =  $id_and_privileges[1];	
	$_SESSION['group'] =  $id_and_privileges[2];	

	header("Location:http://{$_SERVER['HTTP_HOST']}/reyesmagos");
	
}else{
	header("location:  http://{$_SERVER['HTTP_HOST']}/reyesmagos/?err=1");
}
ob_end_flush();
?>