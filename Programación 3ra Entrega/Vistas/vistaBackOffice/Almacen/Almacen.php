<?php
require_once "../../../Controladores/Token/TKVerifyAdmin.php";
require_once "../../../URL/url.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo $base_url; ?>Vistas/vistaBackOffice/css/Almacenes.css">
    <link rel="icon" href="<?php echo $base_url; ?>Vistas/img/Logo-QC.png">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Almacen</title>
</head>

<body>


    <nav>
        <ul>

            <li><a class="logo">
                    <img src="<?php echo $base_url; ?>Vistas/img/Logo-QC.png" alt="logo">
                    <span class="nav-item">Quick System</span>
            </li></a>

            <li><a href="#">
                    <i class="fa fa-home"></i>
                    <span class="nav-item">Inicio</span>
                </a></li>

            <li><a href="<?php echo $base_url; ?>Vistas/vistaBackOffice/Almacen/registrar.php">
                    <i class="fa fa-solid fa-box-open"></i>
                    <span class="nav-item">Registrar</span>
                </a></li>

            <li><a href="<?php echo $base_url; ?>Vistas/vistaBackOffice/Almacen/modificar.php">
                    <i class="fa fa-solid fa-pen-to-square"></i>
                    <span class="nav-item">Modificar</span>
                </a></li>


            <li><a href="<?php echo $base_url; ?>Vistas/vistaBackOffice/Almacen/eliminar.php">
                    <i class="fa fa-solid fa-trash"></i>
                    <span class="nav-item">Eliminar</span>
                </a></li>

            <li><a href="<?php echo $base_url; ?>Vistas/vistaBackOffice/Almacen/asignarTrayecto.php">
                    <i class="fa fa-solid fa-map-location-dot"></i>
                    <span class="nav-item">Asignar trayecto</span>
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
        $countSql = "SELECT COUNT(*) AS total FROM almacen";
        $countResult = $db->query($countSql);
        $totalRows = $countResult->fetch_assoc()['total'];


        // Calcular el offset
        $offset = ($currentPage - 1) * $itemsPerPage;

        // Consulta SQL para obtener los datos con límite
        $sql = "SELECT almacen.idAlmacen, pertenece.idTrayecto, almacen.puertaAlmacen, almacen.calleAlmacen, almacen.ciudadAlmacen, almacen.telefonoAlmacen
    FROM almacen
    LEFT JOIN pertenece ON almacen.idAlmacen = pertenece.idAlmacen
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
        <th>ID Almacen</th>
        <th>ID Trayecto</th>
        <th>Puerta almacen</th>
        <th>Calle almacen</th>
        <th>Ciudad almacen</th>
        <th>Telefono almacen</th>
    </tr>";

                while ($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    $keys = array("idAlmacen", "idTrayecto", "puertaAlmacen", "calleAlmacen", "ciudadAlmacen", "telefonoAlmacen");

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
                echo '<tr><td colspan="9" style="text-align: center;">';
                for ($page = 1; $page <= $totalPages; $page++) {
                    echo "<a class='pagination-button' href='Almacen.php?page=$page'>$page</a> ";
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