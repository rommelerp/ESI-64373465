<?php
require_once "../../../URL/url.php";

if ($_SERVER["REQUEST_METHOD"] == "GET") {

    $matricula = $_GET["matricula"];

    $url = $base_url . 'APIs/apiVehiculo.php?matricula=' . urlencode($matricula);

    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    $data = json_decode($response, true);

    if ($data) {
        $datosVehiculo = $data;
        global $datosVehiculo;
        if ($datosVehiculo['tipo'] == "camion") {
            require_once "../../../Vistas/vistaBackOffice/Vehiculo/modificarCamion.php";
        } else if ($datosVehiculo["tipo"] == "camioneta") {
            require_once "../../../Vistas/vistaBackOffice/Vehiculo/modificarCamioneta.php";
        }

    } else {
        echo "<script>
        window.location.href = '{$base_url}error.html';
    </script>";    }
}
?>