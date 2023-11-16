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
    <title>Registrar Trayecto</title>
</head>

<body>
    <nav>
        <ul>

            <li><a class="logo">
                    <img src="<?php echo $base_url; ?>Vistas/img/Logo-QC.png" alt="logo">
                    <span class="nav-item">Quick System</span>
            </li></a>

            <li><a href="<?php echo $base_url; ?>Vistas/vistaBackOffice/trayecto/index.php">
                    <i class="fa fa-home"></i>
                    <span class="nav-item">Inicio</span>
                </a></li>

            <li><a href="<?php echo $base_url; ?>Vistas/vistaBackOffice/trayecto/registrar.php">
                    <i class="fa fa-solid fa-box-open"></i>
                    <span class="nav-item">Registrar</span>
                </a></li>

            <li><a href="<?php echo $base_url; ?>Vistas/vistaBackOffice/trayecto/modificar.php">
                    <i class="fa fa-solid fa-pen-to-square"></i>
                    <span class="nav-item">Modificar</span>
                </a></li>


            <li><a href="<?php echo $base_url; ?>Vistas/vistaBackOffice/trayecto/eliminar.php">
                    <i class="fa fa-solid fa-trash"></i>
                    <span class="nav-item">Eliminar</span>
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
            <form action="<?php echo $base_url; ?>Controladores/Trayecto/registrar.php" method="post">
                <div class="all">
                    <h1>Registro</h1>
                    <br>
                    <label>Trayectos</label>
                    <br>
                    <input type="text" placeholder="Id Trayecto" name="idTrayecto" required>
                    <br>
                    <br>
                    <input type="number" placeholder="Duracion" name="duracion" required>
                    <br>
                    <br>
                    <input type="text" placeholder="Rutas" name="rutas" required>
                    <br>
                    <br>
                    <button id="Entrar"><input type="submit" id="Entrar" value="Registrar"></button>
                </div>
            </form>
        </div>
    </center>
</body>

</html>