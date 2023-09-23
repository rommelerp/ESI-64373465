<?php
class asignarOrdenDeEntregaModelo{
    private $conexion;
    public function __construct() {
        $this->conexion = new mysqli("localhost", "root", "", "lunes");

        if ($this->conexion->connect_error) {
            die("Error de conexión: " . $this->conexion->connect_error);
        }
    }

    public function asignar($ordenDeEntrega) {
        $modificar = "UPDATE `paquetes` SET `entrega`='{$ordenDeEntrega['ordenDeEntrega']}' WHERE `paquetes`.`idPaquete`='{$ordenDeEntrega['idPaquete']}'";
        $this->conexion->query($modificar);
    }

}

?>