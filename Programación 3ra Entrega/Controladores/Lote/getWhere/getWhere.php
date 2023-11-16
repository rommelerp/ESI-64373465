<?php
require_once "../../../URL/url.php";

if ($_SERVER["REQUEST_METHOD"] == "GET") {

    $idLote = $_GET["idLote"];
    $nombreArchivo = $_GET["nombreArchivo"];

    $url = $base_url . 'APIs/apiLote.php?idLote=' . urlencode($idLote);

    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    $data = json_decode($response, true);
    
    if ($data) {
        $datosLote = $data;
        global $datosLote;
        require_once "../../../Vistas/vistaBackOffice/lote/$nombreArchivo";
    } else {
        echo "<script>
        window.location.href = '{$base_url}error.html';
    </script>";    }
}
?>