<?php
require_once "../ConexionBD/conexion.php";

class Autenticacion
{
    public static function autenticar($cedula, $password)
    {
        $query = "SELECT * FROM `login` WHERE cedula = ?";

        $db = new Connection();

        $stmt = $db->prepare($query);
        $stmt->bind_param("s", $cedula); // Cambié "$cédula" a "$cedula"

        // Inicializamos un arreglo para retornar los resultados
        $result = array('rol' => null, 'autenticado' => false);

        // Ejecuta la consulta
        if ($stmt->execute()) {
            $resultado = $stmt->get_result();
            if ($resultado->num_rows === 1) {
                // El usuario con la cédula existe en la base de datos
                $row = $resultado->fetch_assoc();
                // Verifica la contraseña
                if (password_verify($password, $row['password'])) {
                    // Contraseña válida
                    $result['rol'] = $row['rol'];
                    $result['autenticado'] = true;
                }
            }
        }

        // Cerramos la conexión
        $stmt->close();

        // Retornamos el arreglo con los resultados
        return $result;
    }
}
?>