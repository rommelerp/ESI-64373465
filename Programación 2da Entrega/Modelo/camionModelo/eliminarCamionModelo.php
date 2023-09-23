<?php
class eliminarCamionModelo {
    private $conexion;
    public function __construct() {
        $this->conexion = new mysqli("localhost", "root", "", "lunes");

        if ($this->conexion->connect_error) {
            die("Error de conexión: " . $this->conexion->connect_error);
        }
    }
    public function eliminarCamion($id) { 
        $eliminar = "DELETE FROM `camion` WHERE `camion`.`matricula` = $id"; 
        $this->conexion->query($eliminar);
    }
}
?>