<?php
require_once "../../URL/url.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $iniciarViaje = $_POST["iniciarViaje"];


    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////    LOTE     //////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    if ($iniciarViaje == "lote") {


        $idLotes = $_POST["idLotes"];

        $api_url = $base_url . 'APIs/apiViaje.php';

        $data = [
            "iniciarViaje" => $iniciarViaje,
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
                echo '<script>alert("Hay lotes sin cerrar.");</script>';

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



    } else if ($iniciarViaje == "paquete") {
        $idPaquetes = $_POST["idPaquetes"];

        $api_url = $base_url . 'APIs/apiViaje.php';


        $data = [
            "iniciarViaje" => $iniciarViaje,
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
            echo "<script>
            window.location.href = '{$base_url}error.html';
        </script>";
        }
    }
}
?>