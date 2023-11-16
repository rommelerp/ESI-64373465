-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-11-2023 a las 07:56:50
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
-- Base de datos: `base`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `almacen`
--

CREATE TABLE `almacen` (
  `idAlmacen` int(11) NOT NULL,
  `puertaAlmacen` int(11) DEFAULT NULL,
  `calleAlmacen` varchar(50) DEFAULT NULL,
  `ciudadAlmacen` varchar(50) DEFAULT NULL,
  `telefonoAlmacen` varchar(9) DEFAULT NULL,
  `departamentoAlmacen` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `almacen`
--

INSERT INTO `almacen` (`idAlmacen`, `puertaAlmacen`, `calleAlmacen`, `ciudadAlmacen`, `telefonoAlmacen`, `departamentoAlmacen`) VALUES
(2, 2000, 'Anzani', 'Montevideo', '098787586', 'Canelones'),
(3, 2563, 'Anzaniiiiiiia', 'Montevideo', '098787587', 'Colonia'),
(5, 1111, 'asd', 'asd', '12341312', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `almacena`
--

CREATE TABLE `almacena` (
  `idLote` int(11) NOT NULL,
  `idTrayecto` int(11) DEFAULT NULL,
  `idAlmacen` int(11) DEFAULT NULL,
  `fechaEntregado` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `almacena`
--

INSERT INTO `almacena` (`idLote`, `idTrayecto`, `idAlmacen`, `fechaEntregado`) VALUES
(1, 3, 3, '2023-11-13 00:35:38'),
(2, 3, 2, '2023-11-13 00:36:55');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `camion`
--

CREATE TABLE `camion` (
  `matricula` varchar(7) NOT NULL,
  `estadoCamion` enum('Libre','Ocupado','Mantenimiento') DEFAULT NULL,
  `tareaCamion` enum('En ruta','Sin tarea') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `camion`
--

INSERT INTO `camion` (`matricula`, `estadoCamion`, `tareaCamion`) VALUES
('TPA2001', 'Ocupado', 'En ruta'),
('TPA8598', 'Ocupado', 'En ruta'),
('TPA9090', 'Libre', 'Sin tarea');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `camionero`
--

CREATE TABLE `camionero` (
  `cedula` int(8) NOT NULL,
  `nombre` varchar(20) DEFAULT NULL,
  `apellido` varchar(20) DEFAULT NULL,
  `telefono` varchar(9) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `camionero`
--

INSERT INTO `camionero` (`cedula`, `nombre`, `apellido`, `telefono`) VALUES
(12, 'asd', 'asd', 'asd'),
(888, 'Rommel ', 'Rodriguez', '22026428'),
(1234, 'Rommel', 'Rodriguez', '123'),
(12345, 'Martín ', 'De Vechi', '22026428'),
(23566667, 'Lorena', 'Ferreira', '097485987'),
(55633371, 'Richard', 'Rodríguez', '095737786'),
(57776661, 'Rommel', 'Rodríguez', '094756783');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `camioneta`
--

CREATE TABLE `camioneta` (
  `matricula` varchar(7) NOT NULL,
  `estadoCamioneta` enum('Libre','Ocupado','Mantenimiento') DEFAULT NULL,
  `tareaCamioneta` enum('En ruta','Sin tarea') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `camioneta`
--

INSERT INTO `camioneta` (`matricula`, `estadoCamioneta`, `tareaCamioneta`) VALUES
('TPA0000', 'Mantenimiento', 'Sin tarea'),
('TPA8080', 'Libre', 'En ruta');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `conduce`
--

CREATE TABLE `conduce` (
  `cedula` int(8) NOT NULL,
  `matricula` varchar(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `conduce`
--

INSERT INTO `conduce` (`cedula`, `matricula`) VALUES
(55633371, 'TPA8598');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `esparte`
--

CREATE TABLE `esparte` (
  `idPaquete` int(11) NOT NULL,
  `idLote` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `esparte`
--

INSERT INTO `esparte` (`idPaquete`, `idLote`) VALUES
(1, 2),
(2, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lleva`
--

CREATE TABLE `lleva` (
  `idPaquete` int(11) NOT NULL,
  `matricula` varchar(7) DEFAULT NULL,
  `ordenEntrega` varchar(50) DEFAULT NULL,
  `fechaEntregado` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `lleva`
--

INSERT INTO `lleva` (`idPaquete`, `matricula`, `ordenEntrega`, `fechaEntregado`) VALUES
(1, 'TPA8080', '12', '2023-11-13 02:43:23'),
(2, 'TPA8080', '1', '2023-11-13 02:34:06');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `login`
--

CREATE TABLE `login` (
  `cedula` int(11) NOT NULL,
  `nombre` varchar(20) DEFAULT NULL,
  `apellido` varchar(20) DEFAULT NULL,
  `password` varchar(70) DEFAULT NULL,
  `telefono` varchar(9) DEFAULT NULL,
  `rol` enum('administrador','funcionario','camionero') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `login`
--

INSERT INTO `login` (`cedula`, `nombre`, `apellido`, `password`, `telefono`, `rol`) VALUES
(12, 'asd', 'asd', '$2y$10$.Jy6v/MgKgswz7r.kSQEjuOLEagk.rU2TUob3gvSgKFFR8wqdAk..', 'asd', 'camionero'),
(123, 'Rommel', 'Rodriguez', '$2y$10$uEcqY4OjNkNJcQ/QuXrPLORF2y.zEmQaJv63CgIAEKWuIwTmbkDl2', '123', 'administrador'),
(888, 'Rommel ', 'Rodriguez', '$2y$10$ScTB.DmQCWyhL179LukrQ.F27tb0A140g2rYRBJYuzRmqYj9k.wTq', '22026428', 'camionero'),
(1234, 'Rommel', 'Rodriguez', '$2y$10$gwdzqzaVH0vZHU/r82emxuW0qaFG0GG.2YSVx5GsHJWtFi.yRUEAq', '123', 'camionero'),
(1235, 'Rommelll', 'Rodríguez', '3', '094756783', 'camionero'),
(12345, 'Martín ', 'De Vechi', '$2y$10$LXa9maLymS9MfGJaUz6MQOxVudTRtuuss6886KKWnSJdlFrDXdQXK', '22026428', 'funcionario'),
(123456, 'Rommel ', 'Ferreira', '$2y$10$/6A54959jhJ5OFk.G1XXl.ub6UtKgaMLmZSWJ76DyeiUd2dLnkDKG', '22026428', 'funcionario');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lote`
--

CREATE TABLE `lote` (
  `idLote` int(11) NOT NULL,
  `fechaCreacion` date DEFAULT NULL,
  `estadoLote` enum('Abierto','Cerrado','Entregado') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `lote`
--

INSERT INTO `lote` (`idLote`, `fechaCreacion`, `estadoLote`) VALUES
(1, '2023-11-12', 'Abierto'),
(2, '2023-11-12', 'Entregado'),
(3, '2023-11-12', 'Entregado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paquete`
--

CREATE TABLE `paquete` (
  `idPaquete` int(11) NOT NULL,
  `fechaRecibido` date DEFAULT NULL,
  `estadoPaquete` enum('En proceso','En ruta','Almacenado','En camino al propietario','Entregado') DEFAULT NULL,
  `propietario` varchar(50) DEFAULT NULL,
  `puertaPaquete` int(11) DEFAULT NULL,
  `callePaquete` varchar(50) DEFAULT NULL,
  `ciudadPaquete` varchar(50) DEFAULT NULL,
  `departamentoPaquete` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `paquete`
--

INSERT INTO `paquete` (`idPaquete`, `fechaRecibido`, `estadoPaquete`, `propietario`, `puertaPaquete`, `callePaquete`, `ciudadPaquete`, `departamentoPaquete`) VALUES
(1, '2023-11-12', 'Almacenado', 'Martin De Vecchi', 1563, 'Anzani', 'Melo', 'Cerro Largo'),
(2, '2023-11-12', 'Entregado', 'Rommel', 4563, 'Neyra', 'Melo', 'Cerro Largo'),
(3, '2023-11-12', 'En proceso', 'Lorena', 4563, 'Neyra', 'Melo', 'Cerro Largo'),
(4, '2023-11-12', 'Almacenado', 'Pepe', 4563, 'Neyra', 'Artigas', 'Artigas');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pertenece`
--

CREATE TABLE `pertenece` (
  `idAlmacen` int(11) NOT NULL,
  `idTrayecto` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pertenece`
--

INSERT INTO `pertenece` (`idAlmacen`, `idTrayecto`) VALUES
(5, 2),
(2, 3),
(3, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tiene`
--

CREATE TABLE `tiene` (
  `idLote` int(11) NOT NULL,
  `matricula` varchar(7) DEFAULT NULL,
  `idAlmacen` int(11) NOT NULL,
  `idTrayecto` int(11) NOT NULL,
  `ordenEntrega` varchar(50) DEFAULT NULL,
  `fechaInicio` datetime DEFAULT NULL,
  `fechaFin` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tiene`
--

INSERT INTO `tiene` (`idLote`, `matricula`, `idAlmacen`, `idTrayecto`, `ordenEntrega`, `fechaInicio`, `fechaFin`) VALUES
(1, 'TPA2001', 3, 3, '12', '2023-11-12 17:50:18', '2023-11-13 00:35:38'),
(2, 'TPA2001', 2, 3, '2', '2023-11-12 17:50:18', '2023-11-13 00:36:55');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trayecto`
--

CREATE TABLE `trayecto` (
  `idTrayecto` int(11) NOT NULL,
  `duracion` time DEFAULT NULL,
  `rutas` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `trayecto`
--

INSERT INTO `trayecto` (`idTrayecto`, `duracion`, `rutas`) VALUES
(2, '04:00:00', 'Ruta 1'),
(3, '12:00:00', 'Ruta 1, 2, 3');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculo`
--

CREATE TABLE `vehiculo` (
  `matricula` varchar(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `vehiculo`
--

INSERT INTO `vehiculo` (`matricula`) VALUES
('TPA0000'),
('TPA2001'),
('TPA8080'),
('TPA8598'),
('TPA9090');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `almacen`
--
ALTER TABLE `almacen`
  ADD PRIMARY KEY (`idAlmacen`);

--
-- Indices de la tabla `almacena`
--
ALTER TABLE `almacena`
  ADD PRIMARY KEY (`idLote`),
  ADD KEY `idAlmacen` (`idAlmacen`),
  ADD KEY `idTrayecto` (`idTrayecto`);

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
-- Indices de la tabla `conduce`
--
ALTER TABLE `conduce`
  ADD PRIMARY KEY (`cedula`,`matricula`),
  ADD UNIQUE KEY `cedula` (`cedula`),
  ADD UNIQUE KEY `matricula` (`matricula`);

--
-- Indices de la tabla `esparte`
--
ALTER TABLE `esparte`
  ADD PRIMARY KEY (`idPaquete`),
  ADD KEY `idLote` (`idLote`);

--
-- Indices de la tabla `lleva`
--
ALTER TABLE `lleva`
  ADD PRIMARY KEY (`idPaquete`),
  ADD KEY `matricula` (`matricula`);

--
-- Indices de la tabla `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`cedula`);

--
-- Indices de la tabla `lote`
--
ALTER TABLE `lote`
  ADD PRIMARY KEY (`idLote`);

--
-- Indices de la tabla `paquete`
--
ALTER TABLE `paquete`
  ADD PRIMARY KEY (`idPaquete`);

--
-- Indices de la tabla `pertenece`
--
ALTER TABLE `pertenece`
  ADD PRIMARY KEY (`idAlmacen`),
  ADD KEY `idTrayecto` (`idTrayecto`);

--
-- Indices de la tabla `tiene`
--
ALTER TABLE `tiene`
  ADD PRIMARY KEY (`idLote`,`idTrayecto`,`idAlmacen`),
  ADD UNIQUE KEY `idLote` (`idLote`),
  ADD KEY `matricula` (`matricula`),
  ADD KEY `tiene_ibfk_3` (`idTrayecto`),
  ADD KEY `tiene_ibfk_4` (`idAlmacen`);

--
-- Indices de la tabla `trayecto`
--
ALTER TABLE `trayecto`
  ADD PRIMARY KEY (`idTrayecto`);

--
-- Indices de la tabla `vehiculo`
--
ALTER TABLE `vehiculo`
  ADD PRIMARY KEY (`matricula`);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `almacena`
--
ALTER TABLE `almacena`
  ADD CONSTRAINT `almacena_ibfk_1` FOREIGN KEY (`idLote`) REFERENCES `lote` (`idLote`),
  ADD CONSTRAINT `almacena_ibfk_2` FOREIGN KEY (`idAlmacen`) REFERENCES `pertenece` (`idAlmacen`),
  ADD CONSTRAINT `almacena_ibfk_3` FOREIGN KEY (`idTrayecto`) REFERENCES `pertenece` (`idTrayecto`);

--
-- Filtros para la tabla `conduce`
--
ALTER TABLE `conduce`
  ADD CONSTRAINT `conduce_ibfk_1` FOREIGN KEY (`cedula`) REFERENCES `camionero` (`cedula`),
  ADD CONSTRAINT `conduce_ibfk_2` FOREIGN KEY (`matricula`) REFERENCES `vehiculo` (`matricula`);

--
-- Filtros para la tabla `esparte`
--
ALTER TABLE `esparte`
  ADD CONSTRAINT `es_Parte_ibfk_1` FOREIGN KEY (`idPaquete`) REFERENCES `paquete` (`idPaquete`),
  ADD CONSTRAINT `es_Parte_ibfk_2` FOREIGN KEY (`idLote`) REFERENCES `lote` (`idLote`);

--
-- Filtros para la tabla `lleva`
--
ALTER TABLE `lleva`
  ADD CONSTRAINT `lleva_ibfk_1` FOREIGN KEY (`matricula`) REFERENCES `camioneta` (`matricula`),
  ADD CONSTRAINT `lleva_ibfk_2` FOREIGN KEY (`idPaquete`) REFERENCES `paquete` (`idPaquete`);

--
-- Filtros para la tabla `pertenece`
--
ALTER TABLE `pertenece`
  ADD CONSTRAINT `pertenece_ibfk_1` FOREIGN KEY (`idTrayecto`) REFERENCES `trayecto` (`idTrayecto`),
  ADD CONSTRAINT `pertenece_ibfk_2` FOREIGN KEY (`idAlmacen`) REFERENCES `almacen` (`idAlmacen`);

--
-- Filtros para la tabla `tiene`
--
ALTER TABLE `tiene`
  ADD CONSTRAINT `tiene_ibfk_1` FOREIGN KEY (`matricula`) REFERENCES `camion` (`matricula`),
  ADD CONSTRAINT `tiene_ibfk_2` FOREIGN KEY (`idLote`) REFERENCES `almacena` (`idLote`),
  ADD CONSTRAINT `tiene_ibfk_3` FOREIGN KEY (`idTrayecto`) REFERENCES `almacena` (`idTrayecto`),
  ADD CONSTRAINT `tiene_ibfk_4` FOREIGN KEY (`idAlmacen`) REFERENCES `almacena` (`idAlmacen`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
