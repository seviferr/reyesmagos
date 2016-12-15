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


	$nombre=secureString( $nuevo_producto_nombre);
	$descripcion=secureString(str_replace(PHP_EOL, "<br>", $nuevo_producto_descripcion));
	if (isset($nuevo_producto_precio) && trim($nuevo_producto_precio)!='') {

		$precio=secureString( $nuevo_producto_precio);
		
	}else{
		$precio="?";
	}
	$enlaces=array();
	if(isset($nuevo_producto_enlaces)){
		for ($i=0; $i < count($nuevo_producto_enlaces); $i++) { 
			if (preg_match("/.{5,}/i", str_replace(" ", "", $nuevo_producto_enlaces[$i]))) {
				array_push($enlaces, (isset($nuevo_producto_enlaces_nombres[$i]) ? $nuevo_producto_enlaces_nombres[$i] : "" ) .";;". str_replace("http://", "", $nuevo_producto_enlaces[$i])) ;
			}
		}			
	}
	
	// $imagen=secureString(str_replace(" ", "_", $nuevo_producto_imagen));
	$prioridad=$nuevo_producto_prioridad;



	if ($nuevo_producto_imagenes['name'][0]) {
		$imagenes= $nuevo_producto_imagenes;
	}else{

		$imagenes=array();
	}


	if($nombre!=''){

		Producto::new_product($user, $nombre, $descripcion, $precio, $enlaces, $imagenes, $prioridad);

		header("Location:http://{$_SERVER['HTTP_HOST']}/reyesmagos/cartas/$user");
		
	}else{
		header("Location:http://{$_SERVER['HTTP_HOST']}/reyesmagos/cartas/$user/?err=producto_no_creado");
		
		
	}


}
ob_end_flush();



?>