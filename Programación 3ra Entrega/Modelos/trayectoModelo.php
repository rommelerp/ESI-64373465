<?php
require_once "../ConexionBD/conexion.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', 'D:\Programas\XAMPP\Installer\htdocs\Programa\error.txt');
class Trayecto
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
    public static function getWhere($idTrayecto)
    {
        $db = new Connection();
        $query = "SELECT * FROM `trayecto` WHERE `idTrayecto`=?";

        $stmt = $db->prepare($query);

        $stmt->bind_param("s", $idTrayecto);

        if ($stmt->execute()) {
            $resultado = $stmt->get_result();

            $datos = [];
            while ($row = $resultado->fetch_assoc()) {
                $datos[] = [
                    'idTrayecto' => $row['idTrayecto'],
                    'duracion' => $row['duracion'],
                    'rutas' => $row['rutas']
                ];
            }

            $stmt->close();

            return $datos;
        } else {
            return [];
        }
    }
    //////////////////////////////////////////////////////////////////////////////
   
    //////////////////////////////////////////////////////////////////////////////
    public static function insert($idTrayecto, $duracion, $rutas)
    {
        $db = new Connection();

        $query = "INSERT INTO trayecto (idTrayecto, duracion, rutas) VALUES (?, ?, ?)";

        $stmt = $db->prepare($query);

        $stmt->bind_param("sss", $idTrayecto, $duracion, $rutas);

        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                $stmt->close();
                return true;
            }
        }

        $stmt->close();
        return false;
    }
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public static function update($idTrayecto, $duracion, $rutas, $idTrayectoOriginal)
    {
        $db = new Connection();

        $stmtTrayecto = null;
        $stmtTiene = null;
        $stmtPertence = null;
        $stmtAlmacena = null;

        try {
            $db->begin_transaction(); // Iniciar la transacción

            $db->query("SET foreign_key_checks = 0");

            // Actualizar la tabla 'almacen'
            $queryTrayecto = "UPDATE trayecto SET idTrayecto=?, duracion=?, rutas=? WHERE idTrayecto=?";
            $stmtTrayecto = $db->prepare($queryTrayecto);
            $stmtTrayecto->bind_param("ssss", $idTrayecto, $duracion, $rutas, $idTrayectoOriginal);
            $stmtTrayecto->execute();

            // Actualizar la tabla 'tiene'
            $queryTiene = "UPDATE tiene SET idTrayecto=? WHERE idTrayecto=?";
            $stmtTiene = $db->prepare($queryTiene);
            $stmtTiene->bind_param("ss", $idTrayecto, $idTrayectoOriginal);
            $stmtTiene->execute();

            // Actualizar la tabla 'pertence'
            $queryPertence = "UPDATE pertenece SET idTrayecto=? WHERE idTrayecto=?";
            $stmtPertence = $db->prepare($queryPertence);
            $stmtPertence->bind_param("ss", $idTrayecto, $idTrayectoOriginal);
            $stmtPertence->execute();

            // Actualizar la tabla 'almacena'
            $queryAlmacena = "UPDATE almacena SET idTrayecto=? WHERE idTrayecto=?";
            $stmtAlmacena = $db->prepare($queryAlmacena);
            $stmtAlmacena->bind_param("ss", $idTrayecto, $idTrayectoOriginal);
            $stmtAlmacena->execute();

            $db->query("SET foreign_key_checks = 1");

            $db->commit();

            $stmtTiene->close();
            $stmtPertence->close();
            $stmtAlmacena->close();
            $stmtTrayecto->close();

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
            if ($stmtTrayecto !== null) {
                $stmtTrayecto->close();
            }

            $db->query("SET foreign_key_checks = 1");

            return false;
        }
    }
    ///////////////////////////////////////////////////////////////////////////////
    public static function delete($idTrayecto)
    {
        $db = new Connection();

        // Deshabilita temporalmente las restricciones de clave foránea
        $db->query("SET FOREIGN_KEY_CHECKS=0");

        // Comienza la transacción
        $db->begin_transaction();

        // Intenta eliminar la fila en la tabla "almacen"
        $queryTrayecto = "DELETE FROM trayecto WHERE idTrayecto=?";
        $stmtTrayecto = $db->prepare($queryTrayecto);
        $stmtTrayecto->bind_param("s", $idTrayecto);

        if ($stmtTrayecto->execute() && $stmtTrayecto->affected_rows > 0) {
            // Ahora intenta eliminar las filas relacionadas en las tablas "tiene", "pertenece" y "almacena"
            $queryTiene = "DELETE FROM tiene WHERE idTrayecto=?";
            $stmtTiene = $db->prepare($queryTiene);
            $stmtTiene->bind_param("s", $idTrayecto);
            $stmtTiene->execute();

            $queryPertenece = "DELETE FROM pertenece WHERE idTrayecto=?";
            $stmtPertenece = $db->prepare($queryPertenece);
            $stmtPertenece->bind_param("s", $idTrayecto);
            $stmtPertenece->execute();

            $queryAlmacena = "DELETE FROM almacena WHERE idTrayecto=?";
            $stmtAlmacena = $db->prepare($queryAlmacena);
            $stmtAlmacena->bind_param("s", $idTrayecto);
            $stmtAlmacena->execute();

            // Habilita nuevamente las restricciones de clave foránea
            $db->query("SET FOREIGN_KEY_CHECKS=1");

            // Commit la transacción si todo ha ido bien
            $db->commit();

            $stmtTrayecto->close();
            $stmtTiene->close();
            $stmtPertenece->close();
            $stmtAlmacena->close();
            $db->close();

            return true;
        } else {
            // Rollback la transacción si ocurre un error al eliminar la fila de "almacen"
            $db->rollback();
            $db->query("SET FOREIGN_KEY_CHECKS=1");
            $stmtTrayecto->close();
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