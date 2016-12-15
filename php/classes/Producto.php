<?php
 // include( $_SERVER['DOCUMENT_ROOT'] . '/scripts/variables.php' );
require_once( $_SERVER['DOCUMENT_ROOT'] . '/reyesmagos/php/functions.php' );
final class Producto{
	public $id;
	public $nombre;
	public $descripcion='';
	public $precio='';
	public $enlaces=array();
	public $imagenes=array();
	public $prioridad=1;

	public function __construct($id, $nombre, $descripcion, $precio, $enlaces, $imagenes, $prioridad){		

		$this->id=$id;
		$this->nombre=secureString($nombre);
		$this->descripcion=secureString($descripcion);
		$this->precio=secureString($precio);
		$this->enlaces=$enlaces;
		$this->imagenes=$imagenes;
		$this->prioridad=$prioridad;

	}


	public static function new_product($usuario, $nombre, $descripcion, $precio, $enlaces, $input_imagenes, $prioridad){
		$id_producto=Producto::getID($usuario);
		if($archivo_producto = fopen($_SERVER["DOCUMENT_ROOT"] . "/reyesmagos/product_data/$usuario/" . $id_producto . ".txt", "w")){
			fputs($archivo_producto, secureString($nombre) . PHP_EOL);
			fputs($archivo_producto, secureString($descripcion) . PHP_EOL);

			if($precio==""){
				$precio="?";
			}

			fputs($archivo_producto, secureString($precio) . PHP_EOL);
			
			if(empty($enlaces)){
				fputs($archivo_producto, "" . PHP_EOL);
			}else{				
				fputs($archivo_producto, implode("><",  $enlaces) . PHP_EOL);
				
			}


			if(empty($input_imagenes)){
				fputs($archivo_producto, "no_product.png" . PHP_EOL);
			}else{
				$imagenes=array();
				for ($i=0; $i < count($input_imagenes['name']); $i++) { 
					$imagetype=exif_imagetype($input_imagenes['tmp_name'][$i])== "2" ? '.jpg':'.png';
					redimensionar_imagen($input_imagenes['tmp_name'][$i], strtolower($usuario . "_" .  $id_producto . "_" . $i . "_picture". $imagetype ), 1000, 10000, $_SERVER['DOCUMENT_ROOT']  . "/reyesmagos/img/product_pictures/");
					array_push($imagenes, strtolower($usuario . "_" .  $id_producto . "_" . $i . "_picture".$imagetype));
				}
				fputs($archivo_producto, implode("><", $imagenes) . PHP_EOL);

			}

			fputs($archivo_producto, $prioridad);




			fclose($archivo_producto);

			// $lista_productos=fopen($_SERVER["DOCUMENT_ROOT"] . "/reyesmagos/product_data/$usuario/list.txt" , "a");

			// fputs($lista_productos, $nombre . PHP_EOL);

			// fclose($lista_productos);


		}
	}

