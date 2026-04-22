<?php

    include "conexion_bbdd.php";

    $tipoProducto = $_GET["tipo"];
    $idProducto = $_GET["id"];
    $idCliente = $_GET["idCliente"];

    $resultado;

    $fecha = date('Y-m-d');

    if($tipoProducto == "libros") {
        $resultado = $conexion->query("INSERT INTO RESERVAS (ID, ID_LIBRO, ID_PELICULA, FECHA_RESERVA) VALUES ('$idCliente', '$idProducto', NULL, '$fecha')");
        if ($resultado) {
            $conexion->query("UPDATE LIBROS SET ESTADO = 'Reservado' WHERE ID = '$idProducto'");

            echo "Reserva efectuada correctamente.<br><br>";
        } else {
            echo "Algo ha pasado. Vuelve sobre tus pasos.<br><br>";
    }

    } else {
        $resultado = $conexion->query("INSERT INTO RESERVAS (ID, ID_LIBRO, ID_PELICULA, FECHA_RESERVA) VALUES ('$idCliente', NULL, '$idProducto', '$fecha')");
        if ($resultado== TRUE) {
            $conexion->query("UPDATE PELICULAS SET ESTADO = 'Reservado' WHERE ID = '$idProducto'");

            echo "Reserva efectuada correctamente.<br><br>";
        } else {
            echo "Algo ha pasado. Vuelve sobre tus pasos.<br><br>";
        }
    }
    echo '<a href="productos.php">Volver a la página principal</a>';

?>