<?php

    include "conexion_bbdd.php";

    $consulta = "SELECT * from CLIENTES";

    $resultado = $conexion->query($consulta);

    $clientes = $resultado->fetch_all(MYSQLI_ASSOC);

?>

<html>

    <h1>Listado de clientes</h1>
    <a href="nuevo_cliente.html">Crear nuevo cliente</a> 


    <ul>
        <?php foreach($clientes as $cliente): ?>
            <li><?php echo $cliente["NOMBRE"] ?> |
            <a href="editar_usuario.php?id=<?php echo $cliente["ID"] ?>">Editar</a> |
            <a href="borrar_usuario.php?id=<?= $cliente["ID"] ?>">Borrar</a>
        </li>
        <?php endforeach; ?>
    </ul>


</html>