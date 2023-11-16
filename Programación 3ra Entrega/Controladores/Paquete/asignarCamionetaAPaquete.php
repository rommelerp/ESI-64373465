<?php
require_once "../../URL/url.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $idPaquete = $_POST['idPaquete'];
    $matricula = $_POST['matricula'];

    $json = [
        "idPaquete" => $idPaquete,
        "matricula" => $matricula
    ];

    $api_url = $base_url . 'APIs/apiPaquete.php';

    $ch = curl_init($api_url);

    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT'); // Método PUT
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($json));
    curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);

    $response = curl_exec($ch);

    // Obtener información sobre la transferencia, incluido el código de respuesta HTTP
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    curl_close($ch);

    if ($http_code == 200) {
        //Esta todo bien
        echo "<script>
        window.history.back();
    </script>";

    } else {
        $error_response = json_decode($response);
        if (isset($error_response->error1)) {
            echo '<script>alert("No existe ese matricula.");</script>';

            echo "<script>
        window.history.back();
    </script>";
        } else if (isset($error_response->error2)) {
            echo '<script>alert("Quedan paquetes por entregar.");</script>';

            echo "<script>
        window.history.back();
    </script>";
        }
    }
}
?>