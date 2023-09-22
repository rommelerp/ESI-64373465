<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Almacen</title>
</head>

<body>
    <?php

    if ($filas) {
        foreach ($filas->fetch_all(MYSQLI_ASSOC) as $fila) {

            $idAlmacen = $fila['idAlmacen'];
        }
    }
    ?>

    <form method="post"
        action="http://localhost/PROGRAMA/Controlador/controlador.php/almacenControlador/modificarAlmacenControlador/update2">
        <input type="hidden" value="<?php echo $idAlmacen; ?>" name="idAlmacenActual">
        <b>idAlmacen:</b><input type="number" name="idAlmacen" value="<?php echo $idAlmacen; ?>"><br>
        <input type="submit" value="Modificar">
    </form>
</body>

</html>