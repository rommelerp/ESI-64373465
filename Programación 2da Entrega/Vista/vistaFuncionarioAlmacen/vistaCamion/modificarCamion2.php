<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar camion</title>
</head>

<body>
    <?php

    if ($filas) {
        foreach ($filas->fetch_all(MYSQLI_ASSOC) as $fila) {

            $matricula = $fila['matricula'];
        }
    }
    ?>

    <form method="post"
        action="http://localhost/PROGRAMA/Controlador/controlador.php/camionControlador/modificarCamionControlador/update2">
        <input type="hidden" value="<?php echo $matricula; ?>" name="matriculaActual">
        <b>matricula:</b><input type="number" name="matricula" value="<?php echo $matricula; ?>"><br>
        <input type="submit" value="Modificar">
    </form>
</body>

</html>