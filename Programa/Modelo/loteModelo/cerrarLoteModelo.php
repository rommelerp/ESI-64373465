<?php
class cerrarLoteModelo {
    private $conexion;
    public function __construct() {
        $this->conexion = new mysqli("localhost", "root", "", "lunes");

        if ($this->conexion->connect_error) {
            die("Error de conexión: " . $this->conexion->connect_error);
        }
    }
public function cerrarLote($id) {
    //Se cambia el atributo de lote "estado" a "cerrado"
    $cerrar = "UPDATE `lotes` SET `estado` = 'cerrado' WHERE `lotes`.`idLote`='$id'";

        $this->conexion->query($cerrar);
        
    }
}
?>