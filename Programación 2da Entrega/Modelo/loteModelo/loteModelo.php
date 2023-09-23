<?php
require_once "../Controlador/loteControlador/apiLote.php";
class loteModelo
{
    private $conexion;
    private $api;


    public function __construct()
    {
        $this->conexion = new mysqli("localhost", "root", "", "lunes");
        
    }



    public function registrarLote($id)
    {
        $sentencia = $this->conexion->prepare("INSERT INTO lotes (idLote) VALUES (?)");
        $sentencia->bind_param("s", $id);
        $sentencia->execute();
        $sentencia->close();
        $this->api = new Api();
        $this->api->registroRealizado();
    }

    public function obtenerLotePorId($id)
    {
        $sentencia = $this->conexion->prepare("SELECT * FROM lotes WHERE idLote = ?");
        $sentencia->bind_param("s", $id);
        
        $sentencia->execute();
        $resultado = $sentencia->get_result();
        $sentencia->close();
        
        return $resultado;
    }


}

?>