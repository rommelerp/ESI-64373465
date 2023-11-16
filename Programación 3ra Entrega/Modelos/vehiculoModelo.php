<?php
require_once "../ConexionBD/conexion.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', 'D:\Programas\XAMPP\Installer\htdocs\Programa\error.txt');
class Vehiculo
{
    //////////////////////////////////////////////////////////////////////////
    public static function getAll()
    {
        $db = new Connection();
        $query = "SELECT * FROM `paquete`";

        $stmt = $db->prepare($query);

        if ($stmt->execute()) {
            $resultado = $stmt->get_result();

            if ($resultado->num_rows > 0) {
                $datos = [];
                while ($row = $resultado->fetch_assoc()) {
                    $datos[] = [
                        'idPaquete' => $row['idPaquete'],
                        'idLote' => $row['idLote'],
                        'estadoPaquete' => $row['estadoPaquete'],
                        'propietario' => $row['propietario'],
                        'puertaPaquete' => $row['puertaPaquete'],
                        'callePaquete' => $row['callePaquete'],
                        'ciudadPaquete' => $row['ciudadPaquete']
                    ];
                }

                $stmt->close();

                return $datos;
            } else {
                $stmt->close();
                return [];
            }
        } else {
            return [];
        }
    }

    //////////////////////////////////////////////////////////////////////////
    public static function getWhere($matricula)
    {
        $db = new Connection();

        // Primero, intentamos encontrar la matrícula en la tabla 'camion'.
        $queryCamion = "SELECT * FROM `camion` WHERE `matricula`=?";
        $stmtCamion = $db->prepare($queryCamion);
        $stmtCamion->bind_param("s", $matricula);

        if ($stmtCamion->execute()) {
            $resultadoCamion = $stmtCamion->get_result();

            if ($resultadoCamion->num_rows > 0) {
                // La matrícula se encontró en la tabla 'camion'.
                $rowCamion = $resultadoCamion->fetch_assoc();
                $stmtCamion->close();

                return [
                    'matricula' => $rowCamion['matricula'],
                    'estado' => $rowCamion['estadoCamion'],
                    'tarea' => $rowCamion['tareaCamion'],
                    'tipo' => 'camion'
                ];
            }

            $stmtCamion->close();
        }

        // Si no se encontró en 'camion', intentamos en 'camioneta'.
        $queryCamioneta = "SELECT * FROM `camioneta` WHERE `matricula`=?";
        $stmtCamioneta = $db->prepare($queryCamioneta);
        $stmtCamioneta->bind_param("s", $matricula);

        if ($stmtCamioneta->execute()) {
            $resultadoCamioneta = $stmtCamioneta->get_result();

            if ($resultadoCamioneta->num_rows > 0) {
                // La matrícula se encontró en la tabla 'camioneta'.
                $rowCamioneta = $resultadoCamioneta->fetch_assoc();
                $stmtCamioneta->close();

                return [
                    'matricula' => $rowCamioneta['matricula'],
                    'estado' => $rowCamioneta['estadoCamioneta'],
                    'tarea' => $rowCamioneta['tareaCamioneta'],
                    'tipo' => 'camioneta'
                ];
            }

            $stmtCamioneta->close();
        }

        // Si no se encontró en ninguna tabla, retornamos un arreglo vacío.
        return [];
    }
    //////////////////////////////////////////////////////////////////////////////
    public static function asignarVehiculo($cedula, $matricula)
    {
        $db = new Connection();

        // Inserción en 'conduce' si no existe la matrícula
        $queryInsert = "INSERT INTO conduce (matricula, cedula) VALUES (?, ?)";
        $stmtInsert = $db->prepare($queryInsert);
        $stmtInsert->bind_param("ss", $matricula, $cedula);

        if ($stmtInsert->execute() && $stmtInsert->affected_rows > 0) {
            $stmtInsert->close();

            // Verificar el tipo de matrícula y actualizar los estados correspondientes
            $tipoMatricula = '';

            // Verificar si la matrícula está en la tabla "camion"
            $queryCamion = "SELECT * FROM camion WHERE matricula = ?";
            $stmtCamion = $db->prepare($queryCamion);
            $stmtCamion->bind_param("s", $matricula);
            $stmtCamion->execute();
            $resultCamion = $stmtCamion->get_result();

            // Verificar si la matrícula está en la tabla "camioneta"
            $queryCamioneta = "SELECT * FROM camioneta WHERE matricula = ?";
            $stmtCamioneta = $db->prepare($queryCamioneta);
            $stmtCamioneta->bind_param("s", $matricula);
            $stmtCamioneta->execute();
            $resultCamioneta = $stmtCamioneta->get_result();

            // Cerrar la conexión a la base de datos
            $db->close();

            // Verificar el resultado y asignar el tipo de matrícula
            if ($resultCamion->num_rows > 0) {
                $tipoMatricula = 'camion';
            } elseif ($resultCamioneta->num_rows > 0) {
                $tipoMatricula = 'camioneta';
            }

            // Actualizar estados y tareas según el tipo de vehículo
            if ($tipoMatricula === 'camion') {
                $db = new Connection(); // Abrir una nueva conexión
                $queryUpdateCamion = "UPDATE camion SET estadoCamion = 'Ocupado', tareaCamion = 'En ruta' WHERE matricula = ?";
                $stmtUpdateCamion = $db->prepare($queryUpdateCamion);
                $stmtUpdateCamion->bind_param("s", $matricula);
                $stmtUpdateCamion->execute();
                $stmtUpdateCamion->close();
                $db->close();
            } elseif ($tipoMatricula === 'camioneta') {
                $db = new Connection(); // Abrir una nueva conexión
                $queryUpdateCamioneta = "UPDATE camioneta SET estadoCamioneta = 'Ocupado', tareaCamioneta = 'En ruta' WHERE matricula = ?";
                $stmtUpdateCamioneta = $db->prepare($queryUpdateCamioneta);
                $stmtUpdateCamioneta->bind_param("s", $matricula);
                $stmtUpdateCamioneta->execute();
                $stmtUpdateCamioneta->close();
                $db->close();
            }

            return true;
        }
        return false;
    }


