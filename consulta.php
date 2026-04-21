<?php

    include "conexion_bbdd.php";
	
	session_start();
	if (!isset($_SESSION['USER']))
			header ("Location: login.html");

    $consulta = "SELECT * from PELICULAS";

    $resultado = $conexion->query($consulta);

    $peliculas = $resultado->fetch_all(MYSQLI_ASSOC);

    print_r($peliculas);
?>
