<?php 
session_start();
extract($_SESSION);
ob_start();
require_once("functions.php");
include("classes/Usuario.php");

if($user==''){
	header("Location:http://{$_SERVER['HTTP_HOST']}/reyesmagos");
}else{
	extract($_POST);
	extract($_FILES);	

	$nombre=secureString( $nuevo_usuario_nombre);
	$titulo=secureString( $nuevo_usuario_titulo);
	$clave=secureString( $nuevo_usuario_pass);
	$clave2=secureString( $nuevo_usuario_pass2);
	$privs=secureString( $nuevo_usuario_privilegios);

	$imagen=$nuevo_usuario_imagen['name']!=''?$nuevo_usuario_imagen:"";
	


	if($clave!='' && $clave2!='' && $clave==$clave2 && $nombre!=''){
		Usuario::new_user($nombre, $titulo, $imagen, $clave, $privs, $group);

		header("Location:http://{$_SERVER['HTTP_HOST']}/reyesmagos");
	}else{

		header("Location:http://{$_SERVER['HTTP_HOST']}/reyesmagos/?err=usuario_no_creado");
	}




}
ob_end_flush();

?>