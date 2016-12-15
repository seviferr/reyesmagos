<html>
<?php 
session_start();
if (isset($_SESSION['user'])) {
	extract($_SESSION);
} else {	
	$user = "";
	$privileges = "";
}
extract($_GET);

include("php/definitions.php");
include("php/functions.php");
require('php/classes/Usuario.php');


?>
<head>
	<title>Carta a los reyes magos</title>
	<base href="/reyesmagos/"></base>
	<!-- Bootstrap -->
	<script src="js/jquery.js" type="text/javascript"></script>
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<script src="js/bootstrap.min.js" type="text/javascript"></script>

	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

	<!-- Main Style -->
	<link href="/reyesmagos/css/main.css" rel="stylesheet">

	<!-- Galería blueImp -->
	<link rel="stylesheet" href="css/blueimp-gallery.min.css">

	<!-- Fonts -->
	<link href='http://fonts.googleapis.com/css?family=Pacifico' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Josefin+Sans' rel='stylesheet' type='text/css'>

</head>
<body>
	<header class="container-fluid">
		<?php 

		require('secciones/header.php'); 

		?>
	</header>
	<?php 
	if($user!=''){

			//Retrieving page variable from url. If not set, page will be "home".
		$page = (isset($_GET) && isset($_GET['page'])) ? $_GET['page'] : 'inicio';
		$data = (isset($_GET) && isset($_GET['data'])) ? $_GET['data'] : '';


		?>
		
		<div class="main container-fluid">
			<?php


			if (!@include 'paginas/' . $page . ".php") {
				include 'paginas/inicio.php';
			};


		}else{
			?>
			<div class="row fullBG">
				<h1 class="col-xs-12 pacific white">Carta a los reyes magos </h1>
				<div id="login_wrap" class="col-sm-8 col-md-5">
					<?php 
					if(isset($err)){
						?>
						<p class="text-center" style="color:#F2DEDE"><strong>
							<?php 
							switch ($err) {
								case 1:
								echo "No cuela :/";
								break;

								case 2:
								echo "No vales ni para mirón ://";
								break;
								
								default:
								echo "Deja de toquetear la URL anda";
								break;
							}

							?>

						</strong></p>
						<?php
					}
					?>
					<form class="panel-body" role="form" action="php/checkpass.php" method="post">
						<div class="form-group">
							<label for="name"  class="white">¿Tú quien eres?</label>
							<input name="name" type="text" class="form-control" id="name" placeholder="Desembucha...">
						</div>
						<div class="form-group">
							<label for="pass" class="white">Santo y seña</label>
							<input name="pass" type="password" class="form-control" id="pass" placeholder="Pass plz">
						</div>
						<div class="checkbox">
							<label>
								<input type="checkbox"> <span class="white">Márcameeeee!</span>
							</label>
						</div>
						<button type="submit" class="btn btn-success">Entrar</button>
						<button data-toggle="modal" data-target="#onlylooking_modal" type="button" class="btn btn-warning">Sólo soy un mirón</button>
					</form>
				</div>
			</div>
				<div class="modal fade" id="onlylooking_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
					<h4 class="modal-title" id="myModalLabel">¿A qué familia quieres espiar?</h4>
				</div>
				<div class="modal-body text-center">
					<form id="onlylooking_form" class="panel-body text-left" role="form" method="post" action="php/onlylooking_login.php">
						<div class="form-group">
							<label for="onlylooking_code">Código de la família o grupo de amigos</label>
							<input name="onlylooking_code" type="password" class="form-control" id="onlylooking_code" placeholder="No te lo inventes ¿eh?">
							<p class="help-block" style="margin-top:30px">El modo mirón te permite entrar a ver lo que la gente ha pedido para reyes, pero no dispondrás de un perfil propio</p>
						</div>						
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" id="nuevo_usuario_submit" onclick="document.getElementById('onlylooking_form').submit()">Enviar</button>
				</div>
			</div>
		</div>
	</div>
			<?php 
		}

		?>
	</div>

<script type="text/javascript">
// window.onorientationchange = function() { window.location.reload(); };
</script>
</body>

</html>