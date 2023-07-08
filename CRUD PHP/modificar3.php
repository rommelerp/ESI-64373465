<?php

if($_POST){
    $key = $_POST['key']; 
    $id1 = $_POST['id1'];
    $nombre1 = $_POST['nombre1'];
    $apellido1 = $_POST['apellido1'];
    
    $conexion = new mysqli("localhost", "root", "", "lunes");
    
    $modificar = "UPDATE `personas` SET `id`='$id1',`nombre`='$nombre1',`apellido`='$apellido1' WHERE `personas`.`id`=$key";
    if ($conexion->query($modificar) === TRUE) {
        header("Location: index.php?exito=true");
    } else {
        header("Location: index.php?exito=false");
    }

}

?>