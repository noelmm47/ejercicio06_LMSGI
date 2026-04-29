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

// devolver libro o película
if (isset($_GET["devolver"])) {
    $id = (int) $_GET["devolver"];
    $tabla = $tipo == "libros" ? "LIBROS" : "PELICULAS";

    // cambiar estado a Disponible
    $conexion->query("UPDATE $tabla SET ESTADO='Disponible' WHERE ID=$id");

    header("Location: productos.php?tipo=$tipo");
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

        <!-- enlace para añadir nuevo libro o película -->
        <a href="gestion.php?tipo=<?= $tipo ?>">Añadir nuevo <?= $tipo == "libros" ? "libro" : "película" ?></a>

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
                        // imagen del libro usando la ruta de la base de datos
                        $imagen = $item["IMAGEN"];
                        if (!empty($imagen) && file_exists("./" . $imagen)) {
                            echo '<img src="' . $imagen . '" alt="Portada libro" width="80">'; 
                        }
                    ?>

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
                        // imagen de la película usando la ruta de la base de datos
                        $imagen = $item["IMAGEN"];
                        if (!empty($imagen) && file_exists("./" . $imagen)) {
                            echo '<img src="' . $imagen . '" alt="Portada película" width="80">';
                        }
                    ?>

                    <?= $item["TITULO"] ?><br>
                    Año: <?= $anio ?><br>
                    Director: <?= $item["DIRECTOR"] ?><br>
                    Actores: <?= $item["ACTORES"] ?><br>
                    Género: <?= $item["GENERO"] ?><br>
                    Adaptación: <?= $item["TITULO_LIBRO"] ?><br> <!-- libro que adapta, no su id -->

                <?php endif; ?>

                <a href="gestion.php?tipo=<?= $tipo ?>&editar=<?= $item["ID"] ?>"> Editar </a>  | <!-- enlaces para editar, borrar o reservar -->
                <a href="productos.php?tipo=<?= $tipo ?>&borrar=<?= $item["ID"] ?>" onclick="return confirm('¿Seguro que quieres borrar?')"> Borrar </a>  | <!-- pedimos confirmacion -->
                
                <?php echo $item["ESTADO"] ?><br>

                <?php if ($item["ESTADO"] != "Reservado"): ?>
                    <a href="eleccion.php?tipo=<?= $tipo ?>&id=<?= $item["ID"] ?>"> Reservar </a>
                <?php else: ?>
                    <a href="productos.php?tipo=<?= $tipo ?>&devolver=<?= $item["ID"] ?>" onclick="return confirm('¿Seguro que quieres devolverlo?')"> Devolver </a>
                <?php endif; ?>
            </li>

        <?php endforeach; ?>
        </ul>

    </body>
</html>
