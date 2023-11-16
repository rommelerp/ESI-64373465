<?php
require_once "../Modelos/trayectoModelo.php";

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        if (isset($_GET['idTrayecto'])) {
            echo json_encode(Trayecto::getWhere($_GET['idTrayecto']));
        } else {
            echo json_encode(Trayecto::getAll());
        }
        break;
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////            
    case 'POST':
        $datos = json_decode(file_get_contents('php://input'));
        if ($datos != NULL) {
            if (Trayecto::insert($datos->idTrayecto, $datos->duracion, $datos->rutas)) {
                http_response_code(200);
            } else {
                http_response_code(400);
            }
        }
        break;
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    case 'PUT':
        $json = json_decode(file_get_contents('php://input'));
        if ($json && isset($json->data) && isset($json->dataOriginal)) {

            $datos = $json->data;
            $datosOriginales = $json->dataOriginal;
            if (Trayecto::update($datos->idTrayecto, $datos->duracion, $datos->rutas, $datosOriginales->idTrayectoOriginal)) {
                http_response_code(200); //Con cambios
            } else {
                http_response_code(400);
            }
        }
        break;

    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////            
    case 'DELETE':
        if (isset($_GET['idTrayecto'])) {
            if (Trayecto::delete($_GET['idTrayecto'])) {
                http_response_code(200);
            } else {
                http_response_code(400);
            }
        }

        break;

    default:
        http_response_code(405);
        break;
}