<?php
require_once "../ConexionBD/conexion.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', 'D:\Programas\XAMPP\Installer\htdocs\Programa\error.txt');
class Paquete
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
    public static function getWhere($idPaquete)
    {
        $db = new Connection();
        $query = "SELECT * FROM `paquete` WHERE `idPaquete`=?";

        $stmt = $db->prepare($query);

        $stmt->bind_param("s", $idPaquete);

        if ($stmt->execute()) {
            $resultado = $stmt->get_result();

            $datos = [];
            while ($row = $resultado->fetch_assoc()) {
                $datos[] = [
                    'idPaquete' => $row['idPaquete'],
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
            return [];
        }
    }
    //////////////////////////////////////////////////////////////////////////////
    public static function getSeguimiento($idPaquete)
    {
        $db = new Connection();
        $query = "SELECT paquete.idPaquete, paquete.estadoPaquete, esparte.idLote, lleva.matricula, conduce.cedula
          FROM `paquete`
          LEFT JOIN `esparte` ON paquete.idPaquete = esparte.idPaquete
          LEFT JOIN `lleva` ON paquete.idPaquete = lleva.idPaquete
          LEFT JOIN `conduce` ON lleva.matricula = conduce.matricula
          WHERE paquete.idPaquete = ?";

        $stmt = $db->prepare($query);

        $stmt->bind_param("s", $idPaquete);

        if ($stmt->execute()) {
            $resultado = $stmt->get_result();

            $datos = [];
            while ($row = $resultado->fetch_assoc()) {
                $datos[] = [
                    'idPaquete' => $row['idPaquete'],
                    'estadoPaquete' => $row['estadoPaquete'],
                    'idLote' => $row['idLote'],
                    'matricula' => $row['matricula'],
                    'cedula' => $row['cedula']
                    /*'duracion' => $row['duracion']*/
                ];

            }

            $stmt->close();

            return $datos;
        } else {
            return [];
        }
    }
    //////////////////////////////////////////////////////////////////////////////
    public static function paqueteEstado($idPaquete)
    {
        $db = new Connection();
        $query = "SELECT * FROM paquete WHERE idPaquete=? AND estadoPaquete = 'En proceso'";

        $stmt = $db->prepare($query);
        $stmt->bind_param("s", $idPaquete);

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
    //////////////////////////////////////////////////////////////////////////////
    public static function loteEstado($idLote)
    {
        $db = new Connection();
        $query = "SELECT * FROM lote WHERE idLote=? AND estadoLote = 'Abierto'";

        $stmt = $db->prepare($query);
        $stmt->bind_param("s", $idLote);

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
    //////////////////////////////////////////////////////////////////////////////
    public static function updateLote($idPaquete, $idLote)
    {

        $db = new Connection();
        $query = "UPDATE esparte SET idLote=? WHERE idPaquete=?";

        $stmt = $db->prepare($query);

        $stmt->bind_param("ss", $idLote, $idPaquete);

        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                $stmt->close();
                return true;
            }
        }

        $stmt->close();
        return false;
    }
    //////////////////////////////////////////////////////////////////////////////
    public static function existeLote($idLote)
    {
        $db = new Connection();
        $query = "SELECT * FROM lote WHERE idLote=?";

        $stmt = $db->prepare($query);
        $stmt->bind_param("s", $idLote);

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

    //////////////////////////////////////////////////////////////////////////////
    public static function updateMatricula($idPaquete, $matricula)
    {
        $db = new Connection();
        $db->autocommit(FALSE); // Deshabilitar la confirmación automática

        $query1 = "UPDATE lleva SET matricula=? WHERE idPaquete=?";

        $stmt1 = $db->prepare($query1);

        $stmt1->bind_param("ss", $matricula, $idPaquete);

        // Ejecutar la actualización en lleva
        if ($stmt1->execute()) {
            // Verificar si se afectaron filas en lleva
            if ($stmt1->affected_rows > 0) {
                // Confirmar la transacción
                $db->commit();
                $stmt1->close();
                $db->autocommit(TRUE); // Habilitar la confirmación automática nuevamente
                return true;
            }
        }



        // En caso de error, revertir la transacción
        $db->rollback();
        $stmt1->close();
        $db->autocommit(TRUE); // Habilitar la confirmación automática nuevamente
        return false;
    }
    //////////////////////////////////////////////////////////////////////////////
    public static function asignarOrdenEntrega($idPaquete, $idOrden)
    {

        $db = new Connection();
        $query = "UPDATE lleva SET ordenEntrega=? WHERE idPaquete=?";

        $stmt = $db->prepare($query);

        $stmt->bind_param("ss", $idOrden, $idPaquete);

        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                $stmt->close();
                return true;
            }
        }

        $stmt->close();
        return false;
    }


    //////////////////////////////////////////////////////////////////////////////
    public static function entregar($idPaquete)
    {
        $db = new Connection();

        // Iniciar la transacción
        $db->begin_transaction();

        // Actualizar estadoPaquete en la tabla paquete
        $query1 = "UPDATE paquete SET estadoPaquete = 'Entregado' WHERE idPaquete=?";
        $stmt1 = $db->prepare($query1);
        $stmt1->bind_param("i", $idPaquete);

        // Ejecutar la actualización en paquete
        if (!$stmt1->execute()) {
            // En caso de error, revertir la transacción y devolver false
            $db->rollback();
            $stmt1->close();
            return false;
        }

        $stmt1->close();

        // Actualizar fechaEntregado en la tabla lleva
        $query2 = "UPDATE lleva SET fechaEntregado = NOW() WHERE idPaquete=?";
        $stmt2 = $db->prepare($query2);
        $stmt2->bind_param("i", $idPaquete);

        // Ejecutar la actualización en lleva
        if (!$stmt2->execute()) {
            // En caso de error, revertir la transacción y devolver false
            $db->rollback();
            $stmt2->close();
            return false;
        }

        // Confirmar la transacción
        $db->commit();
        $stmt2->close();
        return true;
    }

    /////////////////////////////////////////////////////////////////////////////
    public static function entregado($idPaquete)
    {
        $db = new Connection();
        $query = "SELECT * FROM paquete WHERE idPaquete=? AND estadoPaquete = 'Almacenado'";

        $stmt = $db->prepare($query);
        $stmt->bind_param("s", $idPaquete);

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
    //////////////////////////////////////////////////////////////////////////////
    public static function existeMatricula($matricula)
    {
        $db = new Connection();
        $query = "SELECT * FROM vehiculo WHERE matricula=?";

        $stmt = $db->prepare($query);
        $stmt->bind_param("s", $matricula);

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
    //////////////////////////////////////////////////////////////////////////////
    public static function insert($idPaquete, $estadoPaquete, $propietario, $puertaPaquete, $callePaquete, $ciudadPaquete)
    {
        $db = new Connection();

        // Inicia una transacción para asegurar la integridad de los datos
        $db->begin_transaction();

        // Primero, inserta datos en la tabla 'paquete'
        $queryPaquete = "INSERT INTO paquete (idPaquete, estadoPaquete, propietario, puertaPaquete, callePaquete, ciudadPaquete) VALUES (?, ?, ?, ?, ?, ?)";
        $stmtPaquete = $db->prepare($queryPaquete);
        $stmtPaquete->bind_param("ssssss", $idPaquete, $estadoPaquete, $propietario, $puertaPaquete, $callePaquete, $ciudadPaquete);

        // Luego, inserta datos en la tabla 'lleva' vinculando con 'idPaquete' y 'idLote'
        $queryLleva = "INSERT INTO lleva (idPaquete) VALUES (?)";
        $stmtLleva = $db->prepare($queryLleva);
        $stmtLleva->bind_param("s", $idPaquete);

        // Finalmente, inserta datos en la tabla 'esparte' vinculando con 'idPaquete'
        $queryEsParte = "INSERT INTO esparte (idPaquete) VALUES (?)";
        $stmtEsParte = $db->prepare($queryEsParte);
        $stmtEsParte->bind_param("s", $idPaquete);

        // Ejecuta la inserción en 'paquete'
        $insertedInPaquete = $stmtPaquete->execute();

        if ($insertedInPaquete) {
            // Ejecuta la inserción en 'lleva' solo si se insertó correctamente en 'paquete'
            $insertedInLleva = $stmtLleva->execute();

            if ($insertedInLleva) {
                // Ejecuta la inserción en 'esparte' solo si se insertó correctamente en 'lleva'
                $insertedInEsParte = $stmtEsParte->execute();

                if ($insertedInEsParte) {
                    // Si todas las inserciones fueron exitosas, confirma la transacción
                    $db->commit();
                    $stmtPaquete->close();
                    $stmtLleva->close();
                    $stmtEsParte->close();
                    return true;
                }
            }
        }

        // Si hubo algún error o no se pudieron insertar todas las filas, realiza un rollback
        $db->rollback();
        $stmtPaquete->close();
        $stmtLleva->close();
        $stmtEsParte->close();
        return false;
    }
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public static function update($idPaquete, $estadoPaquete, $propietario, $puertaPaquete, $callePaquete, $ciudadPaquete, $idPaqueteActual)
    {
        $db = new Connection();

        $stmtPaquete = null;
        $stmtLleva = null;
        $stmtEsParte = null;

        try {
            $db->begin_transaction(); // Iniciar la transacción

            $db->query("SET foreign_key_checks = 0");

            $queryLleva = "UPDATE lleva SET idPaquete=? WHERE idPaquete=?";
            $stmtLleva = $db->prepare($queryLleva);
            $stmtLleva->bind_param("ss", $idPaquete, $idPaqueteActual);
            $stmtLleva->execute();

            $queryEsParte = "UPDATE esparte SET idPaquete=? WHERE idPaquete=?";
            $stmtEsParte = $db->prepare($queryEsParte);
            $stmtEsParte->bind_param("ss", $idPaquete, $idPaqueteActual);
            $stmtEsParte->execute();

            $queryPaquete = "UPDATE paquete SET idPaquete=?, estadoPaquete=?, propietario=?, puertaPaquete=?, callePaquete=?, ciudadPaquete=? WHERE idPaquete=?";
            $stmtPaquete = $db->prepare($queryPaquete);
            $stmtPaquete->bind_param("sssssss", $idPaquete, $estadoPaquete, $propietario, $puertaPaquete, $callePaquete, $ciudadPaquete, $idPaqueteActual);
            $stmtPaquete->execute();



            $db->query("SET foreign_key_checks = 1");


            $db->commit();

            $stmtLleva->close();
            $stmtEsParte->close();
            $stmtPaquete->close();

            return true;

        } catch (Exception $e) {
            $db->rollback();

            if ($stmtPaquete !== null) {
                $stmtPaquete->close();
            }
            if ($stmtLleva !== null) {
                $stmtLleva->close();
            }
            if ($stmtEsParte !== null) {
                $stmtEsParte->close();
            }

            $db->query("SET foreign_key_checks = 1");


            return false;
        }
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////////
    public static function delete($idPaquete)
    {
        $db = new Connection();

        $stmtPaquete = null;
        $stmtLleva = null;
        $stmtEsParte = null;

        try {
            $db->begin_transaction(); // Iniciar la transacción

            $db->query("SET foreign_key_checks = 0");

            // Eliminar el registro de la tabla lleva
            $queryLleva = "DELETE FROM lleva WHERE idPaquete=?";
            $stmtLleva = $db->prepare($queryLleva);
            $stmtLleva->bind_param("s", $idPaquete);
            $stmtLleva->execute();

            // Eliminar el registro de la tabla esParte
            $queryEsParte = "DELETE FROM esparte WHERE idPaquete=?";
            $stmtEsParte = $db->prepare($queryEsParte);
            $stmtEsParte->bind_param("s", $idPaquete);
            $stmtEsParte->execute();

            // Eliminar el registro de la tabla paquete
            $queryPaquete = "DELETE FROM paquete WHERE idPaquete=?";
            $stmtPaquete = $db->prepare($queryPaquete);
            $stmtPaquete->bind_param("s", $idPaquete);
            $stmtPaquete->execute();

            $db->query("SET foreign_key_checks = 1");

            $db->commit();

            $stmtLleva->close();
            $stmtEsParte->close();
            $stmtPaquete->close();

            return true;
        } catch (Exception $e) {
            $db->rollback();
            error_log("Error en la eliminación: " . $e->getMessage(), 0);

            if ($stmtPaquete !== null) {
                $stmtPaquete->close();
            }
            if ($stmtLleva !== null) {
                $stmtLleva->close();
            }
            if ($stmtEsParte !== null) {
                $stmtEsParte->close();
            }

            $db->query("SET foreign_key_checks = 1");


            return false;
        }
    }

    ///////////////////////////////////////////////////////////////////////////////


}