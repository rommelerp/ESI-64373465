<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario con Variables desde otro Archivo</title>
</head>

<body>
    <?php
    if ($filas) {
        foreach ($filas->fetch_all(MYSQLI_ASSOC) as $fila) {

            $idPaquete = $fila['idPaquete'];
            $destino = $fila['destino'];



        }
    }


    ?>

    <form method="post"
        action="http://localhost/PROGRAMA/Controlador/controlador.php/paqueteControlador/modificarPaqueteControlador/update2">
        <input type="hidden" value="<?php echo $idPaquete; ?>" name="idPaqueteActual">
        <b>idPaquete:</b><input type="number" name="idPaquete" value="<?php echo $idPaquete; ?>"><br>
        <b>Destino:</b><input type="text" name="destino" value="<?php echo $destino; ?>"><br>

        <input type="submit" value="Modificar">
    </form>
</body>

</html>