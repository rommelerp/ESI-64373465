<?php
class modificarCamionModelo
{
    private $conexion;

    public function __construct()
    {
        $this->conexion = new mysqli("localhost", "root", "", "lunes");

        if ($this->conexion->connect_error) {
            die("Error de conexión: " . $this->conexion->connect_error);
        }
    }

    public function obtenerCamionByIdModelo($id)
    {
        $sentencia = "SELECT `matricula` FROM `camion` WHERE matricula=$id";
        $filas = $this->conexion->query($sentencia);

        return $filas;

    }

    public function actualizarCamion($camion) {
        $modificar = "UPDATE `camion` SET `matricula`='{$camion['matricula']}' WHERE `camion`.`matricula`='{$camion['matriculaActual']}'";
        $this->conexion->query($modificar);
    }

}
?>