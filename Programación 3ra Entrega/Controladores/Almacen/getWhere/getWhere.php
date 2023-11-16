<?php
require_once "../../../URL/url.php";

if ($_SERVER["REQUEST_METHOD"] == "GET") {

    $idAlmacen = $_GET["idAlmacen"];

    $url = $base_url . 'APIs/apiAlmacen.php?idAlmacen=' . urlencode($idAlmacen);

    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    $data = json_decode($response, true);

    if ($data) {
        $datosAlmacen = $data;
        global $datosAlmacen;
        require_once "../../../Vistas/vistaBackOffice/Almacen/modificarAlmacen.php";
    } else {
        echo "<script>
        window.location.href = '{$base_url}error.html';
    </script>";    }
}
?>