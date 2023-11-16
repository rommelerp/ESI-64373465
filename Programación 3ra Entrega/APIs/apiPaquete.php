<?php
require_once "../Modelos/paqueteModelo.php";

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        if (isset($_GET['idPaquete'])) {
            echo json_encode(Paquete::getWhere($_GET['idPaquete']));
        } else if (isset($_GET['idPaqueteSeguimiento'])) {
            echo json_encode(Paquete::getSeguimiento($_GET['idPaqueteSeguimiento']));
        } else {
            echo json_encode(Paquete::getAll());
        }
        break;
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////            
    case 'POST':
        $datos = json_decode(file_get_contents('php://input'));
        if ($datos != NULL) {
            if (Paquete::insert($datos->idPaquete, $datos->estadoPaquete, $datos->propietario, $datos->puertaPaquete, $datos->callePaquete, $datos->ciudadPaquete)) {
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

            if (Paquete::update($datos->idPaquete, $datos->estadoPaquete, $datos->propietario, $datos->puertaPaquete, $datos->callePaquete, $datos->ciudadPaquete, $datosOriginales->idPaqueteActual)) {
                http_response_code(200); //Con cambios
            } else {
                http_response_code(400); // Error debido a restricciones de clave foránea
            }
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //Asignar almacen a Lote
        } else if ($json && isset($json->idLote) && isset($json->idPaquete)) {
            if (Paquete::paqueteEstado($json->idPaquete)) {
                if (Paquete::loteEstado($json->idLote)) {
                    if (Paquete::existeLote($json->idLote)) {
                        if (Paquete::updateLote($json->idPaquete, $json->idLote)) {
                            http_response_code(200);
                        } else {
                            http_response_code(400);
                        }
                    } else {
                        //No existe el lote
                        $error_message = array(
                            'error1' => "error1",
                        );
                        $response = json_encode($error_message);
                        echo $response;
                        http_response_code(400);
                    }
                } else {
                    $error_message = array(
                        'error3' => "error3",
                    );
                    $response = json_encode($error_message);
                    echo $response;
                    http_response_code(400);
                }
            } else {
                $error_message = array(
                    'error2' => "error2",
                );
                $response = json_encode($error_message);
                echo $response;
                http_response_code(400);
            }
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //Asignar matricula a paquete
        } else if ($json && isset($json->idPaquete) && isset($json->matricula)) {
            if (Paquete::entregado($json->idPaquete)) {
                if (Paquete::existeMatricula($json->matricula)) {
                    if (Paquete::updateMatricula($json->idPaquete, $json->matricula)) {
                        http_response_code(200); //Con cambios
                    } else {
                        http_response_code(400);
                    }

                } else {
                    //No existe la matricula
                    $error_message = array(
                        'error1' => "error1",
                    );
                    $response = json_encode($error_message);
                    echo $response;
                    http_response_code(400);
                }
            } else {
                $error_message = array(
                    'error2' => "error2",
                );
                $response = json_encode($error_message);
                echo $response;
                http_response_code(400);
            }
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            /////Orden entrega
        } else if ($json && isset($json->idPaquete) && isset($json->idOrden)) {
            if (Paquete::asignarOrdenEntrega($json->idPaquete, $json->idOrden)) {
                http_response_code(200); //Con cambios
            } else {
                http_response_code(400); // Error debido a restricciones de clave foránea
            }
            //Entregar paquete
        } else if ($json && isset($json->idPaquete)) {
            if (Paquete::entregar($json->idPaquete)) {
                http_response_code(200); //Con cambios
            } else {
                http_response_code(400); // Error debido a restricciones de clave foránea
            }
        }
        break;

    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////            
    case 'DELETE':
        if (isset($_GET['idPaquete'])) {
            if (Paquete::delete($_GET['idPaquete'])) {
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