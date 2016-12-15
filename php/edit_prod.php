<?php 
session_start();
ob_start();
extract($_SESSION);
require_once("functions.php");
include("classes/Usuario.php");
if($user==''){
	header("Location:http://{$_SERVER['HTTP_HOST']}/reyesmagos");
	
}else{
	extract($_POST);
	extract($_FILES);

	$nombre=secureString( $editar_producto_nombre);
	$descripcion=secureString(str_replace(PHP_EOL, "<br>", $editar_producto_descripcion));
	if (isset($editar_producto_precio) && trim($editar_producto_precio)!='') {

		$precio=secureString( $editar_producto_precio);
		
	}else{
		$precio="?";
	}
	$enlaces=array();
	if(isset($editar_producto_enlaces)){
		for ($i=0; $i < count($editar_producto_enlaces); $i++) { 
			if (preg_match("/.{5,}/i", str_replace(" ", "", $editar_producto_enlaces[$i]))) {
				array_push($enlaces, (isset($editar_producto_enlaces_nombres[$i]) ? $editar_producto_enlaces_nombres[$i] : "" ) .";;". str_replace("http://", "", $editar_producto_enlaces[$i])) ;
			}
		}			
	}
	$prioridad=$editar_producto_prioridad;



	if ($editar_producto_imagenes['name'][0]) {
		$imagenes= $editar_producto_imagenes;
	}else{

		$imagenes=array();
	}

	if($nombre!=''){


		Producto::edit_product( $user, $edit_product_id, $nombre, $descripcion, $precio, $enlaces, $imagenes, $prioridad);
		header("Location:http://{$_SERVER['HTTP_HOST']}/reyesmagos/cartas/$user");
		
	}else{
		header("Location:http://{$_SERVER['HTTP_HOST']}/reyesmagos/cartas/$user/?err=producto_no_editado");
		
		
	}


}
ob_end_flush();



?>