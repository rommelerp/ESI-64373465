<?php
require_once "../Modelos/viajeModelo.php";

switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        $datos = json_decode(file_get_contents('php://input'));
        if ($datos && isset($datos->iniciarViaje) && isset($datos->idLotes)) {
            if (Viaje::verificarLotesCerrados($datos->idLotes)) {
                if (Viaje::iniciarViajeV1($datos->idLotes)) {
                    http_response_code(200);
                } else {
                    http_response_code(400);
                }

            } else {
                //Hay lotes q no se han cerrado aun
                $error_message = array(
                    'error1' => "error1",
                );
                $response = json_encode($error_message);
                echo $response;
                http_response_code(400);
            }
        } else if ($datos && isset($datos->finalizarViaje) && isset($datos->idLotes)) {
            if (Viaje::verificarLotesEntregados($datos->idLotes)) {
                if (Viaje::finalizarViajeV1($datos->idLotes)) {
                    http_response_code(200);
                } else {
                    http_response_code(400);
                }

            } else {
                //Hay lotes q no se han entregado aun
                $error_message = array(
                    'error1' => "error1",
                );
                $response = json_encode($error_message);
                echo $response;
                http_response_code(400);
            }
        } else if ($datos && isset($datos->iniciarViaje) && isset($datos->idPaquetes)) {
            if (Viaje::iniciarViajeV2($datos->idPaquetes)) {
                http_response_code(200);
            } else {
                http_response_code(400);
            }
        } else if ($datos && isset($datos->finalizarViaje) && isset($datos->idPaquetes)) {
            if (Viaje::verificarPaquetesEntregados($datos->idPaquetes)) {
                if (Viaje::finalizarViajeV2($datos->idPaquetes)) {
                    http_response_code(200);
                } else {
                    http_response_code(400);
                }

            } else {
                //Hay paquetes q no se han entregado aun
                $error_message = array(
                    'error2' => "error2",
                );
                $response = json_encode($error_message);
                echo $response;
                http_response_code(400);
            }
        }
        break;

    default:

        http_response_code(405);
        break;
}
