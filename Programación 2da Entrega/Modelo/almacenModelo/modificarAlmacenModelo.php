<?php
class modificarAlmacenModelo
{
    private $conexion;

    public function __construct()
    {
        $this->conexion = new mysqli("localhost", "root", "", "lunes");

        if ($this->conexion->connect_error) {
            die("Error de conexión: " . $this->conexion->connect_error);
        }
    }

    public function obtenerAlmacenByIdModelo($id)
    {
        $sentencia = "SELECT `idAlmacen` FROM `almacen` WHERE idAlmacen=$id";
        $filas = $this->conexion->query($sentencia);

        return $filas;

    }

    public function actualizarAlmacen($almacen) {
        $modificar = "UPDATE `almacen` SET `idAlmacen`='{$almacen['idAlmacen']}' WHERE `almacen`.`idAlmacen`='{$almacen['idAlmacenActual']}'";
        $this->conexion->query($modificar);
    }

}
?>