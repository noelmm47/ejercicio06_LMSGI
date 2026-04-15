<?php
include "conexion_bbdd.php";

// Tipo: libros o peliculas
$tipo = $_POST["acceso"] ?? $_GET["tipo"] ?? "libros";

// --- BORRAR ---
if (isset($_GET["borrar"])) {
    $id = (int) $_GET["borrar"];
    if ($tipo == "libros") {
        $conexion->query("DELETE FROM LIBROS WHERE ID = $id");
    } else {
        $conexion->query("DELETE FROM PELICULAS WHERE ID = $id");
    }
    header("Location: productos.php?tipo=$tipo");
    exit;
}

// --- INSERTAR / EDITAR ---
if (!empty($_POST["accion"])) {
    if ($tipo == "libros") {
        $titulo    = $_POST["TITULO"];
        $autor_id  = $_POST["AUTOR_ID"];
        $genero    = $_POST["GENERO"];
        $editorial = $_POST["EDITORIAL"];
        $paginas   = $_POST["PAGINAS"];
        $anio      = $_POST["AÑO"];
        $precio    = $_POST["PRECIO"];

        if ($_POST["accion"] == "insertar") {
            $conexion->query("INSERT INTO LIBROS (TITULO, AUTOR_ID, GENERO, EDITORIAL, PAGINAS, AÑO, PRECIO)
                              VALUES ('$titulo', '$autor_id', '$genero', '$editorial', '$paginas', '$anio', '$precio')");
        } elseif ($_POST["accion"] == "editar" && !empty($_POST["ID"])) {
            $id = (int) $_POST["ID"];
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

    } else { // peliculas
        $titulo        = $_POST["TITULO"];
        $anio_estreno  = $_POST["AÑO_ESTRENO"];
        $director      = $_POST["DIRECTOR"];
        $actores       = $_POST["ACTORES"];
        $genero        = $_POST["GENERO"];
        $tipo_adap     = $_POST["TIPO_ADAPTACION"];
        $adaptacion_id = $_POST["ADAPTACION_ID"];

        if ($_POST["accion"] == "insertar") {
            $conexion->query("INSERT INTO PELICULAS (TITULO, AÑO_ESTRENO, DIRECTOR, ACTORES, GENERO, TIPO_ADAPTACION, ADAPTACION_ID)
                              VALUES ('$titulo', '$anio_estreno', '$director', '$actores', '$genero', '$tipo_adap', '$adaptacion_id')");
        } elseif ($_POST["accion"] == "editar" && !empty($_POST["ID"])) {
            $id = (int) $_POST["ID"];
            $conexion->query("UPDATE PELICULAS SET 
                                TITULO='$titulo',
                                AÑO_ESTRENO='$anio_estreno',
                                DIRECTOR='$director',
                                ACTORES='$actores',
                                GENERO='$genero',
                                TIPO_ADAPTACION='$tipo_adap',
                                ADAPTACION_ID='$adaptacion_id'
                              WHERE ID=$id");
        }
    }

    header("Location: productos.php?tipo=$tipo");
    exit;
}

// --- FILTRO ---
$filtro = $_POST["filtro"] ?? "";
$campo  = $_POST["campo"] ?? "";

if ($tipo == "libros") {
    $consulta = "SELECT * FROM LIBROS";
    if (!empty($filtro)) {
        if ($campo == "nombre") {
            $consulta .= " WHERE TITULO LIKE '%$filtro%'";
        } elseif ($campo == "autor") {
            $consulta .= " WHERE AUTOR_ID IN (SELECT ID FROM AUTORES WHERE AUTOR LIKE '%$filtro%')";
        }
    }
} else {
    $consulta = "SELECT * FROM PELICULAS";
    if (!empty($filtro)) {
        if ($campo == "nombre") {
            $consulta .= " WHERE TITULO LIKE '%$filtro%'";
        } elseif ($campo == "genero") {
            $consulta .= " WHERE GENERO LIKE '%$filtro%'";
        }
    }
}

$resultado = $conexion->query($consulta);
$items = $resultado->fetch_all(MYSQLI_ASSOC);

// --- MODO EDICIÓN ---
$editItem = null;
if (isset($_GET["editar"])) {
    $idEdit = (int) $_GET["editar"];
    if ($tipo == "libros") {
        $resEdit = $conexion->query("SELECT * FROM LIBROS WHERE ID=$idEdit");
    } else {
        $resEdit = $conexion->query("SELECT * FROM PELICULAS WHERE ID=$idEdit");
    }
    $editItem = $resEdit->fetch_assoc();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de <?= $tipo == "libros" ? "Libros" : "Películas" ?></title>
</head>
<body>
    <h1>Catálogo de <?= $tipo == "libros" ? "Libros" : "Películas" ?></h1>

    <form method="POST" action="productos.php?tipo=<?= $tipo ?>">
        <input type="hidden" name="acceso" value="<?= $tipo ?>">
        <input type="text" name="filtro" placeholder="Buscar..." value="<?= htmlspecialchars($filtro) ?>">

        <?php if ($tipo == "libros"): ?>
            <select name="campo">
                <option value="nombre" <?= $campo=="nombre"?"selected":"" ?>>Nombre</option>
                <option value="autor"  <?= $campo=="autor" ?"selected":"" ?>>Autor</option>
            </select>
        <?php else: ?>
            <select name="campo">
                <option value="nombre" <?= $campo=="nombre"?"selected":"" ?>>Nombre</option>
                <option value="genero" <?= $campo=="genero"?"selected":"" ?>>Género</option>
            </select>
        <?php endif; ?>

        <button type="submit">Filtrar</button>
    </form>

    <br>

    <ul>
    <?php foreach($items as $item): ?>
        <li>
            <?php if ($tipo == "libros"): ?>
                <?= $item["TITULO"] ?> | 
                Autor ID: <?= $item["AUTOR_ID"] ?> | 
                <?= $item["GENERO"] ?> | 
                <?= $item["EDITORIAL"] ?> | 
                Páginas: <?= $item["PAGINAS"] ?> | 
                Año: <?= $item["AÑO"] ?> | 
                Precio: <?= $item["PRECIO"] ?>
            <?php else: ?>
                <?= $item["TITULO"] ?> | 
                Año: <?= $item["AÑO_ESTRENO"] ?> | 
                Director: <?= $item["DIRECTOR"] ?> | 
                Actores: <?= $item["ACTORES"] ?> | 
                Género: <?= $item["GENERO"] ?> | 
                Tipo adaptación: <?= $item["TIPO_ADAPTACION"] ?> | 
                Adaptación ID: <?= $item["ADAPTACION_ID"] ?>
            <?php endif; ?>
            |
            <a href="productos.php?tipo=<?= $tipo ?>&editar=<?= $item["ID"] ?>">Editar</a> |
            <a href="productos.php?tipo=<?= $tipo ?>&borrar=<?= $item["ID"] ?>" onclick="return confirm('¿Seguro que quieres borrar?')">Borrar</a> |
            <a href="reservar.php?tipo=<?= $tipo ?>&id=<?= $item["ID"] ?>">Reservar</a>
        </li>
    <?php endforeach; ?>
    </ul>

    <hr>

    <h2><?= $editItem ? "Editar" : "Nuevo" ?> <?= $tipo == "libros" ? "libro" : "película" ?></h2>

    <form method="POST" action="productos.php?tipo=<?= $tipo ?>">
        <input type="hidden" name="acceso" value="<?= $tipo ?>">
        <input type="hidden" name="accion" value="<?= $editItem ? "editar" : "insertar" ?>">
        <?php if ($editItem): ?>
            <input type="hidden" name="ID" value="<?= $editItem["ID"] ?>">
        <?php endif; ?>

        <?php if ($tipo == "libros"): ?>
            Título: <input type="text" name="TITULO" value="<?= $editItem["TITULO"] ?? "" ?>"><br><br>
            Autor ID: <input type="text" name="AUTOR_ID" value="<?= $editItem["AUTOR_ID"] ?? "" ?>"><br><br>
            Género: <input type="text" name="GENERO" value="<?= $editItem["GENERO"] ?? "" ?>"><br><br>
            Editorial: <input type="text" name="EDITORIAL" value="<?= $editItem["EDITORIAL"] ?? "" ?>"><br><br>
            Páginas: <input type="number" name="PAGINAS" value="<?= $editItem["PAGINAS"] ?? "" ?>"><br><br>
            Año: <input type="date" name="AÑO" value="<?= $editItem["AÑO"] ?? "" ?>"><br><br>
            Precio: <input type="text" name="PRECIO" value="<?= $editItem["PRECIO"] ?? "" ?>"><br><br>
        <?php else: ?>
            Título: <input type="text" name="TITULO" value="<?= $editItem["TITULO"] ?? "" ?>"><br><br>
            Año estreno: <input type="text" name="AÑO_ESTRENO" value="<?= $editItem["AÑO_ESTRENO"] ?? "" ?>"><br><br>
            Director: <input type="text" name="DIRECTOR" value="<?= $editItem["DIRECTOR"] ?? "" ?>"><br><br>
            Actores: <input type="text" name="ACTORES" value="<?= $editItem["ACTORES"] ?? "" ?>"><br><br>
            Género: <input type="text" name="GENERO" value="<?= $editItem["GENERO"] ?? "" ?>"><br><br>
            Tipo adaptación: <input type="text" name="TIPO_ADAPTACION" value="<?= $editItem["TIPO_ADAPTACION"] ?? "" ?>"><br><br>
            Adaptación ID: <input type="text" name="ADAPTACION_ID" value="<?= $editItem["ADAPTACION_ID"] ?? "" ?>"><br><br>
        <?php endif; ?>

        <button type="submit"><?= $editItem ? "Guardar cambios" : "Insertar" ?></button>
    </form>
</body>
</html>
