<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Eliminar camion</title>
</head>

<body>
    <h1>Eliminar camion</h1>

    <form action="http://localhost/PROGRAMA/Controlador/controlador.php/camionControlador/eliminarCamionControlador/delete" method="POST">

        <b>Matricula:</b> <input type="number" name="matricula" required /> <br />        
        <input type="submit" value="Eliminar" />
    </form>
</body>

</html>