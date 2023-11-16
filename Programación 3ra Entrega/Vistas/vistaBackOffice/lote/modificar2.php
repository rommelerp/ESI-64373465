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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <title>Modificar lote</title>
</head>

<body>
    <nav>
        <ul>

            <li><a class="logo">
                    <img src="<?php echo $base_url; ?>Vistas/img/Logo-QC.png" alt="logo">
                    <span class="nav-item">Quick System</span>
            </li></a>

            <li><a href="<?php echo $base_url; ?>Vistas/vistaBackOffice/lote/index.php">
                    <i class="fa fa-home"></i>
                    <span class="nav-item">Inicio</span>
                </a></li>

            <li><a href="<?php echo $base_url; ?>Vistas/vistaBackOffice/lote/registrar.php">
                    <i class="fa fa-solid fa-box-open"></i>
                    <span class="nav-item">Registrar</span>
                </a></li>

            <li><a href="<?php echo $base_url; ?>Vistas/vistaBackOffice/lote/modificar.php">
                    <i class="fa fa-solid fa-pen-to-square"></i>
                    <span class="nav-item">Modificar</span>
                </a></li>


            <li><a href="<?php echo $base_url; ?>Vistas/vistaBackOffice/lote/eliminar.php">
                    <i class="fa fa-solid fa-trash"></i>
                    <span class="nav-item">Eliminar</span>
                </a></li>

            <li><a href="<?php echo $base_url; ?>Vistas/vistaBackOffice/lote/asignarCamion.php">
                    <i class="fa fa-solid fa-truck-ramp-box"></i>
                    <span class="nav-item">Asignar camion</span>
                </a></li>

            <li><a href="<?php echo $base_url; ?>Vistas/vistaBackOffice/lote/asignarAlmacen.php">
                    <i class="fa fa-solid fa-warehouse"></i>
                    <span class="nav-item">Asignar almacén</span>
                </a></li>

            <li><a href="<?php echo $base_url; ?>Vistas/vistaBackOffice/lote/asignarOrdenEntrega.php">
                    <i class="fa fa-solid fa-arrow-up-1-9"></i>
                    <span class="nav-item">Orden de entrega</span>
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
            <form action="<?php echo $base_url; ?>Controladores/Lote/modificar.php" method="POST">
                <div class="all">
                    <h1> Modificar</h1>
                    <br>
                    <input type="text" placeholder="idLote" name="idLote" value="<?php echo $datosLote[0]['idLote']; ?>"
                        required>
                    <br>
                    <br>
                    <label for="estadoLote">Estado</label>
                    <select name="estadoLote" required>
                        <?php
                        $estadoActual = $datosLote[0]['estadoLote'];
                        $estados = array(
                            "Abierto",
                            "Cerrado",
                            "Entregado"
                        );

                        // Primero, agregamos el estado actual como opción seleccionada
                        echo "<option value='$estadoActual'>$estadoActual</option>";

                        // Luego, recorremos las demás opciones y las agregamos
                        foreach ($estados as $estado) {
                            if ($estado != $estadoActual) {
                                echo "<option value='$estado'>$estado</option>";
                            }
                        }
                        ?>
                    </select>


                    <input type="hidden" name="idLoteActual" value="<?php echo $datosLote[0]['idLote']; ?>" required>

                    <button id="Entrar"><input type="submit" id="Entrar" value="Editar"></button>
                </div>
            </form>
        </div>
    </center>


</body>

</html>