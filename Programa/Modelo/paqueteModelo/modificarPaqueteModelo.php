<?php
class modificarPaqueteModelo
{
    private $conexion;

    public function __construct()
    {
        $this->conexion = new mysqli("localhost", "root", "", "lunes");

        if ($this->conexion->connect_error) {
            die("Error de conexión: " . $this->conexion->connect_error);
        }
    }

    public function obtenerPaqueteByIdModelo($id)
    {
        $sentencia = "SELECT `idPaquete`, `destino` FROM `paquetes` WHERE idPaquete=$id";
        $filas = $this->conexion->query($sentencia);

        return $filas;

    }

    public function actualizarPaquete($paquete) {
        $modificar = "UPDATE `paquetes` SET `idPaquete`='{$paquete['idPaquete']}', `destino`='{$paquete['destino']}' WHERE `paquetes`.`idPaquete`='{$paquete['idPaqueteActual']}'";
        $this->conexion->query($modificar);
    }

}
?>