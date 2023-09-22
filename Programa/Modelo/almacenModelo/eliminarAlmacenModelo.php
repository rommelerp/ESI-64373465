<?php
class eliminarAlmacenModelo {
    private $conexion;
    public function __construct() {
        $this->conexion = new mysqli("localhost", "root", "", "lunes");

        if ($this->conexion->connect_error) {
            die("Error de conexión: " . $this->conexion->connect_error);
        }
    }
    public function eliminarAlmacen($id) { 
        $eliminar = "DELETE FROM `almacen` WHERE `almacen`.`idAlmacen` = $id"; 
        $this->conexion->query($eliminar);
    }
}
?>