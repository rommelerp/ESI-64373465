<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_COOKIE['jwtToken'])) {
        // Elimina la cookie del lado del servidor (tiempo de expiración en el pasado y path=/)
        setcookie('jwtToken', '', time() - 86400, '/');

        // Envía un script JavaScript para eliminar la cookie del lado del cliente
        echo "<script>
                document.cookie = 'jwtToken=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
                window.location.href = 'index.php';
              </script>";
        exit(); // Asegura que el script JavaScript sea la última salida
    }
    // Redirige a la página de inicio si la cookie no existe
    echo "<script>
    window.location.href = 'index.php';
  </script>";
}
?>