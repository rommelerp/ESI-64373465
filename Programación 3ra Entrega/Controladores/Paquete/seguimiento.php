<?php
require_once "../../URL/url.php";
if ($_SERVER["REQUEST_METHOD"] == "GET") {

    $idPaquete = $_GET["idPaquete"];

    $url = $base_url . 'APIs/apiPaquete.php?idPaqueteSeguimiento=' . urlencode($idPaquete);

    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    $data = json_decode($response, true);

    if ($data) {
        $datosSeguimiento = $data;
        global $datosSeguimiento;
        require_once "../../Vistas/vistaSeguimiento/index.php";
    } else {
        echo "<script>
        window.location.href = '<?php echo $base_url; ?>error.html';
    </script>";
    }
}
?>