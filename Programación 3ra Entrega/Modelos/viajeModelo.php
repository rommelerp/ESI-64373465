<?php
require_once "../ConexionBD/conexion.php";

class Viaje
{


    //Verfica q todos los lotes esten cerrados 
    public static function verificarLotesCerrados($lotes)
    {
        $db = new Connection();

        // Verificar la conexión
        if ($db->connect_error) {
            die("La conexión a la base de datos ha fallado: " . $db->connect_error);
        }

        // Construir la condición WHERE para los idLote
        $whereCondition = implode(',', array_map('intval', $lotes));

        // Consulta SQL para verificar el estadoLote de los idLote en la tabla lote
        $sql = "SELECT COUNT(*) AS total
                FROM lote
                WHERE idLote IN ($whereCondition) AND estadoLote = 'Cerrado'";

        $result = $db->query($sql);

        if ($result) {
            $row = $result->fetch_assoc();

            // Comparar el número total de registros con el número de lotes
            return $row['total'] == count($lotes);
        } else {
            // Manejar el error si la consulta no fue exitosa
            return false;
        }
    }

    public static function verificarLotesEntregados($lotes)
    {
        $db = new Connection();

        // Verificar la conexión
        if ($db->connect_error) {
            die("La conexión a la base de datos ha fallado: " . $db->connect_error);
        }

        // Construir la condición WHERE para los idLote
        $whereCondition = implode(',', array_map('intval', $lotes));

        // Consulta SQL para verificar el estadoLote de los idLote en la tabla lote
        $sql = "SELECT COUNT(*) AS total
                FROM lote
                WHERE idLote IN ($whereCondition) AND estadoLote = 'Entregado'";

        $result = $db->query($sql);

        if ($result) {
            $row = $result->fetch_assoc();

            // Comparar el número total de registros con el número de lotes
            return $row['total'] == count($lotes);
        } else {
            // Manejar el error si la consulta no fue exitosa
            return false;
        }
    }

    public static function verificarPaquetesEntregados($paquetes)
    {
        $db = new Connection();

        // Verificar la conexión
        if ($db->connect_error) {
            die("La conexión a la base de datos ha fallado: " . $db->connect_error);
        }

        // Construir la condición WHERE para los idPaquete
        $whereCondition = implode(',', array_map('intval', $paquetes));

        // Consulta SQL para verificar el estadoLote de los idPaquete en la tabla lote
        $sql = "SELECT COUNT(*) AS total
                FROM paquete
                WHERE idPaquete IN ($whereCondition) AND estadoPaquete = 'Entregado'";

        $result = $db->query($sql);

        if ($result) {
            $row = $result->fetch_assoc();

            // Comparar el número total de registros con el número de paquetes
            return $row['total'] == count($paquetes);
        } else {
            // Manejar el error si la consulta no fue exitosa
            return false;
        }
    }

    //V1 siginifica vehiculo tipo 1, o sea, los camiones
    public static function iniciarViajeV1($idLotes)
    {
        $db = new Connection();

        // Verificar la conexión
        if ($db->connect_error) {
            die("La conexión a la base de datos ha fallado: " . $db->connect_error);
        }

        // Construir la condición WHERE para los idLote
        $whereCondition = implode(',', array_map('intval', $idLotes));

        // Consulta SQL para actualizar la fechaInicio en la tabla tiene
        $sqlTiene = "UPDATE tiene
                     SET fechaInicio = NOW()
                     WHERE idLote IN ($whereCondition)";

        $resultTiene = $db->query($sqlTiene);

        if ($resultTiene && $db->affected_rows > 0) {
            // Consulta SQL para actualizar el estadoPaquete en la tabla paquete
            $sqlPaquete = "UPDATE paquete
                           SET estadoPaquete = 'En ruta'
                           WHERE idPaquete IN (SELECT idPaquete FROM esparte WHERE idLote IN ($whereCondition))";

            $resultPaquete = $db->query($sqlPaquete);

            if ($resultPaquete && $db->affected_rows > 0) {
                return true; // Al menos un registro fue actualizado
            } else {
                error_log("Ningún registro fue actualizado en la tabla paquete.");
                return false;
            }
        } else {
            error_log("Error en la consulta SQL (tiene): " . $db->error);
            return false;
        }
    }



