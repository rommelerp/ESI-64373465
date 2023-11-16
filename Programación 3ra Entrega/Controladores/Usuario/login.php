<?php
require_once "../../URL/url.php";

require_once '../../jwt/php-jwt-main/src/JWT.php';
use \Firebase\JWT\JWT;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $cedula = $_POST['usuarioCedula'];
    $password = $_POST['usuarioPassword'];

    $api_url = $base_url . 'APIs/apiAutenticacion.php';

    $data = [
        "cedula" => $cedula,
        "password" => $password
    ];


    // Utiliza cURL para enviar la solicitud POST a la API de autenticacion
    $ch = curl_init($api_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
    $response_data = curl_exec($ch);


    curl_close($ch);

    $response_data = json_decode($response_data, true);
    $http_code = $response_data['http_code'];

    if ($http_code == 200) {

        $rol = $response_data['rol'];

        //El usuario existe en la base de datos
        $jwtKey = "clave_secreta";

        // Define la información que se incluirá en el token
        $payload = [
            "sub" => $cedula,
            // cedula de usuario
            "rol" => $rol,
            // Rol de usuario
            "exp" => time() + 86400,
            // Tiempo de expiración (ejemplo: 1 hora)
        ];

        // Genera el token JWT
        $token = JWT::encode($payload, $jwtKey, 'HS256');

        setcookie("jwtToken", $token, time() + 86400, "/");

        if ($rol == "administrador") {

            echo "<script>
        window.location.href = '{$base_url}Vistas/vistaBackOffice/index/index.php';
    </script>";

        } else if ($rol == "camionero") {
            // Requiere el formulario de login

            // Script JavaScript para solicitar la matrícula
            echo "<script>
    window.location.href = '{$base_url}Vistas/vistaCamionero/index/index.php?cedula=" . urlencode($cedula) . "';
</script>";


        } else if ($rol == "funcionario") {

            echo "<script>
            window.location.href = '{$base_url}Vistas/vistaFuncionario/index/index.php';
        </script>";

        }


    } else {
        // Hubo un problema en la API
        echo "<script>
        window.location.href = '{$base_url}error.html';
    </script>";
    }
}

?>