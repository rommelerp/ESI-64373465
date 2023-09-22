<?php
require_once "../Controlador/almacenControlador/apiAlmacen.php";
class almacenModelo
{
    private $conexion;
    private $api;

    public function __construct()
    {
        $this->conexion = new mysqli("localhost", "root", "", "lunes");
    }

    public function registrarAlmacen($id)
    {
        $sentencia = $this->conexion->prepare("INSERT INTO almacen (idAlmacen) VALUES (?)");
        $sentencia->bind_param("i", $id);
        $sentencia->execute();
        $sentencia->close();
        $this->api = new Api();
        $this->api->registroRealizado();
    }

    public function obtenerAlmacenPorId($id)
    {
        $sentencia = $this->conexion->prepare("SELECT * FROM almacen WHERE idAlmacen = ?");
        $sentencia->bind_param("i", $id);

        $sentencia->execute();
        $resultado = $sentencia->get_result();
        $sentencia->close();

        return $resultado;
    }
}

?>