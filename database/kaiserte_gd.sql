-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 20-06-2023 a las 12:51:33
-- Versión del servidor: 10.2.44-MariaDB-cll-lve
-- Versión de PHP: 7.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `kaiserte_gd`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `accidente`
--

CREATE TABLE `accidente` (
  `id` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `accidente`
--

INSERT INTO `accidente` (`id`, `nombre`) VALUES
(1, 'Si'),
(2, 'No');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `acreditacion`
--

CREATE TABLE `acreditacion` (
  `id` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `acreditacion`
--

INSERT INTO `acreditacion` (`id`, `nombre`) VALUES
(1, 'Planilla Cotizaciones'),
(2, 'Certificado Cotizaciones'),
(3, 'No Corresponde Informar');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `afectoavacaciones`
--

CREATE TABLE `afectoavacaciones` (
  `id` int(11) NOT NULL,
  `trabajador` int(11) NOT NULL,
  `fechainicio` date NOT NULL,
  `estadoafectoavacaciones` int(11) NOT NULL,
  `register_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `afp`
--

CREATE TABLE `afp` (
  `id` int(11) NOT NULL,
  `codigo` varchar(20) NOT NULL,
  `codigoprevired` varchar(20) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `tasa` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `afp`
--

INSERT INTO `afp` (`id`, `codigo`, `codigoprevired`, `nombre`, `tasa`) VALUES
(6, '00', '00', 'NO ESTÃ¡ EN AFP', 1.00),
(7, '03', '03', 'CUPRUM', 1.00),
(8, '05', '05', 'HABITAT', 1.00),
(9, '08', '08', 'PROVIDA', 1.00),
(10, '29', '29', 'PLANVITAL', 1.00),
(11, '33', '33', 'CAPITAL', 1.00),
(12, '34', '34', 'MODELO', 1.00),
(13, '35', '35', 'UNO', 1.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `anotacion`
--

CREATE TABLE `anotacion` (
  `id` int(11) NOT NULL,
  `trabajador` int(11) NOT NULL,
  `empresa` int(11) NOT NULL,
  `tipoanotacion` int(11) NOT NULL,
  `anotacion` text NOT NULL,
  `register_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `AuditoriaEventos`
--

CREATE TABLE `AuditoriaEventos` (
  `id` int(11) NOT NULL,
  `idusuario` int(11) NOT NULL,
  `evento` varchar(200) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `AuditoriaEventos`
--

INSERT INTO `AuditoriaEventos` (`id`, `idusuario`, `evento`, `fecha`) VALUES
(1, 6, 'Se Registro la empresa FAHECAR SPA con RUT 77.039.381-7 en el sistema', '2023-01-26 17:42:48'),
(2, 6, 'Se Registro el Trabajador : ALEXSANDRA con el Rut: 19.210.578-0', '2023-01-26 17:47:14'),
(3, 6, 'Se Actualizo el Trabajador : ALEXSANDRA con el Rut: 19.210.578-1', '2023-01-26 17:48:40'),
(4, 6, 'Se Actualizo el Trabajador : ALEXSANDRA con el Rut: 1921057', '2023-01-26 17:48:54'),
(5, 6, 'Se Actualizo el Trabajador : ALEXSANDRA con el Rut: 19.210.578-1', '2023-01-26 17:49:58'),
(6, 6, 'Se Registro el Trabajador : DAVID ERNESTO con el Rut: 16.263.984-6', '2023-01-26 17:52:58'),
(7, 6, 'Se Registro Neuva Informacion de Domicilio para el trabajar con el ID: 2', '2023-01-26 17:54:20'),
(8, 6, 'Se Registro La informaciÃ³n de Prevision del Trabajador con el id: 2', '2023-01-26 17:54:59'),
(9, 6, 'Se Registro La informaciÃ³n de Prevision del Trabajador con el id: 1', '2023-01-26 17:57:36'),
(10, 2, 'Se Registro el Centro de Costo : EL DELIRIO con el Codigo: 01', '2023-01-26 18:01:01'),
(11, 2, 'Se Registro el Centro de Costo : DOS MARIAS con el Codigo: 02', '2023-01-26 18:01:12'),
(12, 2, 'Se Actualizo la Plantilla : 5', '2023-01-26 18:05:52'),
(13, 2, 'Se Actualizo la Plantilla : 5', '2023-01-26 18:11:09'),
(14, 2, 'Se Actualizo la Plantilla : 5', '2023-01-26 18:14:56'),
(15, 2, 'Se Actualizo la Plantilla : 5', '2023-01-26 18:16:27'),
(16, 2, 'Se Actualizo la Plantilla : 5', '2023-01-26 18:17:27'),
(17, 2, 'Se Actualizo la Plantilla : 5', '2023-01-26 18:20:22'),
(18, 2, 'Se Agrego la Plantilla : 5', '2023-01-26 18:20:29'),
(19, 2, 'Se Agrego la Plantilla : 5', '2023-01-26 18:20:47'),
(20, 2, 'Se Agrego la Plantilla : 5', '2023-01-26 18:21:04'),
(21, 2, 'Se Agrego la Plantilla : 5', '2023-01-26 18:21:20'),
(22, 2, 'Se Actualizo la Plantilla : 6', '2023-01-26 18:21:47'),
(23, 2, 'Se Actualizo la Plantilla : 6', '2023-01-26 18:24:09'),
(24, 6, 'Se Registro un nuevo contrato de trabajo para el trabajador ALEXSANDRA CONTRERAS AHUMADA', '2023-01-26 18:25:06'),
(25, 6, 'Se Registro un nuevo contrato de trabajo para el trabajador DAVID ERNESTO RIQUELME PEÃ±A', '2023-01-26 18:25:07'),
(26, 2, 'Se Agrego la Plantilla : 7', '2023-01-26 18:28:15'),
(27, 2, 'Se Registro El Causal de termino contrato : art 159 nÂ°5 termino de faena con el Codigo: 1', '2023-01-26 18:29:05'),
(28, 2, 'Se Agrego Permiso al Usuario con el ID2', '2023-01-27 19:51:58'),
(29, 2, 'Se Agrego Permiso al Usuario con el ID2', '2023-01-27 19:51:59'),
(30, 2, 'Se Agrego Permiso al Usuario con el ID2', '2023-01-27 19:51:59'),
(31, 2, 'Se Agrego Permiso al Usuario con el ID2', '2023-01-27 19:52:03'),
(32, 2, 'Se Agrego Usuario con el ID2 a la Empresa con el ID1', '2023-01-27 19:53:08'),
(33, 2, 'Se Registro la empresa PRUEBA con RUT 76.799.271-8 en el sistema', '2023-02-04 11:11:54'),
(34, 2, 'Se Registro el Centro de Costo : CONTABILIDAD con el Codigo: 01', '2023-02-04 11:14:11'),
(35, 2, 'Se Registro el Trabajador : NATALIA CATALINA con el Rut: 17.504.848-0', '2023-02-04 13:00:38'),
(36, 2, 'Se Registro el Trabajador : CARLOS FELIPE con el Rut: 15.524.906-4', '2023-02-04 13:02:19'),
(37, 2, 'Se Registro el Trabajador : CAMILA FRANCISCA con el Rut: 19.263.645-1', '2023-02-04 13:06:00'),
(38, 2, 'Se Registro el Trabajador : GERALDO DE JESUSCRISTO con el Rut: 26.250.185-1', '2023-02-04 13:08:12'),
(39, 2, 'Se Registro el Trabajador : CECILIA CAROLINA con el Rut: 13.946.991-7', '2023-02-04 13:10:17'),
(40, 2, 'Se Registro La informaciÃ³n de Prevision del Trabajador con el id: 5', '2023-02-04 13:17:18'),
(41, 2, 'Se Registro La informaciÃ³n de Prevision del Trabajador con el id: 4', '2023-02-04 13:18:42'),
(42, 2, 'Se Registro La informaciÃ³n de Prevision del Trabajador con el id: 3', '2023-02-04 13:20:05'),
(43, 2, 'Se Actualizo la prevision  del trabajador con id: 7', '2023-02-04 13:21:11'),
(44, 2, 'Se Registro un nuevo contrato de trabajo para el trabajador CECILIA CAROLINA  VALDES  MONTENEGRO', '2023-02-04 15:41:08'),
(45, 2, 'Se Registro la empresa PRUEBA  con RUT 76.799.271-8 en el sistema', '2023-02-06 12:36:32'),
(46, 2, 'Se Registro el Trabajador : NATALIA CATALINA con el Rut: 17.504.848-0', '2023-02-06 12:53:56'),
(47, 2, 'Se Registro La informaciÃ³n de Prevision del Trabajador con el id: 1', '2023-02-06 12:54:29'),
(48, 2, 'Se elimino la Prevision con el ID: 4', '2023-02-06 12:54:40'),
(49, 2, 'Se Registro el Trabajador : MARCOS con el Rut: 18.039.655-1', '2023-02-06 12:55:56'),
(50, 2, 'Se elimino la Prevision con el ID: 3', '2023-02-06 12:56:09'),
(51, 2, 'Se Registro La informaciÃ³n de Prevision del Trabajador con el id: 2', '2023-02-06 12:56:35'),
(52, 2, 'Se Registro el Trabajador : CECILIA CAROLINA con el Rut: 13.946.991-7', '2023-02-06 12:59:22'),
(53, 2, 'Se elimino la Prevision con el ID: 7', '2023-02-06 12:59:30'),
(54, 2, 'Se Registro La informaciÃ³n de Prevision del Trabajador con el id: 3', '2023-02-06 12:59:47'),
(55, 2, 'Se Registro el Trabajador : CARLOS FELIPE con el Rut: 15.524.906-4', '2023-02-06 13:01:43'),
(56, 2, 'Se Registro el Trabajador : GERALDO DE JESUSCRISTO con el Rut: 26.360.296-k', '2023-02-06 13:03:33'),
(57, 2, 'Se Registro el Trabajador : CAMILA FRANCISCA con el Rut: 19.263.654-k', '2023-02-06 13:06:36'),
(58, 2, 'Se Registro un nuevo contrato de trabajo para el trabajador CECILIA CAROLINA VALDES MONTENEGRO', '2023-02-06 13:21:31'),
(59, 2, 'Se Registro un nuevo contrato de trabajo para el trabajador NATALIA CATALINA PALACIOS RUZ', '2023-02-06 13:33:11'),
(60, 2, 'Se Registro un nuevo contrato de trabajo para el trabajador MARCOS DIAZ GONZALEZ', '2023-02-06 13:33:13'),
(61, 2, 'Se Actualizo la empresa PRUEBA  con RUT 76.799.271-8 en el sistema', '2023-02-07 13:08:22'),
(62, 2, 'Se Actualizo la empresa PRUEBA  con RUT 76.799.271-8 en el sistema', '2023-02-07 13:08:38'),
(63, 2, 'Se Registro el Trabajador : JUAN CARLOS con el Rut: 7.711.868-3', '2023-02-22 16:42:00'),
(64, 2, 'Se Registro un nuevo contrato de trabajo para el trabajador CARLOS FELIPE DIAZ GONZALEZ', '2023-02-22 16:49:47'),
(65, 2, 'Se Registro un nuevo contrato de trabajo para el trabajador CARLOS FELIPE DIAZ GONZALEZ', '2023-02-22 16:55:38'),
(66, 2, 'Se Agrego Permiso al Usuario con el ID2', '2023-02-22 17:44:29'),
(67, 2, 'Se Agrego Permiso al Usuario con el ID2', '2023-02-22 17:44:33'),
(68, 2, 'Se Agrego Permiso al Usuario con el ID2', '2023-02-22 17:44:35'),
(69, 2, 'Se Agrego Permiso al Usuario con el ID2', '2023-02-22 17:44:40'),
(70, 2, 'Se Actualizo la contraseÃ±a del usuario : 1', '2023-02-22 17:44:56'),
(71, 2, 'Se Registro la empresa FELIPE DIAZ ERIL con RUT 76.049.826-2 en el sistema', '2023-02-22 17:47:25'),
(72, 2, 'Se Agrego Usuario con el ID2 a la Empresa con el ID2', '2023-02-22 17:48:49'),
(73, 1, 'Se Registro el Trabajador : JUAN CARLOS  con el Rut: 7.711.868-3', '2023-02-22 17:55:28'),
(74, 1, 'Se Registro La informaciÃ³n de Prevision del Trabajador con el id: 8', '2023-02-22 17:55:50'),
(75, 1, 'Se Registro un nuevo contrato de trabajo para el trabajador JUAN CARLOS  DIAZ ARENAS', '2023-02-22 18:05:02'),
(76, 2, 'Se Actualizo la contraseÃ±a del usuario : 6', '2023-05-17 19:53:55'),
(77, 2, 'Se Actualizo la contraseÃ±a del usuario : 7', '2023-05-17 19:54:09'),
(78, 2, 'Se Registro el Usuario : JAVIERA PAZ GONZALEZ GONZALEZ con el Rut: 19.540.765-7', '2023-05-17 19:57:39'),
(79, 2, 'Se Agrego Permiso al Usuario con el ID2', '2023-05-17 19:57:58'),
(80, 8, 'Se Registro la empresa PAULO BENITO BERRIOS DONAIRE con RUT 11.366.273-5 en el sistema', '2023-05-17 20:47:01'),
(81, 8, 'Se Actualizo la empresa PAULO BENITO BERRIOS DONAIRE con RUT 11.366.273-5 en el sistema', '2023-05-17 20:48:07'),
(82, 8, 'Se Registro el Centro de Costo : TURISTICA DEL SUR con el Codigo: 01', '2023-05-17 20:50:32'),
(83, 8, 'Se Registro el Centro de Costo : TRANSPORTE PUBLICO con el Codigo: 02', '2023-05-17 20:50:58'),
(84, 8, 'Se Registro el Trabajador : PATRICIO JACOB con el Rut: 11.337.156-0', '2023-05-17 20:58:57'),
(85, 8, 'Se Registro La informaciÃ³n de Prevision del Trabajador con el id: 9', '2023-05-17 21:03:51'),
(86, 8, 'Se Registro la Region : RANCAGUA con el Codigo: 94', '2023-05-17 21:10:08'),
(87, 8, 'Se Registro la Comuna : RANCAGUA con el Codigo: 94', '2023-05-17 21:15:37'),
(88, 8, 'Se Registro la Ciudad : RANCAGUA con el Codigo: 94', '2023-05-17 21:15:37'),
(89, 2, 'Se Actualizo la comuna : RENGO con el Codigo: 80', '2023-05-17 21:16:04'),
(90, 2, 'Se Actualizo la ciudad : RENGO con el Codigo: 80', '2023-05-17 21:16:04'),
(91, 2, 'Se Actualizo la comuna : REQUINOA con el Codigo: 81', '2023-05-17 21:16:29'),
(92, 2, 'Se Actualizo la ciudad : REQUINOA con el Codigo: 81', '2023-05-17 21:16:29'),
(93, 2, 'Se Actualizo la comuna : CODEGUA con el Codigo: 89', '2023-05-17 21:16:51'),
(94, 2, 'Se Actualizo la ciudad : CODEGUA con el Codigo: 89', '2023-05-17 21:16:51'),
(95, 2, 'Se Actualizo la comuna : CODEGUA con el Codigo: 89', '2023-05-17 21:16:51'),
(96, 2, 'Se Actualizo la ciudad : CODEGUA con el Codigo: 89', '2023-05-17 21:16:51'),
(97, 8, 'Se Registro el tipo de documento : CONTRATO DE TRABAJO TRANSPORTE PUBLICO con el Codigo: 02', '2023-05-17 21:25:08'),
(98, 8, 'Se Agrego la Plantilla : 8', '2023-05-17 21:52:44'),
(99, 8, 'Se Actualizo la Plantilla : 8', '2023-05-17 21:53:07'),
(100, 8, 'Se Registro Neuva Informacion de Domicilio para el trabajar con el ID: 9', '2023-05-17 21:57:02'),
(101, 8, 'Se Registro el cargo : CONDUCTOR con el Codigo: 02', '2023-05-17 22:02:12'),
(102, 8, 'Se Registro un nuevo contrato de trabajo para el trabajador PATRICIO JACOB MOENA AGUAYO', '2023-05-17 22:09:43'),
(103, 8, 'Se Registro el tipo de documento : COMPROBANTE DE VACACIONES IUSTAX con el Codigo: 7', '2023-05-24 20:27:31'),
(104, 8, 'Se Agrego la Plantilla : 9', '2023-05-24 20:41:20'),
(105, 8, 'Se Actualizo la Plantilla : 9', '2023-05-24 20:50:47'),
(106, 8, 'Se Actualizo la Plantilla : 9', '2023-05-24 20:53:58'),
(107, 8, 'Se Actualizo la Plantilla : 9', '2023-05-24 20:54:57'),
(108, 8, 'Se Actualizo la Plantilla : 9', '2023-05-24 20:59:14'),
(109, 2, 'Se Actualizo la Plantilla : 9', '2023-05-24 21:02:45'),
(110, 2, 'Se Actualizo la Plantilla : 9', '2023-05-24 21:05:30'),
(111, 2, 'Se Actualizo la Plantilla : 9', '2023-05-24 21:05:46'),
(112, 8, 'Se Actualizo la Plantilla : 9', '2023-05-24 21:05:46'),
(113, 2, 'Se Actualizo la Plantilla : 9', '2023-05-24 21:06:35'),
(114, 2, 'Se Actualizo la Plantilla : 9', '2023-05-24 21:07:18'),
(115, 2, 'Se Actualizo la Plantilla : 9', '2023-05-24 21:10:23'),
(116, 2, 'Se Actualizo la Plantilla : 9', '2023-05-24 21:12:04'),
(117, 2, 'Se Actualizo la Plantilla : 9', '2023-05-24 21:12:43'),
(118, 2, 'Se Actualizo la Plantilla : 9', '2023-05-24 21:14:00'),
(119, 2, 'Se Actualizo la Plantilla : 9', '2023-05-24 21:14:10'),
(120, 2, 'Se Actualizo la Plantilla : 9', '2023-05-24 21:14:21'),
(121, 2, 'Se Actualizo la Plantilla : 9', '2023-05-24 21:15:57'),
(122, 2, 'Se Actualizo la Plantilla : 9', '2023-05-24 21:18:17'),
(123, 2, 'Se Actualizo la Plantilla : 9', '2023-05-24 21:19:15'),
(124, 2, 'Se Actualizo la Plantilla : 9', '2023-05-24 21:19:31'),
(125, 2, 'Se Actualizo la Plantilla : 9', '2023-05-24 21:19:56'),
(126, 2, 'Se Actualizo la Plantilla : 9', '2023-05-24 21:20:22'),
(127, 2, 'Se Actualizo la Plantilla : 9', '2023-05-24 21:20:59'),
(128, 2, 'Se Actualizo la Plantilla : 9', '2023-05-24 21:23:07'),
(129, 2, 'Se Actualizo la Plantilla : 9', '2023-05-24 21:23:53'),
(130, 2, 'Se Actualizo la Plantilla : 9', '2023-05-24 21:24:08'),
(131, 2, 'Se Actualizo la Plantilla : 9', '2023-05-24 21:24:19'),
(132, 2, 'Se Actualizo la Plantilla : 9', '2023-05-24 21:26:08'),
(133, 2, 'Se Actualizo la Plantilla : 9', '2023-05-24 21:26:33'),
(134, 8, 'Se Registro el Trabajador : RENE DANIEL con el Rut: 8.054.994-6', '2023-05-30 17:03:28'),
(135, 8, 'Se Registro La informaciÃ³n de Prevision del Trabajador con el id: 10', '2023-05-30 17:09:59'),
(136, 8, 'Se Actualizo la Plantilla : 8', '2023-05-30 18:46:18'),
(137, 8, 'Se Registro un nuevo contrato de trabajo para el trabajador RENE DANIEL REYES FUENZALIDA', '2023-05-30 18:58:53'),
(138, 8, 'Se Registro el Trabajador : DANIEL ANDRES con el Rut: 12.515.380-1', '2023-06-08 21:15:28'),
(139, 8, 'Se Registro La informaciÃ³n de Prevision del Trabajador con el id: 11', '2023-06-08 21:17:28'),
(140, 8, 'Se Registro un nuevo contrato de trabajo para el trabajador DANIEL ANDRES CANTILLANA ESPINOSA', '2023-06-08 21:21:57'),
(141, 8, 'Se Actualizo la Plantilla : 9', '2023-06-08 21:39:57'),
(142, 8, 'Se Actualizo la Plantilla : 9', '2023-06-08 21:43:27'),
(143, 8, 'Se Actualizo la Plantilla : 9', '2023-06-08 21:43:45'),
(144, 8, 'Se Actualizo la Plantilla : 9', '2023-06-08 21:55:00'),
(145, 2, 'Se Actualizo la empresa PAULO BENITO BERRIOS DONAIRE con RUT 11.366.273-5 en el sistema', '2023-06-12 21:12:01'),
(146, 2, 'Se Actualizo la empresa PAULO BENITO BERRIOS DONAIRE con RUT 11.366.273-5 en el sistema', '2023-06-12 21:12:59'),
(147, 8, 'Se Actualizo la Plantilla : 9', '2023-06-12 21:51:34'),
(148, 8, 'Se Registro el tipo de documento : PRUEBA COMPROBANTE DE VACACIONES con el Codigo: P1', '2023-06-12 21:55:40'),
(149, 8, 'Se Agrego la Plantilla : 10', '2023-06-12 21:56:14'),
(150, 2, 'Se Actualizo la empresa PAULO BENITO BERRIOS DONAIRE con RUT 11.366.273-5 en el sistema', '2023-06-12 22:28:47'),
(151, 2, 'Se Actualizo la Plantilla : 9', '2023-06-12 22:35:06'),
(152, 2, 'Se Actualizo la Plantilla : 9', '2023-06-12 22:36:58'),
(153, 2, 'Se Actualizo la Plantilla : 9', '2023-06-12 22:37:24'),
(154, 2, 'Se Actualizo la Plantilla : 9', '2023-06-12 22:39:13'),
(155, 2, 'Se Actualizo la Plantilla : 9', '2023-06-12 22:39:46'),
(156, 2, 'Se Actualizo la Plantilla : 9', '2023-06-12 22:40:00'),
(157, 2, 'Se Actualizo la Plantilla : 9', '2023-06-12 22:40:31'),
(158, 2, 'Se Actualizo la Plantilla : 9', '2023-06-12 22:40:45'),
(159, 2, 'Se Actualizo la Plantilla : 9', '2023-06-12 22:43:28'),
(160, 2, 'Se Actualizo la Plantilla : 9', '2023-06-12 22:44:05'),
(161, 2, 'Se Actualizo la Plantilla : 9', '2023-06-12 22:46:37'),
(162, 2, 'Se Actualizo la Plantilla : 9', '2023-06-12 22:47:32'),
(163, 2, 'Se Actualizo la Plantilla : 9', '2023-06-12 22:48:41'),
(164, 2, 'Se Actualizo la Plantilla : 9', '2023-06-12 22:49:41'),
(165, 2, 'Se Actualizo la Plantilla : 9', '2023-06-12 22:50:17'),
(166, 2, 'Se Actualizo la Plantilla : 9', '2023-06-12 22:51:03'),
(167, 2, 'Se Actualizo la Plantilla : 9', '2023-06-12 22:51:50'),
(168, 2, 'Se Actualizo la Plantilla : 9', '2023-06-12 22:52:42'),
(169, 2, 'Se Actualizo la Plantilla : 9', '2023-06-12 22:54:14'),
(170, 2, 'Se Actualizo la Plantilla : 9', '2023-06-12 22:55:04'),
(171, 2, 'Se Actualizo la Plantilla : 9', '2023-06-12 22:55:47'),
(172, 2, 'Se Actualizo la Plantilla : 9', '2023-06-12 22:57:09'),
(173, 2, 'Se Actualizo la Plantilla : 9', '2023-06-12 22:57:37'),
(174, 2, 'Se Actualizo la Plantilla : 9', '2023-06-12 22:59:01'),
(175, 2, 'Se Actualizo la Plantilla : 9', '2023-06-12 23:00:06'),
(176, 2, 'Se Actualizo la Plantilla : 9', '2023-06-12 23:00:42'),
(177, 2, 'Se Actualizo la Plantilla : 9', '2023-06-12 23:00:58'),
(178, 2, 'Se Actualizo la Plantilla : 9', '2023-06-12 23:01:22'),
(179, 2, 'Se Actualizo la Plantilla : 9', '2023-06-12 23:02:06'),
(180, 2, 'Se Actualizo la Plantilla : 9', '2023-06-12 23:03:43'),
(181, 2, 'Se Actualizo la Plantilla : 9', '2023-06-12 23:05:26'),
(182, 2, 'Se Actualizo la Plantilla : 9', '2023-06-12 23:05:39'),
(183, 2, 'Se Actualizo la Plantilla : 9', '2023-06-12 23:05:56'),
(184, 2, 'Se Actualizo la Plantilla : 9', '2023-06-12 23:06:27'),
(185, 2, 'Se Actualizo la Plantilla : 9', '2023-06-12 23:09:40'),
(186, 2, 'Se Actualizo la Plantilla : 9', '2023-06-12 23:10:20'),
(187, 2, 'Se Actualizo la Plantilla : 9', '2023-06-12 23:10:57'),
(188, 2, 'Se Actualizo la Plantilla : 9', '2023-06-12 23:12:25'),
(189, 2, 'Se Actualizo la Plantilla : 9', '2023-06-12 23:12:43'),
(190, 2, 'Se Actualizo la Plantilla : 9', '2023-06-12 23:13:48'),
(191, 2, 'Se Actualizo la Plantilla : 9', '2023-06-12 23:14:51'),
(192, 2, 'Se Actualizo la Plantilla : 9', '2023-06-12 23:15:29'),
(193, 2, 'Se Actualizo la Plantilla : 9', '2023-06-12 23:16:22'),
(194, 2, 'Se Actualizo la Plantilla : 9', '2023-06-12 23:16:47'),
(195, 2, 'Se Actualizo la Plantilla : 9', '2023-06-12 23:17:50'),
(196, 2, 'Se Actualizo la Plantilla : 9', '2023-06-12 23:23:17'),
(197, 2, 'Se Actualizo la Plantilla : 9', '2023-06-12 23:23:33'),
(198, 2, 'Se Actualizo la Plantilla : 9', '2023-06-12 23:23:53'),
(199, 2, 'Se Actualizo la Plantilla : 9', '2023-06-12 23:24:07'),
(200, 2, 'Se Actualizo la Plantilla : 9', '2023-06-12 23:24:33'),
(201, 2, 'Se Actualizo la Plantilla : 9', '2023-06-13 00:08:04'),
(202, 2, 'Se Actualizo la Plantilla : 9', '2023-06-13 00:08:25'),
(203, 2, 'Se Actualizo la Plantilla : 9', '2023-06-13 00:09:02'),
(204, 2, 'Se Actualizo la Plantilla : 9', '2023-06-13 00:09:54'),
(205, 2, 'Se Actualizo la Plantilla : 9', '2023-06-13 00:10:08'),
(206, 2, 'Se Actualizo la Plantilla : 9', '2023-06-13 00:11:23'),
(207, 2, 'Se Actualizo la Plantilla : 9', '2023-06-13 00:12:05'),
(208, 2, 'Se Actualizo la Plantilla : 9', '2023-06-13 00:13:26'),
(209, 2, 'Se Actualizo la Plantilla : 9', '2023-06-13 00:13:50'),
(210, 2, 'Se Actualizo la Plantilla : 9', '2023-06-13 00:16:36'),
(211, 2, 'Se Actualizo la Plantilla : 9', '2023-06-13 00:18:56'),
(212, 2, 'Se Actualizo la Plantilla : 9', '2023-06-13 00:20:59'),
(213, 2, 'Se Actualizo la Plantilla : 9', '2023-06-13 00:21:43'),
(214, 2, 'Se Actualizo la Plantilla : 9', '2023-06-13 00:23:29'),
(215, 2, 'Se Actualizo la Plantilla : 9', '2023-06-13 00:24:11'),
(216, 2, 'Se Actualizo la Plantilla : 9', '2023-06-13 00:24:34'),
(217, 2, 'Se Actualizo la Plantilla : 9', '2023-06-13 00:24:51'),
(218, 2, 'Se Actualizo la Plantilla : 9', '2023-06-13 00:25:11'),
(219, 2, 'Se Actualizo la Plantilla : 9', '2023-06-13 00:25:33'),
(220, 2, 'Se Actualizo la Plantilla : 9', '2023-06-13 00:25:46'),
(221, 2, 'Se Actualizo la Plantilla : 9', '2023-06-13 00:26:21'),
(222, 2, 'Se Actualizo la Plantilla : 9', '2023-06-13 00:27:04'),
(223, 2, 'Se Actualizo la Plantilla : 9', '2023-06-13 00:27:27'),
(224, 2, 'Se Actualizo la Plantilla : 9', '2023-06-13 00:27:47'),
(225, 2, 'Se Actualizo la Plantilla : 9', '2023-06-13 00:28:48'),
(226, 2, 'Se Actualizo la Plantilla : 9', '2023-06-13 00:29:10'),
(227, 2, 'Se Actualizo la Plantilla : 9', '2023-06-13 00:29:23'),
(228, 2, 'Se Actualizo la Plantilla : 9', '2023-06-13 00:29:33'),
(229, 2, 'Se Actualizo la Plantilla : 9', '2023-06-13 00:30:38'),
(230, 2, 'Se Actualizo la Plantilla : 9', '2023-06-13 00:34:23'),
(231, 2, 'Se Actualizo la Plantilla : 9', '2023-06-13 00:34:57'),
(232, 2, 'Se Actualizo la Plantilla : 9', '2023-06-13 00:35:32'),
(233, 2, 'Se Actualizo la Plantilla : 9', '2023-06-13 00:35:45'),
(234, 2, 'Se Actualizo la Plantilla : 9', '2023-06-13 00:35:57'),
(235, 2, 'Se Actualizo la Plantilla : 9', '2023-06-13 00:37:02'),
(236, 2, 'Se Actualizo la Plantilla : 9', '2023-06-13 00:43:05'),
(237, 2, 'Se Actualizo la Plantilla : 9', '2023-06-13 00:43:41'),
(238, 2, 'Se Actualizo la Plantilla : 9', '2023-06-13 00:47:29'),
(239, 2, 'Se Actualizo la Plantilla : 9', '2023-06-13 00:47:50'),
(240, 2, 'Se Actualizo la Plantilla : 9', '2023-06-13 00:49:02'),
(241, 2, 'Se Actualizo la Plantilla : 9', '2023-06-13 00:49:39'),
(242, 2, 'Se Actualizo la Plantilla : 9', '2023-06-13 00:50:21'),
(243, 2, 'Se Actualizo la Plantilla : 9', '2023-06-13 00:50:36'),
(244, 2, 'Se Actualizo la Plantilla : 9', '2023-06-13 00:51:07'),
(245, 2, 'Se Actualizo la Plantilla : 9', '2023-06-13 00:51:25'),
(246, 2, 'Se Actualizo la Plantilla : 9', '2023-06-13 00:51:46'),
(247, 2, 'Se Actualizo la Plantilla : 9', '2023-06-13 02:10:59'),
(248, 2, 'Se Actualizo la Plantilla : 9', '2023-06-13 02:12:23'),
(249, 2, 'Se Actualizo la Plantilla : 9', '2023-06-13 02:12:44'),
(250, 2, 'Se Actualizo la Plantilla : 9', '2023-06-13 02:13:18'),
(251, 2, 'Se Actualizo la Plantilla : 9', '2023-06-13 02:16:20'),
(252, 2, 'Se Actualizo la Plantilla : 9', '2023-06-13 02:16:30'),
(253, 2, 'Se Actualizo la Plantilla : 9', '2023-06-13 02:16:38'),
(254, 2, 'Se Actualizo la Plantilla : 9', '2023-06-13 02:16:47'),
(255, 2, 'Se Actualizo la Plantilla : 9', '2023-06-13 02:16:58'),
(256, 2, 'Se Actualizo la Plantilla : 9', '2023-06-13 02:17:07'),
(257, 2, 'Se Actualizo la Plantilla : 9', '2023-06-13 02:17:16'),
(258, 2, 'Se Actualizo la Plantilla : 9', '2023-06-13 02:17:24'),
(259, 2, 'Se Actualizo la Plantilla : 9', '2023-06-13 02:17:33'),
(260, 2, 'Se Actualizo la Plantilla : 9', '2023-06-13 02:17:48'),
(261, 2, 'Se Actualizo la Plantilla : 9', '2023-06-13 02:18:28'),
(262, 2, 'Se Actualizo la Plantilla : 9', '2023-06-13 02:19:09'),
(263, 2, 'Se Actualizo la Plantilla : 9', '2023-06-13 02:19:25'),
(264, 2, 'Se Actualizo la Plantilla : 9', '2023-06-13 02:19:38'),
(265, 2, 'Se Actualizo la Plantilla : 9', '2023-06-13 02:19:53'),
(266, 2, 'Se Actualizo la Plantilla : 9', '2023-06-13 02:24:31'),
(267, 2, 'Se Actualizo la Plantilla : 9', '2023-06-13 02:24:51'),
(268, 2, 'Se Actualizo la Plantilla : 9', '2023-06-13 02:25:04'),
(269, 2, 'Se Actualizo la Plantilla : 9', '2023-06-13 02:25:21'),
(270, 2, 'Se Actualizo la Plantilla : 9', '2023-06-13 02:25:49'),
(271, 2, 'Se Actualizo la Plantilla : 9', '2023-06-13 02:27:04'),
(272, 2, 'Se Actualizo la Plantilla : 9', '2023-06-13 02:27:20'),
(273, 2, 'Se Actualizo la Plantilla : 9', '2023-06-13 02:27:33'),
(274, 2, 'Se Actualizo la Plantilla : 9', '2023-06-13 02:27:45'),
(275, 2, 'Se Actualizo la Plantilla : 9', '2023-06-13 02:27:57'),
(276, 2, 'Se Actualizo la Plantilla : 9', '2023-06-13 02:28:19'),
(277, 2, 'Se Actualizo la Plantilla : 9', '2023-06-13 02:28:28'),
(278, 2, 'Se Actualizo la Plantilla : 9', '2023-06-13 02:28:39'),
(279, 2, 'Se Actualizo la Plantilla : 9', '2023-06-13 02:28:51'),
(280, 2, 'Se Actualizo la Plantilla : 9', '2023-06-13 02:29:04'),
(281, 2, 'Se Actualizo la Plantilla : 9', '2023-06-13 02:29:14'),
(282, 2, 'Se Actualizo la Plantilla : 9', '2023-06-13 02:29:23'),
(283, 2, 'Se Actualizo la Plantilla : 9', '2023-06-13 02:29:33'),
(284, 2, 'Se Actualizo la Plantilla : 9', '2023-06-13 02:29:43'),
(285, 2, 'Se Actualizo la Plantilla : 9', '2023-06-13 02:29:52'),
(286, 2, 'Se Actualizo la Plantilla : 9', '2023-06-13 02:32:13'),
(287, 2, 'Se Actualizo la Plantilla : 9', '2023-06-13 02:33:45'),
(288, 2, 'Se Actualizo la Plantilla : 9', '2023-06-13 02:35:12'),
(289, 2, 'Se Actualizo la Plantilla : 9', '2023-06-13 02:35:27'),
(290, 2, 'Se Actualizo la Plantilla : 9', '2023-06-13 02:35:56'),
(291, 2, 'Se Actualizo la Plantilla : 9', '2023-06-13 02:36:23'),
(292, 2, 'Se Actualizo la Plantilla : 9', '2023-06-13 02:42:08'),
(293, 2, 'Se Actualizo la empresa PAULO BENITO BERRIOS DONAIRE con RUT 11.366.273-5 en el sistema', '2023-06-14 19:46:11'),
(294, 2, 'Se Actualizo la Plantilla : 9', '2023-06-14 20:04:04'),
(295, 2, 'Se Actualizo la Plantilla : 9', '2023-06-14 20:04:40'),
(296, 2, 'Se Actualizo la Plantilla : 9', '2023-06-14 20:06:06'),
(297, 2, 'Se Actualizo la Plantilla : 9', '2023-06-14 20:08:39'),
(298, 2, 'Se Actualizo la Plantilla : 9', '2023-06-14 20:09:42'),
(299, 2, 'Se Actualizo la Plantilla : 9', '2023-06-14 20:10:11'),
(300, 2, 'Se Actualizo la Plantilla : 9', '2023-06-14 20:13:01'),
(301, 2, 'Se Actualizo la Plantilla : 9', '2023-06-14 20:30:01'),
(302, 8, 'Se Registro un nuevo contrato de trabajo para el trabajador PATRICIO JACOB MOENA AGUAYO', '2023-06-16 15:40:05'),
(303, 8, 'Se Registro un nuevo contrato de trabajo para el trabajador DANIEL ANDRES CANTILLANA ESPINOSA', '2023-06-16 15:43:04'),
(304, 8, 'Se Registro el Trabajador : RODOLFO ANDRES  con el Rut: 13.261.793-7', '2023-06-16 15:52:38'),
(305, 8, 'Se Registro La informaciÃ³n de Prevision del Trabajador con el id: 12', '2023-06-16 15:54:56'),
(306, 8, 'Se Registro un nuevo contrato de trabajo para el trabajador RODOLFO ANDRES  VALLEJOS REYES', '2023-06-16 15:57:24'),
(307, 2, 'Se Actualizo la Plantilla : 9', '2023-06-16 16:13:00'),
(308, 2, 'Se Actualizo la Plantilla : 9', '2023-06-16 16:14:30'),
(309, 2, 'Se Actualizo la Plantilla : 9', '2023-06-16 16:15:45');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `banco`
--

CREATE TABLE `banco` (
  `id` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `banco`
--

INSERT INTO `banco` (`id`, `nombre`) VALUES
(1, 'Banco de Chile'),
(2, 'Banco Santander'),
(3, 'Banco Estado'),
(4, 'Banco Security'),
(5, 'Banco Itaú'),
(6, 'Banco BCI'),
(7, 'Banco Falabella'),
(8, 'Banco Ripley'),
(9, 'Banco Consorcio'),
(10, 'Banco Internacional'),
(11, 'Banco Edwards Citi'),
(12, 'Banco de Crédito e Inversiones (BCI)'),
(13, 'Banco Penta'),
(14, 'Banco Paris');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cajascompensacion`
--

CREATE TABLE `cajascompensacion` (
  `id` int(11) NOT NULL,
  `codigo` varchar(20) NOT NULL,
  `codigoprevired` varchar(20) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `cajascompensacion`
--

INSERT INTO `cajascompensacion` (`id`, `codigo`, `codigoprevired`, `nombre`) VALUES
(6, '00', '00', 'SIN CCAF'),
(7, '01', '01', 'LOS ANDES'),
(8, '02', '02', 'LA ARAUCANA'),
(9, '03', '03', 'LOS HÃ©ROES'),
(10, '06', '06', '18 DE SEPTIEMBRE');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cargastrabajador`
--

CREATE TABLE `cargastrabajador` (
  `id` int(11) NOT NULL,
  `rut` varchar(20) NOT NULL,
  `nombres` varchar(200) NOT NULL,
  `primerapellido` varchar(200) NOT NULL,
  `segundoapellido` varchar(200) NOT NULL,
  `fechanacimiento` date NOT NULL,
  `civil` int(11) NOT NULL,
  `fechareconocimiento` date NOT NULL,
  `fechapago` date NOT NULL,
  `vigencia` date DEFAULT NULL,
  `tipocausante` int(11) NOT NULL,
  `sexo` int(11) NOT NULL,
  `tipocarga` int(11) NOT NULL,
  `documento` varchar(40) DEFAULT NULL,
  `register_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `trabajador` int(11) NOT NULL,
  `comentario` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cargos`
--

CREATE TABLE `cargos` (
  `id` int(11) NOT NULL,
  `codigo` varchar(20) NOT NULL,
  `codigoprevired` varchar(20) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `empresa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `cargos`
--

INSERT INTO `cargos` (`id`, `codigo`, `codigoprevired`, `nombre`, `empresa`) VALUES
(1, '02', '02', 'CONDUCTOR', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `causalterminocontrato`
--

CREATE TABLE `causalterminocontrato` (
  `id` int(11) NOT NULL,
  `codigo` varchar(20) NOT NULL,
  `codigoprevired` varchar(20) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `causalterminocontrato`
--

INSERT INTO `causalterminocontrato` (`id`, `codigo`, `codigoprevired`, `nombre`) VALUES
(1, '1', '1', 'art 159 nÂ°5 termino de faena');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `centrocosto`
--

CREATE TABLE `centrocosto` (
  `id` int(11) NOT NULL,
  `codigo` varchar(20) NOT NULL,
  `codigoprevired` varchar(20) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `empresa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `centrocosto`
--

INSERT INTO `centrocosto` (`id`, `codigo`, `codigoprevired`, `nombre`, `empresa`) VALUES
(1, '132', '132', 'CONTABILIDAD', 4),
(3, '2', '2', 'PRODUCCION 68478', 4),
(4, '1.1', '1.1', 'EL DELIRIO', 5),
(5, '1.2', '1.2', 'DOS MARIAS', 5),
(6, '01', '01', 'EL DELIRIO', 1),
(7, '02', '02', 'DOS MARIAS', 1),
(8, '01', '01', 'CONTABILIDAD', 2),
(9, '01', '01', 'TURISTICA DEL SUR', 3),
(10, '02', '02', 'TRANSPORTE PUBLICO', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cesantia`
--

CREATE TABLE `cesantia` (
  `id` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `cesantia`
--

INSERT INTO `cesantia` (`id`, `nombre`) VALUES
(1, 'Si'),
(2, 'No');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ciudades`
--

CREATE TABLE `ciudades` (
  `id` int(11) NOT NULL,
  `codigo` varchar(20) NOT NULL,
  `codigoprevired` varchar(20) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `region` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `ciudades`
--

INSERT INTO `ciudades` (`id`, `codigo`, `codigoprevired`, `nombre`, `region`) VALUES
(1, '89', '89', 'CODEGUA', 3),
(2, '80', '80', 'RENGO', 3),
(3, '81', '81', 'REQUINOA', 3),
(4, '94', '94', 'RANCAGUA', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `codigoactividad`
--

CREATE TABLE `codigoactividad` (
  `id` int(11) NOT NULL,
  `codigosii` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `codigoactividad`
--

INSERT INTO `codigoactividad` (`id`, `codigosii`, `nombre`) VALUES
(1, 11101, 'Cultivo de trigo'),
(2, 11102, 'Cultivo de ma?z\"\r\n'),
(3, 11200, 'Cultivo de arroz'),
(4, 11104, 'Cultivo de cebada'),
(5, 11105, 'Cultivo de otros cereales (excepto trigo, ma?z, avena\r\ny cebada)'),
(6, 11902, 'Cultivos forrajeros en praderas mejoradas o\r\nsembradas; cultivos suplementarios forrajeros'),
(7, 11902, 'Cultivos forrajeros en praderas mejoradas o\r\nsembradas; cultivos suplementarios forrajeros'),
(8, 11106, 'Cultivo de porotos'),
(9, 11107, 'Cultivo de lupino'),
(10, 11108, 'Cultivo de otras legumbres (excepto porotos y lupino)'),
(11, 11301, 'Cultivo de papas'),
(12, 11302, 'Cultivo de camotes'),
(13, 11303, 'Cultivo de otros tub?rculos (excepto papas y\r\ncamotes)'),
(14, 11109, 'Cultivo de semillas de raps'),
(15, 11110, 'Cultivo de semillas de maravilla (girasol)'),
(16, 12600, 'Cultivo de frutos oleaginosos (incluye el cultivo de\r\naceitunas)'),
(17, 11111, 'Cultivo de semillas de cereales, legumbres y\r\noleaginosas (excepto semillas de raps y maravilla)'),
(18, 11111, 'Cultivo de semillas de cereales, legumbres y\r\noleaginosas (excepto semillas de raps y maravilla)'),
(19, 11304, 'Cultivo de remolacha azucarera'),
(20, 11500, 'Cultivo de tabaco'),
(21, 16300, 'Actividades poscosecha'),
(22, 11600, 'Cultivo de plantas de fibra'),
(23, 12900, 'Cultivo de otras plantas perennes'),
(24, 12802, 'Cultivo de plantas arom?ticas, medicinales y\r\nfarmac?uticas'),
(25, 12900, 'Cultivo de otras plantas perennes'),
(26, 11400, 'Cultivo de ca?a de az?car'),
(27, 12802, 'Cultivo de plantas arom?ticas, medicinales y\r\nfarmac?uticas'),
(28, 11306, 'Cultivo de hortalizas y melones'),
(29, 12600, 'Cultivo de frutos oleaginosos (incluye el cultivo de\r\naceitunas)'),
(30, 12802, 'Cultivo de plantas arom?ticas, medicinales y\r\nfarmac?uticas'),
(31, 11306, 'Cultivo de hortalizas y melones'),
(32, 11306, 'Cultivo de hortalizas y melones'),
(33, 11901, 'Cultivo de flores'),
(34, 13000, 'Cultivo de plantas vivas incluida la producci?n en\r\nviveros (excepto viveros forestales)'),
(35, 11305, 'Cultivo de semillas de hortalizas'),
(36, 11903, 'Cultivos de semillas de flores; cultivo de semillas de\r\nplantas forrajeras'),
(37, 12501, 'Cultivo de semillas de frutas'),
(38, 13000, 'Cultivo de plantas vivas incluida la producci?n en\r\nviveros (excepto viveros forestales)'),
(39, 11306, 'Cultivo de hortalizas y melones'),
(40, 12900, 'Cultivo de otras plantas perennes'),
(41, 23000, 'Recolecci?n de productos forestales distintos de la\r\nmadera'),
(42, 12111, 'Cultivo de uva destinada a la producci?n de pisco y\r\naguardiente'),
(43, 12112, 'Cultivo de uva destinada a la producci?n de vino'),
(44, 110200, 'Elaboraci?n de vinos'),
(45, 12120, 'Cultivo de uva para mesa'),
(46, 12400, 'Cultivo de frutas de pepita y de hueso'),
(47, 12200, 'Cultivo de frutas tropicales y subtropicales (incluye el\r\ncultivo de paltas)'),
(48, 12300, 'Cultivo de c?tricos'),
(49, 12502, 'Cultivo de otros frutos y nueces de ?rboles y arbustos'),
(50, 12600, 'Cultivo de frutos oleaginosos (incluye el cultivo de\r\naceitunas)'),
(51, 12502, 'Cultivo de otros frutos y nueces de ?rboles y arbustos'),
(52, 23000, 'Recolecci?n de productos forestales distintos de la\r\nmadera'),
(53, 12700, 'Cultivo de plantas con las que se preparan bebidas\r\n(incluye el cultivo de caf?, t? y mate)'),
(54, 12801, 'Cultivo de especias'),
(55, 14101, 'Cr?a de ganado bovino para la producci?n lechera'),
(56, 14102, 'Cr?a de ganado bovino para la producci?n de carne o\r\ncomo ganado reproductor'),
(57, 14410, 'Cr?a de ovejas (ovinos)'),
(58, 14200, 'Cr?a de caballos y otros equinos'),
(59, 14500, 'Cr?a de cerdos'),
(60, 14601, 'Cr?a de aves de corral para la producci?n de carne'),
(61, 14602, 'Cr?a de aves de corral para la producci?n de huevos'),
(62, 14909, 'Cr?a de otros animales n.c.p.'),
(63, 14909, 'Cr?a de otros animales n.c.p.'),
(64, 14901, 'Apicultura'),
(65, 14909, 'Cr?a de otros animales n.c.p.'),
(66, 32200, 'Acuicultura de agua dulce'),
(67, 14909, 'Cr?a de otros animales n.c.p.'),
(68, 14300, 'Cr?a de llamas, alpacas, vicu?as, guanacos y otros\r\ncam?lidos'),
(69, 14420, 'Cr?a de cabras (caprinos)'),
(70, 32130, 'Reproducci?n y cr?a de moluscos, crust?ceos y\r\ngusanos marinos'),
(71, 32200, 'Acuicultura de agua dulce'),
(72, 15000, 'Cultivo de productos agr?colas en combinaci?n con la\r\ncr?a de animales (explotaci?n mixta)'),
(73, 16300, 'Actividades poscosecha'),
(74, 16300, 'Actividades poscosecha'),
(75, 16400, 'Tratamiento de semillas para propagaci?n\"\r\nnull;16100;Actividades de apoyo a la agricultura'),
(76, 16100, 'Actividades de apoyo a la agricultura'),
(77, 16100, 'Actividades de apoyo a la agricultura'),
(78, 16100, 'Actividades de apoyo a la agricultura'),
(79, 813000, 'Actividades de paisajismo, servicios de jardiner?a y\r\nservicios conexos'),
(80, 960901, 'Servicios de adiestramiento, guarder?a, peluquer?a,\r\npaseo de mascotas (excepto act. veterinarias)'),
(81, 16200, 'Actividades de apoyo a la ganader?a\"\r\nnull;17000;Caza ordinaria y mediante trampas y actividades de\r\nservicios conexas'),
(82, 17000, 'Caza ordinaria y mediante trampas y actividades de\r\nservicios conexas'),
(83, 949909, 'Actividades de otras asociaciones n.c.p.'),
(84, 22000, 'Extracci?n de madera'),
(85, 21002, 'Silvicultura y otras actividades forestales (excepto\r\nexplotaci?n de viveros forestales)'),
(86, 23000, 'Recolecci?n de productos forestales distintos de la\r\nmadera'),
(87, 21001, 'Explotaci?n de viveros forestales'),
(88, 12900, 'Cultivo de otras plantas perennes'),
(89, 24001, 'Servicios de forestaci?n a cambio de una retribuci?n\r\no por contrata'),
(90, 24002, 'Servicios de corta de madera a cambio de una\r\nretribuci?n o por contrata'),
(91, 24003, 'Servicios de extinci?n y prevenci?n de incendios\r\nforestales'),
(92, 24009, 'Otros servicios de apoyo a la silvicultura n.c.p.'),
(93, 32200, 'Acuicultura de agua dulce'),
(94, 32110, 'Cultivo y crianza de peces marinos'),
(95, 32120, 'Cultivo, reproducci?n y manejo de algas marinas'),
(96, 32130, 'Reproducci?n y cr?a de moluscos, crust?ceos y\r\ngusanos marinos'),
(97, 32140, 'Servicios relacionados con la acuicultura marina'),
(98, 32200, 'Acuicultura de agua dulce'),
(99, 31110, 'Pesca mar?tima industrial, excepto de barcos factor?a\"\r\nnull;102050;Actividades de elaboraci?n y conservaci?n de\r\npescado, realizadas en barcos factor?a\"\r\nnull;31120;Pesca mar?tima artesanal'),
(100, 31200, 'Pesca de agua dulce'),
(101, 31130, 'Recolecci?n y extracci?n de productos marinos'),
(102, 31140, 'Servicios relacionados con la pesca mar?tima'),
(103, 31200, 'Pesca de agua dulce'),
(104, 51000, 'Extracci?n de carb?n de piedra'),
(105, 52000, 'Extracci?n de lignito'),
(106, 89200, 'Extracci?n de turba'),
(107, 99001, 'Actividades de apoyo para la explotaci?n de otras\r\nminas y canteras prestados por empresas'),
(108, 192000, 'Fabricaci?n de productos de la refinaci?n del petr?leo'),
(109, 61000, 'Extracci?n de petr?leo crudo'),
(110, 62000, 'Extracci?n de gas natural'),
(111, 91001, 'Actividades de apoyo para la extracci?n de petr?leo y\r\ngas natural prestados por empresas'),
(112, 91001, 'Actividades de apoyo para la extracci?n de petr?leo y\r\ngas natural prestados por empresas'),
(113, 72100, 'Extracci?n de minerales de uranio y torio'),
(114, 99001, 'Actividades de apoyo para la explotaci?n de otras\r\nminas y canteras prestados por empresas'),
(115, 71000, 'Extracci?n de minerales de hierro'),
(116, 99001, 'Actividades de apoyo para la explotaci?n de otras\r\nminas y canteras prestados por empresas'),
(117, 72910, 'Extracci?n de oro y plata'),
(118, 99001, 'Actividades de apoyo para la explotaci?n de otras\r\nminas y canteras prestados por empresas'),
(119, 72991, 'Extracci?n de zinc y plomo'),
(120, 99001, 'Actividades de apoyo para la explotaci?n de otras\r\nminas y canteras prestados por empresas'),
(121, 72992, 'Extracci?n de manganeso'),
(122, 99001, 'Actividades de apoyo para la explotaci?n de otras\r\nminas y canteras prestados por empresas'),
(123, 72999, 'Extracci?n de otros minerales metal?feros no ferrosos\r\nn.c.p. (excepto zinc, plomo y manganeso)'),
(124, 99001, 'Actividades de apoyo para la explotaci?n de otras\r\nminas y canteras prestados por empresas'),
(125, 40000, 'Extracci?n y procesamiento de cobre'),
(126, 99001, 'Actividades de apoyo para la explotaci?n de otras\r\nminas y canteras prestados por empresas'),
(127, 81000, 'Extracci?n de piedra, arena y arcilla'),
(128, 99001, 'Actividades de apoyo para la explotaci?n de otras\r\nminas y canteras prestados por empresas'),
(129, 89190, 'Extracci?n de minerales para la fabricaci?n de\r\nabonos y productos qu?micos n.c.p.'),
(130, 99001, 'Actividades de apoyo para la explotaci?n de otras\r\nminas y canteras prestados por empresas'),
(131, 89300, 'Extracci?n de sal'),
(132, 99001, 'Actividades de apoyo para la explotaci?n de otras\r\nminas y canteras prestados por empresas'),
(133, 89110, 'Extracci?n y procesamiento de litio'),
(134, 89190, 'Extracci?n de minerales para la fabricaci?n de\r\nabonos y productos qu?micos n.c.p.'),
(135, 99001, 'Actividades de apoyo para la explotaci?n de otras\r\nminas y canteras prestados por empresas'),
(136, 89900, 'Explotaci?n de otras minas y canteras n.c.p.'),
(137, 81000, 'Extracci?n de piedra, arena y arcilla'),
(138, 99001, 'Actividades de apoyo para la explotaci?n de otras\r\nminas y canteras prestados por empresas'),
(139, 101011, 'Explotaci?n de mataderos de bovinos, ovinos,\r\nequinos, caprinos, porcinos y cam?lidos'),
(140, 521001, 'Explotaci?n de frigor?ficos para almacenamiento y\r\ndep?sito'),
(141, 101019, 'Explotaci?n de mataderos de aves y de otros tipos de\r\nanimales n.c.p.'),
(142, 101020, 'Elaboraci?n y conservaci?n de carne y productos\r\nc?rnicos'),
(143, 102010, 'Producci?n de harina de pescado'),
(144, 102030, 'Elaboraci?n y conservaci?n de otros pescados, en\r\nplantas en tierra (excepto barcos factor?a)'),
(145, 102020, 'Elaboraci?n y conservaci?n de salm?nidos'),
(146, 102040, 'Elaboraci?n y conservaci?n de crust?ceos, moluscos\r\ny otros productos acu?ticos, en plantas en tierra'),
(147, 107500, 'Elaboraci?n de comidas y platos preparados\r\nenvasados, rotulados y con informaci?n nutricional'),
(148, 102020, 'Elaboraci?n y conservaci?n de salm?nidos'),
(149, 102030, 'Elaboraci?n y conservaci?n de otros pescados, en\r\nplantas en tierra (excepto barcos factor?a)'),
(150, 102040, 'Elaboraci?n y conservaci?n de crust?ceos, moluscos\r\ny otros productos acu?ticos, en plantas en tierra'),
(151, 107500, 'Elaboraci?n de comidas y platos preparados\r\nenvasados, rotulados y con informaci?n nutricional'),
(152, 102020, 'Elaboraci?n y conservaci?n de salm?nidos'),
(153, 102030, 'Elaboraci?n y conservaci?n de otros pescados, en\r\nplantas en tierra (excepto barcos factor?a)'),
(154, 102040, 'Elaboraci?n y conservaci?n de crust?ceos, moluscos\r\ny otros productos acu?ticos, en plantas en tierra'),
(155, 102060, 'Elaboraci?n y procesamiento de algas'),
(156, 103000, 'Elaboraci?n y conservaci?n de frutas, legumbres y\r\nhortalizas'),
(157, 107500, 'Elaboraci?n de comidas y platos preparados\r\nenvasados, rotulados y con informaci?n nutricional'),
(158, 104000, 'Elaboraci?n de aceites y grasas de origen vegetal y\r\nanimal (excepto elaboraci?n de mantequilla)'),
(159, 104000, 'Elaboraci?n de aceites y grasas de origen vegetal y\r\nanimal (excepto elaboraci?n de mantequilla)'),
(160, 104000, 'Elaboraci?n de aceites y grasas de origen vegetal y\r\nanimal (excepto elaboraci?n de mantequilla)'),
(161, 105000, 'Elaboraci?n de productos l?cteos'),
(162, 105000, 'Elaboraci?n de productos l?cteos'),
(163, 105000, 'Elaboraci?n de productos l?cteos'),
(164, 106101, 'Molienda de trigo: producci?n de harina, s?mola y\r\ngr?nulos'),
(165, 106102, 'Molienda de arroz; producci?n de harina de arroz'),
(166, 106109, 'Elaboraci?n de otros productos de moliner?a n.c.p.'),
(167, 106200, 'Elaboraci?n de almidones y productos derivados del\r\nalmid?n\"\r\nnull;106200;Elaboraci?n de almidones y productos derivados del\r\nalmid?n\"\r\nnull;108000;Elaboraci?n de piensos preparados para animales'),
(168, 107100, 'Elaboraci?n de productos de panader?a y pasteler?a\"\r\nnull;107100;Elaboraci?n de productos de panader?a y pasteler?a\"\r\nnull;107200;Elaboraci?n de az?car'),
(169, 107300, 'Elaboraci?n de cacao, chocolate y de productos de\r\nconfiter?a\"\r\nnull;107300;Elaboraci?n de cacao, chocolate y de productos de\r\nconfiter?a\"\r\nnull;107400;Elaboraci?n de macarrones, fideos, alcuzcuz y\r\np'),
(170, 107500, 'Elaboraci?n de comidas y platos preparados\r\nenvasados, rotulados y con informaci?n nutricional'),
(171, 107901, 'Elaboraci?n de t?, caf?, mate e infusiones de hierbas'),
(172, 107902, 'Elaboraci?n de levaduras naturales o artificiales'),
(173, 107903, 'Elaboraci?n de vinagres, mostazas, mayonesas y\r\ncondimentos en general'),
(174, 107909, 'Elaboraci?n de otros productos alimenticios n.c.p.'),
(175, 103000, 'Elaboraci?n y conservaci?n de frutas, legumbres y\r\nhortalizas'),
(176, 107100, 'Elaboraci?n de productos de panader?a y pasteler?a\"\r\nnull;107500;Elaboraci?n de comidas y platos preparados\r\nenvasados, rotulados y con informaci?n nutricional'),
(177, 110110, 'Elaboraci?n de pisco (industrias pisqueras)'),
(178, 110120, 'Destilaci?n, rectificaci?n y mezclas de bebidas\r\nalcoh?licas; excepto pisco'),
(179, 201109, 'Fabricaci?n de otras sustancias qu?micas b?sicas\r\nn.c.p.'),
(180, 110200, 'Elaboraci?n de vinos'),
(181, 110300, 'Elaboraci?n de bebidas malteadas y de malta'),
(182, 110401, 'Elaboraci?n de bebidas no alcoh?licas'),
(183, 110402, 'Producci?n de aguas minerales y otras aguas\r\nembotelladas'),
(184, 353002, 'Elaboraci?n de hielo (excepto fabricaci?n de hielo\r\nseco)'),
(185, 120001, 'Elaboraci?n de cigarros y cigarrillos'),
(186, 120009, 'Elaboraci?n de otros productos de tabaco n.c.p.'),
(187, 131200, 'Tejedura de productos textiles'),
(188, 131100, 'Preparaci?n e hilatura de fibras textiles'),
(189, 131300, 'Acabado de productos textiles'),
(190, 952900, 'Reparaci?n de otros efectos personales y enseres\r\ndom?sticos'),
(191, 139200, 'Fabricaci?n de art?culos confeccionados de\r\nmateriales textiles, excepto prendas de vestir'),
(192, 325009, 'Fabricaci?n de instrumentos y materiales m?dicos,\r\noftalmol?gicos y odontol?gicos n.c.p.'),
(193, 331900, 'Reparaci?n de otros tipos de equipo'),
(194, 139300, 'Fabricaci?n de tapices y alfombras'),
(195, 139400, 'Fabricaci?n de cuerdas, cordeles, bramantes y redes'),
(196, 331900, 'Reparaci?n de otros tipos de equipo'),
(197, 139900, 'Fabricaci?n de otros productos textiles n.c.p.'),
(198, 131300, 'Acabado de productos textiles'),
(199, 139900, 'Fabricaci?n de otros productos textiles n.c.p.'),
(200, 170900, 'Fabricaci?n de otros art?culos de papel y cart?n\"\r\nnull;143000;Fabricaci?n de art?culos de punto y ganchillo'),
(201, 139100, 'Fabricaci?n de tejidos de punto y ganchillo'),
(202, 141001, 'Fabricaci?n de prendas de vestir de materiales\r\ntextiles y similares'),
(203, 131300, 'Acabado de productos textiles'),
(204, 141002, 'Fabricaci?n de prendas de vestir de cuero natural o\r\nartificial'),
(205, 141003, 'Fabricaci?n de accesorios de vestir'),
(206, 141004, 'Fabricaci?n de ropa de trabajo'),
(207, 131300, 'Acabado de productos textiles'),
(208, 329000, 'Otras industrias manufactureras n.c.p.'),
(209, 151100, 'Curtido y adobo de cueros; adobo y te?ido de pieles'),
(210, 142000, 'Fabricaci?n de art?culos de piel'),
(211, 151100, 'Curtido y adobo de cueros; adobo y te?ido de pieles'),
(212, 151200, 'Fabricaci?n de maletas, bolsos y art?culos similares,\r\nart?culos de talabarter?a y guarnicioner?a\"\r\nnull;329000;Otras industrias manufactureras n.c.p.'),
(213, 152000, 'Fabricaci?n de calzado'),
(214, 151200, 'Fabricaci?n de maletas, bolsos y art?culos similares,\r\nart?culos de talabarter?a y guarnicioner?a\"\r\nnull;162900;Fabricaci?n de otros productos de madera, de\r\nart?culos de corcho, paja y materiales tre'),
(215, 221900, 'Fabricaci?n de otros productos de caucho'),
(216, 222000, 'Fabricaci?n de productos de pl?stico'),
(217, 323000, 'Fabricaci?n de art?culos de deporte'),
(218, 161000, 'Aserrado y acepilladura de madera'),
(219, 162100, 'Fabricaci?n de hojas de madera para enchapado y\r\ntableros a base de madera'),
(220, 162200, 'Fabricaci?n de partes y piezas de carpinter?a para\r\nedificios y construcciones'),
(221, 162300, 'Fabricaci?n de recipientes de madera'),
(222, 331900, 'Reparaci?n de otros tipos de equipo'),
(223, 162900, 'Fabricaci?n de otros productos de madera, de\r\nart?culos de corcho, paja y materiales trenzables'),
(224, 329000, 'Otras industrias manufactureras n.c.p.'),
(225, 331900, 'Reparaci?n de otros tipos de equipo'),
(226, 170110, 'Fabricaci?n de celulosa y otras pastas de madera'),
(227, 170190, 'Fabricaci?n de papel y cart?n para su posterior uso\r\nindustrial n.c.p.'),
(228, 170190, 'Fabricaci?n de papel y cart?n para su posterior uso\r\nindustrial n.c.p.'),
(229, 170200, 'Fabricaci?n de papel y cart?n ondulado y de envases\r\nde papel y cart?n\"\r\nnull;170900;Fabricaci?n de otros art?culos de papel y cart?n\"\r\nnull;181109;Otras actividades de impresi?n n.c.p.'),
(230, 222000, 'Fabricaci?n de productos de pl?stico'),
(231, 581100, 'Edici?n de libros'),
(232, 581200, 'Edici?n de directorios y listas de correo'),
(233, 329000, 'Otras industrias manufactureras n.c.p.'),
(234, 592000, 'Actividades de grabaci?n de sonido y edici?n de\r\nm?sica'),
(235, 581300, 'Edici?n de diarios, revistas y otras publicaciones\r\nperi?dicas'),
(236, 592000, 'Actividades de grabaci?n de sonido y edici?n de\r\nm?sica'),
(237, 581900, 'Otras actividades de edici?n\"\r\nnull;581300;Edici?n de diarios, revistas y otras publicaciones\r\nperi?dicas'),
(238, 181101, 'Impresi?n de libros'),
(239, 181109, 'Otras actividades de impresi?n n.c.p.'),
(240, 170900, 'Fabricaci?n de otros art?culos de papel y cart?n\"\r\nnull;181200;Actividades de servicios relacionadas con la\r\nimpresi?n\"\r\nnull;182000;Reproducci?n de grabaciones'),
(241, 191000, 'Fabricaci?n de productos de hornos de coque'),
(242, 192000, 'Fabricaci?n de productos de la refinaci?n del petr?leo'),
(243, 201109, 'Fabricaci?n de otras sustancias qu?micas b?sicas\r\nn.c.p.'),
(244, 210000, 'Fabricaci?n de productos farmac?uticos, sustancias\r\nqu?micas medicinales y productos bot?nicos'),
(245, 242009, 'Fabricaci?n de productos primarios de metales\r\npreciosos y de otros metales no ferrosos n.c.p.'),
(246, 381200, 'Recogida de desechos peligrosos'),
(247, 382200, 'Tratamiento y eliminaci?n de desechos peligrosos'),
(248, 201101, 'Fabricaci?n de carb?n vegetal (excepto activado);\r\nfabricaci?n de briquetas de carb?n vegetal'),
(249, 201109, 'Fabricaci?n de otras sustancias qu?micas b?sicas\r\nn.c.p.'),
(250, 191000, 'Fabricaci?n de productos de hornos de coque'),
(251, 201200, 'Fabricaci?n de abonos y compuestos de nitr?geno'),
(252, 382100, 'Tratamiento y eliminaci?n de desechos no peligrosos'),
(253, 201300, 'Fabricaci?n de pl?sticos y caucho sint?tico en formas\r\nprimarias'),
(254, 202100, 'Fabricaci?n de plaguicidas y otros productos\r\nqu?micos de uso agropecuario'),
(255, 202200, 'Fabricaci?n de pinturas, barnices y productos de\r\nrevestimiento, tintas de imprenta y masillas'),
(256, 210000, 'Fabricaci?n de productos farmac?uticos, sustancias\r\nqu?micas medicinales y productos bot?nicos'),
(257, 325009, 'Fabricaci?n de instrumentos y materiales m?dicos,\r\noftalmol?gicos y odontol?gicos n.c.p.'),
(258, 202300, 'Fabricaci?n de jabones y detergentes, preparados\r\npara limpiar, perfumes y preparados de tocador'),
(259, 202901, 'Fabricaci?n de explosivos y productos pirot?cnicos'),
(260, 202909, 'Fabricaci?n de otros productos qu?micos n.c.p.'),
(261, 107909, 'Elaboraci?n de otros productos alimenticios n.c.p.'),
(262, 201109, 'Fabricaci?n de otras sustancias qu?micas b?sicas\r\nn.c.p.'),
(263, 261000, 'Fabricaci?n de componentes y tableros electr?nicos'),
(264, 268000, 'Fabricaci?n de soportes magn?ticos y ?pticos'),
(265, 281700, 'Fabricaci?n de maquinaria y equipo de oficina\r\n(excepto computadores y equipo perif?rico)'),
(266, 203000, 'Fabricaci?n de fibras artificiales'),
(267, 221100, 'Fabricaci?n de cubiertas y c?maras de caucho;\r\nrecauchutado y renovaci?n de cubiertas de caucho'),
(268, 221100, 'Fabricaci?n de cubiertas y c?maras de caucho;\r\nrecauchutado y renovaci?n de cubiertas de caucho'),
(269, 221900, 'Fabricaci?n de otros productos de caucho'),
(270, 222000, 'Fabricaci?n de productos de pl?stico'),
(271, 281200, 'Fabricaci?n de equipo de propulsi?n de fluidos'),
(272, 329000, 'Otras industrias manufactureras n.c.p.'),
(273, 331900, 'Reparaci?n de otros tipos de equipo'),
(274, 222000, 'Fabricaci?n de productos de pl?stico'),
(275, 222000, 'Fabricaci?n de productos de pl?stico'),
(276, 222000, 'Fabricaci?n de productos de pl?stico'),
(277, 261000, 'Fabricaci?n de componentes y tableros electr?nicos'),
(278, 273300, 'Fabricaci?n de dispositivos de cableado'),
(279, 329000, 'Otras industrias manufactureras n.c.p.'),
(280, 331400, 'Reparaci?n de equipo el?ctrico (excepto reparaci?n\r\nde equipo y enseres dom?sticos)'),
(281, 331900, 'Reparaci?n de otros tipos de equipo'),
(282, 231001, 'Fabricaci?n de vidrio plano'),
(283, 231002, 'Fabricaci?n de vidrio hueco'),
(284, 231003, 'Fabricaci?n de fibras de vidrio'),
(285, 231009, 'Fabricaci?n de productos de vidrio n.c.p.'),
(286, 331900, 'Reparaci?n de otros tipos de equipo'),
(287, 239300, 'Fabricaci?n de otros productos de porcelana y de\r\ncer?mica'),
(288, 239300, 'Fabricaci?n de otros productos de porcelana y de\r\ncer?mica'),
(289, 239200, 'Fabricaci?n de materiales de construcci?n de arcilla'),
(290, 239100, 'Fabricaci?n de productos refractarios'),
(291, 239200, 'Fabricaci?n de materiales de construcci?n de arcilla'),
(292, 239400, 'Fabricaci?n de cemento, cal y yeso'),
(293, 239500, 'Fabricaci?n de art?culos de hormig?n, cemento y\r\nyeso'),
(294, 239500, 'Fabricaci?n de art?culos de hormig?n, cemento y\r\nyeso'),
(295, 239500, 'Fabricaci?n de art?culos de hormig?n, cemento y\r\nyeso'),
(296, 239500, 'Fabricaci?n de art?culos de hormig?n, cemento y\r\nyeso'),
(297, 239600, 'Corte, talla y acabado de la piedra'),
(298, 239900, 'Fabricaci?n de otros productos minerales no\r\nmet?licos n.c.p.'),
(299, 239900, 'Fabricaci?n de otros productos minerales no\r\nmet?licos n.c.p.'),
(300, 131200, 'Tejedura de productos textiles'),
(301, 329000, 'Otras industrias manufactureras n.c.p.'),
(302, 331900, 'Reparaci?n de otros tipos de equipo'),
(303, 241000, 'Industrias b?sicas de hierro y acero'),
(304, 243100, 'Fundici?n de hierro y acero'),
(305, 242001, 'Fabricaci?n de productos primarios de cobre'),
(306, 242002, 'Fabricaci?n de productos primarios de aluminio'),
(307, 242009, 'Fabricaci?n de productos primarios de metales\r\npreciosos y de otros metales no ferrosos n.c.p.'),
(308, 243100, 'Fundici?n de hierro y acero'),
(309, 243200, 'Fundici?n de metales no ferrosos'),
(310, 251100, 'Fabricaci?n de productos met?licos para uso\r\nestructural'),
(311, 331100, 'Reparaci?n de productos elaborados de metal'),
(312, 251201, 'Fabricaci?n de recipientes de metal para gases\r\ncomprimidos o licuados'),
(313, 251209, 'Fabricaci?n de tanques, dep?sitos y recipientes de\r\nmetal n.c.p.'),
(314, 331100, 'Reparaci?n de productos elaborados de metal'),
(315, 251300, 'Fabricaci?n de generadores de vapor, excepto\r\ncalderas de agua caliente para calefacci?n central'),
(316, 331100, 'Reparaci?n de productos elaborados de metal'),
(317, 332000, 'Instalaci?n de maquinaria y equipos industriales'),
(318, 259100, 'Forja, prensado, estampado y laminado de metales;\r\npulvimetalurgia'),
(319, 259200, 'Tratamiento y revestimiento de metales; maquinado'),
(320, 16200, 'Actividades de apoyo a la ganader?a\"\r\nnull;181109;Otras actividades de impresi?n n.c.p.'),
(321, 331100, 'Reparaci?n de productos elaborados de metal'),
(322, 952900, 'Reparaci?n de otros efectos personales y enseres\r\ndom?sticos'),
(323, 259300, 'Fabricaci?n de art?culos de cuchiller?a, herramientas\r\nde mano y art?culos de ferreter?a\"\r\nnull;331100;Reparaci?n de productos elaborados de metal'),
(324, 259300, 'Fabricaci?n de art?culos de cuchiller?a, herramientas\r\nde mano y art?culos de ferreter?a\"\r\nnull;331100;Reparaci?n de productos elaborados de metal'),
(325, 259900, 'Fabricaci?n de otros productos elaborados de metal\r\nn.c.p.'),
(326, 259900, 'Fabricaci?n de otros productos elaborados de metal\r\nn.c.p.'),
(327, 281700, 'Fabricaci?n de maquinaria y equipo de oficina\r\n(excepto computadores y equipo perif?rico)'),
(328, 329000, 'Otras industrias manufactureras n.c.p.'),
(329, 331100, 'Reparaci?n de productos elaborados de metal'),
(330, 281100, 'Fabricaci?n de motores y turbinas, excepto para\r\naeronaves, veh?culos automotores y motocicletas'),
(331, 331209, 'Reparaci?n de otro tipo de maquinaria y equipos\r\nindustriales n.c.p.'),
(332, 332000, 'Instalaci?n de maquinaria y equipos industriales'),
(333, 281300, 'Fabricaci?n de otras bombas, compresores, grifos y\r\nv?lvulas'),
(334, 281100, 'Fabricaci?n de motores y turbinas, excepto para\r\naeronaves, veh?culos automotores y motocicletas'),
(335, 281200, 'Fabricaci?n de equipo de propulsi?n de fluidos'),
(336, 331209, 'Reparaci?n de otro tipo de maquinaria y equipos\r\nindustriales n.c.p.'),
(337, 332000, 'Instalaci?n de maquinaria y equipos industriales'),
(338, 281400, 'Fabricaci?n de cojinetes, engranajes, trenes de\r\nengranajes y piezas de transmisi?n\"\r\nnull;281200;Fabricaci?n de equipo de propulsi?n de fluidos'),
(339, 331209, 'Reparaci?n de otro tipo de maquinaria y equipos\r\nindustriales n.c.p.'),
(340, 281500, 'Fabricaci?n de hornos, calderas y quemadores'),
(341, 331209, 'Reparaci?n de otro tipo de maquinaria y equipos\r\nindustriales n.c.p.'),
(342, 332000, 'Instalaci?n de maquinaria y equipos industriales'),
(343, 281600, 'Fabricaci?n de equipo de elevaci?n y manipulaci?n\"\r\nnull;331209;Reparaci?n de otro tipo de maquinaria y equipos\r\nindustriales n.c.p.'),
(344, 332000, 'Instalaci?n de maquinaria y equipos industriales'),
(345, 281900, 'Fabricaci?n de otros tipos de maquinaria de uso\r\ngeneral'),
(346, 325009, 'Fabricaci?n de instrumentos y materiales m?dicos,\r\noftalmol?gicos y odontol?gicos n.c.p.'),
(347, 331209, 'Reparaci?n de otro tipo de maquinaria y equipos\r\nindustriales n.c.p.'),
(348, 332000, 'Instalaci?n de maquinaria y equipos industriales'),
(349, 282100, 'Fabricaci?n de maquinaria agropecuaria y forestal'),
(350, 331201, 'Reparaci?n de maquinaria agropecuaria y forestal'),
(351, 332000, 'Instalaci?n de maquinaria y equipos industriales'),
(352, 282200, 'Fabricaci?n de maquinaria para la conformaci?n de\r\nmetales y de m?quinas herramienta'),
(353, 279000, 'Fabricaci?n de otros tipos de equipo el?ctrico'),
(354, 281800, 'Fabricaci?n de herramientas de mano motorizadas'),
(355, 281900, 'Fabricaci?n de otros tipos de maquinaria de uso\r\ngeneral'),
(356, 331209, 'Reparaci?n de otro tipo de maquinaria y equipos\r\nindustriales n.c.p.'),
(357, 331400, 'Reparaci?n de equipo el?ctrico (excepto reparaci?n\r\nde equipo y enseres dom?sticos)'),
(358, 332000, 'Instalaci?n de maquinaria y equipos industriales'),
(359, 282300, 'Fabricaci?n de maquinaria metal?rgica'),
(360, 331202, 'Reparaci?n de maquinaria metal?rgica, para la\r\nminer?a, extracci?n de petr?leo y para la construcci?n\"\r\nnull;332000;Instalaci?n de maquinaria y equipos industriales'),
(361, 282400, 'Fabricaci?n de maquinaria para la explotaci?n de\r\nminas y canteras y para obras de construcci?n\"\r\nnull;282400;Fabricaci?n de maquinaria para la explotaci?n de\r\nminas y canteras y para obras de constru'),
(362, 282500, 'Fabricaci?n de maquinaria para la elaboraci?n de\r\nalimentos, bebidas y tabaco'),
(363, 331203, 'Reparaci?n de maquinaria para la elaboraci?n de\r\nalimentos, bebidas y tabaco'),
(364, 332000, 'Instalaci?n de maquinaria y equipos industriales'),
(365, 282600, 'Fabricaci?n de maquinaria para la elaboraci?n de\r\nproductos textiles, prendas de vestir y cueros'),
(366, 331204, 'Reparaci?n de maquinaria para producir textiles,\r\nprendas de vestir, art?culos de cuero y calzado'),
(367, 332000, 'Instalaci?n de maquinaria y equipos industriales'),
(368, 252000, 'Fabricaci?n de armas y municiones'),
(369, 303000, 'Fabricaci?n de aeronaves, naves espaciales y\r\nmaquinaria conexa'),
(370, 304000, 'Fabricaci?n de veh?culos militares de combate'),
(371, 331100, 'Reparaci?n de productos elaborados de metal'),
(372, 282900, 'Fabricaci?n de otros tipos de maquinaria de uso\r\nespecial'),
(373, 259300, 'Fabricaci?n de art?culos de cuchiller?a, herramientas\r\nde mano y art?culos de ferreter?a\"\r\nnull;279000;Fabricaci?n de otros tipos de equipo el?ctrico'),
(374, 282600, 'Fabricaci?n de maquinaria para la elaboraci?n de\r\nproductos textiles, prendas de vestir y cueros'),
(375, 331209, 'Reparaci?n de otro tipo de maquinaria y equipos\r\nindustriales n.c.p.'),
(376, 331100, 'Reparaci?n de productos elaborados de metal'),
(377, 331400, 'Reparaci?n de equipo el?ctrico (excepto reparaci?n\r\nde equipo y enseres dom?sticos)'),
(378, 332000, 'Instalaci?n de maquinaria y equipos industriales'),
(379, 275000, 'Fabricaci?n de aparatos de uso dom?stico'),
(380, 281500, 'Fabricaci?n de hornos, calderas y quemadores'),
(381, 281900, 'Fabricaci?n de otros tipos de maquinaria de uso\r\ngeneral'),
(382, 262000, 'Fabricaci?n de computadores y equipo perif?rico'),
(383, 261000, 'Fabricaci?n de componentes y tableros electr?nicos'),
(384, 332000, 'Instalaci?n de maquinaria y equipos industriales'),
(385, 281700, 'Fabricaci?n de maquinaria y equipo de oficina\r\n(excepto computadores y equipo perif?rico)'),
(386, 332000, 'Instalaci?n de maquinaria y equipos industriales'),
(387, 271000, 'Fabricaci?n de motores, generadores y\r\ntransformadores el?ctricos, aparatos de distribuci?n y\r\ncontrol'),
(388, 261000, 'Fabricaci?n de componentes y tableros electr?nicos'),
(389, 279000, 'Fabricaci?n de otros tipos de equipo el?ctrico'),
(390, 281100, 'Fabricaci?n de motores y turbinas, excepto para\r\naeronaves, veh?culos automotores y motocicletas'),
(391, 331400, 'Reparaci?n de equipo el?ctrico (excepto reparaci?n\r\nde equipo y enseres dom?sticos)'),
(392, 331209, 'Reparaci?n de otro tipo de maquinaria y equipos\r\nindustriales n.c.p.'),
(393, 332000, 'Instalaci?n de maquinaria y equipos industriales'),
(394, 271000, 'Fabricaci?n de motores, generadores y\r\ntransformadores el?ctricos, aparatos de distribuci?n y\r\ncontrol'),
(395, 261000, 'Fabricaci?n de componentes y tableros electr?nicos'),
(396, 273300, 'Fabricaci?n de dispositivos de cableado'),
(397, 279000, 'Fabricaci?n de otros tipos de equipo el?ctrico'),
(398, 331400, 'Reparaci?n de equipo el?ctrico (excepto reparaci?n\r\nde equipo y enseres dom?sticos)'),
(399, 273200, 'Fabricaci?n de otros hilos y cables el?ctricos'),
(400, 261000, 'Fabricaci?n de componentes y tableros electr?nicos'),
(401, 273100, 'Fabricaci?n de cables de fibra ?ptica'),
(402, 279000, 'Fabricaci?n de otros tipos de equipo el?ctrico'),
(403, 331400, 'Reparaci?n de equipo el?ctrico (excepto reparaci?n\r\nde equipo y enseres dom?sticos)'),
(404, 272000, 'Fabricaci?n de pilas, bater?as y acumuladores'),
(405, 331400, 'Reparaci?n de equipo el?ctrico (excepto reparaci?n\r\nde equipo y enseres dom?sticos)'),
(406, 274000, 'Fabricaci?n de equipo el?ctrico de iluminaci?n\"\r\nnull;279000;Fabricaci?n de otros tipos de equipo el?ctrico'),
(407, 331400, 'Reparaci?n de equipo el?ctrico (excepto reparaci?n\r\nde equipo y enseres dom?sticos)'),
(408, 279000, 'Fabricaci?n de otros tipos de equipo el?ctrico'),
(409, 259900, 'Fabricaci?n de otros productos elaborados de metal\r\nn.c.p.'),
(410, 263000, 'Fabricaci?n de equipo de comunicaciones'),
(411, 265100, 'Fabricaci?n de equipo de medici?n, prueba,\r\nnavegaci?n y control'),
(412, 273300, 'Fabricaci?n de dispositivos de cableado'),
(413, 274000, 'Fabricaci?n de equipo el?ctrico de iluminaci?n\"\r\nnull;282200;Fabricaci?n de maquinaria para la conformaci?n de\r\nmetales y de m?quinas herramienta'),
(414, 293000, 'Fabricaci?n de partes, piezas y accesorios para\r\nveh?culos automotores'),
(415, 302000, 'Fabricaci?n de locomotoras y material rodante'),
(416, 331400, 'Reparaci?n de equipo el?ctrico (excepto reparaci?n\r\nde equipo y enseres dom?sticos)'),
(417, 331309, 'Reparaci?n de otros equipos electr?nicos y ?pticos\r\nn.c.p.'),
(418, 261000, 'Fabricaci?n de componentes y tableros electr?nicos'),
(419, 279000, 'Fabricaci?n de otros tipos de equipo el?ctrico'),
(420, 331400, 'Reparaci?n de equipo el?ctrico (excepto reparaci?n\r\nde equipo y enseres dom?sticos)'),
(421, 263000, 'Fabricaci?n de equipo de comunicaciones'),
(422, 265100, 'Fabricaci?n de equipo de medici?n, prueba,\r\nnavegaci?n y control'),
(423, 951200, 'Reparaci?n de equipo de comunicaciones (incluye la\r\nreparaci?n tel?fonos celulares)'),
(424, 331309, 'Reparaci?n de otros equipos electr?nicos y ?pticos\r\nn.c.p.'),
(425, 332000, 'Instalaci?n de maquinaria y equipos industriales'),
(426, 264000, 'Fabricaci?n de aparatos electr?nicos de consumo'),
(427, 261000, 'Fabricaci?n de componentes y tableros electr?nicos'),
(428, 263000, 'Fabricaci?n de equipo de comunicaciones'),
(429, 267000, 'Fabricaci?n de instrumentos ?pticos y equipo\r\nfotogr?fico'),
(430, 281700, 'Fabricaci?n de maquinaria y equipo de oficina\r\n(excepto computadores y equipo perif?rico)'),
(431, 331209, 'Reparaci?n de otro tipo de maquinaria y equipos\r\nindustriales n.c.p.'),
(432, 331309, 'Reparaci?n de otros equipos electr?nicos y ?pticos\r\nn.c.p.'),
(433, 952100, 'Reparaci?n de aparatos electr?nicos de consumo\r\n(incluye aparatos de televisi?n y radio)'),
(434, 325009, 'Fabricaci?n de instrumentos y materiales m?dicos,\r\noftalmol?gicos y odontol?gicos n.c.p.'),
(435, 266000, 'Fabricaci?n de equipo de irradiaci?n y equipo\r\nelectr?nico de uso m?dico y terap?utico'),
(436, 329000, 'Otras industrias manufactureras n.c.p.'),
(437, 325001, 'Actividades de laboratorios dentales'),
(438, 331309, 'Reparaci?n de otros equipos electr?nicos y ?pticos\r\nn.c.p.'),
(439, 331900, 'Reparaci?n de otros tipos de equipo'),
(440, 332000, 'Instalaci?n de maquinaria y equipos industriales'),
(441, 265100, 'Fabricaci?n de equipo de medici?n, prueba,\r\nnavegaci?n y control'),
(442, 267000, 'Fabricaci?n de instrumentos ?pticos y equipo\r\nfotogr?fico'),
(443, 281900, 'Fabricaci?n de otros tipos de maquinaria de uso\r\ngeneral'),
(444, 282900, 'Fabricaci?n de otros tipos de maquinaria de uso\r\nespecial'),
(445, 325009, 'Fabricaci?n de instrumentos y materiales m?dicos,\r\noftalmol?gicos y odontol?gicos n.c.p.'),
(446, 331301, 'Reparaci?n de equipo de medici?n, prueba,\r\nnavegaci?n y control'),
(447, 331900, 'Reparaci?n de otros tipos de equipo'),
(448, 265100, 'Fabricaci?n de equipo de medici?n, prueba,\r\nnavegaci?n y control'),
(449, 331309, 'Reparaci?n de otros equipos electr?nicos y ?pticos\r\nn.c.p.'),
(450, 332000, 'Instalaci?n de maquinaria y equipos industriales'),
(451, 325009, 'Fabricaci?n de instrumentos y materiales m?dicos,\r\noftalmol?gicos y odontol?gicos n.c.p.'),
(452, 267000, 'Fabricaci?n de instrumentos ?pticos y equipo\r\nfotogr?fico'),
(453, 273100, 'Fabricaci?n de cables de fibra ?ptica'),
(454, 282900, 'Fabricaci?n de otros tipos de maquinaria de uso\r\nespecial'),
(455, 331309, 'Reparaci?n de otros equipos electr?nicos y ?pticos\r\nn.c.p.'),
(456, 265200, 'Fabricaci?n de relojes'),
(457, 321100, 'Fabricaci?n de joyas y art?culos conexos'),
(458, 321200, 'Fabricaci?n de bisuter?a y art?culos conexos'),
(459, 331900, 'Reparaci?n de otros tipos de equipo'),
(460, 291000, 'Fabricaci?n de veh?culos automotores'),
(461, 292000, 'Fabricaci?n de carrocer?as para veh?culos\r\nautomotores; fabricaci?n de remolques y\r\nsemirremolques'),
(462, 331100, 'Reparaci?n de productos elaborados de metal'),
(463, 293000, 'Fabricaci?n de partes, piezas y accesorios para\r\nveh?culos automotores'),
(464, 139200, 'Fabricaci?n de art?culos confeccionados de\r\nmateriales textiles, excepto prendas de vestir'),
(465, 281100, 'Fabricaci?n de motores y turbinas, excepto para\r\naeronaves, veh?culos automotores y motocicletas'),
(466, 301100, 'Construcci?n de buques, embarcaciones menores y\r\nestructuras flotantes'),
(467, 331501, 'Reparaci?n de buques, embarcaciones menores y\r\nestructuras flotantes'),
(468, 301100, 'Construcci?n de buques, embarcaciones menores y\r\nestructuras flotantes'),
(469, 331501, 'Reparaci?n de buques, embarcaciones menores y\r\nestructuras flotantes'),
(470, 301200, 'Construcci?n de embarcaciones de recreo y de\r\ndeporte'),
(471, 331501, 'Reparaci?n de buques, embarcaciones menores y\r\nestructuras flotantes'),
(472, 302000, 'Fabricaci?n de locomotoras y material rodante'),
(473, 331509, 'Reparaci?n de otros equipos de transporte n.c.p.,\r\nexcepto veh?culos automotores'),
(474, 303000, 'Fabricaci?n de aeronaves, naves espaciales y\r\nmaquinaria conexa'),
(475, 281100, 'Fabricaci?n de motores y turbinas, excepto para\r\naeronaves, veh?culos automotores y motocicletas'),
(476, 282900, 'Fabricaci?n de otros tipos de maquinaria de uso\r\nespecial'),
(477, 331502, 'Reparaci?n de aeronaves y naves espaciales'),
(478, 309100, 'Fabricaci?n de motocicletas'),
(479, 281100, 'Fabricaci?n de motores y turbinas, excepto para\r\naeronaves, veh?culos automotores y motocicletas'),
(480, 309200, 'Fabricaci?n de bicicletas y de sillas de ruedas'),
(481, 309900, 'Fabricaci?n de otros tipos de equipo de transporte\r\nn.c.p.'),
(482, 281600, 'Fabricaci?n de equipo de elevaci?n y manipulaci?n\"\r\nnull;310009;Fabricaci?n de colchones; fabricaci?n de otros\r\nmuebles n.c.p.'),
(483, 331209, 'Reparaci?n de otro tipo de maquinaria y equipos\r\nindustriales n.c.p.'),
(484, 331509, 'Reparaci?n de otros equipos de transporte n.c.p.,\r\nexcepto veh?culos automotores'),
(485, 310001, 'Fabricaci?n de muebles principalmente de madera'),
(486, 310009, 'Fabricaci?n de colchones; fabricaci?n de otros\r\nmuebles n.c.p.'),
(487, 221900, 'Fabricaci?n de otros productos de caucho'),
(488, 222000, 'Fabricaci?n de productos de pl?stico'),
(489, 281700, 'Fabricaci?n de maquinaria y equipo de oficina\r\n(excepto computadores y equipo perif?rico)'),
(490, 293000, 'Fabricaci?n de partes, piezas y accesorios para\r\nveh?culos automotores'),
(491, 301100, 'Construcci?n de buques, embarcaciones menores y\r\nestructuras flotantes'),
(492, 302000, 'Fabricaci?n de locomotoras y material rodante'),
(493, 303000, 'Fabricaci?n de aeronaves, naves espaciales y\r\nmaquinaria conexa'),
(494, 952400, 'Reparaci?n de muebles y accesorios dom?sticos'),
(495, 321100, 'Fabricaci?n de joyas y art?culos conexos'),
(496, 322000, 'Fabricaci?n de instrumentos musicales'),
(497, 331900, 'Reparaci?n de otros tipos de equipo'),
(498, 323000, 'Fabricaci?n de art?culos de deporte'),
(499, 329000, 'Otras industrias manufactureras n.c.p.'),
(500, 324000, 'Fabricaci?n de juegos y juguetes'),
(501, 264000, 'Fabricaci?n de aparatos electr?nicos de consumo'),
(502, 282900, 'Fabricaci?n de otros tipos de maquinaria de uso\r\nespecial'),
(503, 331209, 'Reparaci?n de otro tipo de maquinaria y equipos\r\nindustriales n.c.p.'),
(504, 331900, 'Reparaci?n de otros tipos de equipo'),
(505, 329000, 'Otras industrias manufactureras n.c.p.'),
(506, 329000, 'Otras industrias manufactureras n.c.p.'),
(507, 202909, 'Fabricaci?n de otros productos qu?micos n.c.p.'),
(508, 329000, 'Otras industrias manufactureras n.c.p.'),
(509, 139900, 'Fabricaci?n de otros productos textiles n.c.p.'),
(510, 151200, 'Fabricaci?n de maletas, bolsos y art?culos similares,\r\nart?culos de talabarter?a y guarnicioner?a\"\r\nnull;162900;Fabricaci?n de otros productos de madera, de\r\nart?culos de corcho, paja y materiales tre'),
(511, 170900, 'Fabricaci?n de otros art?culos de papel y cart?n\"\r\nnull;221900;Fabricaci?n de otros productos de caucho'),
(512, 222000, 'Fabricaci?n de productos de pl?stico'),
(513, 259900, 'Fabricaci?n de otros productos elaborados de metal\r\nn.c.p.'),
(514, 282900, 'Fabricaci?n de otros tipos de maquinaria de uso\r\nespecial'),
(515, 309200, 'Fabricaci?n de bicicletas y de sillas de ruedas'),
(516, 321200, 'Fabricaci?n de bisuter?a y art?culos conexos'),
(517, 331209, 'Reparaci?n de otro tipo de maquinaria y equipos\r\nindustriales n.c.p.'),
(518, 383001, 'Recuperaci?n y reciclamiento de desperdicios y\r\ndesechos met?licos'),
(519, 383002, 'Recuperaci?n y reciclamiento de papel'),
(520, 383003, 'Recuperaci?n y reciclamiento de vidrio'),
(521, 383009, 'Recuperaci?n y reciclamiento de otros desperdicios y\r\ndesechos n.c.p.'),
(522, 351011, 'Generaci?n de energ?a el?ctrica en centrales\r\nhidroel?ctricas'),
(523, 351012, 'Generaci?n de energ?a el?ctrica en centrales\r\ntermoel?ctricas'),
(524, 351012, 'Generaci?n de energ?a el?ctrica en centrales\r\ntermoel?ctricas'),
(525, 351019, 'Generaci?n de energ?a el?ctrica en otras centrales\r\nn.c.p.'),
(526, 351020, 'Transmisi?n de energ?a el?ctrica'),
(527, 351030, 'Distribuci?n de energ?a el?ctrica'),
(528, 352020, 'Fabricaci?n de gas; distribuci?n de combustibles\r\ngaseosos por tuber?a, excepto regasificaci?n de GNL'),
(529, 352010, 'Regasificaci?n de Gas Natural Licuado (GNL)'),
(530, 353001, 'Suministro de vapor y de aire acondicionado'),
(531, 360000, 'Captaci?n, tratamiento y distribuci?n de agua'),
(532, 431200, 'Preparaci?n del terreno'),
(533, 99001, 'Actividades de apoyo para la explotaci?n de otras\r\nminas y canteras prestados por empresas'),
(534, 390000, 'Actividades de descontaminaci?n y otros servicios de\r\ngesti?n de desechos'),
(535, 431100, 'Demolici?n\"\r\nnull;410010;Construcci?n de edificios para uso residencial'),
(536, 410020, 'Construcci?n de edificios para uso no residencial'),
(537, 439000, 'Otras actividades especializadas de construcci?n\"\r\nnull;421000;Construcci?n de carreteras y l?neas de ferrocarril'),
(538, 422000, 'Construcci?n de proyectos de servicio p?blico'),
(539, 429000, 'Construcci?n de otras obras de ingenier?a civil'),
(540, 439000, 'Otras actividades especializadas de construcci?n\"\r\nnull;432100;Instalaciones el?ctricas'),
(541, 432200, 'Instalaciones de gasfiter?a, calefacci?n y aire\r\nacondicionado'),
(542, 432900, 'Otras instalaciones para obras de construcci?n\"\r\nnull;433000;Terminaci?n y acabado de edificios'),
(543, 439000, 'Otras actividades especializadas de construcci?n\"\r\nnull;433000;Terminaci?n y acabado de edificios'),
(544, 332000, 'Instalaci?n de maquinaria y equipos industriales'),
(545, 432900, 'Otras instalaciones para obras de construcci?n\"\r\nnull;439000;Otras actividades especializadas de construcci?n\"\r\nnull;439000;Otras actividades especializadas de construcci?n\"\r\nnull;99001;Actividades de'),
(546, 451001, 'Venta al por mayor de veh?culos automotores'),
(547, 451002, 'Venta al por menor de veh?culos automotores nuevos\r\no usados (incluye compraventa)'),
(548, 452001, 'Servicio de lavado de veh?culos automotores'),
(549, 522190, 'Actividades de servicios vinculadas al transporte\r\nterrestre n.c.p.'),
(550, 452002, 'Mantenimiento y reparaci?n de veh?culos\r\nautomotores'),
(551, 453000, 'Venta de partes, piezas y accesorios para veh?culos\r\nautomotores'),
(552, 454001, 'Venta de motocicletas'),
(553, 454002, 'Venta de partes, piezas y accesorios de motocicletas'),
(554, 454003, 'Mantenimiento y reparaci?n de motocicletas'),
(555, 473000, 'Venta al por menor de combustibles para veh?culos\r\nautomotores en comercios especializados'),
(556, 461001, 'Corretaje al por mayor de productos agr?colas'),
(557, 461002, 'Corretaje al por mayor de ganado'),
(558, 461009, 'Otros tipos de corretajes o remates al por mayor\r\nn.c.p.'),
(559, 619090, 'Otras actividades de telecomunicaciones n.c.p.'),
(560, 462020, 'Venta al por mayor de animales vivos'),
(561, 462090, 'Venta al por mayor de otras materias primas\r\nagropecuarias n.c.p.'),
(562, 462010, 'Venta al por mayor de materias primas agr?colas'),
(563, 462090, 'Venta al por mayor de otras materias primas\r\nagropecuarias n.c.p.'),
(564, 463011, 'Venta al por mayor de frutas y verduras'),
(565, 463012, 'Venta al por mayor de carne y productos c?rnicos'),
(566, 463013, 'Venta al por mayor de productos del mar (pescados,\r\nmariscos y algas)'),
(567, 463020, 'Venta al por mayor de bebidas alcoh?licas y no\r\nalcoh?licas'),
(568, 463014, 'Venta al por mayor de productos de confiter?a\"\r\nnull;463030;Venta al por mayor de tabaco'),
(569, 463019, 'Venta al por mayor de huevos, l?cteos, abarrotes y\r\nde otros alimentos n.c.p.'),
(570, 464100, 'Venta al por mayor de productos textiles, prendas de\r\nvestir y calzado'),
(571, 464901, 'Venta al por mayor de muebles, excepto muebles de\r\noficina'),
(572, 464902, 'Venta al por mayor de art?culos el?ctricos y\r\nelectr?nicos para el hogar'),
(573, 464903, 'Venta al por mayor de art?culos de perfumer?a, de\r\ntocador y cosm?ticos'),
(574, 464904, 'Venta al por mayor de art?culos de papeler?a y\r\nescritorio'),
(575, 464905, 'Venta al por mayor de libros'),
(576, 464906, 'Venta al por mayor de diarios y revistas'),
(577, 464907, 'Venta al por mayor de productos farmac?uticos y\r\nmedicinales'),
(578, 464908, 'Venta al por mayor de instrumentos cient?ficos y\r\nquir?rgicos'),
(579, 464909, 'Venta al por mayor de otros enseres dom?sticos\r\nn.c.p.'),
(580, 466302, 'Venta al por mayor de materiales de construcci?n,\r\nart?culos de ferreter?a, gasfiter?a y calefacci?n\"\r\nnull;466100;Venta al por mayor de combustibles s?lidos, l?quidos\r\ny gaseosos y productos conexos'),
(581, 466100, 'Venta al por mayor de combustibles s?lidos, l?quidos\r\ny gaseosos y productos conexos'),
(582, 466100, 'Venta al por mayor de combustibles s?lidos, l?quidos\r\ny gaseosos y productos conexos'),
(583, 466100, 'Venta al por mayor de combustibles s?lidos, l?quidos\r\ny gaseosos y productos conexos'),
(584, 466200, 'Venta al por mayor de metales y minerales\r\nmetal?feros'),
(585, 466301, 'Venta al por mayor de madera en bruto y productos\r\nprimarios de la elaboraci?n de madera'),
(586, 466302, 'Venta al por mayor de materiales de construcci?n,\r\nart?culos de ferreter?a, gasfiter?a y calefacci?n\"\r\nnull;466901;Venta al por mayor de productos qu?micos'),
(587, 466902, 'Venta al por mayor de desechos met?licos (chatarra)'),
(588, 464908, 'Venta al por mayor de instrumentos cient?ficos y\r\nquir?rgicos'),
(589, 466909, 'Venta al por mayor de desperdicios, desechos y otros\r\nproductos n.c.p.'),
(590, 465300, 'Venta al por mayor de maquinaria, equipo y\r\nmateriales agropecuarios'),
(591, 465901, 'Venta al por mayor de maquinaria metal?rgica, para\r\nla miner?a, extracci?n de petr?leo y construcci?n\"\r\nnull;465901;Venta al por mayor de maquinaria metal?rgica, para\r\nla miner?a, extracci?n de petr?l'),
(592, 465903, 'Venta al por mayor de maquinaria para la industria\r\ntextil, del cuero y del calzado'),
(593, 465100, 'Venta al por mayor de computadores, equipo\r\nperif?rico y programas inform?ticos'),
(594, 465200, 'Venta al por mayor de equipo, partes y piezas\r\nelectr?nicos y de telecomunicaciones'),
(595, 465904, 'Venta al por mayor de maquinaria y equipo de\r\noficina; venta al por mayor de muebles de oficina'),
(596, 465905, 'Venta al por mayor de equipo de transporte(excepto\r\nveh?culos automotores, motocicletas y bicicletas)'),
(597, 465909, 'Venta al por mayor de otros tipos de maquinaria y\r\nequipo n.c.p.'),
(598, 469000, 'Venta al por mayor no especializada'),
(599, 471100, 'Venta al por menor en comercios de alimentos,\r\nbebidas o tabaco (supermercados e hipermercados)'),
(600, 472101, 'Venta al por menor de alimentos en comercios\r\nespecializados (almacenes peque?os y minimarket)'),
(601, 471100, 'Venta al por menor en comercios de alimentos,\r\nbebidas o tabaco (supermercados e hipermercados)'),
(602, 472101, 'Venta al por menor de alimentos en comercios\r\nespecializados (almacenes peque?os y minimarket)'),
(603, 471990, 'Otras actividades de venta al por menor en\r\ncomercios no especializados n.c.p.'),
(604, 471910, 'Venta al por menor en comercios de vestuario y\r\nproductos para el hogar (grandes tiendas)'),
(605, 477399, 'Venta al por menor de otros productos en comercios\r\nespecializados n.c.p.'),
(606, 472200, 'Venta al por menor de bebidas alcoh?licas y no\r\nalcoh?licas en comercios especializados (botiller?as)'),
(607, 472102, 'Venta al por menor en comercios especializados de\r\ncarne y productos c?rnicos'),
(608, 472103, 'Venta al por menor en comercios especializados de\r\nfrutas y verduras (verduler?as)'),
(609, 472104, 'Venta al por menor en comercios especializados de\r\npescado, mariscos y productos conexos'),
(610, 472105, 'Venta al por menor en comercios especializados de\r\nproductos de panader?a y pasteler?a\"\r\nnull;477391;Venta al por menor de alimento y accesorios para\r\nmascotas en comercios especializados'),
(611, 472109, 'Venta al por menor en comercios especializados de\r\nhuevos, confites y productos alimenticios n.c.p.'),
(612, 472109, 'Venta al por menor en comercios especializados de\r\nhuevos, confites y productos alimenticios n.c.p.'),
(613, 472300, 'Venta al por menor de tabaco y productos de tabaco\r\nen comercios especializados'),
(614, 477201, 'Venta al por menor de productos farmac?uticos y\r\nmedicinales en comercios especializados'),
(615, 477201, 'Venta al por menor de productos farmac?uticos y\r\nmedicinales en comercios especializados'),
(616, 477201, 'Venta al por menor de productos farmac?uticos y\r\nmedicinales en comercios especializados'),
(617, 477202, 'Venta al por menor de art?culos ortop?dicos en\r\ncomercios especializados'),
(618, 477203, 'Venta al por menor de art?culos de perfumer?a, de\r\ntocador y cosm?ticos en comercios especializados'),
(619, 477101, 'Venta al por menor de calzado en comercios\r\nespecializados'),
(620, 477102, 'Venta al por menor de prendas y accesorios de vestir\r\nen comercios especializados'),
(621, 475100, 'Venta al por menor de telas, lanas, hilos y similares\r\nen comercios especializados'),
(622, 477103, 'Venta al por menor de carteras, maletas y otros\r\naccesorios de viaje en comercios especializados'),
(623, 477102, 'Venta al por menor de prendas y accesorios de vestir\r\nen comercios especializados'),
(624, 475100, 'Venta al por menor de telas, lanas, hilos y similares\r\nen comercios especializados'),
(625, 475300, 'Venta al por menor de tapices, alfombras y\r\ncubrimientos para paredes y pisos'),
(626, 475909, 'Venta al por menor de aparatos el?ctricos, textiles\r\npara el hogar y otros enseres dom?sticos n.c.p.'),
(627, 477103, 'Venta al por menor de carteras, maletas y otros\r\naccesorios de viaje en comercios especializados'),
(628, 475909, 'Venta al por menor de aparatos el?ctricos, textiles\r\npara el hogar y otros enseres dom?sticos n.c.p.'),
(629, 474200, 'Venta al por menor de equipo de sonido y de video\r\nen comercios especializados');
INSERT INTO `codigoactividad` (`id`, `codigosii`, `nombre`) VALUES
(630, 475909, 'Venta al por menor de aparatos el?ctricos, textiles\r\npara el hogar y otros enseres dom?sticos n.c.p.'),
(631, 475901, 'Venta al por menor de muebles y colchones en\r\ncomercios especializados'),
(632, 475902, 'Venta al por menor de instrumentos musicales en\r\ncomercios especializados'),
(633, 476200, 'Venta al por menor de grabaciones de m?sica y de\r\nvideo en comercios especializados'),
(634, 475909, 'Venta al por menor de aparatos el?ctricos, textiles\r\npara el hogar y otros enseres dom?sticos n.c.p.'),
(635, 475909, 'Venta al por menor de aparatos el?ctricos, textiles\r\npara el hogar y otros enseres dom?sticos n.c.p.'),
(636, 475201, 'Venta al por menor de art?culos de ferreter?a y\r\nmateriales de construcci?n\"\r\nnull;475202;Venta al por menor de pinturas, barnices y lacas en\r\ncomercios especializados'),
(637, 475203, 'Venta al por menor de productos de vidrio en\r\ncomercios especializados'),
(638, 477399, 'Venta al por menor de otros productos en comercios\r\nespecializados n.c.p.'),
(639, 477393, 'Venta al por menor de art?culos ?pticos en comercios\r\nespecializados'),
(640, 476400, 'Venta al por menor de juegos y juguetes en\r\ncomercios especializados'),
(641, 474100, 'Venta al por menor de computadores, equipo\r\nperif?rico, programas inform?ticos y equipo de\r\ntelecom.'),
(642, 476101, 'Venta al por menor de libros en comercios\r\nespecializados'),
(643, 476102, 'Venta al por menor de diarios y revistas en comercios\r\nespecializados'),
(644, 476103, 'Venta al por menor de art?culos de papeler?a y\r\nescritorio en comercios especializados'),
(645, 474100, 'Venta al por menor de computadores, equipo\r\nperif?rico, programas inform?ticos y equipo de\r\ntelecom.'),
(646, 476301, 'Venta al por menor de art?culos de caza y pesca en\r\ncomercios especializados'),
(647, 477392, 'Venta al por menor de armas y municiones en\r\ncomercios especializados'),
(648, 476302, 'Venta al por menor de bicicletas y sus repuestos en\r\ncomercios especializados'),
(649, 476309, 'Venta al por menor de otros art?culos y equipos de\r\ndeporte n.c.p.'),
(650, 477394, 'Venta al por menor de art?culos de joyer?a, bisuter?a y\r\nrelojer?a en comercios especializados'),
(651, 477310, 'Venta al por menor de gas licuado en bombonas\r\n(cilindros) en comercios especializados'),
(652, 477395, 'Venta al por menor de carb?n, le?a y otros\r\ncombustibles de uso dom?stico en comercios\r\nespecializados'),
(653, 477396, 'Venta al por menor de recuerdos, artesan?as y\r\nart?culos religiosos en comercios especializados'),
(654, 477397, 'Venta al por menor de flores, plantas, arboles,\r\nsemillas y abonos en comercios especializados'),
(655, 477398, 'Venta al por menor de mascotas en comercios\r\nespecializados'),
(656, 477391, 'Venta al por menor de alimento y accesorios para\r\nmascotas en comercios especializados'),
(657, 477399, 'Venta al por menor de otros productos en comercios\r\nespecializados n.c.p.'),
(658, 475300, 'Venta al por menor de tapices, alfombras y\r\ncubrimientos para paredes y pisos'),
(659, 477401, 'Venta al por menor de antig?edades en comercios'),
(660, 477402, 'Venta al por menor de ropa usada en comercios'),
(661, 477409, 'Venta al por menor de otros art?culos de segunda\r\nmano en comercios n.c.p.'),
(662, 649209, 'Otras actividades de concesi?n de cr?dito n.c.p.'),
(663, 479100, 'Venta al por menor por correo, por Internet y v?a\r\ntelef?nica'),
(664, 479100, 'Venta al por menor por correo, por Internet y v?a\r\ntelef?nica'),
(665, 479100, 'Venta al por menor por correo, por Internet y v?a\r\ntelef?nica'),
(666, 478100, 'Venta al por menor de alimentos, bebidas y tabaco\r\nen puestos de venta y mercados (incluye ferias)'),
(667, 478200, 'Venta al por menor de productos textiles, prendas de\r\nvestir y calzado en puestos de venta y mercados'),
(668, 478900, 'Venta al por menor de otros productos en puestos de\r\nventa y mercados (incluye ferias)'),
(669, 479901, 'Venta al por menor realizada por independientes en\r\nla locomoci?n colectiva (Ley 20.388)'),
(670, 479909, 'Otras actividades de venta por menor no realizadas\r\nen comercios, puestos de venta o mercados n.c.p.'),
(671, 479902, 'Venta al por menor mediante m?quinas\r\nexpendedoras'),
(672, 479903, 'Venta al por menor por comisionistas (no\r\ndependientes de comercios)'),
(673, 479909, 'Otras actividades de venta por menor no realizadas\r\nen comercios, puestos de venta o mercados n.c.p.'),
(674, 479100, 'Venta al por menor por correo, por Internet y v?a\r\ntelef?nica'),
(675, 952300, 'Reparaci?n de calzado y de art?culos de cuero'),
(676, 952200, 'Reparaci?n de aparatos de uso dom?stico, equipo\r\ndom?stico y de jardiner?a\"\r\nnull;331309;Reparaci?n de otros equipos electr?nicos y ?pticos\r\nn.c.p.'),
(677, 952100, 'Reparaci?n de aparatos electr?nicos de consumo\r\n(incluye aparatos de televisi?n y radio)'),
(678, 952900, 'Reparaci?n de otros efectos personales y enseres\r\ndom?sticos'),
(679, 952900, 'Reparaci?n de otros efectos personales y enseres\r\ndom?sticos'),
(680, 802000, 'Actividades de servicios de sistemas de seguridad\r\n(incluye servicios de cerrajer?a)'),
(681, 951200, 'Reparaci?n de equipo de comunicaciones (incluye la\r\nreparaci?n tel?fonos celulares)'),
(682, 952400, 'Reparaci?n de muebles y accesorios dom?sticos'),
(683, 551001, 'Actividades de hoteles'),
(684, 551002, 'Actividades de moteles'),
(685, 559001, 'Actividades de residenciales para estudiantes y\r\ntrabajadores'),
(686, 551003, 'Actividades de residenciales para turistas'),
(687, 559009, 'Otras actividades de alojamiento n.c.p.'),
(688, 551009, 'Otras actividades de alojamiento para turistas n.c.p.'),
(689, 552000, 'Actividades de camping y de parques para casas\r\nrodantes'),
(690, 561000, 'Actividades de restaurantes y de servicio m?vil de\r\ncomidas'),
(691, 561000, 'Actividades de restaurantes y de servicio m?vil de\r\ncomidas'),
(692, 563009, 'Otras actividades de servicio de bebidas n.c.p.'),
(693, 562900, 'Suministro industrial de comidas por encargo;\r\nconcesi?n de servicios de alimentaci?n\"\r\nnull;562900;Suministro industrial de comidas por encargo;\r\nconcesi?n de servicios de alimentaci?n\"\r\nnull;562100;'),
(694, 562900, 'Suministro industrial de comidas por encargo;\r\nconcesi?n de servicios de alimentaci?n\"\r\nnull;561000;Actividades de restaurantes y de servicio m?vil de\r\ncomidas'),
(695, 563009, 'Otras actividades de servicio de bebidas n.c.p.'),
(696, 491100, 'Transporte interurbano de pasajeros por ferrocarril'),
(697, 522190, 'Actividades de servicios vinculadas al transporte\r\nterrestre n.c.p.'),
(698, 491200, 'Transporte de carga por ferrocarril'),
(699, 522190, 'Actividades de servicios vinculadas al transporte\r\nterrestre n.c.p.'),
(700, 492110, 'Transporte urbano y suburbano de pasajeros v?a\r\nmetro y metrotren'),
(701, 492120, 'Transporte urbano y suburbano de pasajeros v?a\r\nlocomoci?n colectiva'),
(702, 492250, 'Transporte de pasajeros en buses interurbanos'),
(703, 492130, 'Transporte de pasajeros v?a taxi colectivo'),
(704, 492210, 'Servicios de transporte de escolares'),
(705, 492220, 'Servicios de transporte de trabajadores'),
(706, 492290, 'Otras actividades de transporte de pasajeros por v?a\r\nterrestre n.c.p.'),
(707, 492190, 'Otras actividades de transporte urbano y suburbano\r\nde pasajeros por v?a terrestre n.c.p.'),
(708, 492230, 'Servicios de transporte de pasajeros en taxis libres y\r\nradiotaxis'),
(709, 492240, 'Servicios de transporte a turistas'),
(710, 492290, 'Otras actividades de transporte de pasajeros por v?a\r\nterrestre n.c.p.'),
(711, 492290, 'Otras actividades de transporte de pasajeros por v?a\r\nterrestre n.c.p.'),
(712, 492300, 'Transporte de carga por carretera'),
(713, 493090, 'Otras actividades de transporte por tuber?as n.c.p.'),
(714, 493010, 'Transporte por oleoductos'),
(715, 493020, 'Transporte por gasoductos'),
(716, 501100, 'Transporte de pasajeros mar?timo y de cabotaje'),
(717, 501200, 'Transporte de carga mar?timo y de cabotaje'),
(718, 502100, 'Transporte de pasajeros por v?as de navegaci?n\r\ninteriores'),
(719, 502200, 'Transporte de carga por v?as de navegaci?n\r\ninteriores'),
(720, 511000, 'Transporte de pasajeros por v?a a?rea'),
(721, 512000, 'Transporte de carga por v?a a?rea'),
(722, 511000, 'Transporte de pasajeros por v?a a?rea'),
(723, 512000, 'Transporte de carga por v?a a?rea'),
(724, 522400, 'Manipulaci?n de la carga'),
(725, 521009, 'Otros servicios de almacenamiento y dep?sito n.c.p.'),
(726, 522110, 'Explotaci?n de terminales terrestres de pasajeros'),
(727, 522120, 'Explotaci?n de estacionamientos de veh?culos\r\nautomotores y parqu?metros'),
(728, 522200, 'Actividades de servicios vinculadas al transporte\r\nacu?tico'),
(729, 522300, 'Actividades de servicios vinculadas al transporte\r\na?reo'),
(730, 522130, 'Servicios prestados por concesionarios de carreteras'),
(731, 522190, 'Actividades de servicios vinculadas al transporte\r\nterrestre n.c.p.'),
(732, 331509, 'Reparaci?n de otros equipos de transporte n.c.p.,\r\nexcepto veh?culos automotores'),
(733, 522200, 'Actividades de servicios vinculadas al transporte\r\nacu?tico'),
(734, 522300, 'Actividades de servicios vinculadas al transporte\r\na?reo'),
(735, 791100, 'Actividades de agencias de viajes'),
(736, 791200, 'Actividades de operadores tur?sticos'),
(737, 799000, 'Otros servicios de reservas y actividades conexas\r\n(incluye venta de entradas para teatro, y otros)'),
(738, 522910, 'Agencias de aduanas'),
(739, 522990, 'Otras actividades de apoyo al transporte n.c.p.'),
(740, 522920, 'Agencias de naves'),
(741, 531000, 'Actividades postales'),
(742, 821900, 'Fotocopiado, preparaci?n de documentos y otras\r\nactividades especializadas de apoyo de oficina'),
(743, 532000, 'Actividades de mensajer?a\"\r\nnull;611010;Telefon?a fija'),
(744, 612010, 'Telefon?a m?vil celular'),
(745, 613010, 'Telefon?a m?vil satelital'),
(746, 611020, 'Telefon?a larga distancia'),
(747, 613020, 'Televisi?n de pago satelital'),
(748, 611030, 'Televisi?n de pago por cable'),
(749, 612030, 'Televisi?n de pago inal?mbrica'),
(750, 611090, 'Otros servicios de telecomunicaciones al?mbricas\r\nn.c.p.'),
(751, 612090, 'Otros servicios de telecomunicaciones inal?mbricas\r\nn.c.p.'),
(752, 613090, 'Otros servicios de telecomunicaciones por sat?lite\r\nn.c.p.'),
(753, 619010, 'Centros de llamados y centros de acceso a Internet'),
(754, 619010, 'Centros de llamados y centros de acceso a Internet'),
(755, 619090, 'Otras actividades de telecomunicaciones n.c.p.'),
(756, 611090, 'Otros servicios de telecomunicaciones al?mbricas\r\nn.c.p.'),
(757, 612020, 'Radiocomunicaciones m?viles'),
(758, 612090, 'Otros servicios de telecomunicaciones inal?mbricas\r\nn.c.p.'),
(759, 613090, 'Otros servicios de telecomunicaciones por sat?lite\r\nn.c.p.'),
(760, 641100, 'Banca central'),
(761, 641910, 'Actividades bancarias'),
(762, 649201, 'Financieras'),
(763, 641990, 'Otros tipos de intermediaci?n monetaria n.c.p.'),
(764, 649100, 'Leasing financiero'),
(765, 649100, 'Leasing financiero'),
(766, 649209, 'Otras actividades de concesi?n de cr?dito n.c.p.'),
(767, 649202, 'Actividades de cr?dito prendario'),
(768, 649900, 'Otras actividades de servicios financieros, excepto\r\nlas de seguros y fondos de pensiones n.c.p.'),
(769, 661201, 'Actividades de securitizadoras'),
(770, 649209, 'Otras actividades de concesi?n de cr?dito n.c.p.'),
(771, 663091, 'Administradoras de fondos de inversi?n\"\r\nnull;663092;Administradoras de fondos mutuos'),
(772, 663093, 'Administradoras de fices (fondos de inversi?n de\r\ncapital extranjero)'),
(773, 663094, 'Administradoras de fondos para la vivienda'),
(774, 663099, 'Administradoras de fondos para otros fines n.c.p.'),
(775, 643000, 'Fondos y sociedades de inversi?n y entidades\r\nfinancieras similares'),
(776, 642000, 'Actividades de sociedades de cartera'),
(777, 774000, 'Arrendamiento de propiedad intelectual y similares,\r\nexcepto obras protegidas por derechos de autor'),
(778, 949909, 'Actividades de otras asociaciones n.c.p.'),
(779, 651100, 'Seguros de vida'),
(780, 652000, 'Reaseguros'),
(781, 663010, 'Administradoras de Fondos de Pensiones (AFP)'),
(782, 653000, 'Fondos de pensiones'),
(783, 651210, 'Seguros generales, excepto actividades de Isapres'),
(784, 651100, 'Seguros de vida'),
(785, 652000, 'Reaseguros'),
(786, 651220, 'Actividades de Isapres'),
(787, 661100, 'Administraci?n de mercados financieros'),
(788, 661202, 'Corredores de bolsa'),
(789, 661203, 'Agentes de valores'),
(790, 661209, 'Otros servicios de corretaje de valores y commodities\r\nn.c.p.'),
(791, 661901, 'Actividades de c?maras de compensaci?n\"\r\nnull;661902;Administraci?n de tarjetas de cr?dito'),
(792, 661903, 'Empresas de asesor?a y consultor?a en inversi?n\r\nfinanciera; sociedades de apoyo al giro'),
(793, 661904, 'Actividades de clasificadoras de riesgo'),
(794, 661204, 'Actividades de casas de cambio y operadores de\r\ndivisa'),
(795, 661909, 'Otras actividades auxiliares de las actividades de\r\nservicios financieros n.c.p.'),
(796, 641990, 'Otros tipos de intermediaci?n monetaria n.c.p.'),
(797, 662200, 'Actividades de agentes y corredores de seguros'),
(798, 662100, 'Evaluaci?n de riesgos y da?os (incluye actividades\r\nde liquidadores de seguros)'),
(799, 662900, 'Otras actividades auxiliares de las actividades de\r\nseguros y fondos de pensiones'),
(800, 681011, 'Alquiler de bienes inmuebles amoblados o con\r\nequipos y maquinarias'),
(801, 681012, 'Compra, venta y alquiler (excepto amoblados) de\r\ninmuebles'),
(802, 429000, 'Construcci?n de otras obras de ingenier?a civil'),
(803, 681020, 'Servicios imputados de alquiler de viviendas'),
(804, 682000, 'Actividades inmobiliarias realizadas a cambio de una\r\nretribuci?n o por contrata'),
(805, 811000, 'Actividades combinadas de apoyo a instalaciones'),
(806, 771000, 'Alquiler de veh?culos automotores sin chofer'),
(807, 773001, 'Alquiler de equipos de transporte sin operario,\r\nexcepto veh?culos automotores'),
(808, 771000, 'Alquiler de veh?culos automotores sin chofer'),
(809, 773001, 'Alquiler de equipos de transporte sin operario,\r\nexcepto veh?culos automotores'),
(810, 773001, 'Alquiler de equipos de transporte sin operario,\r\nexcepto veh?culos automotores'),
(811, 773002, 'Alquiler de maquinaria y equipo agropecuario,\r\nforestal, de construcci?n e ing. civil, sin operarios'),
(812, 773002, 'Alquiler de maquinaria y equipo agropecuario,\r\nforestal, de construcci?n e ing. civil, sin operarios'),
(813, 773003, 'Alquiler de maquinaria y equipo de oficina, sin\r\noperarios (sin servicio administrativo)'),
(814, 773009, 'Alquiler de otros tipos de maquinarias y equipos sin\r\noperario n.c.p.'),
(815, 772100, 'Alquiler y arrendamiento de equipo recreativo y\r\ndeportivo'),
(816, 772900, 'Alquiler de otros efectos personales y enseres\r\ndom?sticos (incluye mobiliario para eventos)'),
(817, 772200, 'Alquiler de cintas de video y discos'),
(818, 772900, 'Alquiler de otros efectos personales y enseres\r\ndom?sticos (incluye mobiliario para eventos)'),
(819, 773009, 'Alquiler de otros tipos de maquinarias y equipos sin\r\noperario n.c.p.'),
(820, 772900, 'Alquiler de otros efectos personales y enseres\r\ndom?sticos (incluye mobiliario para eventos)'),
(821, 772100, 'Alquiler y arrendamiento de equipo recreativo y\r\ndeportivo'),
(822, 773009, 'Alquiler de otros tipos de maquinarias y equipos sin\r\noperario n.c.p.'),
(823, 620100, 'Actividades de programaci?n inform?tica'),
(824, 631100, 'Procesamiento de datos, hospedaje y actividades\r\nconexas'),
(825, 581100, 'Edici?n de libros'),
(826, 581200, 'Edici?n de directorios y listas de correo'),
(827, 581300, 'Edici?n de diarios, revistas y otras publicaciones\r\nperi?dicas'),
(828, 581900, 'Otras actividades de edici?n\"\r\nnull;582000;Edici?n de programas inform?ticos'),
(829, 592000, 'Actividades de grabaci?n de sonido y edici?n de\r\nm?sica'),
(830, 601000, 'Transmisiones de radio'),
(831, 602000, 'Programaci?n y transmisiones de televisi?n\"\r\nnull;620200;Actividades de consultor?a de inform?tica y de gesti?n\r\nde instalaciones inform?ticas'),
(832, 631200, 'Portales web'),
(833, 951100, 'Reparaci?n de computadores y equipo perif?rico'),
(834, 331209, 'Reparaci?n de otro tipo de maquinaria y equipos\r\nindustriales n.c.p.'),
(835, 620200, 'Actividades de consultor?a de inform?tica y de gesti?n\r\nde instalaciones inform?ticas'),
(836, 620900, 'Otras actividades de tecnolog?a de la informaci?n y\r\nde servicios inform?ticos'),
(837, 721000, 'Investigaciones y desarrollo experimental en el\r\ncampo de las ciencias naturales y la ingenier?a\"\r\nnull;722000;Investigaciones y desarrollo experimental en el\r\ncampo de las ciencias sociales y las hum'),
(838, 722000, 'Investigaciones y desarrollo experimental en el\r\ncampo de las ciencias sociales y las humanidades'),
(839, 691001, 'Servicios de asesoramiento y representaci?n jur?dica'),
(840, 691002, 'Servicio notarial'),
(841, 691003, 'Conservador de bienes ra?ces'),
(842, 691004, 'Receptores judiciales'),
(843, 691009, 'Servicios de arbitraje; s?ndicos de quiebra y peritos\r\njudiciales; otras actividades jur?dicas n.c.p.'),
(844, 692000, 'Actividades de contabilidad, tenedur?a de libros y\r\nauditor?a; consultor?a fiscal'),
(845, 732000, 'Estudios de mercado y encuestas de opini?n p?blica'),
(846, 702000, 'Actividades de consultor?a de gesti?n\"\r\nnull;701000;Actividades de oficinas principales'),
(847, 855000, 'Actividades de apoyo a la ense?anza'),
(848, 711001, 'Servicios de arquitectura (dise?o de edificios, dibujo\r\nde planos de construcci?n, entre otros)'),
(849, 99001, 'Actividades de apoyo para la explotaci?n de otras\r\nminas y canteras prestados por empresas'),
(850, 91001, 'Actividades de apoyo para la extracci?n de petr?leo y\r\ngas natural prestados por empresas'),
(851, 711002, 'Empresas de servicios de ingenier?a y actividades\r\nconexas de consultor?a t?cnica'),
(852, 99002, 'Actividades de apoyo para la explotaci?n de otras\r\nminas y canteras prestados por profesionales'),
(853, 91002, 'Actividades de apoyo para la extracci?n de petr?leo y\r\ngas natural prestados por profesionales'),
(854, 711003, 'Servicios profesionales de ingenier?a y actividades\r\nconexas de consultor?a t?cnica'),
(855, 711002, 'Empresas de servicios de ingenier?a y actividades\r\nconexas de consultor?a t?cnica'),
(856, 711003, 'Servicios profesionales de ingenier?a y actividades\r\nconexas de consultor?a t?cnica'),
(857, 711002, 'Empresas de servicios de ingenier?a y actividades\r\nconexas de consultor?a t?cnica'),
(858, 741009, 'Otras actividades especializadas de dise?o n.c.p.'),
(859, 711003, 'Servicios profesionales de ingenier?a y actividades\r\nconexas de consultor?a t?cnica'),
(860, 741009, 'Otras actividades especializadas de dise?o n.c.p.'),
(861, 749009, 'Otras actividades profesionales, cient?ficas y t?cnicas\r\nn.c.p.'),
(862, 711003, 'Servicios profesionales de ingenier?a y actividades\r\nconexas de consultor?a t?cnica'),
(863, 712001, 'Actividades de plantas de revisi?n t?cnica para\r\nveh?culos automotores'),
(864, 712009, 'Otros servicios de ensayos y an?lisis t?cnicos\r\n(excepto actividades de plantas de revisi?n t?cnica)'),
(865, 731001, 'Servicios de publicidad prestados por empresas'),
(866, 731002, 'Servicios de publicidad prestados por profesionales'),
(867, 783000, 'Otras actividades de dotaci?n de recursos humanos'),
(868, 782000, 'Actividades de agencias de empleo temporal (incluye\r\nempresas de servicios transitorios)'),
(869, 781000, 'Actividades de agencias de empleo'),
(870, 803000, 'Actividades de investigaci?n (incluye actividades de\r\ninvestigadores y detectives privados)'),
(871, 801001, 'Servicios de seguridad privada prestados por\r\nempresas'),
(872, 802000, 'Actividades de servicios de sistemas de seguridad\r\n(incluye servicios de cerrajer?a)'),
(873, 801002, 'Servicio de transporte de valores en veh?culos\r\nblindados'),
(874, 801003, 'Servicios de seguridad privada prestados por\r\nindependientes'),
(875, 812100, 'Limpieza general de edificios'),
(876, 812909, 'Otras actividades de limpieza de edificios e\r\ninstalaciones industriales n.c.p.'),
(877, 812901, 'Desratizaci?n, desinfecci?n y exterminio de plagas no\r\nagr?colas'),
(878, 742001, 'Servicios de revelado, impresi?n y ampliaci?n de\r\nfotograf?as'),
(879, 742002, 'Servicios y actividades de fotograf?a\"\r\nnull;742003;Servicios personales de fotograf?a\"\r\nnull;829200;Actividades de envasado y empaquetado'),
(880, 829110, 'Actividades de agencias de cobro'),
(881, 829120, 'Actividades de agencias de calificaci?n crediticia'),
(882, 749001, 'Asesor?a y gesti?n en la compra o venta de peque?as\r\ny medianas empresas'),
(883, 741001, 'Actividades de dise?o de vestuario'),
(884, 741002, 'Actividades de dise?o y decoraci?n de interiores'),
(885, 741009, 'Otras actividades especializadas de dise?o n.c.p.'),
(886, 821900, 'Fotocopiado, preparaci?n de documentos y otras\r\nactividades especializadas de apoyo de oficina'),
(887, 821100, 'Actividades combinadas de servicios administrativos\r\nde oficina'),
(888, 749003, 'Servicios personales de traducci?n e interpretaci?n\"\r\nnull;749002;Servicios de traducci?n e interpretaci?n prestados por\r\nempresas'),
(889, 821900, 'Fotocopiado, preparaci?n de documentos y otras\r\nactividades especializadas de apoyo de oficina'),
(890, 749004, 'Actividades de agencias y agentes de representaci?n\r\nde actores, deportistas y otras figuras p?blicas'),
(891, 829900, 'Otras actividades de servicios de apoyo a las\r\nempresas n.c.p.'),
(892, 823000, 'Organizaci?n de convenciones y exposiciones\r\ncomerciales'),
(893, 823000, 'Organizaci?n de convenciones y exposiciones\r\ncomerciales'),
(894, 822000, 'Actividades de call-center'),
(895, 829900, 'Otras actividades de servicios de apoyo a las\r\nempresas n.c.p.'),
(896, 639900, 'Otras actividades de servicios de informaci?n n.c.p.'),
(897, 731001, 'Servicios de publicidad prestados por empresas'),
(898, 742002, 'Servicios y actividades de fotograf?a\"\r\nnull;855000;Actividades de apoyo a la ense?anza'),
(899, 841100, 'Actividades de la administraci?n p?blica en general'),
(900, 681011, 'Alquiler de bienes inmuebles amoblados o con\r\nequipos y maquinarias'),
(901, 681012, 'Compra, venta y alquiler (excepto amoblados) de\r\ninmuebles'),
(902, 682000, 'Actividades inmobiliarias realizadas a cambio de una\r\nretribuci?n o por contrata'),
(903, 799000, 'Otros servicios de reservas y actividades conexas\r\n(incluye venta de entradas para teatro, y otros)'),
(904, 841200, 'Regulaci?n de las actividades de organismos que\r\nprestan servicios sanitarios, educativos, culturales'),
(905, 841300, 'Regulaci?n y facilitaci?n de la actividad econ?mica'),
(906, 910100, 'Actividades de bibliotecas y archivos'),
(907, 841100, 'Actividades de la administraci?n p?blica en general'),
(908, 842300, 'Actividades de mantenimiento del orden p?blico y de\r\nseguridad'),
(909, 841100, 'Actividades de la administraci?n p?blica en general'),
(910, 842100, 'Relaciones exteriores'),
(911, 889000, 'Otras actividades de asistencia social sin alojamiento'),
(912, 842200, 'Actividades de defensa'),
(913, 842300, 'Actividades de mantenimiento del orden p?blico y de\r\nseguridad'),
(914, 712009, 'Otros servicios de ensayos y an?lisis t?cnicos\r\n(excepto actividades de plantas de revisi?n t?cnica)'),
(915, 843090, 'Otros planes de seguridad social de afiliaci?n\r\nobligatoria n.c.p.'),
(916, 843010, 'Fondo Nacional de Salud (FONASA)'),
(917, 843020, 'Instituto de Previsi?n Social (IPS)'),
(918, 649203, 'Cajas de compensaci?n\"\r\nnull;843090;Otros planes de seguridad social de afiliaci?n\r\nobligatoria n.c.p.'),
(919, 850021, 'Ense?anza preescolar privada'),
(920, 850011, 'Ense?anza preescolar p?blica'),
(921, 850022, 'Ense?anza primaria, secundaria cient?fico humanista\r\ny t?cnico profesional privada'),
(922, 850012, 'Ense?anza primaria, secundaria cient?fico humanista\r\ny t?cnico profesional p?blica'),
(923, 850022, 'Ense?anza primaria, secundaria cient?fico humanista\r\ny t?cnico profesional privada'),
(924, 850012, 'Ense?anza primaria, secundaria cient?fico humanista\r\ny t?cnico profesional p?blica'),
(925, 850022, 'Ense?anza primaria, secundaria cient?fico humanista\r\ny t?cnico profesional privada'),
(926, 850012, 'Ense?anza primaria, secundaria cient?fico humanista\r\ny t?cnico profesional p?blica'),
(927, 853120, 'Ense?anza superior en universidades privadas'),
(928, 853110, 'Ense?anza superior en universidades p?blicas'),
(929, 853201, 'Ense?anza superior en institutos profesionales'),
(930, 853202, 'Ense?anza superior en centros de formaci?n t?cnica'),
(931, 850022, 'Ense?anza primaria, secundaria cient?fico humanista\r\ny t?cnico profesional privada'),
(932, 850012, 'Ense?anza primaria, secundaria cient?fico humanista\r\ny t?cnico profesional p?blica'),
(933, 854901, 'Ense?anza preuniversitaria'),
(934, 854909, 'Otros tipos de ense?anza n.c.p.'),
(935, 854909, 'Otros tipos de ense?anza n.c.p.'),
(936, 854902, 'Servicios personales de educaci?n\"\r\nnull;861020;Actividades de hospitales y cl?nicas privadas'),
(937, 861010, 'Actividades de hospitales y cl?nicas p?blicas'),
(938, 861020, 'Actividades de hospitales y cl?nicas privadas'),
(939, 861010, 'Actividades de hospitales y cl?nicas p?blicas'),
(940, 862031, 'Servicios de m?dicos prestados de forma\r\nindependiente'),
(941, 862021, 'Centros m?dicos privados (establecimientos de\r\natenci?n ambulatoria)'),
(942, 862010, 'Actividades de centros de salud municipalizados\r\n(servicios de salud p?blica)'),
(943, 862032, 'Servicios de odont?logos prestados de forma\r\nindependiente'),
(944, 862022, 'Centros de atenci?n odontol?gica privados\r\n(establecimientos de atenci?n ambulatoria)'),
(945, 869010, 'Actividades de laboratorios cl?nicos y bancos de\r\nsangre'),
(946, 869092, 'Servicios prestados de forma independiente por otros\r\nprofesionales de la salud'),
(947, 869091, 'Otros servicios de atenci?n de la salud humana\r\nprestados por empresas'),
(948, 871000, 'Actividades de atenci?n de enfermer?a en\r\ninstituciones'),
(949, 872000, 'Actividades de atenci?n en instituciones para\r\npersonas con discapacidad mental y toxic?manos'),
(950, 873000, 'Actividades de atenci?n en instituciones para\r\npersonas de edad y personas con discapacidad f?sica'),
(951, 750001, 'Actividades de cl?nicas veterinarias'),
(952, 750002, 'Actividades de veterinarios, t?cnicos y otro personal\r\nauxiliar, prestados de forma independiente'),
(953, 750002, 'Actividades de veterinarios, t?cnicos y otro personal\r\nauxiliar, prestados de forma independiente'),
(954, 879000, 'Otras actividades de atenci?n en instituciones'),
(955, 872000, 'Actividades de atenci?n en instituciones para\r\npersonas con discapacidad mental y toxic?manos'),
(956, 873000, 'Actividades de atenci?n en instituciones para\r\npersonas de edad y personas con discapacidad f?sica'),
(957, 889000, 'Otras actividades de asistencia social sin alojamiento'),
(958, 561000, 'Actividades de restaurantes y de servicio m?vil de\r\ncomidas'),
(959, 855000, 'Actividades de apoyo a la ense?anza'),
(960, 881000, 'Actividades de asistencia social sin alojamiento para\r\npersonas de edad y personas con discapacidad'),
(961, 382100, 'Tratamiento y eliminaci?n de desechos no peligrosos'),
(962, 382200, 'Tratamiento y eliminaci?n de desechos peligrosos'),
(963, 812909, 'Otras actividades de limpieza de edificios e\r\ninstalaciones industriales n.c.p.'),
(964, 813000, 'Actividades de paisajismo, servicios de jardiner?a y\r\nservicios conexos'),
(965, 381100, 'Recogida de desechos no peligrosos'),
(966, 381200, 'Recogida de desechos peligrosos'),
(967, 382100, 'Tratamiento y eliminaci?n de desechos no peligrosos'),
(968, 382200, 'Tratamiento y eliminaci?n de desechos peligrosos'),
(969, 370000, 'Evacuaci?n y tratamiento de aguas servidas'),
(970, 370000, 'Evacuaci?n y tratamiento de aguas servidas'),
(971, 370000, 'Evacuaci?n y tratamiento de aguas servidas'),
(972, 390000, 'Actividades de descontaminaci?n y otros servicios de\r\ngesti?n de desechos'),
(973, 941100, 'Actividades de asociaciones empresariales y de\r\nempleadores'),
(974, 941200, 'Actividades de asociaciones profesionales'),
(975, 941200, 'Actividades de asociaciones profesionales'),
(976, 942000, 'Actividades de sindicatos'),
(977, 949100, 'Actividades de organizaciones religiosas'),
(978, 949200, 'Actividades de organizaciones pol?ticas'),
(979, 949901, 'Actividades de centros de madres'),
(980, 889000, 'Otras actividades de asistencia social sin alojamiento'),
(981, 949902, 'Actividades de clubes sociales'),
(982, 949903, 'Fundaciones y corporaciones; asociaciones que\r\npromueven actividades culturales o recreativas'),
(983, 949909, 'Actividades de otras asociaciones n.c.p.'),
(984, 591100, 'Actividades de producci?n de pel?culas\r\ncinematogr?ficas, videos y programas de televisi?n\"\r\nnull;591200;Actividades de postproducci?n de pel?culas\r\ncinematogr?ficas, videos y programas de televisi?n\"'),
(985, 591300, 'Actividades de distribuci?n de pel?culas\r\ncinematogr?ficas, videos y programas de televisi?n\"\r\nnull;591400;Actividades de exhibici?n de pel?culas\r\ncinematogr?ficas y cintas de video'),
(986, 602000, 'Programaci?n y transmisiones de televisi?n\"\r\nnull;591100;Actividades de producci?n de pel?culas\r\ncinematogr?ficas, videos y programas de televisi?n\"\r\nnull;601000;Transmisiones de radio'),
(987, 592000, 'Actividades de grabaci?n de sonido y edici?n de\r\nm?sica'),
(988, 900001, 'Servicios de producci?n de obras de teatro,\r\nconciertos, espect?culos de danza, otras prod.\r\nesc?nicas'),
(989, 900009, 'Otras actividades creativas, art?sticas y de\r\nentretenimiento n.c.p.'),
(990, 900001, 'Servicios de producci?n de obras de teatro,\r\nconciertos, espect?culos de danza, otras prod.\r\nesc?nicas'),
(991, 900009, 'Otras actividades creativas, art?sticas y de\r\nentretenimiento n.c.p.'),
(992, 900002, 'Actividades art?sticas realizadas por bandas de\r\nm?sica, compa??as de teatro, circenses y similares'),
(993, 900009, 'Otras actividades creativas, art?sticas y de\r\nentretenimiento n.c.p.'),
(994, 900003, 'Actividades de artistas realizadas de forma\r\nindependiente: actores, m?sicos, escritores, entre\r\notros'),
(995, 900009, 'Otras actividades creativas, art?sticas y de\r\nentretenimiento n.c.p.'),
(996, 799000, 'Otros servicios de reservas y actividades conexas\r\n(incluye venta de entradas para teatro, y otros)'),
(997, 854200, 'Ense?anza cultural'),
(998, 563001, 'Actividades de discotecas y cabaret (night club), con\r\npredominio del servicio de bebidas'),
(999, 932909, 'Otras actividades de esparcimiento y recreativas\r\nn.c.p.'),
(1000, 932100, 'Actividades de parques de atracciones y parques\r\ntem?ticos'),
(1001, 932909, 'Otras actividades de esparcimiento y recreativas\r\nn.c.p.'),
(1002, 900001, 'Servicios de producci?n de obras de teatro,\r\nconciertos, espect?culos de danza, otras prod.\r\nesc?nicas'),
(1003, 932909, 'Otras actividades de esparcimiento y recreativas\r\nn.c.p.'),
(1004, 799000, 'Otros servicios de reservas y actividades conexas\r\n(incluye venta de entradas para teatro, y otros)'),
(1005, 639100, 'Actividades de agencias de noticias'),
(1006, 900004, 'Servicios prestados por periodistas independientes'),
(1007, 742002, 'Servicios y actividades de fotograf?a\"\r\nnull;910100;Actividades de bibliotecas y archivos'),
(1008, 591200, 'Actividades de postproducci?n de pel?culas\r\ncinematogr?ficas, videos y programas de televisi?n\"\r\nnull;910200;Actividades de museos, gesti?n de lugares y edificios\r\nhist?ricos'),
(1009, 910300, 'Actividades de jardines bot?nicos, zool?gicos y\r\nreservas naturales'),
(1010, 931109, 'Gesti?n de otras instalaciones deportivas n.c.p.'),
(1011, 492290, 'Otras actividades de transporte de pasajeros por v?a\r\nterrestre n.c.p.'),
(1012, 931909, 'Otras actividades deportivas n.c.p.'),
(1013, 932909, 'Otras actividades de esparcimiento y recreativas\r\nn.c.p.'),
(1014, 931209, 'Actividades de otros clubes deportivos n.c.p.'),
(1015, 931201, 'Actividades de clubes de f?tbol amateur y profesional'),
(1016, 931201, 'Actividades de clubes de f?tbol amateur y profesional'),
(1017, 931101, 'Hip?dromos'),
(1018, 931909, 'Otras actividades deportivas n.c.p.'),
(1019, 931901, 'Promoci?n y organizaci?n de competencias\r\ndeportivas'),
(1020, 854100, 'Ense?anza deportiva y recreativa'),
(1021, 854100, 'Ense?anza deportiva y recreativa'),
(1022, 931909, 'Otras actividades deportivas n.c.p.'),
(1023, 799000, 'Otros servicios de reservas y actividades conexas\r\n(incluye venta de entradas para teatro, y otros)'),
(1024, 920090, 'Otras actividades de juegos de azar y apuestas n.c.p.'),
(1025, 920010, 'Actividades de casinos de juegos'),
(1026, 932901, 'Gesti?n de salas de pool; gesti?n (explotaci?n) de\r\njuegos electr?nicos'),
(1027, 931102, 'Gesti?n de salas de billar; gesti?n de salas de bolos\r\n(bowling)'),
(1028, 781000, 'Actividades de agencias de empleo'),
(1029, 932909, 'Otras actividades de esparcimiento y recreativas\r\nn.c.p.'),
(1030, 592000, 'Actividades de grabaci?n de sonido y edici?n de\r\nm?sica'),
(1031, 931909, 'Otras actividades deportivas n.c.p.'),
(1032, 960100, 'Lavado y limpieza, incluida la limpieza en seco, de\r\nproductos textiles y de piel'),
(1033, 960200, 'Peluquer?a y otros tratamientos de belleza'),
(1034, 960310, 'Servicios funerarios'),
(1035, 960320, 'Servicios de cementerios'),
(1036, 960310, 'Servicios funerarios'),
(1037, 960310, 'Servicios funerarios'),
(1038, 960320, 'Servicios de cementerios'),
(1039, 960902, 'Actividades de salones de masajes, ba?os turcos,\r\nsaunas, servicio de ba?os p?blicos'),
(1040, 960909, 'Otras actividades de servicios personales n.c.p.'),
(1041, 970000, 'Actividades de los hogares como empleadores de\r\npersonal dom?stico'),
(1042, 949904, 'Consejo de administraci?n de edificios y condominios'),
(1043, 990000, 'Actividades de organizaciones y ?rganos\r\nextraterritoriales'),
(1044, 11103, 'Cultivo de avena');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comunas`
--

CREATE TABLE `comunas` (
  `id` int(11) NOT NULL,
  `codigo` varchar(20) NOT NULL,
  `codigoprevired` varchar(20) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `region` int(11) NOT NULL,
  `provincia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `comunas`
--

INSERT INTO `comunas` (`id`, `codigo`, `codigoprevired`, `nombre`, `region`, `provincia`) VALUES
(1, '89', '89', 'CODEGUA', 3, 1),
(2, '80', '80', 'RENGO', 3, 1),
(3, '81', '81', 'REQUINOA', 3, 1),
(4, '94', '94', 'RANCAGUA', 3, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comunicacion`
--

CREATE TABLE `comunicacion` (
  `id` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `comunicacion`
--

INSERT INTO `comunicacion` (`id`, `nombre`) VALUES
(1, 'Personal'),
(2, 'Carta Certificada');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contratos`
--

CREATE TABLE `contratos` (
  `id` int(11) NOT NULL,
  `trabajador` int(11) NOT NULL,
  `empresa` int(11) NOT NULL,
  `tipocontrato` varchar(200) NOT NULL,
  `cargo` varchar(200) NOT NULL,
  `sueldo` decimal(10,2) NOT NULL,
  `fechainicio` date NOT NULL,
  `fechatermino` varchar(200) DEFAULT NULL,
  `documento` varchar(200) NOT NULL,
  `estado` int(11) NOT NULL,
  `register_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `contratos`
--

INSERT INTO `contratos` (`id`, `trabajador`, `empresa`, `tipocontrato`, `cargo`, `sueldo`, `fechainicio`, `fechatermino`, `documento`, `estado`, `register_at`) VALUES
(1, 3, 1, 'Contrato a Plazo Fijo', 'Analista de datos (TIC-DTAN)', 410.00, '2023-01-01', '2023-02-14', 'Contrato_20230206102131.pdf', 1, '2023-02-06 13:21:31'),
(3, 4, 1, 'Contrato a Plazo Fijo', 'Administrador de aplicaciones (TIC - ASUP)', 450.00, '1969-12-31', '1969-12-31', 'Contrato_20230222015538.pdf', 1, '2023-02-22 16:55:38'),
(4, 8, 2, 'Contrato a Plazo Fijo', 'Agente de mes de servicios (TIC-USUP)', 500.00, '1969-12-31', '1969-12-31', 'Contrato_20230222030502.pdf', 1, '2023-02-22 18:05:02'),
(6, 10, 3, 'Contrato Indefinido', 'Administrador de aplicaciones (TIC - ASUP)', 440.00, '1969-12-31', '', 'Contrato_20230530025853.pdf', 1, '2023-05-30 18:58:53'),
(7, 11, 3, 'Contrato Indefinido', 'Administrador de aplicaciones (TIC - ASUP)', 440.00, '2019-01-07', '2023-06-12', 'Contrato_20230608052157.pdf', 2, '2023-06-08 21:21:57'),
(8, 9, 3, 'Contrato Indefinido', 'Administrador de aplicaciones (TIC - ASUP)', 440.00, '2022-02-05', '', 'Contrato_20230616114005.pdf', 1, '2023-06-16 15:40:05'),
(9, 11, 3, 'Contrato Indefinido', 'Administrador de aplicaciones (TIC - ASUP)', 440.00, '2019-01-10', '', 'Contrato_20230616114304.pdf', 1, '2023-06-16 15:43:04'),
(10, 12, 3, 'Contrato Indefinido', 'Administrador de aplicaciones (TIC - ASUP)', 440.00, '2021-01-03', '', 'Contrato_20230616115724.pdf', 1, '2023-06-16 15:57:24');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuentabancaria`
--

CREATE TABLE `cuentabancaria` (
  `id` int(11) NOT NULL,
  `trabajador` int(11) NOT NULL,
  `banco` int(11) NOT NULL,
  `tipocuenta` int(11) NOT NULL,
  `numero` varchar(200) NOT NULL,
  `register_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `cuentabancaria`
--

INSERT INTO `cuentabancaria` (`id`, `trabajador`, `banco`, `tipocuenta`, `numero`, `register_at`) VALUES
(2, 1, 3, 2, '215466885', '2023-01-26 17:57:55'),
(3, 5, 1, 1, '56156-65198-5464198', '2023-02-04 13:17:47'),
(4, 4, 1, 1, '215-849-158-00', '2023-02-04 13:18:53'),
(5, 7, 10, 3, '181-6519-198181', '2023-02-04 13:21:01'),
(6, 1, 1, 1, '1691-1981-151981-000165', '2023-02-06 12:55:00'),
(7, 2, 3, 3, '18039655', '2023-02-06 12:58:22'),
(8, 3, 1, 1, '4519-51691-5419681-519651', '2023-02-06 13:00:09'),
(9, 6, 10, 2, '5419-18479-4169', '2023-02-06 13:06:55'),
(10, 8, 3, 3, '7711868', '2023-02-22 17:56:06');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detallefiniquito`
--

CREATE TABLE `detallefiniquito` (
  `id` int(11) NOT NULL,
  `indemnizacion` int(11) NOT NULL,
  `tipoindemnizacion` int(11) NOT NULL,
  `descripcion` varchar(500) NOT NULL,
  `monto` decimal(10,2) NOT NULL,
  `finiquito` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `detallefiniquito`
--

INSERT INTO `detallefiniquito` (`id`, `indemnizacion`, `tipoindemnizacion`, `descripcion`, `monto`, `finiquito`) VALUES
(1, 5, 2, 'feriado proporcional', 54000.00, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detallelotes`
--

CREATE TABLE `detallelotes` (
  `id` int(11) NOT NULL,
  `contrato` int(11) NOT NULL,
  `lotes` int(11) NOT NULL,
  `register_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `detallelotes`
--

INSERT INTO `detallelotes` (`id`, `contrato`, `lotes`, `register_at`) VALUES
(1, 1, 1, '2023-02-06 13:33:14');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `diasferiado`
--

CREATE TABLE `diasferiado` (
  `id` int(11) NOT NULL,
  `periodo` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `descripcion` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `diasferiado`
--

INSERT INTO `diasferiado` (`id`, `periodo`, `fecha`, `descripcion`) VALUES
(1, 2023, '2023-01-01', 'AÃ±o Nuevo (feriado irrenunciable).'),
(2, 2023, '2023-01-02', 'Feriado aÃ±adido para 2023.'),
(5, 2023, '2023-04-07', 'Viernes Santo'),
(6, 2023, '2023-01-02', 'FERIADO'),
(7, 2023, '2023-06-21', 'DÃ­a Nacional de los Pueblos IndÃ­genas'),
(8, 2023, '2023-06-26', 'San Pedro y San Pablo'),
(10, 2023, '2023-08-15', 'AsunciÃ³n de la Virgen'),
(11, 2023, '2023-07-16', 'DÃ­a de la Virgen del Carmen'),
(12, 2023, '2023-09-18', 'Independencia Nacional'),
(13, 2023, '2023-09-19', 'DÃ­a de las Glorias del EjÃ©rcito'),
(14, 2023, '2023-10-09', 'Encuentro de Dos Mundos'),
(15, 2023, '2023-10-27', 'DÃ­a de las Iglesias EvangÃ©licas y Protestantes'),
(16, 2023, '2023-11-01', '	DÃ­a de Todos los Santos'),
(17, 2023, '2023-12-08', 'Inmaculada ConcepciÃ³n'),
(18, 2023, '2023-12-17', 'Plebiscito Nacional'),
(19, 2023, '2023-12-25', 'Navidad');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `discapacidad`
--

CREATE TABLE `discapacidad` (
  `id` int(11) NOT NULL,
  `nombre` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `discapacidad`
--

INSERT INTO `discapacidad` (`id`, `nombre`) VALUES
(1, 'Si'),
(2, 'No');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documentos`
--

CREATE TABLE `documentos` (
  `id` int(11) NOT NULL,
  `trabajador` int(11) NOT NULL,
  `empresa` int(11) NOT NULL,
  `tipodocumento` int(11) NOT NULL,
  `fechageneracion` date NOT NULL,
  `documento` varchar(200) NOT NULL,
  `register_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documentosubido`
--

CREATE TABLE `documentosubido` (
  `id` int(11) NOT NULL,
  `titulo` varchar(200) NOT NULL,
  `tipodocumento` int(11) NOT NULL,
  `observacion` text DEFAULT NULL,
  `trabajador` int(11) NOT NULL,
  `empresa` int(11) NOT NULL,
  `documento` varchar(200) NOT NULL,
  `register_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresa`
--

CREATE TABLE `empresa` (
  `id` int(11) NOT NULL,
  `rut` varchar(20) NOT NULL,
  `razonsocial` varchar(200) NOT NULL,
  `calle` varchar(200) NOT NULL,
  `villa` varchar(200) DEFAULT NULL,
  `numero` varchar(20) NOT NULL,
  `dept` varchar(200) DEFAULT NULL,
  `region` int(11) NOT NULL,
  `comuna` int(11) NOT NULL,
  `ciudad` int(11) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `email` varchar(200) NOT NULL,
  `giro` varchar(200) NOT NULL,
  `cajascompensacion` int(11) NOT NULL,
  `mutuales` int(11) NOT NULL,
  `cotizacionbasica` decimal(10,2) NOT NULL,
  `cotizacionleysanna` decimal(10,2) NOT NULL,
  `cotizacionadicional` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `empresa`
--

INSERT INTO `empresa` (`id`, `rut`, `razonsocial`, `calle`, `villa`, `numero`, `dept`, `region`, `comuna`, `ciudad`, `telefono`, `email`, `giro`, `cajascompensacion`, `mutuales`, `cotizacionbasica`, `cotizacionleysanna`, `cotizacionadicional`, `created_at`, `updated_at`) VALUES
(1, '76.799.271-8', 'PRUEBA ', 'AVENIDA EL ABRA', 'el esfuerzo', '82-4', '', 3, 3, 3, '961906783', 'marcos.diaz@consultoradg.cl', 'CONTABILDIAD', 6, 10, 0.90, 0.30, 0.10, '2023-02-06 12:36:32', '2023-02-07 13:08:38'),
(2, '76.049.826-2', 'FELIPE DIAZ ERIL', 'EGUENAU PONIENTE', 'villa las hojas', '523', '', 3, 2, 2, '961906783', 'felipe@rengogas.cl', 'VERNTA DE GAS LICUADO', 8, 10, 0.90, 0.30, 2.55, '2023-02-22 17:47:25', '2023-02-22 17:47:25'),
(3, '11.366.273-5', 'PAULO BENITO BERRIOS DONAIRE', 'VIÃ‘A DEL MAR ', 'POBLACION VALENZUELA', '0174', '', 3, 4, 4, '961906783', 'paulo.trans@hotmail.com', 'TRANSPORTE URBANO DE PASAJEROS VIA AUTOBUS (LOCOMOCION COLECTIVA)', 6, 11, 0.90, 0.30, 2.55, '2023-05-17 20:47:01', '2023-06-14 19:46:11');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estadoafectoavacaciones`
--

CREATE TABLE `estadoafectoavacaciones` (
  `id` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `estadoafectoavacaciones`
--

INSERT INTO `estadoafectoavacaciones` (`id`, `nombre`) VALUES
(1, 'Si'),
(2, 'No');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estadocivil`
--

CREATE TABLE `estadocivil` (
  `id` int(11) NOT NULL,
  `nombre` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `estadocivil`
--

INSERT INTO `estadocivil` (`id`, `nombre`) VALUES
(1, 'Soltero'),
(2, 'Casado'),
(3, 'Divorciado'),
(4, 'Viudo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estadocontrato`
--

CREATE TABLE `estadocontrato` (
  `id` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `estadocontrato`
--

INSERT INTO `estadocontrato` (`id`, `nombre`) VALUES
(1, 'Activo'),
(2, 'Finiquitado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `finiquito`
--

CREATE TABLE `finiquito` (
  `id` int(11) NOT NULL,
  `contrato` int(11) NOT NULL,
  `tipodocumento` int(11) NOT NULL,
  `fechafiniqito` date NOT NULL,
  `fechainicio` date NOT NULL,
  `fechatermino` date NOT NULL,
  `causalterminocontrato` int(11) NOT NULL,
  `trabajador` int(11) NOT NULL,
  `empresa` int(11) NOT NULL,
  `register_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `finiquito`
--

INSERT INTO `finiquito` (`id`, `contrato`, `tipodocumento`, `fechafiniqito`, `fechainicio`, `fechatermino`, `causalterminocontrato`, `trabajador`, `empresa`, `register_at`) VALUES
(1, 7, 7, '2023-06-12', '2019-01-07', '2023-06-12', 1, 11, 3, '2023-06-12 21:47:40');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `indemnizacion`
--

CREATE TABLE `indemnizacion` (
  `id` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `tipodeindezacion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `indemnizacion`
--

INSERT INTO `indemnizacion` (`id`, `nombre`, `tipodeindezacion`) VALUES
(1, 'Descuentos', 1),
(2, 'Impuesto retenido por indemnizaciones', 2),
(3, 'Indemnización años de servicio', 2),
(4, 'Indemnización fuero maternal (Art. 163 bis)', 2),
(5, 'Indemnización por feriado legal', 2),
(6, 'Indemnización sustitutiva del aviso previo', 2),
(7, 'Indemnización contractuales tributables', 2),
(8, 'Indemnización voluntarias tributables', 2),
(9, 'Otros haberes', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `isapre`
--

CREATE TABLE `isapre` (
  `id` int(11) NOT NULL,
  `codigo` varchar(20) NOT NULL,
  `codigoprevired` varchar(20) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `tipo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `isapre`
--

INSERT INTO `isapre` (`id`, `codigo`, `codigoprevired`, `nombre`, `tipo`) VALUES
(5, '00', '00', 'SIN ISAPRE', 1),
(6, '01', '01', 'BANMÃ©DICA', 2),
(7, '02', '02', 'CONSALUD', 2),
(8, '03', '03', 'VIDATRES', 2),
(9, '04', '04', 'COLMENA', 2),
(10, '05', '05', 'ISAPRE CRUZ BLANCA S.A', 2),
(11, '07', '07', 'FONASA', 1),
(12, '10', '10', 'NUEVA MASVIDA', 2),
(13, '11', '11', 'ISAPRE DE CODELCO LTDA', 2),
(14, '12', '12', 'ISAPRE BCO. ESTADO', 2),
(15, '25', '25', 'Cruz del Norte', 2),
(16, '28', '28', 'Esencial', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jornadas`
--

CREATE TABLE `jornadas` (
  `id` int(11) NOT NULL,
  `codigo` varchar(20) NOT NULL,
  `codigoprevired` varchar(20) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jubilado`
--

CREATE TABLE `jubilado` (
  `id` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `jubilado`
--

INSERT INTO `jubilado` (`id`, `nombre`) VALUES
(1, 'Si'),
(2, 'No');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `licenciamedica`
--

CREATE TABLE `licenciamedica` (
  `id` int(11) NOT NULL,
  `folio` varchar(50) NOT NULL,
  `tipolicencia` int(11) NOT NULL,
  `fechainicio` date NOT NULL,
  `fechatermino` date NOT NULL,
  `pagadora` int(11) NOT NULL,
  `comentario` varchar(200) DEFAULT NULL,
  `documentolicencia` varchar(200) DEFAULT NULL,
  `comprobantetramite` varchar(200) DEFAULT NULL,
  `trabajador` int(11) NOT NULL,
  `register_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lote`
--

CREATE TABLE `lote` (
  `id` int(11) NOT NULL,
  `trabajador` int(11) NOT NULL,
  `token` varchar(200) NOT NULL,
  `usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `lote`
--

INSERT INTO `lote` (`id`, `trabajador`, `token`, `usuario`) VALUES
(29, 7, '7656c6c5549875b3da58edaee933f797', 6),
(30, 6, '7656c6c5549875b3da58edaee933f797', 6),
(33, 1, 'eaf3a8707d38faf42630e102d1d0ad1f', 6),
(34, 2, 'eaf3a8707d38faf42630e102d1d0ad1f', 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lote2`
--

CREATE TABLE `lote2` (
  `id` int(11) NOT NULL,
  `contrato` int(11) NOT NULL,
  `usuario` int(11) NOT NULL,
  `register_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lote3`
--

CREATE TABLE `lote3` (
  `id` int(11) NOT NULL,
  `finiquito` int(11) NOT NULL,
  `usuario` int(11) NOT NULL,
  `register_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lotes`
--

CREATE TABLE `lotes` (
  `id` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `empresa` int(11) NOT NULL,
  `register_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `lotes`
--

INSERT INTO `lotes` (`id`, `nombre`, `empresa`, `register_at`) VALUES
(1, 'EL DELIRIO_20230206103313', 1, '2023-02-06 13:33:14');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mutuales`
--

CREATE TABLE `mutuales` (
  `id` int(11) NOT NULL,
  `codigo` varchar(20) NOT NULL,
  `codigoprevired` varchar(20) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `mutuales`
--

INSERT INTO `mutuales` (`id`, `codigo`, `codigoprevired`, `nombre`) VALUES
(9, '00', '00', 'SIN MUTUAL - EMPRESA ENTREGA APORTE ACCIDENTES DEL'),
(10, '01', '01', 'ASOCIACIÃ³N CHILENA DE SEGURIDAD (ACHS)'),
(11, '02', '02', 'MUTUAL DE SEGURIDAD CCHC'),
(12, '03', '03', 'INSTITUTO DE SEGURIDAD DEL TRABAJO I.S.T.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nacionalidad`
--

CREATE TABLE `nacionalidad` (
  `id` int(11) NOT NULL,
  `codigo` varchar(20) NOT NULL,
  `codigoprevired` varchar(20) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `nacionalidad`
--

INSERT INTO `nacionalidad` (`id`, `codigo`, `codigoprevired`, `nombre`) VALUES
(4, '01', '1', 'CHILENA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notificaciones`
--

CREATE TABLE `notificaciones` (
  `id` int(11) NOT NULL,
  `fechanotificacion` date NOT NULL,
  `finiquito` int(11) NOT NULL,
  `tipodocumento` int(11) NOT NULL,
  `causal` int(11) NOT NULL,
  `causalhechos` text NOT NULL,
  `cotizacionprevisional` text NOT NULL,
  `comunicacion` int(11) NOT NULL,
  `acreditacion` int(11) NOT NULL,
  `comuna` varchar(200) DEFAULT NULL,
  `texto` text NOT NULL,
  `register_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nubcodigoactividad`
--

CREATE TABLE `nubcodigoactividad` (
  `id` int(11) NOT NULL,
  `codigo` int(11) NOT NULL,
  `empresa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `nubcodigoactividad`
--

INSERT INTO `nubcodigoactividad` (`id`, `codigo`, `empresa`) VALUES
(5, 844, 1),
(6, 651, 2),
(7, 701, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagadoressubsidio`
--

CREATE TABLE `pagadoressubsidio` (
  `id` int(11) NOT NULL,
  `codigo` varchar(20) NOT NULL,
  `codigoprevired` varchar(20) NOT NULL,
  `nombre` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `pagadoressubsidio`
--

INSERT INTO `pagadoressubsidio` (`id`, `codigo`, `codigoprevired`, `nombre`) VALUES
(2, '96856780-2', '96.856.780-2', 'CONSALUD'),
(3, '96502530-8 ', '965025308 ', 'VIDA TRES '),
(4, '96572800-7', '96.572.800-7', 'BANMÃ©DICA'),
(5, '76296619-0', '76296619-0', 'COLMENA'),
(6, '96501450-0 ', '96501450-0 ', 'ISAPRE CRUZ BLANCA S.A.'),
(7, '96936100-0', '96.936.100-0', 'ESENCIAL'),
(8, '61603000-0 ', '61603000-0 ', 'FONASA'),
(9, '96504160-5 ', '965041605 ', 'NUEVA MASVIDA'),
(10, '76334370-7', '76334370-7', 'ISAPRE DE CODELCO LTDA.'),
(11, '71235700-2', '71235700-2', 'ISAPRE BANCO ESTADO'),
(12, '79906120-1', '79906120-1', 'CRUZ DEL NORTE'),
(13, '70360100-6', '70360100-6', 'ASOCIACIÃ³N CHILENA DE SEGURIDAD (ACHS)'),
(14, '70285100-9 ', '70285100-9 ', 'MUTUAL DE SEGURIDAD CCHC'),
(15, '70015580-3 ', '70015580-3 ', 'INSTITUTO DE SEGURIDAD DEL TRABAJO I.S.T.'),
(16, '61533000-0 ', '61533000-0 ', 'INSTITUTO DE SEGURIDAD LABORAL I.S.L.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos`
--

CREATE TABLE `permisos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `permisos`
--

INSERT INTO `permisos` (`id`, `nombre`, `descripcion`) VALUES
(1, 'Gestión', 'Permite Gestion las definiciones de sistema'),
(2, 'Lectura', 'Permite leer los datos'),
(3, 'Escritura', 'Permite escribir los datos'),
(4, 'Actualizacion', 'Permite actualizar los datos'),
(5, 'Eliminacion', 'Permite eliminar los datos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisosusuarios`
--

CREATE TABLE `permisosusuarios` (
  `id` int(11) NOT NULL,
  `idusuario` int(11) NOT NULL,
  `idpermiso` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `permisosusuarios`
--

INSERT INTO `permisosusuarios` (`id`, `idusuario`, `idpermiso`) VALUES
(5, 3, 1),
(6, 3, 2),
(7, 3, 3),
(8, 3, 4),
(9, 4, 1),
(10, 4, 2),
(11, 4, 3),
(12, 4, 4),
(13, 4, 5),
(14, 2, 1),
(15, 2, 2),
(16, 2, 3),
(17, 2, 4),
(18, 2, 5),
(19, 6, 1),
(20, 6, 2),
(21, 6, 3),
(22, 6, 4),
(25, 6, 5),
(26, 7, 2),
(27, 7, 3),
(28, 7, 4),
(29, 7, 5),
(30, 1, 2),
(31, 1, 3),
(32, 1, 4),
(33, 1, 5),
(34, 8, 1),
(35, 8, 2),
(36, 8, 3),
(37, 8, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `plantillas`
--

CREATE TABLE `plantillas` (
  `id` int(11) NOT NULL,
  `tipodocumento` int(11) NOT NULL,
  `contenido` text NOT NULL,
  `register_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `plantillas`
--

INSERT INTO `plantillas` (`id`, `tipodocumento`, `contenido`, `register_at`) VALUES
(1, 1, '<p class=\"H1\" align=\"center\" style=\"text-align:center\"><span lang=\"ES-TRAD\" style=\"font-family:&quot;Arial&quot;,sans-serif;mso-bidi-font-family:&quot;Times New Roman&quot;\">Modelo\nde Aviso de TÃ©rmino de<o:p></o:p></span></p>\n\n<p class=\"H1\" align=\"center\" style=\"text-align:center\"><span lang=\"ES-TRAD\" style=\"font-family:&quot;Arial&quot;,sans-serif;mso-bidi-font-family:&quot;Times New Roman&quot;\">Contrato\nde Trabajo</span><span lang=\"ES-TRAD\" style=\"font-size:12.0pt;mso-bidi-font-size:\n10.0pt;font-family:&quot;Arial&quot;,sans-serif;mso-bidi-font-family:&quot;Times New Roman&quot;\"><o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"text-align:justify\"><span style=\"font-size:12.0pt;\nmso-bidi-font-size:10.0pt;font-family:&quot;Arial&quot;,sans-serif;mso-bidi-font-family:\n&quot;Times New Roman&quot;\">&nbsp;</span></p>\n\n<h1>Santiago, â€¦..de â€¦â€¦â€¦â€¦â€¦â€¦ de 2....... .-<o:p></o:p></h1>\n\n<p class=\"MsoNormal\" style=\"text-align:justify\"><span style=\"font-size:12.0pt;\nmso-bidi-font-size:10.0pt;font-family:&quot;Arial&quot;,sans-serif;mso-bidi-font-family:\n&quot;Times New Roman&quot;\">&nbsp;</span></p>\n\n<p class=\"MsoNormal\" style=\"text-align:justify\"><span style=\"font-size:12.0pt;\nmso-bidi-font-size:10.0pt;font-family:&quot;Arial&quot;,sans-serif;mso-bidi-font-family:\n&quot;Times New Roman&quot;\">SEÃ‘OR (A):<o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"text-align:justify\"><span style=\"font-size:12.0pt;\nmso-bidi-font-size:10.0pt;font-family:&quot;Arial&quot;,sans-serif;mso-bidi-font-family:\n&quot;Times New Roman&quot;\">...........................................<o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"text-align:justify\"><span style=\"font-size:12.0pt;\nmso-bidi-font-size:10.0pt;font-family:&quot;Arial&quot;,sans-serif;mso-bidi-font-family:\n&quot;Times New Roman&quot;\">PRESENTE<o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"text-align:justify\"><span style=\"font-size:12.0pt;\nmso-bidi-font-size:10.0pt;font-family:&quot;Arial&quot;,sans-serif;mso-bidi-font-family:\n&quot;Times New Roman&quot;\">&nbsp;</span></p>\n\n<p class=\"MsoNormal\" style=\"text-align:justify\"><span style=\"font-size:12.0pt;\nmso-bidi-font-size:10.0pt;font-family:&quot;Arial&quot;,sans-serif;mso-bidi-font-family:\n&quot;Times New Roman&quot;\">Estimado seÃ±or(a):<o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"text-align:justify\"><span style=\"font-size:12.0pt;\nmso-bidi-font-size:10.0pt;font-family:&quot;Arial&quot;,sans-serif;mso-bidi-font-family:\n&quot;Times New Roman&quot;\">Nos permitimos comunicar que, con esta fecha, â€¦â€¦ de â€¦â€¦â€¦â€¦â€¦..\nde 2......., se ha resuelto poner tÃ©rmino al contrato de trabajo que lo vincula\ncon la empresa, por la causal del artÃ­culo â€¦â€¦., nÃºmero (o inciso) â€¦., del\nCÃ³digo del Trabajo, esto es, â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦..<o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"text-align:justify\"><span style=\"font-size:12.0pt;\nmso-bidi-font-size:10.0pt;font-family:&quot;Arial&quot;,sans-serif;mso-bidi-font-family:\n&quot;Times New Roman&quot;\">Los hechos en que se funda la causal invocada consisten en que:\nâ€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦<o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"text-align:justify\"><span style=\"font-size:12.0pt;\nmso-bidi-font-size:10.0pt;font-family:&quot;Arial&quot;,sans-serif;mso-bidi-font-family:\n&quot;Times New Roman&quot;\">&nbsp;</span></p>\n\n<p class=\"MsoNormal\" style=\"text-align:justify\"><span style=\"font-size:12.0pt;\nmso-bidi-font-size:10.0pt;font-family:&quot;Arial&quot;,sans-serif;mso-bidi-font-family:\n&quot;Times New Roman&quot;\">Informo que sus cotizaciones previsionales se encuentran al\ndÃ­a. AdemÃ¡s, le adjuntamos certificado de cotizaciones (o copia de las\nplanillas de declaraciÃ³n y pago simultÃ¡neo) de las entidades de previsiÃ³n a las\nque se encuentra afiliado, que dan cuenta que las cotizaciones previsionales,\ndel perÃ­odo trabajado, se encuentran pagadas.<o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"text-align:justify\"><span style=\"font-size:12.0pt;\nmso-bidi-font-size:10.0pt;font-family:&quot;Arial&quot;,sans-serif;mso-bidi-font-family:\n&quot;Times New Roman&quot;\">&nbsp;</span></p>\n\n<p class=\"MsoNormal\" style=\"text-align:justify\"><span style=\"font-size:12.0pt;\nmso-bidi-font-size:10.0pt;font-family:&quot;Arial&quot;,sans-serif;mso-bidi-font-family:\n&quot;Times New Roman&quot;\">Saluda a usted,<o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"text-align:justify\"><span style=\"font-size:12.0pt;\nmso-bidi-font-size:10.0pt;font-family:&quot;Arial&quot;,sans-serif;mso-bidi-font-family:\n&quot;Times New Roman&quot;\">&nbsp;</span></p>\n\n<p class=\"MsoNormal\" style=\"text-align:justify\"><span style=\"font-size:12.0pt;\nmso-bidi-font-size:10.0pt;font-family:&quot;Arial&quot;,sans-serif;mso-bidi-font-family:\n&quot;Times New Roman&quot;\">&nbsp;</span></p>\n\n<p class=\"MsoNormal\" style=\"text-align:justify\"><span style=\"font-size:12.0pt;\nmso-bidi-font-size:10.0pt;font-family:&quot;Arial&quot;,sans-serif;mso-bidi-font-family:\n&quot;Times New Roman&quot;\">&nbsp;</span></p>\n\n<p class=\"MsoNormal\" style=\"text-align:justify\"><span style=\"font-size:12.0pt;\nmso-bidi-font-size:10.0pt;font-family:&quot;Arial&quot;,sans-serif;mso-bidi-font-family:\n&quot;Times New Roman&quot;\">&nbsp;</span></p>\n\n<table class=\"MsoNormalTable\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n <tbody><tr>\n  <td width=\"312\" style=\"width:234.0pt;padding:0cm 0cm 0cm 0cm\">\n  <p class=\"MsoNormal\" style=\"text-align:justify\"><span style=\"font-size:12.0pt;\n  mso-bidi-font-size:10.0pt;font-family:&quot;Arial&quot;,sans-serif;mso-bidi-font-family:\n  &quot;Times New Roman&quot;\">............................................<o:p></o:p></span></p>\n  <p class=\"MsoNormal\" style=\"text-align:justify\"><span style=\"font-size:12.0pt;\n  mso-bidi-font-size:10.0pt;font-family:&quot;Arial&quot;,sans-serif;mso-bidi-font-family:\n  &quot;Times New Roman&quot;\">EMPLEADOR<o:p></o:p></span></p>\n  </td>\n </tr>\n</tbody></table>\n\n<p class=\"MsoNormal\" style=\"text-align:justify\"><span style=\"font-size:12.0pt;\nmso-bidi-font-size:10.0pt;font-family:&quot;Arial&quot;,sans-serif;mso-bidi-font-family:\n&quot;Times New Roman&quot;\">&nbsp;</span></p>\n\n<p class=\"MsoNormal\" style=\"text-align:justify\"><span style=\"font-size:12.0pt;\nmso-bidi-font-size:10.0pt;font-family:&quot;Arial&quot;,sans-serif;mso-bidi-font-family:\n&quot;Times New Roman&quot;\">&nbsp;</span></p>\n\n<p class=\"MsoNormal\" style=\"text-align:justify\"><span style=\"font-size:12.0pt;\nmso-bidi-font-size:10.0pt;font-family:&quot;Arial&quot;,sans-serif;mso-bidi-font-family:\n&quot;Times New Roman&quot;\">RecibÃ­ copia de la presente carta<o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"text-align:justify\"><span style=\"font-size:12.0pt;\nmso-bidi-font-size:10.0pt;font-family:&quot;Arial&quot;,sans-serif;mso-bidi-font-family:\n&quot;Times New Roman&quot;\">&nbsp;</span></p>\n\n<p class=\"MsoNormal\" style=\"text-align:justify\"><span style=\"font-size:12.0pt;\nmso-bidi-font-size:10.0pt;font-family:&quot;Arial&quot;,sans-serif;mso-bidi-font-family:\n&quot;Times New Roman&quot;\">&nbsp;</span></p>\n\n<p class=\"MsoNormal\" style=\"text-align:justify\"><span style=\"font-size:12.0pt;\nmso-bidi-font-size:10.0pt;font-family:&quot;Arial&quot;,sans-serif;mso-bidi-font-family:\n&quot;Times New Roman&quot;\">&nbsp;</span></p>\n\n<table class=\"MsoNormalTable\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n <tbody><tr>\n  <td width=\"312\" style=\"width:234.0pt;padding:0cm 0cm 0cm 0cm\">\n  <p class=\"MsoNormal\" style=\"text-align:justify\"><span style=\"font-size:12.0pt;\n  mso-bidi-font-size:10.0pt;font-family:&quot;Arial&quot;,sans-serif;mso-bidi-font-family:\n  &quot;Times New Roman&quot;\">...........................................<o:p></o:p></span></p>\n  <p class=\"MsoNormal\" style=\"text-align:justify\"><span style=\"font-size:12.0pt;\n  mso-bidi-font-size:10.0pt;font-family:&quot;Arial&quot;,sans-serif;mso-bidi-font-family:\n  &quot;Times New Roman&quot;\">FIRMA DEL TRABAJADOR<o:p></o:p></span></p>\n  </td>\n </tr>\n</tbody></table>\n\n<p class=\"MsoNormal\" style=\"text-align:justify\"><span style=\"font-size:12.0pt;\nmso-bidi-font-size:10.0pt;font-family:&quot;Arial&quot;,sans-serif;mso-bidi-font-family:\n&quot;Times New Roman&quot;\">&nbsp;</span></p>\n\n<p class=\"MsoBodyText\">Nota: Este aviso debe entregarse personalmente al\ntrabajador, quien deberÃ¡ firmar una copia del mismo, o enviarse por Correo\nCertificado al Ãºltimo domicilio que tiene registrado la empresa, en el plazo de\ntres dÃ­as hÃ¡biles, o seis dÃ­as hÃ¡biles cuando se invoque causa fortuita o\nfuerza mayor, ambos contado desde que deja de pertenecer a la empresa,\nconsiderÃ¡ndose el sÃ¡bado como dÃ­a hÃ¡bil, o de treinta dÃ­as a lo menos cuando\nsea aplicada como causal las seÃ±aladas en el ArtÃ­culo 161 del CÃ³digo del\nTrabajo. Copia de este aviso debe remitirse a la InspecciÃ³n del Trabajo, en los\nmismos plazos seÃ±alados.<span style=\"font-size:12.0pt;mso-bidi-font-size:10.0pt\"><o:p></o:p></span></p>', '2022-11-23 01:22:20'),
(2, 2, '<p class=\"H1\" align=\"center\" style=\"text-align: center;\"><i><span lang=\"ES-TRAD\" style=\"font-size: 22pt;\">Modelo de Contrato de Plazo Fijo<o:p></o:p></span></i></p><p class=\"MsoBodyText\" style=\"text-align: justify;\"><span lang=\"ES-CL\" style=\"font-size: 11pt;\">En&nbsp;</span>{FECHA_CELEBRACION}<span lang=\"ES-CL\" style=\"font-size: 11pt;\">, entre la Empresa&nbsp;</span>{NOMBRE_EMPRESA}<span lang=\"ES-CL\" style=\"font-size: 11pt;\">&nbsp;representada por don&nbsp;</span>{REPRESENTANTE_LEGAL}<span lang=\"ES-CL\" style=\"font-size: 11pt;\">. con domicilio en&nbsp;&nbsp;</span>{CALLE_EMPRESA}&nbsp;<span style=\"text-align: center; font-size: 0.875rem;\">{NUMERO_EMPRESA}</span><span lang=\"ES-CL\" style=\"font-size: 11pt;\">., comuna de&nbsp;<span style=\"font-size: 14px; text-align: center;\">{COMUNA_EMPRESA}</span>, en adelante \"el empleador\" y don (a) .</span>{NOMBRE_TRABAJADOR}<span lang=\"ES-CL\" style=\"font-size: 11pt;\">, de nacionalidad&nbsp;</span>{NACIONALIDAD}<span lang=\"ES-CL\" style=\"font-size: 11pt;\">&nbsp;nacido (a) el&nbsp;</span>{FECHA_NACIMIENTO}<span lang=\"ES-CL\" style=\"font-size: 11pt;\">, cÃ©dula de identidad NÂº&nbsp;</span>{RUT_TRABAJADOR}<span lang=\"ES-CL\" style=\"font-size: 11pt;\">, domiciliado en&nbsp;</span>{CALLE_TRABAJADOR}&nbsp;{NUMERO_CASA_TRABAJADOR}<span lang=\"ES-CL\" style=\"font-size: 11pt;\">, comuna de&nbsp;</span>{COMUNA_TRABAJADOR}<span lang=\"ES-CL\" style=\"font-size: 11pt;\">, de estado civil&nbsp;</span>{ESTADO_CIVIL}<span lang=\"ES-CL\" style=\"font-size: 11pt;\">, en adelante \"el trabajador\", se ha convenido el siguiente contrato de trabajo.</span></p><p class=\"MsoNormal\" style=\"text-align: justify;\"><span lang=\"ES-CL\" style=\"font-size: 11pt;\">El trabajador se compromete y obliga a ejecutar el trabajo de&nbsp;</span>{CARGO}<span lang=\"ES-CL\" style=\"font-size: 11pt;\">.que se le encomienda.<o:p></o:p></span></p><p class=\"MsoNormal\" style=\"text-align: justify;\"><span lang=\"ES-CL\" style=\"font-size: 11pt;\">Los servicios se prestarÃ¡n en (las oficinas del empleador u otros sitios. Nombrarlos)&nbsp;</span>{CENTRO_DE_COSTO}<span lang=\"ES-CL\" style=\"font-size: 11pt;\">&nbsp;sin perjuicio de la facultad del empleador de alterar, por causa justificada, la naturaleza de los servicios, o el sitio o recinto en que ellos han de prestarse, con la sola limitaciÃ³n de que se trate de labores similares y que el nuevo sitio o recinto quede dentro de la misma localidad o ciudad, conforme a lo seÃ±alado en el artÃ­culo 12Âº del CÃ³digo del Trabajo.<o:p></o:p></span></p><p class=\"MsoNormal\" style=\"text-align: justify;\"><span lang=\"ES-CL\" style=\"font-size: 11pt;\">* La jornada de trabajo serÃ¡ de&nbsp;</span>{HORAS_MENSUALES}<span lang=\"ES-CL\" style=\"font-size: 11pt;\">&nbsp;horas semanales distribuidas de las siguientes maneras.</span></p><p class=\"MsoNormal\" style=\"text-align: justify;\">{DISTRIBUCION_JORNADA}<span lang=\"ES-CL\" style=\"font-size: 11pt;\"><br></span></p><p class=\"MsoNormal\" style=\"text-align: justify;\"><span lang=\"ES-CL\" style=\"font-size: 11pt;\"><o:p></o:p></span></p><p class=\"MsoNormal\" style=\"text-align: justify;\"><span lang=\"ES-CL\" style=\"font-size: 11pt;\">El empleador se compromete a remunerar los servicios del trabajador con un sueldo mensual de $&nbsp;</span>{SUELDO_MONTO}<span lang=\"ES-CL\" style=\"font-size: 11pt;\">&nbsp;(la misma cantidad en letras) ........................................... que serÃ¡ liquidado y pagado, por perÃ­odos vencidos y en forma proporcional a los dÃ­as trabajados.<o:p></o:p></span></p><p class=\"MsoNormal\" style=\"text-align: justify;\"><span lang=\"ES-CL\" style=\"font-size: 11pt;\">El empleador se compromete a otorgar a suministrar al trabajador los siguientes beneficios a)...........................................................................b)â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦.c)â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦â€¦<o:p></o:p></span></p><p class=\"MsoBodyText2\" style=\"text-align: justify;\"><span lang=\"ES-CL\">El trabajador se compromete y obliga expresamente a cumplir las instrucciones que le sean impartidas por su jefe inmediato o por la gerencia de la empresa, en relaciÃ³n a su trabajo, y acatar en todas sus partes las normas del Reglamento Interno de Orden, Higiene y Seguridad (cuando exista en la empresa), las que declara conocer y que forman parte integrante del presente contrato, reglamento del cual se le entrega un ejemplar.<o:p></o:p></span></p><p class=\"MsoNormal\" style=\"text-align: justify;\"><span lang=\"ES-CL\" style=\"font-size: 11pt;\">El presente contrato durarÃ¡ hasta el&nbsp;</span>{TERMINO_CONTRATO}<span lang=\"ES-CL\" style=\"font-size: 11pt;\">&nbsp;y sÃ³lo podrÃ¡ ponÃ©rsele tÃ©rmino en conformidad a la legislaciÃ³n vigente.<o:p></o:p></span></p><p class=\"MsoNormal\" style=\"text-align: justify;\"><span lang=\"ES-CL\" style=\"font-size: 11pt;\">Se deja constancia que el trabajador ingresÃ³ al servicio del empleador el&nbsp;</span>{INICIO_CONTRATO}<span lang=\"ES-CL\" style=\"font-size: 11pt;\"><o:p></o:p></span></p><p class=\"MsoNormal\" style=\"text-align: justify;\"><span lang=\"ES-CL\" style=\"font-size: 11pt;\">Para todos los efectos derivados del presente contrato las partes fijan domicilio en la ciudad de ............................................., y se someten a la JurisdicciÃ³n de sus Tribunales.<o:p></o:p></span></p><p class=\"MsoNormal\" style=\"text-align: justify;\"><span lang=\"ES-CL\" style=\"font-size: 11pt;\">El presente contrato se firman en ............................... ejemplares, declarando el trabajador haber recibido en este acto un ejemplar de dicho instrumento, que es el fiel reflejo de la relaciÃ³n laboral convenida.<o:p></o:p></span></p><p class=\"MsoNormal\" style=\"text-align: justify;\"><span lang=\"ES-CL\" style=\"font-size: 11pt;\">&nbsp;</span></p><p class=\"MsoNormal\" style=\"text-align: justify;\"><span lang=\"ES-CL\" style=\"font-size: 11pt;\">&nbsp;</span>{RUT_TRABAJADOR}&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;{RUT_EMPRESA}</p><table class=\"MsoNormalTable\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"text-align: justify;\"><tbody><tr><td width=\"312\" valign=\"bottom\" style=\"width: 234pt; padding: 0cm;\"><p class=\"MsoNormal\"><span lang=\"ES-CL\" style=\"font-size: 11pt;\">...........................................<o:p></o:p></span></p><p class=\"MsoNormal\"><span lang=\"ES-CL\" style=\"font-size: 11pt;\">FIRMA TRABAJADOR<o:p></o:p></span></p><p class=\"MsoNormal\"><span lang=\"ES-CL\" style=\"font-size: 11pt;\">RUT ...........................................<o:p></o:p></span></p></td><td width=\"312\" style=\"width: 234pt; padding: 0cm;\"><p class=\"MsoNormal\"><span lang=\"ES-CL\" style=\"font-size: 11pt;\">...........................................<o:p></o:p></span></p><p class=\"MsoNormal\"><span lang=\"ES-CL\" style=\"font-size: 11pt;\">FIRMA EMPLEADOR<o:p></o:p></span></p><p class=\"MsoNormal\"><span lang=\"ES-CL\" style=\"font-size: 11pt;\">RUT ...........................................<o:p></o:p></span></p></td></tr></tbody></table><p class=\"MsoNormal\" style=\"text-align: justify;\"><span lang=\"ES-CL\" style=\"font-size: 11pt;\">NOTA:<o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin-left: 18pt; text-align: justify; text-indent: -18pt;\"><span lang=\"ES-CL\" style=\"font-size: 11pt; font-family: Symbol;\">Â·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: &quot;Times New Roman&quot;;\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></span><span lang=\"ES-CL\" style=\"font-size: 11pt;\">Este tipo de contrato se rige por las normas contempladas en el art. 159 NÂº 4 del CÃ³digo del Trabajo, debiendo tenerse presente lo siguiente:<o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin-left: 18pt; text-align: justify; text-indent: -18pt;\"><span lang=\"ES-CL\" style=\"font-size: 11pt; font-family: Symbol;\">Â·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: &quot;Times New Roman&quot;;\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></span><span lang=\"ES-CL\" style=\"font-size: 11pt;\">La duraciÃ³n del contrato de plazo, fijo, no podrÃ¡ exceder de un aÃ±o, salvo que se tratare de gerentes o personas que tengan un tÃ­tulo profesional o tÃ©cnico, otorgado por instituciones de educaciÃ³n superior del Estado o reconocido por Ã©ste, caso en el cual la duraciÃ³n no podrÃ¡ exceder de dos aÃ±os.<o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin-left: 18pt; text-align: justify; text-indent: -18pt;\"><span lang=\"ES-CL\" style=\"font-size: 11pt; font-family: Symbol;\">Â·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: &quot;Times New Roman&quot;;\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></span><span lang=\"ES-CL\" style=\"font-size: 11pt;\">La prestaciÃ³n de servicios una vez expirado el plazo lo transforma en contrato de duraciÃ³n indefinida.<o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin-left: 18pt; text-align: justify; text-indent: -18pt;\"><span lang=\"ES-CL\" style=\"font-size: 11pt; font-family: Symbol;\">Â·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: &quot;Times New Roman&quot;;\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></span><span lang=\"ES-CL\" style=\"font-size: 11pt;\">Estos contratos sÃ³lo admiten una renovaciÃ³n. La segunda renovaciÃ³n lo transforma en contrato de duraciÃ³n indefinida.<o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin-left: 18pt; text-align: justify; text-indent: -18pt;\"><span lang=\"ES-CL\" style=\"font-size: 11pt; font-family: Symbol;\">Â·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: &quot;Times New Roman&quot;;\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></span><span lang=\"ES-CL\" style=\"font-size: 11pt;\">La prestaciÃ³n de servicios discontinuos durante 12 meses o mÃ¡s en un perÃ­odo de quince meses hace presumir que hay contrato indefinido.<o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin-left: 18pt; text-align: justify; text-indent: -18pt;\"><span lang=\"ES-CL\" style=\"font-size: 11pt; font-family: Symbol;\">Â·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: &quot;Times New Roman&quot;;\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></span><span lang=\"ES-CL\" style=\"font-size: 11pt;\">En los contratos que tengan una duraciÃ³n de 30 dÃ­as o menos, se entiende incluida en la remuneraciÃ³n convenida el pago por feriado y demÃ¡s derechos que se devengan en proporciÃ³n al tiempo servido. RegirÃ¡ la misma disposiciÃ³n si el contrato inicial ha tenido prÃ³rrogas, que en total incluido el primer perÃ­odo no excedan de 60 dÃ­as.<o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin-left: 18pt; text-align: justify; text-indent: -18pt;\"><span lang=\"ES-CL\" style=\"font-size: 11pt; font-family: Symbol;\">Â·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: &quot;Times New Roman&quot;;\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></span><span lang=\"ES-CL\" style=\"font-size: 11pt;\">La terminaciÃ³n anticipada del contrato a plazo fijo, sin que exista causal justificada obliga al empleador a pagar la totalidad de los emolumentos convenidos hasta la fecha de tÃ©rmino consignada en el contrato.</span></p>', '2022-12-11 18:02:49'),
(3, 4, '<h1 style=\"text-align: center;\"><font color=\"#000000\"><u>Comprobante de Vacaciones</u></font></h1><h6 style=\"text-align: center;\">CERTIFICADO DE FERIADO LEGAL {NOMBRE_TRABAJADOR} {APELLIDO_1} {APELLIDO_2},</h6><h6 style=\"text-align: center;\">CÃ©dula de Identidad NÂº {RUT_TRABAJADOR}, declara que hace uso de su feriado legal correspondiente al perÃ­odo {PERIODO_VACACIONES},</h6><h6 style=\"text-align: center;\">desde el dÃ­a {FECHA_INICIO_VACACIONES} hasta el dÃ­a {FECHA_TERMINO_VACACIONES},</h6><h6 style=\"text-align: center;\">ambos dÃ­as inclusive, lo que corresponde a&nbsp;{DIAS_VACACIONES} dÃ­as hÃ¡biles.</h6><h6 style=\"text-align: center;\">Se deja constancia que la remuneraciÃ³n por el perÃ­odo de feriado legal se incluirÃ¡ en la liquidaciÃ³n correspondiente al presente mes.</h6><h6 style=\"text-align: center;\">OBSERVACIÃ“N:&nbsp;{OBSERVACIONES_VACACIONES}</h6><h6 style=\"text-align: center;\"></h6><h6 style=\"text-align: center;\">......................................................................&nbsp; &nbsp; ...............................................................</h6><h6 style=\"text-align: center;\">FIRMA DEL TRABAJADOR&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; FIRMA DEL EMPLEADOR</h6><h6 style=\"text-align: center;\"><br></h6>', '2023-01-16 18:54:59'),
(4, 5, '', '2023-01-20 18:49:44'),
(5, 6, '<p class=\"MsoNormal\" align=\"center\" style=\"margin-bottom:0cm;text-align:center;\nline-height:normal\"><b><i><span lang=\"ES-TRAD\" style=\"font-size: 9pt;\">CONTRATO DE\nTRABAJO DE TEMPORADA O FAENA AGRÃCOLA</span></i></b><b><span style=\"font-size: 9pt;\"><o:p></o:p></span></b></p>\n\n<p class=\"MsoNormal\" style=\"margin-bottom:0cm;text-align:justify;line-height:\nnormal\"><span style=\"font-size: 9pt;\">En&nbsp;<b>{CEL_COMUNA}</b>, a&nbsp;{FECHA_CELEBRACION},\nentre&nbsp;<b>{NOMBRE_EMPRESA}</b>,&nbsp;<b>rol Ãºnico tributario&nbsp;{RUT_EMPRESA}</b>,\nrepresentada legalmente por&nbsp;<b>{REPRESENTANTE_LEGAL}, cÃ©dula de identidad {RUT_REPRESENTANTE_LEGAL}</b>,\nambos domiciliados en pasaje&nbsp;{CALLE_EMPRESA} {NUMERO_EMPRESA}</span>,\ncomuna de&nbsp;{COMUNA_EMPRESA}, regiÃ³n de&nbsp;{REGION_EMPRESA}, nÃºmero de\ntelÃ©fono/celular de contacto&nbsp;<b>{TELEFONO_EMPRESA}</b>, correo\nelectrÃ³nico&nbsp;<b>{CORREO_EMPRESA}</b>,&nbsp; en adelante el&nbsp;<b>\"Empleador\"</b>,\ny don (a)&nbsp;<b>{NOMBRE_TRABAJADOR} {APELLIDO_1} {APELLIDO_2}</b>, de\nnacionalidad&nbsp;{NACIONALIDAD},&nbsp;<b>cÃ©dula de identidad&nbsp;{RUT_TRABAJADOR},</b>&nbsp;estado\ncivil&nbsp;{ESTADO_CIVIL}, nacido (a) el&nbsp;{FECHA_NACIMIENTO}, domiciliado\n(a) en&nbsp;<b>{CALLE_TRABAJADOR} {NUMERO_CASA_TRABAJADOR}</b>, comuna de&nbsp;<b>{COMUNA_TRABAJADOR}</b>,\nregiÃ³n de&nbsp;<b>{REGION_TRABAJADOR}</b>, nÃºmero de telÃ©fono/celular de\ncontacto&nbsp;<b>{TELEFONO_TRABAJADOR}</b>, correo electrÃ³nico&nbsp;<b>{CORREO_TRABAJADOR}</b>,&nbsp;\nen adelante&nbsp;<b>â€œTrabajadorâ€</b>,&nbsp;se ha convenido en el siguiente\ncontrato de trabajo de temporada o de faena transitoria.<o:p></o:p></p>\n\n<p class=\"MsoNormal\" style=\"margin-bottom:0cm;text-align:justify;line-height:\nnormal\"><b><span style=\"font-size: 9pt;\">Primero:</span></b><span style=\"font-size: 9pt;\">&nbsp;El\ntrabajador prestarÃ¡ sus servicios como&nbsp;<b>{CARGO}</b>, ubicado en calle<b>&nbsp;{CALLE_ESPECIFICA}\n{NUMERO_CASA_ESPECIFICA}</b>, comuna de&nbsp;<b>{COMUNA_ESPECIFICA}</b>, regiÃ³n\nde&nbsp;<b>{REGION_ESPECIFICA}</b>,&nbsp;pudiendo ser trasladado a otros\npredios agrÃ­colas a cumplir labores similares, dentro de la ciudad, por causa\njustificada, sin que ello importe menoscabo para el trabajador.<o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"margin-bottom:0cm;text-align:justify;line-height:\nnormal\"><span style=\"font-size: 9pt;\">El empleador contrata al trabajador para ejecutar\nlas labores agrÃ­colas que se especifican:&nbsp;{DESCRIPCION_CARGO}.<o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"margin-bottom:0cm;text-align:justify;line-height:\nnormal\"><b><span style=\"font-size: 9pt;\">Segundo:</span></b><span style=\"font-size: 9pt;\">&nbsp;El\npresente contrato se entenderÃ¡ terminado automÃ¡ticamente, en la fecha en que\nconcluyen las faenas que le dieron origen y a que se ha hecho referencia en la\nclÃ¡usula primera, sin perjuicio que el empleador comunique por escrito este\nhecho, de conformidad con lo dispuesto en el artÃ­culo 162 del CÃ³digo del\nTrabajo.<o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"margin-bottom:0cm;text-align:justify;line-height:\nnormal\"><b><span style=\"font-size: 9pt;\">Tercero:</span></b><span style=\"font-size: 9pt;\">&nbsp;La&nbsp;{TIPO_JORNADA}&nbsp;de\ntrabajo serÃ¡ de&nbsp;<b>{DURACION_JORNADA_MENSUAL}</b>&nbsp;distribuidas de la\nsiguiente forma:<br>\n{DISTRIBUCION_JORNADA} {COLACION_MINUTOS}&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;\n&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp;<o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"margin-bottom:0cm;text-align:justify;line-height:\nnormal\"><b><span style=\"font-size: 9pt;\">Cuarto:</span></b><span style=\"font-size: 9pt;\">&nbsp;El\nempleador se compromete a remunerar los servicios del trabajador con un sueldo\nbase&nbsp;{SUELDO_BASE} de&nbsp;<b>${SUELDO_MONTO}.- ({SUELDO_MONTO_LETRAS})</b>,\nque serÃ¡ liquidado y pagado, por perÃ­odos vencidos en forma proporcional a los\ndÃ­as efectivamente trabajados.<o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"margin-bottom:0cm;text-align:justify;line-height:\nnormal\"><span style=\"font-size: 9pt;\">El pago se realizarÃ¡, mediante una&nbsp;{FORMA_PAGO}&nbsp;a\nsu&nbsp;<b>{TIPO_CUENTA}, NÂ°&nbsp;{NUMERO_CUENTA}, del&nbsp;{BANCO}.</b><o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"margin-bottom:0cm;text-align:justify;line-height:\nnormal\"><b><span style=\"font-size: 9pt;\">Quinto:</span></b><span style=\"font-size: 9pt;\">&nbsp;Cuando\npor necesidades de funcionamiento de la Empresa, sea necesario pactar trabajo\nen tiempo extraordinario, el trabajador que lo acuerde, se obligarÃ¡ a cumplir\nel horario que al efecto determinen con la Empleadora, dentro de los lÃ­mites\nlegales. Dicho acuerdo constarÃ¡ por escrito y se firmarÃ¡ por ambas partes,\npreviamente a la realizaciÃ³n del trabajo.<o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"margin-bottom:0cm;text-align:justify;line-height:\nnormal\"><span style=\"font-size: 9pt;\">Queda prohibido expresamente al trabajador laborar\nsobretiempo o simplemente permanecer en el recinto de la Empresa, despuÃ©s de la\nhora diaria de salida, salvo en los casos a que se refiere el inciso\nprecedente.<o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"margin-bottom:0cm;text-align:justify;line-height:\nnormal\"><b><span style=\"font-size: 9pt;\">Sexto:</span></b><span style=\"font-size: 9pt;\">&nbsp;De\nacuerdo al artÃ­culo 38, NÂº 3 del CÃ³digo del Trabajo, las partes dejan\nestablecido que la jornada ordinaria puede comprender domingos o festivos,\natendido el carÃ¡cter de las labores frutÃ­colas materia del presente contrato.<o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"margin-bottom:0cm;line-height:normal\"><b><span style=\"font-size: 9pt;\">SÃ©ptimo:&nbsp;</span></b><span style=\"font-size: 9pt;\">El trabajador declara que su rÃ©gimen\nprevisional es el siguiente:&nbsp;RÃ©gimen de pensiones: {AFP}, RÃ©gimen de salud:&nbsp;{SALUD}<o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"margin-bottom:0cm;text-align:justify;line-height:\nnormal\"><b><span style=\"font-size: 9pt;\">Octavo: Se deja expresa constancia que el\ntrabajador ingresÃ³ al servicio del empleador el&nbsp;{INICIO_CONTRATO}.</span></b><span style=\"font-size: 9pt;\"><o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"margin-bottom:0cm;text-align:justify;line-height:\nnormal\"><b><span style=\"font-size: 9pt;\">Noveno</span></b><span style=\"font-size: 9pt;\">:\nPara todos los efectos derivados del presente contrato las partes fijan\ndomicilio en la ciudad de&nbsp;{CEL_COMUNA}, y se someten a la JurisdicciÃ³n de\nsus Tribunales.</span></p><p class=\"MsoNormal\" style=\"margin-bottom:0cm;text-align:justify;line-height:\nnormal\"><span style=\"font-size: 9pt;\">El presente contrato se firma en 2 ejemplares,\ndeclarando el trabajador haber recibido en este acto un ejemplar de dicho\ninstrumento, que es el fiel reflejo de la relaciÃ³n laboral convenida.&nbsp; &nbsp;</span><span style=\"font-size: 12pt;\">&nbsp;&nbsp;</span></p>', '2023-01-20 19:57:27'),
(6, 5, '<p class=\"MsoNormal\" align=\"center\" style=\"margin-bottom:0cm;text-align:center;\nline-height:normal\"><b><i><span lang=\"ES-TRAD\" style=\"font-size: 12pt;\">CONTRATO DE TRABAJO DE TEMPORADA O FAENA AGRÃCOLA</span></i></b><b><span style=\"font-size: 12pt;\"><o:p></o:p></span></b></p>\n\n<p class=\"MsoNormal\" style=\"margin-bottom:0cm;text-align:justify;line-height:\nnormal\"><span style=\"font-size: 12pt;\">En&nbsp;<b>{CEL_COMUNA}</b>, a&nbsp;{FECHA_CELEBRACION},\nentre&nbsp;<b>{NOMBRE_EMPRESA}</b>,&nbsp;<b>rol Ãºnico tributario&nbsp;{RUT_EMPRESA}</b>,\nrepresentada legalmente por&nbsp;<b>{REPRESENTANTE_LEGAL}, cÃ©dula de identidad {RUT_REPRESENTANTE_LEGAL}</b>,\nambos domiciliados en pasaje&nbsp;{CALLE_EMPRESA} {NUMERO_EMPRESA}</span>,\ncomuna de&nbsp;{COMUNA_EMPRESA}, regiÃ³n de&nbsp;{REGION_EMPRESA}, nÃºmero de\ntelÃ©fono/celular de contacto&nbsp;<b>{TELEFONO_EMPRESA}</b>, correo\nelectrÃ³nico&nbsp;<b>{CORREO_EMPRESA}</b>,&nbsp; en adelante el&nbsp;<b>\"Empleador\"</b>,\ny don (a)&nbsp;<b>{NOMBRE_TRABAJADOR} {APELLIDO_1} {APELLIDO_2}</b>, de\nnacionalidad&nbsp;{NACIONALIDAD},&nbsp;<b>cÃ©dula de identidad&nbsp;{RUT_TRABAJADOR},</b>&nbsp;estado\ncivil&nbsp;{ESTADO_CIVIL}, nacido (a) el&nbsp;{FECHA_NACIMIENTO}, domiciliado\n(a) en&nbsp;<b>{CALLE_TRABAJADOR} {NUMERO_CASA_TRABAJADOR}</b>, comuna de&nbsp;<b>{COMUNA_TRABAJADOR}</b>,\nregiÃ³n de&nbsp;<b>{REGION_TRABAJADOR}</b>, nÃºmero de telÃ©fono/celular de\ncontacto&nbsp;<b>{TELEFONO_TRABAJADOR}</b>, correo electrÃ³nico&nbsp;<b>{CORREO_TRABAJADOR}</b>,&nbsp;\nen adelante&nbsp;<b>â€œTrabajadorâ€</b>,&nbsp;se ha convenido en el siguiente\ncontrato de trabajo de temporada o de faena transitoria.<o:p></o:p></p>\n\n<p class=\"MsoNormal\" style=\"margin-bottom:0cm;text-align:justify;line-height:\nnormal\"><b><span style=\"font-size: 12pt;\">Primero:</span></b><span style=\"font-size: 12pt;\">&nbsp;El\ntrabajador prestarÃ¡ sus servicios como&nbsp;<b>{CARGO}</b>, ubicado en calle<b>&nbsp;{CALLE_ESPECIFICA}\n{NUMERO_CASA_ESPECIFICA}</b>, comuna de&nbsp;<b>{COMUNA_ESPECIFICA}</b>, regiÃ³n\nde&nbsp;<b>{REGION_ESPECIFICA}</b>,&nbsp;pudiendo ser trasladado a otros\npredios agrÃ­colas a cumplir labores similares, dentro de la ciudad, por causa\njustificada, sin que ello importe menoscabo para el trabajador.<o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"margin-bottom:0cm;text-align:justify;line-height:\nnormal\"><span style=\"font-size: 12pt;\">El empleador contrata al trabajador para ejecutar\nlas labores agrÃ­colas que se especifican:&nbsp;{DESCRIPCION_CARGO}.<o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"margin-bottom:0cm;text-align:justify;line-height:\nnormal\"><b><span style=\"font-size: 12pt;\">Segundo:</span></b><span style=\"font-size: 12pt;\">&nbsp;El\npresente contrato se entenderÃ¡ terminado automÃ¡ticamente, en la fecha en que\nconcluyen las faenas que le dieron origen y a que se ha hecho referencia en la\nclÃ¡usula primera, sin perjuicio que el empleador comunique por escrito este\nhecho, de conformidad con lo dispuesto en el artÃ­culo 162 del CÃ³digo del\nTrabajo.<o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"margin-bottom:0cm;text-align:justify;line-height:\nnormal\"><b><span style=\"font-size: 12pt;\">Tercero:</span></b><span style=\"font-size: 12pt;\">&nbsp;La&nbsp;{TIPO_JORNADA}&nbsp;de\ntrabajo serÃ¡ de&nbsp;<b>{DURACION_JORNADA_MENSUAL}</b>&nbsp;distribuidas de la\nsiguiente forma:<br>\n{DISTRIBUCION_JORNADA} {COLACION_MINUTOS}&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;\n&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp;<o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"margin-bottom:0cm;text-align:justify;line-height:\nnormal\"><b><span style=\"font-size: 12pt;\">Cuarto:</span></b><span style=\"font-size: 12pt;\">&nbsp;El\nempleador se compromete a remunerar los servicios del trabajador con un sueldo\nbase&nbsp;{SUELDO_BASE} de&nbsp;<b>${SUELDO_MONTO}.- ({SUELDO_MONTO_LETRAS})</b>,\nque serÃ¡ liquidado y pagado, por perÃ­odos vencidos en forma proporcional a los\ndÃ­as efectivamente trabajados.<o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"margin-bottom:0cm;text-align:justify;line-height:\nnormal\"><span style=\"font-size: 12pt;\">El pago se realizarÃ¡, mediante una&nbsp;{FORMA_PAGO}&nbsp;a\nsu&nbsp;<b>{TIPO_CUENTA}, NÂ°&nbsp;{NUMERO_CUENTA}, del&nbsp;{BANCO}.</b><o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"margin-bottom:0cm;text-align:justify;line-height:\nnormal\"><b><span style=\"font-size: 12pt;\">Quinto:</span></b><span style=\"font-size: 12pt;\">&nbsp;Cuando\npor necesidades de funcionamiento de la Empresa, sea necesario pactar trabajo\nen tiempo extraordinario, el trabajador que lo acuerde, se obligarÃ¡ a cumplir\nel horario que al efecto determinen con la Empleadora, dentro de los lÃ­mites\nlegales. Dicho acuerdo constarÃ¡ por escrito y se firmarÃ¡ por ambas partes,\npreviamente a la realizaciÃ³n del trabajo.<o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"margin-bottom:0cm;text-align:justify;line-height:\nnormal\"><span style=\"font-size: 12pt;\">Queda prohibido expresamente al trabajador laborar\nsobretiempo o simplemente permanecer en el recinto de la Empresa, despuÃ©s de la\nhora diaria de salida, salvo en los casos a que se refiere el inciso\nprecedente.<o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"margin-bottom:0cm;text-align:justify;line-height:\nnormal\"><b><span style=\"font-size: 12pt;\">Sexto:</span></b><span style=\"font-size: 12pt;\">&nbsp;De\nacuerdo al artÃ­culo 38, NÂº 3 del CÃ³digo del Trabajo, las partes dejan\nestablecido que la jornada ordinaria puede comprender domingos o festivos,\natendido el carÃ¡cter de las labores frutÃ­colas materia del presente contrato.<o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"margin-bottom:0cm;line-height:normal\"><b><span style=\"font-size: 12pt;\">SÃ©ptimo:&nbsp;</span></b><span style=\"font-size: 12pt;\">El trabajador declara que su rÃ©gimen\nprevisional es el siguiente:&nbsp;RÃ©gimen de pensiones: {AFP}, RÃ©gimen de salud:&nbsp;{SALUD}<o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"margin-bottom:0cm;text-align:justify;line-height:\nnormal\"><b><span style=\"font-size: 12pt;\">Octavo: Se deja expresa constancia que el\ntrabajador ingresÃ³ al servicio del empleador el&nbsp;{INICIO_CONTRATO}.</span></b><span style=\"font-size: 12pt;\"><o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"margin-bottom:0cm;text-align:justify;line-height:\nnormal\"><b><span style=\"font-size: 12pt;\">Noveno</span></b><span style=\"font-size: 12pt;\">:\nPara todos los efectos derivados del presente contrato las partes fijan\ndomicilio en la ciudad de&nbsp;{CEL_COMUNA}, y se someten a la JurisdicciÃ³n de\nsus Tribunales.<o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"margin-bottom:0cm;text-align:justify;line-height:\nnormal\"><span style=\"font-size: 12pt;\">El presente contrato se firma en 2 ejemplares,\ndeclarando el trabajador haber recibido en este acto un ejemplar de dicho\ninstrumento, que es el fiel reflejo de la relaciÃ³n laboral convenida.&nbsp; &nbsp;<o:p></o:p></span></p>', '2023-01-26 18:20:29'),
(7, 5, '<p class=\"MsoNormal\" align=\"center\" style=\"margin-bottom:0cm;text-align:center;\nline-height:normal\"><b><i><span lang=\"ES-TRAD\" style=\"font-size: 12pt;\">CONTRATO DE TRABAJO DE TEMPORADA O FAENA AGRÃCOLA</span></i></b><b><span style=\"font-size: 12pt;\"><o:p></o:p></span></b></p>\n\n<p class=\"MsoNormal\" style=\"margin-bottom:0cm;text-align:justify;line-height:\nnormal\"><span style=\"font-size: 12pt;\">En&nbsp;<b>{CEL_COMUNA}</b>, a&nbsp;{FECHA_CELEBRACION},\nentre&nbsp;<b>{NOMBRE_EMPRESA}</b>,&nbsp;<b>rol Ãºnico tributario&nbsp;{RUT_EMPRESA}</b>,\nrepresentada legalmente por&nbsp;<b>{REPRESENTANTE_LEGAL}, cÃ©dula de identidad {RUT_REPRESENTANTE_LEGAL}</b>,\nambos domiciliados en pasaje&nbsp;{CALLE_EMPRESA} {NUMERO_EMPRESA}</span>,\ncomuna de&nbsp;{COMUNA_EMPRESA}, regiÃ³n de&nbsp;{REGION_EMPRESA}, nÃºmero de\ntelÃ©fono/celular de contacto&nbsp;<b>{TELEFONO_EMPRESA}</b>, correo\nelectrÃ³nico&nbsp;<b>{CORREO_EMPRESA}</b>,&nbsp; en adelante el&nbsp;<b>\"Empleador\"</b>,\ny don (a)&nbsp;<b>{NOMBRE_TRABAJADOR} {APELLIDO_1} {APELLIDO_2}</b>, de\nnacionalidad&nbsp;{NACIONALIDAD},&nbsp;<b>cÃ©dula de identidad&nbsp;{RUT_TRABAJADOR},</b>&nbsp;estado\ncivil&nbsp;{ESTADO_CIVIL}, nacido (a) el&nbsp;{FECHA_NACIMIENTO}, domiciliado\n(a) en&nbsp;<b>{CALLE_TRABAJADOR} {NUMERO_CASA_TRABAJADOR}</b>, comuna de&nbsp;<b>{COMUNA_TRABAJADOR}</b>,\nregiÃ³n de&nbsp;<b>{REGION_TRABAJADOR}</b>, nÃºmero de telÃ©fono/celular de\ncontacto&nbsp;<b>{TELEFONO_TRABAJADOR}</b>, correo electrÃ³nico&nbsp;<b>{CORREO_TRABAJADOR}</b>,&nbsp;\nen adelante&nbsp;<b>â€œTrabajadorâ€</b>,&nbsp;se ha convenido en el siguiente\ncontrato de trabajo de temporada o de faena transitoria.<o:p></o:p></p>\n\n<p class=\"MsoNormal\" style=\"margin-bottom:0cm;text-align:justify;line-height:\nnormal\"><b><span style=\"font-size: 12pt;\">Primero:</span></b><span style=\"font-size: 12pt;\">&nbsp;El\ntrabajador prestarÃ¡ sus servicios como&nbsp;<b>{CARGO}</b>, ubicado en calle<b>&nbsp;{CALLE_ESPECIFICA}\n{NUMERO_CASA_ESPECIFICA}</b>, comuna de&nbsp;<b>{COMUNA_ESPECIFICA}</b>, regiÃ³n\nde&nbsp;<b>{REGION_ESPECIFICA}</b>,&nbsp;pudiendo ser trasladado a otros\npredios agrÃ­colas a cumplir labores similares, dentro de la ciudad, por causa\njustificada, sin que ello importe menoscabo para el trabajador.<o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"margin-bottom:0cm;text-align:justify;line-height:\nnormal\"><span style=\"font-size: 12pt;\">El empleador contrata al trabajador para ejecutar\nlas labores agrÃ­colas que se especifican:&nbsp;{DESCRIPCION_CARGO}.<o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"margin-bottom:0cm;text-align:justify;line-height:\nnormal\"><b><span style=\"font-size: 12pt;\">Segundo:</span></b><span style=\"font-size: 12pt;\">&nbsp;El\npresente contrato se entenderÃ¡ terminado automÃ¡ticamente, en la fecha en que\nconcluyen las faenas que le dieron origen y a que se ha hecho referencia en la\nclÃ¡usula primera, sin perjuicio que el empleador comunique por escrito este\nhecho, de conformidad con lo dispuesto en el artÃ­culo 162 del CÃ³digo del\nTrabajo.<o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"margin-bottom:0cm;text-align:justify;line-height:\nnormal\"><b><span style=\"font-size: 12pt;\">Tercero:</span></b><span style=\"font-size: 12pt;\">&nbsp;La&nbsp;{TIPO_JORNADA}&nbsp;de\ntrabajo serÃ¡ de&nbsp;<b>{DURACION_JORNADA_MENSUAL}</b>&nbsp;distribuidas de la\nsiguiente forma:<br>\n{DISTRIBUCION_JORNADA} {COLACION_MINUTOS}&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;\n&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp;<o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"margin-bottom:0cm;text-align:justify;line-height:\nnormal\"><b><span style=\"font-size: 12pt;\">Cuarto:</span></b><span style=\"font-size: 12pt;\">&nbsp;El\nempleador se compromete a remunerar los servicios del trabajador con un sueldo\nbase&nbsp;{SUELDO_BASE} de&nbsp;<b>${SUELDO_MONTO}.- ({SUELDO_MONTO_LETRAS})</b>,\nque serÃ¡ liquidado y pagado, por perÃ­odos vencidos en forma proporcional a los\ndÃ­as efectivamente trabajados.<o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"margin-bottom:0cm;text-align:justify;line-height:\nnormal\"><span style=\"font-size: 12pt;\">El pago se realizarÃ¡, mediante una&nbsp;{FORMA_PAGO}&nbsp;a\nsu&nbsp;<b>{TIPO_CUENTA}, NÂ°&nbsp;{NUMERO_CUENTA}, del&nbsp;{BANCO}.</b><o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"margin-bottom:0cm;text-align:justify;line-height:\nnormal\"><b><span style=\"font-size: 12pt;\">Quinto:</span></b><span style=\"font-size: 12pt;\">&nbsp;Cuando\npor necesidades de funcionamiento de la Empresa, sea necesario pactar trabajo\nen tiempo extraordinario, el trabajador que lo acuerde, se obligarÃ¡ a cumplir\nel horario que al efecto determinen con la Empleadora, dentro de los lÃ­mites\nlegales. Dicho acuerdo constarÃ¡ por escrito y se firmarÃ¡ por ambas partes,\npreviamente a la realizaciÃ³n del trabajo.<o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"margin-bottom:0cm;text-align:justify;line-height:\nnormal\"><span style=\"font-size: 12pt;\">Queda prohibido expresamente al trabajador laborar\nsobretiempo o simplemente permanecer en el recinto de la Empresa, despuÃ©s de la\nhora diaria de salida, salvo en los casos a que se refiere el inciso\nprecedente.<o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"margin-bottom:0cm;text-align:justify;line-height:\nnormal\"><b><span style=\"font-size: 12pt;\">Sexto:</span></b><span style=\"font-size: 12pt;\">&nbsp;De\nacuerdo al artÃ­culo 38, NÂº 3 del CÃ³digo del Trabajo, las partes dejan\nestablecido que la jornada ordinaria puede comprender domingos o festivos,\natendido el carÃ¡cter de las labores frutÃ­colas materia del presente contrato.<o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"margin-bottom:0cm;line-height:normal\"><b><span style=\"font-size: 12pt;\">SÃ©ptimo:&nbsp;</span></b><span style=\"font-size: 12pt;\">El trabajador declara que su rÃ©gimen\nprevisional es el siguiente:&nbsp;RÃ©gimen de pensiones: {AFP}, RÃ©gimen de salud:&nbsp;{SALUD}<o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"margin-bottom:0cm;text-align:justify;line-height:\nnormal\"><b><span style=\"font-size: 12pt;\">Octavo: Se deja expresa constancia que el\ntrabajador ingresÃ³ al servicio del empleador el&nbsp;{INICIO_CONTRATO}.</span></b><span style=\"font-size: 12pt;\"><o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"margin-bottom:0cm;text-align:justify;line-height:\nnormal\"><b><span style=\"font-size: 12pt;\">Noveno</span></b><span style=\"font-size: 12pt;\">:\nPara todos los efectos derivados del presente contrato las partes fijan\ndomicilio en la ciudad de&nbsp;{CEL_COMUNA}, y se someten a la JurisdicciÃ³n de\nsus Tribunales.<o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"margin-bottom:0cm;text-align:justify;line-height:\nnormal\"><span style=\"font-size: 12pt;\">El presente contrato se firma en 2 ejemplares,\ndeclarando el trabajador haber recibido en este acto un ejemplar de dicho\ninstrumento, que es el fiel reflejo de la relaciÃ³n laboral convenida.&nbsp; &nbsp;<o:p></o:p></span></p>', '2023-01-26 18:20:47');
INSERT INTO `plantillas` (`id`, `tipodocumento`, `contenido`, `register_at`) VALUES
(8, 5, '<p class=\"MsoNormal\" align=\"center\" style=\"margin-bottom:0cm;text-align:center;\nline-height:normal\"><b><i><span lang=\"ES-TRAD\" style=\"font-size: 12pt;\">CONTRATO DE TRABAJO DE TEMPORADA O FAENA AGRÃCOLA</span></i></b><b><span style=\"font-size: 12pt;\"><o:p></o:p></span></b></p>\n\n<p class=\"MsoNormal\" style=\"margin-bottom:0cm;text-align:justify;line-height:\nnormal\"><span style=\"font-size: 12pt;\">En&nbsp;<b>{CEL_COMUNA}</b>, a&nbsp;{FECHA_CELEBRACION},\nentre&nbsp;<b>{NOMBRE_EMPRESA}</b>,&nbsp;<b>rol Ãºnico tributario&nbsp;{RUT_EMPRESA}</b>,\nrepresentada legalmente por&nbsp;<b>{REPRESENTANTE_LEGAL}, cÃ©dula de identidad {RUT_REPRESENTANTE_LEGAL}</b>,\nambos domiciliados en pasaje&nbsp;{CALLE_EMPRESA} {NUMERO_EMPRESA}</span>,\ncomuna de&nbsp;{COMUNA_EMPRESA}, regiÃ³n de&nbsp;{REGION_EMPRESA}, nÃºmero de\ntelÃ©fono/celular de contacto&nbsp;<b>{TELEFONO_EMPRESA}</b>, correo\nelectrÃ³nico&nbsp;<b>{CORREO_EMPRESA}</b>,&nbsp; en adelante el&nbsp;<b>\"Empleador\"</b>,\ny don (a)&nbsp;<b>{NOMBRE_TRABAJADOR} {APELLIDO_1} {APELLIDO_2}</b>, de\nnacionalidad&nbsp;{NACIONALIDAD},&nbsp;<b>cÃ©dula de identidad&nbsp;{RUT_TRABAJADOR},</b>&nbsp;estado\ncivil&nbsp;{ESTADO_CIVIL}, nacido (a) el&nbsp;{FECHA_NACIMIENTO}, domiciliado\n(a) en&nbsp;<b>{CALLE_TRABAJADOR} {NUMERO_CASA_TRABAJADOR}</b>, comuna de&nbsp;<b>{COMUNA_TRABAJADOR}</b>,\nregiÃ³n de&nbsp;<b>{REGION_TRABAJADOR}</b>, nÃºmero de telÃ©fono/celular de\ncontacto&nbsp;<b>{TELEFONO_TRABAJADOR}</b>, correo electrÃ³nico&nbsp;<b>{CORREO_TRABAJADOR}</b>,&nbsp;\nen adelante&nbsp;<b>â€œTrabajadorâ€</b>,&nbsp;se ha convenido en el siguiente\ncontrato de trabajo de temporada o de faena transitoria.<o:p></o:p></p>\n\n<p class=\"MsoNormal\" style=\"margin-bottom:0cm;text-align:justify;line-height:\nnormal\"><b><span style=\"font-size: 12pt;\">Primero:</span></b><span style=\"font-size: 12pt;\">&nbsp;El\ntrabajador prestarÃ¡ sus servicios como&nbsp;<b>{CARGO}</b>, ubicado en calle<b>&nbsp;{CALLE_ESPECIFICA}\n{NUMERO_CASA_ESPECIFICA}</b>, comuna de&nbsp;<b>{COMUNA_ESPECIFICA}</b>, regiÃ³n\nde&nbsp;<b>{REGION_ESPECIFICA}</b>,&nbsp;pudiendo ser trasladado a otros\npredios agrÃ­colas a cumplir labores similares, dentro de la ciudad, por causa\njustificada, sin que ello importe menoscabo para el trabajador.<o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"margin-bottom:0cm;text-align:justify;line-height:\nnormal\"><span style=\"font-size: 12pt;\">El empleador contrata al trabajador para ejecutar\nlas labores agrÃ­colas que se especifican:&nbsp;{DESCRIPCION_CARGO}.<o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"margin-bottom:0cm;text-align:justify;line-height:\nnormal\"><b><span style=\"font-size: 12pt;\">Segundo:</span></b><span style=\"font-size: 12pt;\">&nbsp;El\npresente contrato se entenderÃ¡ terminado automÃ¡ticamente, en la fecha en que\nconcluyen las faenas que le dieron origen y a que se ha hecho referencia en la\nclÃ¡usula primera, sin perjuicio que el empleador comunique por escrito este\nhecho, de conformidad con lo dispuesto en el artÃ­culo 162 del CÃ³digo del\nTrabajo.<o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"margin-bottom:0cm;text-align:justify;line-height:\nnormal\"><b><span style=\"font-size: 12pt;\">Tercero:</span></b><span style=\"font-size: 12pt;\">&nbsp;La&nbsp;{TIPO_JORNADA}&nbsp;de\ntrabajo serÃ¡ de&nbsp;<b>{DURACION_JORNADA_MENSUAL}</b>&nbsp;distribuidas de la\nsiguiente forma:<br>\n{DISTRIBUCION_JORNADA} {COLACION_MINUTOS}&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;\n&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp;<o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"margin-bottom:0cm;text-align:justify;line-height:\nnormal\"><b><span style=\"font-size: 12pt;\">Cuarto:</span></b><span style=\"font-size: 12pt;\">&nbsp;El\nempleador se compromete a remunerar los servicios del trabajador con un sueldo\nbase&nbsp;{SUELDO_BASE} de&nbsp;<b>${SUELDO_MONTO}.- ({SUELDO_MONTO_LETRAS})</b>,\nque serÃ¡ liquidado y pagado, por perÃ­odos vencidos en forma proporcional a los\ndÃ­as efectivamente trabajados.<o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"margin-bottom:0cm;text-align:justify;line-height:\nnormal\"><span style=\"font-size: 12pt;\">El pago se realizarÃ¡, mediante una&nbsp;{FORMA_PAGO}&nbsp;a\nsu&nbsp;<b>{TIPO_CUENTA}, NÂ°&nbsp;{NUMERO_CUENTA}, del&nbsp;{BANCO}.</b><o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"margin-bottom:0cm;text-align:justify;line-height:\nnormal\"><b><span style=\"font-size: 12pt;\">Quinto:</span></b><span style=\"font-size: 12pt;\">&nbsp;Cuando\npor necesidades de funcionamiento de la Empresa, sea necesario pactar trabajo\nen tiempo extraordinario, el trabajador que lo acuerde, se obligarÃ¡ a cumplir\nel horario que al efecto determinen con la Empleadora, dentro de los lÃ­mites\nlegales. Dicho acuerdo constarÃ¡ por escrito y se firmarÃ¡ por ambas partes,\npreviamente a la realizaciÃ³n del trabajo.<o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"margin-bottom:0cm;text-align:justify;line-height:\nnormal\"><span style=\"font-size: 12pt;\">Queda prohibido expresamente al trabajador laborar\nsobretiempo o simplemente permanecer en el recinto de la Empresa, despuÃ©s de la\nhora diaria de salida, salvo en los casos a que se refiere el inciso\nprecedente.<o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"margin-bottom:0cm;text-align:justify;line-height:\nnormal\"><b><span style=\"font-size: 12pt;\">Sexto:</span></b><span style=\"font-size: 12pt;\">&nbsp;De\nacuerdo al artÃ­culo 38, NÂº 3 del CÃ³digo del Trabajo, las partes dejan\nestablecido que la jornada ordinaria puede comprender domingos o festivos,\natendido el carÃ¡cter de las labores frutÃ­colas materia del presente contrato.<o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"margin-bottom:0cm;line-height:normal\"><b><span style=\"font-size: 12pt;\">SÃ©ptimo:&nbsp;</span></b><span style=\"font-size: 12pt;\">El trabajador declara que su rÃ©gimen\nprevisional es el siguiente:&nbsp;RÃ©gimen de pensiones: {AFP}, RÃ©gimen de salud:&nbsp;{SALUD}<o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"margin-bottom:0cm;text-align:justify;line-height:\nnormal\"><b><span style=\"font-size: 12pt;\">Octavo: Se deja expresa constancia que el\ntrabajador ingresÃ³ al servicio del empleador el&nbsp;{INICIO_CONTRATO}.</span></b><span style=\"font-size: 12pt;\"><o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"margin-bottom:0cm;text-align:justify;line-height:\nnormal\"><b><span style=\"font-size: 12pt;\">Noveno</span></b><span style=\"font-size: 12pt;\">:\nPara todos los efectos derivados del presente contrato las partes fijan\ndomicilio en la ciudad de&nbsp;{CEL_COMUNA}, y se someten a la JurisdicciÃ³n de\nsus Tribunales.<o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"margin-bottom:0cm;text-align:justify;line-height:\nnormal\"><span style=\"font-size: 12pt;\">El presente contrato se firma en 2 ejemplares,\ndeclarando el trabajador haber recibido en este acto un ejemplar de dicho\ninstrumento, que es el fiel reflejo de la relaciÃ³n laboral convenida.&nbsp; &nbsp;<o:p></o:p></span></p>', '2023-01-26 18:21:04'),
(9, 5, '<p class=\"MsoNormal\" align=\"center\" style=\"margin-bottom:0cm;text-align:center;\nline-height:normal\"><b><i><span lang=\"ES-TRAD\" style=\"font-size: 12pt;\">CONTRATO DE TRABAJO DE TEMPORADA O FAENA AGRÃCOLA</span></i></b><b><span style=\"font-size: 12pt;\"><o:p></o:p></span></b></p>\n\n<p class=\"MsoNormal\" style=\"margin-bottom:0cm;text-align:justify;line-height:\nnormal\"><span style=\"font-size: 12pt;\">En&nbsp;<b>{CEL_COMUNA}</b>, a&nbsp;{FECHA_CELEBRACION},\nentre&nbsp;<b>{NOMBRE_EMPRESA}</b>,&nbsp;<b>rol Ãºnico tributario&nbsp;{RUT_EMPRESA}</b>,\nrepresentada legalmente por&nbsp;<b>{REPRESENTANTE_LEGAL}, cÃ©dula de identidad {RUT_REPRESENTANTE_LEGAL}</b>,\nambos domiciliados en pasaje&nbsp;{CALLE_EMPRESA} {NUMERO_EMPRESA}</span>,\ncomuna de&nbsp;{COMUNA_EMPRESA}, regiÃ³n de&nbsp;{REGION_EMPRESA}, nÃºmero de\ntelÃ©fono/celular de contacto&nbsp;<b>{TELEFONO_EMPRESA}</b>, correo\nelectrÃ³nico&nbsp;<b>{CORREO_EMPRESA}</b>,&nbsp; en adelante el&nbsp;<b>\"Empleador\"</b>,\ny don (a)&nbsp;<b>{NOMBRE_TRABAJADOR} {APELLIDO_1} {APELLIDO_2}</b>, de\nnacionalidad&nbsp;{NACIONALIDAD},&nbsp;<b>cÃ©dula de identidad&nbsp;{RUT_TRABAJADOR},</b>&nbsp;estado\ncivil&nbsp;{ESTADO_CIVIL}, nacido (a) el&nbsp;{FECHA_NACIMIENTO}, domiciliado\n(a) en&nbsp;<b>{CALLE_TRABAJADOR} {NUMERO_CASA_TRABAJADOR}</b>, comuna de&nbsp;<b>{COMUNA_TRABAJADOR}</b>,\nregiÃ³n de&nbsp;<b>{REGION_TRABAJADOR}</b>, nÃºmero de telÃ©fono/celular de\ncontacto&nbsp;<b>{TELEFONO_TRABAJADOR}</b>, correo electrÃ³nico&nbsp;<b>{CORREO_TRABAJADOR}</b>,&nbsp;\nen adelante&nbsp;<b>â€œTrabajadorâ€</b>,&nbsp;se ha convenido en el siguiente\ncontrato de trabajo de temporada o de faena transitoria.<o:p></o:p></p>\n\n<p class=\"MsoNormal\" style=\"margin-bottom:0cm;text-align:justify;line-height:\nnormal\"><b><span style=\"font-size: 12pt;\">Primero:</span></b><span style=\"font-size: 12pt;\">&nbsp;El\ntrabajador prestarÃ¡ sus servicios como&nbsp;<b>{CARGO}</b>, ubicado en calle<b>&nbsp;{CALLE_ESPECIFICA}\n{NUMERO_CASA_ESPECIFICA}</b>, comuna de&nbsp;<b>{COMUNA_ESPECIFICA}</b>, regiÃ³n\nde&nbsp;<b>{REGION_ESPECIFICA}</b>,&nbsp;pudiendo ser trasladado a otros\npredios agrÃ­colas a cumplir labores similares, dentro de la ciudad, por causa\njustificada, sin que ello importe menoscabo para el trabajador.<o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"margin-bottom:0cm;text-align:justify;line-height:\nnormal\"><span style=\"font-size: 12pt;\">El empleador contrata al trabajador para ejecutar\nlas labores agrÃ­colas que se especifican:&nbsp;{DESCRIPCION_CARGO}.<o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"margin-bottom:0cm;text-align:justify;line-height:\nnormal\"><b><span style=\"font-size: 12pt;\">Segundo:</span></b><span style=\"font-size: 12pt;\">&nbsp;El\npresente contrato se entenderÃ¡ terminado automÃ¡ticamente, en la fecha en que\nconcluyen las faenas que le dieron origen y a que se ha hecho referencia en la\nclÃ¡usula primera, sin perjuicio que el empleador comunique por escrito este\nhecho, de conformidad con lo dispuesto en el artÃ­culo 162 del CÃ³digo del\nTrabajo.<o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"margin-bottom:0cm;text-align:justify;line-height:\nnormal\"><b><span style=\"font-size: 12pt;\">Tercero:</span></b><span style=\"font-size: 12pt;\">&nbsp;La&nbsp;{TIPO_JORNADA}&nbsp;de\ntrabajo serÃ¡ de&nbsp;<b>{DURACION_JORNADA_MENSUAL}</b>&nbsp;distribuidas de la\nsiguiente forma:<br>\n{DISTRIBUCION_JORNADA} {COLACION_MINUTOS}&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;\n&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp;<o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"margin-bottom:0cm;text-align:justify;line-height:\nnormal\"><b><span style=\"font-size: 12pt;\">Cuarto:</span></b><span style=\"font-size: 12pt;\">&nbsp;El\nempleador se compromete a remunerar los servicios del trabajador con un sueldo\nbase&nbsp;{SUELDO_BASE} de&nbsp;<b>${SUELDO_MONTO}.- ({SUELDO_MONTO_LETRAS})</b>,\nque serÃ¡ liquidado y pagado, por perÃ­odos vencidos en forma proporcional a los\ndÃ­as efectivamente trabajados.<o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"margin-bottom:0cm;text-align:justify;line-height:\nnormal\"><span style=\"font-size: 12pt;\">El pago se realizarÃ¡, mediante una&nbsp;{FORMA_PAGO}&nbsp;a\nsu&nbsp;<b>{TIPO_CUENTA}, NÂ°&nbsp;{NUMERO_CUENTA}, del&nbsp;{BANCO}.</b><o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"margin-bottom:0cm;text-align:justify;line-height:\nnormal\"><b><span style=\"font-size: 12pt;\">Quinto:</span></b><span style=\"font-size: 12pt;\">&nbsp;Cuando\npor necesidades de funcionamiento de la Empresa, sea necesario pactar trabajo\nen tiempo extraordinario, el trabajador que lo acuerde, se obligarÃ¡ a cumplir\nel horario que al efecto determinen con la Empleadora, dentro de los lÃ­mites\nlegales. Dicho acuerdo constarÃ¡ por escrito y se firmarÃ¡ por ambas partes,\npreviamente a la realizaciÃ³n del trabajo.<o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"margin-bottom:0cm;text-align:justify;line-height:\nnormal\"><span style=\"font-size: 12pt;\">Queda prohibido expresamente al trabajador laborar\nsobretiempo o simplemente permanecer en el recinto de la Empresa, despuÃ©s de la\nhora diaria de salida, salvo en los casos a que se refiere el inciso\nprecedente.<o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"margin-bottom:0cm;text-align:justify;line-height:\nnormal\"><b><span style=\"font-size: 12pt;\">Sexto:</span></b><span style=\"font-size: 12pt;\">&nbsp;De\nacuerdo al artÃ­culo 38, NÂº 3 del CÃ³digo del Trabajo, las partes dejan\nestablecido que la jornada ordinaria puede comprender domingos o festivos,\natendido el carÃ¡cter de las labores frutÃ­colas materia del presente contrato.<o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"margin-bottom:0cm;line-height:normal\"><b><span style=\"font-size: 12pt;\">SÃ©ptimo:&nbsp;</span></b><span style=\"font-size: 12pt;\">El trabajador declara que su rÃ©gimen\nprevisional es el siguiente:&nbsp;RÃ©gimen de pensiones: {AFP}, RÃ©gimen de salud:&nbsp;{SALUD}<o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"margin-bottom:0cm;text-align:justify;line-height:\nnormal\"><b><span style=\"font-size: 12pt;\">Octavo: Se deja expresa constancia que el\ntrabajador ingresÃ³ al servicio del empleador el&nbsp;{INICIO_CONTRATO}.</span></b><span style=\"font-size: 12pt;\"><o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"margin-bottom:0cm;text-align:justify;line-height:\nnormal\"><b><span style=\"font-size: 12pt;\">Noveno</span></b><span style=\"font-size: 12pt;\">:\nPara todos los efectos derivados del presente contrato las partes fijan\ndomicilio en la ciudad de&nbsp;{CEL_COMUNA}, y se someten a la JurisdicciÃ³n de\nsus Tribunales.<o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"margin-bottom:0cm;text-align:justify;line-height:\nnormal\"><span style=\"font-size: 12pt;\">El presente contrato se firma en 2 ejemplares,\ndeclarando el trabajador haber recibido en este acto un ejemplar de dicho\ninstrumento, que es el fiel reflejo de la relaciÃ³n laboral convenida.&nbsp; &nbsp;</span></p><p class=\"MsoNormal\" style=\"margin-bottom:0cm;text-align:justify;line-height:\nnormal\"><span style=\"font-size: 12pt;\"><o:p></o:p></span></p>', '2023-01-26 18:21:20'),
(10, 7, '<p class=\"MsoNormal\" align=\"center\" style=\"margin-bottom:0cm;text-align:center;\nline-height:normal\"><b><i><span lang=\"ES-TRAD\" style=\"font-size: 8pt; font-family: Verdana, sans-serif;\">FINIQUITO</span></i></b><b><span style=\"font-size: 8pt; font-family: Poppins;\"><o:p></o:p></span></b></p>\n\n<p class=\"MsoNormal\" style=\"margin-bottom:0cm;text-align:justify;line-height:\nnormal\"><span style=\"font-size: 8pt; font-family: Poppins;\">En&nbsp;<b>{CEL_COMUNA}</b>,\na&nbsp;(fecha finiquito), entre&nbsp;<b>{NOMBRE_EMPRESA}</b>,&nbsp;<b>rol Ãºnico\ntributario&nbsp;{RUT_EMPRESA}</b>, representada legalmente por&nbsp;<b>{REPRESENTANTE_LEGAL},\ncÃ©dula de identidad {RUT_REPRESENTANTE_LEGAL}</b>, ambos domiciliados en\npasaje&nbsp;{CALLE_EMPRESA}, comuna de&nbsp;{COMUNA_EMPRESA}, regiÃ³n\nde&nbsp;{REGION_EMPRESA}, nÃºmero de telÃ©fono/celular de contacto&nbsp;<b>{TELEFONO_EMPRESA}</b>,\ncorreo electrÃ³nico&nbsp;<b>{CORREO_EMPRESA}</b>,&nbsp; en adelante el&nbsp;<b>\"Empresa\no Empleador\"</b>, y don (a)&nbsp;<b>{NOMBRE_TRABAJADOR} {APELLIDO_1}\n{APELLIDO_2}</b>, de nacionalidad&nbsp;{NACIONALIDAD},&nbsp;<b>cÃ©dula de\nidentidad&nbsp;{RUT_TRABAJADOR}</b>,&nbsp;estado civil&nbsp;{ESTADO_CIVIL},\nnacido (a) el&nbsp;{FECHA_NACIMIENTO}, domiciliado (a) en&nbsp;<b>{CALLE_TRABAJADOR}\n{NUMERO_CASA_TRABAJADOR}</b>, comuna de&nbsp;<b>{COMUNA_TRABAJADOR}</b>, regiÃ³n\nde&nbsp;<b>{REGION_TRABAJADOR}</b>, nÃºmero de telÃ©fono/celular de\ncontacto&nbsp;<b>{TELEFONO_TRABAJADOR}</b>, correo electrÃ³nico&nbsp;<b>{CORREO_TRABAJADOR}</b>,&nbsp;en\nadelante&nbsp;<b>â€œTrabajadorâ€,</b>&nbsp;se ha convenido en el siguiente finiquito\nde contrato de trabajo:<o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"margin-bottom:0cm;text-align:justify;line-height:\nnormal\"><b><span style=\"font-size: 8pt; font-family: Poppins;\">Primero:</span></b><span style=\"font-size: 8pt; font-family: Poppins;\">&nbsp;El trabajador <b>{NOMBRE_TRABAJADOR}\n{APELLIDO_1} {APELLIDO_2} </b>declara haber prestado servicios en calidad de <b>{CARGO}</b>\na <b>{NOMBRE_EMPRESA}</b>,&nbsp;<b>rol Ãºnico tributario&nbsp;{RUT_EMPRESA} </b>desde\n<b>{INICIO_CONTRATO} </b>hasta (fecha termino relaciÃ³n laboral) fecha esta\nÃºltima en que su contrato de trabajo ha terminado por la siguiente causa de\nacuerdo legal: (artÃ­culo del C del T)<o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"margin-bottom:0cm;text-align:justify;line-height:\nnormal\"><b><span style=\"font-size: 8pt; font-family: Poppins;\">Segundo:</span></b><span style=\"font-size: 8pt; font-family: Poppins;\">&nbsp;<b>{NOMBRE_TRABAJADOR}\n{APELLIDO_1} {APELLIDO_2} </b>declara recibir en este acto, a su entera\nsatisfacciÃ³n, de parte de <b>{NOMBRE_EMPRESA} </b>la suma que a continuaciÃ³n se\ndetallan:<o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"margin-bottom:0cm;text-align:justify;line-height:\nnormal\"><b><span style=\"font-size: 8pt; font-family: Poppins;\">Tercero:</span></b><span style=\"font-size: 8pt; font-family: Poppins;\">&nbsp;En consecuencia, el empleador\npaga a <b>{NOMBRE_TRABAJADOR} {APELLIDO_1} {APELLIDO_2} </b>a travÃ©s una&nbsp;{FORMA_PAGO}&nbsp;a\nsu&nbsp;<b>{TIPO_CUENTA}, NÂ°&nbsp;{NUMERO_CUENTA}, del&nbsp;{BANCO}</b>, que el\ntrabajador declara recibir en este acto a su entera satisfacciÃ³n. <o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"margin-bottom:0cm;text-align:justify;line-height:\nnormal\"><b><span style=\"font-size: 8pt; font-family: Poppins;\">Cuarto:</span></b><span style=\"font-size: 8pt; font-family: Poppins;\">&nbsp;<b>{NOMBRE_TRABAJADOR}\n{APELLIDO_1} {APELLIDO_2} </b>deja constancia que durante el tiempo que prestÃ³\nservicios a <b>{NOMBRE_EMPRESA}</b>, recibiÃ³ oportunamente el total de las remuneraciones,\nbeneficios y demÃ¡s prestaciones convenidas de acuerdo a su contrato de trabajo,\nclase de trabajo ejecutado y disposiciones legales pertinentes, y que en virtud\nde esto el empleador nada le adeuda por tales conceptos, ni por horas\nextraordinarias, asignaciÃ³n familiar, feriado indemnizaciÃ³n por aÃ±os de\nservicios, imposiciones previsionales, asÃ­ como por ningÃºn otro concepto, ya\nsea legal o contractual, derivado de la prestaciÃ³n de sus servicios, de su\ncontrato de trabajo o de la terminaciÃ³n del mismo. Es por esto que don <b>{NOMBRE_TRABAJADOR}\n{APELLIDO_1} {APELLIDO_2} </b>declara que no tiene reclamo alguno que formular\nen contra de <b>{NOMBRE_EMPRESA}</b> renunciando a todas las acciones que\npudieran emanar del contrato que los vinculÃ³ laboralmente.</span><span style=\"font-size:8.0pt\"><o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"margin-bottom:0cm;text-align:justify;line-height:\nnormal\"><b><span style=\"font-size: 8pt; font-family: Poppins;\">Quinto:</span></b><span style=\"font-size: 8pt; font-family: Poppins;\">&nbsp;SegÃºn lo anteriormente\nexpuesto, <b>{NOMBRE_TRABAJADOR} {APELLIDO_1} {APELLIDO_2} </b>manifiesta que nada\nle adeuda en relaciÃ³n con los servicios prestados, con el contrato de trabajo o\ncon motivo de la terminaciÃ³n del mismo, por lo que libre y espontÃ¡neamente, y\ncon el pleno y cabal conocimiento de sus derechos, otorga a su empleador, el\nmÃ¡s amplio, completo, total y definitivo finiquito por los servicios prestados\no la terminaciÃ³n de ellos, ya diga relaciÃ³n con remuneraciones, cotizaciones previsionales,\nde seguridad social o de salud, subsidios, beneficios contractuales adicionales\na las remuneraciones, indemnizaciones, compensaciones, o con cualquiera causa o\nconcepto.<o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"margin-bottom:0cm;text-align:justify;line-height:\nnormal\"><b><span style=\"font-size: 8pt; font-family: Poppins;\">Sexto:</span></b><span style=\"font-size: 8pt; font-family: Poppins;\">&nbsp;TambiÃ©n, declara el trabajador\nque, en todo caso y a todo evento, renuncia expresamente a cualquier derecho,\nacciÃ³n o reclamo que eventualmente tuviere o pudiere corresponderle en contra\ndel empleador, en relaciÃ³n directa o indirecta con su contrato de trabajo, con\nlos servicios prestados, con la terminaciÃ³n del referido contrato o dichos\nservicios, sepa que esos derechos o acciones correspondan a remuneraciones,\ncotizaciones previsionales, de seguridad social o salud, subsidios, beneficios\ncontractuales adicionales a las remuneraciones a las remuneraciones, indemnizaciones\ncompensaciones, o con cualquier otra causa o concepto.</span><span style=\"font-size:8.0pt\"><o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"margin-bottom:0cm;text-align:justify;line-height:\nnormal\"><b><span style=\"font-size: 8pt; font-family: Poppins;\">SÃ©ptimo:&nbsp;</span></b><span style=\"font-size: 8pt; font-family: Poppins;\">De acuerdo con la Ley NÂ° 21.389 el\nempleador declara bajo juramento que el trabajador no se encuentra sujeto a la\nretenciÃ³n judicial de pensiÃ³n alimenticia, segÃºn se acredita con la exhibiciÃ³n\nde las 3 Ãºltimas liquidaciones de sueldo, liberando en este acto al notario u\noficial civil autorizante de cualquier responsabilidad por el no pago de esta.<o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"margin-bottom:0cm;text-align:justify;line-height:\nnormal\"><b><span style=\"font-size: 8pt; font-family: Poppins;\">Octavo: </span></b><span style=\"font-size: 8pt; font-family: Poppins;\">Se deja constancia, las partes firman\nel presente finiquito en 3 ejemplares, quedando uno en poder de cada una de\nellas, y en cumplimiento de la legislaciÃ³n vigente.<o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"margin-bottom:0cm;text-align:justify;line-height:\nnormal\"><span style=\"font-size: 8pt; font-family: Poppins;\">&nbsp;</span></p>\n\n<p class=\"MsoNormal\" style=\"margin-bottom:0cm;text-align:justify;line-height:\nnormal\"><span style=\"font-size: 8pt; font-family: Poppins;\">&nbsp;</span></p>', '2023-01-26 18:28:15'),
(11, 8, '<p class=\"H1\" align=\"center\" style=\"text-align:center\"><i><span lang=\"ES-TRAD\" style=\"font-size:14.0pt;mso-bidi-font-size:10.0pt\">Contrato\nde trabajo <o:p></o:p></span></i></p>\n\n<p class=\"MsoBodyText\"><span lang=\"ES-CL\" style=\"font-size:11.0pt;mso-bidi-font-size:\n10.0pt\">En&nbsp;</span>{CEL_COMUNA}<span lang=\"ES-CL\" style=\"font-size:11.0pt;mso-bidi-font-size:\n10.0pt\">, a </span>{FECHA_CELEBRACION}<span lang=\"ES-CL\" style=\"font-size:11.0pt;mso-bidi-font-size:\n10.0pt\">, entre, </span>{NOMBRE_EMPRESA}<span lang=\"ES-CL\" style=\"font-size:11.0pt;mso-bidi-font-size:\n10.0pt\">, <b>rol\nÃºnico tributario </b></span>{RUT_EMPRESA}<span lang=\"ES-CL\" style=\"font-size:11.0pt;mso-bidi-font-size:\n10.0pt\">, Empleador o Empresa de Transportes, representado\nlegalmente por don </span>{REPRESENTANTE_LEGAL}<span lang=\"ES-CL\" style=\"font-size:11.0pt;mso-bidi-font-size:\n10.0pt\">, cedula de identidad </span>{RUT_REPRESENTANTE_LEGAL}<span lang=\"ES-CL\" style=\"font-size:11.0pt;mso-bidi-font-size:\n10.0pt\">,\nambos domiciliados para estos efectos en </span>{CALLE_EMPRESA}&nbsp;{NUMERO_EMPRESA}<span lang=\"ES-CL\" style=\"font-size:11.0pt;mso-bidi-font-size:\n10.0pt\">, comuna de </span>{CEL_COMUNA}<span lang=\"ES-CL\" style=\"font-size:11.0pt;mso-bidi-font-size:\n10.0pt\">,\ncorreo electrÃ³nico </span>{CORREO_EMPRESA}<span lang=\"ES-CL\" style=\"font-size:11.0pt;mso-bidi-font-size:\n10.0pt\"><b>,\n</b>nÃºmero de contacto </span>{TELEFONO_EMPRESA}<span lang=\"ES-CL\" style=\"font-size:11.0pt;mso-bidi-font-size:\n10.0pt\"><b>,</b> y don </span>{NOMBRE_TRABAJADOR} {APELLIDO_1}&nbsp;{APELLIDO_2}<span lang=\"ES-CL\" style=\"font-size:11.0pt;mso-bidi-font-size:\n10.0pt\">, de nacionalidad Chilena, <b>Cedula de identidad </b></span>{RUT_TRABAJADOR}<span lang=\"ES-CL\" style=\"font-size:11.0pt;mso-bidi-font-size:\n10.0pt\">, estado </span>{ESTADO_CIVIL}<span lang=\"ES-CL\" style=\"font-size:11.0pt;mso-bidi-font-size:\n10.0pt\">, nacido el </span>{FECHA_NACIMIENTO}<span lang=\"ES-CL\" style=\"font-size:11.0pt;mso-bidi-font-size:\n10.0pt\">, domiciliado en </span>{CALLE_TRABAJADOR}&nbsp;{NUMERO_CASA_TRABAJADOR}<span lang=\"ES-CL\" style=\"font-size:11.0pt;mso-bidi-font-size:\n10.0pt\">&nbsp;, comuna </span>{COMUNA_TRABAJADOR}<span lang=\"ES-CL\" style=\"font-size:11.0pt;mso-bidi-font-size:\n10.0pt\">, </span>{REGION_TRABAJADOR},&nbsp;<span lang=\"ES-CL\" style=\"font-size:11.0pt;mso-bidi-font-size:\n10.0pt\">correo electrÃ³nico </span>{CORREO_TRABAJADOR},<span lang=\"ES-CL\" style=\"font-size:11.0pt;mso-bidi-font-size:\n10.0pt\">&nbsp;nÃºmero de contacto </span>{TELEFONO_TRABAJADOR}<span lang=\"ES-CL\" style=\"font-size:11.0pt;mso-bidi-font-size:\n10.0pt\">, se ha convenido el siguiente Contrato\nIndividual de Trabajo, para cuyo efecto las partes convienen en denominarse <b>\"Empleador\ny Chofer\",</b> respectivamente.<o:p></o:p></span></p>\n\n<p class=\"MsoBodyText\"><span lang=\"ES-CL\" style=\"font-size:11.0pt;mso-bidi-font-size:\n10.0pt\">&nbsp;</span></p>\n\n<p class=\"MsoNormal\" style=\"text-align:justify\"><span lang=\"ES-CL\" style=\"font-size:11.0pt;mso-bidi-font-size:10.0pt\">PRIMERO: Don </span>{NOMBRE_TRABAJADOR}&nbsp;{APELLIDO_1}&nbsp;{APELLIDO_2}<span lang=\"ES-CL\" style=\"font-size:11.0pt;mso-bidi-font-size:10.0pt\">, se\ncompromete a efectuar el trabajo de </span>{CARGO}<span lang=\"ES-CL\" style=\"font-size:11.0pt;mso-bidi-font-size:10.0pt\">&nbsp;en los buses que el Empleador le asigne, dentro de la <b>â€œAsociaciÃ³n Gremial de\nBuses Galgo Ã“mnibus AsociaciÃ³n Gremial de Transporte\"</b> y que estÃ¡n\ndestinados al servicio de la locomociÃ³n colectiva rural en el trayecto Rancagua\nâ€“ Santa InÃ©s; Rancagua â€“ San Fernando; Rancagua â€“ Quinta de Til-coco; Rancagua\nâ€“ Villa MarÃ­a; Rancagua â€“ Pimpinela.<o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"text-align:justify\"><span lang=\"ES-CL\" style=\"font-size:11.0pt;mso-bidi-font-size:10.0pt\">SEGUNDO: Atendida la\nnaturaleza desplazable de la prestaciÃ³n de los servicios, se entenderÃ¡ por\nlugar de trabajo toda la zona geogrÃ¡fica comprendida en el itinerario indicado\nen la clÃ¡usula primera.<o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"text-align:justify\"><span lang=\"ES-CL\" style=\"font-size:11.0pt;mso-bidi-font-size:10.0pt\">TERCERO: El trabajo\nespecÃ­fico del Chofer consistirÃ¡, por lo tanto, en el transporte y traslado de\npasajeros y de la carga rural correspondiente, valijas, bultos, paquetes,\ncartas y encomiendas que se deba distribuir en los trayectos antes indicados.<o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"text-align:justify\"><span lang=\"ES-CL\" style=\"font-size:11.0pt;mso-bidi-font-size:10.0pt\">CUARTO: La jornada efectiva\nde trabajo serÃ¡ de </span>{DURACION_JORNADA_MENSUAL}<span lang=\"ES-CL\" style=\"font-size:11.0pt;mso-bidi-font-size:10.0pt\"><b>&nbsp;, distribuidas en </b></span>{HORARIOS_TURNOS}<span lang=\"ES-CL\" style=\"font-size:11.0pt;mso-bidi-font-size:10.0pt\"><b>.</b> Esta jornada, que <b>no podrÃ¡ exceder de 10 horas\ndiarias,</b> se desarrollarÃ¡ en el horario comprendido conforme a los despachos\nde preferencia u ordinarios que le sean asignados por el Inspector de Garita.<o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"text-align:justify\"><span lang=\"ES-CL\" style=\"font-size:11.0pt;mso-bidi-font-size:10.0pt\">AdemÃ¡s, a travÃ©s de la\nrespectiva planilla de ruta o por medio de otro mecanismo idÃ³neo de publicidad,\nque podrÃ¡ colocarse en los terminales de la respectiva LÃ­nea, se comunicarÃ¡ al\nchofer al tÃ©rmino de su jornada, la hora de su primera salida del dÃ­a\nsiguiente.<o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"text-align:justify\"><span lang=\"ES-CL\" style=\"font-size:11.0pt;mso-bidi-font-size:10.0pt\">QUINTO: De conformidad con\nla clÃ¡usula anterior no se considerarÃ¡ como jornada de trabajo, el tiempo en\nque el Chofer anticipe su llegada a la Garita.<o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"text-align:justify\"><span lang=\"ES-CL\" style=\"font-size:11.0pt;mso-bidi-font-size:10.0pt\">SEXTO: Considerando que la\njornada de trabajo incluye domingos y festivos, el Chofer tendrÃ¡ derecho a\ndescansar un dÃ­a a la semana, en compensaciÃ³n a las actividades desarrolladas\nen dÃ­a domingo y otro por cada festivo en que el trabajador preste servicios.<o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"text-align:justify\"><span lang=\"ES-CL\" style=\"font-size:11.0pt;mso-bidi-font-size:10.0pt\">SEPTIMO: Por circunstancias\nque afecten toda la actividad de la AsociaciÃ³n, como la implantaciÃ³n de\nhorarios de verano, invierno, vacaciones de invierno, de fiestas patrias,\nSemana Santa y otras el Empleador podrÃ¡ alterar la distribuciÃ³n de la jornada\nconvenida hasta sesenta minutos, sea anticipando o postergando la hora de\niniciaciÃ³n del trabajo, lo que se avisarÃ¡ al Chofer con 10 dÃ­as de anticipaciÃ³n\na lo menos.<o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"text-align:justify\"><span lang=\"ES-CL\" style=\"font-size:11.0pt;mso-bidi-font-size:10.0pt\">OCTAVO: El Empleador se\ncompromete a remunerar mensualmente al trabajador, por la prestaciÃ³n de sus\nservicios ordinarios o especiales que se fijen, con la cantidad de </span>{SUELDO_MONTO}<span lang=\"ES-CL\" style=\"font-size:11.0pt;mso-bidi-font-size:10.0pt\"><b>.- (</b></span>{SUELDO_MONTO_LETRAS}<span lang=\"ES-CL\" style=\"font-size:11.0pt;mso-bidi-font-size:10.0pt\"><b>)</b>\nmensuales la que tendrÃ¡ el carÃ¡cter de sueldo base y que se pagarÃ¡ hasta el dÃ­a\n5 del mes entrante.<o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"text-align:justify\"><span lang=\"ES-CL\" style=\"font-size:11.0pt;mso-bidi-font-size:10.0pt\">NOVENO: El Trabajador queda\nautorizado para retirar solo en una oportunidad, a cuenta de su remuneraciÃ³n\nmensual, sÃ³lo el 20%, procediÃ©ndose a liquidar el sueldo base convenido, a fin\nde cada mes.<o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"text-align:justify\"><span lang=\"ES-CL\" style=\"font-size:11.0pt;mso-bidi-font-size:10.0pt\">DECIMO: Las partes\ncontratantes convienen que servirÃ¡ como comprobante de asistencia mensual, la\nrespectiva GUIA DE TRABAJO DIARIO, la que deberÃ¡ contemplar para esa validez,\nla firma del trabajador con indicaciÃ³n de la cantidad recibida.<o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"text-align:justify\"><span lang=\"ES-CL\" style=\"font-size:11.0pt;mso-bidi-font-size:10.0pt\">DECIMO PRIMERO: Las\ndeducciones que la empleadora podrÃ¡ practicar a las remuneraciones son todas\naquellas que autoriza el art. 58 del CÃ³digo del Trabajo.<o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"text-align:justify\"><span lang=\"ES-CL\" style=\"font-size:11.0pt;mso-bidi-font-size:10.0pt\">Con todo, por este\ninstrumento, el Chofer acepta y autoriza al Empleador para que se le descuente\ndel sueldo mensual, el tiempo no trabajado debido a atrasos e inasistencias sin\njustificar debidamente.<o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"text-align:justify\"><span lang=\"ES-CL\" style=\"font-size:11.0pt;mso-bidi-font-size:10.0pt\">Practicada las deducciones\nlegales y descuentos autorizados, el chofer deberÃ¡ firmar su liquidaciÃ³n de\nsueldos y otorgar el recibo correspondiente.<o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"text-align:justify\"><span lang=\"ES-CL\" style=\"font-size:11.0pt;mso-bidi-font-size:10.0pt\">DECIMO SEGUNDO: El\ntrabajador declara pertenece al <b>sistema de salud </b></span>{SALUD}<span lang=\"ES-CL\" style=\"font-size:11.0pt;mso-bidi-font-size:10.0pt\"><b>,</b> y se encuentra\nafiliado a <b>AFP&nbsp;</b></span>{AFP}.<span lang=\"ES-CL\" style=\"font-size:11.0pt;mso-bidi-font-size:10.0pt\"><o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"text-align:justify\"><span lang=\"ES-CL\" style=\"font-size:11.0pt;mso-bidi-font-size:10.0pt\">DECIMO TERCERO: Se establecen\ncomo obligaciones esenciales del Chofer, las siguientes conviniÃ©ndose que la\ninfracciÃ³n a cualquiera de ellas serÃ¡ considerada de incumplimiento grave de\nlas obligaciones que impone el contrato, siendo la terminaciÃ³n de los servicios\nuna facultad que se reserva el Empleador segÃºn la gravedad de las faltas, todo\nen conformidad con lo dispuesto en el CÃ³digo del Trabajo.<o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"text-align:justify\"><span lang=\"ES-CL\" style=\"font-size:11.0pt;mso-bidi-font-size:10.0pt\">a) Presentarse puntualmente\na la hora prefijada para el cumplimiento de su turno, en todo caso, con una\nantelaciÃ³n de 15 minutos a lo menos a la hora de salida en su respectiva\ngarita; <o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"text-align:justify\"><span lang=\"ES-CL\" style=\"font-size:11.0pt;mso-bidi-font-size:10.0pt\">b) Presentarse al trabajo en\ncondiciones fÃ­sicas y mentales adecuadas, cuidando en especial su presentaciÃ³n\npersonal, documentos de competencia al dÃ­a y uniforme si procediere; <o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"text-align:justify\"><span lang=\"ES-CL\" style=\"font-size:11.0pt;mso-bidi-font-size:10.0pt\">c) Cumplir en forma\nirrestricta las instrucciones, Ã³rdenes, circulares, memorÃ¡ndums que le imparten\nel Empleador, el Jefe de Servicios y las que emanen del Departamento de Trafico;\n<o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"text-align:justify\"><span lang=\"ES-CL\" style=\"font-size:11.0pt;mso-bidi-font-size:10.0pt\">d) Respetar en su trabajo\nlas normas legales y reglamentarias de los servicios de transportes por calles\ny caminos, Ordenanza General del TrÃ¡nsito PÃºblico que en este acto declara\nconocer; en tal sentido, las sanciones que se deriven de su aplicaciÃ³n lo\nafectarÃ¡n exclusiva y personalmente, salvo que la ley estableciere lo contrario;\n<o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"text-align:justify\"><span lang=\"ES-CL\" style=\"font-size:11.0pt;mso-bidi-font-size:10.0pt\">e) Entregar al empleador a\nmÃ¡s tardar dentro de las 24 horas siguientes al tÃ©rmino de la jornada, cuenta\ndetallada de la recaudaciÃ³n diaria por venta de boletos, realizada en el\nautobÃºs y la relaciÃ³n documentada de los gastos producidos; <o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"text-align:justify\"><span lang=\"ES-CL\" style=\"font-size:11.0pt;mso-bidi-font-size:10.0pt\">f) retenciÃ³n de planillas o\nde dinero o entrega parcial de Ã©stos. La entrega sÃ³lo podrÃ¡ acreditarse\nmediante un recibo comprobante; <o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"text-align:justify\"><span lang=\"ES-CL\" style=\"font-size:11.0pt;mso-bidi-font-size:10.0pt\">g) Cobrar las tarifas en su\nvalor vigente y entregar los boletos correspondientes a ellas. Anotar\nclaramente en la GUIA a su cargo, nÃºmero y serie de boletos que ocupa, debiendo\nexistir correlaciÃ³n de nÃºmero y serie en las guÃ­as siguientes; <o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"text-align:justify\"><span lang=\"ES-CL\" style=\"font-size:11.0pt;mso-bidi-font-size:10.0pt\">h) No llevar pasajeros\ngratis, sin boletos; <o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"text-align:justify\"><span lang=\"ES-CL\" style=\"font-size:11.0pt;mso-bidi-font-size:10.0pt\">i) Ser respetuoso y\ndeferente con el pÃºblico usuario y con los poseedores de PASES LIBRES; <o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"text-align:justify\"><span lang=\"ES-CL\" style=\"font-size:11.0pt;mso-bidi-font-size:10.0pt\">j) Marcar en los controles\nque la AsociaciÃ³n disponga, estando obligado ademÃ¡s a someterse a la revisiÃ³n y\ncontrol de los Inspectores de Recorrido y de Garita, y facilitarles en toda su\nlabor fiscalizadora; <o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"text-align:justify\"><span lang=\"ES-CL\" style=\"font-size:11.0pt;mso-bidi-font-size:10.0pt\">k) No circular por rutas o\narterias expresamente prohibidas por el empleador o la AsociaciÃ³n Gremial,\ndebiendo cumplir con los recorridos sin variarlos, salvo fuerza mayor u orden\nde la autoridad competente; 1) No efectuar otros servicios o recorridos para\nlos cuales no ha sido contratado y, no ofrecer dÃ¡divas a los Inspectores de la\nAsociaciÃ³n con el objeto de evitar que se le revise y controle; <o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"text-align:justify\"><span lang=\"ES-CL\" style=\"font-size:11.0pt;mso-bidi-font-size:10.0pt\">m) No entregar el vehÃ­culo\ndurante su jornada o turno a otro chofer, salvo autorizaciÃ³n en contrario y\nconducir pasajeros en contravenciÃ³n a las normas sobre servicios especiales; <o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"text-align:justify\"><span lang=\"ES-CL\" style=\"font-size:11.0pt;mso-bidi-font-size:10.0pt\">n) presentarse y ponerse a\ndisposiciÃ³n del Empleador cuando el vehÃ­culo asignado estÃ© en reparaciones; o)\njustificar mediante certificado mÃ©dico competente, cualquier inasistencia por\nmotivos de enfermedad, dentro de las 24 horas siguientes; <o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"text-align:justify\"><span lang=\"ES-CL\" style=\"font-size:11.0pt;mso-bidi-font-size:10.0pt\">p) Es obligaciÃ³n primera del\nChofer, antes de iniciar su servicio, efectuar una revisiÃ³n a los neumÃ¡ticos,\ncontrolar la presiÃ³n de aire, los niveles de aceite y el agua del radiador, en\ngeneral, le corresponde preocuparse en todo momento por la buena presentaciÃ³n,\nconservaciÃ³n y mantenciÃ³n de la mÃ¡quina a su cargo, de sus herramientas y\naccesorios debiendo dar cuenta inmediata al Empleador de cualquier desperfecto\no deficiencia que detectare. El omitir esta informaciÃ³n supone que la mÃ¡quina\nse recibiÃ³ en perfectas condiciones al salir despachado de la garita o\nterminal; <o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"text-align:justify\"><span lang=\"ES-CL\" style=\"font-size:11.0pt;mso-bidi-font-size:10.0pt\">q) El Empleador por su\nparte, deberÃ¡ subsanar a la brevedad cualquier desperfecto o deficiencia que\nseÃ±ale el chofer. EL no hacerlo o a destiempo, significa que el chofer quedarÃ¡\nexento de responsabilidad alguna, por las consecuencias que se deriven de la\nconducciÃ³n en esas circunstancias; <o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"text-align:justify\"><span lang=\"ES-CL\" style=\"font-size:11.0pt;mso-bidi-font-size:10.0pt\">r) Estando a su cargo la\nmÃ¡quina mientras la conduce en su turno de trabajo, serÃ¡ obligaciÃ³n del chofer,\nprocurar el buen mantenimiento y funcionamiento de los sistemas de luces\ninteriores, puertas, vidrios, tapicerÃ­a, frenos, direcciÃ³n y la limpieza del\nvehÃ­culo; <o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"text-align:justify\"><span lang=\"ES-CL\" style=\"font-size:11.0pt;mso-bidi-font-size:10.0pt\">s) Una vez terminada la\njornada de trabajo el Chofer deberÃ¡ dejar la mÃ¡quina con sus estanques de\nbencina, lubricantes y agua completa y guardar el autobÃºs en el lugar que le indique\nel Empleador y abastecerlo de combustible, en los lugares donde Ã©ste Ãºltimo se\nlo seÃ±ale. Esta orden serÃ¡ dada por escrito para su validez; <o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"text-align:justify\"><span lang=\"ES-CL\" style=\"font-size:11.0pt;mso-bidi-font-size:10.0pt\">t) Dejar constancia en la\nUnidad de Carabineros mÃ¡s prÃ³xima, de todo accidente de trÃ¡nsito en que se vea\ninvolucrada la mÃ¡quina que conduce y dar aviso de inmediato al Empleador,\nAsociaciÃ³n y Garita, respectivamente. <o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"text-align:justify\"><span lang=\"ES-CL\" style=\"font-size:11.0pt;mso-bidi-font-size:10.0pt\">u-1) La encargatoria de reo\npor cuasi delito de lesiones o cuasi delito de homicidio y la condena por la conducciÃ³n\nculpable o descuidada, cuando a consecuencias de ello se hayan ocasionado la\nmuerte o lesiones de personas o daÃ±os de vehÃ­culos a otros bienes, <o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"text-align:justify\"><span lang=\"ES-CL\" style=\"font-size:11.0pt;mso-bidi-font-size:10.0pt\">2) Cuando el chofer hubiere\nsido sancionado mÃ¡s de tres veces por infracciones graves y cuatro o mÃ¡s veces\npor infracciones menos graves o leves, segÃºn la calificaciÃ³n vigente de la\nOrdenanza General del TrÃ¡nsito, en un lapso de tres meses.<o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"text-align:justify\"><span lang=\"ES-CL\" style=\"font-size:11.0pt;mso-bidi-font-size:10.0pt\">DECIMO CUARTO: El chofer se\nresponsabiliza de las notificaciones por infracciones de trÃ¡nsito cursadas por\nCarabineros o Inspectores Municipales y aquellas que se hagan al\nempadronamiento del vehÃ­culo.<o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"text-align:justify\"><span lang=\"ES-CL\" style=\"font-size:11.0pt;mso-bidi-font-size:10.0pt\">Para estos efectos el Empleador\npodrÃ¡ descontar o deducir de las remuneraciones mensuales del Chofer, un\nporcentaje no superior al 10% de Ã©stas, hasta enterar el total de las sumas que\nÃ©ste hubiera debido pagar. Por este instrumento el Chofer acepta el compromiso\nde devolver las sumas pagadas por el Empleador en forma prevista en esta\nclÃ¡usula y autoriza las deducciones correspondientes, respetÃ¡ndose, en todo\ncaso, el tope de los descuentos permitidos por la ley.<o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"text-align:justify\"><span lang=\"ES-CL\" style=\"font-size:11.0pt;mso-bidi-font-size:10.0pt\">DECIMO QUINTO: En caso de\nextravÃ­o de boletos sin vender, por cualquiera causa, el chofer estÃ¡ obligado a\ncancelÃ¡rselos al mismo precio de venta al pÃºblico, en caso de extravÃ­o de uno o\nmÃ¡s boletos sin vender, el chofer debe proceder a su devoluciÃ³n en dinero\ndentro del plazo de los 10 dÃ­as siguientes a su extravÃ­o. En caso contrario se\ntendrÃ¡ tal circunstancia como falta gravÃ­sima a las obligaciones que impone\neste contrato.<o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"text-align:justify\"><span lang=\"ES-CL\" style=\"font-size:11.0pt;mso-bidi-font-size:10.0pt\">DECIMO SEXTO: Se deja\nconstancia que don&nbsp;</span>{NOMBRE_TRABAJADOR}&nbsp;{APELLIDO_1}&nbsp;{APELLIDO_2}<span lang=\"ES-CL\" style=\"font-size:11.0pt;mso-bidi-font-size:10.0pt\"><b>, ingresÃ³ al servicio del empleador con fecha </b></span><b>{INICIO_CONTRATO}</b><span lang=\"ES-CL\" style=\"font-size:11.0pt;mso-bidi-font-size:10.0pt\">,\ndeclarando haber recibido en este acto, un ejemplar del presente contrato que\nse extiende y firma en dos ejemplares.<o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"text-align:justify\"><span lang=\"ES-CL\" style=\"font-size:11.0pt;mso-bidi-font-size:10.0pt\">DECIMO SEPTIMO: Las partes\ndeclaran que aceptan tener como parte integrante de este contrato los\nreglamentos internos de la AsociaciÃ³n y las circulares sobre sistemas de\ntrabajo que emita el Directorio.<o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"text-align:justify\"><span lang=\"ES-CL\" style=\"font-size:11.0pt;mso-bidi-font-size:10.0pt\">DECIMO OCTAVO<b>: El presente contrato regirÃ¡ de forma </b></span>{TIPO_CONTRATO}<span lang=\"ES-CL\" style=\"font-size:11.0pt;mso-bidi-font-size:10.0pt\"><b>,</b> pero cualquiera de las partes, o ambas, segÃºn el caso, podrÃ¡n\nponerle tÃ©rmino en cualquier momento con arreglo a la ley. <o:p></o:p></span></p>\n\n<p class=\"MsoNormal\" style=\"text-align:justify\"><span lang=\"ES-CL\" style=\"font-size:11.0pt;mso-bidi-font-size:10.0pt\">&nbsp;</span></p>\n\n<p class=\"MsoNormal\" style=\"text-align:justify\"><span lang=\"ES-CL\" style=\"font-size:11.0pt;mso-bidi-font-size:10.0pt\">&nbsp;</span></p>\n\n<p class=\"MsoNormal\" style=\"text-align:justify\"><span lang=\"ES-CL\" style=\"font-size:11.0pt;mso-bidi-font-size:10.0pt\">&nbsp;</span></p>\n\n<p class=\"MsoNormal\" style=\"text-align:justify\"><span lang=\"ES-CL\" style=\"font-size:11.0pt;mso-bidi-font-size:10.0pt\">&nbsp;</span></p>\n\n<p class=\"MsoNormal\" style=\"text-align:justify\"><span lang=\"ES-CL\" style=\"font-size:11.0pt;mso-bidi-font-size:10.0pt\">&nbsp;</span></p>\n\n<p class=\"MsoNormal\" style=\"text-align:justify\"><span lang=\"ES-CL\" style=\"font-size:11.0pt;mso-bidi-font-size:10.0pt\">&nbsp;</span></p>\n\n<p class=\"MsoNormal\" style=\"text-align:justify\"><span lang=\"ES-CL\" style=\"font-size:11.0pt;mso-bidi-font-size:10.0pt\">&nbsp;</span></p>\n\n<p class=\"MsoNormal\" style=\"text-align:justify\"><span lang=\"ES-CL\" style=\"font-size:11.0pt;mso-bidi-font-size:10.0pt\">&nbsp;</span></p>\n\n<table class=\"MsoNormalTable\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n <tbody><tr>\n  <td width=\"312\" style=\"width:234.0pt;padding:0cm 0cm 0cm 0cm\">\n  <p class=\"MsoNormal\" style=\"text-align:justify\"><span lang=\"ES-CL\" style=\"font-size:11.0pt;mso-bidi-font-size:10.0pt\">............................................<o:p></o:p></span></p>\n  <p class=\"MsoNormal\" style=\"text-align:justify\"><span lang=\"ES-CL\" style=\"font-size:11.0pt;mso-bidi-font-size:10.0pt\">FIRMA DEL EMPLEADOR<o:p></o:p></span></p>\n  <p class=\"MsoNormal\" style=\"text-align:justify\"><span lang=\"ES-CL\" style=\"font-size:11.0pt;mso-bidi-font-size:10.0pt\">RUT\n  ............................................<o:p></o:p></span></p>\n  </td>\n  <td width=\"312\" style=\"width:234.0pt;padding:0cm 0cm 0cm 0cm\">\n  <p class=\"MsoNormal\" style=\"text-align:justify\"><span lang=\"ES-CL\" style=\"font-size:11.0pt;mso-bidi-font-size:10.0pt\">............................................\n  <o:p></o:p></span></p>\n  <p class=\"MsoNormal\" style=\"text-align:justify\"><span lang=\"ES-CL\" style=\"font-size:11.0pt;mso-bidi-font-size:10.0pt\">FIRMA DEL CHOFER<o:p></o:p></span></p>\n  <p class=\"MsoNormal\" style=\"text-align:justify\"><span lang=\"ES-CL\" style=\"font-size:11.0pt;mso-bidi-font-size:10.0pt\">RUT ............................................\n  <o:p></o:p></span></p>\n  </td>\n </tr>\n</tbody></table>\n\n<p class=\"MsoNormal\" style=\"text-align:justify\"><span lang=\"ES-CL\">&nbsp;</span></p>', '2023-05-17 21:52:44'),
(12, 9, '<div style=\"text-align: left;\"><div style=\"text-align: left;\"><h3 style=\"text-align: left;\"><div style=\"text-align: right; font-size: 14px; font-weight: 400;\">Fecha: {FECHA_COMPROBANTE}</div><div style=\"text-align: right; font-size: 14px; font-weight: 400;\">Comprobante NÂ°: {NUMERO_COMPROBANTE}</div></h3><h3 style=\"text-align: center;\">COMPROBANTE DE FERIADOS</h3></div><div style=\"text-align: left;\"><b><br></b></div><div style=\"text-align: left;\"><b>Empleador</b>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</div><div style=\"text-align: left;\"><span style=\"font-size: 0.875rem;\">{REPRESENTANTE_LEGAL}&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</span></div></div><div><div>RUT: {RUT_REPRESENTANTE_LEGAL}</div><div>DIRECCION: {CALLE_EMPRESA} {NUMERO_EMPRESA}, {COMUNA_EMPRESA}, {REGION_EMPRESA}</div><div><br></div></div><div><b>Trabajador&nbsp;</b></div><div>ï»¿NOMBRE: {NOMBRE_TRABAJADOR} {APELLIDO_1} {APELLIDO_2}.</div><div>RUT: {RUT_TRABAJADOR}</div><div><br></div><div><br></div><div>De acuerdo con lo establecido en el CÃ³digo del Trabajo, se deja constancia que el trabajador harÃ¡ uso de su feriado legal los dÃ­as que se indican:</div><div><br></div><div>Inicio periodo vacaciones: <b>{FECHA_INICIO_VACACIONES}</b></div><div>Fin periodo vacaciones: <b>{FECHA_TERMINO_VACACIONES}</b></div><div><br></div><div>Total dÃ­a(s) hÃ¡biles tomados: <b>{DIAS_VACACIONES}&nbsp;</b></div><div><br></div><div>Al tÃ©rmino del uso de estos dÃ­as el trabajador tendrÃ¡ un total de <b>{TOTAL_DIAS_VACACIONES}</b> dÃ­as hÃ¡biles a favor.</div><div><br></div><div><div>La composiciÃ³n del feriado legal por periodo es la siguiente:&nbsp;</div><div><br></div><div>{INICIO_PERIODO_VACACIONES} a {TERMINO_PERIODO_VACACIONES}:&nbsp;&nbsp;</div></div><div><br></div><div><span style=\"font-size: 0.875rem;\"><br></span></div><div><br></div><div><br></div><div><br></div><div><br></div><div><br></div><div><br></div><div>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</div><div>Firma Empleador&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Firma Trabajador</div>', '2023-05-24 20:41:20');
INSERT INTO `plantillas` (`id`, `tipodocumento`, `contenido`, `register_at`) VALUES
(13, 10, '<h5><span style=\"font-size: 0.875rem; font-family: Arial;\">Fecha:</span>{FECHA_COMPROBANTE}<span style=\"font-size: 0.875rem; font-family: Arial;\"><br></span><span style=\"font-size: 0.875rem; font-family: Arial;\">Comprobante NÂ°:</span>{NUMERO_COMPROBANTE}</h5><h6 style=\"text-align: right;\"><span style=\"font-size: 0.875rem; font-family: Arial;\"><span style=\"font-weight: normal;\"><br></span></span></h6><h5>{REPRESENTANTE_LEGAL}<span style=\"font-size: 0.875rem;\"><span style=\"font-family: Poppins;\"><br></span></span><span style=\"font-family: Arial; font-size: 1.09375rem; font-weight: normal;\">RUT:&nbsp;</span>{RUT_REPRESENTANTE_LEGAL}</h5><h6></h6><h5><span style=\"font-weight: normal;\"><span style=\"font-family: Arial;\"><span style=\"font-family: Poppins;\"><span style=\"font-family: Arial;\">DIRECCIO</span><span style=\"font-family: Arial;\">N:</span></span></span></span>{CALLE_EMPRESA}<span style=\"font-weight: normal;\"><span style=\"font-family: Arial;\"><span style=\"font-family: Poppins;\">&nbsp;</span></span></span>{NUMERO_EMPRESA}&nbsp;{COMUNA_EMPRESA}&nbsp;{REGION_EMPRESA}<span style=\"font-weight: normal;\"><span style=\"font-family: Arial;\"><span style=\"font-family: Poppins;\">&nbsp;.</span></span></span></h5><p></p><p></p><p><span style=\"font-size: 0.875rem;\"><br></span></p><p><span style=\"font-size: 0.875rem;\"><br></span></p><h5 style=\"text-align: center;\"><span style=\"font-family: Arial;\">COMPROBANTE DE VACACIONES</span></h5><h5><span style=\"font-family: Arial;\">NOMBRE:&nbsp;</span>{NOMBRE_TRABAJADOR}<span style=\"font-family: Arial;\">&nbsp;</span>{APELLIDO_1}&nbsp;{APELLIDO_2}.<span style=\"font-family: Arial;\"><br></span><span style=\"font-family: Arial;\">RUT:&nbsp;</span>{RUT_TRABAJADOR}</h5><h4><span style=\"font-family: Arial;\">De acuerdo con lo establecido en el CÃ³digo del Trabajo, se deja constancia que el trabajador harÃ¡ uso de su feriado legal los dÃ­as que se indican:</span></h4><h5><span style=\"font-family: Arial;\"></span></h5><h5><span style=\"font-family: Arial;\">Inicio:&nbsp;</span>{FECHA_INICIO_VACACIONES}<span style=\"font-family: Arial;\"><br></span><span style=\"font-family: Arial;\">Fin:&nbsp;</span>{FECHA_TERMINO_VACACIONES}<span style=\"font-family: Arial;\"><br></span><span style=\"font-family: Arial;\">Total:&nbsp;</span>{DIAS_VACACIONES}<span style=\"font-family: Arial;\">&nbsp;dÃ­a(s) hÃ¡biles.</span></h5><h5><span style=\"font-size: 0.875rem;\"><br></span></h5><h5><span style=\"font-family: Arial;\">La composiciÃ³n del feriado legal por periodo es la siguiente:&nbsp;</span>{PERIODO_VACACIONES}</h5><span style=\"font-family: Poppins;\"></span><h5><br></h5><h5><span style=\"font-family: Arial;\">:dÃ­a(s) hÃ¡biles.</span></h5><h5><span style=\"font-family: Arial;\"><br></span></h5><blockquote class=\"blockquote\"><h5><span style=\"font-size: 0.875rem; font-family: Arial;\">Al tÃ©rmino del uso de estos dÃ­as el trabajador tendrÃ¡ un total de&nbsp;</span><span style=\"font-size: 0.875rem; font-family: Arial;\">&nbsp;dÃ­as hÃ¡biles a favor.</span></h5></blockquote><p><br></p><p><br></p><p><br></p><p><br></p><h6 style=\"text-align: center;\">Firma Empleador&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Firma Trabajador</h6><p><br></p><p><br></p>', '2023-06-12 21:56:14');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `previsiontrabajador`
--

CREATE TABLE `previsiontrabajador` (
  `id` int(11) NOT NULL,
  `trabajador` int(11) NOT NULL,
  `periodo` date NOT NULL,
  `afp` int(11) NOT NULL,
  `jubilado` int(11) NOT NULL,
  `cesantia` int(11) NOT NULL,
  `accidente` int(11) NOT NULL,
  `fechacesantiainicio` date NOT NULL,
  `isapre` int(11) NOT NULL,
  `planpactado` int(11) NOT NULL,
  `valorplanpactado` decimal(10,2) NOT NULL,
  `ges` int(11) NOT NULL,
  `valorges` decimal(10,2) NOT NULL,
  `comentario` varchar(200) DEFAULT NULL,
  `documentoafp` varchar(200) DEFAULT NULL,
  `documentosalud` varchar(200) DEFAULT NULL,
  `documentojubilacion` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `previsiontrabajador`
--

INSERT INTO `previsiontrabajador` (`id`, `trabajador`, `periodo`, `afp`, `jubilado`, `cesantia`, `accidente`, `fechacesantiainicio`, `isapre`, `planpactado`, `valorplanpactado`, `ges`, `valorges`, `comentario`, `documentoafp`, `documentosalud`, `documentojubilacion`) VALUES
(1, 7, '2023-01-01', 8, 2, 1, 1, '2023-01-01', 11, 3, 0.00, 3, 0.00, '', 'AFP_DOCUMENT_24161220.pdf', 'SALUD_DOCUMENT_24161220.pdf', ''),
(2, 6, '2023-01-01', 8, 2, 1, 1, '2023-01-01', 11, 3, 0.00, 3, 0.00, '', 'AFP_DOCUMENT_24161301.pdf', 'SALUD_DOCUMENT_24161301.pdf', ''),
(5, 5, '2023-02-01', 8, 2, 1, 1, '2023-02-01', 11, 3, 0.00, 3, 0.00, '', '', '', ''),
(6, 4, '2023-02-01', 10, 2, 1, 1, '2013-01-01', 11, 3, 0.00, 3, 0.00, '', '', '', ''),
(8, 1, '2023-02-01', 8, 2, 1, 1, '2023-01-01', 6, 2, 1.50, 2, 1.20, '', '', '', ''),
(9, 2, '2023-02-01', 12, 2, 1, 1, '2023-02-01', 9, 2, 1.50, 2, 2.90, '', '', '', ''),
(10, 3, '2023-02-01', 12, 2, 1, 1, '2023-02-01', 11, 3, 0.00, 3, 0.00, '', '', '', ''),
(11, 8, '2023-02-01', 8, 2, 1, 1, '2002-01-01', 11, 3, 0.00, 3, 0.00, '', '', '', ''),
(12, 9, '2023-05-01', 9, 2, 1, 1, '2022-05-01', 11, 3, 0.00, 3, 0.00, '', '', '', ''),
(13, 10, '2019-08-01', 10, 2, 1, 1, '2019-08-01', 11, 3, 0.00, 3, 0.00, '', '', '', ''),
(14, 11, '2019-07-01', 11, 2, 1, 1, '2019-07-01', 11, 3, 0.00, 3, 0.00, '', '', '', ''),
(15, 12, '2021-03-01', 10, 2, 1, 1, '2021-03-01', 11, 3, 0.00, 3, 0.00, '', '', '', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `provincias`
--

CREATE TABLE `provincias` (
  `id` int(11) NOT NULL,
  `codigo` varchar(20) NOT NULL,
  `codigoprevired` varchar(20) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `region` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `provincias`
--

INSERT INTO `provincias` (`id`, `codigo`, `codigoprevired`, `nombre`, `region`) VALUES
(1, '89', '89', 'CACHAPOAL', 3),
(2, '15', '98', 'CACHAPOAL 132', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `regiones`
--

CREATE TABLE `regiones` (
  `id` int(11) NOT NULL,
  `codigo` varchar(20) NOT NULL,
  `codigoprevired` varchar(20) NOT NULL,
  `nombre` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `regiones`
--

INSERT INTO `regiones` (`id`, `codigo`, `codigoprevired`, `nombre`) VALUES
(1, '15', '5111', 'BIO BIO'),
(2, '16', '188', 'METROPOLITANA santiago'),
(3, '45', '65', 'LIBERTADOR BERNARDO OHIGGINS');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `representantelegal`
--

CREATE TABLE `representantelegal` (
  `id` int(11) NOT NULL,
  `rut` varchar(20) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `primerapellido` varchar(200) NOT NULL,
  `segundoapellido` varchar(200) NOT NULL,
  `empresa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `representantelegal`
--

INSERT INTO `representantelegal` (`id`, `rut`, `nombre`, `primerapellido`, `segundoapellido`, `empresa`) VALUES
(5, '18.039.655-1', 'MARCOS ', 'DIAZ', 'GONZALEZ', 1),
(6, '15.524.906-4', 'CARLOS FELIPE', 'DIAZ', ' GONZALEZ', 2),
(7, '11.366.273-5', 'PAULO BENITO ', 'BERRIOS ', 'DONAIRE', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resumencomuna`
--

CREATE TABLE `resumencomuna` (
  `id` int(11) NOT NULL,
  `comuna` int(11) NOT NULL,
  `usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `resumencomuna`
--

INSERT INTO `resumencomuna` (`id`, `comuna`, `usuario`) VALUES
(1, 1, 4),
(2, 2, 4),
(3, 3, 4),
(4, 3, 2),
(5, 3, 6),
(6, 2, 2),
(7, 2, 1),
(8, 4, 8);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resumenfiniquito`
--

CREATE TABLE `resumenfiniquito` (
  `id` int(11) NOT NULL,
  `indemnizacion` int(11) NOT NULL,
  `tipoindemnizacion` int(11) NOT NULL,
  `descripcion` varchar(500) NOT NULL,
  `monto` decimal(10,2) NOT NULL,
  `usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `resumenfiniquito`
--

INSERT INTO `resumenfiniquito` (`id`, `indemnizacion`, `tipoindemnizacion`, `descripcion`, `monto`, `usuario`) VALUES
(2, 5, 2, 'vacaciones', 1000.00, 8),
(3, 2, 2, 'Bonificacion', 200000.00, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resumenprovincia`
--

CREATE TABLE `resumenprovincia` (
  `id` int(11) NOT NULL,
  `provincia` int(11) NOT NULL,
  `usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `resumenprovincia`
--

INSERT INTO `resumenprovincia` (`id`, `provincia`, `usuario`) VALUES
(1, 1, 4),
(2, 2, 4),
(3, 1, 2),
(4, 1, 6),
(5, 2, 2),
(6, 1, 1),
(7, 1, 8);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resumenregion`
--

CREATE TABLE `resumenregion` (
  `id` int(11) NOT NULL,
  `region` int(11) NOT NULL,
  `usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `resumenregion`
--

INSERT INTO `resumenregion` (`id`, `region`, `usuario`) VALUES
(1, 1, 4),
(2, 2, 4),
(3, 3, 4),
(4, 3, 2),
(5, 3, 6),
(6, 1, 2),
(7, 3, 1),
(8, 3, 8);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sesionusuario`
--

CREATE TABLE `sesionusuario` (
  `id` int(11) NOT NULL,
  `id_usu` int(11) NOT NULL,
  `token` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `sesionusuario`
--

INSERT INTO `sesionusuario` (`id`, `id_usu`, `token`, `created_at`, `updated_at`) VALUES
(3, 6, 'eaf3a8707d38faf42630e102d1d0ad1f', '2023-01-26 17:36:58', '2023-01-26 17:36:58'),
(9, 7, '5260e74fd3eeb70cf357011993abe706', '2023-01-29 20:28:29', '2023-01-29 20:28:29'),
(48, 1, 'fc2953581b5e4efc0ba2a859ef264f7d', '2023-02-22 17:45:32', '2023-02-22 17:45:32'),
(86, 4, '09f499d5f4914f5704c48fdb6ba452be', '2023-06-16 14:40:48', '2023-06-16 14:40:48'),
(87, 8, '76571ead38bdcb5f3c0441f2bcb07014', '2023-06-16 15:31:17', '2023-06-16 15:31:17'),
(89, 2, 'a0031b4487861a3bec28bdb02f4e8d4e', '2023-06-19 15:05:41', '2023-06-19 15:05:41');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sexo`
--

CREATE TABLE `sexo` (
  `id` int(11) NOT NULL,
  `nombre` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `sexo`
--

INSERT INTO `sexo` (`id`, `nombre`) VALUES
(1, 'Masculino'),
(2, 'Femenino');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `status`
--

CREATE TABLE `status` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `status`
--

INSERT INTO `status` (`id`, `nombre`) VALUES
(1, 'Activo'),
(2, 'Inactivo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subcentrocosto`
--

CREATE TABLE `subcentrocosto` (
  `id` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `centrocosto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tasaafp`
--

CREATE TABLE `tasaafp` (
  `id` int(11) NOT NULL,
  `afp` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `tasa` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tasaafp`
--

INSERT INTO `tasaafp` (`id`, `afp`, `fecha`, `tasa`) VALUES
(1, 3, '2022-10-31', 10.87),
(2, 3, '2022-09-01', 11.87),
(3, 3, '2021-01-01', 10.00),
(4, 3, '2021-03-01', 10.56),
(5, 3, '2021-12-01', 10.56),
(6, 4, '2022-09-01', 11.65),
(7, 5, '2022-06-01', 12.45),
(8, 5, '2022-01-01', 12.45),
(9, 5, '2022-12-01', 12.45);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tasacaja`
--

CREATE TABLE `tasacaja` (
  `id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `tasa` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tasacaja`
--

INSERT INTO `tasacaja` (`id`, `fecha`, `tasa`) VALUES
(1, '2022-10-01', 0.45),
(2, '2022-11-01', 0.45);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tasamutual`
--

CREATE TABLE `tasamutual` (
  `id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `tasabasica` decimal(10,2) NOT NULL,
  `tasaleysanna` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tasamutual`
--

INSERT INTO `tasamutual` (`id`, `fecha`, `tasabasica`, `tasaleysanna`) VALUES
(1, '2022-10-01', 0.90, 0.30),
(2, '2022-11-01', 0.90, 0.30);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipoanotacion`
--

CREATE TABLE `tipoanotacion` (
  `id` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tipoanotacion`
--

INSERT INTO `tipoanotacion` (`id`, `nombre`) VALUES
(1, 'Observación'),
(2, 'Anotación Positiva'),
(3, 'Anotación Negativa');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipocausante`
--

CREATE TABLE `tipocausante` (
  `id` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tipocausante`
--

INSERT INTO `tipocausante` (`id`, `nombre`) VALUES
(1, 'La o El Conyuge'),
(2, 'HIJO E HIJASTRO CON EDAD MENOS O IGUAL A 18 AÑOS'),
(3, 'HIJO E HIJASTRO CON EDAD ENTRE 18 Y 24 AÑOS Y QUE ESTUDIA'),
(4, 'CARGA MATERNAL');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipocontrato`
--

CREATE TABLE `tipocontrato` (
  `id` int(11) NOT NULL,
  `codigo` varchar(20) NOT NULL,
  `codigoprevired` varchar(20) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tipocontrato`
--

INSERT INTO `tipocontrato` (`id`, `codigo`, `codigoprevired`, `nombre`) VALUES
(1, '89', '05', 'INDEFINIDO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipocuenta`
--

CREATE TABLE `tipocuenta` (
  `id` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tipocuenta`
--

INSERT INTO `tipocuenta` (`id`, `nombre`) VALUES
(1, 'Cuenta Corriente'),
(2, 'Cuenta Vista'),
(3, 'Cuenta RUT'),
(4, 'Cuenta Ahorro'),
(5, 'Cuenta de Inversiones');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipodeindezacion`
--

CREATE TABLE `tipodeindezacion` (
  `id` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tipodeindezacion`
--

INSERT INTO `tipodeindezacion` (`id`, `nombre`) VALUES
(1, 'Descuento'),
(2, 'Suma');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipodocumento`
--

CREATE TABLE `tipodocumento` (
  `id` int(11) NOT NULL,
  `codigo` varchar(20) NOT NULL,
  `codigoprevired` varchar(20) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tipodocumento`
--

INSERT INTO `tipodocumento` (`id`, `codigo`, `codigoprevired`, `nombre`) VALUES
(1, '89', '89', 'CONTRATO POR FAENA'),
(2, '02', '02', 'CONTRATO INDEFINIDO'),
(3, '45', '45', 'RENDICOP SEMANA 11 DIC A 7 DIC '),
(4, '12', '12', 'COMPROBANTE DE VACACIONES'),
(5, '1.1', '1', 'CONTRATO POR OBRA O FAENA'),
(6, '1.2', '1.2', 'CONTRATO PRUEBA AGRICOLA FAENA'),
(7, '01', '01', 'FINIQUITO 1'),
(8, '02', '02', 'CONTRATO DE TRABAJO TRANSPORTE PUBLICO'),
(9, '7', '7', 'COMPROBANTE DE VACACIONES IUSTAX'),
(10, 'P1', 'P1', 'PRUEBA COMPROBANTE DE VACACIONES');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipodocumentosubido`
--

CREATE TABLE `tipodocumentosubido` (
  `id` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tipodocumentosubido`
--

INSERT INTO `tipodocumentosubido` (`id`, `nombre`) VALUES
(1, 'Contrato'),
(2, 'Certificado de trabajo'),
(3, 'Anexo de contrato'),
(4, 'Finiquito'),
(5, 'Carta de Renuncia'),
(6, 'Carta de despido'),
(7, 'Carta de Aviso'),
(8, 'Entrega de EPP');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipoisapre`
--

CREATE TABLE `tipoisapre` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tipoisapre`
--

INSERT INTO `tipoisapre` (`id`, `nombre`) VALUES
(1, 'Fonasa'),
(2, 'Isapre');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipolicencia`
--

CREATE TABLE `tipolicencia` (
  `id` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tipolicencia`
--

INSERT INTO `tipolicencia` (`id`, `nombre`) VALUES
(1, 'Orden de reposo'),
(2, 'Maternal (Pre y Post)'),
(3, 'Licencias Medicas');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipomoneda`
--

CREATE TABLE `tipomoneda` (
  `id` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tipomoneda`
--

INSERT INTO `tipomoneda` (`id`, `nombre`) VALUES
(1, 'Pesos'),
(2, 'UF'),
(3, 'Porcentaje');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tiposueldo`
--

CREATE TABLE `tiposueldo` (
  `id` int(11) NOT NULL,
  `codigo` varchar(20) NOT NULL,
  `codigoprevired` varchar(20) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tiposueldobase`
--

CREATE TABLE `tiposueldobase` (
  `id` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tiposueldobase`
--

INSERT INTO `tiposueldobase` (`id`, `nombre`) VALUES
(1, 'Por Hora'),
(2, 'Mensual'),
(3, 'Semanal'),
(4, 'Diario');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trabajadorcargo`
--

CREATE TABLE `trabajadorcargo` (
  `id` int(11) NOT NULL,
  `trabajador` int(11) NOT NULL,
  `centrocosto` int(11) NOT NULL,
  `cargo` int(11) NOT NULL,
  `descripcion` varchar(200) DEFAULT NULL,
  `tipocontrato` int(11) NOT NULL,
  `desde` date NOT NULL,
  `hasta` date DEFAULT NULL,
  `jornada` int(11) NOT NULL,
  `horaspactadas` int(11) NOT NULL,
  `register_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trabajadorcontacto`
--

CREATE TABLE `trabajadorcontacto` (
  `id` int(11) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `email` varchar(200) NOT NULL,
  `trabajador` int(11) NOT NULL,
  `register_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `trabajadorcontacto`
--

INSERT INTO `trabajadorcontacto` (`id`, `telefono`, `email`, `trabajador`, `register_at`) VALUES
(1, '961906783', 'NATY.PALACIOS@ICLOUD.COM', 1, '2023-02-06 12:53:56'),
(2, '961906783', 'MARCOS.DIAZ@CONSULTORADG.CL', 2, '2023-02-06 12:55:56'),
(3, '961906783', 'CECILIA@GMAIL.COM', 3, '2023-02-06 12:59:22'),
(4, '95477705', 'FELIPE.DIAZ@CONSULTORADG.CL', 4, '2023-02-06 13:01:43'),
(5, '961906783', 'GM@IUSTAX.CL', 5, '2023-02-06 13:03:33'),
(6, '961906783', 'CG@IUSTAX.CL', 6, '2023-02-06 13:06:36'),
(7, '961906783', 'NATY.PALACIOS@ICLOUD.COM', 7, '2023-02-22 16:42:00'),
(8, '961906783', 'MARCOS.DIAZ@CONSULTORADG.CL', 8, '2023-02-22 17:55:28'),
(9, '985781214', 'PATOMOENA68@GMAIL.COM', 9, '2023-05-17 20:58:57'),
(10, '962799470', 'PAULOTRANS@HOTMAIL.COM', 10, '2023-05-30 17:03:28'),
(11, '994313967', 'PAULOTRANS@HOTMAIL.COM', 11, '2023-06-08 21:15:28'),
(12, 'Â 990511364', 'PAULOTRANS@HOTMAIL.COM', 12, '2023-06-16 15:52:38');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trabajadordomicilio`
--

CREATE TABLE `trabajadordomicilio` (
  `id` int(11) NOT NULL,
  `calle` varchar(200) NOT NULL,
  `villa` varchar(200) DEFAULT NULL,
  `numero` varchar(20) NOT NULL,
  `depto` varchar(20) DEFAULT NULL,
  `region` int(11) NOT NULL,
  `comuna` int(11) NOT NULL,
  `ciudad` int(11) NOT NULL,
  `trabajador` int(11) NOT NULL,
  `register_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `trabajadordomicilio`
--

INSERT INTO `trabajadordomicilio` (`id`, `calle`, `villa`, `numero`, `depto`, `region`, `comuna`, `ciudad`, `trabajador`, `register_at`) VALUES
(1, 'PARCELA ', '', '22', '', 3, 3, 3, 1, '2023-02-06 12:53:56'),
(2, 'PARCELA ', '', '22', '', 3, 3, 3, 2, '2023-02-06 12:55:56'),
(3, 'PALLACHATA', 'nelson pereira', '2541', '', 3, 3, 3, 3, '2023-02-06 12:59:22'),
(4, 'PALLACHATA', 'nelson pereira', '2541', '', 3, 3, 3, 4, '2023-02-06 13:01:43'),
(5, 'AVENIDA EL ABRA ', 'el esfuerzo', '82-A', '', 3, 3, 3, 5, '2023-02-06 13:03:33'),
(6, 'INMACULADA CONCEPCIÃ³N', 'Villa MarÃ­a', '70', '', 3, 3, 3, 6, '2023-02-06 13:06:36'),
(7, 'PARCELA ', '', '22', '', 3, 3, 3, 7, '2023-02-22 16:42:00'),
(8, 'AVENIDA EL ABRA ESQUINA LECARO', '', 'S/N', '', 3, 3, 3, 8, '2023-02-22 17:55:28'),
(9, 'LOS NEVADOS ', 'ENTRE CERROS', '36', '', 3, 4, 4, 9, '2023-05-17 20:58:57'),
(10, 'LAS ORQUIDEAS', 'VILLA JARDIN', '1299', '', 3, 3, 3, 10, '2023-05-30 17:03:28'),
(11, 'ISLA NAVARINO ', 'LA TORRE DEL PAINE', '1490', '', 3, 4, 4, 11, '2023-06-08 21:15:28'),
(12, 'EL TRAPICHE', 'VILLA ALAMEDA', '0365', '', 3, 4, 1, 12, '2023-06-16 15:52:38');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trabajadores`
--

CREATE TABLE `trabajadores` (
  `id` int(11) NOT NULL,
  `rut` varchar(20) NOT NULL,
  `dni` varchar(20) DEFAULT NULL,
  `nombre` varchar(200) NOT NULL,
  `primerapellido` varchar(200) NOT NULL,
  `segundoapellido` varchar(200) DEFAULT NULL,
  `fechanacimiento` date NOT NULL,
  `sexo` int(11) NOT NULL,
  `estadocivil` int(11) NOT NULL,
  `nacionalidad` int(11) NOT NULL,
  `discapacidad` int(11) NOT NULL,
  `pension` int(11) NOT NULL,
  `empresa` int(11) NOT NULL,
  `register_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `trabajadores`
--

INSERT INTO `trabajadores` (`id`, `rut`, `dni`, `nombre`, `primerapellido`, `segundoapellido`, `fechanacimiento`, `sexo`, `estadocivil`, `nacionalidad`, `discapacidad`, `pension`, `empresa`, `register_at`) VALUES
(1, '17.504.848-0', '', 'NATALIA CATALINA', 'PALACIOS', 'RUZ', '1990-04-12', 2, 2, 4, 2, 2, 1, '2023-02-06 12:53:56'),
(2, '18.039.655-1', '', 'MARCOS', 'DIAZ', 'GONZALEZ', '1992-04-08', 1, 2, 4, 2, 2, 1, '2023-02-06 12:55:56'),
(3, '13.946.991-7', '', 'CECILIA CAROLINA', 'VALDES', 'MONTENEGRO', '1980-02-28', 2, 2, 4, 2, 2, 1, '2023-02-06 12:59:22'),
(4, '15.524.906-4', '', 'CARLOS FELIPE', 'DIAZ', 'GONZALEZ', '1983-05-22', 1, 2, 4, 2, 2, 1, '2023-02-06 13:01:43'),
(5, '26.360.296-k', '', 'GERALDO DE JESUSCRISTO', 'MOLINA', '', '1983-02-04', 1, 1, 4, 2, 2, 1, '2023-02-06 13:03:33'),
(6, '19.263.654-k', '', 'CAMILA FRANCISCA', 'GALVEZ', 'SEPULVEDA', '1996-08-10', 2, 1, 4, 2, 2, 1, '2023-02-06 13:06:36'),
(7, '7.711.868-3', '', 'JUAN CARLOS', 'DIAZ', 'ARENAS', '1957-02-22', 1, 2, 4, 2, 2, 1, '2023-02-22 16:42:00'),
(8, '7.711.868-3', '', 'JUAN CARLOS ', 'DIAZ', 'ARENAS', '1956-02-22', 1, 2, 4, 2, 2, 2, '2023-02-22 17:55:28'),
(9, '11.337.156-0', '', 'PATRICIO JACOB', 'MOENA', 'AGUAYO', '1968-08-29', 1, 1, 4, 2, 2, 3, '2023-05-17 20:58:57'),
(10, '8.054.994-6', '', 'RENE DANIEL', 'REYES', 'FUENZALIDA', '1957-10-08', 1, 1, 4, 2, 2, 3, '2023-05-30 17:03:28'),
(11, '12.515.380-1', '', 'DANIEL ANDRES', 'CANTILLANA', 'ESPINOSA', '1972-12-16', 1, 1, 4, 2, 2, 3, '2023-06-08 21:15:28'),
(12, '13.261.793-7', '', 'RODOLFO ANDRES ', 'VALLEJOS', 'REYES', '1977-07-26', 1, 1, 4, 2, 2, 3, '2023-06-16 15:52:38');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trabajadorremuneracion`
--

CREATE TABLE `trabajadorremuneracion` (
  `id` int(11) NOT NULL,
  `trabajador` int(11) NOT NULL,
  `tiposueldobase` int(11) NOT NULL,
  `sueldobase` decimal(10,2) NOT NULL,
  `zonaextrema` decimal(10,2) NOT NULL,
  `register_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tramosasignacionfamiliar`
--

CREATE TABLE `tramosasignacionfamiliar` (
  `id` int(11) NOT NULL,
  `codigo` varchar(20) NOT NULL,
  `codigoprevired` varchar(20) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tramosasignacionfamiliar`
--

INSERT INTO `tramosasignacionfamiliar` (`id`, `codigo`, `codigoprevired`, `nombre`) VALUES
(4, 'A', 'A', 'PRIMER TRAMO'),
(5, 'B', 'B', 'SEGUNDO TRAMO'),
(6, 'C', 'C', 'TERCER TRAMO'),
(7, 'D', 'D', 'SIN DERECHO'),
(8, 'Sin InformaciÃ³n', 'Sin InformaciÃ³n', 'SIN DERECHO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id_usu` int(11) NOT NULL,
  `rut` varchar(20) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `apellidos` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `direccion` varchar(200) NOT NULL,
  `region` int(11) NOT NULL,
  `comuna` int(11) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `password` varchar(64) NOT NULL,
  `estado` int(11) NOT NULL,
  `token` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id_usu`, `rut`, `nombre`, `apellidos`, `email`, `direccion`, `region`, `comuna`, `telefono`, `password`, `estado`, `token`, `created_at`, `updated_at`) VALUES
(1, '15.524.906-4', 'CARLOS FELIPE', 'DIAZ GONZALEZ', 'felipe.diaz@consultoradg.cl', 'AVENIDA EL ABRA 82-A 4564', 2, 1, '+56961906783', 'd9d5d4ac6abf1ca25bee6f86a5083ec8bcb94143', 1, '55e8af78b8aa94e5cb16260cbb660b691c405f92', '2022-10-31 12:00:19', '2022-11-01 15:21:16'),
(2, '18.039.655-1', 'MARCOS ', 'DIAZ GONZALEZ', 'md@iustax.cl', 'LOS BOLDOS PARCELA 22 LOTE 3', 2, 1, '+56961906783', 'f7ba4ce7fbce9b58cab1267e1149c621f45aac02', 1, 'c1c5306b9c6f65acd02867152fd3a1f6d2f8c161', '2022-10-31 16:16:58', '2022-10-31 16:16:58'),
(4, '25.484.361-K', 'WILKENS', 'MOMPOINT', 'mwforlife24@gmail.com', 'AV O\'HIGGINS 740', 3, 1, '945250440', 'b3f73bf17a0fb121a990dfcafc2e3e780d9ee5dc', 1, '0495b8d8ea1c1ee09199cfb3fcfeee621ad25a5e', '2023-01-20 16:33:48', '2023-01-20 16:39:03'),
(6, '19.263.654-K', 'CAMILA FRANCISCA', 'GALVEZ SEPULVEDA', 'cg@iustax.cl', 'CALLE INMACULADA CONCEPCION 70, POBLACIÃ“N VILLA AMRIA , RINCON DE ABRA', 3, 3, '+56 9 9881 0096', 'ed8b4ccf9c1876f233ff0dc5c5d2b76a2b3cae87', 1, 'cbf5228dad7295fc909d71aa8aea8ead8125ace5', '2023-01-20 16:47:01', '2023-05-17 19:53:55'),
(7, '26.250.185-K', 'GERALDO DE JESUSCRISTO', 'MOLINA', 'gm@iustax.cl', 'AVENIDA EL ABRA 82-A', 3, 3, '+56 9 6561 4014', 'ed8b4ccf9c1876f233ff0dc5c5d2b76a2b3cae87', 1, 'dcd96266819c70220f8b505423d2301342c72bde', '2023-01-20 16:49:44', '2023-05-17 19:54:09'),
(8, '19.540.765-7', 'JAVIERA PAZ', 'GONZALEZ GONZALEZ', 'jg@iustax.cl', 'LAS FUCCIAS 0675', 3, 3, '+56975651464', 'f69c578b320950597704f33e6d2a68f7c06b3f9b', 1, 'e5fd361125bfcd8ccc78539b23f9d1e5449565bf', '2023-05-17 19:57:39', '2023-05-17 19:57:39');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarioempresa`
--

CREATE TABLE `usuarioempresa` (
  `id` int(11) NOT NULL,
  `usuario` int(11) NOT NULL,
  `empresa` int(11) NOT NULL,
  `estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuarioempresa`
--

INSERT INTO `usuarioempresa` (`id`, `usuario`, `empresa`, `estado`) VALUES
(1, 1, 2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vacaciones`
--

CREATE TABLE `vacaciones` (
  `id` int(11) NOT NULL,
  `trabajador` int(11) NOT NULL,
  `periodo_inicio` date NOT NULL,
  `periodo_termino` date NOT NULL,
  `dias` int(11) NOT NULL,
  `diasprograsivas` int(11) NOT NULL,
  `tipodocumento` int(11) NOT NULL,
  `fechainicio` date NOT NULL,
  `fechatermino` date NOT NULL,
  `observacion` varchar(200) DEFAULT NULL,
  `comprobantetramitefirmado` varchar(200) DEFAULT NULL,
  `register_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `accidente`
--
ALTER TABLE `accidente`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `acreditacion`
--
ALTER TABLE `acreditacion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `afectoavacaciones`
--
ALTER TABLE `afectoavacaciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `afp`
--
ALTER TABLE `afp`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `anotacion`
--
ALTER TABLE `anotacion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `AuditoriaEventos`
--
ALTER TABLE `AuditoriaEventos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `banco`
--
ALTER TABLE `banco`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cajascompensacion`
--
ALTER TABLE `cajascompensacion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cargastrabajador`
--
ALTER TABLE `cargastrabajador`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cargos`
--
ALTER TABLE `cargos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `causalterminocontrato`
--
ALTER TABLE `causalterminocontrato`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `centrocosto`
--
ALTER TABLE `centrocosto`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cesantia`
--
ALTER TABLE `cesantia`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ciudades`
--
ALTER TABLE `ciudades`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `codigoactividad`
--
ALTER TABLE `codigoactividad`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `comunas`
--
ALTER TABLE `comunas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `comunicacion`
--
ALTER TABLE `comunicacion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `contratos`
--
ALTER TABLE `contratos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cuentabancaria`
--
ALTER TABLE `cuentabancaria`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `detallefiniquito`
--
ALTER TABLE `detallefiniquito`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `detallelotes`
--
ALTER TABLE `detallelotes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `diasferiado`
--
ALTER TABLE `diasferiado`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `discapacidad`
--
ALTER TABLE `discapacidad`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `documentos`
--
ALTER TABLE `documentos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `documentosubido`
--
ALTER TABLE `documentosubido`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `empresa`
--
ALTER TABLE `empresa`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `estadoafectoavacaciones`
--
ALTER TABLE `estadoafectoavacaciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `estadocivil`
--
ALTER TABLE `estadocivil`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `estadocontrato`
--
ALTER TABLE `estadocontrato`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `finiquito`
--
ALTER TABLE `finiquito`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `indemnizacion`
--
ALTER TABLE `indemnizacion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `isapre`
--
ALTER TABLE `isapre`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `jornadas`
--
ALTER TABLE `jornadas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `jubilado`
--
ALTER TABLE `jubilado`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `licenciamedica`
--
ALTER TABLE `licenciamedica`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `lote`
--
ALTER TABLE `lote`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `lote2`
--
ALTER TABLE `lote2`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `lote3`
--
ALTER TABLE `lote3`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `lotes`
--
ALTER TABLE `lotes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `mutuales`
--
ALTER TABLE `mutuales`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `nacionalidad`
--
ALTER TABLE `nacionalidad`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `nubcodigoactividad`
--
ALTER TABLE `nubcodigoactividad`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pagadoressubsidio`
--
ALTER TABLE `pagadoressubsidio`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `permisos`
--
ALTER TABLE `permisos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `permisosusuarios`
--
ALTER TABLE `permisosusuarios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `plantillas`
--
ALTER TABLE `plantillas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `previsiontrabajador`
--
ALTER TABLE `previsiontrabajador`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `provincias`
--
ALTER TABLE `provincias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `regiones`
--
ALTER TABLE `regiones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `representantelegal`
--
ALTER TABLE `representantelegal`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `resumencomuna`
--
ALTER TABLE `resumencomuna`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `resumenfiniquito`
--
ALTER TABLE `resumenfiniquito`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `resumenprovincia`
--
ALTER TABLE `resumenprovincia`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `resumenregion`
--
ALTER TABLE `resumenregion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `sesionusuario`
--
ALTER TABLE `sesionusuario`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `sexo`
--
ALTER TABLE `sexo`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `subcentrocosto`
--
ALTER TABLE `subcentrocosto`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tasaafp`
--
ALTER TABLE `tasaafp`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tasacaja`
--
ALTER TABLE `tasacaja`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tasamutual`
--
ALTER TABLE `tasamutual`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipoanotacion`
--
ALTER TABLE `tipoanotacion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipocausante`
--
ALTER TABLE `tipocausante`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipocontrato`
--
ALTER TABLE `tipocontrato`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipocuenta`
--
ALTER TABLE `tipocuenta`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipodeindezacion`
--
ALTER TABLE `tipodeindezacion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipodocumento`
--
ALTER TABLE `tipodocumento`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipodocumentosubido`
--
ALTER TABLE `tipodocumentosubido`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipoisapre`
--
ALTER TABLE `tipoisapre`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipolicencia`
--
ALTER TABLE `tipolicencia`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipomoneda`
--
ALTER TABLE `tipomoneda`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tiposueldo`
--
ALTER TABLE `tiposueldo`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tiposueldobase`
--
ALTER TABLE `tiposueldobase`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `trabajadorcargo`
--
ALTER TABLE `trabajadorcargo`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `trabajadorcontacto`
--
ALTER TABLE `trabajadorcontacto`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `trabajadordomicilio`
--
ALTER TABLE `trabajadordomicilio`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `trabajadores`
--
ALTER TABLE `trabajadores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `trabajadorremuneracion`
--
ALTER TABLE `trabajadorremuneracion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tramosasignacionfamiliar`
--
ALTER TABLE `tramosasignacionfamiliar`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_usu`);

--
-- Indices de la tabla `usuarioempresa`
--
ALTER TABLE `usuarioempresa`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `vacaciones`
--
ALTER TABLE `vacaciones`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `accidente`
--
ALTER TABLE `accidente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `acreditacion`
--
ALTER TABLE `acreditacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `afectoavacaciones`
--
ALTER TABLE `afectoavacaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `afp`
--
ALTER TABLE `afp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `anotacion`
--
ALTER TABLE `anotacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `AuditoriaEventos`
--
ALTER TABLE `AuditoriaEventos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=310;

--
-- AUTO_INCREMENT de la tabla `banco`
--
ALTER TABLE `banco`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `cajascompensacion`
--
ALTER TABLE `cajascompensacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `cargastrabajador`
--
ALTER TABLE `cargastrabajador`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cargos`
--
ALTER TABLE `cargos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `causalterminocontrato`
--
ALTER TABLE `causalterminocontrato`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `centrocosto`
--
ALTER TABLE `centrocosto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `cesantia`
--
ALTER TABLE `cesantia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `ciudades`
--
ALTER TABLE `ciudades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `codigoactividad`
--
ALTER TABLE `codigoactividad`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1045;

--
-- AUTO_INCREMENT de la tabla `comunas`
--
ALTER TABLE `comunas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `comunicacion`
--
ALTER TABLE `comunicacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `contratos`
--
ALTER TABLE `contratos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `cuentabancaria`
--
ALTER TABLE `cuentabancaria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `detallefiniquito`
--
ALTER TABLE `detallefiniquito`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `detallelotes`
--
ALTER TABLE `detallelotes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `diasferiado`
--
ALTER TABLE `diasferiado`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `discapacidad`
--
ALTER TABLE `discapacidad`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `documentos`
--
ALTER TABLE `documentos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `documentosubido`
--
ALTER TABLE `documentosubido`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `empresa`
--
ALTER TABLE `empresa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `estadoafectoavacaciones`
--
ALTER TABLE `estadoafectoavacaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `estadocivil`
--
ALTER TABLE `estadocivil`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `estadocontrato`
--
ALTER TABLE `estadocontrato`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `finiquito`
--
ALTER TABLE `finiquito`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `indemnizacion`
--
ALTER TABLE `indemnizacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `isapre`
--
ALTER TABLE `isapre`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `jornadas`
--
ALTER TABLE `jornadas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `jubilado`
--
ALTER TABLE `jubilado`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `licenciamedica`
--
ALTER TABLE `licenciamedica`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `lote`
--
ALTER TABLE `lote`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT de la tabla `lote2`
--
ALTER TABLE `lote2`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `lote3`
--
ALTER TABLE `lote3`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `lotes`
--
ALTER TABLE `lotes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `mutuales`
--
ALTER TABLE `mutuales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `nacionalidad`
--
ALTER TABLE `nacionalidad`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `nubcodigoactividad`
--
ALTER TABLE `nubcodigoactividad`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `pagadoressubsidio`
--
ALTER TABLE `pagadoressubsidio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `permisos`
--
ALTER TABLE `permisos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `permisosusuarios`
--
ALTER TABLE `permisosusuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT de la tabla `plantillas`
--
ALTER TABLE `plantillas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `previsiontrabajador`
--
ALTER TABLE `previsiontrabajador`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `provincias`
--
ALTER TABLE `provincias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `regiones`
--
ALTER TABLE `regiones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `representantelegal`
--
ALTER TABLE `representantelegal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `resumencomuna`
--
ALTER TABLE `resumencomuna`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `resumenfiniquito`
--
ALTER TABLE `resumenfiniquito`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `resumenprovincia`
--
ALTER TABLE `resumenprovincia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `resumenregion`
--
ALTER TABLE `resumenregion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `sesionusuario`
--
ALTER TABLE `sesionusuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT de la tabla `sexo`
--
ALTER TABLE `sexo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `status`
--
ALTER TABLE `status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `subcentrocosto`
--
ALTER TABLE `subcentrocosto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tasaafp`
--
ALTER TABLE `tasaafp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `tasacaja`
--
ALTER TABLE `tasacaja`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tasamutual`
--
ALTER TABLE `tasamutual`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tipoanotacion`
--
ALTER TABLE `tipoanotacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tipocausante`
--
ALTER TABLE `tipocausante`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tipocontrato`
--
ALTER TABLE `tipocontrato`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tipocuenta`
--
ALTER TABLE `tipocuenta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `tipodeindezacion`
--
ALTER TABLE `tipodeindezacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tipodocumento`
--
ALTER TABLE `tipodocumento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `tipodocumentosubido`
--
ALTER TABLE `tipodocumentosubido`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `tipoisapre`
--
ALTER TABLE `tipoisapre`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tipolicencia`
--
ALTER TABLE `tipolicencia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tipomoneda`
--
ALTER TABLE `tipomoneda`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tiposueldo`
--
ALTER TABLE `tiposueldo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tiposueldobase`
--
ALTER TABLE `tiposueldobase`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `trabajadorcargo`
--
ALTER TABLE `trabajadorcargo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `trabajadorcontacto`
--
ALTER TABLE `trabajadorcontacto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `trabajadordomicilio`
--
ALTER TABLE `trabajadordomicilio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `trabajadores`
--
ALTER TABLE `trabajadores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `trabajadorremuneracion`
--
ALTER TABLE `trabajadorremuneracion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tramosasignacionfamiliar`
--
ALTER TABLE `tramosasignacionfamiliar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id_usu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `usuarioempresa`
--
ALTER TABLE `usuarioempresa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `vacaciones`
--
ALTER TABLE `vacaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
