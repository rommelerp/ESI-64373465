<?php
require_once "../../URL/url.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $idTrayecto = $_POST['idTrayecto'];
    $duracion = $_POST['duracion'];
    $rutas = $_POST['rutas'];

    $api_url = $base_url . 'APIs/apiTrayecto.php';


    $data = [

        "idTrayecto" => $idTrayecto,
        "duracion" => $duracion,
        "rutas" => $rutas

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