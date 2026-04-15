<?php

    $servidor = "bbdd";
    $usuario = "root";
    $contraseña = "bbddphp";
    $nombre_bbdd = "proyecto";

    $conexion = new mysqli($servidor, $usuario, $contraseña, $nombre_bbdd);
	$conexion->set_charset("utf8");

    if($conexion->connect_error) {
        echo "Hubo un error" . $conexion->connect_error;
    }
    
?>