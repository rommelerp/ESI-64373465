<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar</title>
</head>

<body>

    <form action="eliminar.php" method="post">
        <b>ID:</b> <input type="number" name="id" required> <br />
        <input type="submit" value="eliminar">

        <?php
        if ($_POST) {
            $conexion = new mysqli("localhost", "root", "", "lunes");
            $id = $_POST['id']; 
            $eliminar = "DELETE FROM `personas` WHERE `personas`.`id` = $id";
            if ($conexion->query($eliminar) === TRUE) {
                header("Location: index.php?exito=true");
            } else {
                header("Location: index.php?exito=false");
            }
        }
        ?>
</body>

</html>