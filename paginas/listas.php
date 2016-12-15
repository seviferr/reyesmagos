<?php 
session_start();

if(isset($_GET['data']) && $_GET['data']!='' && $_SESSION['user']!=''){

	if($user = Usuario::retrieve($_GET['data'])) {
		echo "<ol>";
		foreach ($user->getProducts() as $product) {
			echo "<li>" . $product->nombre . "</li>";
			
		}
		echo "</ol>";		
	}else{

		header("Location:http://{$_SERVER['HTTP_HOST']}/reyesmagos");

	}

}else{

	header("Location:http://{$_SERVER['HTTP_HOST']}/reyesmagos");

}

?>