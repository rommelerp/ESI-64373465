<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener el contenido de la solicitud
    $json = file_get_contents('php://input');

    // Verificar si se recibió un JSON válido
    $data = json_decode($json, true);

    if ($data === null) {
        // Error al decodificar el JSON
        http_response_code(400); 
        echo json_encode(array('error' => 'JSON inválido'));


        //Si salio todo bien
    } else {
        $accion = $data['accion'];
        $id = $data['id'];
        $nombre = $data['nombre'];
        $apellido = $data['apellido'];

        $conexion = new mysqli("localhost", "root", "", "lunes");



        //Si accion es igual a registrar se autentica para ver si se REGISTRA o no a la base de datos
        if ($accion == 'registrar') {

            $sentencia = "SELECT * FROM personas WHERE id = '$id'";
            $resultado = $conexion->query($sentencia);
            //Si ya hay una persona con el mismo id, no se REGISTRA al usuario
            if ($resultado->num_rows > 0) {
                echo "<script>alert('YA existe ese usuario');</script>";
                $redireccion = '<script>window.location.href = "html/error1.html?exito=true";</script>';
                echo $redireccion;
                //Sino, se REGISTRA al usuario  
            } else {
                $sentencia = "INSERT INTO personas VALUES ( '$id', '$nombre', '$apellido' )";
                $resultado = $conexion->query($sentencia);
                $redireccion = '<script>window.location.href = "usuarioIndex.php?exito=true";</script>';
                echo $redireccion;
            }







        //Si accion es igual a inicioSesion se autentica para ver si se AUTORIZA o no al usuario a acceder a la pagina
        } else if ($accion == 'inicioSesion') {
            $sentencia = "SELECT * FROM personas WHERE id = '$id'";
            $resultado = $conexion->query($sentencia);
            //Si ya hay una persona con el mismo id, se AUTORIZA al usuario accededr a la pagina
            if ($resultado->num_rows > 0) {
                $redireccion = '<script>window.location.href = "usuarioIndex.php?exito=true";</script>';
                echo $redireccion;
                //Sino, se NO SE AUOTORIZA al usuario  
            } else {
                echo "<script>alert('NO existe ese usuario');</script>";
                $redireccion = '<script>window.location.href = "html/error.html?exito=true";</script>';
                echo $redireccion;
            }
        }
    }
}
?>
