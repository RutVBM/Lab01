-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 11, 2024 at 03:14 AM
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
(12, 123, 'Individual', 'José Navarro', '369852144', 'A', '2024-10-05 05:00:00'),
(13, 0, 'Individual', 'VIVIANA', '12345678', 'A', '2024-11-07 01:27:41'),
(14, 0, 'Corporativo', 'Grupo Intercorp', '12345678', 'A', '2024-11-07 02:02:53');

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
(7, 'N', 'José Luis', 'DNI', '72345982', 'PUK', '12345678', 'jose.luis@gmail.com', 'A', '2024-10-26'),
(8, 'N', 'Luis Ortega', 'DNI', '76043201', 'Las orquideas', '5387662', 'luis.ortega@gmail.com', 'A', '2024-11-06');

-- --------------------------------------------------------

--
-- Table structure for table `compra_insumos`
--

CREATE TABLE `compra_insumos` (
  `id_compra` int(11) NOT NULL,
  `id_proveedor` int(11) NOT NULL,
  `nombre_insumo` varchar(100) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL,
  `fecha_pedido` date NOT NULL,
  `fecha_recepcion` date DEFAULT NULL,
  `estado` enum('Pendiente','Recibido','Cancelado') DEFAULT 'Pendiente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Dumping data for table `compra_insumos`
--

INSERT INTO `compra_insumos` (`id_compra`, `id_proveedor`, `nombre_insumo`, `cantidad`, `precio_unitario`, `fecha_pedido`, `fecha_recepcion`, `estado`) VALUES
(6, 1, 'Bicicleta Estática', 10, 1200.50, '2024-10-01', '2024-10-29', 'Pendiente'),
(7, 2, 'Caminadora Eléctrica', 5, 3200.00, '2024-09-25', '2024-10-10', 'Recibido'),
(8, 3, 'Proteína Whey 1kg', 50, 150.00, '2024-09-28', NULL, 'Pendiente'),
(9, 4, 'Mancuernas 10kg', 20, 100.00, '2024-10-05', NULL, 'Pendiente'),
(10, 3, 'Creatina 500g', 30, 80.00, '2024-09-30', '2024-10-08', 'Recibido'),
(11, 4, 'Pesas', 22, 20.00, '2024-10-28', NULL, 'Pendiente'),
(12, 4, 'Pesas', 22, 20.00, '2024-10-28', NULL, 'Pendiente'),
(13, 4, 'Pesas', 22, 20.00, '2024-10-28', NULL, 'Pendiente');

-- --------------------------------------------------------

--
-- Table structure for table `contratos_locales`
--

CREATE TABLE `contratos_locales` (
  `idContratos_locales` int(11) NOT NULL,
  `nombre_local` varchar(50) DEFAULT NULL,
  `direccion` varchar(50) DEFAULT NULL,
  `telefono_contacto` varchar(50) DEFAULT NULL,
  `Finicio_contrato_local` date DEFAULT NULL,
  `Ffin_contrato_local` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Dumping data for table `contratos_locales`
--

INSERT INTO `contratos_locales` (`idContratos_locales`, `nombre_local`, `direccion`, `telefono_contacto`, `Finicio_contrato_local`, `Ffin_contrato_local`) VALUES
(101, 'Gimnasio Central', 'Av. Principal 123', '987654321', '2024-01-01', '2025-01-01'),
(237, 'Fitness Club', 'Calle Secundaria 456', '912345678', '2024-02-15', '2025-02-15'),
(289, 'Centro Funcional', 'Av. Vitalidad 707', '990123456', '2024-10-05', '2025-10-05'),
(359, 'Centro Deportivo', 'Av. Los Deportes 789', '923456789', '2024-03-01', '2025-03-01'),
(482, 'Wellness Center', 'Av. Bienestar 101', '934567890', '2024-04-10', '2025-04-10'),
(519, 'Sala de Yoga', 'Calle Tranquila 202', '945678901', '2024-05-05', '2025-05-05'),
(628, 'CrossFit Zone', 'Av. Fuerza 303', '956789012', '2024-06-20', '2025-06-20'),
(749, 'Pilates Studio', 'Calle Armonía 404', '967890123', '2024-07-15', '2025-07-15'),
(857, 'Club Natación', 'Av. Las Aguas 505', '978901234', '2024-08-01', '2025-08-01'),
(963, 'Spa Relax', 'Calle Paz 606', '989012345', '2024-09-10', '2025-09-10');

-- --------------------------------------------------------

--
-- Table structure for table `contrato_personal`
--

CREATE TABLE `contrato_personal` (
  `idContratos_personal` int(11) NOT NULL,
  `nombre_personal` varchar(50) DEFAULT NULL,
  `DNI_personal` varchar(50) DEFAULT NULL,
  `telefono` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `Finicio_contrato_per` date DEFAULT NULL,
  `Ffin_contrato_per` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Dumping data for table `contrato_personal`
--

INSERT INTO `contrato_personal` (`idContratos_personal`, `nombre_personal`, `DNI_personal`, `telefono`, `email`, `Finicio_contrato_per`, `Ffin_contrato_per`) VALUES
(101, 'Laura Martínez', '45678901', '987654324', 'lauramartinez@example.com', '2024-04-01', '2025-04-01'),
(123, 'Juan Pérez', '12345678', '987654321', 'juanperez@example.com', '2024-01-01', '2025-01-01'),
(202, 'Pedro Sánchez', '56789012', '987654325', 'pedrosanchez@example.com', '2024-05-01', '2025-05-01'),
(303, 'Ana Gómez', '67890123', '987654326', 'anagomez@example.com', '2024-06-01', '2025-06-01'),
(404, 'Javier Ruiz', '78901234', '987654327', 'javierruiz@example.com', '2024-07-01', '2025-07-01'),
(456, 'María López', '23456789', '987654322', 'marialopez@example.com', '2024-02-01', '2025-02-01'),
(505, 'Elena Fernández', '89012345', '987654328', 'elenafdez@example.com', '2024-08-01', '2025-08-01'),
(606, 'David Rodríguez', '90123456', '987654329', 'davidrodriguez@example.com', '2024-09-01', '2025-09-01'),
(707, 'Sara Martínez', '01234567', '987654330', 'saramartinez@example.com', '2024-10-01', '2025-10-01'),
(789, 'Carlos García', '34567890', '987654323', 'carlosgarcia@example.com', '2024-03-01', '2025-03-01');

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
(2, 8, 'Rut', 1, '', '2024-10-27 05:00:00'),
(1, 12, 'Rut', 3, '', '2024-11-07 05:00:00'),
(2, 13, 'Fred Pastor', 1, '', '2024-11-07 05:00:00'),
(2, 14, 'Fred Pastor', 1, '', '2024-11-07 05:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `inventario`
--

CREATE TABLE `inventario` (
  `id_inventario` int(11) NOT NULL,
  `nombre_material_producto` varchar(100) NOT NULL,
  `tipo` enum('Material','Producto') NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `cantidad` int(11) NOT NULL,
  `stock_minimo` int(11) NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL,
  `id_proveedor` int(11) DEFAULT NULL,
  `estado` enum('Activo','Inactivo') DEFAULT 'Activo',
  `fecha_registro` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Dumping data for table `inventario`
--

INSERT INTO `inventario` (`id_inventario`, `nombre_material_producto`, `tipo`, `descripcion`, `cantidad`, `stock_minimo`, `precio_unitario`, `id_proveedor`, `estado`, `fecha_registro`) VALUES
(1, 'Colchoneta de yoga', 'Producto', 'Colchoneta antideslizante para clases de yoga', 50, 10, 25.00, 1, 'Activo', '2024-01-10'),
(2, 'Pesas de 5kg', 'Producto', 'Pesas de mano de 5kg para musculación', 30, 15, 18.00, 2, 'Activo', '2024-01-10'),
(3, 'Gel desinfectante', 'Material', 'Gel antibacterial para limpieza de equipos', 100, 20, 5.50, 3, 'Activo', '2024-01-10'),
(4, 'Cinta de resistencia', 'Producto', 'Cinta elástica de resistencia para entrenamiento', 20, 7, 12.00, 2, 'Activo', '2024-01-10'),
(5, 'Cloro', 'Material', 'Cloro para limpieza de áreas comunes', 80, 30, 4.50, 4, 'Activo', '2024-01-10'),
(6, 'pesas', 'Material', '...', 20, 0, 20.00, 1, 'Activo', '2024-10-27');

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
  `precio` int(4) DEFAULT NULL,
  `estado` varchar(1) NOT NULL DEFAULT 'A',
  `fecharegistro` datetime NOT NULL DEFAULT current_timestamp(),
  `idcliente` int(11) NOT NULL,
  `metodo_pago` enum('Pago Efectivo','Tarjeta') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Dumping data for table `planes_entrenamiento`
--

INSERT INTO `planes_entrenamiento` (`idplan`, `tipo_plan`, `nombre_plan`, `duracion`, `precio`, `estado`, `fecharegistro`, `idcliente`, `metodo_pago`) VALUES
(5, 'Grupal', 'Rut-Ina', 20, 85, 'A', '2024-10-25 00:00:00', 0, 'Pago Efectivo'),
(6, 'Individual', 'Aeróbicos', 10, 100, 'A', '2024-11-06 00:00:00', 0, 'Pago Efectivo'),
(8, 'Individual', 'Bailes', 12, 590, 'A', '2024-11-09 00:00:00', 0, 'Pago Efectivo');

-- --------------------------------------------------------

--
-- Table structure for table `proveedor`
--

CREATE TABLE `proveedor` (
  `id_proveedor` int(11) NOT NULL,
  `nombre_proveedor` varchar(100) NOT NULL,
  `ruc` varchar(20) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `estado` enum('A','I') DEFAULT 'A'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Dumping data for table `proveedor`
--

INSERT INTO `proveedor` (`id_proveedor`, `nombre_proveedor`, `ruc`, `direccion`, `telefono`, `correo`, `estado`) VALUES
(1, 'ProSports S.A.C.', '20546789231', 'Av. El Derby 150, Santiago de Surco', '016789234', 'ventas@prosports.com.pe', 'A'),
(2, 'Gym Equipment Perú', '20667893456', 'Calle La Mar 1120, Miraflores', '015678900', 'info@gym-equipment.pe', 'A'),
(3, 'NutriFit S.A.C.', '20578934567', 'Av. Primavera 987, San Borja', '015632145', 'contacto@nutrifit.pe', 'A'),
(4, 'Mega Fitness S.A.', '20678923455', 'Av. San Luis 2300, La Victoria', '014589002', 'ventas@megafitness.com.pe', 'A'),
(5, 'Industrias Deportivas S.A.', '20598347213', 'Calle Comercio 456, Lince', '014587123', 'proveedores@industriasdeportivas.pe', 'I');

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
  `id_cliente` text NOT NULL,
  `detalle_solucion` text NOT NULL,
  `nombre` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reclamos`
--

INSERT INTO `reclamos` (`id_reclamo`, `tipo`, `detalle`, `fecha_reclamo`, `estado_reclamo`, `fecha_solucion`, `id_cliente`, `detalle_solucion`, `nombre`) VALUES
(25, 'Reclamo', 'Tengo un reclamo', '2024-11-09', '', '2024-11-10', 'rut.benites@gmail.com', 'Se ha atendido correctamente su reclamo', 'Rut ');

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
  `idcliente` text NOT NULL,
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
(13, 'rut.benites@gmail.com', 'Rut ', '2024-11-09', 'Individual', 1, 'Instalaciones'),
(14, 'rut.benites@gmail.com', 'Rut Benites', '2024-11-12', 'Individual', 1, 'Instalaciones');

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
(2, 'Rut', 'Benites', '2014-10-09', 'rut.benites@gmail.com', '123456', 'A', '2024-10-04 03:12:57.303827'),
(3, 'José Luis', 'Rodriguez', '2024-11-10', 'jose.luis@gmail.com', '58623', 'A', '2024-11-11 05:00:00.000000'),
(4, 'Luis ', 'Ortega', '2024-11-10', 'luis.ortega@gmail.com', '293206528', 'A', '2024-11-11 05:00:00.000000');

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
-- Indexes for table `compra_insumos`
--
ALTER TABLE `compra_insumos`
  ADD PRIMARY KEY (`id_compra`),
  ADD KEY `id_proveedor` (`id_proveedor`);

--
-- Indexes for table `contratos_locales`
--
ALTER TABLE `contratos_locales`
  ADD PRIMARY KEY (`idContratos_locales`);

--
-- Indexes for table `contrato_personal`
--
ALTER TABLE `contrato_personal`
  ADD PRIMARY KEY (`idContratos_personal`);

--
-- Indexes for table `gestion_sanciones`
--
ALTER TABLE `gestion_sanciones`
  ADD PRIMARY KEY (`id_sancion`),
  ADD KEY `idcliente` (`idcliente`);

--
-- Indexes for table `inventario`
--
ALTER TABLE `inventario`
  ADD PRIMARY KEY (`id_inventario`),
  ADD KEY `id_proveedor` (`id_proveedor`);

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
-- Indexes for table `proveedor`
--
ALTER TABLE `proveedor`
  ADD PRIMARY KEY (`id_proveedor`);

--
-- Indexes for table `reclamos`
--
ALTER TABLE `reclamos`
  ADD PRIMARY KEY (`id_reclamo`),
  ADD KEY `id_cliente` (`id_cliente`(768));

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
  ADD KEY `idcliente` (`idcliente`(768));

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
  MODIFY `idcaptacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `cliente`
--
ALTER TABLE `cliente`
  MODIFY `idcliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `compra_insumos`
--
ALTER TABLE `compra_insumos`
  MODIFY `id_compra` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `gestion_sanciones`
--
ALTER TABLE `gestion_sanciones`
  MODIFY `id_sancion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `inventario`
--
ALTER TABLE `inventario`
  MODIFY `id_inventario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `pago_clientes`
--
ALTER TABLE `pago_clientes`
  MODIFY `id_pago` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `planes_entrenamiento`
--
ALTER TABLE `planes_entrenamiento`
  MODIFY `idplan` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `proveedor`
--
ALTER TABLE `proveedor`
  MODIFY `id_proveedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `reclamos`
--
ALTER TABLE `reclamos`
  MODIFY `id_reclamo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `reporte_gestion`
--
ALTER TABLE `reporte_gestion`
  MODIFY `id_reporte_gestion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reserva_entrenamientos`
--
ALTER TABLE `reserva_entrenamientos`
  MODIFY `idreserva` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idusuario` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `atencion_reclamos`
--
ALTER TABLE `atencion_reclamos`
  ADD CONSTRAINT `atencion_reclamos_ibfk_1` FOREIGN KEY (`idcliente`) REFERENCES `cliente` (`idcliente`);

--
-- Constraints for table `compra_insumos`
--
ALTER TABLE `compra_insumos`
  ADD CONSTRAINT `compra_insumos_ibfk_1` FOREIGN KEY (`id_proveedor`) REFERENCES `proveedor` (`id_proveedor`);

--
-- Constraints for table `gestion_sanciones`
--
ALTER TABLE `gestion_sanciones`
  ADD CONSTRAINT `gestion_sanciones_ibfk_1` FOREIGN KEY (`idcliente`) REFERENCES `cliente` (`idcliente`);

--
-- Constraints for table `inventario`
--
ALTER TABLE `inventario`
  ADD CONSTRAINT `inventario_ibfk_1` FOREIGN KEY (`id_proveedor`) REFERENCES `proveedor` (`id_proveedor`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