	public static function edit_product($usuario, $id, $nombre, $descripcion, $precio, $enlaces, $input_imagenes, $prioridad){

		// Producto::rmvProduct($usuario, $id);

		if($archivo_producto = file($_SERVER["DOCUMENT_ROOT"] . "/reyesmagos/product_data/$usuario/" . $id . ".txt")){

			$archivo_producto[0]=secureString($nombre) . PHP_EOL;
			$archivo_producto[1]=secureString($descripcion) . PHP_EOL;

			if($precio==""){
				$precio="?";
			}				
			$archivo_producto[2]=secureString($precio) . PHP_EOL;
			


			if(empty($enlaces)){
				$archivo_producto[3]="" . PHP_EOL;
			}else{								
				$archivo_producto[3]=implode("><",  $enlaces) . PHP_EOL;
			}


			if(!empty($input_imagenes)){			
				$mask = $_SERVER["DOCUMENT_ROOT"] . "reyesmagos/img/product_pictures/" . $usuario . "_" . $id . "_*.*";
				array_map('unlink', glob($mask));

				$imagenes=array();
				for ($i=0; $i < count($input_imagenes['name']); $i++) { 
					$imagetype=exif_imagetype($input_imagenes['tmp_name'][$i])== "2" ? '.jpg':'.png';
					redimensionar_imagen($input_imagenes['tmp_name'][$i], strtolower($usuario . "_" .  $id . "_" . $i . "_picture". $imagetype ), 1000, 10000, $_SERVER['DOCUMENT_ROOT']  . "/reyesmagos/img/product_pictures/");
						
					array_push($imagenes, strtolower($usuario . "_" .  $id . "_" . $i . "_picture" . $imagetype));
				}

				$archivo_producto[4]=implode("><", $imagenes) . PHP_EOL;
				
			}
			
			$archivo_producto[5]=$prioridad;

			file_put_contents($_SERVER["DOCUMENT_ROOT"] . "/reyesmagos/product_data/$usuario/" . $id . ".txt", $archivo_producto);

			// $lista_productos = file($_SERVER["DOCUMENT_ROOT"] . "/reyesmagos/product_data/$usuario/list.txt");

			// for ($i=0; $i < count($lista_productos) ; $i++) { 
			// 	if ($lista_productos[$i]==secureString($nombre)) {
			// 		$lista_productos[$i]=secureString($nombre);
			// 		break;
			// 	}

			// }

		}
	}

	public static function retrieve($id_usuario, $id_producto){
		if($archivo_producto = file($_SERVER["DOCUMENT_ROOT"] . "/reyesmagos/product_data/$id_usuario/" . $id_producto .".txt")){
		// Por si hay algún fichero sin todas las filas
			while(count($archivo_producto)<5){			
				array_push($archivo_producto, "");			
			}
			$archivo_producto[4]= $archivo_producto[4]=="" || $archivo_producto[4]=="no_product.jpg"?"no_product.png":$archivo_producto[4];

			$array_enlaces=explode("><",  $archivo_producto[3]);
			$array_imagenes=explode("><", $archivo_producto[4]);

		// En caso de no haber especificado una imágen de perfil

			return new Producto($id_producto, $archivo_producto[0], $archivo_producto[1], $archivo_producto[2], $array_enlaces, $array_imagenes, $archivo_producto[5]);

		}else{
			return false;
		}
	}

	// public static function getAllProducts(){

	// 	$productArray=array();
	// 	foreach(new DirectoryIterator($_SERVER["DOCUMENT_ROOT"] . "/reyesmagos/product_data/") as $carpeta_usuario){
	// 		if($carpeta_usuario->getType() == "dir" && !$carpeta_usuario->isDot()) 
	// 		{
	// 			foreach(new DirectoryIterator($_SERVER["DOCUMENT_ROOT"] . "/reyesmagos/product_data/".$carpeta_usuario->getFilename()) as $archivo_producto){
	// 				if($archivo_producto->getType() == "file") 
	// 				{
	// 					array_push($productArray, Producto::retrieve(secureString($carpeta_usuario -> getFilename())), $archivo_producto->getFilename());
	// 				}
	// 			}
	// 		}

	// 		return $productArray;
	// 	}
	// }

	public static function rmvProduct($usuario, $id){

		unlink($_SERVER["DOCUMENT_ROOT"] . "/reyesmagos/product_data/$usuario/" .  $id . ".txt");

		$mask = $_SERVER["DOCUMENT_ROOT"] . "/reyesmagos/img/product_pictures/" . $usuario . "_" . $id . "_*.*";
		array_map('unlink', glob($mask));


	}

	public static function getID($usuario){
		$id=0;
		foreach(new DirectoryIterator($_SERVER["DOCUMENT_ROOT"] . "/reyesmagos/product_data/$usuario") as $archivo_producto) {
			if($archivo_producto->getType() == "file" && $archivo_producto->getFilename() != 'list.txt') 
			{
				if (str_replace(".txt", "", $archivo_producto->getFilename()) > $id) {
					$id=str_replace(".txt", "", $archivo_producto->getFilename());
				}
				
				
			}
		}
		return $id+1;;
	}

}

?>

