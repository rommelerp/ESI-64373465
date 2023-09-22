<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Eliminar almacén</title>
</head>

<body>
    <h1>Eliminar almacén</h1>

    <form action="http://localhost/PROGRAMA/Controlador/controlador.php/almacenControlador/eliminarAlmacenControlador/delete" method="POST">

        <b>IdAlmacén:</b> <input type="number" name="idAlmacen" required /> <br />        
        <input type="submit" value="Eliminar" />
    </form>
</body>

</html>