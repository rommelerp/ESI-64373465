<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Añadir</title>
</head>

<body>
    <h1>Asignar lote a paquete</h1>

    <form action="http://localhost/PROGRAMA/Controlador/controlador.php/paqueteControlador/asignarLotePaquete/asignar" method="POST">

        <b>IdPaquete:</b> <input type="number" name="idPaquete" required /> <br />        
        <b>IdLote:</b> <input type="text" name="idLote" required /> <br />        
        <input type="submit" value="Asignar"/>
    </form>
</body>

</html>