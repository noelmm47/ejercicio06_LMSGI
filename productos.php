<?php
include "conexion_bbdd.php";
header('Content-Type: text/html; charset=UTF-8');

$tipo = $_POST["acceso"] ?? $_GET["tipo"] ?? "libros";

// borramos libros o películas y recargamos la página
if (isset($_GET["borrar"])) {
    $id = (int) $_GET["borrar"];
    $tabla = $tipo == "libros" ? "LIBROS" : "PELICULAS";
    $conexion->query("DELETE FROM $tabla WHERE ID = $id");
    header("Location: productos.php?tipo=$tipo");
    exit;
}

// añadimos o editamos libros y peliculas
if (!empty($_POST["accion"])) {

    if ($tipo == "libros") { //guardamos las variables insertadas para libro

        $titulo    = $_POST["TITULO"];
        $autor_id  = $_POST["AUTOR_ID"];
        $genero    = $_POST["GENERO"];
        $editorial = $_POST["EDITORIAL"];
        $paginas   = $_POST["PAGINAS"];
        $anio      = $_POST["AÑO"];
        $precio    = $_POST["PRECIO"];

        if ($_POST["accion"] == "insertar") { //añadimos
            $conexion->query("INSERT INTO LIBROS (TITULO, AUTOR_ID, GENERO, EDITORIAL, PAGINAS, AÑO, PRECIO)
                              VALUES ('$titulo', '$autor_id', '$genero', '$editorial', '$paginas', '$anio', '$precio')");
        } else {
            $id = (int) $_POST["ID"]; // si no añadimos es que editamos
            $conexion->query("UPDATE LIBROS SET 
                                TITULO='$titulo',
                                AUTOR_ID='$autor_id',
                                GENERO='$genero',
                                EDITORIAL='$editorial',
                                PAGINAS='$paginas',
                                AÑO='$anio',
                                PRECIO='$precio'
                              WHERE ID=$id");
        }

    } else { // lo mismo para película

        $titulo        = $_POST["TITULO"];
        $anio_estreno  = $_POST["AÑO_ESTRENO"];
        $director      = $_POST["DIRECTOR"];
        $actores       = $_POST["ACTORES"];
        $genero        = $_POST["GENERO"];
        $tipo_adap     = $_POST["TIPO_ADAPTACION"];
        $adaptacion_id = $_POST["ADAPTACION_ID"] ?: "NULL";

        if ($_POST["accion"] == "insertar") { // añadimos
            $conexion->query("INSERT INTO PELICULAS (TITULO, AÑO_ESTRENO, DIRECTOR, ACTORES, GENERO, TIPO_ADAPTACION, ADAPTACION_ID)
                              VALUES ('$titulo', '$anio_estreno', '$director', '$actores', '$genero', '$tipo_adap', $adaptacion_id)");
        } else {
            $id = (int) $_POST["ID"]; // o editamos
            $conexion->query("UPDATE PELICULAS SET 
                                TITULO='$titulo',
                                AÑO_ESTRENO='$anio_estreno',
                                DIRECTOR='$director',
                                ACTORES='$actores',
                                GENERO='$genero',
                                TIPO_ADAPTACION='$tipo_adap',
                                ADAPTACION_ID=$adaptacion_id
                              WHERE ID=$id");
        }
    }

    header("Location: productos.php?tipo=$tipo"); // y recargamos la página
    exit;
}

// los filtros y las consultas para sacar datos de tablas
$filtro = $_POST["filtro"] ?? "";
$campo  = $_POST["campo"] ?? "";

if ($tipo == "libros") { //si es un libro sacamos todos los datos del libro en LIBROS y el autor de AUTORES

    $consulta = " 
        SELECT LIBROS.*, AUTORES.AUTOR AS NOMBRE_AUTOR
        FROM LIBROS
        LEFT JOIN AUTORES ON LIBROS.AUTOR_ID = AUTORES.ID
    ";

    if (!empty($filtro)) { // filtramos por libro o por autor
        if ($campo == "nombre") {
            $consulta .= " WHERE LIBROS.TITULO LIKE '%$filtro%'";
        } elseif ($campo == "autor") {
            $consulta .= " WHERE AUTORES.AUTOR LIKE '%$filtro%'";
        }
    }

} else { // si es una película hacemos lo propio, todos los datos de PELICULAS y el libro que adapta

    $consulta = "
        SELECT PELICULAS.*, LIBROS.TITULO AS TITULO_LIBRO
        FROM PELICULAS
        LEFT JOIN LIBROS ON PELICULAS.ADAPTACION_ID = LIBROS.ID
    ";

    if (!empty($filtro)) { // filtramos por pelicula o genero
        if ($campo == "nombre") {
            $consulta .= " WHERE PELICULAS.TITULO LIKE '%$filtro%'";
        } elseif ($campo == "genero") {
            $consulta .= " WHERE PELICULAS.GENERO LIKE '%$filtro%'";
        }
    }
}

$resultado = $conexion->query($consulta); //hacemos la consulta y guardamos los resultados en un array al cuadrado
$items = $resultado->fetch_all(MYSQLI_ASSOC);

// editar
$editItem = null;

if (isset($_GET["editar"])) { // guardamos los datos a editar en $editItem
    $idEdit = (int) $_GET["editar"];
    $tabla = $tipo == "libros" ? "LIBROS" : "PELICULAS";
    $resEdit = $conexion->query("SELECT * FROM $tabla WHERE ID=$idEdit");
    $editItem = $resEdit->fetch_assoc();
}

// ordenamos autores por nombre y libros por título para el botón select
$listaAutores = $conexion->query("SELECT ID, AUTOR FROM AUTORES ORDER BY AUTOR")->fetch_all(MYSQLI_ASSOC);
$listaLibros  = $conexion->query("SELECT ID, TITULO FROM LIBROS ORDER BY TITULO")->fetch_all(MYSQLI_ASSOC);

?>


<!DOCTYPE html> <!-- el php -->
<html lang="es">
	<head>
		<meta charset="UTF-8"> <!-- modificamos el título según por donde entremos -->
		<title>Gestión de <?= $tipo == "libros" ? "Libros" : "Películas" ?></title>
	</head>
	<body>

		<h1>Gestión de <?= $tipo == "libros" ? "Libros" : "Películas" ?></h1> <!-- lo mismo con la cabecera -->

		<!-- formulario de añadir o editar, si no estamos editando es añadir por defecto -->
		<h2><?= $editItem ? "Editar" : "Nuevo" ?> <?= $tipo == "libros" ? "libro" : "película" ?></h2>

		<form method="POST" action="productos.php?tipo=<?= $tipo ?>"> <!-- decimos si estamos en libro o pelicula y si editamos o insertamos -->
			<input type="hidden" name="acceso" value="<?= $tipo ?>">
			<input type="hidden" name="accion" value="<?= $editItem ? "editar" : "insertar" ?>">

			<?php if ($editItem): ?> <!-- si estamos editando no queremos ver ni modificar el id -->
				<input type="hidden" name="ID" value="<?= $editItem["ID"] ?>">
			<?php endif; ?>

			<?php if ($tipo == "libros"): ?> <!-- formulario para libros -->

				Título: <input type="text" name="TITULO" value="<?= $editItem["TITULO"] ?? "" ?>"><br><br> <!-- titulo -->

				Autor: <!-- autor, aquí guarda el id del autor, pero muestra su nombre -->
				<select name="AUTOR_ID">
					<?php foreach ($listaAutores as $autor): ?>
						<option value="<?= $autor["ID"] ?>"
							<?= isset($editItem["AUTOR_ID"]) && $editItem["AUTOR_ID"] == $autor["ID"] ? "selected" : "" ?>>
							<?= $autor["AUTOR"] ?>
						</option>
					<?php endforeach; ?>
				</select>
				<br>
				<br>

				Género: <input type="text" name="GENERO" value="<?= $editItem["GENERO"] ?? "" ?>"><br><br> <!-- resto de campos de libro -->
				Editorial: <input type="text" name="EDITORIAL" value="<?= $editItem["EDITORIAL"] ?? "" ?>"><br><br>
				Páginas: <input type="number" name="PAGINAS" value="<?= $editItem["PAGINAS"] ?? "" ?>"><br><br>
				Año: <input type="date" name="AÑO" value="<?= $editItem["AÑO"] ?? "" ?>"><br><br>
				Precio: <input type="text" name="PRECIO" value="<?= $editItem["PRECIO"] ?? "" ?>"><br><br> <!-- por que tienen precio? -->

			<?php else: ?> <!-- si no es libro es que es película -->

				Título: <input type="text" name="TITULO" value="<?= $editItem["TITULO"] ?? "" ?>"><br><br> <!-- los campos de pelicula -->
				Año estreno: <input type="text" name="AÑO_ESTRENO" value="<?= $editItem["AÑO_ESTRENO"] ?? "" ?>"><br><br>
				Director: <input type="text" name="DIRECTOR" value="<?= $editItem["DIRECTOR"] ?? "" ?>"><br><br>
				Actores: <input type="text" name="ACTORES" value="<?= $editItem["ACTORES"] ?? "" ?>"><br><br>
				Género: <input type="text" name="GENERO" value="<?= $editItem["GENERO"] ?? "" ?>"><br><br>

				Tipo adaptación: <input type="text" name="TIPO_ADAPTACION" value="<?= $editItem["TIPO_ADAPTACION"] ?? "" ?>"><br><br> <!-- el php -->

				Adaptación: <!-- el select para elegir que libro adaptamos, hay un campo vacío que no envía nada y si estámos editando se autorrellena -->
				<select name="ADAPTACION_ID">
					<option value="">(Sin adaptación)</option>
					<?php foreach ($listaLibros as $libro): ?>
						<option value="<?= $libro["ID"] ?>"
							<?= isset($editItem["ADAPTACION_ID"]) && $editItem["ADAPTACION_ID"] == $libro["ID"] ? "selected" : "" ?>>
							<?= $libro["TITULO"] ?>
						</option>
					<?php endforeach; ?>
				</select>
				<br>
				<br>

			<?php endif; ?>

			<button type="submit"><?= $editItem ? "Guardar cambios" : "Insertar" ?></button> <!-- boton de envío en funcion de si añadimos o editamos -->
		</form>

		<hr> <!-- linea para separar de la lista -->

<!-- filtros -->
		<form method="POST" action="productos.php?tipo=<?= $tipo ?>"> <!-- miniformulario del filtro -->
			<input type="hidden" name="acceso" value="<?= $tipo ?>">
			<input type="text" name="filtro" placeholder="Buscar..." value="<?= htmlspecialchars($filtro) ?>">

			<?php if ($tipo == "libros"): ?> <!-- si son libros -->
				<select name="campo">
					<option value="nombre" <?= $campo=="nombre"?"selected":"" ?>>Nombre</option>
					<option value="autor" <?= $campo=="autor"?"selected":"" ?>>Autor</option>
				</select>
			<?php else: ?>
				<select name="campo"> <!-- si son películas -->
					<option value="nombre" <?= $campo=="nombre"?"selected":"" ?>>Nombre</option>
					<option value="genero" <?= $campo=="genero"?"selected":"" ?>>Género</option>
				</select>
			<?php endif; ?>

			<button type="submit">Filtrar</button>
		</form>

		<hr>

<!-- listado, faltaría añadir imagen -->
		<ul>
		<?php foreach($items as $item): ?> <!-- le decimos si es libro o pelicula -->

			<li>
				<?php if ($tipo == "libros"): ?> <!-- si es libro -->

					<?php 
						$anio = !empty($item["AÑO"]) ? date("Y", strtotime($item["AÑO"])) : "";
					?> <!-- sacamos el año de la fecha -->

					<?php 
						$imagen = "images/L" . str_pad($item["ID"], 2, "0", STR_PAD_LEFT) . ".jpg";
						if (file_exists($imagen)) {
							echo '<img src="' . $imagen . '" alt="Portada libro" width="80">'; 
						}
					?> <!-- imagen del libro, si existe, toda esta vaina crea el nombre del jpg para llamarlo-->

					<?= $item["TITULO"] ?><br>
					Autor: <?= $item["NOMBRE_AUTOR"] ?><br> <!-- nombre del autor, no su id -->
					Género: <?= $item["GENERO"] ?><br>
					Editorial: <?= $item["EDITORIAL"] ?><br>
					Páginas: <?= $item["PAGINAS"] ?><br>
					Año: <?= $anio ?><br>
					Precio: <?= $item["PRECIO"] ?><br>

				<?php else: ?> <!-- si es pelicula -->

					<?php
						$anio = substr($item["AÑO_ESTRENO"], 0, 4);
					?> <!-- sacamos los primeros 4 caracteres porque alguien decidio que la fecha de libro y la de película no compartían el mismo tipo de dato... -->

					<?php 
						$imagen = "imagenes/P" . str_pad($item["ID"], 2, "0", STR_PAD_LEFT) . ".jpg";
						if (file_exists($imagen)) {
							echo '<img src="' . $imagen . '" alt="Portada película" width="80">';
						}
					?> <!-- imagen de la pelicula, mismo procedimiento que con el libro -->

					<?= $item["TITULO"] ?><br>
					Año: <?= $anio ?><br>
					Director: <?= $item["DIRECTOR"] ?><br>
					Actores: <?= $item["ACTORES"] ?><br>
					Género: <?= $item["GENERO"] ?><br>
					Adaptación: <?= $item["TITULO_LIBRO"] ?><br> <!-- libro que adapta, no su id -->

				<?php endif; ?>

				<a href="productos.php?tipo=<?= $tipo ?>&editar=<?= $item["ID"] ?>"> Editar </a>  <!-- enlaces para editar, borrar o reservar -->
				<a href="productos.php?tipo=<?= $tipo ?>&borrar=<?= $item["ID"] ?>" onclick="return confirm('¿Seguro que quieres borrar?')"> Borrar </a>  <!-- pedimos confirmacion -->
				<a href="reservar.php?tipo=<?= $tipo ?>&id=<?= $item["ID"] ?>"> Reservar </a>
			</li>

		<?php endforeach; ?>
		</ul>

	</body>
</html>
