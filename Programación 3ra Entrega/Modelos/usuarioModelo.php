<?php
require_once "../ConexionBD/conexion.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', 'C:\xampp\htdocs\Programa\error.txt');
class Usuario
{
    //////////////////////////////////////////////////////////////////////////
    public static function getAll()
    {
        $db = new Connection();
        $query = "SELECT * FROM `usuario`";

        $stmt = $db->prepare($query);

        if ($stmt->execute()) {
            $resultado = $stmt->get_result();

            if ($resultado->num_rows > 0) {
                $datos = [];
                while ($row = $resultado->fetch_assoc()) {
                    $datos[] = [
                        'nombre' => $row['nombre'],
                        'apellido' => $row['apellido'],
                        'email' => $row['email'],
                        'telefono' => $row['telefono'],
                        'rol' => $row['rol'],
                        'id' => $row['id']
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
    public static function getWhere($cedula)
    {
        $db = new Connection();
        $query = "SELECT * FROM `login` WHERE `cedula`=?";

        $stmt = $db->prepare($query);

        $stmt->bind_param("s", $cedula);

        if ($stmt->execute()) {
            $resultado = $stmt->get_result();

            $datos = [];
            while ($row = $resultado->fetch_assoc()) {
                $datos[] = [
                    'nombre' => $row['nombre'],
                    'cedula' => $row['cedula'],
                    'apellido' => $row['apellido'],
                    'telefono' => $row['telefono'],
                    'rol' => $row['rol']
                ];
            }

            $stmt->close();

            return $datos;
        } else {
            return [];
        }
    }
    //////////////////////////////////////////////////////////////////////////////
    public static function insert($nombre, $apellido, $cedula, $password, $telefono, $rol)
    {
        $db = new Connection();

        $hash = password_hash($password, PASSWORD_BCRYPT);

        $query = "INSERT INTO login (nombre, apellido, cedula, password, telefono, rol) VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = $db->prepare($query);

        $stmt->bind_param("ssssss", $nombre, $apellido, $cedula, $hash, $telefono, $rol);

        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                if ($rol == "camionero") {
                    // Insertar datos en la tabla "camionero" cuando el rol sea "camionero"
                    $queryCamionero = "INSERT INTO camionero (nombre, apellido, cedula, telefono) VALUES (?, ?, ?, ?)";
                    $stmtCamionero = $db->prepare($queryCamionero);
                    $stmtCamionero->bind_param("ssss", $nombre, $apellido, $cedula, $telefono);

                    if ($stmtCamionero->execute() && $stmtCamionero->affected_rows > 0) {
                        $stmtCamionero->close();
                    } else {
                        // Manejo de errores si no se pudo insertar en la tabla "camionero"
                    }
                }

                $stmt->close();
                return true;
            }
        }

        $stmt->close();
        return false;
    }
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public static function update($cedula, $nombre, $apellido, $rol, $telefono, $cedulaOriginal)
    {
        $db = new Connection();

        // Incluir una estructura try-catch para manejar excepciones
        try {
            // Comenzar una transacción
            $db->begin_transaction();

            $query = "UPDATE login SET nombre=?, apellido=?, cedula=?, telefono=?, rol=? WHERE cedula=?";
            $stmt = $db->prepare($query);

            $stmt->bind_param("ssssss", $nombre, $apellido, $cedula, $telefono, $rol, $cedulaOriginal);

            if ($stmt->execute()) {
                if ($stmt->affected_rows > 0) {
                    $stmt->close();

                    // Confirmar la transacción si la actualización fue exitosa
                    $db->commit();
                    return true;
                }
            }

            // Si la actualización no afectó ninguna fila, entonces revierte la transacción
            $db->rollback();
            $stmt->close();
            return false;
        } catch (Exception $e) {
            // En caso de excepción, revierte la transacción y registra un error
            $db->rollback();
            error_log("Error en la actualización: " . $e->getMessage(), 0);
            return false;
        }
    }
    ///////////////////////////////////////////////////////////////////////////////
    public static function updatePassword($cedula, $password)
    {
        $db = new Connection();

        $hash = password_hash($password, PASSWORD_BCRYPT);
        // Incluir una estructura try-catch para manejar excepciones
        try {
            // Comenzar una transacción
            $db->begin_transaction();

            $query = "UPDATE login SET password=? WHERE cedula=?";
            $stmt = $db->prepare($query);

            $stmt->bind_param("ss", $hash, $cedula);

            if ($stmt->execute()) {
                if ($stmt->affected_rows > 0) {
                    $stmt->close();

                    // Confirmar la transacción si la actualización fue exitosa
                    $db->commit();
                    return true;
                }
            }

            // Si la actualización no afectó ninguna fila, entonces revierte la transacción
            $db->rollback();
            $stmt->close();
            return false;
        } catch (Exception $e) {
            // En caso de excepción, revierte la transacción y registra un error
            $db->rollback();
            error_log("Error en la actualización: " . $e->getMessage(), 0);
            return false;
        }
    }
    ///////////////////////////////////////////////////////////////////////////////
    public static function delete($cedula)
    {
        $db = new Connection();
        $query = "DELETE FROM login WHERE cedula=?";

        $stmt = $db->prepare($query);

        $stmt->bind_param("i", $cedula);

        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                $stmt->close();
                return true;
            }
        }

        $stmt->close();
        return false;
    }
}
