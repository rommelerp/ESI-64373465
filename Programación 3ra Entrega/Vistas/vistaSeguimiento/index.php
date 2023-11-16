<?php

require_once "../../URL/url.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo $base_url; ?>Vistas/vistaSeguimiento/css/seguimientos.css">
    <link rel="icon" href="<?php echo $base_url; ?>Vistas/img/Logo-QC.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Seguimiento</title>
</head>

<body>


    <nav>
        <ul>

            <li><a class="logo">
                    <img src="<?php echo $base_url; ?>Vistas/img/Logo-QC.png" alt="logo">
                    <span class="nav-item">Quick System</span>
            </li></a>

            <li><a href="<?php echo $base_url; ?>index.php">
                    <i class="fa fa-home"></i>
                    <span class="nav-item">Inicio</span>
                </a></li>


            <li><a href="<?php echo $base_url; ?>Vistas/vistaAyuda/Support.html">
                    <i class="fa fa-solid fa-circle-question"></i>
                    <span class="nav-item">Ayuda</span>
                </a></li>

            </div>
        </ul>
    </nav>
    <?php
    echo "<table>
<tr>
    <th>ID Paquete</th>
    <th>ID Lote</th>
    <th>Estado del Paquete</th>
    <th>Vehiculo</th>
    <th>Cedula</th>
</tr>";

    echo '<tr>';
    echo '<td>' . $datosSeguimiento[0]['idPaquete'] . '</td>';
    echo '<td>' . $datosSeguimiento[0]['idLote'] . '</td>';
    echo '<td>' . $datosSeguimiento[0]['estadoPaquete'] . '</td>';
    echo '<td>' . $datosSeguimiento[0]['matricula'] . '</td>';
    echo '<td>' . $datosSeguimiento[0]['cedula'] . '</td>';
    echo '</tr>';

    echo "</table>";
    ?>
</body>

</html>