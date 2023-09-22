<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Añadir</title>
  </head>

  <body>
    <h1>Eliminar paquete</h1>

    <form
      action="http://localhost/PROGRAMA/Controlador/controlador.php/paqueteControlador/eliminarPaqueteControlador/delete"
      method="POST"
    >
      <input type="hidden" name="principal" value="almacenControlador" />
      <input type="hidden" name="archivo" value="eliminarPaqueteControlador" />
      <input type="hidden" name="metodo" value="eliminarPaqueteControlador" />
      <input type="hidden" name="clase" value="eliminarPaqueteControlador" />

      <b>IdPaquete:</b> <input type="number" name="id" required /> <br />
      <input type="submit" value="eliminar" />
    </form>
  </body>
</html>
