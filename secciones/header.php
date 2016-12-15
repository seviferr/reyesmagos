<?php 
if($user!=''){
	?>
	<div class="row header-content">
		<div class="col-sm-6">
			<h3 id="greeting" class=" josefin">
				<?php 

				echo "Hola " . $user_name;
				?>
			</h3>
			<div>
				<a href="/reyesmagos/">Inicio  </a> |
				<?php 
				if ($privileges!='onlylooking') {
					?>
					<a href="cartas/<?php echo $user ?>">Ver tu carta </a> | 
					<?php
				}
				?>
				<a href="php/logout.php">Salir</a>
				<?php

				?>
			</div>
		</div>
		<div class="hidden-xs col-sm-6 text-right" style="padding:0px" >
			<div class="iconomagos"><a href="/reyesmagos"><img  src="img/minimagos.png"></a></div>
		</div>
		<?php 
	}
	?>

</div>