<?php
class asignarLoteCamionModelo{
    private $conexion;
    public function __construct() {
        $this->conexion = new mysqli("localhost", "root", "", "lunes");

        if ($this->conexion->connect_error) {
            die("Error de conexión: " . $this->conexion->connect_error);
        }
    }

    public function asignar($camion) {
        $modificar = "UPDATE `camion` SET `idLote`='{$camion['idLote']}' WHERE `camion`.`matricula`='{$camion['matricula']}'";
        $this->conexion->query($modificar);
    }

}

?>