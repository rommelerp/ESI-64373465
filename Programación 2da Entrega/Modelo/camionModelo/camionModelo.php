<?php
require_once "../Controlador/camionControlador/apiCamion.php";
class camionModelo
{
    private $conexion;
    private $api;

    public function __construct()
    {
        $this->conexion = new mysqli("localhost", "root", "", "lunes");
    }

    public function registrarCamion($id)
    {
        $sentencia = $this->conexion->prepare("INSERT INTO camion (matricula) VALUES (?)");
        $sentencia->bind_param("i", $id);
        $sentencia->execute();
        $sentencia->close();
        $this->api = new Api();
        $this->api->registroRealizado();
    }

    public function obtenerCamionById($id)
    {
        $sentencia = $this->conexion->prepare("SELECT * FROM camion WHERE matricula = ?");
        $sentencia->bind_param("i", $id);

        $sentencia->execute();
        $resultado = $sentencia->get_result();
        $sentencia->close();

        return $resultado;
    }
}

?>