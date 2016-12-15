<?php 
session_start();
session_destroy();
ob_start();
header("Location:http://{$_SERVER['HTTP_HOST']}/reyesmagos");
ob_end_flush();

?>