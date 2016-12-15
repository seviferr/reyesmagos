<?php 
session_start();
ob_start();
extract($_GET);
extract($_SESSION);

include("classes/Producto.php");

Producto::rmvProduct($user, $prod);

header("Location:http://{$_SERVER['HTTP_HOST']}/reyesmagos/cartas/$user");

ob_end_flush();

?>