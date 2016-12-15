	<?php 
	$privileges=str_replace(PHP_EOL, "", trim($_SESSION['privileges']));
	// Metemos todos los usuarios en un array frejco frejco	
	$userArray=Usuario::getAllUsersByGroup($_SESSION["group"]);
	// $userArray=Usuario::getAllUsers();


	?>
	<article class="page">


		<?php 
		if(count($userArray)>0){


			?>
			<h2>Selecciona individuo</h2>
			<div class="row">
				<?php
				foreach($userArray as $user){

					if ($user->id!='0' && $user->id!='1'){
						?>
						<div class="col-xs-6 col-sm-4 col-md-2">
							<figure class="thumbnail <?php echo $user->its_me()?'me':''?>" onclick="location.href='http://pokandroll.net/reyesmagos/cartas/<?php echo $user->id ?>'">
								
									<div class="img-responsive profile-pic-wrap" style="background-image: url('img/profile_pictures/<?php echo $user->imagen?>')"></div>
									<figcaption class="caption">
										<h3 class="nombre-usuario"><?php echo  ucwords($user->nombre) ?></h3>
										<p class="titulo-usuario"><?php echo $user->titulo ?></p>
										<?php 
										if ($privileges=="admin") {
											?>
											<p class="thumb-admin-buttons"><a href="#" class="btn btn-primary edit-user" role="button" onclick="alert('No me jodas, estoy a contrarreloj no me ha dado para poner al admin un botoncito de editar de mierda. Vete a los ficheros y lo cambas -.-')"><img src='http://pokandroll.net/reyesmagos/img/iconos/editSmall.png' alt='editar'><span class="edit-button-text">Editar</span></a> <a href="php/rmv_usr.php?usr=<?php echo $user->id ?>" class="btn btn-danger remove-user" role="button" ><img src='http://pokandroll.net/reyesmagos/img/iconos/removeSmall.png' alt='editar'><span class="remove-button-text">Borrar</span></a></p>
											<?php
										}
										?>
										<!-- <p><a href="#" class="btn btn-primary" role="button">Button</a> <a href="#" class="btn btn-default" role="button">Button</a></p> -->
									</figcaption>
							</figure>
						</div>
						<?php
					}
				}
				?>
				<?php
			}else{
				?>
				<p class="text-danger page">No hay usuarios :/</p>
				<?php 		
			}
			if ($privileges=="admin") {

				?>
				<div class="col-xs-6 col-sm-4 col-md-2">
					<figure class="thumbnail" id="new_user_button" data-toggle="modal" data-target="#new_user_modal">
						<div class="img-responsive profile-pic-wrap" style="background-image: url('img/profile_pictures/no_profile.png')"></div>

						<!-- <img data-src="img/profile_pictures/plus.png" src="img/profile_pictures/no_profile.png"  alt="Nuevo individuo"> -->
						<figcaption class="caption">
							<h3>Nuevo individuo</h3>
							<p>Haz click para crearlo</p>
						</figcaption>
					</figure>
				</div>
				<?php
			}		
			?>
		</div>


		<?php if ($privileges=='admin') { ?>

		<div class="modal fade" id="new_user_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
						<h4 class="modal-title" id="myModalLabel">Nuevo individuo:</h4>
					</div>
					<div class="modal-body text-center">
						<form id="nuevo_usuario_form" class="panel-body text-left" role="form" method="post" action="php/new_user.php" enctype="multipart/form-data">
							<div class="form-group">
								<label for="nuevo_usuario_nombre">Nombre del susodicho/a</label>
								<input  name="nuevo_usuario_nombre" type="text" class="form-control" id="nuevo_usuario_nombre" placeholder="Nombre" required>
							</div>
							<div class="form-group">
								<label for="nuevo_usuario_titulo">Título</label>
								<input name="nuevo_usuario_titulo" type="text" class="form-control" id="nuevo_usuario_titulo" placeholder="Pon alguna chorrada" required>
							</div>
							<div class="form-group">
								<label for="nuevo_usuario_pass">Contraseña</label>
								<input  name="nuevo_usuario_pass" type="password" class="form-control" id="nuevo_usuario_pass" value="" required>
							</div>
							<div class="form-group">
								<label for="nuevo_usuario_pass2">Repetir contraseña (mero formalismo)</label>
								<input  name="nuevo_usuario_pass2" type="password" class="form-control" id="nuevo_usuario_pass2" value="" required>
							</div>
							<div class="form-group">
								<label for="nuevo_usuario_foto">Su cara bonita</label>
								<input type="file" id="nuevo_usuario_imagen" name="nuevo_usuario_imagen">
								<p class="help-block">Sube la foto menos mala de tu careto</p>
							</div>
							<div class="checkbox">
								<label for="nuevo_usuario_privilegios">Prerrogativas</label>
								<select id="nuevo_usuario_privilegios" name="nuevo_usuario_privilegios">
									<option value="user">User</option>
									<option value="admin">Admin</option>
								</select>
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" id="nuevo_usuario_submit" onclick="document.getElementById('nuevo_usuario_form').submit()">Enviar</button>
					</div>
				</div>
			</div>
		</div>

		<?php } ?>



	</article>

