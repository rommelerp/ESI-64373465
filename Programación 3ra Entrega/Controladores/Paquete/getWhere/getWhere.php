<?php
require_once "../../../URL/url.php";

if ($_SERVER["REQUEST_METHOD"] == "GET") {

    $idPaquete = $_GET["idPaquete"];
    $nombreArchivo = $_GET["nombreArchivo"];

    $url = $base_url . 'APIs/apiPaquete.php?idPaquete=' . urlencode($idPaquete);

    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    $data = json_decode($response, true);
    
    if ($data) {
        $datosPaquete = $data;
        global $datosPaquete;
        require_once "../../../Vistas/vistaBackOffice/paquete/$nombreArchivo";
    } else {
        echo "<script>
        window.location.href = '{$base_url}error.html';
    </script>";    }
}
?>