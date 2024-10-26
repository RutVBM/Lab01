-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 26-10-2024 a las 07:29:59
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `fitness center`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `atencion_reclamos`
--

CREATE TABLE `atencion_reclamos` (
  `idreclamo` int(11) NOT NULL,
  `idcliente` int(11) NOT NULL,
  `nombre_cliente` varchar(255) NOT NULL,
  `descripcion` text NOT NULL,
  `estado` enum('Pendiente','Resuelto','','') NOT NULL DEFAULT 'Pendiente',
  `fecha_reclamo` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `captacion_clientes`
--

CREATE TABLE `captacion_clientes` (
  `idcaptacion` int(11) NOT NULL,
  `idcliente` int(11) NOT NULL,
  `tipo_cliente` enum('Individual','Corporativo','VIP','Familiar','Estudiante') NOT NULL,
  `nombre_cliente` varchar(255) NOT NULL,
  `contacto` varchar(255) NOT NULL,
  `estado` varchar(1) NOT NULL DEFAULT 'A',
  `fecha_captacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `captacion_clientes`
--

INSERT INTO `captacion_clientes` (`idcaptacion`, `idcliente`, `tipo_cliente`, `nombre_cliente`, `contacto`, `estado`, `fecha_captacion`) VALUES
(12, 123, 'Individual', 'José Navarro', '369852144', 'A', '2024-10-05 05:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `idcliente` int(11) NOT NULL,
  `tipopersona` varchar(1) NOT NULL DEFAULT 'J',
  `nombre` varchar(100) DEFAULT NULL,
  `tipodocumento` varchar(30) NOT NULL,
  `numdocumento` varchar(8) DEFAULT NULL,
  `direccion` varchar(1200) DEFAULT NULL,
  `telefono` varchar(9) DEFAULT NULL,
  `correo` varchar(1200) NOT NULL,
  `estado` varchar(1) NOT NULL DEFAULT 'A',
  `fechregistro` date DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`idcliente`, `tipopersona`, `nombre`, `tipodocumento`, `numdocumento`, `direccion`, `telefono`, `correo`, `estado`, `fechregistro`) VALUES
(1, 'J', 'Dominique ', 'DNI', '73091158', 'Terre 187', '129845754', 'pollofrito@gmail.com', 'A', '2024-10-03'),
(2, 'N', 'Rut', 'DNI', '71404985', 'Los Cayetanitos', '12345678', 'rut.benites@gmail.com', 'A', '2024-10-05'),
(3, 'J', 'La tuvi', 'DNI', '7894561', 'PUK', '4066176', 'latuvi@gmail.com', 'I', '2024-10-05'),
(6, 'M', 'V BNM', 'GFVBNHJM', 'GBHNJM', 'GYHUJMK', 'GBHNJM', 'GVBHNJKM@GMAIL.COM', 'A', '2024-10-05');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gestion_sanciones`
--

CREATE TABLE `gestion_sanciones` (
  `idcliente` int(11) NOT NULL,
  `id_sancion` int(11) NOT NULL,
  `nombre_cliente` varchar(255) NOT NULL,
  `faltas` int(11) NOT NULL DEFAULT 0,
  `estado` enum('A','B','I','') NOT NULL DEFAULT 'A',
  `fecha_sancion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `planes_entrenamiento`
--

CREATE TABLE `planes_entrenamiento` (
  `idplan` int(100) NOT NULL,
  `tipo_plan` varchar(100) NOT NULL DEFAULT '',
  `nombre_plan` varchar(100) NOT NULL,
  `duracion` int(50) NOT NULL,
  `precio` decimal(2,0) DEFAULT NULL,
  `estado` varchar(1) NOT NULL DEFAULT 'A',
  `fecharegistro` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `planes_entrenamiento`
--

INSERT INTO `planes_entrenamiento` (`idplan`, `tipo_plan`, `nombre_plan`, `duracion`, `precio`, `estado`, `fecharegistro`) VALUES
(1, 'Básico', 'FullBody', 12, 99, 'I', '2024-10-03 22:12:02'),
(4, 'Grupal', 'Tonificador', 12, 99, 'A', '2024-10-25 00:00:00'),
(5, 'Grupal', 'Rut-Ina', 20, 85, 'A', '2024-10-25 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reporte_gestion`
--

CREATE TABLE `reporte_gestion` (
  `id_reporte_gestion` int(11) NOT NULL,
  `fecha_generacion` datetime NOT NULL,
  `tipo_reporte` varchar(50) NOT NULL,
  `cantidad_reclamos` int(11) NOT NULL,
  `cantidad_sanciones` int(11) NOT NULL,
  `tiempo_promedio_resolucion` int(11) NOT NULL,
  `satisfaccion_cliente` int(11) NOT NULL,
  `observaciones` text NOT NULL,
  `idusuario` int(11) NOT NULL,
  `idreclamo` int(11) NOT NULL,
  `id_sancion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reserva_entrenamientos`
--

CREATE TABLE `reserva_entrenamientos` (
  `idreserva` int(11) NOT NULL,
  `idcliente` int(11) NOT NULL,
  `nombre_cliente` varchar(255) NOT NULL,
  `fecha_reserva` date DEFAULT NULL,
  `tipo_entrenamiento` enum('Grupal','Individual','','') NOT NULL,
  `num_participantes` int(2) NOT NULL,
  `lugar_entrenamiento` enum('Aire Libre','Instalaciones','','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `reserva_entrenamientos`
--

INSERT INTO `reserva_entrenamientos` (`idreserva`, `idcliente`, `nombre_cliente`, `fecha_reserva`, `tipo_entrenamiento`, `num_participantes`, `lugar_entrenamiento`) VALUES
(2, 0, 'Amiguito', '2024-07-11', 'Individual', 1, 'Aire Libre');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `idusuario` int(6) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `apellidos` varchar(30) DEFAULT NULL,
  `fechnac` date DEFAULT NULL,
  `correo` varchar(1200) DEFAULT NULL,
  `clave` varchar(100) DEFAULT NULL,
  `estado` char(1) NOT NULL DEFAULT 'A',
  `fechregistro` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idusuario`, `nombre`, `apellidos`, `fechnac`, `correo`, `clave`, `estado`, `fechregistro`) VALUES
(1, 'Adriana', 'Pastor', '2014-10-11', 'adriana.pastor@gmail.com', '1416', 'A', '0000-00-00 00:00:00.000000'),
(2, 'Rut', 'Benites', '2014-10-09', 'rut.benites@gmail.com', '123456', 'A', '2024-10-04 03:12:57.303827');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `atencion_reclamos`
--
ALTER TABLE `atencion_reclamos`
  ADD PRIMARY KEY (`idreclamo`),
  ADD KEY `idcliente` (`idcliente`);

--
-- Indices de la tabla `captacion_clientes`
--
ALTER TABLE `captacion_clientes`
  ADD PRIMARY KEY (`idcaptacion`),
  ADD KEY `idcliente` (`idcliente`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`idcliente`);

--
-- Indices de la tabla `gestion_sanciones`
--
ALTER TABLE `gestion_sanciones`
  ADD PRIMARY KEY (`id_sancion`),
  ADD KEY `idcliente` (`idcliente`);

--
-- Indices de la tabla `planes_entrenamiento`
--
ALTER TABLE `planes_entrenamiento`
  ADD PRIMARY KEY (`idplan`);

--
-- Indices de la tabla `reporte_gestion`
--
ALTER TABLE `reporte_gestion`
  ADD PRIMARY KEY (`id_reporte_gestion`),
  ADD KEY `idusuario` (`idusuario`),
  ADD KEY `idreclamo` (`idreclamo`,`id_sancion`);

--
-- Indices de la tabla `reserva_entrenamientos`
--
ALTER TABLE `reserva_entrenamientos`
  ADD PRIMARY KEY (`idreserva`),
  ADD KEY `idcliente` (`idcliente`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idusuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `atencion_reclamos`
--
ALTER TABLE `atencion_reclamos`
  MODIFY `idreclamo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `captacion_clientes`
--
ALTER TABLE `captacion_clientes`
  MODIFY `idcaptacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `idcliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `gestion_sanciones`
--
ALTER TABLE `gestion_sanciones`
  MODIFY `id_sancion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `planes_entrenamiento`
--
ALTER TABLE `planes_entrenamiento`
  MODIFY `idplan` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `reporte_gestion`
--
ALTER TABLE `reporte_gestion`
  MODIFY `id_reporte_gestion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `reserva_entrenamientos`
--
ALTER TABLE `reserva_entrenamientos`
  MODIFY `idreserva` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idusuario` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `atencion_reclamos`
--
ALTER TABLE `atencion_reclamos`
  ADD CONSTRAINT `atencion_reclamos_ibfk_1` FOREIGN KEY (`idcliente`) REFERENCES `cliente` (`idcliente`);

--
-- Filtros para la tabla `gestion_sanciones`
--
ALTER TABLE `gestion_sanciones`
  ADD CONSTRAINT `gestion_sanciones_ibfk_1` FOREIGN KEY (`idcliente`) REFERENCES `cliente` (`idcliente`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
