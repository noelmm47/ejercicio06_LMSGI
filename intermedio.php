<?php
	if(!isset($_SESSION['USER']))
		header("login.html");
		
	if(isset($_POST['Dir']){
		header($_POST['Dir']);
?>

<!DOCTYPE HTML>
<lang="es">
<head> 
	<meta charset="utf-8">
	<title></title>
</head>

<body> 
	<form action="intermedio.php" method="POST">
		<input type="radio" name="Dir" value="clientes.php"/><label>Clientes</label>
		<input type="radio" name="Dir" value="items.php"/><label>Libros</label>
		<input type="radio" name="Dir" value="items.php"/><label>Películas</label>
		<!-- Hacer que de alguna forma se sepa si se quieren libros o películas -->
		<input type="submit" value="Seleccionar"/>
	</form>
</body>

</html>