    public static function finalizarViajeV1($idLotes)
    {
        $db = new Connection();

        // Verificar la conexión
        if ($db->connect_error) {
            die("La conexión a la base de datos ha fallado: " . $db->connect_error);
        }

        // Construir la condición WHERE para los idLote
        $whereCondition = implode(',', array_map('intval', $idLotes));

        // Consulta SQL para obtener la matrícula de los lotes en la tabla tiene
        $sqlMatricula = "SELECT DISTINCT matricula
                     FROM tiene
                     WHERE idLote IN ($whereCondition) LIMIT 1";

        $resultMatricula = $db->query($sqlMatricula);

        if ($resultMatricula) {
            while ($row = $resultMatricula->fetch_assoc()) {
                $matricula = $row['matricula'];

                // Consulta SQL para actualizar el estado del camión
                $sqlUpdate = "UPDATE camion
                          SET estadoCamion = 'Libre'
                          WHERE matricula = '$matricula'";

                $resultUpdate = $db->query($sqlUpdate);

                if (!$resultUpdate) {
                    error_log("Error al actualizar el estado del camión: " . $db->error);
                    return false;
                }

                // Consulta SQL para eliminar la fila de la tabla "conduce"
                $sqlDeleteConduce = "DELETE FROM conduce WHERE matricula = '$matricula'";

                $resultDeleteConduce = $db->query($sqlDeleteConduce);

                if (!$resultDeleteConduce) {
                    error_log("Error al eliminar la fila de la tabla 'conduce': " . $db->error);
                    return false;
                }
            }

            return true; // Todas las operaciones se realizaron con éxito
        } else {
            // Manejar el error si la consulta no fue exitosa
            error_log("Error al obtener la matrícula: " . $db->error);
            return false;
        }
    }







    //V2 siginifica vehiculo tipo 2, o sea, las camionetas
    public static function iniciarViajeV2($paquetes)
    {
        $db = new Connection();

        // Iniciar la transacción
        $db->begin_transaction();

        try {
            // Construir la condición WHERE para los idPaquete
            $whereCondition = implode(',', array_map('intval', $paquetes));

            // Actualizar estadoPaquete en la tabla paquete
            $query = "UPDATE paquete SET estadoPaquete = 'En camino al propietario' WHERE idPaquete IN ($whereCondition)";
            $stmt = $db->prepare($query);

            // Ejecutar la actualización en paquete
            $stmt->execute();

            // Verificar si se afectaron filas en paquete
            if ($stmt->affected_rows > 0) {
                // Confirmar la transacción
                $db->commit();
                $stmt->close();
                return true;
            } else {
                // Si no se afectaron filas, revertir la transacción y devolver false
                throw new Exception("No se actualizaron registros en la tabla paquete.");
            }
        } catch (Exception $e) {
            // Manejar la excepción, revertir la transacción y devolver false
            $db->rollback();
            $stmt->close();
            error_log("Error en la transacción: " . $e->getMessage());
            return false;
        }
    }


    public static function finalizarViajeV2($paquetes)
    {
        $db = new Connection();

        // Verificar la conexión
        if ($db->connect_error) {
            die("La conexión a la base de datos ha fallado: " . $db->connect_error);
        }

        // Construir la condición WHERE para los idPaquete
        $whereConditionPaquetes = implode(',', array_map('intval', $paquetes));

        // Consulta SQL para obtener la matrícula de los paquetes en la tabla lleva
        $sqlMatricula = "SELECT DISTINCT matricula
                     FROM lleva
                     WHERE idPaquete IN ($whereConditionPaquetes) LIMIT 1";

        $resultMatricula = $db->query($sqlMatricula);

        if ($resultMatricula) {
            while ($row = $resultMatricula->fetch_assoc()) {
                $matricula = $row['matricula'];

                // Consulta SQL para actualizar el estado de la camioneta
                $sqlUpdate = "UPDATE camioneta
                          SET estadoCamioneta = 'Libre'
                          WHERE matricula = '$matricula'";

                $resultUpdate = $db->query($sqlUpdate);

                if (!$resultUpdate) {
                    error_log("Error al actualizar el estado de la camioneta: " . $db->error);
                    return false;
                }

                // Consulta SQL para eliminar la fila de la tabla "conduce"
                $sqlDeleteConduce = "DELETE FROM conduce WHERE matricula = '$matricula'";

                $resultDeleteConduce = $db->query($sqlDeleteConduce);

                if (!$resultDeleteConduce) {
                    error_log("Error al eliminar la fila de la tabla 'conduce': " . $db->error);
                    return false;
                }
            }

            return true; // Todas las operaciones se realizaron con éxito
        } else {
            // Manejar el error si la consulta no fue exitosa
            error_log("Error al obtener la matrícula: " . $db->error);
            return false;
        }
    }




}
?>