-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 27, 2024 at 06:00 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fitness_center`
--

-- --------------------------------------------------------

--
-- Table structure for table `atencion_reclamos`
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
-- Table structure for table `captacion_clientes`
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
-- Dumping data for table `captacion_clientes`
--

INSERT INTO `captacion_clientes` (`idcaptacion`, `idcliente`, `tipo_cliente`, `nombre_cliente`, `contacto`, `estado`, `fecha_captacion`) VALUES
(12, 123, 'Individual', 'José Navarro', '369852144', 'A', '2024-10-05 05:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `cliente`
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
-- Dumping data for table `cliente`
--

INSERT INTO `cliente` (`idcliente`, `tipopersona`, `nombre`, `tipodocumento`, `numdocumento`, `direccion`, `telefono`, `correo`, `estado`, `fechregistro`) VALUES
(1, 'J', 'Dominique ', 'DNI', '73091158', 'Terre 187', '129845754', 'pollofrito@gmail.com', 'A', '2024-10-03'),
(2, 'N', 'Rut', 'DNI', '71404985', 'Los Cayetanitos', '12345678', 'rut.benites@gmail.com', 'A', '2024-10-05'),
(7, 'N', 'José Luis', 'DNI', '72345982', 'PUK', '12345678', 'jose.luis@gmail.com', 'A', '2024-10-26');

-- --------------------------------------------------------

--
-- Table structure for table `gestion_sanciones`
--

CREATE TABLE `gestion_sanciones` (
  `idcliente` int(11) NOT NULL,
  `id_sancion` int(11) NOT NULL,
  `nombre_cliente` varchar(255) NOT NULL,
  `faltas` int(11) NOT NULL DEFAULT 0,
  `estado` enum('A','B','I','') NOT NULL DEFAULT 'A',
  `fecha_sancion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Dumping data for table `gestion_sanciones`
--

