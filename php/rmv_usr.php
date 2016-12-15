<?php 
session_start();
extract($_GET);
extract($_SESSION);
ob_start();

if (trim($privileges) == "admin") {

	include("classes/Usuario.php");
	Usuario::rmvUsr($usr);

	header("Location:http://{$_SERVER['HTTP_HOST']}/reyesmagos");

}else{

	header("Location:http://{$_SERVER['HTTP_HOST']}/reyesmagos/?err=privileges");

}
ob_end_flush();

?>