<?php

require_once "../../../Controladores/Token/TKVerifyAdmin.php";
require_once "../../../URL/url.php";

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo $base_url; ?>Vistas/vistaBackOffice/css/Botones.css">
    <link rel="icon" href="<?php echo $base_url; ?>Vistas/img/Logo-QC.png">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Modificar usuario</title>
</head>

<body>

    <nav>
        <ul>

            <li><a class="logo">
                    <img src="<?php echo $base_url; ?>Vistas/img/Logo-QC.png" alt="logo">
                    <span class="nav-item">Quick System</span>
            </li></a>

            <li><a href="<?php echo $base_url; ?>Vistas/vistaBackOffice/usuario/index.php">
                    <i class="fa fa-home"></i>
                    <span class="nav-item">Inicio</span>
                </a></li>

            <li><a href="<?php echo $base_url; ?>Vistas/vistaBackOffice/usuario/Registro.php">
                    <i class="fa fa-solid fa-user-plus"></i>
                    <span class="nav-item">Registra</span>
                </a></li>

            <li><a href="<?php echo $base_url; ?>Vistas/vistaBackOffice/usuario/Elimina.php">
                    <i class="fa fa-solid fa-user-minus"></i>
                    <span class="nav-item">Elimina</span>
                </a></li>

            <li><a href="<?php echo $base_url; ?>Vistas/vistaBackOffice/usuario/Modifica.php">
                    <i class="fa fa-solid fa-user-pen"></i>
                    <span class="nav-item">Modifica</span>
                </a></li>

            <li><a href="<?php echo $base_url; ?>Vistas/vistaBackOffice/usuario/Password.php">
                    <i class="fa fa-solid fa-key"></i>
                    <span class="nav-item">Modifica contraseña</span>
                </a></li>


            <div class="logout">
                <li><a href="<?php echo $base_url; ?>Vistas/vistaBackOffice/index/index.php">
                        <i class="fa fa-solid fa-left-long"></i>
                        <span class="nav-item">Volver</span>
                    </a></li>

                <li><a href="<?php echo $base_url; ?>Vistas/vistaAyuda/Support.html">
                        <i class="fa fa-solid fa-circle-question"></i>
                        <span class="nav-item">Ayuda</span>
                    </a></li>

                    <li><a href="#" id="logoutLink">
                        <i class="fa fa-solid fa-arrow-right-from-bracket"></i>
                        <span class="nav-item">Cerrar sesión</span>
                    </a></li>
                <script>
                    $(document).ready(function () {
                        $("#logoutLink").click(function (e) {
                            e.preventDefault(); // Evita la acción predeterminada del enlace

                            // Envía una solicitud POST al archivo logout.php
                            $.post("<?php echo $base_url; ?>Controladores/Usuario/logout.php", function (data) {
                                // Maneja la respuesta si es necesario
                                window.location.href = '<?php echo $base_url; ?>index.php';
                            });
                        });
                    });
                </script>
            </div>
        </ul>
    </nav>

    <center>
    <div class="formulario">

        <form action="<?php echo $base_url; ?>Controladores/Usuario/getWhere/getWhere.php" method="get">
            <div class="all">
                <h1> Ingrese cedula</h1>
                <input type="number" name="cedula" placeholder="Cedula" required>
                <br>
                <br>
                <input type="submit" value="Entrar" id="Entrar">
            </div>
        </form>
        </div>

    </center>

</body>

</html>