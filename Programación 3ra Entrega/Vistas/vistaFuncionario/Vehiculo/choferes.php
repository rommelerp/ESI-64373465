<?php

require_once "../../../Controladores/Token/TKVerifyFuncAlmacen.php";
require_once "../../../URL/url.php";

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo $base_url; ?>Vistas/vistaFuncionario/css/Vehiculo.css">
    <link rel="icon" href="<?php echo $base_url; ?>Vistas/img/Logo-QC.png">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Vehiculos</title>
</head>

<body>
    <nav>
        <ul>

            <li><a class="logo">
                    <img src="<?php echo $base_url; ?>Vistas/img/Logo-QC.png" alt="logo">
                    <span class="nav-item">Quick System</span>
            </li></a>

            <li><a href="<?php echo $base_url; ?>Vistas/vistaFuncionario/Vehiculo/vehiculo.php">
                    <i class="fa fa-home"></i>
                    <span class="nav-item">Inicio</span>
                </a></li>

            <li><a href="<?php echo $base_url; ?>Vistas/vistaFuncionario/Vehiculo/registrar.php">
                    <i class="fa fa-solid fa-box-open"></i>
                    <span class="nav-item">Registrar</span>
                </a></li>

            <li><a href="<?php echo $base_url; ?>Vistas/vistaFuncionario/Vehiculo/modificar.php">
                    <i class="fa fa-solid fa-pen-to-square"></i>
                    <span class="nav-item">Modificar</span>
                </a></li>


            <li><a href="<?php echo $base_url; ?>Vistas/vistaFuncionario/Vehiculo/eliminar.php">
                    <i class="fa fa-solid fa-trash"></i>
                    <span class="nav-item">Eliminar</span>
                </a></li>

            <li><a href="<?php echo $base_url; ?>Vistas/vistaFuncionario/Vehiculo/asignarVehiculo.php">
                    <i class="fa fa-solid fa-truck-ramp-box"></i>
                    <span class="nav-item">Asignar chofer</span>
                </a></li>

            <li><a href="<?php echo $base_url; ?>Vistas/vistaFuncionario/Vehiculo/choferesAsignados.php">
                    <i class="fa fa-solid fa-id-card"></i>
                    <span class="nav-item">Choferes asignados</span>
                </a></li>

            <li><a href="<?php echo $base_url; ?>Vistas/vistaFuncionario/Vehiculo/choferes.php">
                    <i class="fa fa-solid fa-users"></i>
                    <span class="nav-item">Choferes</span>
                </a></li>

            <div class="logout">
                <li><a href="<?php echo $base_url; ?>Vistas/vistaFuncionario/index/index.php">
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

        <?php
        require_once "../../../ConexionBD/conexion.php";
        $db = new Connection();

        // Verificar la conexión
        if ($db->connect_error) {
            die("La conexión a la base de datos ha fallado: " . $db->connect_error);
        }

        $itemsPerPage = 15; // Número de filas por página
        $currentPage = isset($_GET['page']) ? (int) $_GET['page'] : 1; // Página actual
        
        // Consulta SQL para contar el número total de registros en la tabla "camionero"
        $countSql = "SELECT COUNT(*) AS total FROM camionero";
        $countResult = $db->query($countSql);
        $totalRows = $countResult->fetch_assoc()['total'];

        // Calcular el offset
        $offset = ($currentPage - 1) * $itemsPerPage;

        // Consulta SQL para obtener los datos de la tabla "camionero"
        $sqlCamionero = "SELECT cedula, nombre, apellido, telefono FROM camionero LIMIT $offset, $itemsPerPage";
        $resultCamionero = $db->query($sqlCamionero);

        // Calcular el número total de páginas
        $totalPages = ceil($totalRows / $itemsPerPage);

        // Cerrar la conexión a la base de datos
        $db->close();

        if ($totalPages > 0) {
            echo '<div style="display: flex; justify-content: center;">'; // Center the content horizontally
        
            // Table (Cedula, Nombre, Apellido, Telefono)
            echo "<table class='custom-table'>"; // Add a CSS class for styling
            echo "<tr><th>Cedula</th><th>Nombre</th><th>Apellido</th><th>Telefono</th></tr>";

            while ($rowCamionero = $resultCamionero->fetch_assoc()) {
                echo "<tr><td>" . ($rowCamionero["cedula"] ?? '') . "</td><td>" . ($rowCamionero["nombre"] ?? '') . "</td><td>" . ($rowCamionero["apellido"] ?? '') . "</td><td>" . ($rowCamionero["telefono"] ?? '') . "</td></tr>";
            }

            echo '<tr><td colspan="4" style="text-align: center;">';
            for ($page = 1; $page <= $totalPages; $page++) {
                echo "<a class='pagination-button' href='tu_pagina.php?page=$page'>$page</a> ";
            }
            echo '</td></tr>';
            echo "</table>";

            echo '</div>';
        } else {
            echo "No se encontraron resultados.";
        }
        ?>

    </center>
</body>

</html>