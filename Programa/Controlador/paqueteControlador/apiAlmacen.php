<?php
require_once '../Modelo/paqueteModelo/paqueteModelo.php';
require_once 'registrarPaqueteControlador.php';
class Api
{
    private $modelo;
    private $api;

    private $controlador;

    public function __construct()
    {

        $this->modelo = new paqueteModelo();
    }


    public function registrarPaquete($post_data)
    {
        $id = $post_data['idPaquete'];
        $destino = $post_data['destino'];

        $resultado = $this->modelo->obtenerPaquetePorId($id);

        if ($resultado->num_rows > 0) {
            //ya existe una paquete
            $this->controlador = new registrarPaqueteControlador();
            $this->controlador->accionNoExitoso();

            //Sino, se REGISTRA al paquete  
        } else {
            $this->modelo->registrar($id, $destino);


        }

    }

    public function registroRealizado()
    {
        $this->controlador = new registrarPaqueteControlador();
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