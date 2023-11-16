<?php
require_once "../../URL/url.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $idPaquete = $_POST['idPaquete'];
    $estadoPaquete = $_POST['estadoPaquete'];
    $propietario = $_POST['propietario'];
    $puertaPaquete = $_POST['puertaPaquete'];
    $callePaquete = $_POST['callePaquete'];
    $ciudadPaquete = $_POST['ciudadPaquete'];

    $api_url = $base_url . 'APIs/apiPaquete.php';


    $data = [

        "idPaquete" => $idPaquete,
        "estadoPaquete" => $estadoPaquete,
        "propietario" => $propietario,
        "puertaPaquete" => $puertaPaquete,
        "callePaquete" => $callePaquete,
        "ciudadPaquete" => $ciudadPaquete
    ];

    // Utilizar cURL para enviar la solicitud POST a la API
    $ch = curl_init($api_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);

    curl_exec($ch);

    // Obtener información sobre la transferencia, incluido el código de respuesta HTTP
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