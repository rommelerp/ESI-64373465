<?php
class usuarioModelo
{
    private $conexion;
    private $api;


    public function __construct()
    {
        $this->conexion = new mysqli("localhost", "root", "", "lunes");
        
    } 

    public function obtenerPersonaPorId($id)
    {
        $sentencia = $this->conexion->prepare("SELECT * FROM personas WHERE id = ?");
        $sentencia->bind_param("i", $id);
        
        $sentencia->execute();
        $resultado = $sentencia->get_result();
        $sentencia->close();
        
        return $resultado;
    }


}

?>