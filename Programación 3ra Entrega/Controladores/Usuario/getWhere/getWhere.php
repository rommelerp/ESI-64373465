<?php
require_once "../../../URL/url.php";

if ($_SERVER["REQUEST_METHOD"] == "GET") {

    $cedula = $_GET["cedula"];

    $url = $base_url . 'APIs/apiUsuario.php?cedula=' . urlencode($cedula);

    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    $data = json_decode($response, true);

    if ($data) {
        $datosUsuario = $data;

        global $datosUsuario;
        require_once "../../../Vistas/vistaBackOffice/usuario/modifica2.php";
    } else {
        echo "<script>
        window.location.href = '{$base_url}error.html';
    </script>";
    }
}
?>