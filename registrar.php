<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Añadir</title>
</head>

<body>
  <form action="registrar.php" method="post">

    <input type="hidden" name="accion" value="registrar">
    <b>ID:</b> <input type="number" name="id" required /> <br />
    <b>Nombre:</b> <input type="text" name="nombre" required /> <br />
    <b>Apellido:</b> <input type="text" name="apellido" required /> <br />
    <input type="submit" value="añadir" />
  </form>
</body>

</html>
<?php

if ($_POST) {
  $accion = $_POST['accion'];
  $id = $_POST['id'];
  $nombre = $_POST['nombre'];
  $apellido = $_POST['apellido'];
  $url = 'http://localhost/api.php';

  // Paso los datos a un array asociativo
  $persona = array(
    'accion' => $accion,
    'id' => $id,
    'nombre' => $nombre,
    'apellido' => $apellido
  );



  // Datos a enviar en formato JSON

  $jsonData = json_encode($persona);

  // Inicializar la solicitud cURL
  $ch = curl_init($url);

  // Establecer las opciones para enviar datos JSON
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
  curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
  curl_setopt(
    $ch,
    CURLOPT_HTTPHEADER,
    array(
      'Content-Type: application/json',
      'Content-Length: ' . strlen($jsonData)
    )
  );

  // Ejecutar la solicitud y obtener la respuesta
  $response = curl_exec($ch);

  // Cerrar la conexión cURL
  curl_close($ch);
}
?>
