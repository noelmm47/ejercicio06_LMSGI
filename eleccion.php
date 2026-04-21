<?php

    include "conexion_bbdd.php";
	
	session_start();
	if (!isset($_SESSION['USER']))
		header ("Location: login.html");
    
    // recogemos producto a reservar
    $tipoProducto = $_GET["tipo"];
    $idProducto   = $_GET["id"];

    // Sacamos clientes
    $consulta = "SELECT ID, NOMBRE, APELLIDOS FROM CLIENTES ORDER BY APELLIDOS, NOMBRE";
    $resultado = $conexion->query($consulta);
    $clientes = $resultado->fetch_all(MYSQLI_ASSOC);
?>

<html>

    <head>
        <meta charset="UTF-8">
        <title>Elegir cliente</title>
    </head>

    <body>
        <h1>Elige el cliente para la reserva</h1>
        <ul>
            <?php foreach($clientes as $cliente): ?>
                <li>
                    <?php echo $cliente["NOMBRE"] . " " . $cliente["APELLIDOS"]?> |
        
                    <form action="reservar.php" method="GET" style="display:inline;">
                        <input type="hidden" name="tipo" value="<?php echo $tipoProducto; ?>">
                        <input type="hidden" name="id" value="<?php echo $idProducto; ?>">
                        <input type="hidden" name="idCliente" value="<?php echo $cliente["ID"]; ?>">
                        
                        <button type="submit">Reservar</button> <br><br>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>

    </body>

</html>