<?php
require_once '../Modelo/usuarioModelo/loginModelo.php';
require_once 'loginControlador.php';
class Api
{
    private $modelo;
    private $api;

    private $controlador;

    public function __construct()
    {

        $this->modelo = new usuarioModelo();
    }

    public function loginUsuario($post_data)
    {
        $id = $post_data['id'];

        $resultado = $this->modelo->obtenerPersonaPorId($id);

        if ($resultado->num_rows > 0) {

            //LOGIN EXITOSO
            $this->controlador = new loginControlador();
            $this->controlador->accionExitoso();

        } else {
            //LOGIN DENEGADO
            $this->controlador = new loginControlador();
            $this->controlador->accionNoExitoso();

        }

    }

    // Otros métodos relacionados con la API...

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