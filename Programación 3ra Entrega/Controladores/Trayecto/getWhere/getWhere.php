<?php
require_once "../../../URL/url.php";

if ($_SERVER["REQUEST_METHOD"] == "GET") {

    $idTrayecto = $_GET["idTrayecto"];

    $url = $base_url . 'APIs/apiTrayecto.php?idTrayecto=' . urlencode($idTrayecto);

    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    $data = json_decode($response, true);

    if ($data) {
        $datosTrayecto = $data;
        global $datosTrayecto;
        require_once "../../../Vistas/vistaBackOffice/Trayecto/modificarTrayecto.php";
    } else {
        echo "<script>
        window.location.href = '{$base_url}error.html';
    </script>";    }
}
?>