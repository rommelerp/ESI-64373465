<?php
require_once "../Modelos/almacenModelo.php";

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        if (isset($_GET['idAlmacen'])) {
            echo json_encode(Almacen::getWhere($_GET['idAlmacen']));
        } else {
            echo json_encode(Almacen::getAll());
        }
        break;
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////            
    case 'POST':
        $datos = json_decode(file_get_contents('php://input'));
        if ($datos != NULL) {
            if (Almacen::insert($datos->idAlmacen, $datos->puertaAlmacen, $datos->calleAlmacen, $datos->ciudadAlmacen, $datos->telefonoAlmacen)) {
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
            if (Almacen::update($datos->idAlmacen, $datos->puertaAlmacen, $datos->calleAlmacen, $datos->ciudadAlmacen, $datos->telefonoAlmacen, $datosOriginales->idAlmacenOriginal)) {
                http_response_code(200); //Con cambios
            } else {
                http_response_code(400);
            }
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        } else if ($json && isset($json->idAlmacen) && isset($json->idTrayecto)) {
            if (Almacen::existeTrayecto($json->idTrayecto)) {
                if (Almacen::existeAlmacenAsignado($json->idAlmacen)) {
                    if (Almacen::updateTrayecto1($json->idAlmacen, $json->idTrayecto)) {
                        http_response_code(200); //Con cambios
                    } else {
                        http_response_code(400);
                    }
                } else if (Almacen::updateTrayecto($json->idAlmacen, $json->idTrayecto)) {
                    http_response_code(200); //Con cambios
                } else {
                    http_response_code(400);
                }


            } else {
                //No existe el trayecto
                $error_message = array(
                    'error1' => "error1",
                );
                $response = json_encode($error_message);
                echo $response;
                http_response_code(400);

            }
        }
        /*} else if ($json && isset($json->idAlmacen) && isset($json->idTrayecto)) {
            if (Almacen::existeTrayecto($json->idTrayecto)) {
                if (Almacen::existeTrayectoAsignado($json->idTrayecto)) {
                    if (Almacen::updateTrayecto($json->idAlmacen, $json->idTrayecto)) {
                        http_response_code(200); //Con cambios
                    } else {
                        http_response_code(400);
                    }

                } else {
                    //No existe el trayecto
                    http_response_code(400);
                }
            } else {
                //El trayecto no se ha asignado
                http_response_code(400);
            }
        }*/

        break;

    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////            
    case 'DELETE':
        if (isset($_GET['idAlmacen'])) {
            if (Almacen::delete($_GET['idAlmacen'])) {
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