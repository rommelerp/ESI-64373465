<?php
require_once "../Modelos/vehiculoModelo.php";

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        if (isset($_GET['matricula'])) {
            echo json_encode(Vehiculo::getWhere($_GET['matricula']));
        } else {
            echo json_encode(Vehiculo::getAll());
        }
        break;
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////            
    case 'POST':
        $datos = json_decode(file_get_contents('php://input'));
        if ($datos && isset($datos->estadoCamioneta)) {
            if (Vehiculo::insertCamioneta($datos->matricula, $datos->estadoCamioneta, $datos->tareaCamioneta)) {
                http_response_code(200);
            } else {
                http_response_code(400);
            }
        } else if ($datos && isset($datos->estadoCamion)) {
            if (Vehiculo::insertCamion($datos->matricula, $datos->estadoCamion, $datos->tareaCamion)) {
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
            if ($json && isset($datos->estadoCamioneta)) {
                if (Vehiculo::updateCamioneta($datos->matricula, $datos->estadoCamioneta, $datos->tareaCamioneta, $datosOriginales->matriculaOriginal)) {
                    http_response_code(200); //Con cambios
                } else {
                    http_response_code(400);
                }
            } else {
                if (Vehiculo::updateCamion($datos->matricula, $datos->estadoCamion, $datos->tareaCamion, $datosOriginales->matriculaOriginal)) {
                    http_response_code(200); //Con cambios
                } else {
                    http_response_code(400);
                }
            }


            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        } else if ($json && isset($json->cedula) && isset($json->matricula)) {
            if (Vehiculo::existeCedula($json->cedula)) {
                if (Vehiculo::verificarEstado($json->matricula)) {
                    if (Vehiculo::asignarVehiculo($json->cedula, $json->matricula)) {
                        http_response_code(200); //Con cambios
                    } else {
                        http_response_code(400);
                    }
                } else {
                    //El vehiculo esta ocupado
                    $error_message = array(
                        'error2' => "error2",
                    );
                    $response = json_encode($error_message);
                    echo $response;
                    http_response_code(400);
                }
            } else {
                //No existe el conductor
                $error_message = array(
                    'error1' => "error1",
                );
                $response = json_encode($error_message);
                echo $response;
                http_response_code(400);
            }
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        } else if ($json && isset($json->cedulaCamionero) && isset($json->matriculaCamion)) {
            if (Vehiculo::existeCedula($json->cedulaCamionero)) {
                if (Vehiculo::asignarCamionero($json->cedulaCamionero, $json->matriculaCamion)) {
                    http_response_code(200); //Con cambios
                } else {
                    http_response_code(400);
                }
            } else {
                //No existe el conductor
                http_response_code(400);

            }
        }

        break;

    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////            
    case 'DELETE':
        if (isset($_GET['matriculaCamion'])) {
            if (Vehiculo::deleteCamion($_GET['matriculaCamion'])) {
                http_response_code(200);
            } else {
                http_response_code(400);
            }
        } else if (isset($_GET['matriculaCamioneta'])) {
            if (Vehiculo::deleteCamioneta($_GET['matriculaCamioneta'])) {
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