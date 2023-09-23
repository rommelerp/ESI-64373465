<?php
class entregarPaqueteModelo
{
    private $conexion;
    private $api;


    public function __construct()
    {
        $this->conexion = new mysqli("localhost", "root", "", "lunes");
        
    } 

    public function entregarPaquete($id, $entrega)
    {
        $entregar = "UPDATE `paquetes` SET `estado` = '$entrega' WHERE `paquetes`.`idPaquete`='$id'";

        $this->conexion->query($entregar);
    }


}

?>