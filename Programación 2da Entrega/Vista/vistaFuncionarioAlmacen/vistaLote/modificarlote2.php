<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Lote</title>
</head>

<body>
    <?php

    if($filas){
    foreach ($filas->fetch_all(MYSQLI_ASSOC) as $fila) {

        $idLote = $fila['idLote'];
        
        

    }
}
    
    
    ?>
    
    <form method="post" action="http://localhost/PROGRAMA/Controlador/controlador.php/loteControlador/modificarLoteControlador/update2">
        <input type="hidden" value="<?php echo $idLote; ?>" name="idLoteActual">
        <b>idLote:</b><input type="number" name="idLote" value="<?php echo $idLote; ?>"><br>
        
        <input type="submit" value="Modificar">
    </form>
</body>

</html>