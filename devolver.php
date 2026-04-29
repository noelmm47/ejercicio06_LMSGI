<?php <!-- en desuso -->

include "conexion_bbdd.php";

session_start();
if (!isset($_SESSION['USER'])) {
    header("Location: login.html");
    exit;
}

$tipoProducto = $_GET["tipo"];
$idProducto = $_GET["id"];

$resultado;

if ($tipoProducto == "libros") {
    $resultado = $conexion->query("UPDATE LIBROS SET ESTADO = 'Disponible' WHERE ID = $idProducto");

} else {
    $resultado = $conexion->query("UPDATE PELICULAS SET ESTADO = 'Disponible' WHERE ID = $id");
}
    echo "Devolución realizada correctamente. Muchas gracias.<br><br>";
    echo '<a href="productos.php">Volver a la página principal</a>';
?>
