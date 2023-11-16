<?php
require_once "URL/url.php";
?>
<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="Vistas/css/Principal.css">
	<link rel="icon" href="Vistas/img/Logo-QC.png">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

	<title>Quick System</title>
</head>

<body>
	<nav>
		<ul>
			<li>
				<a href="#" class="logo">
					<img src="Vistas/img/Logo-QC.png" alt="logo">
					<span class="nav-item">Quick System</span>
			</li></a>

			<li><a href="#">
					<i class="fa fa-home"></i>
					<span class="nav-item">Inicio</span>
				</a></li>

			<li><a href="Vistas/vistaLogin/Login.php">
					<i class="fa fa-solid fa-user"></i>
					<span class="nav-item">Perfil</span>
				</a></li>

			<li><a href="Vistas/vistaAyuda/Support.html">
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
				</a></li>
			<li><a href="#" class="Direccion">
					<i class="fa fa-solid fa-map-pin"></i>
					<span class="nav-item">Direccion</span>
				</a></li>

			<li><a href="#" class="ig">
					<i class="fa fa-brands fa-instagram"></i>
					<span class="nav-item">Instagram</span>
				</a></li>
			<li><a href="#" class="Twitter">
					<i class="fa fa-brands fa-twitter"></i>
					<span class="nav-item">Twitter</span>
				</a></li>




		</ul>
	</nav>



	<h1>Quick System</h1>
	<br>
	<form action="<?php echo $base_url; ?>Controladores/Paquete/seguimiento.php" method="get">

		<div class="seguimiento">

			<h2>Rastree su envío</h2>

			<div class="rastreo">
				<input id="codigo" type="text" placeholder="Introduzca su id de paquete" name="idPaquete"
					style="text-align: left; padding-left: 10px;" required>
				<input id="enviar" type="submit" name="enviar">
			</div>
		</div>

	</form>
	<div class="texto">

		<p> Nos dedicamos al transporte de paquetería en distribución nacional,
			contamos con múltiples plataformas en la proximidad de las principales ciudades y centros poblados en casi
			todo el Uruguay.
			El sistema tiene el potencial de optimizar el desempeño de la empresa como también el de nuestros clientes.
		</p>
	</div>
</body>

</html>