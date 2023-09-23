<?php
require_once '../Modelo/camionModelo/camionModelo.php'; 
require_once 'registrarCamionControlador.php'; 

class Api
{
    private $modelo;
    private $api;

    private $controlador;

    public function __construct()
    {
        $this->modelo = new camionModelo();
    }

    public function registrarCamion($post_data) 
    {
        $id = $post_data['matricula']; 

        $resultado = $this->modelo->obtenerCamionById($id); 


        if ($resultado->num_rows > 0) {
            // Ya existe un camion
            $this->controlador = new registrarCamionControlador(); 
            $this->controlador->accionNoExitoso();

            // Sino, se REGISTRA al camion  
        } else {
            $this->modelo->registrarCamion($id); 
        }
    }

    public function registroRealizado()
    {
        $this->controlador = new registrarCamionControlador();
        $this->controlador->accionExitoso();
    }

    public function accionRealizada()
    {
        $response = array(
            'accion' => true
        );

        return json_encode($response);
    }

    public function accionNoRealizada()
    {
        $response = array(
            'accion' => false,
            'url' => 'Location: http://localhost/PROGRAMA/Vista/error.html'
        );

        return json_encode($response);
    }
}
?>