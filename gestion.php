<?php
include "conexion_bbdd.php";
header('Content-Type: text/html; charset=UTF-8');

$tipo = $_GET["tipo"] ?? $_POST["acceso"] ?? "libros";

// entramos por insertar o editar

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $accion = $_POST["accion"];
    $tabla = $tipo == "libros" ? "LIBROS" : "PELICULAS";

    // recogemos todos los campos del formulario
    $datos = $_POST;

    // si estamos editando, guardamos el ID
    $id = isset($_POST["ID"]) ? (int) $_POST["ID"] : null;

    // quitamos campos que no pertenecen al grupo
    unset($datos["acceso"], $datos["accion"], $datos["ID"]);

// añadimos productos

    if ($accion === "insertar") {

        // insertamos SIN imagen
        $columnas = implode(",", array_keys($datos));
        $valores  = "'" . implode("','", array_map([$conexion, 'real_escape_string'], $datos)) . "'";

        $conexion->query("INSERT INTO $tabla ($columnas) VALUES ($valores)");

        // Obtenemos el ID nuevo
        $id = $conexion->insert_id;

        // creamos el nombre del archivo
        $prefijo = ($tipo == "libros") ? "L" : "P";
        $nombreImagen = "/images/" . $prefijo . str_pad($id, 2, "0", STR_PAD_LEFT) . ".jpg";

        // si se subió imagen, la guardamos
        if (!empty($_FILES["IMAGEN"]["tmp_name"])) {
            move_uploaded_file($_FILES["IMAGEN"]["tmp_name"], "." . $nombreImagen);
        }

        // guardamos la ruta en la base de datos
        $conexion->query("UPDATE $tabla SET IMAGEN='$nombreImagen' WHERE ID=$id");
    }

// editamos productos

    if ($accion === "editar") {

        // actualizamos todos los campos excepto IMAGEN
        $updates = [];
        foreach ($datos as $campo => $valor) {
            $valor = $conexion->real_escape_string($valor);
            $updates[] = "$campo='$valor'";
        }
        $conexion->query("UPDATE $tabla SET " . implode(",", $updates) . " WHERE ID=$id");

        // si se subió una nueva imagen, reemplazamos la que había
        if (!empty($_FILES["IMAGEN"]["tmp_name"])) {

            $prefijo = ($tipo == "libros") ? "L" : "P";
            $nombreImagen = "/images/" . $prefijo . str_pad($id, 2, "0", STR_PAD_LEFT) . ".jpg";

            move_uploaded_file($_FILES["IMAGEN"]["tmp_name"], "." . $nombreImagen);

            $conexion->query("UPDATE $tabla SET IMAGEN='$nombreImagen' WHERE ID=$id");
        }
    }

    // volvemos a productos.php
    header("Location: productos.php?tipo=$tipo");
    exit;
}

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
        <title><?= $editItem ? "Editar" : "Nuevo" ?> <?= $tipo == "libros" ? "Libro" : "Película" ?></title>
    </head>
    <body>

        <h1><?= $editItem ? "Editar" : "Nuevo" ?> <?= $tipo == "libros" ? "libro" : "película" ?></h1> <!-- lo mismo con la cabecera -->

        <!-- formulario de añadir o editar, si no estamos editando es añadir por defecto -->
        <form method="POST" action="gestion.php?tipo=<?= $tipo ?>" enctype="multipart/form-data"> <!-- la vaina de subir imágenes -->
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
                Precio: <input type="text" name="PRECIO" value="<?= $editItem["PRECIO"] ?? "" ?>"><br><br>

            <?php else: ?> <!-- si no es libro es que es película -->

                Título: <input type="text" name="TITULO" value="<?= $editItem["TITULO"] ?? "" ?>"><br><br> <!-- los campos de pelicula -->
                Año estreno: <input type="text" name="AÑO_ESTRENO" value="<?= $editItem["AÑO_ESTRENO"] ?? "" ?>"><br><br>
                Director: <input type="text" name="DIRECTOR" value="<?= $editItem["DIRECTOR"] ?? "" ?>"><br><br>
                Actores: <input type="text" name="ACTORES" value="<?= $editItem["ACTORES"] ?? "" ?>"><br><br>
                Género: <input type="text" name="GENERO" value="<?= $editItem["GENERO"] ?? "" ?>"><br><br>

                Tipo adaptación: <input type="text" name="TIPO_ADAPTACION" value="<?= $editItem["TIPO_ADAPTACION"] ?? "" ?>"><br><br>

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

            <!-- IMAGEN -->
            <?php if ($editItem && !empty($editItem["IMAGEN"])): ?>
                Cambiar imagen:<br>
                <img src="<?= $editItem["IMAGEN"] ?>" width="80"><br>
                <input type="file" name="IMAGEN"><br><br>
            <?php else: ?>
                Añadir imagen:<br>
                <input type="file" name="IMAGEN"><br><br>
            <?php endif; ?>

            <button type="submit"><?= $editItem ? "Guardar cambios" : "Insertar" ?></button> <!-- boton de envío en funcion de si añadimos o editamos -->
        </form>

        <br>
        <a href="productos.php?tipo=<?= $tipo ?>">Volver a la lista</a>

    </body>
</html>
