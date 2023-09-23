<?php
class asignarLotePaqueteModelo{
    private $conexion;
    public function __construct() {
        $this->conexion = new mysqli("localhost", "root", "", "lunes");

        if ($this->conexion->connect_error) {
            die("Error de conexión: " . $this->conexion->connect_error);
        }
    }

    public function asignar($lote) {
        $modificar = "UPDATE `paquetes` SET `idLote`='{$lote['idLote']}' WHERE `paquetes`.`idPaquete`='{$lote['idPaquete']}'";
        $this->conexion->query($modificar);
    }

}

?>