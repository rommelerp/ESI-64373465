<?php
require_once '../Modelo/loteModelo/loteModelo.php';
require_once 'registrarLoteControlador.php';
class Api
{
    private $modelo;
    private $api;

    private $controlador;

    public function __construct()
    {

        $this->modelo = new loteModelo();
    }


    public function registrarLote($post_data)
    {
        $id = $post_data['idLote'];

        $resultado = $this->modelo->obtenerLotePorId($id);

        if ($resultado->num_rows > 0) {
            //ya existe un lote
            $this->controlador = new registrarLoteControlador();
            $this->controlador->accionNoExitoso();

            //Sino, se REGISTRA al paquete  
        } else {
            $this->modelo->registrarLote($id);



        }

    }

    public function registroRealizado()
    {
        $this->controlador = new registrarLoteControlador();
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