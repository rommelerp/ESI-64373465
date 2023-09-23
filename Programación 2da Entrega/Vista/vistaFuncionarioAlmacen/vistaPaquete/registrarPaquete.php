<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Añadir</title>
  </head>

  <body>
    <h1>Registro de paquete</h1>
    
    <form
      action="http://localhost/PROGRAMA/Controlador/controlador.php/paqueteControlador/registrarPaqueteControlador/register"
      method="POST"
    >
      <b>IdPaquete:</b> <input type="number" name="idPaquete" required /> <br />
      <b>Destino:</b> <input type="text" name="destino" required /> <br />

      <input type="submit" value="añadir" />
    </form>
  </body>
</html>