    //////////////////////////////////////////////////////////////////////////////

    /*public static function asignarChofer($cedula, $matricula)
    {
        $db = new Connection();

        // Consulta para verificar si la matrícula ya existe en 'conduce'
        $querySelect = "SELECT * FROM conduce WHERE matricula = ?";
        $stmtSelect = $db->prepare($querySelect);
        $stmtSelect->bind_param("s", $matricula);
        $stmtSelect->execute();
        $result = $stmtSelect->get_result();

        // Si ya existe una fila, realiza una actualización, de lo contrario, una inserción
        if ($result->num_rows > 0) {
            // Actualización en 'conduce' si ya existe la matrícula
            $queryUpdate = "UPDATE conduce SET cedula = ? WHERE matricula = ?";
            $stmtUpdate = $db->prepare($queryUpdate);
            $stmtUpdate->bind_param("ss", $cedula, $matricula);

            if ($stmtUpdate->execute() && $stmtUpdate->affected_rows > 0) {
                $stmtSelect->close();
                $stmtUpdate->close();
                return true;
            }
            $stmtUpdate->close();
        } else {
            // Inserción en 'conduce' si no existe la matrícula
            $queryInsert = "INSERT INTO conduce (matricula, cedula) VALUES (?, ?)";
            $stmtInsert = $db->prepare($queryInsert);
            $stmtInsert->bind_param("ss", $matricula, $cedula);

            if ($stmtInsert->execute() && $stmtInsert->affected_rows > 0) {
                $stmtSelect->close();
                $stmtInsert->close();
                return true;
            }
            $stmtInsert->close();
        }

        $stmtSelect->close();
        return false;
    }*/