INSERT INTO `gestion_sanciones` (`idcliente`, `id_sancion`, `nombre_cliente`, `faltas`, `estado`, `fecha_sancion`) VALUES
(1, 7, 'VIVIANA', 3, 'A', '2024-10-27 05:00:00'),
(2, 8, 'Rut', 1, '', '2024-10-27 05:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `pago_clientes`
--

CREATE TABLE `pago_clientes` (
  `id_pago` int(11) NOT NULL,
  `tipo_plan` varchar(50) NOT NULL,
  `nombre_plan` varchar(255) DEFAULT NULL,
  `duracion` int(11) NOT NULL,
  `precio` int(11) NOT NULL,
  `metodo_pago` varchar(50) NOT NULL,
  `fecha_pago` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pago_clientes`
--

INSERT INTO `pago_clientes` (`id_pago`, `tipo_plan`, `nombre_plan`, `duracion`, `precio`, `metodo_pago`, `fecha_pago`) VALUES
(1, 'grupal', '4', 12, 99, 'transferencia', '2024-10-26'),
(2, 'grupal', '1', 12, 99, 'efectivo', '2024-10-26');

-- --------------------------------------------------------

--
-- Table structure for table `planes_entrenamiento`
--

CREATE TABLE `planes_entrenamiento` (
  `idplan` int(100) NOT NULL,
  `tipo_plan` varchar(100) NOT NULL DEFAULT '',
  `nombre_plan` varchar(100) NOT NULL,
  `duracion` int(50) NOT NULL,
  `precio` decimal(2,0) DEFAULT NULL,
  `estado` varchar(1) NOT NULL DEFAULT 'A',
  `fecharegistro` datetime NOT NULL DEFAULT current_timestamp(),
  `idcliente` int(11) NOT NULL,
  `metodo_pago` enum('Pago Efectivo','Tarjeta') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Dumping data for table `planes_entrenamiento`
--

INSERT INTO `planes_entrenamiento` (`idplan`, `tipo_plan`, `nombre_plan`, `duracion`, `precio`, `estado`, `fecharegistro`, `idcliente`, `metodo_pago`) VALUES
(1, 'Básico', 'FullBody', 12, 99, 'A', '2024-10-03 22:12:02', 0, 'Pago Efectivo'),
(4, 'Grupal', 'Tonificador', 12, 99, 'A', '2024-10-25 00:00:00', 0, 'Pago Efectivo'),
(5, 'Grupal', 'Rut-Ina', 20, 85, 'A', '2024-10-25 00:00:00', 0, 'Pago Efectivo');

-- --------------------------------------------------------

--
-- Table structure for table `reclamos`
--

CREATE TABLE `reclamos` (
  `id_reclamo` int(11) NOT NULL,
  `tipo` enum('Consulta','Reclamo') NOT NULL,
  `detalle` text NOT NULL,
  `fecha_reclamo` date NOT NULL,
  `estado_reclamo` enum('R','E') NOT NULL,
  `fecha_solucion` date NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `detalle_solucion` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reclamos`
--

INSERT INTO `reclamos` (`id_reclamo`, `tipo`, `detalle`, `fecha_reclamo`, `estado_reclamo`, `fecha_solucion`, `id_cliente`, `detalle_solucion`) VALUES
(8, 'Reclamo', 'Holaaa', '2024-10-26', '', '2024-10-26', 4, ''),
(11, 'Reclamo', 'Tengo un reclamo, ya que no se presento el entrenador a la hora pactada', '2024-10-26', '', '2024-10-26', 3, 'Reclamo atendido'),
(12, 'Consulta', 'CONSULTA', '2024-10-26', 'R', '0000-00-00', 12, ''),
(15, 'Reclamo', 'RECLAMO52', '2024-10-26', 'R', '0000-00-00', 52, '');

-- --------------------------------------------------------

--
-- Table structure for table `reporte_gestion`
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
-- Table structure for table `reserva_entrenamientos`
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
-- Dumping data for table `reserva_entrenamientos`
--

INSERT INTO `reserva_entrenamientos` (`idreserva`, `idcliente`, `nombre_cliente`, `fecha_reserva`, `tipo_entrenamiento`, `num_participantes`, `lugar_entrenamiento`) VALUES
(2, 0, 'Amiguito', '2024-07-11', 'Individual', 1, 'Aire Libre'),
(3, 0, 'Rut', '2024-10-26', 'Grupal', 3, 'Aire Libre');

-- --------------------------------------------------------

--
-- Table structure for table `usuario`
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
-- Dumping data for table `usuario`
--

INSERT INTO `usuario` (`idusuario`, `nombre`, `apellidos`, `fechnac`, `correo`, `clave`, `estado`, `fechregistro`) VALUES
(1, 'Adriana', 'Pastor', '2014-10-11', 'adriana.pastor@gmail.com', '1416', 'A', '0000-00-00 00:00:00.000000'),
(2, 'Rut', 'Benites', '2014-10-09', 'rut.benites@gmail.com', '123456', 'A', '2024-10-04 03:12:57.303827');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `atencion_reclamos`
--
ALTER TABLE `atencion_reclamos`
  ADD PRIMARY KEY (`idreclamo`),
  ADD KEY `idcliente` (`idcliente`);

--
-- Indexes for table `captacion_clientes`
--
ALTER TABLE `captacion_clientes`
  ADD PRIMARY KEY (`idcaptacion`),
  ADD KEY `idcliente` (`idcliente`);

--
-- Indexes for table `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`idcliente`);

--
-- Indexes for table `gestion_sanciones`
--
ALTER TABLE `gestion_sanciones`
  ADD PRIMARY KEY (`id_sancion`),
  ADD KEY `idcliente` (`idcliente`);

--
-- Indexes for table `pago_clientes`
--
ALTER TABLE `pago_clientes`
  ADD PRIMARY KEY (`id_pago`);

--
-- Indexes for table `planes_entrenamiento`
--
ALTER TABLE `planes_entrenamiento`
  ADD PRIMARY KEY (`idplan`),
  ADD KEY `idcliente` (`idcliente`);

--
-- Indexes for table `reclamos`
--
ALTER TABLE `reclamos`
  ADD PRIMARY KEY (`id_reclamo`),
  ADD KEY `id_cliente` (`id_cliente`);

--
-- Indexes for table `reporte_gestion`
--
ALTER TABLE `reporte_gestion`
  ADD PRIMARY KEY (`id_reporte_gestion`),
  ADD KEY `idusuario` (`idusuario`),
  ADD KEY `idreclamo` (`idreclamo`,`id_sancion`);

--
-- Indexes for table `reserva_entrenamientos`
--
ALTER TABLE `reserva_entrenamientos`
  ADD PRIMARY KEY (`idreserva`),
  ADD KEY `idcliente` (`idcliente`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idusuario`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `atencion_reclamos`
--
ALTER TABLE `atencion_reclamos`
  MODIFY `idreclamo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `captacion_clientes`
--
ALTER TABLE `captacion_clientes`
  MODIFY `idcaptacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `cliente`
--
ALTER TABLE `cliente`
  MODIFY `idcliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `gestion_sanciones`
--
ALTER TABLE `gestion_sanciones`
  MODIFY `id_sancion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `pago_clientes`
--
ALTER TABLE `pago_clientes`
  MODIFY `id_pago` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `planes_entrenamiento`
--
ALTER TABLE `planes_entrenamiento`
  MODIFY `idplan` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `reclamos`
--
ALTER TABLE `reclamos`
  MODIFY `id_reclamo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `reporte_gestion`
--
ALTER TABLE `reporte_gestion`
  MODIFY `id_reporte_gestion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reserva_entrenamientos`
--
ALTER TABLE `reserva_entrenamientos`
  MODIFY `idreserva` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idusuario` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `atencion_reclamos`
--
ALTER TABLE `atencion_reclamos`
  ADD CONSTRAINT `atencion_reclamos_ibfk_1` FOREIGN KEY (`idcliente`) REFERENCES `cliente` (`idcliente`);

--
-- Constraints for table `gestion_sanciones`
--
ALTER TABLE `gestion_sanciones`
  ADD CONSTRAINT `gestion_sanciones_ibfk_1` FOREIGN KEY (`idcliente`) REFERENCES `cliente` (`idcliente`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
