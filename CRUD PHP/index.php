<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    
</head>

<body>
    <?php

    $conexion = new mysqli("localhost", "root", "", "lunes");

    $sentencia = "select * from personas";
    $filas = $conexion->query($sentencia);

    echo '<table>';
    echo '<tr><th>ID</th><th>Nombre</th><th>Apellido</th></tr>';

    foreach ($filas->fetch_all(MYSQLI_ASSOC) as $fila) {
        echo '<tr>';
        echo '<td>' . $fila['id'] . '</td>';
        echo '<td>' . $fila['nombre'] . '</td>';
        echo '<td>' . $fila['apellido'] . '</td>';
        echo '</tr>';
    }

    echo '</table>';
    ?>

    <button><a href="añadir.php">Añadir</a></button>
    <button><a href="eliminar.php">Eliminar</a></button>
    <button><a href="modificar.php">Modificar</a></button>

</body>

</html>