<?php

require_once "../../../Controladores/Token/TKVerifyAdmin.php";
require_once "../../../URL/url.php";

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo $base_url; ?>Vistas/vistaBackOffice/css/Paquetes.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <link rel="icon" href="<?php echo $base_url; ?>Vistas/img/Logo-QC.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Paquete</title>

</head>

<body>

    <nav>

        <ul>

            <li><a class="logo">
                    <img src="<?php echo $base_url; ?>Vistas/img/Logo-QC.png" alt="logo">
                    <span class="nav-item">Quick System</span>
            </li></a>

            <li><a href="<?php echo $base_url; ?>Vistas/vistaBackOffice/paquete/index.php">
                    <i class="fa fa-home"></i>
                    <span class="nav-item">Inicio</span>
                </a></li>

            <li><a href="<?php echo $base_url; ?>Vistas/vistaBackOffice/paquete/registrar.php">
                    <i class="fa fa-solid fa-box-open"></i>
                    <span class="nav-item">Registrar</span>
                </a></li>

            <li><a href="<?php echo $base_url; ?>Vistas/vistaBackOffice/paquete/modificar.php">
                    <i class="fa fa-solid fa-pen-to-square"></i>
                    <span class="nav-item">Modificar</span>
                </a></li>

            <li><a href="<?php echo $base_url; ?>Vistas/vistaBackOffice/paquete/eliminar.php">
                    <i class="fa fa-solid fa-trash"></i>
                    <span class="nav-item">Eliminar</span>
                </a></li>

            <li><a href="<?php echo $base_url; ?>Vistas/vistaBackOffice/paquete/asignarLote.php">
                    <i class="fa fa-solid fa-boxes-packing"></i>
                    <span class="nav-item">Asignar lote</span>
                </a></li>

            <li><a href="<?php echo $base_url; ?>Vistas/vistaBackOffice/paquete/asignarCamioneta.php">
                    <i class="fa fa-solid fa-truck-ramp-box"></i>
                    <span class="nav-item">Asignar camioneta</span>
                </a></li>

            <li><a href="<?php echo $base_url; ?>Vistas/vistaBackOffice/paquete/asignarOrdenEntrega.php">
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
        <?php
        require_once "../../../ConexionBD/conexion.php";
        $db = new Connection();

        // Verificar la conexión
        if ($db->connect_error) {
            die("La conexión a la base de datos ha fallado: " . $db->connect_error);
        }

        $itemsPerPage = 15; // Número de filas por página
        $currentPage = isset($_GET['page']) ? (int) $_GET['page'] : 1; // Página actual
        
        // Consulta SQL para contar el número total de registros sin límite
        $countSql = "SELECT COUNT(*) AS total FROM paquete";
        $countResult = $db->query($countSql);
        $totalRows = $countResult->fetch_assoc()['total'];


        // Calcular el offset
        $offset = ($currentPage - 1) * $itemsPerPage;

        // Consulta SQL para obtener los datos con límite
        $sql = "SELECT lleva.ordenEntrega, paquete.idPaquete, esParte.idLote, lleva.matricula, paquete.fechaRecibido, paquete.estadoPaquete, paquete.propietario, paquete.puertaPaquete, paquete.callePaquete, paquete.ciudadPaquete
    FROM paquete
    LEFT JOIN esParte ON paquete.idPaquete = esParte.idPaquete
    LEFT JOIN lleva ON paquete.idPaquete = lleva.idPaquete
    LIMIT $offset, $itemsPerPage";

        $result = $db->query($sql);

        // Calcular el número total de páginas
        $totalPages = ceil($totalRows / $itemsPerPage);

        // Cerrar la conexión a la base de datos
        $db->close();

        if ($result->num_rows > 0) {
            if ($totalPages > 0) {
                echo "<table>   
    <tr>
        <th>Orden de entrega</th>
        <th>ID Paquete</th>
        <th>ID Lote</th>
        <th>Matrícula</th>
        <th>Fecha Recibido</th>
        <th>Estado Paquete</th>
        <th>Propietario</th>
        <th>Puerta Paquete</th>
        <th>Calle Paquete</th>
        <th>Ciudad Paquete</th>
    </tr>";

                while ($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    $keys = array("ordenEntrega", "idPaquete", "idLote", "matricula", "fechaRecibido", "estadoPaquete", "propietario", "puertaPaquete", "callePaquete", "ciudadPaquete");

                    foreach ($keys as $key) {
                        echo '<td';
                        if (empty($row[$key])) {
                            echo ' style="color: red; text-align: center; font-weight: bold;">---</td>';
                        } else {
                            echo ' style="text-align: center;">' . $row[$key] . '</td>';
                        }
                    }

                    echo '</tr>';
                }

                // Agrega la fila de botones de paginación
                echo '<tr><td colspan="10" style="text-align: center;">';
                for ($page = 1; $page <= $totalPages; $page++) {
                    echo "<a class='pagination-button' href='index.php?page=$page'>$page</a> ";
                }
                echo '</td></tr>';

                echo "</table>";
            }

        } else {
            echo "No se encontraron resultados.";
        }


        ?>
    </center>
</body>

</html>