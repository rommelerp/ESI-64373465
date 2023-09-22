<!DOCTYPE html>
<html>
<head>
    <title>Entregar Paquete</title>
</head>
<body>

<form action="http://localhost/PROGRAMA/Controlador/controlador.php/camioneroControlador/entregarPaqueteControlador/entregar" method="post">

<b>IdPaquete:</b> <input type="number" name="idPaquete" required /> <br />
<input type="hidden" name="entrega" value="entregado" required /> <br />
<input type="submit" value="Entregar" />


</form>
</body>
</html>