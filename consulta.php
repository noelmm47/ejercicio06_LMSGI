<?php

    include "conexion_bbdd.php";

    $consulta = "SELECT * from PELICULAS";

    $resultado = $conexion->query($consulta);

    $peliculas = $resultado->fetch_all(MYSQLI_ASSOC);

    print_r($peliculas);
?>
