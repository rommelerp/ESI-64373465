<?php
require_once '../Modelo/almacenModelo/almacenModelo.php'; 
require_once 'registrarAlmacenControlador.php'; 

class Api
{
    private $modelo;
    private $api;

    private $controlador;

    public function __construct()
    {
        $this->modelo = new almacenModelo();
    }

    public function registrarAlmacen($post_data) 
    {
        $id = $post_data['idAlmacen']; 

        $resultado = $this->modelo->obtenerAlmacenPorId($id); 

        if ($resultado->num_rows > 0) {
            // Ya existe un almacen
            $this->controlador = new registrarAlmacenControlador(); 
            $this->controlador->accionNoExitoso();

            // Sino, se REGISTRA al almacen  
        } else {
            $this->modelo->registrarAlmacen($id); 
        }
    }

    public function registroRealizado()
    {
        $this->controlador = new registrarAlmacenControlador();
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