<?php
require_once '../../../jwt/php-jwt-main/src/JWT.php';
require_once '../../../jwt/php-jwt-main/src/Key.php';
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

// Verifica si el token JWT existe en las cookies
if (isset($_COOKIE['jwtToken'])) {
    $token = $_COOKIE['jwtToken'];

    try {
        $payload = JWT::decode($token, new Key("clave_secreta", 'HS256'));

        if (isset($payload->rol) && ($payload->rol === 'funcionario' || $payload->rol === 'administrador')) {

        } else {
            echo "<script>
            window.location.href = '{$base_url}error.html';
        </script>";
            echo "No tienes permisos para acceder a esta página.";

        }
    } catch (Exception $e) {
        echo "<script>
            window.location.href = '{$base_url}error.html';
        </script>";
        echo "Token no válido. Debes iniciar sesión.";
    }
} else {
    echo "<script>
            window.location.href = '{$base_url}error.html';
        </script>";
    echo "Debes iniciar sesión para acceder a esta página.";
}
?>