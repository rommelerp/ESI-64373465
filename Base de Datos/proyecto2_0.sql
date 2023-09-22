-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 22-09-2023 a las 22:29:44
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `proyecto2.0`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `almacen`
--

CREATE TABLE `almacen` (
  `id_Almacen` int(11) NOT NULL,
  `puerta_Almacen` int(11) NOT NULL,
  `calle_Almacen` varchar(50) NOT NULL,
  `ciudad_Almacen` varchar(50) NOT NULL,
  `telefono_Almacen` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `almacen`
--

INSERT INTO `almacen` (`id_Almacen`, `puerta_Almacen`, `calle_Almacen`, `ciudad_Almacen`, `telefono_Almacen`) VALUES
(1, 2563, 'Anzani', 'Montevideo', 98787587);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `camion`
--

CREATE TABLE `camion` (
  `matricula` varchar(7) NOT NULL,
  `estado_Camion` varchar(50) NOT NULL,
  `tarea_Camion` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `camion`
--

INSERT INTO `camion` (`matricula`, `estado_Camion`, `tarea_Camion`) VALUES
('TPA2000', 'Ocupado', 'Transportando Lote'),
('TPA8598', 'Fuera de servicio', 'Inactivo'),
('TPA9090', 'Libre', 'Sin tarea');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `camionero`
--

CREATE TABLE `camionero` (
  `cedula` int(8) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `apellido` varchar(20) NOT NULL,
  `telefono` int(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `camionero`
--

INSERT INTO `camionero` (`cedula`, `nombre`, `apellido`, `telefono`) VALUES
(23566667, 'Lorena', 'Ferreira', 97485987),
(55633371, 'Richard', 'Rodríguez', 95737786),
(57776661, 'Rommel', 'Rodríguez', 94756783);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `camioneta`
--

CREATE TABLE `camioneta` (
  `matricula` varchar(7) NOT NULL,
  `estado_Camioneta` varchar(50) NOT NULL,
  `tarea_Camioneta` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `camioneta`
--

INSERT INTO `camioneta` (`matricula`, `estado_Camioneta`, `tarea_Camioneta`) VALUES
('TPA0000', 'Ocupado', 'Sin tarea'),
('TPA8080', 'Libre', 'Sin tarea');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lote`
--

CREATE TABLE `lote` (
  `id_Lote` int(11) NOT NULL,
  `id_Almacen` int(11) NOT NULL,
  `matricula` varchar(7) NOT NULL,
  `tipo_Lote` varchar(50) NOT NULL,
  `fecha_Creacion` datetime NOT NULL,
  `fecha_Cierre` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `lote`
--

INSERT INTO `lote` (`id_Lote`, `id_Almacen`, `matricula`, `tipo_Lote`, `fecha_Creacion`, `fecha_Cierre`) VALUES
(1, 1, 'TPA2000', 'Inicial', '2023-05-01 23:00:00', NULL),
(2, 1, 'TPA2000', 'Final', '2023-08-01 19:49:29', '2023-09-20 19:49:29');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paquete`
--

CREATE TABLE `paquete` (
  `id_Paquete` int(11) NOT NULL,
  `matricula` varchar(7) DEFAULT NULL,
  `id_Lote` int(11) DEFAULT NULL,
  `fecha_Recibido` datetime NOT NULL,
  `estado` varchar(50) NOT NULL,
  `propietario` varchar(50) NOT NULL,
  `puerta_Paquete` int(11) NOT NULL,
  `calle_Paquete` varchar(50) NOT NULL,
  `ciudad_Paquete` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `paquete`
--

INSERT INTO `paquete` (`id_Paquete`, `matricula`, `id_Lote`, `fecha_Recibido`, `estado`, `propietario`, `puerta_Paquete`, `calle_Paquete`, `ciudad_Paquete`) VALUES
(1, 'TPA0000', NULL, '2023-04-22 00:00:00', 'Almacen Central', 'Martin De Vecchi', 1563, 'Anzani', 'Melo'),
(2, 'TPA0000', 1, '2023-04-22 00:39:02', 'En camino', 'Rommel', 4563, 'Neyra', 'Melo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculo`
--

CREATE TABLE `vehiculo` (
  `matricula` varchar(7) NOT NULL,
  `cedula` int(8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `vehiculo`
--

INSERT INTO `vehiculo` (`matricula`, `cedula`) VALUES
('TPA8080', NULL),
('TPA9090', NULL),
('TPA8598', 23566667),
('TPA0000', 55633371),
('TPA2000', 57776661);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `almacen`
--
ALTER TABLE `almacen`
  ADD PRIMARY KEY (`id_Almacen`);

--
-- Indices de la tabla `camion`
--
ALTER TABLE `camion`
  ADD PRIMARY KEY (`matricula`);

--
-- Indices de la tabla `camionero`
--
ALTER TABLE `camionero`
  ADD PRIMARY KEY (`cedula`);

--
-- Indices de la tabla `camioneta`
--
ALTER TABLE `camioneta`
  ADD PRIMARY KEY (`matricula`);

--
-- Indices de la tabla `lote`
--
ALTER TABLE `lote`
  ADD PRIMARY KEY (`id_Lote`),
  ADD KEY `matricula` (`matricula`),
  ADD KEY `id_Almacen` (`id_Almacen`);

--
-- Indices de la tabla `paquete`
--
ALTER TABLE `paquete`
  ADD PRIMARY KEY (`id_Paquete`),
  ADD KEY `id_Lote` (`id_Lote`),
  ADD KEY `matricula` (`matricula`);

--
-- Indices de la tabla `vehiculo`
--
ALTER TABLE `vehiculo`
  ADD PRIMARY KEY (`matricula`),
  ADD UNIQUE KEY `cedula` (`cedula`);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `camion`
--
ALTER TABLE `camion`
  ADD CONSTRAINT `camion_ibfk_1` FOREIGN KEY (`matricula`) REFERENCES `vehiculo` (`matricula`);

--
-- Filtros para la tabla `camioneta`
--
ALTER TABLE `camioneta`
  ADD CONSTRAINT `camioneta_ibfk_1` FOREIGN KEY (`matricula`) REFERENCES `vehiculo` (`matricula`);

--
-- Filtros para la tabla `lote`
--
ALTER TABLE `lote`
  ADD CONSTRAINT `lote_ibfk_1` FOREIGN KEY (`id_Almacen`) REFERENCES `almacen` (`id_Almacen`),
  ADD CONSTRAINT `lote_ibfk_2` FOREIGN KEY (`matricula`) REFERENCES `camion` (`matricula`);

--
-- Filtros para la tabla `paquete`
--
ALTER TABLE `paquete`
  ADD CONSTRAINT `paquete_ibfk_1` FOREIGN KEY (`matricula`) REFERENCES `camioneta` (`matricula`),
  ADD CONSTRAINT `paquete_ibfk_2` FOREIGN KEY (`id_Lote`) REFERENCES `lote` (`id_Lote`);

--
-- Filtros para la tabla `vehiculo`
--
ALTER TABLE `vehiculo`
  ADD CONSTRAINT `vehiculo_ibfk_1` FOREIGN KEY (`cedula`) REFERENCES `camionero` (`cedula`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
