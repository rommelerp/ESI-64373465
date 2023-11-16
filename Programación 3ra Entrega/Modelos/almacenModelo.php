<?php
require_once "../ConexionBD/conexion.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', 'D:\Programas\XAMPP\Installer\htdocs\Programa\error.txt');
class Almacen
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
    public static function getWhere($idAlmacen)
    {
        $db = new Connection();
        $query = "SELECT * FROM `almacen` WHERE `idAlmacen`=?";

        $stmt = $db->prepare($query);

        $stmt->bind_param("s", $idAlmacen);

        if ($stmt->execute()) {
            $resultado = $stmt->get_result();

            $datos = [];
            while ($row = $resultado->fetch_assoc()) {
                $datos[] = [
                    'idAlmacen' => $row['idAlmacen'],
                    'puertaAlmacen' => $row['puertaAlmacen'],
                    'calleAlmacen' => $row['calleAlmacen'],
                    'ciudadAlmacen' => $row['ciudadAlmacen'],
                    'telefonoAlmacen' => $row['telefonoAlmacen']
                ];
            }

            $stmt->close();

            return $datos;
        } else {
            return [];
        }
    }
    //////////////////////////////////////////////////////////////////////////////
    public static function existeTrayecto($idTrayecto)
    {
        $db = new Connection();
        $query = "SELECT * FROM trayecto WHERE idTrayecto=?";

        $stmt = $db->prepare($query);
        $stmt->bind_param("s", $idTrayecto);

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
    public static function existeTrayectoAsignado($idTrayecto)
    {
        $db = new Connection();
        $query = "SELECT * FROM pertenece WHERE idTrayecto=?";

        $stmt = $db->prepare($query);
        $stmt->bind_param("s", $idTrayecto);

        // Ejecuta la consulta
        $stmt->execute();

        // Obtiene el resultado de la consulta
        $result = $stmt->get_result();

        // Verifica si existe al menos una fila
        if ($result->num_rows > 0) {
            $stmt->close();
            return false;
        }

        $stmt->close();
        return true;
    }
    //////////////////////////////////////////////////////////////////////////////
    public static function existeAlmacenAsignado($idAlmacen)
    {
        $db = new Connection();
        $query = "SELECT * FROM almacena WHERE idAlmacen=?";

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
    public static function updateTrayecto1($idAlmacen, $idTrayecto)
    {
        $db = new Connection();
        $db->autocommit(FALSE); // Deshabilitar la confirmación automática
        $db->query("SET foreign_key_checks = 0"); // Deshabilitar las restricciones de clave foránea

        $queryPertenece = "UPDATE pertenece SET idTrayecto=? WHERE idAlmacen=?";
        $queryAlmacena = "UPDATE almacena SET idTrayecto=? WHERE idAlmacen=?";

        $stmtPertenece = $db->prepare($queryPertenece);
        $stmtAlmacena = $db->prepare($queryAlmacena);

        $stmtPertenece->bind_param("ss", $idTrayecto, $idAlmacen);
        $stmtAlmacena->bind_param("ss", $idTrayecto, $idAlmacen);

        // Ejecutar la actualización en pertenece
        if ($stmtPertenece->execute() && $stmtPertenece->affected_rows > 0) {
            // Ejecutar la actualización en almacena
            if ($stmtAlmacena->execute() && $stmtAlmacena->affected_rows > 0) {
                // Confirmar la transacción
                $db->commit();
                $stmtPertenece->close();
                $stmtAlmacena->close();
                $db->autocommit(TRUE); // Habilitar la confirmación automática nuevamente
                $db->query("SET foreign_key_checks = 1"); // Habilitar las restricciones de clave foránea nuevamente
                return true;
            }
        }

        // En caso de error, revertir la transacción
        $db->rollback();
        $stmtPertenece->close();
        $stmtAlmacena->close();
        $db->autocommit(TRUE); // Habilitar la confirmación automática nuevamente
        $db->query("SET foreign_key_checks = 1"); // Habilitar las restricciones de clave foránea nuevamente
        return false;
    }

    //////////////////////////////////////////////////////////////////////////////
    public static function updateTrayecto($idAlmacen, $idTrayecto)
    {
        $db = new Connection();
        $db->query("SET foreign_key_checks = 0"); // Deshabilitar las restricciones de clave foránea

        $query1 = "UPDATE pertenece SET idTrayecto=? WHERE idAlmacen=?";

        $stmt1 = $db->prepare($query1);

        $stmt1->bind_param("ss", $idTrayecto, $idAlmacen);

        // Ejecutar la actualización en lleva
        if ($stmt1->execute()) {
            // Verificar si se afectaron filas en lleva
            if ($stmt1->affected_rows > 0) {
                // Confirmar la transacción
                $db->commit();
                $stmt1->close();
                $db->query("SET foreign_key_checks = 1"); // Habilitar las restricciones de clave foránea nuevamente
                return true;
            }
        }



        // En caso de error, revertir la transacción
        $db->rollback();
        $stmt1->close();
        $db->query("SET foreign_key_checks = 1"); // Habilitar las restricciones de clave foránea nuevamente
        return false;
    }
    //////////////////////////////////////////////////////////////////////////////
    public static function insert($idAlmacen, $puertaAlmacen, $calleAlmacen, $ciudadAlmacen, $telefonoAlmacen)
    {
        $db = new Connection();
        $db->begin_transaction(); // Iniciar la transacción

        $queryAlmacen = "INSERT INTO almacen (idAlmacen, puertaAlmacen, calleAlmacen, ciudadAlmacen, telefonoAlmacen) VALUES (?, ?, ?, ?, ?)";
        $stmtAlmacen = $db->prepare($queryAlmacen);
        $stmtAlmacen->bind_param("sssss", $idAlmacen, $puertaAlmacen, $calleAlmacen, $ciudadAlmacen, $telefonoAlmacen);

        $queryPertenece = "INSERT INTO pertenece (idAlmacen) VALUES (?)";
        $stmtPertenece = $db->prepare($queryPertenece);
        $stmtPertenece->bind_param("s", $idAlmacen);

        // Ejecutar la inserción en la tabla 'almacen'
        if ($stmtAlmacen->execute() && $stmtAlmacen->affected_rows > 0) {
            // Ejecutar la inserción en la tabla 'pertenece'
            if ($stmtPertenece->execute() && $stmtPertenece->affected_rows > 0) {
                $db->commit(); // Confirmar la transacción si ambas inserciones tienen éxito
                $stmtAlmacen->close();
                $stmtPertenece->close();
                return true;
            }
        }

        // En caso de error, revertir la transacción y cerrar los statement
        $db->rollback();
        $stmtAlmacen->close();
        $stmtPertenece->close();
        return false;
    }
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public static function update($idAlmacen, $puertaAlmacen, $calleAlmacen, $ciudadAlmacen, $telefonoAlmacen, $idAlmacenOriginal)
    {
        $db = new Connection();

        $stmtAlmacen = null;
        $stmtTiene = null;
        $stmtPertence = null;
        $stmtAlmacena = null;

        try {
            $db->begin_transaction(); // Iniciar la transacción

            $db->query("SET foreign_key_checks = 0");

            // Actualizar la tabla 'almacen'
            $queryAlmacen = "UPDATE almacen SET idAlmacen=?, puertaAlmacen=?, calleAlmacen=?, ciudadAlmacen=?, telefonoAlmacen=? WHERE idAlmacen=?";
            $stmtAlmacen = $db->prepare($queryAlmacen);
            $stmtAlmacen->bind_param("ssssss", $idAlmacen, $puertaAlmacen, $calleAlmacen, $ciudadAlmacen, $telefonoAlmacen, $idAlmacenOriginal);
            $stmtAlmacen->execute();

            // Actualizar la tabla 'tiene'
            $queryTiene = "UPDATE tiene SET idAlmacen=? WHERE idAlmacen=?";
            $stmtTiene = $db->prepare($queryTiene);
            $stmtTiene->bind_param("ss", $idAlmacen, $idAlmacenOriginal);
            $stmtTiene->execute();

            // Actualizar la tabla 'pertence'
            $queryPertence = "UPDATE pertenece SET idAlmacen=? WHERE idAlmacen=?";
            $stmtPertence = $db->prepare($queryPertence);
            $stmtPertence->bind_param("ss", $idAlmacen, $idAlmacenOriginal);
            $stmtPertence->execute();

            // Actualizar la tabla 'almacena'
            $queryAlmacena = "UPDATE almacena SET idAlmacen=? WHERE idAlmacen=?";
            $stmtAlmacena = $db->prepare($queryAlmacena);
            $stmtAlmacena->bind_param("ss", $idAlmacen, $idAlmacenOriginal);
            $stmtAlmacena->execute();

            $db->query("SET foreign_key_checks = 1");

            $db->commit();

            $stmtTiene->close();
            $stmtPertence->close();
            $stmtAlmacena->close();
            $stmtAlmacen->close();

            return true;
        } catch (Exception $e) {
            $db->rollback();
            error_log("Error en la actualizacion: " . $e->getMessage(), 0);

            if ($stmtTiene !== null) {
                $stmtTiene->close();
            }
            if ($stmtPertence !== null) {
                $stmtPertence->close();
            }
            if ($stmtAlmacena !== null) {
                $stmtAlmacena->close();
            }
            if ($stmtAlmacen !== null) {
                $stmtAlmacen->close();
            }

            $db->query("SET foreign_key_checks = 1");

            return false;
        }
    }
    ///////////////////////////////////////////////////////////////////////////////
    public static function delete($idAlmacen)
    {
        $db = new Connection();

        // Deshabilita temporalmente las restricciones de clave foránea
        $db->query("SET FOREIGN_KEY_CHECKS=0");

        // Comienza la transacción
        $db->begin_transaction();

        // Intenta eliminar la fila en la tabla "almacen"
        $queryAlmacen = "DELETE FROM almacen WHERE idAlmacen=?";
        $stmtAlmacen = $db->prepare($queryAlmacen);
        $stmtAlmacen->bind_param("s", $idAlmacen);

        if ($stmtAlmacen->execute() && $stmtAlmacen->affected_rows > 0) {
            // Ahora intenta eliminar las filas relacionadas en las tablas "tiene", "pertenece" y "almacena"
            $queryTiene = "DELETE FROM tiene WHERE idAlmacen=?";
            $stmtTiene = $db->prepare($queryTiene);
            $stmtTiene->bind_param("s", $idAlmacen);
            $stmtTiene->execute();

            $queryPertenece = "DELETE FROM pertenece WHERE idAlmacen=?";
            $stmtPertenece = $db->prepare($queryPertenece);
            $stmtPertenece->bind_param("s", $idAlmacen);
            $stmtPertenece->execute();

            $queryAlmacena = "DELETE FROM almacena WHERE idAlmacen=?";
            $stmtAlmacena = $db->prepare($queryAlmacena);
            $stmtAlmacena->bind_param("s", $idAlmacen);
            $stmtAlmacena->execute();

            // Habilita nuevamente las restricciones de clave foránea
            $db->query("SET FOREIGN_KEY_CHECKS=1");

            // Commit la transacción si todo ha ido bien
            $db->commit();

            $stmtAlmacen->close();
            $stmtTiene->close();
            $stmtPertenece->close();
            $stmtAlmacena->close();
            $db->close();

            return true;
        } else {
            // Rollback la transacción si ocurre un error al eliminar la fila de "almacen"
            $db->rollback();
            $db->query("SET FOREIGN_KEY_CHECKS=1");
            $stmtAlmacen->close();
            $db->close();
            return false;
        }
    }

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