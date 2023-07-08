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
    //Guardamos en las variables los valores de la persona
    if($_POST){
    $id = $_POST['id'];
    $conexion = new mysqli("localhost", "root", "", "lunes");
    $sentencia = "SELECT `id`, `nombre`, `apellido` FROM `personas` WHERE id=$id";
    $filas = $conexion->query($sentencia);
    
    foreach ($filas->fetch_all(MYSQLI_ASSOC) as $fila) {

        $key = $fila['id'];
        $nombre = $fila['nombre'];
        $apellido = $fila['apellido']; 
        
        
    }
}
    ?>

    

<form action="modificar3.php" method="post">
        <input type="hidden" name="key" value="<?php echo $key; ?>">
        <b>ID:</b> <input type="number" name="id1" value="<?php echo $key; ?>"> <br />
        <b>Nombre:</b> <input type="text" name="nombre1" value="<?php echo $nombre; ?>"> <br />
        <b>Apellido:</b> <input type="text" name="apellido1" value="<?php echo $apellido; ?>"> <br />
    <input type="submit" value="modificar"></b>
    </form>



</body>
</html>
