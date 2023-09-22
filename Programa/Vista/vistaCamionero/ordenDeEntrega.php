<!DOCTYPE html>
<html>
<head>
    <title>Tabla de Entregas de Paquetes</title>
</head>
<body>
<?php

$conexion = new mysqli("localhost", "root", "", "lunes");

$sentencia = "select * from paquetes ORDER BY entrega ASC";
$filas = $conexion->query($sentencia);

echo "<h1>Tabla de Entregas de Paquetes</h1>";
echo '<table border="1">';
echo '<tr><th>Orden de Entrega</th><th>Código de Paquete</th><th>Destino</tr>';

foreach ($filas->fetch_all(MYSQLI_ASSOC) as $fila) {
    echo '<tr>';
    echo '<td>' . $fila['entrega'] . '</td>';
    echo '<td>' . $fila['idPaquete'] . '</td>';
    echo '<td>' . $fila['destino'] . '</td>';
    
    echo '</tr>';
}

echo '</table>';
?>

</body>
</html>