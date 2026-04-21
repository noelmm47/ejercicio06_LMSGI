<?php

session_start();
if (!isset($_SESSION['USER']))
		header ("Location: login.html");

$idUsuario = $_GET["id"];

include "conexion_bbdd.php";

$consulta = "DELETE FROM CLIENTES WHERE id = $idUsuario";

$resultado = $conexion->query($consulta);

if ($resultado == true) {
    echo "Registro eliminado.";
} else {
    echo "Error al eliminar el registro: " . $conexion->error;
}

?>