    //////////////////////////////////////////////////////////////////
    public static function verificarEstado($matricula)
    {
        $db = new Connection();

        // Verificar si la matrícula está en la tabla "camion"
        $queryCamion = "SELECT estadoCamion FROM camion WHERE matricula = ?";
        $stmtCamion = $db->prepare($queryCamion);
        $stmtCamion->bind_param("s", $matricula);
        $stmtCamion->execute();
        $resultCamion = $stmtCamion->get_result();

        // Verificar si la matrícula está en la tabla "camioneta"
        $queryCamioneta = "SELECT estadoCamioneta FROM camioneta WHERE matricula = ?";
        $stmtCamioneta = $db->prepare($queryCamioneta);
        $stmtCamioneta->bind_param("s", $matricula);
        $stmtCamioneta->execute();
        $resultCamioneta = $stmtCamioneta->get_result();

        // Cerrar la conexión a la base de datos
        $db->close();

        // Verificar el resultado y devolver true o false según el estado
        if ($resultCamion->num_rows > 0) {
            $rowCamion = $resultCamion->fetch_assoc();
            $estadoCamion = $rowCamion['estadoCamion'];

            // Devolver true si el estado es "Libre", false en caso contrario
            return ($estadoCamion == 'Libre');
        } elseif ($resultCamioneta->num_rows > 0) {
            $rowCamioneta = $resultCamioneta->fetch_assoc();
            $estadoCamioneta = $rowCamioneta['estadoCamioneta'];

            // Devolver true si el estado es "Libre", false en caso contrario
            return ($estadoCamioneta == 'Libre');
        }

        // Devolver false si la matrícula no se encuentra en ninguna de las tablas
        return false;
    }
    //////////////////////////////////////////////////////////////////

