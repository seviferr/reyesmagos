
<?php 
function productSort( $a, $b ) {
    return $a->prioridad -  $b->prioridad;
}

// Users
function checkPass($user, $pass, $user_codes){

	foreach($user_codes as $row){
		$userPass=explode(";", $row);
		if($userPass[1]==$user && $userPass[2]==$pass){
			return array($userPass[0], $userPass[3], $userPass[4]);
		}
	}
	return false;
}

function check_group_code($input_code, $group_codes){
	
	foreach($group_codes as $row){

        $group_data=explode(";", $row);

		if(secureString($group_data[2])==secureString($input_code)){
			return $group_data;
		}
	}
	return false;
}

function secureString($string){
	return trim($string);
}

function Delete($path)
{
    if (is_dir($path) === true)
    {
        $files = array_diff(scandir($path), array('.', '..'));

        foreach ($files as $file)
        {
            Delete(realpath($path) . '/' . $file);
        }

        return rmdir($path);
    }

    else if (is_file($path) === true)
    {
        return unlink($path);
    }

    return false;
}

function redimensionar_imagen($imagen, $nombre_imagen_asociada, $nuevo_ancho, $nuevo_alto, $directorio) {

    //Recojo información de la imágen (es una ruto)
    $info_imagen = getimagesize($imagen);
    $alto = $info_imagen[1];
    $ancho = $info_imagen[0];
    $tipo_imagen = $info_imagen[2];
    $proporcionAlto = $alto / $nuevo_alto;
    $proporcionAncho = $ancho / $nuevo_ancho;
    if (($proporcionAlto > 1) || ($proporcionAncho > 1)) {
        //primero ancho y luego alto
        if ($proporcionAlto > $proporcionAncho) {
            $nuevo_alto = round($alto / $proporcionAlto, 0);
            $nuevo_ancho = round($ancho / $proporcionAlto, 0);
        } else {
            $nuevo_alto = round($alto / $proporcionAncho, 0);
            $nuevo_ancho = round($ancho / $proporcionAncho, 0);
        }
        /* // primero alto y luego ancho
          if ($proporcionAlto <= $proporcionAncho) {
          $nuevo_alto = round($alto / $proporcionAlto,0);
          $nuevo_ancho = round($ancho/ $proporcionAlto,0);
          }else {
          $nuevo_alto = round($alto / $proporcionAncho,0);
          $nuevo_ancho = round($ancho/ $proporcionAncho,0);
          } */
    } else {
        $nuevo_alto = $alto;
        $nuevo_ancho = $ancho;
    }

    // dependiendo del tipo de imagen tengo que usar diferentes funciones
    switch ($tipo_imagen) {
        case 1: //si es gif .
            $imagen_nueva = imagecreate($nuevo_ancho, $nuevo_alto);
            $imagen_vieja = imagecreatefromgif($imagen);
            //cambio de tamaño.
            imagecopyresampled($imagen_nueva, $imagen_vieja, 0, 0, 0, 0, $nuevo_ancho, $nuevo_alto, $ancho, $alto);
            if (!imagegif($imagen_nueva, $directorio . $nombre_imagen_asociada))
                return false;
            break;

        case 2: //si es jpeg .
            $imagen_nueva = imagecreatetruecolor($nuevo_ancho, $nuevo_alto);
            $imagen_vieja = imagecreatefromjpeg($imagen);
            //cambio de tamaño.
            imagecopyresampled($imagen_nueva, $imagen_vieja, 0, 0, 0, 0, $nuevo_ancho, $nuevo_alto, $ancho, $alto);
            if (!imagejpeg($imagen_nueva, $directorio . $nombre_imagen_asociada))
                return false;
            break;

        case 3: //si es png .
            $imagen_nueva = imagecreatetruecolor($nuevo_ancho, $nuevo_alto);
            $transparent = imagecolorallocatealpha($imagen_nueva, 255, 255, 255, 127);
            imagecolortransparent($imagen_nueva, $transparent);
            $imagen_vieja = imagecreatefrompng($imagen);
            //cambio de tamaño.
            imagecopyresampled($imagen_nueva, $imagen_vieja, 0, 0, 0, 0, $nuevo_ancho, $nuevo_alto, $ancho, $alto);
            if (!imagepng($imagen_nueva, $directorio . $nombre_imagen_asociada))
                return false;
            /*
              $original = imagecreatefromstring(file_get_contents($url));
              $nueva = imagecreatetruecolor($nuevoWidth, $nuevoHeight);
              $transparente = imagecolorallocate($nueva, 255, 255, 255);
              imagefill($nueva, 0, 0, $transparente);
              imagetransparent($nueva, $transparente);
              imagecopyresized($nueva, $original, 0, 0, 0, 0, $nuevoWidth, $nuevoHeight, imagesX($original), imagesY($original));

              http://blog.controlzeta.net/?p=123
             */
            break;
    }
    return true; //si todo ha ido bien devuelve true
}

function reArrayFiles(&$file_post) {

    $file_ary = array();
    $file_count = count($file_post['name']);
    $file_keys = array_keys($file_post);

    for ($i=0; $i<$file_count; $i++) {
        foreach ($file_keys as $key) {
            $file_ary[$i][$key] = $file_post[$key][$i];
        }
    }

    return $file_ary;
}
?>