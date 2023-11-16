<?php

require_once "../../URL/url.php";

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo $base_url; ?>Vistas/vistaLogin/css/Login.css">
    <link rel="icon" href="<?php echo $base_url; ?>Vistas/img/Logo-QC.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Login</title>
</head>

<body>
    <nav>
        <ul>
            <li>
                <a href="#" class="logo">
                    <img src="<?php echo $base_url; ?>Vistas/img/Logo-QC.png" alt="logo">
                    <span class="nav-item">Quick System</span>
            </li></a>

            <li><a class="a" href="<?php echo $base_url; ?>index.php">
                    <i class="fa fa-home"></i>
                    <span class="nav-item">Inicio</span>
                </a></li>

            <li><a href="<?php echo $base_url; ?>Vistas/vistaAyuda/Support.html">
                    <i class="fa fa-solid fa-circle-question"></i>
                    <span class="nav-item">Ayuda</span>
                </a></li>

            <li>
                <a href="#" class="Email">
                    <i class="fa fa-solid fa-at"></i>
                    <span class="nav-item"> Email:</span>
                </a>
            </li>

            <li><a href="#" class="Telefono">
                    <i class="fa fa-solid fa-phone"> </i>
                    <span class="nav-item">Telefono: 096 754 985</span>
                </a>
            </li>
            <li><a href="#" class="Direccion">
                    <i class="fa fa-solid fa-map-pin"></i>
                    <span class="nav-item">Direccion</span>
                </a>
            </li>

            <li><a href="#" class="ig">
                    <i class="fa fa-brands fa-instagram"></i>
                    <span class="nav-item">Instagram</span>
                </a>
            </li>

            <li><a href="#" class="Twitter">
                    <i class="fa fa-brands fa-twitter"></i>
                    <span class="nav-item">Twitter</span>
                </a>
            </li>
        </ul>
    </nav>
    <br>
    <div id="todo">
        <form action="<?php echo $base_url; ?>Controladores/Usuario/login.php" method="post">
            <center>
                <h1>Login:</h1>
                <br>
                <input class="User" type="texto" placeholder="Usuario" name="usuarioCedula" required>
                <br>
                <br>
                <div class="password-container">
                    <input class="User" type="password" placeholder="Contraseña" name="usuarioPassword"
                        id="passwordField" required>
                    <i class="fas fa-eye" id="togglePassword"></i>
                </div>
                <br>
                <br>
                <button id="Entrar"><input type="submit" id="Entrar" value="Entrar"></button>
            </center>
        </form>
        </center>
    </div>
    <br>
    <!-- <footer class="footer">
        <p id="derechos"> INDEX.INC </p>
    </footer> -->

    <script>
        var passwordField = document.getElementById("passwordField");
        var togglePassword = document.getElementById("togglePassword");

        togglePassword.addEventListener("click", function () {
            if (passwordField.type === "password") {
                passwordField.type = "text";
            } else {
                passwordField.type = "password";
            }
        });
    </script>
</body>

</html>