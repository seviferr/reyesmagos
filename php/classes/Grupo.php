<?php
 // include( $_SERVER['DOCUMENT_ROOT'] . '/scripts/variables.php' );
require_once( $_SERVER['DOCUMENT_ROOT'] . '/reyesmagos/php/functions.php' );
require_once( $_SERVER['DOCUMENT_ROOT'] . '/reyesmagos/php/classes/Producto.php' );
require_once( $_SERVER['DOCUMENT_ROOT'] . '/reyesmagos/php/classes/Usuario.php' );
final class Grupo{
	public $id;
	public $nombre;
	public $titulo='';

	public function __construct($id, $nombre, $titulo){		

		$this->id=$id;
		$this->nombre=secureString($nombre);
		$this->titulo=secureString($titulo);

	}


	


}

?>

