<?php
require_once "../../URL/url.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $finalizarViaje = $_POST["finalizarViaje"];



    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////    LOTE     //////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    if ($finalizarViaje == "lote") {

        $idLotes = $_POST["idLotes"];

        $api_url = $base_url . 'APIs/apiViaje.php';

        $data = [
            "finalizarViaje" => $finalizarViaje,
            "idLotes" => $idLotes
        ];

        // Utilizar cURL para enviar la solicitud POST a la API
        $ch = curl_init($api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
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
                echo '<script>alert("Hay lotes sin entregar.");</script>';

                echo "<script>
        window.history.back();
    </script>";
            }
        }

        /////////////////////////////////////////////////////////////////////////////////////////////////////////
        /////////////////////////////////////////////////////////////////////////////////////////////////////////
        //////////////////////////////////    PAQUETE     ///////////////////////////////////////////////////////
        /////////////////////////////////////////////////////////////////////////////////////////////////////////
        /////////////////////////////////////////////////////////////////////////////////////////////////////////
    } else if ($finalizarViaje == "paquete") {

        $idPaquetes = $_POST["idPaquetes"];

        $api_url = $base_url . 'APIs/apiViaje.php';

        $data = [
            "finalizarViaje" => $finalizarViaje,
            "idPaquetes" => $idPaquetes
        ];

        // Utilizar cURL para enviar la solicitud POST a la API
        $ch = curl_init($api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
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
            if (isset($error_response->error2)) {
                echo '<script>alert("Hay paquetes sin entregar.");</script>';

                echo "<script>
        window.history.back();
    </script>";
            }
        }
    }
}
?>