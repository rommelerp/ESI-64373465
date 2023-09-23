<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Eliminar lote</title>
</head>

<body>
    <h1>Cerrar lote</h1>

    <form action="http://localhost/PROGRAMA/Controlador/controlador.php/loteControlador/cerrarLoteControlador/cerrar" method="POST">

        <b>IdLote:</b> <input type="number" name="idLote" required /> <br />        
        <input type="submit" value="Cerrar" />
    </form>
</body>

</html>