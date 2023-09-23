<?php
require_once "../Controlador/paqueteControlador/apiAlmacen.php";
class paqueteModelo
{
    private $conexion;
    private $api;


    public function __construct()
    {
        $this->conexion = new mysqli("localhost", "root", "", "lunes");
        
    }



    public function registrar($id, $destino)
    {
        $sentencia = $this->conexion->prepare("INSERT INTO paquetes (idPaquete, destino) VALUES (?, ?)");
        $sentencia->bind_param("is", $id, $destino);
        $sentencia->execute();
        $sentencia->close();
        $this->api = new Api();
        $this->api->registroRealizado();
    }

    public function obtenerPaquetePorId($id)
    {
        $sentencia = $this->conexion->prepare("SELECT * FROM paquetes WHERE idPaquete = ?");
        $sentencia->bind_param("i", $id);
        
        $sentencia->execute();
        $resultado = $sentencia->get_result();
        $sentencia->close();
        
        return $resultado;
    }


}

?>