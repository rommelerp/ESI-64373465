<?php
require_once "../../URL/url.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    //datos modificados
    $matricula = $_POST['matricula'];
    $tareaCamioneta = $_POST['tareaCamioneta'];
    $estadoCamioneta = $_POST['estadoCamioneta'];


    //datos originales
    $matriculaOriginal = $_POST['matriculaOriginal'];


    $dataOriginal = [
        "matriculaOriginal" => $matriculaOriginal
    ];

    $data = [
        "matricula" => $matricula,
        "tareaCamioneta" => $tareaCamioneta,
        "estadoCamioneta" => $estadoCamioneta,
    ];

    $json = array(
        'dataOriginal' => $dataOriginal,
        'data' => $data
    );

    $api_url = $base_url . 'APIs/apiVehiculo.php';

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