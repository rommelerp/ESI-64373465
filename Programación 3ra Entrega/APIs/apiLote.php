<?php
require_once "../Modelos/loteModelo.php";

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        if (isset($_GET['idLote'])) {
            echo json_encode(Lote::getWhere($_GET['idLote']));
        } else {
            echo json_encode(Lote::getAll());
        }
        break;
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////            
    case 'POST':
        $datos = json_decode(file_get_contents('php://input'));
        if ($datos != NULL) {
            if (Lote::insert($datos->idLote, $datos->estadoLote)) {
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

            if (Lote::update($datos->idLote, $datos->estadoLote, $datosOriginales->idLoteActual)) {
                http_response_code(200); //Con cambios                
            } else {
                http_response_code(400);
            }

            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        } else if ($json && isset($json->idLote) && isset($json->idAlmacen)) {
            if (Lote::existeAlmacen($json->idAlmacen)) {
                if (Lote::tieneTrayectoAsignado($json->idAlmacen)) {
                    if (Lote::updateAlmacen($json->idLote, $json->idAlmacen)) {
                        http_response_code(200);
                    } else {
                        http_response_code(400);
                    }
                } else {
                    //No tiene trayecto asignado
                    $error_message = array(
                        'error2' => "error2",
                    );
                    $response = json_encode($error_message);
                    echo $response;
                    http_response_code(400);
                }
            } else {
                //No existe el almacen
                $error_message = array(
                    'error1' => "error1",
                );
                $response = json_encode($error_message);
                echo $response;
                http_response_code(400);
            }
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        } else if ($json && isset($json->idLote) && isset($json->matricula)) {
            if (Lote::existeMatricula($json->matricula)) {
                if (Lote::updateMatricula($json->idLote, $json->matricula)) {
                    http_response_code(200); //Con cambios
                } else {
                    http_response_code(400);
                }
            } else {
                $error_message = array(
                    'error1' => "error1",
                );
                $response = json_encode($error_message);
                echo $response;
                http_response_code(400);
            }
            ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        } else if ($json && isset($json->idLote) && isset($json->idOrden)) {
            if (Lote::asignarOrdenEntrega($json->idLote, $json->idOrden)) {
                http_response_code(200); //Con cambios
            } else {
                http_response_code(400);
            }

            ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        } else if ($json && isset($json->idLote)) {
            if (Lote::entregar($json->idLote)) {
                http_response_code(200); //Con cambios
            } else {
                http_response_code(400); // Error debido a restricciones de clave foránea
            }
        }

        break;

    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////            
    case 'DELETE':
        if (isset($_GET['idLote'])) {
            if (Lote::delete($_GET['idLote'])) {
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