<?php
	session_start();
	if(!isset($_SESSION['USER']))
		header("Location: login.html");
?>

<!DOCTYPE html>
<html lang="es">

	<head>
	<meta charset="UTF-8">
	</head>
	
	<body>
		<h1>¿Qué deseas gestionar?</h1>
		<br>
		<h3>Clientes:</h3>
		<br>
		<p>Agrega nuevos clientes a la base de datos, modifica o borra los ya existentes.</p>
		<form action="clientes.php" method="POST">
			<button type="submit">Acceder</button>
		</form>
		<br>
		
		<h3>Catálogo:</h3>
		<br>
		<p>Gestiona la reserva y préstamo de libros y películas, agrega nuevos títulos al catálogo.</p>
		<form action="productos.php" method="POST">
		<button type="submit" name="acceso" value="libros">Libros</button>
		<br>
		<br>
		<button type="submit" name="acceso" value="peliculas">Películas</button>
		</form>
	</body>

</html>