<?php
require_once 'apiCamion.php';

class registrarCamionControlador
{
    private $api;

    public function __construct()
    {
        $this->api = new Api();
    }

    public function register($context)
    {
        $post_data = $context['post'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->api->registrarCamion($post_data);
        }
    }

    public function accionExitoso()
    {
        $json = $this->api->accionRealizada();
        $jsonDecode = json_decode($json, true);

        if ($jsonDecode['accion']) {
            // El registro fue exitoso, redirige a la página de éxito
            header('Location: http://localhost/PROGRAMA/Vista/vistaFuncionarioAlmacen/vistaCamion/index.html');
            exit(); // Termina la ejecución del script
        }
    }

    public function accionNoExitoso()
    {
        $resultado = $this->api->accionNoRealizada();
        $jsonDecode = json_decode($resultado, true);
        if ($jsonDecode['accion'] == false) {
            // Ya existe un camión registrado
            header($jsonDecode['url']);
            exit(); // Termina la ejecución del script
        }
    }
}
?>