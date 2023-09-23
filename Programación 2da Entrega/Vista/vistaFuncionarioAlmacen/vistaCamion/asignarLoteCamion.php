<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Asignar lote a camion</title>
</head>

<body>
    <h1>Asignar lote a camion</h1>

    <form action="http://localhost/PROGRAMA/Controlador/controlador.php/camionControlador/asignarLoteCamion/asignar" method="POST">

        <b>Matricula:</b> <input type="number" name="matricula" required /> <br />        
        <b>Lote:</b> <input type="text" name="idLote" required /> <br />        
        <input type="submit" value="Asignar"/>
    </form>
</body>

</html>