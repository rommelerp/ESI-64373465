<?php
require_once "../ConexionBD/conexion.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', 'D:\Programas\XAMPP\Installer\htdocs\Programa\error.txt');
class Lote
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
    public static function getWhere($idLote)
    {
        $db = new Connection();
        $query = "SELECT * FROM `lote` WHERE `idLote`=?";

        $stmt = $db->prepare($query);

        $stmt->bind_param("s", $idLote);

        if ($stmt->execute()) {
            $resultado = $stmt->get_result();

            $datos = [];
            while ($row = $resultado->fetch_assoc()) {
                $datos[] = [
                    'idLote' => $row['idLote'],
                    'estadoLote' => $row['estadoLote']
                ];
            }

            $stmt->close();

            return $datos;
        } else {
            return [];
        }
    }
    //////////////////////////////////////////////////////////////////////////////
    public static function existeAlmacen($idAlmacen)
    {
        $db = new Connection();
        $query = "SELECT * FROM pertenece WHERE idAlmacen=?";

        $stmt = $db->prepare($query);
        $stmt->bind_param("s", $idAlmacen);

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
    ///////////////////////////////////////////////////////////////////////////////////////
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
    //////////////////////////////////////////////////////////////////////////////////////
    public static function tieneTrayectoAsignado($idAlmacen)
    {
        $db = new Connection();
        $query = "SELECT idTrayecto FROM pertenece WHERE idAlmacen=? AND idTrayecto IS NOT NULL";

        $stmt = $db->prepare($query);
        $stmt->bind_param("s", $idAlmacen);

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
    public static function updateAlmacen($idLote, $idAlmacen)
    {
        $db = new Connection();

        // Desactivar restricciones de FK
        $db->query("SET FOREIGN_KEY_CHECKS = 0");

        // Paso 1: Obtener el idTrayecto de la tabla pertenece
        $queryPertenece = "SELECT idTrayecto FROM pertenece WHERE idAlmacen=?";
        $stmtPertenece = $db->prepare($queryPertenece);
        $stmtPertenece->bind_param("s", $idAlmacen);
        $stmtPertenece->execute();
        $stmtPertenece->bind_result($idTrayecto);

        // Paso 2: Verificar si se encontró un idTrayecto
        if ($stmtPertenece->fetch()) {
            $stmtPertenece->close();

            // Paso 3: Actualizar la tabla almacena con los nuevos valores, sin considerar claves foráneas
            $queryUpdateAlmacen = "UPDATE almacena SET idAlmacen=?, idTrayecto=? WHERE idLote=?";
            $stmtUpdateAlmacen = $db->prepare($queryUpdateAlmacen);
            $stmtUpdateAlmacen->bind_param("sss", $idAlmacen, $idTrayecto, $idLote);

            // Paso 4: Ejecutar la actualización
            if ($stmtUpdateAlmacen->execute() && $stmtUpdateAlmacen->affected_rows > 0) {
                $stmtUpdateAlmacen->close();

                // Insertar datos en la tabla "tiene"
                $queryInsertTiene = "INSERT INTO tiene (idTrayecto, idLote, idAlmacen) VALUES (?, ?, ?)";
                $stmtInsertTiene = $db->prepare($queryInsertTiene);
                $stmtInsertTiene->bind_param("sss", $idTrayecto, $idLote, $idAlmacen);
                $stmtInsertTiene->execute();
                $stmtInsertTiene->close();

                // Restablecer restricciones de FK
                $db->query("SET FOREIGN_KEY_CHECKS = 1");

                return true;
            } else {
                $stmtUpdateAlmacen->close();

                // Restablecer restricciones de FK
                $db->query("SET FOREIGN_KEY_CHECKS = 1");
            }
        } else {
            // Restablecer restricciones de FK si no se encontró un idTrayecto
            $db->query("SET FOREIGN_KEY_CHECKS = 1");
        }

        // Paso 5: Si no se encontró un idTrayecto, puedes manejarlo de acuerdo a tus necesidades

        return false; // Puedes ajustar el retorno según tus necesidades
    }

    //////////////////////////////////////////////////////////////////////////////
    public static function updateMatricula($idLote, $matricula)
    {

        $db = new Connection();
        $query = "UPDATE tiene SET matricula=? WHERE idLote=?";

        $stmt = $db->prepare($query);

        $stmt->bind_param("ss", $matricula, $idLote);

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
    public static function asignarOrdenEntrega($idLote, $idOrden)
    {

        $db = new Connection();
        $query = "UPDATE tiene SET ordenEntrega=? WHERE idLote=?";

        $stmt = $db->prepare($query);

        $stmt->bind_param("ss", $idOrden, $idLote);

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
    public static function entregar($idLote)
    {
        $db = new Connection();

        // Actualizar estadoLote en la tabla lote
        $query1 = "UPDATE lote SET estadoLote = 'Entregado' WHERE idLote=?";
        $stmt1 = $db->prepare($query1);
        $stmt1->bind_param("i", $idLote);

        // Iniciar la transacción
        $db->begin_transaction();

        // Ejecutar la actualización en lote
        if (!$stmt1->execute()) {
            // En caso de error, revertir la transacción y devolver false
            $db->rollback();
            $stmt1->close();
            return false;
        }

        $stmt1->close();

        // Actualizar estadoPaquete en la tabla paquete usando esparte
        $query2 = "UPDATE paquete SET estadoPaquete = 'Almacenado' 
               WHERE idPaquete IN (SELECT idPaquete FROM esparte WHERE idLote=?)";
        $stmt2 = $db->prepare($query2);
        $stmt2->bind_param("i", $idLote);

        // Ejecutar la actualización en paquete
        if (!$stmt2->execute()) {
            // En caso de error, revertir la transacción y devolver false
            $db->rollback();
            $stmt2->close();
            return false;
        }

        $stmt2->close();

        // Actualizar fechaEntregado en la tabla almacena
        $query3 = "UPDATE almacena SET fechaEntregado = NOW() WHERE idLote=?";
        $stmt3 = $db->prepare($query3);
        $stmt3->bind_param("i", $idLote);

        // Ejecutar la actualización en almacena
        if (!$stmt3->execute()) {
            // En caso de error, revertir la transacción y devolver false
            $db->rollback();
            $stmt3->close();
            return false;
        }

        $stmt3->close();

        // Actualizar fechaFin en la tabla tiene
        $query4 = "UPDATE tiene SET fechaFin = NOW() WHERE idLote=?";
        $stmt4 = $db->prepare($query4);
        $stmt4->bind_param("i", $idLote);

        // Ejecutar la actualización en tiene
        if (!$stmt4->execute()) {
            // En caso de error, revertir la transacción y devolver false
            $db->rollback();
            $stmt4->close();
            return false;
        }

        // Confirmar la transacción
        $db->commit();
        $stmt4->close();
        return true;
    }


    //////////////////////////////////////////////////////////////////////////////
    public static function insert($idLote, $estadoLote)
    {
        $db = new Connection();

        // Comienza la transacción
        $db->begin_transaction();

        // Inserta en la tabla "lote"
        $queryLote = "INSERT INTO lote (idLote, estadoLote) VALUES (?, ?)";
        $stmtLote = $db->prepare($queryLote);
        $stmtLote->bind_param("ss", $idLote, $estadoLote);

        // Inserta en la tabla "almacena"
        $queryAlmacena = "INSERT INTO almacena (idLote) VALUES (?)";
        $stmtAlmacena = $db->prepare($queryAlmacena);
        $stmtAlmacena->bind_param("s", $idLote);

        $loteInsertSuccess = $stmtLote->execute();
        $almacenaInsertSuccess = $stmtAlmacena->execute();

        if ($loteInsertSuccess && $almacenaInsertSuccess) {
            // Commit la transacción si ambas inserciones fueron exitosas
            $db->commit();
            $stmtLote->close();
            $stmtAlmacena->close();
            $db->close();
            return true;
        } else {
            // Rollback la transacción si ocurre un error en alguna de las inserciones
            $db->rollback();
            $stmtLote->close();
            $stmtAlmacena->close();
            $db->close();
            return false;
        }
    }
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public static function update($idLote, $estadoLote, $idLoteOriginal)
    {
        $db = new Connection();
        $db->begin_transaction(); // Iniciamos la transacción

        // Desactivamos las restricciones de clave foránea
        $db->query("SET FOREIGN_KEY_CHECKS=0");

        $query1 = "UPDATE lote SET idLote=?, estadoLote=? WHERE idLote=?";
        $query2 = "UPDATE tiene SET idLote=? WHERE idLote=?";
        $query3 = "UPDATE esparte SET idLote=? WHERE idLote=?";
        $query4 = "UPDATE almacena SET idLote=? WHERE idLote=?";

        $stmt1 = $db->prepare($query1);
        $stmt2 = $db->prepare($query2);
        $stmt3 = $db->prepare($query3);
        $stmt4 = $db->prepare($query4);

        // Bind parameters for all prepared statements
        $stmt1->bind_param("sss", $idLote, $estadoLote, $idLoteOriginal);
        $stmt2->bind_param("ss", $idLote, $idLoteOriginal);
        $stmt3->bind_param("ss", $idLote, $idLoteOriginal);
        $stmt4->bind_param("ss", $idLote, $idLoteOriginal);

        $success = true;

        if ($stmt1->execute() && $stmt2->execute() && $stmt3->execute() && $stmt4->execute()) {
            if ($stmt1->affected_rows > 0) {
                $stmt1->close();
                $stmt2->close();
                $stmt3->close();
                $stmt4->close();

                // Restauramos las restricciones de clave foránea
                $db->query("SET FOREIGN_KEY_CHECKS=1");

                $db->commit(); // Si todas las operaciones se realizan con éxito, confirmamos la transacción
            } else {
                $success = false;
            }
        } else {
            $success = false;
        }

        if (!$success) {
            // En caso de error, revertimos la transacción y restauramos las restricciones de clave foránea
            $db->query("SET FOREIGN_KEY_CHECKS=1");
            $db->rollback();
        }

        $stmt1->close();
        $stmt2->close();
        $stmt3->close();
        $stmt4->close();

        return $success;
    }
    ///////////////////////////////////////////////////////////////////////////////
    public static function delete($idLote)
    {
        $db = new Connection();

        $stmtEsparte = null;
        $stmtTiene = null;
        $stmtAlmacena = null;
        $stmtLote = null;

        try {
            $db->begin_transaction(); // Iniciar la transacción

            // Deshabilitar restricciones de clave foránea
            $db->query("SET foreign_key_checks = 0");

            // Eliminar registros en la tabla esparte
            $queryEsparte = "DELETE FROM esparte WHERE idLote=?";
            $stmtEsparte = $db->prepare($queryEsparte);
            $stmtEsparte->bind_param("s", $idLote);
            $stmtEsparte->execute();

            // Eliminar registros en la tabla tiene
            $queryTiene = "DELETE FROM tiene WHERE idLote=?";
            $stmtTiene = $db->prepare($queryTiene);
            $stmtTiene->bind_param("s", $idLote);
            $stmtTiene->execute();

            // Eliminar registros en la tabla almacena
            $queryAlmacena = "DELETE FROM almacena WHERE idLote=?";
            $stmtAlmacena = $db->prepare($queryAlmacena);
            $stmtAlmacena->bind_param("s", $idLote);
            $stmtAlmacena->execute();

            // Eliminar registros en la tabla lote
            $queryLote = "DELETE FROM lote WHERE idLote=?";
            $stmtLote = $db->prepare($queryLote);
            $stmtLote->bind_param("s", $idLote);
            $stmtLote->execute();

            // Habilitar restricciones de clave foránea nuevamente
            $db->query("SET foreign_key_checks = 1");

            $db->commit();

            $stmtEsparte->close();
            $stmtTiene->close();
            $stmtAlmacena->close();
            $stmtLote->close();

            return true;
        } catch (Exception $e) {
            $db->rollback();
            error_log("Error en la eliminación: " . $e->getMessage(), 0);

            if ($stmtEsparte !== null) {
                $stmtEsparte->close();
            }
            if ($stmtTiene !== null) {
                $stmtTiene->close();
            }
            if ($stmtAlmacena !== null) {
                $stmtAlmacena->close();
            }
            if ($stmtLote !== null) {
                $stmtLote->close();
            }

            // Asegúrate de habilitar las restricciones de clave foránea en caso de error
            $db->query("SET foreign_key_checks = 1");

            return false;
        }
    }
    public static function tieneClaveForanea($idLoteOriginal)
    {
        $db = new Connection();

        // Verifica si existen registros relacionados en la tabla secundaria (reemplaza con tus nombres de tabla)
        $consulta = "SELECT idLote FROM esparte WHERE idLote = ?";

        $stmt = $db->prepare($consulta);
        $stmt->bind_param("i", $idLoteOriginal);

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