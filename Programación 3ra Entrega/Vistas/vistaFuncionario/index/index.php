<?php

require_once "../../../Controladores/Token/TKVerifyFuncAlmacen.php";
require_once "../../../URL/url.php";

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo $base_url; ?>Vistas/vistaFuncionario/css/Admin.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link rel="icon" href="<?php echo $base_url; ?>Vistas/img/Logo-QC.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Funcionario</title>
</head>

<body>

    <nav>
        <ul>

            <li><a class="logo">
                    <img src="<?php echo $base_url; ?>Vistas/img/Logo-QC.png" alt="logo">
                    <span class="nav-item">Quick System</span>
            </li></a>

            <li><a href="<?php echo $base_url; ?>Vistas/vistaFuncionario/index/index.php">
                    <i class="fa fa-home"></i>
                    <span class="nav-item">Inicio</span>
                </a></li>
            <div class="logout">
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
        <div class="container">
            <a href="<?php echo $base_url; ?>Vistas/vistaFuncionario/Almacen/Almacen.php">
                <div class="button uno">
                    <p>Almacen</p>
                </div>
            </a>
            <a href="<?php echo $base_url; ?>Vistas/vistaFuncionario/lote/index.php">
                <div class="button dos">
                    <p>Lote</p>
                </div>
            </a>
            <a href="<?php echo $base_url; ?>Vistas/vistaFuncionario/paquete/index.php">
                <div class="button tres">
                    <p>Paquete</p>
                </div>
            </a>
            <a href="<?php echo $base_url; ?>Vistas/vistaFuncionario/trayecto/index.php">
                <div class="button cuatro">
                    <p>Trayecto</p>
                </div>
            </a>
            <a href="<?php echo $base_url; ?>Vistas/vistaFuncionario/Vehiculo/vehiculo.php">
                <div class="button cinco">
                    <p>Vehículo</p>
                </div>
            </a>



        </div>
    </center>

</body>

</html>