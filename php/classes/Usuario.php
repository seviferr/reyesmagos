<?php
 // include( $_SERVER['DOCUMENT_ROOT'] . '/scripts/variables.php' );
require_once( $_SERVER['DOCUMENT_ROOT'] . '/reyesmagos/php/functions.php' );
require_once( $_SERVER['DOCUMENT_ROOT'] . '/reyesmagos/php/classes/Producto.php' );
final class Usuario{
	public $id;
	public $nombre;
	public $titulo='';
	public $imagen='';
	
	public $productos=array();

	public function __construct($id, $nombre, $titulo, $imagen, $productos=array()){		

		$this->id=$id;
		$this->nombre=secureString($nombre);
		$this->titulo=secureString($titulo);	
		$this->imagen=secureString($imagen);
		$this->productos=$productos;

	}


	public static function new_user($nombre, $titulo, $imagen, $clave, $privilegios, $grupo){
		$id=Usuario::getID();
		// Dar de alta un usuario en el sistema. NO crea un objeto, no hace falta.
		if($archivo_usuario = fopen($_SERVER["DOCUMENT_ROOT"] . "/reyesmagos/user_data/users/" . $id . ".txt", "w")){

			if($imagen==""){
				$imagen="no_profile.png";
			}else{
				redimensionar_imagen($imagen['tmp_name'], strtolower($id . "_picture.jpg"), 500, 10000, $_SERVER['DOCUMENT_ROOT']  . "/reyesmagos/img/profile_pictures/");
				$imagen=$id . "_picture.jpg";
			}
			fputs($archivo_usuario, secureString($nombre) . PHP_EOL);
			fputs($archivo_usuario, secureString($titulo) . PHP_EOL);
			fputs($archivo_usuario,	$imagen .  PHP_EOL);
			fputs($archivo_usuario, "");

			fclose($archivo_usuario);
			
			$user_codes = fopen($_SERVER["DOCUMENT_ROOT"] . "/reyesmagos/user_data/user_codes.txt", "a");

			echo $id .";". $nombre.";".$clave . ";" . $privilegios . ";" . $grupo . PHP_EOL;


			fputs($user_codes, $id .";". $nombre.";".$clave . ";" . $privilegios . ";" . $grupo . PHP_EOL);

			fclose($user_codes);			

			mkdir($_SERVER["DOCUMENT_ROOT"] . "/reyesmagos/product_data/" . $id);



			
		}else{
			return "false";
		}
	}

	public static function retrieve($id){
		if($archivo_usuario = file($_SERVER["DOCUMENT_ROOT"] . "/reyesmagos/user_data/users/" . $id. ".txt")){
		// // Por si hay algún fichero sin todas las filas
			while(count($archivo_usuario)<3){			
				array_push($archivo_usuario, "");			
			}

		 // En caso de no haber especificado una imágen de perfil
			$archivo_usuario[2]= $archivo_usuario[2]==""?"no_profile.png":$archivo_usuario[2];


			return new Usuario($id, secureString($archivo_usuario[0]), secureString($archivo_usuario[1]), secureString($archivo_usuario[2]));
		}else{
			return false;
		}
	}



	public static function getAllUsers(){

		$userArray=array();

		foreach(new DirectoryIterator($_SERVER["DOCUMENT_ROOT"] . "/reyesmagos/user_data/users/") as $arrayItem){
			if($arrayItem->getType() == "file") {
				array_push($userArray, Usuario::retrieve(str_replace(".txt", "", secureString($arrayItem -> getFilename()))));
			}
		}
		return $userArray;
	}


	public static function getAllUsersByGroup($group_id){



		$users=file($_SERVER['DOCUMENT_ROOT'] . "/reyesmagos/user_data/user_codes.txt");
		$userArray=array();


		foreach ($users as $row) {
			$user_data = explode(";", $row);

			// echo $user_data[0] . ",";
			// echo $user_data[1] . ",";
			// echo $user_data[4] . ",";
			// echo $group_id;

			// echo "<br>";

			if (secureString($user_data[4]) == secureString($group_id)) {
			array_push($userArray, Usuario::retrieve($user_data[0]));

				
			}
			
		}
			// print_r($userArray);



		return $userArray;
	}


	public static function rmvUsr($id){

		unlink($_SERVER["DOCUMENT_ROOT"] . "/reyesmagos/user_data/users/" . $id . ".txt");

		unlink($_SERVER["DOCUMENT_ROOT"] . "/reyesmagos/img/profile_pictures/" . $id . "_picture.jpg");

		$user_codes_array =file($_SERVER["DOCUMENT_ROOT"] . "/reyesmagos/user_data/user_codes.txt");
		$new_string="";
		for ($i=0; $i < count($user_codes_array) ; $i++) { 

			$exploded=explode(";", $user_codes_array[$i]);
			if($exploded[0]!=$id){
				$new_string.=$user_codes_array[$i];
			}else{
				unset($user_codes_array[$i]);
				break;
			}

		}

		file_put_contents($_SERVER["DOCUMENT_ROOT"] . "/reyesmagos/user_data/user_codes.txt", $new_string);

		Delete($_SERVER["DOCUMENT_ROOT"] . "/reyesmagos/product_data/" . $id);

		$mask = $_SERVER["DOCUMENT_ROOT"] . "/reyesmagos/img/product_pictures/" . $id . "_*_*.*";
		array_map('unlink', glob($mask));


	}

	public function getProducts(){
		$userProducts=array();
		foreach(new DirectoryIterator($_SERVER["DOCUMENT_ROOT"] . "/reyesmagos/product_data/".$this->id) as $product_file){
			if($product_file->getType() == "file" && $product_file->getFilename() != 'list.txt') {
				array_push($userProducts,  Producto::retrieve($this->id, str_replace(".txt", "", $product_file->getFilename())));
			}
		}
		return $userProducts;
	}

	public function its_me(){
		if($_SESSION['user']==$this->id){
			return true;
		}else{
			return false;
		}
	}

	public static function getID(){
		$id=0;
		foreach(new DirectoryIterator($_SERVER["DOCUMENT_ROOT"] . "/reyesmagos/user_data/users") as $archivo_usuario) {
			if($archivo_usuario->getType() == "file") 
			{

				$id=str_replace(".txt", "", $archivo_usuario->getFilename());
			}
		}
		return $id+1;
	}




}

?>

