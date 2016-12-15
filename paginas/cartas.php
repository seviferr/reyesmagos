<?php 

session_start();

if(isset($_GET['data']) && $_GET['data']!='' && $_SESSION['user']!=''){

	if($user = Usuario::retrieve($_GET['data'])) {
		$allProducts=$user->getProducts();
		$lista_productos=fopen($_SERVER["DOCUMENT_ROOT"] . "/reyesmagos/product_data/$user->id/list.txt" , "w");

		?>
		<div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls">
			<div class="slides"></div>
			<h3 class="title"></h3>
			<a class="prev">‹</a>
			<a class="next">›</a>
			<a class="close">×</a>
			<a class="play-pause"></a>
			<ol class="indicator"></ol>
		</div>
		

		<div class="carta_reyes">
			<div class="row carta_reyes_header">
				<div class="col-sm-3 text-center">
					<img class="round-picture img-responsive img-center" src="img/profile_pictures/<?php echo $user->imagen ?>" width="200">

				</div>
				<div class="col-sm-9">
					<h2 ><?php echo ucwords($user->nombre) ?></h2>
					<h3 ><?php echo $user->descripcion ?></h3>
					<p><img src="img/iconos/gift.png" width="40"><span class="bigLetters"><?php echo "  x  " . count($allProducts) ?> </span></p>
					<?php 
					if(count($allProducts)>0){
						?>
						<p><a href="http://pokandroll.net/reyesmagos/product_data/<?php echo $user->id ?>/list.txt" download><img src="img/iconos/text.png" width="40">&nbsp;&nbsp;Descargar lista (txt)</a></p>
						<?php
					}
					if($user->its_me()){
						?>
						<p><a href="#" data-toggle="modal" data-target="#new-prod-modal" ><img src="img/iconos/moreGifts.png" width="40">&nbsp;&nbsp;Añadir regalo a la lista</a></p>
						<?php
					}
					?>
				</div>
			</div>
			<div class="row carta_reyes_body">
				<h3 class="pacific">Queridos reyes magos, este año he sido buen@... o eso creo. Me gustarían tener:</h3>
				<p class="page"></p>
				<?php
				if (count($allProducts)>0) {
					usort($allProducts, 'productSort');
					$contador=0;

					foreach ($allProducts as $producto) {
						fputs($lista_productos, $contador+1 .". ". $producto->nombre . PHP_EOL);
						$contador++;


						switch ($producto->prioridad) {
							case 1:
							$importanciaString="Imprescindible";
							$importanceClass="info";

							break;

							case 2:
							$importanciaString="Importante";
							$importanceClass="success";

							break;

							case 3:
							$importanciaString="Deseable";													
							$importanceClass="warning";

							break;

							case 4:
							$importanciaString="Meh";													
							$importanceClass="danger";

							break;

							default:
							$importanciaString="Imprescindible";													
							$importanceClass="info";

							break;
						}
						if ($producto->imagenes!='') {
							$imagenes=$producto->imagenes;
						}else{
							$imagenes="no_product.jpg";
						}

						?>


						<div class="container-fluid panel panel-<?php echo $importanceClass ?>">
							<div class="row panel-heading" style="margin-top:0px">
								<div class="col-xs-7 titulo-producto" id="<?php echo $producto->id ?>-nombre" ><?php echo $producto->nombre; ?></div>
								<div class="col-xs-5 text-right">
									<?php

									if($user->its_me()){
										echo '<a href="#" class="editar-producto" id="editar-producto-'.$producto->id.'" data-toggle="modal" data-target="#edit-prod-modal"><img width="30" src="img/iconos/edit.png"></a>&nbsp;&nbsp;&nbsp;';
										?>
										<a class="open-rmv-modal" href="#" data-toggle="modal" data-target="#rmv-prod-modal" data-remove="<?php echo $producto->id ?>"><img width="30" src="img/iconos/remove.png"></a></a>

										<?php 
									}
									?>
								</div>  
							</div>

							<div class="row panel-body">
								<div class="col-sm-4">
									<a class='gallery-item' href="img/product_pictures/<?php echo $imagenes[0] ?>" data-gallery="#blueimp-gallery-<?php echo $producto->id ?>" title="<?php echo $producto->nombre?>">
										<img id="<?php echo $producto->id ?>-main-img" class="product-main-thumb img-responsive " src="img/product_pictures/<?php echo $imagenes[0] ?>">

									</a>

								</div>
								<div class="col-sm-8">

									<p id="<?php echo $producto->id ?>-importancia" class="text-<?php echo $importanceClass ?>" data-importance="<?php echo $producto->prioridad ?>"><strong>Prioridad: <?php echo $importanciaString ?></strong></p>

									<p><strong >Precio aproximado: <span id="<?php echo $producto->id ?>-precio"><?php echo $producto->precio ?></span></strong></p>
									<p><strong>Aclaraciones:</strong></p>
									<p id="<?php echo $producto->id ?>-descripcion"> <?php echo $producto->descripcion ?>	</p>
									<?php 

									if(str_replace(PHP_EOL, "", $producto->enlaces[0])!=''){
										?>
										<p><strong>Enlaces de inter&eacute;s:</strong></p>
										<ul id="<?php echo $producto->id ?>-enlaces" class="list-unstyled">
											<?php 
											$enlaces =$producto->enlaces;
											for ($i=0; $i  <  count($enlaces); $i++) {

												$name_url=explode(";;", $enlaces[$i]);

												$nombre_enlace= isset($name_url[0]) && $name_url[0]!='' ? $name_url[0] : $name_url[1];
												?>
												<li>
													<a class="enlace-producto" id="<?php echo $producto->id ?>-enlaces-<?php echo $i ?>" href="<?php echo strpos($name_url[1], 'https://') !== false ? $name_url[1] : 'http://' . $name_url[1] ?>" target="_blank" data-test="<?php echo strrpos($name_url[1], 'https://') != '0'  ?>"><?php echo $nombre_enlace ?></a>
												</li>

	

												<?php
											}												
											?>
										</ul>
										<?php
									}

									if(count($imagenes)>1){
										echo "<p><strong>Otras imágenes:</strong></p>";
										for ($i=1; $i < count($imagenes) ; $i++) { 
											?>
											<!-- <img class="product-thumb" src="img/product_pictures/<?php echo $imagenes[$i] ?>"> -->

											<a class='gallery-item' href="img/product_pictures/<?php echo $imagenes[$i] ?>" data-gallery="#blueimp-gallery-<?php echo $producto->id ?>" title="<?php echo $producto->nombre?>">
												<img class="product-thumb" src="img/product_pictures/<?php echo $imagenes[$i] ?>" alt="<?php echo $imagen ?>">
											</a>
											<?php
										}
									}			
									?>
								</div>
								<?php
								// if($user->its_me()){
								// 	echo '<p class="text-right"><a href="#" class="editar-producto" id="editar-producto-'.$producto->id.'" data-toggle="modal" data-target="#edit-prod-modal">Editar</a></p>';
								// }
								?>
							</div>

						</div>


						<div style="display:none" id="cheto-<?php echo $producto->id ?>">
							<?php 	

							$enlaces =$producto->enlaces;
							for ($i=0; $i  <  count($enlaces); $i++) {

								$name_url=explode(";;", $enlaces[$i]);
								$nombre_enlace= isset($name_url[0]) && $name_url[0]!='' ? $name_url[0] : $name_url[1];
								?>
								<div  class="link-row-edit">
									<input name="editar_producto_enlaces_nombres[]" type="text" class="form-control link-name"  value="<?php echo $nombre_enlace ?>" placeholder="ej: Amazon">
									<input name="editar_producto_enlaces[]" type="text" class="form-control link-url"  value="<?php echo $name_url[1] ?>" placeholder="http://www.ejemplo.com">
									<a class="btn btn-danger quitar-link" >Quitar</a>
								</div>

								<?php
							}	
							?>
						</div>
						<?php	
					}
					# code...
				}else{
					?>
					<p class="text-danger page">No hay regalos en esta carta de reyes :/</p>
					<?php 				
				}
				?>
			</div>
		</div>

		<?php 
	}else{
		?>

		<p class="text-danger page">Ese usuario no existe:/ </p>
		<?php 
	}

	?>

</div>
<div class="modal fade" id="rmv-prod-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
				<h4 class="modal-title" id="myModalLabel">¿Borrar el regalo de la carta de reyes?</strong></p>
				</div>
				<div class="modal-body text-center">
					<img src="" width="300">						
				</div>
				<div class="modal-footer">
					<a href="#" type="button" class="btn btn-primary" id="rmv-prod-submit" >Borrar </a>
					<button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="new-prod-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
					<h4 class="modal-title" id="myModalLabel">Pedir un regalo</h4>
				</div>
				<div class="modal-body text-center">		
					<form id="nuevo_producto_form" class="panel-body text-left" role="form" method="post" action="php/new_prod.php" enctype="multipart/form-data">
						<div class="form-group">
							<label for="nuevo_producto_nombre">Nombre del artículo</label>
							<input name="nuevo_producto_nombre" type="text" class="form-control" id="nuevo_producto_nombre" placeholder="ej: una bolsa de piruletas">
						</div>
						<div class="form-group">
							<label for="nuevo_producto_descripcion">Descripcion</label>
							<!-- <input name="nuevo_producto_descripcion" class="form-control" type="text" id="nuevo_producto_descripcion" placeholder="ej: alguna chorrada"> -->
							<textarea name="nuevo_producto_descripcion" id="nuevo_producto_descripcion"  class="form-control" placeholder="ej: alguna chorrada"></textarea>
						</div>
						<div class="form-group">
							<label for="nuevo_producto_precio">Precio aproximado</label>
							<p class="help-block">Si no sabes pon un ? o algo así</p>
							<input name="nuevo_producto_precio" type="text" class="form-control" id="nuevo_producto_precio" value="" placeholder="ej: 10-20€">
						</div>
						<div class="form-group" >
							<div id="contenedor_enlaces_nuevo">
								<label for="nuevo_producto_enlace">Enlaces de interés</label>
								<p class="help-block">¿Dónde has visto el producto? ¿En algún sitio te gustaba más su calidad/precio?</p>
								<div class="link-row">
									<input name="nuevo_producto_enlaces_nombres[]" type="text" class="form-control link-name"  value="" placeholder="ej: Amazon">
									<input name="nuevo_producto_enlaces[]" type="text" class="form-control link-url"  value="" placeholder="http://www.ejemplo.com">
									<a class="btn btn-danger quitar-link" >Quitar</a>
								</div>
							</div>
							<a class="btn btn-success" id="otro_link">Otro link, porfa</a>

						</div>

						<div class="form-group">
							<label for="nuevo_producto_imagenes">Imágenes</label>
							<p class="help-block">Puedes incluir tantas imágenes como quieras para el producto, la primera se usara como imágen principal (Asegurate de ordenar las fotos en el orden que necesites ANTES de subirlas, el navegador no sabe en qué orden las eliges)</p>
							<input type="file" id="nuevo_producto_imagenes[]" name="nuevo_producto_imagenes[]" multiple>
						</div>
						<div class="form-group">
							<label for="nuevo_producto_privilegios">Prioridad</label>
							<p class="help-block">¿Qué tan importante es el regalo para tí? Puntúa</p>
							<select id="nuevo_producto_prioridad" name="nuevo_producto_prioridad">
								<option value="1">Imprescindible</option>
								<option value="2">Importante</option>
								<option value="3">Deseable</option>
								<option value="4">Meh</option>
							</select>
						</div>
					</form>				
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" id="nuevo_usuario_submit" onclick="document.getElementById('nuevo_producto_form').submit()">Enviar</button>
					<button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
				</div>
			</div>
		</div>
	</div>


	<div class="modal fade" id="edit-prod-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
					<h4 class="modal-title" id="myModalLabel">Editar regalo</h4>
				</div>
				<div class="modal-body text-center">		
					<form id="editar_producto_form" class="panel-body text-left" role="form" method="post" action="php/edit_prod.php" enctype="multipart/form-data">
						<div class="form-group">
							<label for="editar_producto_nombre">Nombre del artículo</label>
							<input name="editar_producto_nombre" type="text" class="form-control" id="editar_producto_nombre" value="<?php echo $producto->nombre ?>">
						</div>
						<div class="form-group">
							<label for="editar_producto_descripcion">Descripcion</label>
							<textarea name="editar_producto_descripcion" id="editar_producto_descripcion"  class="form-control" placeholder="ej: alguna chorrada"></textarea>
						</div>
						<div class="form-group">
							<label for="editar_producto_precio">Precio aproximado</label>
							<p class="help-block">Si no sabes pon un ? o algo así</p>
							<input name="editar_producto_precio" type="text" class="form-control" id="editar_producto_precio" value="<?php echo $producto->precio ?>">
						</div>
						<div class="form-group">
							<label for="editar_producto_enlace">Enlaces de interés </label>
							<p class="help-block">¿Dónde has visto el producto? ¿En algún sitio te gustaba más su calidad/precio?</p>
							<div id="contenedor_enlaces_editar">
								
								
							</div>
							<a class="btn btn-success" id="otro_link_editar">Otro link, porfa</a>

						</div>


						<div class="form-group">
							<label for="editar_producto_imagenes">Imágenes</label>
							<p class="help-block">Puedes incluir tantas imágenes como quieras para el producto, la primera se usara como imágen principal (Asegurate de ordenar las fotos en el orden que necesites ANTES de subirlas, el navegador no sabe en qué orden las eliges)</p>
							<input type="file" id="editar_producto_imagenes[]" name="editar_producto_imagenes[]" multiple>
						</div>
						<div class="form-group">
							<label for="editar_producto_privilegios">Prioridad</label>
							<p class="help-block">¿Qué tan importante es el regalo para tí? Puntúa</p>
							<select id="editar_producto_prioridad" name="editar_producto_prioridad" value="<?php echo $producto->prioridad ?>"> 
								<option value="1" <?php echo $producto->prioridad==1?"selected":""; ?>>Imprescindible</option>
								<option value="2" <?php echo $producto->prioridad==2?"selected":""; ?>>Importante</option>
								<option value="3" <?php echo $producto->prioridad==3?"selected":""; ?>>Deseable</option>
								<option value="4" <?php echo $producto->prioridad==4?"selected":""; ?>>Meh</option>
							</select>
						</div>
						<input type='hidden' id="edit_product_id" name="edit_product_id" value="<?php echo $producto->id ?>">
					</form>				
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" id="editar_usuario_submit" onclick="document.getElementById('editar_producto_form').submit()">Enviar</button>
					<button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
				</div>
			</div>
		</div>
	</div>

	<script src="js/blueimp/jquery.blueimp-gallery.min.js"></script>



	<script type="text/javascript">
	jQuery(".open-rmv-modal").click(function(){
		jQuery("#rmv-prod-submit").attr("href", "php/rmv_prod.php?prod="+jQuery(this).attr("data-remove"));
		// alert(jQuery("#"+jQuery(this).attr('data-remove')+'-main-img').attr("src"));
		jQuery("#rmv-prod-modal .modal-body").html("<h3>"+jQuery("#"+jQuery(this).attr('data-remove')+'-nombre').text()+"</h3><img src='"+jQuery("#"+jQuery(this).attr('data-remove')+'-main-img').attr("src")+"' width='200'>");
	})
	jQuery(".editar-producto").mouseover(function(){
		var id = jQuery(this).attr("id").replace("editar-producto-", "");		
		jQuery("#edit_product_id").attr("value", (jQuery.trim(id)));
		jQuery("#editar_producto_nombre").val(jQuery("#"+id+"-nombre").text());
		jQuery("#editar_producto_precio").val(jQuery("#"+id+"-precio").text());
		jQuery("#editar_producto_descripcion").text(jQuery("#"+id+"-descripcion").html().replace(/<br>/g, "\n").trim())
		jQuery("#contenedor_enlaces_editar").html(jQuery("#cheto-"+id).html());
		jQuery(".quitar-link").click(function(){
			jQuery(this).closest('.link-row-edit').remove();
		});
		jQuery("#editar_producto_prioridad option[value='"+jQuery("#"+id+"-importancia").attr("data-importance")+"']").attr("selected", "selected");
		

	})
	jQuery("#otro_link").click(function(){
		jQuery("#contenedor_enlaces_nuevo").append("<div class='link-row'> <input name='nuevo_producto_enlaces_nombres[]' type='text' class='form-control link-name'  value='' placeholder='Nombre 1'> <input name='nuevo_producto_enlaces[]' type='text' class='form-control link-url'  value='' placeholder='http://www.direccion1.com'> <a class='btn btn-danger quitar-link'>Quitar</a> </div>");
		jQuery(".quitar-link").click(function(){
			jQuery(this).closest('.link-row').remove();
		});
	});
	jQuery("#otro_link_editar").click(function(){
		jQuery("#contenedor_enlaces_editar").append("<div class='link-row-edit'> <input name='editar_producto_enlaces_nombres[]' type='text' class='form-control link-name'  value='' placeholder='Nombre 1'> <input name='editar_producto_enlaces[]' type='text' class='form-control link-url'  value='' placeholder='http://www.direccion1.com'> <a class='btn btn-danger quitar-link'>Quitar</a> </div>");
		jQuery(".quitar-link").click(function(){
			jQuery(this).closest('.link-row-edit').remove();
		});
	});

	jQuery(".quitar-link").click(function(){
		jQuery(this).closest('.link-row').remove();
	});

// jQuery("#rmv-prod-cancel").click(function(){
	// 	alert("hey");
	// 	jQuery("#rmv-prod-submit").attr("href", "#");
	// })
</script>
<?php 
}else{
	
	header("Location:http://{$_SERVER['HTTP_HOST']}/reyesmagos");
	
}


?>