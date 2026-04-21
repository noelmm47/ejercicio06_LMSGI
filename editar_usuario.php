<?php
	include "conexion_bbdd.php";
	
	session_start();
	if (!isset($_SESSION['USER']))
			header ("Location: login.html");

	$idUser = $_GET["id"] ?? $_POST["ID"];
	
	if(!empty($_POST["ID"])){
		$insertados= [$_POST["ID"], $_POST["NOMBRE"], $_POST["APELLIDOS"], $_POST["DNI"], $_POST["DIRECCION"], $_POST["POBLACION"]];
		
		$conexion -> query("UPDATE CLIENTES SET NOMBRE='$insertados[1]', APELLIDOS='$insertados[2]', DNI='$insertados[3]', DIRECCION='$insertados[4]', POBLACION='$insertados[5]' 
		WHERE ID=$insertados[0]");
	}
	
	$clientes = $conexion -> query("SELECT * FROM CLIENTES WHERE ID=$idUser") ->fetch_all(MYSQLI_ASSOC);
	/* Asegurarse que el nombre de la tabla es exactamente igual en tu BBDD */
?>

<HTML lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Editar cliente</title>
	</head>

	<body>
		<section id="Tabla">
		<?php foreach($clientes as $cliente):?> <!-- Como solo retorna un cliente, no hay peligro de bucle -->
			<html>
				<h1>FORMULARIO DE EDICIÓN DE DATOS</h1>
				<p>Introduce los datos que quieras modificar</p><br>
			<html>	
			<form target="editar_clientes.php&ID=<?=$cliente["ID"]?>" method="POST">
				<table>
					<tr style="display:none">
						<th>ID</th>
						<td><input type="text" value="<?=$cliente["ID"]?>" name="ID"/></td>
					</tr>
					<tr>
						<th>NOMBRE</th>
						<td><input type="text" value="<?=$cliente["NOMBRE"]?>" name="NOMBRE"/></td>
					</tr>
					<tr>
						<th>APELLIDOS</th>
						<td><input type="text" value="<?=$cliente["APELLIDOS"]?>" name="APELLIDOS"/></td>
					</tr>
					<tr>
						<th>DNI</th>
						<td><input type="text" value="<?=$cliente["DNI"]?>" name="DNI"/></td>
					</tr>
					<tr>
						<th>DIRECCIÓN</th>
						<td><input type="text" value="<?=$cliente["DIRECCION"]?>" name="DIRECCION"/></td>
					</tr>
					<tr>
						<th>POBLACIÓN</th>
						<td><input type="text" value="<?=$cliente["POBLACION"]?>" name="POBLACION"/></td>
					</tr>
				<table><br><br>
				<input type="submit">
			</form>
		<?php endforeach?>	
		</section>
	</body>
</html>