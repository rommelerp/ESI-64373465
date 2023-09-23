<?php
class eliminarLoteModelo {
    private $conexion;
    public function __construct() {
        $this->conexion = new mysqli("localhost", "root", "", "lunes");

        if ($this->conexion->connect_error) {
            die("Error de conexión: " . $this->conexion->connect_error);
        }
    }
public function eliminarLote($id) {
        $eliminar = "DELETE FROM `lotes` WHERE `lotes`.`idLote` = $id";

        $this->conexion->query($eliminar);
        
    }
}
?>