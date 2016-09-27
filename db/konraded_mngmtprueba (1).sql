-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-09-2016 a las 03:22:18
-- Versión del servidor: 5.6.26
-- Versión de PHP: 5.6.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `konraded_mngmtprueba`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jsoria_alumno`
--

CREATE TABLE IF NOT EXISTS `jsoria_alumno` (
  `nro_documento` varchar(30) NOT NULL,
  `tipo_documento` varchar(50) NOT NULL DEFAULT 'DNI',
  `nombres` varchar(30) NOT NULL,
  `apellidos` varchar(50) NOT NULL,
  `estado` char(1) NOT NULL DEFAULT '0' COMMENT '0: No Matriculado, 1: Matriculado.',
  `id_grado` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `jsoria_alumno`
--

INSERT INTO `jsoria_alumno` (`nro_documento`, `tipo_documento`, `nombres`, `apellidos`, `estado`, `id_grado`) VALUES
('11111111', 'DNI', 'Jose', 'Mendoza', '1', 12),
('22222222', 'DNI', 'Marco', 'Polo', '1', 61);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jsoria_autorizacion`
--

CREATE TABLE IF NOT EXISTS `jsoria_autorizacion` (
  `id` int(11) NOT NULL,
  `rd` varchar(20) NOT NULL COMMENT 'Resolución Directoral',
  `estado` char(1) DEFAULT '0' COMMENT '0: Sin procesar, 1: Procesada.',
  `id_alumno` varchar(30) NOT NULL,
  `fecha_limite` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jsoria_balance`
--

CREATE TABLE IF NOT EXISTS `jsoria_balance` (
  `id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `id_tesorera` int(11) NOT NULL,
  `ingresos` decimal(8,2) NOT NULL DEFAULT '0.00',
  `egresos` decimal(8,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jsoria_categoria`
--

CREATE TABLE IF NOT EXISTS `jsoria_categoria` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `monto` decimal(8,2) DEFAULT NULL,
  `tipo` varchar(30) NOT NULL COMMENT 'Valores: {actividad, matricula, pension, cobro_ordinario, cobro_extraordinario, cobro_multiple}',
  `estado` char(1) DEFAULT NULL COMMENT '0: Habilitada, 1: Inhabilitada.',
  `fecha_inicio` date DEFAULT NULL,
  `fecha_fin` date DEFAULT NULL,
  `destino` char(1) DEFAULT '0' COMMENT '0: Interno, 1: Externo.',
  `id_detalle_institucion` int(11) NOT NULL,
  `id_matricula` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `jsoria_categoria`
--

INSERT INTO `jsoria_categoria` (`id`, `nombre`, `monto`, `tipo`, `estado`, `fecha_inicio`, `fecha_fin`, `destino`, `id_detalle_institucion`, `id_matricula`) VALUES
(1, 'Cobro Extraordinario', NULL, 'cobro_extraordinario', '1', NULL, NULL, '0', 18, NULL),
(2, 'Cobro Extraordinario', NULL, 'cobro_extraordinario', '1', NULL, NULL, '0', 19, NULL),
(3, 'Cobro Extraordinario', NULL, 'cobro_extraordinario', '1', NULL, NULL, '0', 20, NULL),
(4, 'Cobro Extraordinario', NULL, 'cobro_extraordinario', '1', NULL, NULL, '0', 21, NULL),
(5, 'Cobro Extraordinario', NULL, 'cobro_extraordinario', '1', NULL, NULL, '1', 18, NULL),
(6, 'Cobro Extraordinario', NULL, 'cobro_extraordinario', '1', NULL, NULL, '1', 19, NULL),
(7, 'Cobro Extraordinario', NULL, 'cobro_extraordinario', '1', NULL, NULL, '1', 20, NULL),
(8, 'Cobro Extraordinario', NULL, 'cobro_extraordinario', '1', NULL, NULL, '1', 21, NULL),
(9, 'Matricula 2016', '100.00', 'matricula', '1', '2016-09-01', '2016-12-31', '0', 1, NULL),
(10, 'Pensión Septiembre 2016', '100.00', 'pension', '1', '2016-09-01', '2016-09-30', '0', 1, 9),
(11, 'Pensión Octubre 2016', '100.00', 'pension', '1', '2016-10-01', '2016-10-31', '0', 1, 9),
(12, 'Pensión Noviembre 2016', '100.00', 'pension', '1', '2016-11-01', '2016-11-30', '0', 1, 9),
(13, 'Pensión Diciembre 2016', '100.00', 'pension', '1', '2016-12-01', '2016-12-31', '0', 1, 9),
(14, 'Matricula 2016', '100.00', 'matricula', '1', '2016-09-01', '2016-12-31', '0', 2, NULL),
(15, 'Pensión Septiembre 2016', '100.00', 'pension', '1', '2016-09-01', '2016-09-30', '0', 2, 14),
(16, 'Pensión Octubre 2016', '100.00', 'pension', '1', '2016-10-01', '2016-10-31', '0', 2, 14),
(17, 'Pensión Noviembre 2016', '100.00', 'pension', '1', '2016-11-01', '2016-11-30', '0', 2, 14),
(18, 'Pensión Diciembre 2016', '100.00', 'pension', '1', '2016-12-01', '2016-12-31', '0', 2, 14),
(19, 'Matricula 2016', '120.00', 'matricula', '1', '2016-09-01', '2016-12-31', '0', 3, NULL),
(20, 'Pensión Septiembre 2016', '120.00', 'pension', '1', '2016-09-01', '2016-09-30', '0', 3, 19),
(21, 'Pensión Octubre 2016', '120.00', 'pension', '1', '2016-10-01', '2016-10-31', '0', 3, 19),
(22, 'Pensión Noviembre 2016', '120.00', 'pension', '1', '2016-11-01', '2016-11-30', '0', 3, 19),
(23, 'Pensión Diciembre 2016', '120.00', 'pension', '1', '2016-12-01', '2016-12-31', '0', 3, 19),
(24, 'Matricula 2016 - III', '80.00', 'matricula', '1', '2016-09-01', '2016-12-31', '0', 6, NULL),
(25, 'Pensión 2016 - III Septiembre 2016', '100.00', 'pension', '1', '2016-09-01', '2016-09-30', '0', 6, 24),
(26, 'Pensión 2016 - III Octubre 2016', '100.00', 'pension', '1', '2016-10-01', '2016-10-31', '0', 6, 24),
(27, 'Pensión 2016 - III Noviembre 2016', '100.00', 'pension', '1', '2016-11-01', '2016-11-30', '0', 6, 24),
(28, 'Pensión 2016 - III Diciembre 2016', '100.00', 'pension', '1', '2016-12-01', '2016-12-31', '0', 6, 24),
(29, 'Matricula 2016 - III', '80.00', 'matricula', '1', '2016-09-01', '2016-12-31', '0', 7, NULL),
(30, 'Pensión 2016 - III Septiembre 2016', '100.00', 'pension', '1', '2016-09-01', '2016-09-30', '0', 7, 29),
(31, 'Pensión 2016 - III Octubre 2016', '100.00', 'pension', '1', '2016-10-01', '2016-10-31', '0', 7, 29),
(32, 'Pensión 2016 - III Noviembre 2016', '100.00', 'pension', '1', '2016-11-01', '2016-11-30', '0', 7, 29),
(33, 'Pensión 2016 - III Diciembre 2016', '100.00', 'pension', '1', '2016-12-01', '2016-12-31', '0', 7, 29),
(34, 'Matricula 2016 - III', '80.00', 'matricula', '1', '2016-09-01', '2016-12-31', '0', 8, NULL),
(35, 'Pensión 2016 - III Septiembre 2016', '100.00', 'pension', '1', '2016-09-01', '2016-09-30', '0', 8, 34),
(36, 'Pensión 2016 - III Octubre 2016', '100.00', 'pension', '1', '2016-10-01', '2016-10-31', '0', 8, 34),
(37, 'Pensión 2016 - III Noviembre 2016', '100.00', 'pension', '1', '2016-11-01', '2016-11-30', '0', 8, 34),
(38, 'Pensión 2016 - III Diciembre 2016', '100.00', 'pension', '1', '2016-12-01', '2016-12-31', '0', 8, 34),
(39, 'Matricula 2016 - III', '80.00', 'matricula', '1', '2016-09-01', '2016-12-31', '0', 9, NULL),
(40, 'Pensión 2016 - III Septiembre 2016', '100.00', 'pension', '1', '2016-09-01', '2016-09-30', '0', 9, 39),
(41, 'Pensión 2016 - III Octubre 2016', '100.00', 'pension', '1', '2016-10-01', '2016-10-31', '0', 9, 39),
(42, 'Pensión 2016 - III Noviembre 2016', '100.00', 'pension', '1', '2016-11-01', '2016-11-30', '0', 9, 39),
(43, 'Pensión 2016 - III Diciembre 2016', '100.00', 'pension', '1', '2016-12-01', '2016-12-31', '0', 9, 39),
(44, 'Matricula 2016 - III', '80.00', 'matricula', '1', '2016-09-01', '2016-12-31', '0', 10, NULL),
(45, 'Pensión 2016 - III Septiembre 2016', '100.00', 'pension', '1', '2016-09-01', '2016-09-30', '0', 10, 44),
(46, 'Pensión 2016 - III Octubre 2016', '100.00', 'pension', '1', '2016-10-01', '2016-10-31', '0', 10, 44),
(47, 'Pensión 2016 - III Noviembre 2016', '100.00', 'pension', '1', '2016-11-01', '2016-11-30', '0', 10, 44),
(48, 'Pensión 2016 - III Diciembre 2016', '100.00', 'pension', '1', '2016-12-01', '2016-12-31', '0', 10, 44),
(49, 'Matricula 2016 - III', '80.00', 'matricula', '1', '2016-09-01', '2016-12-31', '0', 11, NULL),
(50, 'Pensión 2016 - III Septiembre 2016', '100.00', 'pension', '1', '2016-09-01', '2016-09-30', '0', 11, 49),
(51, 'Pensión 2016 - III Octubre 2016', '100.00', 'pension', '1', '2016-10-01', '2016-10-31', '0', 11, 49),
(52, 'Pensión 2016 - III Noviembre 2016', '100.00', 'pension', '1', '2016-11-01', '2016-11-30', '0', 11, 49),
(53, 'Pensión 2016 - III Diciembre 2016', '100.00', 'pension', '1', '2016-12-01', '2016-12-31', '0', 11, 49),
(54, 'Matricula 2016 - III', '80.00', 'matricula', '1', '2016-09-01', '2016-12-31', '0', 12, NULL),
(55, 'Pensión 2016 - III Septiembre 2016', '100.00', 'pension', '1', '2016-09-01', '2016-09-30', '0', 12, 54),
(56, 'Pensión 2016 - III Octubre 2016', '100.00', 'pension', '1', '2016-10-01', '2016-10-31', '0', 12, 54),
(57, 'Pensión 2016 - III Noviembre 2016', '100.00', 'pension', '1', '2016-11-01', '2016-11-30', '0', 12, 54),
(58, 'Pensión 2016 - III Diciembre 2016', '100.00', 'pension', '1', '2016-12-01', '2016-12-31', '0', 12, 54),
(59, 'Desfile', '25.00', 'actividad', '1', NULL, NULL, '0', 12, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jsoria_comprobante`
--

CREATE TABLE IF NOT EXISTS `jsoria_comprobante` (
  `id` int(11) NOT NULL,
  `tipo` varchar(12) NOT NULL,
  `serie` varchar(15) DEFAULT '0001',
  `numero_comprobante` int(11) NOT NULL,
  `id_razon_social` char(1) NOT NULL,
  `pad_izquierda` int(11) NOT NULL DEFAULT '8'
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `jsoria_comprobante`
--

INSERT INTO `jsoria_comprobante` (`id`, `tipo`, `serie`, `numero_comprobante`, `id_razon_social`, `pad_izquierda`) VALUES
(1, 'comprobante', 'C001', 0, '1', 8),
(2, 'comprobante', 'C002', 0, '1', 8),
(3, 'comprobante', 'C001', 0, '2', 8),
(4, 'boleta', 'B001', 0, '1', 8),
(5, 'boleta', 'B001', 0, '2', 8),
(6, 'factura', 'F001', 0, '1', 8),
(7, 'factura', 'F001', 0, '2', 8);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jsoria_detalle_egreso`
--

CREATE TABLE IF NOT EXISTS `jsoria_detalle_egreso` (
  `id_egreso` int(11) NOT NULL,
  `nro_detalle_egreso` int(11) NOT NULL,
  `id_rubro` int(11) NOT NULL,
  `monto` decimal(8,2) NOT NULL,
  `descripcion` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jsoria_detalle_institucion`
--

CREATE TABLE IF NOT EXISTS `jsoria_detalle_institucion` (
  `id` int(11) NOT NULL,
  `id_institucion` int(11) NOT NULL,
  `nombre_division` varchar(50) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `jsoria_detalle_institucion`
--

INSERT INTO `jsoria_detalle_institucion` (`id`, `id_institucion`, `nombre_division`) VALUES
(1, 1, 'Inicial'),
(2, 1, 'Primaria'),
(3, 1, 'Secundaria'),
(4, 2, 'Primaria'),
(5, 2, 'Secundaria'),
(6, 3, 'Contabilidad'),
(7, 3, 'Enfermería'),
(8, 3, 'Construcción Civil'),
(9, 3, 'Farmacia'),
(10, 3, 'Guía Oficial de Turismo'),
(11, 3, 'Administración de Empresas'),
(12, 3, 'Computación e Informática'),
(13, 4, 'Ingeniería de Sistemas e Informática'),
(14, 4, 'Contabilidad'),
(15, 4, 'Economía'),
(16, 4, 'Ingeniería Civil'),
(17, 4, 'Ingeniería Ambiental'),
(18, 1, 'Todo'),
(19, 2, 'Todo'),
(20, 3, 'Todo'),
(21, 4, 'Todo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jsoria_deuda_ingreso`
--

CREATE TABLE IF NOT EXISTS `jsoria_deuda_ingreso` (
  `id` int(11) NOT NULL,
  `saldo` double(8,2) NOT NULL DEFAULT '0.00',
  `descuento` double(8,2) NOT NULL DEFAULT '0.00',
  `estado_pago` char(1) DEFAULT '0' COMMENT '0:Pendiente, 1:Pagado',
  `estado_retiro` char(1) NOT NULL DEFAULT '0',
  `estado_descuento` char(1) NOT NULL DEFAULT '0',
  `estado_fraccionam` char(1) NOT NULL DEFAULT '0',
  `cliente_extr` varchar(50) DEFAULT NULL,
  `descripcion_extr` varchar(50) DEFAULT NULL,
  `fecha_hora_ingreso` datetime DEFAULT NULL,
  `id_categoria` int(11) NOT NULL,
  `id_alumno` varchar(30) DEFAULT NULL,
  `id_autorizacion` int(11) DEFAULT NULL,
  `id_retiro` int(11) DEFAULT NULL,
  `id_cajera` int(11) DEFAULT NULL,
  `tipo_comprobante` enum('comprobante','boleta','factura') DEFAULT NULL,
  `serie_comprobante` varchar(15) DEFAULT NULL,
  `numero_comprobante` varchar(15) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `jsoria_deuda_ingreso`
--

INSERT INTO `jsoria_deuda_ingreso` (`id`, `saldo`, `descuento`, `estado_pago`, `estado_retiro`, `estado_descuento`, `estado_fraccionam`, `cliente_extr`, `descripcion_extr`, `fecha_hora_ingreso`, `id_categoria`, `id_alumno`, `id_autorizacion`, `id_retiro`, `id_cajera`, `tipo_comprobante`, `serie_comprobante`, `numero_comprobante`) VALUES
(1, 70.00, 0.00, '0', '0', '0', '1', NULL, NULL, NULL, 19, '11111111', NULL, NULL, NULL, NULL, NULL, NULL),
(2, 120.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 20, '11111111', NULL, NULL, NULL, NULL, NULL, NULL),
(3, 120.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 21, '11111111', NULL, NULL, NULL, NULL, NULL, NULL),
(4, 120.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 22, '11111111', NULL, NULL, NULL, NULL, NULL, NULL),
(5, 120.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 23, '11111111', NULL, NULL, NULL, NULL, NULL, NULL),
(6, 50.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 19, '11111111', NULL, NULL, NULL, NULL, NULL, NULL),
(7, 80.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 54, '22222222', NULL, NULL, NULL, NULL, NULL, NULL),
(8, 50.00, 11.00, '0', '0', '0', '1', NULL, NULL, NULL, 55, '22222222', NULL, NULL, NULL, NULL, NULL, NULL),
(9, 100.00, 11.00, '0', '0', '0', '0', NULL, NULL, NULL, 56, '22222222', NULL, NULL, NULL, NULL, NULL, NULL),
(10, 100.00, 11.00, '0', '0', '0', '0', NULL, NULL, NULL, 57, '22222222', NULL, NULL, NULL, NULL, NULL, NULL),
(11, 100.00, 11.00, '0', '0', '0', '0', NULL, NULL, NULL, 58, '22222222', NULL, NULL, NULL, NULL, NULL, NULL),
(12, 50.00, 5.50, '0', '0', '0', '0', NULL, NULL, NULL, 55, '22222222', NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jsoria_egreso`
--

CREATE TABLE IF NOT EXISTS `jsoria_egreso` (
  `id` int(11) NOT NULL,
  `tipo_comprobante` int(12) NOT NULL,
  `numero_comprobante` varchar(30) NOT NULL,
  `fecha` date NOT NULL,
  `id_institucion` int(11) NOT NULL,
  `id_tesorera` int(11) DEFAULT NULL,
  `fecha_registro` datetime DEFAULT NULL,
  `razon_social` varchar(255) DEFAULT NULL,
  `responsable` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jsoria_grado`
--

CREATE TABLE IF NOT EXISTS `jsoria_grado` (
  `id` int(11) NOT NULL,
  `id_detalle` int(11) DEFAULT NULL,
  `nombre_grado` varchar(45) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `jsoria_grado`
--

INSERT INTO `jsoria_grado` (`id`, `id_detalle`, `nombre_grado`) VALUES
(1, 1, '3 años'),
(2, 1, '4 años'),
(3, 1, '5 años'),
(4, 2, '1° grado'),
(5, 2, '2° grado'),
(6, 2, '3° grado'),
(7, 2, '4° grado'),
(8, 2, '5° grado'),
(9, 2, '6° grado'),
(10, 3, '1° grado'),
(11, 3, '2° grado'),
(12, 3, '3° grado'),
(13, 3, '4° grado'),
(14, 3, '5° grado'),
(15, 4, '1° grado'),
(16, 4, '2° grado'),
(17, 4, '3° grado'),
(18, 4, '4° grado'),
(19, 4, '5° grado'),
(20, 4, '6° grado'),
(21, 5, '1° grado'),
(22, 5, '2° grado'),
(23, 5, '3° grado'),
(24, 5, '4° grado'),
(25, 6, 'Semestre I'),
(26, 6, 'Semestre II'),
(27, 6, 'Semestre III'),
(28, 6, 'Semestre IV'),
(29, 6, 'Semestre V'),
(30, 6, 'Semestre VI'),
(31, 7, 'Semestre I'),
(32, 7, 'Semestre II'),
(33, 7, 'Semestre III'),
(34, 7, 'Semestre IV'),
(35, 7, 'Semestre V'),
(36, 7, 'Semestre VI'),
(37, 8, 'Semestre I'),
(38, 8, 'Semestre II'),
(39, 8, 'Semestre III'),
(40, 8, 'Semestre IV'),
(41, 8, 'Semestre V'),
(42, 8, 'Semestre VI'),
(43, 9, 'Semestre I'),
(44, 9, 'Semestre II'),
(45, 9, 'Semestre III'),
(46, 9, 'Semestre IV'),
(47, 9, 'Semestre V'),
(48, 9, 'Semestre VI'),
(49, 10, 'Semestre I'),
(50, 10, 'Semestre II'),
(51, 10, 'Semestre III'),
(52, 10, 'Semestre IV'),
(53, 10, 'Semestre V'),
(54, 10, 'Semestre VI'),
(55, 11, 'Semestre I'),
(56, 11, 'Semestre II'),
(57, 11, 'Semestre III'),
(58, 11, 'Semestre IV'),
(59, 11, 'Semestre V'),
(60, 11, 'Semestre VI'),
(61, 12, 'Semestre I'),
(62, 12, 'Semestre II'),
(63, 12, 'Semestre III'),
(64, 12, 'Semestre IV'),
(65, 12, 'Semestre V'),
(66, 12, 'Semestre VI'),
(67, 13, 'Unico'),
(68, 14, 'Unico'),
(69, 15, 'Unico'),
(70, 16, 'Unico'),
(71, 17, 'Unico');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jsoria_institucion`
--

CREATE TABLE IF NOT EXISTS `jsoria_institucion` (
  `id` int(11) NOT NULL,
  `nombre` varchar(60) NOT NULL,
  `id_razon_social` char(1) NOT NULL,
  `razon_social` varchar(50) NOT NULL,
  `ruc` char(11) NOT NULL,
  `direccion` varchar(50) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `jsoria_institucion`
--

INSERT INTO `jsoria_institucion` (`id`, `nombre`, `id_razon_social`, `razon_social`, `ruc`, `direccion`) VALUES
(1, 'Institución Educativa J. Soria', '1', 'Corporación Educativa J-Soria S.C.R.LTDA', '20490041339', 'Jr. Quillabamba N° 110 - Quillabamba'),
(2, 'CEBA Konrad Adenahuer', '1', 'Corporación Educativa J-Soria S.C.R.LTDA', '20490041339', 'Jr. Quillabamba N° 110 - Quillabamba'),
(3, 'Instituto Superior Tecnológico Urusayhua', '1', 'Corporación Educativa J-Soria S.C.R.LTDA', '20490041339', 'Jr. Quillabamba N° 110 - Quillabamba'),
(4, 'Universidad Líder Peruana', '2', 'Universidad Privada Líder Peruana S.A.C.', '20564356035', 'Jr. Quillabamba N° 110 - Quillabamba');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jsoria_migrations`
--

CREATE TABLE IF NOT EXISTS `jsoria_migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `jsoria_migrations`
--

INSERT INTO `jsoria_migrations` (`migration`, `batch`) VALUES
('2016_09_18_061348_add_razon_social_and_responsable_to_egreso', 1),
('2016_09_22_153014_change_user_printer_columns_to_nullable', 2),
('2016_09_22_232734_add_printer_to_comprobante', 2),
('2016_09_23_135351_add_fields_for_store_invoices', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jsoria_permisos`
--

CREATE TABLE IF NOT EXISTS `jsoria_permisos` (
  `id_institucion` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `jsoria_permisos`
--

INSERT INTO `jsoria_permisos` (`id_institucion`, `id_usuario`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(1, 2),
(2, 2),
(3, 2),
(4, 2),
(1, 3),
(2, 3),
(3, 3),
(4, 3),
(1, 4),
(2, 4),
(3, 4),
(4, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jsoria_retiro`
--

CREATE TABLE IF NOT EXISTS `jsoria_retiro` (
  `id` int(11) NOT NULL,
  `monto` double(8,2) DEFAULT '0.00',
  `fecha_hora_creacion` datetime DEFAULT NULL,
  `estado` char(1) DEFAULT '0' COMMENT '0: Pendiente, 1: Retirado.',
  `id_usuario` int(11) NOT NULL,
  `id_cajera` int(11) NOT NULL,
  `fecha_hora_retiro` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jsoria_rubro`
--

CREATE TABLE IF NOT EXISTS `jsoria_rubro` (
  `id` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tabla para almacenar los rubros.';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jsoria_tipo_comprobante`
--

CREATE TABLE IF NOT EXISTS `jsoria_tipo_comprobante` (
  `id` int(11) NOT NULL,
  `denominacion` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `jsoria_tipo_comprobante`
--

INSERT INTO `jsoria_tipo_comprobante` (`id`, `denominacion`) VALUES
(1, 'Boleta'),
(2, 'Factura'),
(3, 'Comprobante de Pago'),
(4, 'Comprobante de Egreso'),
(5, 'Recibo por Honorario');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jsoria_usuario`
--

CREATE TABLE IF NOT EXISTS `jsoria_usuario` (
  `id` int(11) NOT NULL,
  `dni` char(8) NOT NULL,
  `nombres` varchar(30) NOT NULL,
  `apellidos` varchar(50) NOT NULL,
  `tipo` varchar(20) NOT NULL,
  `usuario_login` varchar(20) NOT NULL,
  `password` varchar(60) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `jsoria_usuario`
--

INSERT INTO `jsoria_usuario` (`id`, `dni`, `nombres`, `apellidos`, `tipo`, `usuario_login`, `password`, `remember_token`) VALUES
(1, '12345678', 'admin', 'admin', 'Administrador', 'admin', '$2y$10$1mMfIVg.QYQ2yPEALOWo2eIe/lKdFTOQvHmZvvXEU4.qLYOLYV5nK', 'FZRDAdvdYdeVVfyHwhwVeRhENkaEIJghcinMHaXpuny37ijEWZpw3wtYy6E7'),
(2, '12345678', 'Jeronimo', 'Soria Mormontoy', 'Administrador', 'admin2', '$2y$10$MZf9JBxYC6TSxOlF5/oN8.OegQq7SFJgpDg6WhWEzyj1x7KCRArym', NULL),
(3, '92910101', 'Marta', 'Sanchez Paredes', 'Cajera', 'cajera', '$2y$10$7pDsbKyo.TkwWachx3yDCeHivGr287HQNgVNxYef.hry0B/RiKei.', 'j2XF08VKUohNYyLRXNmB1LPTt1FsJwAq33equPQ0Dsb3W7W8GvOxns99IC0z'),
(4, '12134134', 'Juana', 'Quispe Mormontoy', 'Secretaria', 'secretaria', '$2y$10$cn5wFSJJZETAbeMtJdrElOElcQNkiHgJ9yShq4YJv2X1wzaUbUIV2', 'Y7yveOflZW2bLqf0uHLWaJR4KWtDHdH64gVYM9Y28oIHEFbF2jJxHho6RWDB');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jsoria_usuario_impresora`
--

CREATE TABLE IF NOT EXISTS `jsoria_usuario_impresora` (
  `id_cajera` int(11) NOT NULL,
  `tipo_impresora` varchar(20) DEFAULT NULL,
  `nombre_impresora` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `jsoria_usuario_impresora`
--

INSERT INTO `jsoria_usuario_impresora` (`id_cajera`, `tipo_impresora`, `nombre_impresora`) VALUES
(3, 'matricial', 'Matricial');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `jsoria_alumno`
--
ALTER TABLE `jsoria_alumno`
  ADD PRIMARY KEY (`nro_documento`),
  ADD KEY `fk_grado_alumno_idx` (`id_grado`);

--
-- Indices de la tabla `jsoria_autorizacion`
--
ALTER TABLE `jsoria_autorizacion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_id_alumno_idx` (`id_alumno`);

--
-- Indices de la tabla `jsoria_balance`
--
ALTER TABLE `jsoria_balance`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `jsoria_categoria`
--
ALTER TABLE `jsoria_categoria`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_detalle:institucion_categoria_idx` (`id_detalle_institucion`),
  ADD KEY `fk_id_matricula` (`id_matricula`);

--
-- Indices de la tabla `jsoria_comprobante`
--
ALTER TABLE `jsoria_comprobante`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `jsoria_detalle_egreso`
--
ALTER TABLE `jsoria_detalle_egreso`
  ADD PRIMARY KEY (`id_egreso`,`nro_detalle_egreso`) USING BTREE,
  ADD KEY `fk_rubro_idx` (`id_rubro`);

--
-- Indices de la tabla `jsoria_detalle_institucion`
--
ALTER TABLE `jsoria_detalle_institucion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_institucion_detalle_institucion_idx` (`id_institucion`);

--
-- Indices de la tabla `jsoria_deuda_ingreso`
--
ALTER TABLE `jsoria_deuda_ingreso`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_categoria_deuda_idx` (`id_categoria`),
  ADD KEY `fk_autorizacion_deuda_idx` (`id_autorizacion`),
  ADD KEY `fk_retiro_deuda_idx` (`id_retiro`),
  ADD KEY `fk_alumno_deuda_idx` (`id_alumno`),
  ADD KEY `fkUsuario_Deuda_Ingreso` (`id_cajera`);

--
-- Indices de la tabla `jsoria_egreso`
--
ALTER TABLE `jsoria_egreso`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_idx` (`id_institucion`),
  ADD KEY `tipo_comprobante` (`tipo_comprobante`);

--
-- Indices de la tabla `jsoria_grado`
--
ALTER TABLE `jsoria_grado`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_detalle_institucion_grado_idx` (`id_detalle`);

--
-- Indices de la tabla `jsoria_institucion`
--
ALTER TABLE `jsoria_institucion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `jsoria_permisos`
--
ALTER TABLE `jsoria_permisos`
  ADD PRIMARY KEY (`id_institucion`,`id_usuario`),
  ADD KEY `fk_usuario_permisos_idx` (`id_usuario`);

--
-- Indices de la tabla `jsoria_retiro`
--
ALTER TABLE `jsoria_retiro`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fkid_usuario_retiro_idx` (`id_usuario`);

--
-- Indices de la tabla `jsoria_rubro`
--
ALTER TABLE `jsoria_rubro`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `jsoria_tipo_comprobante`
--
ALTER TABLE `jsoria_tipo_comprobante`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `jsoria_usuario`
--
ALTER TABLE `jsoria_usuario`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `jsoria_usuario_impresora`
--
ALTER TABLE `jsoria_usuario_impresora`
  ADD PRIMARY KEY (`id_cajera`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `jsoria_autorizacion`
--
ALTER TABLE `jsoria_autorizacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `jsoria_balance`
--
ALTER TABLE `jsoria_balance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `jsoria_categoria`
--
ALTER TABLE `jsoria_categoria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=60;
--
-- AUTO_INCREMENT de la tabla `jsoria_comprobante`
--
ALTER TABLE `jsoria_comprobante`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT de la tabla `jsoria_detalle_institucion`
--
ALTER TABLE `jsoria_detalle_institucion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT de la tabla `jsoria_deuda_ingreso`
--
ALTER TABLE `jsoria_deuda_ingreso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT de la tabla `jsoria_egreso`
--
ALTER TABLE `jsoria_egreso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `jsoria_grado`
--
ALTER TABLE `jsoria_grado`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=72;
--
-- AUTO_INCREMENT de la tabla `jsoria_institucion`
--
ALTER TABLE `jsoria_institucion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `jsoria_retiro`
--
ALTER TABLE `jsoria_retiro`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `jsoria_rubro`
--
ALTER TABLE `jsoria_rubro`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `jsoria_tipo_comprobante`
--
ALTER TABLE `jsoria_tipo_comprobante`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `jsoria_usuario`
--
ALTER TABLE `jsoria_usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `jsoria_autorizacion`
--
ALTER TABLE `jsoria_autorizacion`
  ADD CONSTRAINT `fk_id_alumno` FOREIGN KEY (`id_alumno`) REFERENCES `jsoria_alumno` (`nro_documento`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `jsoria_categoria`
--
ALTER TABLE `jsoria_categoria`
  ADD CONSTRAINT `fk_detalle:institucion_categoria` FOREIGN KEY (`id_detalle_institucion`) REFERENCES `jsoria_detalle_institucion` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_matricula_pension` FOREIGN KEY (`id_matricula`) REFERENCES `jsoria_categoria` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `jsoria_detalle_egreso`
--
ALTER TABLE `jsoria_detalle_egreso`
  ADD CONSTRAINT `fk_egreso_detalle_egreso` FOREIGN KEY (`id_egreso`) REFERENCES `jsoria_egreso` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_rubro_detalle_egreso` FOREIGN KEY (`id_rubro`) REFERENCES `jsoria_rubro` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `jsoria_detalle_institucion`
--
ALTER TABLE `jsoria_detalle_institucion`
  ADD CONSTRAINT `fk_institucion_detalle_institucion` FOREIGN KEY (`id_institucion`) REFERENCES `jsoria_institucion` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `jsoria_deuda_ingreso`
--
ALTER TABLE `jsoria_deuda_ingreso`
  ADD CONSTRAINT `fkUsuario_Deuda_Ingreso` FOREIGN KEY (`id_cajera`) REFERENCES `jsoria_usuario` (`id`),
  ADD CONSTRAINT `fk_alumno_deuda` FOREIGN KEY (`id_alumno`) REFERENCES `jsoria_alumno` (`nro_documento`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_autorizacion_deuda` FOREIGN KEY (`id_autorizacion`) REFERENCES `jsoria_autorizacion` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_categoria_deuda` FOREIGN KEY (`id_categoria`) REFERENCES `jsoria_categoria` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_retiro_deuda` FOREIGN KEY (`id_retiro`) REFERENCES `jsoria_retiro` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `jsoria_egreso`
--
ALTER TABLE `jsoria_egreso`
  ADD CONSTRAINT `fk_institucion_egreso_id` FOREIGN KEY (`id_institucion`) REFERENCES `jsoria_institucion` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tipo_comprobante_egreso` FOREIGN KEY (`tipo_comprobante`) REFERENCES `jsoria_tipo_comprobante` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `jsoria_grado`
--
ALTER TABLE `jsoria_grado`
  ADD CONSTRAINT `fk_detalle_institucion_grado` FOREIGN KEY (`id_detalle`) REFERENCES `jsoria_detalle_institucion` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `jsoria_permisos`
--
ALTER TABLE `jsoria_permisos`
  ADD CONSTRAINT `fk_institucion_permisos` FOREIGN KEY (`id_institucion`) REFERENCES `jsoria_institucion` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_usuario_permisos` FOREIGN KEY (`id_usuario`) REFERENCES `jsoria_usuario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `jsoria_retiro`
--
ALTER TABLE `jsoria_retiro`
  ADD CONSTRAINT `fkid_usuario_retiro` FOREIGN KEY (`id_usuario`) REFERENCES `jsoria_usuario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
