-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 29, 2024 at 05:31 AM
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
(8, 3, 'Proteína Whey 1kg', 10, 150.00, '2024-09-28', '0000-00-00', 'Pendiente'),
(9, 4, 'Mancuernas 10kg', 20, 100.00, '2024-10-05', NULL, 'Pendiente'),
(10, 3, 'Creatina 500g', 19, 80.00, '2024-09-30', '2024-10-08', 'Recibido'),
(12, 4, 'Pesas', 22, 20.00, '2024-10-28', NULL, 'Pendiente');

-- --------------------------------------------------------

--
-- Table structure for table `contratos_locales`
--

CREATE TABLE `contratos_locales` (
  `id_contratacion_local` int(11) NOT NULL,
  `id_local` int(50) DEFAULT NULL,
  `id_dia` int(11) NOT NULL,
  `hora_inicio` time DEFAULT NULL,
  `hora_fin` time DEFAULT NULL,
  `estado` enum('Activo','Inactivo') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Dumping data for table `contratos_locales`
--

INSERT INTO `contratos_locales` (`id_contratacion_local`, `id_local`, `id_dia`, `hora_inicio`, `hora_fin`, `estado`) VALUES
(1, 1, 0, '15:00:00', '21:00:00', 'Activo'),
(101, 0, 0, '00:00:00', '00:00:00', ''),
(102, 1, 3, '22:00:00', '23:00:00', 'Activo');

-- --------------------------------------------------------

--
-- Table structure for table `contrato_personal`
--

CREATE TABLE `contrato_personal` (
  `id_contrato` int(11) NOT NULL,
  `nombre_entrenador` varchar(100) DEFAULT NULL,
  `telefono` int(11) DEFAULT NULL,
  `salario` decimal(10,0) DEFAULT NULL,
  `estado` enum('Activo','Inactivo') DEFAULT NULL,
  `dias_disponibles` varchar(255) NOT NULL,
  `hora_inicio` time NOT NULL,
  `hora_fin` time NOT NULL,
  `tipo_entrenamiento` enum('Grupal','Individual') NOT NULL,
  `capacidad` int(11) NOT NULL,
  `especialidad` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Dumping data for table `contrato_personal`
--

INSERT INTO `contrato_personal` (`id_contrato`, `nombre_entrenador`, `telefono`, `salario`, `estado`, `dias_disponibles`, `hora_inicio`, `hora_fin`, `tipo_entrenamiento`, `capacidad`, `especialidad`) VALUES
(709, 'Mario Vargas', 12345678, 80, 'Activo', '2', '14:00:00', '16:00:00', 'Grupal', 4, 'Yoga'),
(710, 'Stefany Catro', 458330112, 100, 'Activo', '4,5', '14:00:00', '18:00:00', 'Individual', 1, 'Baile'),
(711, 'Rut Benites', 4066176, 96, 'Activo', '1', '19:11:00', '20:24:00', 'Grupal', 10, 'Yoga');

-- --------------------------------------------------------

--
-- Table structure for table `dias_disponibles`
--

CREATE TABLE `dias_disponibles` (
  `id_dia` int(11) NOT NULL,
  `dia` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dias_disponibles`
--

INSERT INTO `dias_disponibles` (`id_dia`, `dia`) VALUES
(1, 'Lunes'),
(2, 'Martes'),
(3, 'Miercoles'),
(4, 'Jueves'),
(5, 'Viernes'),
(6, 'Sabado'),
(7, 'Domingo');

-- --------------------------------------------------------

--
-- Table structure for table `entrenadores`
--

CREATE TABLE `entrenadores` (
  `id_entrenador` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `especialidad` varchar(255) NOT NULL,
  `max_personas` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `entrenador_dias_horarios`
--

CREATE TABLE `entrenador_dias_horarios` (
  `id_disponibilidad` int(11) NOT NULL,
  `id_entrenador` int(11) NOT NULL,
  `id_dia` int(11) NOT NULL,
  `hora_inicio` time NOT NULL,
  `hora_fin` time NOT NULL,
  `lugar` varchar(50) NOT NULL,
  `tipo_entrenamiento` enum('Individual','Grupal') NOT NULL,
  `capacidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Table structure for table `horario_treno`
--

CREATE TABLE `horario_treno` (
  `id_programacion` int(11) NOT NULL,
  `id_contrato` int(11) NOT NULL,
  `id_dia` int(11) NOT NULL,
  `id_hora` int(11) NOT NULL,
  `estado` enum('Activo','Inactivo') NOT NULL,
  `id_local` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `horario_treno`
--

INSERT INTO `horario_treno` (`id_programacion`, `id_contrato`, `id_dia`, `id_hora`, `estado`, `id_local`) VALUES
(8, 710, 4, 2, 'Activo', 1),
(9, 711, 6, 6, 'Activo', 2);

-- --------------------------------------------------------

--
-- Table structure for table `horas`
--

CREATE TABLE `horas` (
  `id_hora` int(11) NOT NULL,
  `hora_inicio` time NOT NULL,
  `hora_fin` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `horas`
--

INSERT INTO `horas` (`id_hora`, `hora_inicio`, `hora_fin`) VALUES
(1, '07:00:00', '08:00:00'),
(2, '08:30:00', '09:30:00'),
(3, '10:00:00', '11:00:00'),
(4, '11:30:00', '12:30:00'),
(5, '13:00:00', '14:00:00'),
(6, '14:30:00', '15:30:00'),
(7, '16:00:00', '17:00:00'),
(8, '17:30:00', '18:30:00'),
(9, '19:00:00', '20:00:00'),
(10, '20:30:00', '21:30:00'),
(11, '22:00:00', '23:00:00');

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
-- Table structure for table `locales`
--

CREATE TABLE `locales` (
  `id_local` int(11) NOT NULL,
  `nombre_parque` varchar(255) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `capacidad` int(11) NOT NULL,
  `descripcion` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `locales`
--

INSERT INTO `locales` (`id_local`, `nombre_parque`, `direccion`, `capacidad`, `descripcion`) VALUES
(1, 'Parque Miraflores', 'Av. Las Flores 123, Miraflores', 10, 'Entrenamiento funcional y cardio.'),
(2, 'Parque del Sol', 'Avenida Primavera 123, Miraflores', 10, 'Un parque amplio con zonas para ejercicio al aire libre.'),
(3, 'Parque Los Cedros', 'Jirón Los Cedros 123, Lince', 1, 'Un lugar tranquilo para meditación y entrenamientos ligeros.');

-- --------------------------------------------------------

--
-- Table structure for table `ordenes_materiales`
--

CREATE TABLE `ordenes_materiales` (
  `id_orden` int(11) NOT NULL,
  `id_inventario` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `subtotal` int(11) NOT NULL,
  `estado` varchar(255) NOT NULL,
  `fecha` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `fecha_pago` date DEFAULT NULL,
  `idusuario` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pago_clientes`
--

INSERT INTO `pago_clientes` (`id_pago`, `tipo_plan`, `nombre_plan`, `duracion`, `precio`, `metodo_pago`, `fecha_pago`, `idusuario`) VALUES
(7, 'Individual', 'Bailes', 12, 590, 'Tarjeta', '2024-11-23', 2),
(8, 'Individual', 'Bailes', 12, 590, 'Efectivo', '2024-11-23', 2),
(9, 'Individual', 'Aeróbicos', 10, 100, 'Tarjeta', '2024-11-23', 2),
(10, 'Individual', 'Aeróbicos', 10, 100, 'Tarjeta', '2024-11-26', 2),
(11, 'Individual', 'Bailes', 12, 590, 'Efectivo', '2024-11-26', 2),
(12, 'Individual', 'Bailes', 12, 590, 'Efectivo', '2024-11-26', 2),
(13, 'Grupal', 'Rut-Ina', 20, 85, 'Efectivo', '2024-11-26', 2),
(14, 'Individual', 'Aeróbicos', 10, 100, 'Tarjeta', '2024-11-26', 2),
(15, 'Grupal', 'Fight Do', 1, 200, 'Efectivo', '2024-11-26', 2),
(16, 'Individual', 'Bailes', 12, 590, 'Efectivo', '2024-11-26', 2),
(17, 'Individual', 'Bailes', 12, 590, 'Efectivo', '2024-11-26', 2),
(18, 'Individual', 'Bailes', 12, 590, 'Efectivo', '2024-11-26', 2),
(19, 'Individual', 'Bailes', 12, 590, 'Efectivo', '2024-11-26', 2),
(20, 'Individual', 'Aeróbicos', 10, 100, 'Efectivo', '2024-11-26', 2),
(21, 'Grupal', 'Fight Do', 1, 200, 'Efectivo', '2024-11-26', 2),
(22, 'Individual', 'Bailes', 12, 590, 'Efectivo', '2024-11-26', 2),
(23, 'Grupal', 'Rut-Ina', 20, 200, 'Efectivo', '2024-11-26', 2),
(24, 'Individual', 'Aeróbicos', 10, 100, 'Efectivo', '2024-11-26', 2),
(25, 'Individual', 'Bailes', 12, 590, 'Efectivo', '2024-11-26', 2),
(26, 'Individual', 'Gym', 5, 400, 'Efectivo', '2024-11-26', 2),
(27, 'Grupal', 'Fight Do', 1, 200, 'Efectivo', '2024-11-26', 2),
(28, 'Individual', 'Aeróbicos', 10, 100, 'Efectivo', '2024-11-28', 2);

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
(5, 'Grupal', 'Rut-Ina', 20, 200, 'A', '2024-10-25 00:00:00', 0, 'Pago Efectivo'),
(6, 'Individual', 'Aeróbicos', 10, 100, 'A', '2024-11-06 00:00:00', 0, 'Pago Efectivo'),
(8, 'Individual', 'Bailes', 12, 590, 'A', '2024-11-09 00:00:00', 0, 'Pago Efectivo'),
(9, 'Individual', 'Gym', 5, 400, 'A', '2024-11-23 00:00:00', 0, 'Pago Efectivo'),
(10, 'Grupal', 'Fight Do', 1, 200, 'A', '2024-11-26 00:00:00', 0, 'Pago Efectivo');

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
  `correo` varchar(255) DEFAULT NULL,
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
  ADD PRIMARY KEY (`id_contratacion_local`);

--
-- Indexes for table `contrato_personal`
--
ALTER TABLE `contrato_personal`
  ADD PRIMARY KEY (`id_contrato`);

--
-- Indexes for table `dias_disponibles`
--
ALTER TABLE `dias_disponibles`
  ADD PRIMARY KEY (`id_dia`);

--
-- Indexes for table `entrenadores`
--
ALTER TABLE `entrenadores`
  ADD PRIMARY KEY (`id_entrenador`);

--
-- Indexes for table `entrenador_dias_horarios`
--
ALTER TABLE `entrenador_dias_horarios`
  ADD PRIMARY KEY (`id_disponibilidad`);

--
-- Indexes for table `gestion_sanciones`
--
ALTER TABLE `gestion_sanciones`
  ADD PRIMARY KEY (`id_sancion`),
  ADD KEY `idcliente` (`idcliente`);

--
-- Indexes for table `horario_treno`
--
ALTER TABLE `horario_treno`
  ADD PRIMARY KEY (`id_programacion`);

--
-- Indexes for table `horas`
--
ALTER TABLE `horas`
  ADD PRIMARY KEY (`id_hora`);

--
-- Indexes for table `inventario`
--
ALTER TABLE `inventario`
  ADD PRIMARY KEY (`id_inventario`),
  ADD KEY `id_proveedor` (`id_proveedor`);

--
-- Indexes for table `locales`
--
ALTER TABLE `locales`
  ADD PRIMARY KEY (`id_local`);

--
-- Indexes for table `ordenes_materiales`
--
ALTER TABLE `ordenes_materiales`
  ADD PRIMARY KEY (`id_orden`);

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
-- AUTO_INCREMENT for table `contratos_locales`
--
ALTER TABLE `contratos_locales`
  MODIFY `id_contratacion_local` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT for table `contrato_personal`
--
ALTER TABLE `contrato_personal`
  MODIFY `id_contrato` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=712;

--
-- AUTO_INCREMENT for table `entrenador_dias_horarios`
--
ALTER TABLE `entrenador_dias_horarios`
  MODIFY `id_disponibilidad` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gestion_sanciones`
--
ALTER TABLE `gestion_sanciones`
  MODIFY `id_sancion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `horario_treno`
--
ALTER TABLE `horario_treno`
  MODIFY `id_programacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `horas`
--
ALTER TABLE `horas`
  MODIFY `id_hora` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `inventario`
--
ALTER TABLE `inventario`
  MODIFY `id_inventario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `locales`
--
ALTER TABLE `locales`
  MODIFY `id_local` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ordenes_materiales`
--
ALTER TABLE `ordenes_materiales`
  MODIFY `id_orden` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pago_clientes`
--
ALTER TABLE `pago_clientes`
  MODIFY `id_pago` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `planes_entrenamiento`
--
ALTER TABLE `planes_entrenamiento`
  MODIFY `idplan` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

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