    public static function existeCedula($cedula)
    {
        $db = new Connection();
        $query = "SELECT * FROM camionero WHERE cedula=?";

        $stmt = $db->prepare($query);
        $stmt->bind_param("s", $cedula);

        // Ejecuta la consulta
        $stmt->execute();

        // Obtiene el resultado de la consulta
        $result = $stmt->get_result();

        // Verifica si existe al menos una fila
        if ($result->num_rows > 0) {
            $stmt->close();
            return true;
        }

        $stmt->close();
        return false;
    }
    ////////////////////////////////////////////////////////////////////
    public static function asignarChofer($cedula, $matricula)
    {
        $db = new Connection();

        // Inserción en 'conduce' si no existe la matrícula
        $queryInsert = "INSERT INTO conduce (matricula, cedula) VALUES (?, ?)";
        $stmtInsert = $db->prepare($queryInsert);
        $stmtInsert->bind_param("ss", $matricula, $cedula);

        if ($stmtInsert->execute() && $stmtInsert->affected_rows > 0) {
            $stmtInsert->close();
            return true;
        }

        return false;
    }
    //////////////////////////////////////////////////////////////////////////////
    public static function insertCamion($matricula, $estadoCamion, $tareaCamion)
    {
        $db = new Connection();

        // Inicia una transacción
        $db->begin_transaction();

        // Inserta la matrícula en la tabla 'vehiculo'
        $queryVehiculo = "INSERT INTO vehiculo (matricula) VALUES (?)";
        $stmtVehiculo = $db->prepare($queryVehiculo);
        $stmtVehiculo->bind_param("s", $matricula);

        // Inserta datos en la tabla 'camion'
        $queryCamion = "INSERT INTO camion (matricula, estadoCamion, tareaCamion) VALUES (?, ?, ?)";
        $stmtCamion = $db->prepare($queryCamion);
        $stmtCamion->bind_param("sss", $matricula, $estadoCamion, $tareaCamion);

        // Ejecuta la inserción en 'vehiculo'
        $insertedInVehiculo = $stmtVehiculo->execute();

        if ($insertedInVehiculo) {
            // Ejecuta la inserción en 'camion' solo si se insertó correctamente en 'vehiculo'
            $insertedInCamion = $stmtCamion->execute();

            if ($insertedInCamion) {
                // Si ambas inserciones fueron exitosas, confirma la transacción
                $db->commit();
                $stmtVehiculo->close();
                $stmtCamion->close();
                return true;
            }
        }

        // Si hubo algún error o no se pudieron insertar todas las filas, realiza un rollback
        $db->rollback();
        $stmtVehiculo->close();
        $stmtCamion->close();
        return false;
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public static function insertCamioneta($matricula, $estadoCamioneta, $tareaCamioneta)
    {
        $db = new Connection();

        // Inicia una transacción
        $db->begin_transaction();

        // Inserta la matrícula en la tabla 'vehiculo'
        $queryVehiculo = "INSERT INTO vehiculo (matricula) VALUES (?)";
        $stmtVehiculo = $db->prepare($queryVehiculo);
        $stmtVehiculo->bind_param("s", $matricula);

        // Inserta datos en la tabla 'camioneta'
        $queryCamioneta = "INSERT INTO camioneta (matricula, estadoCamioneta, tareaCamioneta) VALUES (?, ?, ?)";
        $stmtCamioneta = $db->prepare($queryCamioneta);
        $stmtCamioneta->bind_param("sss", $matricula, $estadoCamioneta, $tareaCamioneta);

        // Ejecuta la inserción en 'vehiculo'
        $insertedInVehiculo = $stmtVehiculo->execute();

        if ($insertedInVehiculo) {
            // Ejecuta la inserción en 'camioneta' solo si se insertó correctamente en 'vehiculo'
            $insertedInCamioneta = $stmtCamioneta->execute();

            if ($insertedInCamioneta) {
                // Si ambas inserciones fueron exitosas, confirma la transacción
                $db->commit();
                $stmtVehiculo->close();
                $stmtCamioneta->close();
                return true;
            }
        }

        // Si hubo algún error o no se pudieron insertar todas las filas, realiza un rollback
        $db->rollback();
        $stmtVehiculo->close();
        $stmtCamioneta->close();
        return false;
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public static function updateCamion($matricula, $estadoCamion, $tareaCamion, $matriculaOriginal)
    {
        $db = new Connection();

        $stmtVehiculo = null;
        $stmtConduce = null;
        $stmtTiene = null;
        $stmtCamion = null;

        try {
            $db->begin_transaction(); // Iniciar la transacción

            // Deshabilitar temporalmente las restricciones de clave foránea
            $db->query("SET FOREIGN_KEY_CHECKS = 0");

            // Actualiza la tabla 'tiene'
            $queryTiene = "UPDATE tiene SET matricula=? WHERE matricula=?";
            $stmtTiene = $db->prepare($queryTiene);
            $stmtTiene->bind_param("ss", $matricula, $matriculaOriginal);
            $stmtTiene->execute();

            // Actualiza la tabla 'camion'
            $queryCamion = "UPDATE camion SET matricula=?, estadoCamion=?, tareaCamion=? WHERE matricula=?";
            $stmtCamion = $db->prepare($queryCamion);
            $stmtCamion->bind_param("ssss", $matricula, $estadoCamion, $tareaCamion, $matriculaOriginal);
            $stmtCamion->execute();

            // Actualiza la tabla 'vehiculo'
            $queryVehiculo = "UPDATE vehiculo SET matricula=? WHERE matricula=?";
            $stmtVehiculo = $db->prepare($queryVehiculo);
            $stmtVehiculo->bind_param("ss", $matricula, $matriculaOriginal);
            $stmtVehiculo->execute();

            // Actualiza la tabla 'conduce'
            $queryConduce = "UPDATE conduce SET matricula=? WHERE matricula=?";
            $stmtConduce = $db->prepare($queryConduce);
            $stmtConduce->bind_param("ss", $matricula, $matriculaOriginal);
            $stmtConduce->execute();

            // Volver a habilitar las restricciones de clave foránea
            $db->query("SET FOREIGN_KEY_CHECKS = 1");

            $db->commit();

            $stmtVehiculo->close();
            $stmtConduce->close();
            $stmtTiene->close();
            $stmtCamion->close();

            return true;

        } catch (Exception $e) {
            $db->rollback();
            error_log("Error en la actualización: " . $e->getMessage(), 0);

            if ($stmtVehiculo !== null) {
                $stmtVehiculo->close();
            }
            if ($stmtConduce !== null) {
                $stmtConduce->close();
            }
            if ($stmtTiene !== null) {
                $stmtTiene->close();
            }
            if ($stmtCamion !== null) {
                $stmtCamion->close();
            }

            // Volver a habilitar las restricciones de clave foránea en caso de error
            $db->query("SET FOREIGN_KEY_CHECKS = 1");

            return false;
        }
    }
    ///////////////////////////////////////////////////////////////////////////////
    public static function updateCamioneta($matricula, $estadoCamioneta, $tareaCamioneta, $matriculaOriginal)
    {
        $db = new Connection();

        $stmtVehiculo = null;
        $stmtConduce = null;
        $stmtLleva = null;
        $stmtCamioneta = null;

        try {
            $db->begin_transaction(); // Iniciar la transacción

            // Deshabilitar temporalmente las restricciones de clave foránea
            $db->query("SET FOREIGN_KEY_CHECKS = 0");

            // Actualiza la tabla 'tiene'
            $queryLleva = "UPDATE lleva SET matricula=? WHERE matricula=?";
            $stmtLleva = $db->prepare($queryLleva);
            $stmtLleva->bind_param("ss", $matricula, $matriculaOriginal);
            $stmtLleva->execute();

            // Actualiza la tabla 'camion'
            $queryCamioneta = "UPDATE camioneta SET matricula=?, estadoCamioneta=?, tareaCamioneta=? WHERE matricula=?";
            $stmtCamioneta = $db->prepare($queryCamioneta);
            $stmtCamioneta->bind_param("ssss", $matricula, $estadoCamioneta, $tareaCamioneta, $matriculaOriginal);
            $stmtCamioneta->execute();

            // Actualiza la tabla 'vehiculo'
            $queryVehiculo = "UPDATE vehiculo SET matricula=? WHERE matricula=?";
            $stmtVehiculo = $db->prepare($queryVehiculo);
            $stmtVehiculo->bind_param("ss", $matricula, $matriculaOriginal);
            $stmtVehiculo->execute();

            // Actualiza la tabla 'conduce'
            $queryConduce = "UPDATE conduce SET matricula=? WHERE matricula=?";
            $stmtConduce = $db->prepare($queryConduce);
            $stmtConduce->bind_param("ss", $matricula, $matriculaOriginal);
            $stmtConduce->execute();

            // Volver a habilitar las restricciones de clave foránea
            $db->query("SET FOREIGN_KEY_CHECKS = 1");

            $db->commit();

            $stmtVehiculo->close();
            $stmtConduce->close();
            $stmtLleva->close();
            $stmtCamioneta->close();

            return true;

        } catch (Exception $e) {
            $db->rollback();
            error_log("Error en la actualización: " . $e->getMessage(), 0);

            if ($stmtVehiculo !== null) {
                $stmtVehiculo->close();
            }
            if ($stmtConduce !== null) {
                $stmtConduce->close();
            }
            if ($stmtLleva !== null) {
                $stmtLleva->close();
            }
            if ($stmtCamioneta !== null) {
                $stmtCamioneta->close();
            }

            // Volver a habilitar las restricciones de clave foránea en caso de error
            $db->query("SET FOREIGN_KEY_CHECKS = 1");

            return false;
        }
    }
    ///////////////////////////////////////////////////////////////////////////////
    public static function deleteCamioneta($matricula)
    {
        $db = new Connection();

        // Inicia una transacción
        $db->begin_transaction();

        // Elimina registros de la tabla 'lleva' donde la matrícula coincide
        $queryLleva = "DELETE FROM lleva WHERE matricula = ?";
        $stmtLleva = $db->prepare($queryLleva);
        $stmtLleva->bind_param("s", $matricula);

        // Elimina registros de la tabla 'conduce' donde la matrícula coincide
        $queryConduce = "DELETE FROM conduce WHERE matricula = ?";
        $stmtConduce = $db->prepare($queryConduce);
        $stmtConduce->bind_param("s", $matricula);

        // Elimina registros de la tabla 'vehiculo' donde la matrícula coincide
        $queryVehiculo = "DELETE FROM vehiculo WHERE matricula = ?";
        $stmtVehiculo = $db->prepare($queryVehiculo);
        $stmtVehiculo->bind_param("s", $matricula);

        // Elimina registros de la tabla 'camioneta' donde la matrícula coincide
        $queryCamioneta = "DELETE FROM camioneta WHERE matricula = ?";
        $stmtCamioneta = $db->prepare($queryCamioneta);
        $stmtCamioneta->bind_param("s", $matricula);

        // Ejecuta las eliminaciones
        $deletedLleva = $stmtLleva->execute();
        $deletedConduce = $stmtConduce->execute();
        $deletedVehiculo = $stmtVehiculo->execute();
        $deletedCamioneta = $stmtCamioneta->execute();

        // Si todas las eliminaciones fueron exitosas, confirma la transacción
        if ($deletedLleva && $deletedConduce && $deletedVehiculo && $deletedCamioneta) {
            $db->commit();
            $stmtLleva->close();
            $stmtConduce->close();
            $stmtVehiculo->close();
            $stmtCamioneta->close();
            return true;
        }

        // Si hubo algún error o no se pudieron eliminar todos los registros, realiza un rollback
        $db->rollback();
        $stmtLleva->close();
        $stmtConduce->close();
        $stmtVehiculo->close();
        $stmtCamioneta->close();
        return false;
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////
    public static function deleteCamion($matricula)
    {
        $db = new Connection();

        // Inicia una transacción
        $db->begin_transaction();

        // Elimina registros de la tabla 'lleva' donde la matrícula coincide
        $queryLleva = "DELETE FROM lleva WHERE matricula = ?";
        $stmtLleva = $db->prepare($queryLleva);
        $stmtLleva->bind_param("s", $matricula);

        // Elimina registros de la tabla 'tiene' donde la matrícula coincide
        $queryTiene = "DELETE FROM tiene WHERE matricula = ?";
        $stmtTiene = $db->prepare($queryTiene);
        $stmtTiene->bind_param("s", $matricula);

        // Elimina registros de la tabla 'conduce' donde la matrícula coincide
        $queryConduce = "DELETE FROM conduce WHERE matricula = ?";
        $stmtConduce = $db->prepare($queryConduce);
        $stmtConduce->bind_param("s", $matricula);

        // Elimina registros de la tabla 'vehiculo' donde la matrícula coincide
        $queryVehiculo = "DELETE FROM vehiculo WHERE matricula = ?";
        $stmtVehiculo = $db->prepare($queryVehiculo);
        $stmtVehiculo->bind_param("s", $matricula);

        // Elimina registros de la tabla 'camion' donde la matrícula coincide
        $queryCamion = "DELETE FROM camion WHERE matricula = ?";
        $stmtCamion = $db->prepare($queryCamion);
        $stmtCamion->bind_param("s", $matricula);

        // Ejecuta las eliminaciones
        $deletedLleva = $stmtLleva->execute();
        $deletedTiene = $stmtTiene->execute();
        $deletedConduce = $stmtConduce->execute();
        $deletedVehiculo = $stmtVehiculo->execute();
        $deletedCamion = $stmtCamion->execute();

        // Si todas las eliminaciones fueron exitosas, confirma la transacción
        if ($deletedLleva && $deletedTiene && $deletedConduce && $deletedVehiculo && $deletedCamion) {
            $db->commit();
            $stmtLleva->close();
            $stmtTiene->close();
            $stmtConduce->close();
            $stmtVehiculo->close();
            $stmtCamion->close();
            return true;
        }

        // Si hubo algún error o no se pudieron eliminar todos los registros, realiza un rollback
        $db->rollback();
        $stmtLleva->close();
        $stmtTiene->close();
        $stmtConduce->close();
        $stmtVehiculo->close();
        $stmtCamion->close();
        return false;
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////
    public static function tieneClaveForanea($idAlmacenOriginal)
    {
        $db = new Connection();

        // Verifica si existen registros relacionados en la tabla secundaria
        $consulta = "SELECT idAlmacen FROM almacena WHERE idAlmacen = ?";

        $stmt = $db->prepare($consulta);
        $stmt->bind_param("s", $idAlmacenOriginal);

        $stmt->execute();


        if ($stmt->get_result()->num_rows > 0) {
            // Hay claves foráneas asociadas
            $stmt->close();
            $db->close();
            return true;
        } else {
            // No hay claves foráneas asociadas
            $stmt->close();
            $db->close();
            return false;
        }
    }

}