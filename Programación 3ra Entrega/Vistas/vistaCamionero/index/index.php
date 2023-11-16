<?php

require_once "../../../Controladores/Token/TKVerifyCamionero.php";
require_once "../../../URL/url.php";

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo $base_url; ?>Vistas/vistaCamionero/css/camionero.css">
    <link rel="icon" href="<?php echo $base_url; ?>Vistas/img/Logo-QC.png">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Camionero</title>
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
        </ul>
    </nav>

    <?php
    require_once "../../../ConexionBD/conexion.php";

    if (isset($_GET['cedula'])) {

        $cedula = $_GET['cedula'];
        session_start();
        $_SESSION['cedula'] = $cedula;

    } else {
        session_start();
        $cedula = $_SESSION['cedula'];
    }


    $db = new Connection();

    // Verificar la conexión
    if ($db->connect_error) {
        die("La conexión a la base de datos ha fallado: " . $db->connect_error);
    }

    // Obtener la matrícula de la tabla "conduce"
    $sqlConduce = "SELECT matricula FROM conduce WHERE cedula = ?";

    $stmtConduce = $db->prepare($sqlConduce);
    $stmtConduce->bind_param("s", $cedula);
    $stmtConduce->execute();
    $resultConduce = $stmtConduce->get_result();

    if ($resultConduce->num_rows > 0) {
        // Obtener la primera fila (debería ser única) y extraer la matrícula
        $rowConduce = $resultConduce->fetch_assoc();
        $matricula = $rowConduce['matricula'];

        // Verificar si la matrícula está en la tabla "camion"
        $sqlCamion = "SELECT * FROM camion WHERE matricula = ?";
        $stmtCamion = $db->prepare($sqlCamion);
        $stmtCamion->bind_param("s", $matricula);
        $stmtCamion->execute();
        $resultCamion = $stmtCamion->get_result();

        // Verificar si la matrícula está en la tabla "camioneta"
        $sqlCamioneta = "SELECT * FROM camioneta WHERE matricula = ?";
        $stmtCamioneta = $db->prepare($sqlCamioneta);
        $stmtCamioneta->bind_param("s", $matricula);
        $stmtCamioneta->execute();
        $resultCamioneta = $stmtCamioneta->get_result();

        // Cerrar la conexión a la base de datos
        $stmtConduce->close();

        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        ///////////////////////////////////////////////////////////////////            CAMION               ///////////////////////////////////////////////////////////////////////////////
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
        if ($resultCamion->num_rows > 0) {

            $itemsPerPage = 15; // Número de filas por página
            $currentPage = isset($_GET['page']) ? (int) $_GET['page'] : 1; // Página actual
    
            // Consulta SQL para contar el número total de registros sin límite (Tiene, Conduce, Lote)
            $countSql = "SELECT COUNT(*) AS total FROM tiene JOIN conduce ON tiene.matricula = conduce.matricula LEFT JOIN lote ON tiene.idLote = lote.idLote WHERE conduce.cedula = ?";
            $countStmt = $db->prepare($countSql);
            $countStmt->bind_param("s", $cedula);
            $countStmt->execute();
            $countResult = $countStmt->get_result();
            $totalRows = $countResult->fetch_assoc()['total'];

            // Calcular el offset
            $offset = ($currentPage - 1) * $itemsPerPage;

            // Consulta SQL para obtener los datos con límite (Tiene, Conduce, Lote)
            $sql = "SELECT tiene.ordenEntrega, tiene.idLote, tiene.idAlmacen, tiene.idTrayecto, lote.estadoLote
        FROM tiene
        JOIN conduce ON tiene.matricula = conduce.matricula
        LEFT JOIN lote ON tiene.idLote = lote.idLote
        WHERE conduce.cedula = ?
        ORDER BY tiene.ordenEntrega ASC
        LIMIT ?, ?";

            $stmt = $db->prepare($sql);
            $stmt->bind_param("sii", $cedula, $offset, $itemsPerPage);
            $stmt->execute();
            $result = $stmt->get_result();

            // Calcular el número total de páginas (Tiene, Conduce, Lote)
            $totalPages = ceil($totalRows / $itemsPerPage);

            // Imprimir tabla y botones de paginación (Tiene, Conduce, Lote)
            if ($result->num_rows > 0) {
                echo "<table>
        <tr>
            <th>Orden de entrega</th>
            <th>ID Lote</th>
            <th>ID Almacen</th>
            <th>ID Trayecto</th>
            <th>Acción</th>
        </tr>";

                while ($row = $result->fetch_assoc()) {
                    echo '<tr>'; // Set background, border, and text color for rows
                    $keys = array("ordenEntrega", "idLote", "idAlmacen", "idTrayecto");

                    foreach ($keys as $key) {
                        echo '<td style="text-align: center;">' . $row[$key] . '</td>';
                    }

                    // Acción (Botón "Entregar" como un formulario)
                    echo '<td style="text-align: center;">';
                    if ($row["estadoLote"] == 'Entregado') {
                        echo 'Lote entregado';
                    } else {
                        echo '<form method="post" action="' . $base_url . 'Controladores/Lote/entregaLote.php?cedula=' . $cedula . '" style="text-align: center; margin-top: 10px;">
                                <input type="hidden" name="idLote" value="' . $row["idLote"] . '">
                                <button type="submit" style="    background: rgb(30, 29, 114);
                                color: #fff; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;">Entregar</button>
                              </form>';


                    }
                    echo '</td>';

                    echo '</tr>';
                }

                // Agrega la fila de botones de paginación
                echo '<tr><td colspan="5" style="text-align: center;">';
                for ($page = 1; $page <= $totalPages; $page++) {
                    echo "<a class='pagination-button' href='index.php?page=$page&cedula=$cedula'>$page</a> ";
                }
                echo '</td></tr>';
                echo '<tr>
    <td colspan="4" style="text-align: center; background-color: rgb(30, 29, 114); border: 1px solid rgb(30, 29, 114); color: white;">'; // Set background, border, and text color for the last row
    
                echo '<form method="post" action="' . $base_url . 'Controladores/Viaje/iniciarViaje.php" style="display: inline-block; margin: 10px;">';
                echo '<input type="submit" value="Iniciar Viaje" style="background-color: #4CAF50; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;">';
                echo '<input type="hidden" value="lote" name="iniciarViaje">';
                echo '<input type="hidden" value="' . $cedula . '" name="cedula">';

                // Iterar sobre los resultados para incluir múltiples ID de lote en el formulario
                $result->data_seek(0); // Reiniciar el puntero del resultado al principio
                while ($row = $result->fetch_assoc()) {
                    echo '<input type="hidden" name="idLotes[]" value="' . $row["idLote"] . '">';
                }

                echo '</form>';


                echo '<form method="post" action="' . $base_url . 'Controladores/Viaje/finalizarViaje.php" style="display: inline-block; margin: 10px;">';
                echo '<input type="submit" value="Finalizar Viaje" style="background-color: #D9534F; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;">';
                echo '<input type="hidden" value="lote" name="finalizarViaje">';
                echo '<input type="hidden" value="' . $cedula . '" name="cedula">';

                // Iterar sobre los resultados para incluir múltiples ID de lote en el formulario
                $result->data_seek(0); // Reiniciar el puntero del resultado al principio
                while ($row = $result->fetch_assoc()) {
                    echo '<input type="hidden" name="idLotes[]" value="' . $row["idLote"] . '">';
                }


                echo '</form>';

                echo '</td></tr>';
                echo "</table>";
            }

            // Cerrar la conexión a la base de datos
            $stmt->close();
            $db->close();

            /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
            ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            ///////////////////////////////////////////////////////////////////            CAMIONETA            ///////////////////////////////////////////////////////////////////////////////
            ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        } elseif ($resultCamioneta->num_rows > 0) {
            $countSql = "SELECT COUNT(*) AS total FROM lleva JOIN conduce ON lleva.matricula = conduce.matricula JOIN paquete ON lleva.idPaquete = paquete.idPaquete WHERE conduce.cedula = ?";
            $countStmt = $db->prepare($countSql);
            $countStmt->bind_param("s", $cedula);
            $countStmt->execute();
            $countResult = $countStmt->get_result();
            $totalRows = $countResult->fetch_assoc()['total'];

            $itemsPerPage = 15; // Número de filas por página
            $currentPage = isset($_GET['page']) ? (int) $_GET['page'] : 1; // Página actual
    
            // Calcular el offset
            $offset = ($currentPage - 1) * $itemsPerPage;

            // Consulta SQL para obtener los datos con límite (lleva, conduce, paquete)
            $sql = "SELECT lleva.ordenEntrega, lleva.idPaquete, paquete.estadoPaquete, paquete.propietario, paquete.ciudadPaquete, paquete.callePaquete, paquete.puertaPaquete
            FROM lleva
            JOIN conduce ON lleva.matricula = conduce.matricula
            JOIN paquete ON lleva.idPaquete = paquete.idPaquete
            WHERE conduce.cedula = ?
            ORDER BY lleva.ordenEntrega ASC
            LIMIT ?, ?";
            $stmt = $db->prepare($sql);
            $stmt->bind_param("sii", $cedula, $offset, $itemsPerPage);
            $stmt->execute();
            $result = $stmt->get_result();

            // Calcular el número total de páginas (lleva, conduce, paquete)
            $totalPages = ceil($totalRows / $itemsPerPage);

            // Imprimir tabla y botones de paginación (lleva, conduce, paquete)
            if ($result->num_rows > 0) {
                echo "<table>
                <tr>    
                    <th>Orden de entrega</th>
                    <th>ID Paquete</th>
                    <th>Estado del Paquete</th>
                    <th>Propietario</th>
                    <th>Ciudad del Paquete</th>
                    <th>Calle del Paquete</th>
                    <th>Puerta del Paquete</th>
                    <th>Acción</th>
                </tr>";

                while ($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    $keys = array("ordenEntrega", "idPaquete", "estadoPaquete", "propietario", "ciudadPaquete", "callePaquete", "puertaPaquete");

                    foreach ($keys as $key) {
                        echo '<td';
                        echo ' style="text-align: center;">' . $row[$key] . '</td>';
                    }

                    // Agregamos el botón "Entregar" como un formulario
                    echo '<td style="text-align: center;">';
                    if ($row["estadoPaquete"] == 'Entregado') {
                        echo 'Paquete entregado';
                    } else {
                        echo '<form method="post" action="' . $base_url . 'Controladores/paquete/entregaPaquete.php?cedula=' . $cedula . '" style="text-align: center; margin-top: 10px;">
        <input type="hidden" name="idPaquete" value="' . $row["idPaquete"] . '">
        <button type="submit" style="background: rgb(30, 29, 114); color: #fff; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;">Entregar</button>
      </form>';

                    }
                    echo '</td>';

                    echo '</tr>';
                }

                // Agrega la fila de botones de paginación
                echo '<tr><td colspan="8" style="text-align: center;">';
                for ($page = 1; $page <= $totalPages; $page++) {
                    echo "<a class='pagination-button' href='index.php?page=$page&cedula=$cedula'>$page</a> ";
                }
                echo '</td></tr>';
                echo '<tr>';
                echo '<tr>
                <td colspan="7" style="text-align: center; background-color: rgb(30, 29, 114); border: 1px solid rgb(30, 29, 114); color: white;">';

                echo '<form method="post" action="' . $base_url . 'Controladores/Viaje/iniciarViaje.php" style="display: inline-block; margin: 10px;">';
                echo '<input type="submit" value="Iniciar Viaje" style="background-color: #4CAF50; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;">';
                echo '<input type="hidden" value="paquete" name="iniciarViaje">';
                echo '<input type="hidden" value="' . $cedula . '" name="cedula">';

                // Iterar sobre los resultados para incluir múltiples ID de paquete en el formulario
                $result->data_seek(0); // Reiniciar el puntero del resultado al principio
                while ($row = $result->fetch_assoc()) {
                    echo '<input type="hidden" name="idPaquetes[]" value="' . $row["idPaquete"] . '">';
                }
                echo '</form>';


                echo '<form method="post" action="' . $base_url . 'Controladores/Viaje/finalizarViaje.php" style="display: inline-block; margin: 10px;">';
                echo '<input type="submit" value="Finalizar Viaje" style="background-color: #D9534F; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;">';
                echo '<input type="hidden" value="paquete" name="finalizarViaje">';
                echo '<input type="hidden" value="' . $cedula . '" name="cedula">';

                // Iterar sobre los resultados para incluir múltiples ID de paquete en el formulario
                $result->data_seek(0); // Reiniciar el puntero del resultado al principio
                while ($row = $result->fetch_assoc()) {
                    echo '<input type="hidden" name="idPaquetes[]" value="' . $row["idPaquete"] . '">';
                }
                echo '</form>';

                echo '</td></tr>';
                echo "</table>";
            }

            // Cerrar la conexión a la base de datos
            $stmt->close();
            $db->close();

        } else {
            echo "<script>
        var matricula = '$matricula';
        alert('No se encontró información sobre el tipo de vehículo para la matrícula ' + matricula + '.');
      </script>";
        }
    } else {
        echo "<script>
        var cedula = '$cedula';
        alert('No se encontraron registros de conducción para la cédula ' + cedula + '.');
      </script>";
    }

    ?>

</body>

</html>