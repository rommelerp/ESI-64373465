<?php
require_once "../../URL/url.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {




    if (isset($_POST['estadoCamioneta'])) {
        $matricula = $_POST['matricula'];
        $tareaCamioneta = $_POST['tareaCamioneta'];
        $estadoCamioneta = $_POST['estadoCamioneta'];

        $data = [

            "matricula" => $matricula,
            "estadoCamioneta" => $estadoCamioneta,
            "tareaCamioneta" => $tareaCamioneta

        ];


    } else if (isset($_POST['estadoCamion'])) {
        $matricula = $_POST['matricula'];
        $estadoCamion = $_POST['estadoCamion'];
        $tareaCamion = $_POST['tareaCamion'];
        

        $data = [
            "matricula" => $matricula,
            "estadoCamion" => $estadoCamion,
            "tareaCamion" => $tareaCamion
        ];

    }


    $api_url = $base_url . 'APIs/apiVehiculo.php';

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