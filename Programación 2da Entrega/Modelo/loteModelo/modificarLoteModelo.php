<?php
class modificarLoteModelo
{
    private $conexion;

    public function __construct()
    {
        $this->conexion = new mysqli("localhost", "root", "", "lunes");

        if ($this->conexion->connect_error) {
            die("Error de conexión: " . $this->conexion->connect_error);
        }
    }

    public function obtenerLoteByIdModelo($id)
    {
        $sentencia = "SELECT `idLote` FROM `lotes` WHERE idLote=$id";
        $filas = $this->conexion->query($sentencia);

        return $filas;

    }

    public function actualizarLote($lote) {
        $modificar = "UPDATE `lotes` SET `idLote`='{$lote['idLote']}' WHERE `lotes`.`idLote`='{$lote['idLoteActual']}'";
        $this->conexion->query($modificar);
    }

}
?>