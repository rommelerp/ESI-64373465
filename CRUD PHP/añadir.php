<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir</title>
</head>

<body>

    <form action="añadir.php" method="post">
        <b>ID:</b> <input type="number" name="id" required> <br />
        <b>Nombre:</b> <input type="text" name="nombre" required> <br />
        <b>Apellido:</b> <input type="text" name="apellido" required> <br />
        <input type="submit" value="añadir">
    </form>
        <?php
        if ($_POST) {
            $conexion = new mysqli("localhost", "root", "", "lunes");
            $id = $_POST['id'];
            $nombre = $_POST['nombre'];
            $apellido = $_POST['apellido'];
            $sentencia = "INSERT INTO personas VALUES ( '$id', '$nombre', '$apellido' )";
            if ($conexion->query($sentencia) === TRUE) {
                header("Location: index.php?exito=true");
            } else {
                header("Location: index.php?exito=false");
            }
        }
        ?>
</body>

</html>