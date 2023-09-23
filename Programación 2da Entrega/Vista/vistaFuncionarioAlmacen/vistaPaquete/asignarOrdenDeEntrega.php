<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Orden de entrega</title>
</head>

<body>
    <h1>Asignar orden de entrega</h1>

    <form action="http://localhost/PROGRAMA/Controlador/controlador.php/paqueteControlador/asignarordenDeEntrega/asignar" method="POST">

        <b>IdPaquete:</b> <input type="number" name="idPaquete" required /> <br />        
        <b>Orden de Entrega:</b> <input type="text" name="ordenDeEntrega" required /> <br />        
        <input type="submit" value="Asignar"/>
    </form>
</body>

</html>