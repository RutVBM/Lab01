-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 05, 2024 at 10:27 PM
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
-- Database: `fitness center`
--

-- --------------------------------------------------------

--
-- Table structure for table `captacion_clientes`
--

CREATE TABLE `captacion_clientes` (
  `idcaptacion` int(11) NOT NULL,
  `idcliente` int(10) UNSIGNED NOT NULL,
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
(12, 123, 'VIP', 'José Navarro', '369852147', 'A', '2024-10-05 05:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `cliente`
--

CREATE TABLE `cliente` (
  `idcliente` int(11) UNSIGNED NOT NULL,
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
(3, 'J', 'La tuvi', 'DNI', '7894561', 'PUK', '4066176', 'latuvi@gmail.com', 'I', '2024-10-05'),
(6, 'M', 'V BNM', 'GFVBNHJM', 'GBHNJM', 'GYHUJMK', 'GBHNJM', 'GVBHNJKM@GMAIL.COM', 'A', '2024-10-05');

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
  `fecharegistro` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Dumping data for table `planes_entrenamiento`
--

INSERT INTO `planes_entrenamiento` (`idplan`, `tipo_plan`, `nombre_plan`, `duracion`, `precio`, `estado`, `fecharegistro`) VALUES
(1, 'Básico', 'FullBody', 12, 99, 'A', '2024-10-03 22:12:02');

-- --------------------------------------------------------

--
-- Table structure for table `reserva_entrenamientos`
--

CREATE TABLE `reserva_entrenamientos` (
  `idreserva` int(200) NOT NULL,
  `tipo_entrenamiento` enum('Grupal','Individual') DEFAULT NULL,
  `num_participantes` int(11) NOT NULL,
  `lugar` enum('Aire Libre','Instalaciones') NOT NULL,
  `fecha` date DEFAULT NULL,
  `hora` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Dumping data for table `reserva_entrenamientos`
--

INSERT INTO `reserva_entrenamientos` (`idreserva`, `tipo_entrenamiento`, `num_participantes`, `lugar`, `fecha`, `hora`) VALUES
(1, 'Grupal', 4, 'Aire Libre', '2024-10-02', '18:36:55'),
(2, 'Grupal', 12, 'Aire Libre', '2024-10-03', '15:46:00'),
(3, 'Individual', 0, 'Instalaciones', '2024-10-02', '16:20:00'),
(4, 'Individual', 0, 'Instalaciones', '2024-10-02', '16:20:00'),
(5, 'Individual', 0, 'Instalaciones', '2024-10-02', '16:20:00'),
(6, 'Individual', 0, 'Instalaciones', '2024-10-01', '16:34:00'),
(9, 'Grupal', 12, 'Instalaciones', '2024-10-07', '16:30:00');

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
-- Indexes for table `captacion_clientes`
--
ALTER TABLE `captacion_clientes`
  ADD PRIMARY KEY (`idcaptacion`);

--
-- Indexes for table `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`idcliente`);

--
-- Indexes for table `gestion_sanciones`
--
ALTER TABLE `gestion_sanciones`
  ADD PRIMARY KEY (`id_sancion`);

--
-- Indexes for table `planes_entrenamiento`
--
ALTER TABLE `planes_entrenamiento`
  ADD PRIMARY KEY (`idplan`);

--
-- Indexes for table `reserva_entrenamientos`
--
ALTER TABLE `reserva_entrenamientos`
  ADD PRIMARY KEY (`idreserva`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idusuario`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `captacion_clientes`
--
ALTER TABLE `captacion_clientes`
  MODIFY `idcaptacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `cliente`
--
ALTER TABLE `cliente`
  MODIFY `idcliente` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `gestion_sanciones`
--
ALTER TABLE `gestion_sanciones`
  MODIFY `id_sancion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `planes_entrenamiento`
--
ALTER TABLE `planes_entrenamiento`
  MODIFY `idplan` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `reserva_entrenamientos`
--
ALTER TABLE `reserva_entrenamientos`
  MODIFY `idreserva` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idusuario` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
