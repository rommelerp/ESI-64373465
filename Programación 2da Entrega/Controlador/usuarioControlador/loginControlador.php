<?php
require_once 'api.php';

class loginControlador
{

    private $api;

    public function __construct()
    {
        $this->api = new Api();
    }

    public function accionExitoso()
    {
        $json = $this->api->accionRealizada();
            $jsonDecode = json_decode($json, true);

            if ($jsonDecode['accion']) {
                // El registro fue exitoso, redirige a la página de éxito
                header('Location: http://localhost/PROGRAMA/Vista/vistaUsuario/usuarioIndex.php');
                exit(); // Termina la ejecución del script
            }
    }

    public function accionNoExitoso()
    {
        $resultado = $this->api->accionNoRealizada();
        $jsonDecode = json_decode($resultado, true);
        if ($jsonDecode['accion'] == false) {
            // Ya existe una persona registrada
            header($jsonDecode['url']);
            exit(); // Termina la ejecución del script
        }
    }

    public function login($context)
    {
        $post_data = $context['post'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $this->api->loginUsuario($post_data);

        }


    }
}


?>