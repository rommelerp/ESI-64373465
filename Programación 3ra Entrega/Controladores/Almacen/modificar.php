<?php
require_once "../../URL/url.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    //datos modificados
    $idAlmacen = $_POST['idAlmacen'];
    $puertaAlmacen = $_POST['puertaAlmacen'];
    $calleAlmacen = $_POST['calleAlmacen'];
    $ciudadAlmacen = $_POST['ciudadAlmacen'];
    $telefonoAlmacen = $_POST['telefonoAlmacen'];


    //datos originales
    $idAlmacenOriginal = $_POST['idAlmacenOriginal'];

    $dataOriginal = [
        "idAlmacenOriginal" => $idAlmacenOriginal
    ];

    $data = [
        "idAlmacen" => $idAlmacen,
        "puertaAlmacen" => $puertaAlmacen,
        "calleAlmacen" => $calleAlmacen,
        "ciudadAlmacen" => $ciudadAlmacen,
        "telefonoAlmacen" => $telefonoAlmacen,
    ];

    $json = array(
        'dataOriginal' => $dataOriginal,
        'data' => $data
    );

    $api_url = $base_url . "APIs/apiAlmacen.php";

    // Utilizar cURL para enviar la solicitud POST a la API
    $ch = curl_init($api_url);

    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT'); // Método PUT
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($json));
    curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);

    curl_exec($ch);

    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    curl_close($ch);


    if ($http_code == 200) {
        //Esta todo bien
        echo "<script>
        window.history.back();
    </script>";

    } else {
        echo "<script>
        window.location.href = '{$base_url}error.html';
    </script>";
    }
}
?>