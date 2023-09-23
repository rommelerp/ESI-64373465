<!DOCTYPE html>
<html>

<head>
    <title>Iniciar Sesión</title>
</head>

<body>
    <h1>Iniciar Sesión</h1>
    <form action="http://localhost/PROGRAMA/Controlador/controlador.php/usuarioControlador/loginControlador/login" method="post">

        <b>ID:</b> <input type="number" name="id" required /> <br />
        <b>Nombre:</b> <input type="text" name="nombre" required /> <br />
        <b>Apellido:</b> <input type="text" name="apellido" required /> <br />
        <input type="submit" value="añadir" />

        
    </form>
</body>

</html>