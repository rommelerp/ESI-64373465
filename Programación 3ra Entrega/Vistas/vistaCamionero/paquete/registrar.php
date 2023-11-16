<?php

require_once "../../../Controladores/Token/TKVerifyCamionero.php";
require_once "../../../URL/url.php";

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/Botones.css">
    <link rel="icon" href="../../img/Logo-QC.png">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Registrar Paquete</title>
</head>

<body>
    <nav>

        <ul>

            <li><a class="logo">
                    <img src="<?php echo $base_url; ?>Vistas/img/Logo-QC.png" alt="logo">
                    <span class="nav-item">Quick System</span>
            </li></a>

            <li><a href="<?php echo $base_url; ?>Vistas/vistaCamionero/index/index.php">
                    <i class="fa fa-home"></i>
                    <span class="nav-item">Inicio</span>
                </a></li>

            <li><a href="<?php echo $base_url; ?>Vistas/vistaCamionero/paquete/registrar.php">
                    <i class="fa fa-solid fa-box-open"></i>
                    <span class="nav-item">Registrar paquete</span>
                </a></li>

            <li><a href="<?php echo $base_url; ?>Vistas/vistaCamionero/Almacen/Almacen.php">
                    <i class="fa fa-solid fa-warehouse"></i>
                    <span class="nav-item">Almacén</span>
                </a></li>


            <li><a href="<?php echo $base_url; ?>Vistas/vistaCamionero/trayecto/index.php">
                    <i class="fa fa-solid fa-map-location-dot"></i>
                    <span class="nav-item">Trayecto</span>
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
            </div>
        </ul>

    </nav>
    <center>
        <div class="formulario">

            <form action="<?php echo $base_url; ?>Controladores/Paquete/registrar.php" method="post">
                <div class="all">
                    <h1>Registro</h1>
                    <br>
                    <input type="text" placeholder="idPaquete" name="idPaquete" required>
                    <br>
                    <br>
                    <label for="estadoPaquete">Estado</label>
                    <select name="estadoPaquete">
                        <option value="En Proceso">En proceso</option>
                        <option value="En ruta">En ruta</option>
                        <option value="En camino al propietario">En camino al propietario</option>
                        <option value="Entregado">Entregado</option>
                        <option value="Almacenado">Almacenado</option>

                    </select>
                    <br>
                    <br>
                    <input type="text" placeholder="propietario" name="propietario" required>
                    <br>
                    <br>
                    <input type="text" placeholder="puertaPaquete" name="puertaPaquete" required>
                    <br>
                    <br>
                    <input type="text" placeholder="callePaquete" name="callePaquete" required>
                    <br>
                    <br>
                    <input type="text" placeholder="ciudadPaquete" name="ciudadPaquete" required>
                    <br>
                    <br>
                    <button id="Entrar"><input type="submit" id="Entrar" value="Registrar"></button>
                </div>
            </form>
        </div>

    </center>
</body>

</html>