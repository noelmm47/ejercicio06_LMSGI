<?php

    include "conexion_bbdd.php";
	header('Content-Type: text/html; charset=UTF-8');
	
	session_start();
	if (!isset($_SESSION['USER']))
			header ("Location: login.html");

    $consulta = "SELECT * from CLIENTES";

    $resultado = $conexion->query($consulta);

    $clientes = $resultado->fetch_all(MYSQLI_ASSOC);

?>

<html>

    <h1>Listado de clientes</h1>
    <a href="nuevo_cliente.html">Crear nuevo cliente</a> 


    <ul>
        <?php foreach($clientes as $cliente): ?>
            <li><?php echo $cliente["NOMBRE"] . " " . $cliente["APELLIDOS"]?> |
            <a href="editar_usuario.php?id=<?php echo $cliente["ID"] ?>">Editar</a> |
            <a href="borrar_usuario.php?id=<?= $cliente["ID"] ?>">Borrar</a>
        </li>
        <?php endforeach; ?>
    </ul>


</html>