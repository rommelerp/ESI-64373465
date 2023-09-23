<?php
class eliminarPaqueteModelo {
    private $conexion;
    public function __construct() {
        $this->conexion = new mysqli("localhost", "root", "", "lunes");

        if ($this->conexion->connect_error) {
            die("Error de conexión: " . $this->conexion->connect_error);
        }
    }
public function eliminarPaquete($id) {
        $eliminar = "DELETE FROM `paquetes` WHERE `paquetes`.`idPaquete` = $id";

        $this->conexion->query($eliminar);
        
    }
}
?>