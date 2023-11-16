<?php
require_once "../Modelos/usuarioModelo.php";


switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        if (isset($_GET['cedula'])) {
            echo json_encode(Usuario::getWhere($_GET['cedula']));
        } else {
            echo json_encode(Usuario::getAll());
        }
        break;
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////            
    case 'POST':
        $datos = json_decode(file_get_contents('php://input'));
        if ($datos != NULL) {
            if (Usuario::insert($datos->nombre, $datos->apellido, $datos->cedula, $datos->password, $datos->telefono, $datos->rol)) {
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

            if (Usuario::update($datos->cedula, $datos->nombre, $datos->apellido, $datos->rol, $datos->telefono, $datosOriginales->cedulaOriginal)) {
                http_response_code(200); //Con cambios
            } else {
                http_response_code(400); // Error debido a restricciones de clave foránea
            }
        } else if ($json && isset($json->cedula) && isset($json->password)) {
            if (Usuario::updatePassword($json->cedula, $json->password)) {
                http_response_code(200); //Con cambios
            } else {
                http_response_code(400);
            }

        }
        break;

    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////            
    case 'DELETE':
        if (isset($_GET['cedula'])) {
            if (Usuario::delete($_GET['cedula'])) {
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
