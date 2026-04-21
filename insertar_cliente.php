<?php

    include "conexion_bbdd.php";
	
	session_start();
	if (!isset($_SESSION['USER']))
		header ("Location: login.html");

    $nombre = $_POST["nombre"];
    $apellidos = $_POST["apellidos"];
    $dni = $_POST["dni"];
    $direccion = $_POST["direccion"];
    $poblacion = $_POST["poblacion"];

    $consulta = "INSERT INTO CLIENTES (NOMBRE, APELLIDOS, DNI, DIRECCION, POBLACION) VALUES ('$nombre', '$apellidos', '$dni','$direccion', '$poblacion')";

    $resultado = $conexion->query($consulta);

    if ($resultado == TRUE) {
        echo "Insertado con éxito";
    } else {
        echo "Error en la inserción: " . $conexion->error;
    }

    ?>