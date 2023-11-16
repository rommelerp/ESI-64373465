<?php
require_once "../Modelos/autenticacionModelo.php";

switch ($_SERVER['REQUEST_METHOD']) {
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////            
    case 'POST':
        $datos = json_decode(file_get_contents('php://input'));
        if ($datos != NULL) {
            $resultado = Autenticacion::autenticar($datos->cedula, $datos->password);

            if ($resultado['autenticado']) {
                // Autenticación exitosa
                $response = array(
                    'http_code' => 200,
                    'rol' => $resultado['rol']
                );

                $json_response = json_encode($response);
                header('Content-Type: application/json');
                echo $json_response;
            } else {
                // Autenticación fallida
                $response = array(
                    'http_code' => 400
                );

                $json_response = json_encode($response);
                header('Content-Type: application/json');
                echo $json_response;
            }
        }
        break;

    default:
        http_response_code(405);
        break;
}