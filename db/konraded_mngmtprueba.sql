-- phpMyAdmin SQL Dump
-- version 4.0.10.14
-- http://www.phpmyadmin.net
--
-- Servidor: localhost:3306
-- Tiempo de generación: 23-09-2016 a las 08:53:47
-- Versión del servidor: 5.5.49-cll-lve
-- Versión de PHP: 5.6.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

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
  `id_grado` int(11) DEFAULT NULL,
  PRIMARY KEY (`nro_documento`),
  KEY `fk_grado_alumno_idx` (`id_grado`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `jsoria_alumno`
--

INSERT INTO `jsoria_alumno` (`nro_documento`, `tipo_documento`, `nombres`, `apellidos`, `estado`, `id_grado`) VALUES
('11111111', 'DNI', 'Maria', 'Martines', '1', 1),
('22222222', 'DNI', 'pedro', 'peres', '1', 1),
('40404040', 'DNI', 'Juan', 'Perez Perez', '1', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jsoria_autorizacion`
--

CREATE TABLE IF NOT EXISTS `jsoria_autorizacion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rd` varchar(20) NOT NULL COMMENT 'Resolución Directoral',
  `estado` char(1) DEFAULT '0' COMMENT '0: Sin procesar, 1: Procesada.',
  `id_alumno` varchar(30) NOT NULL,
  `fecha_limite` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_id_alumno_idx` (`id_alumno`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jsoria_balance`
--

CREATE TABLE IF NOT EXISTS `jsoria_balance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` date NOT NULL,
  `id_tesorera` int(11) NOT NULL,
  `ingresos` decimal(8,2) NOT NULL DEFAULT '0.00',
  `egresos` decimal(8,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `jsoria_balance`
--

INSERT INTO `jsoria_balance` (`id`, `fecha`, `id_tesorera`, `ingresos`, `egresos`) VALUES
(1, '2016-09-18', 4, '0.00', '50.00'),
(2, '2016-09-22', 4, '950.00', '54944.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jsoria_categoria`
--

CREATE TABLE IF NOT EXISTS `jsoria_categoria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `monto` decimal(8,2) DEFAULT NULL,
  `tipo` varchar(30) NOT NULL COMMENT 'Valores: {actividad, matricula, pension, cobro_ordinario, cobro_extraordinario, cobro_multiple}',
  `estado` char(1) DEFAULT NULL COMMENT '0: Habilitada, 1: Inhabilitada.',
  `fecha_inicio` date DEFAULT NULL,
  `fecha_fin` date DEFAULT NULL,
  `destino` char(1) DEFAULT '0' COMMENT '0: Interno, 1: Externo.',
  `id_detalle_institucion` int(11) NOT NULL,
  `id_matricula` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_detalle:institucion_categoria_idx` (`id_detalle_institucion`),
  KEY `fk_id_matricula` (`id_matricula`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=138 ;

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
(9, 'desfile', '25.00', 'actividad', '1', NULL, NULL, '0', 1, NULL),
(10, 'Actividad', '50.00', 'actividad', '1', NULL, NULL, '0', 1, NULL),
(11, 'libros', '100.00', 'con_factor', '1', NULL, NULL, '0', 18, NULL),
(12, 'Matricula 2016', '100.00', 'matricula', '1', '2016-01-01', '2016-06-30', '0', 1, NULL),
(13, 'Pensión Marzo 2016', '120.00', 'pension', '1', '2016-03-01', '2016-03-31', '0', 1, 12),
(14, 'Pensión Abril 2016', '120.00', 'pension', '1', '2016-04-01', '2016-04-30', '0', 1, 12),
(15, 'Pensión Mayo 2016', '120.00', 'pension', '1', '2016-05-01', '2016-05-31', '0', 1, 12),
(16, 'Pensión Junio 2016', '120.00', 'pension', '1', '2016-06-01', '2016-06-30', '0', 1, 12),
(17, 'Pensión Julio 2016', '120.00', 'pension', '1', '2016-07-01', '2016-07-31', '0', 1, 12),
(18, 'Pensión Agosto 2016', '120.00', 'pension', '1', '2016-08-01', '2016-08-31', '0', 1, 12),
(19, 'Pensión Septiembre 2016', '120.00', 'pension', '1', '2016-09-01', '2016-09-30', '0', 1, 12),
(20, 'Pensión Octubre 2016', '120.00', 'pension', '1', '2016-10-01', '2016-10-31', '0', 1, 12),
(21, 'Pensión Noviembre 2016', '120.00', 'pension', '1', '2016-11-01', '2016-11-30', '0', 1, 12),
(22, 'Pensión Diciembre 2016', '120.00', 'pension', '1', '2016-12-01', '2016-12-31', '0', 1, 12),
(23, 'Matricula 2016', '120.00', 'matricula', '1', '2016-01-01', '2016-06-30', '0', 2, NULL),
(24, 'Pensión Marzo 2016', '140.00', 'pension', '1', '2016-03-01', '2016-03-31', '0', 2, 23),
(25, 'Pensión Abril 2016', '140.00', 'pension', '1', '2016-04-01', '2016-04-30', '0', 2, 23),
(26, 'Pensión Mayo 2016', '140.00', 'pension', '1', '2016-05-01', '2016-05-31', '0', 2, 23),
(27, 'Pensión Junio 2016', '140.00', 'pension', '1', '2016-06-01', '2016-06-30', '0', 2, 23),
(28, 'Pensión Julio 2016', '140.00', 'pension', '1', '2016-07-01', '2016-07-31', '0', 2, 23),
(29, 'Pensión Agosto 2016', '140.00', 'pension', '1', '2016-08-01', '2016-08-31', '0', 2, 23),
(30, 'Pensión Septiembre 2016', '140.00', 'pension', '1', '2016-09-01', '2016-09-30', '0', 2, 23),
(31, 'Pensión Octubre 2016', '140.00', 'pension', '1', '2016-10-01', '2016-10-31', '0', 2, 23),
(32, 'Pensión Noviembre 2016', '140.00', 'pension', '1', '2016-11-01', '2016-11-30', '0', 2, 23),
(33, 'Pensión Diciembre 2016', '140.00', 'pension', '1', '2016-12-01', '2016-12-31', '0', 2, 23),
(34, 'Matricula 2016', '140.00', 'matricula', '1', '2016-01-01', '2016-06-30', '0', 3, NULL),
(35, 'Pensión Marzo 2016', '160.00', 'pension', '1', '2016-03-01', '2016-03-31', '0', 3, 34),
(36, 'Pensión Abril 2016', '160.00', 'pension', '1', '2016-04-01', '2016-04-30', '0', 3, 34),
(37, 'Pensión Mayo 2016', '160.00', 'pension', '1', '2016-05-01', '2016-05-31', '0', 3, 34),
(38, 'Pensión Junio 2016', '160.00', 'pension', '1', '2016-06-01', '2016-06-30', '0', 3, 34),
(39, 'Pensión Julio 2016', '160.00', 'pension', '1', '2016-07-01', '2016-07-31', '0', 3, 34),
(40, 'Pensión Agosto 2016', '160.00', 'pension', '1', '2016-08-01', '2016-08-31', '0', 3, 34),
(41, 'Pensión Septiembre 2016', '160.00', 'pension', '1', '2016-09-01', '2016-09-30', '0', 3, 34),
(42, 'Pensión Octubre 2016', '160.00', 'pension', '1', '2016-10-01', '2016-10-31', '0', 3, 34),
(43, 'Pensión Noviembre 2016', '160.00', 'pension', '1', '2016-11-01', '2016-11-30', '0', 3, 34),
(44, 'Pensión Diciembre 2016', '160.00', 'pension', '1', '2016-12-01', '2016-12-31', '0', 3, 34),
(45, 'Matricula Especial', '80.00', 'matricula', '1', '2016-01-01', '2016-06-30', '0', 1, NULL),
(46, 'Pensión Especial Marzo 2016', '100.00', 'pension', '1', '2016-03-01', '2016-03-31', '0', 1, 45),
(47, 'Pensión Especial Abril 2016', '100.00', 'pension', '1', '2016-04-01', '2016-04-30', '0', 1, 45),
(48, 'Pensión Especial Mayo 2016', '100.00', 'pension', '1', '2016-05-01', '2016-05-31', '0', 1, 45),
(49, 'Pensión Especial Junio 2016', '100.00', 'pension', '1', '2016-06-01', '2016-06-30', '0', 1, 45),
(50, 'Pensión Especial Julio 2016', '100.00', 'pension', '1', '2016-07-01', '2016-07-31', '0', 1, 45),
(51, 'Pensión Especial Agosto 2016', '100.00', 'pension', '1', '2016-08-01', '2016-08-31', '0', 1, 45),
(52, 'Pensión Especial Septiembre 2016', '100.00', 'pension', '1', '2016-09-01', '2016-09-30', '0', 1, 45),
(53, 'Pensión Especial Octubre 2016', '100.00', 'pension', '1', '2016-10-01', '2016-10-31', '0', 1, 45),
(54, 'Pensión Especial Noviembre 2016', '100.00', 'pension', '1', '2016-11-01', '2016-11-30', '0', 1, 45),
(55, 'Pensión Especial Diciembre 2016', '100.00', 'pension', '1', '2016-12-01', '2016-12-31', '0', 1, 45),
(56, 'Matricula Especial', '100.00', 'matricula', '1', '2016-01-01', '2016-06-30', '0', 2, NULL),
(57, 'Pensión Especial Marzo 2016', '120.00', 'pension', '1', '2016-03-01', '2016-03-31', '0', 2, 56),
(58, 'Pensión Especial Abril 2016', '120.00', 'pension', '1', '2016-04-01', '2016-04-30', '0', 2, 56),
(59, 'Pensión Especial Mayo 2016', '120.00', 'pension', '1', '2016-05-01', '2016-05-31', '0', 2, 56),
(60, 'Pensión Especial Junio 2016', '120.00', 'pension', '1', '2016-06-01', '2016-06-30', '0', 2, 56),
(61, 'Pensión Especial Julio 2016', '120.00', 'pension', '1', '2016-07-01', '2016-07-31', '0', 2, 56),
(62, 'Pensión Especial Agosto 2016', '120.00', 'pension', '1', '2016-08-01', '2016-08-31', '0', 2, 56),
(63, 'Pensión Especial Septiembre 2016', '120.00', 'pension', '1', '2016-09-01', '2016-09-30', '0', 2, 56),
(64, 'Pensión Especial Octubre 2016', '120.00', 'pension', '1', '2016-10-01', '2016-10-31', '0', 2, 56),
(65, 'Pensión Especial Noviembre 2016', '120.00', 'pension', '1', '2016-11-01', '2016-11-30', '0', 2, 56),
(66, 'Pensión Especial Diciembre 2016', '120.00', 'pension', '1', '2016-12-01', '2016-12-31', '0', 2, 56),
(67, 'Matricula Especial', '120.00', 'matricula', '1', '2016-01-01', '2016-06-30', '0', 3, NULL),
(68, 'Pensión Especial Marzo 2016', '140.00', 'pension', '1', '2016-03-01', '2016-03-31', '0', 3, 67),
(69, 'Pensión Especial Abril 2016', '140.00', 'pension', '1', '2016-04-01', '2016-04-30', '0', 3, 67),
(70, 'Pensión Especial Mayo 2016', '140.00', 'pension', '1', '2016-05-01', '2016-05-31', '0', 3, 67),
(71, 'Pensión Especial Junio 2016', '140.00', 'pension', '1', '2016-06-01', '2016-06-30', '0', 3, 67),
(72, 'Pensión Especial Julio 2016', '140.00', 'pension', '1', '2016-07-01', '2016-07-31', '0', 3, 67),
(73, 'Pensión Especial Agosto 2016', '140.00', 'pension', '1', '2016-08-01', '2016-08-31', '0', 3, 67),
(74, 'Pensión Especial Septiembre 2016', '140.00', 'pension', '1', '2016-09-01', '2016-09-30', '0', 3, 67),
(75, 'Pensión Especial Octubre 2016', '140.00', 'pension', '1', '2016-10-01', '2016-10-31', '0', 3, 67),
(76, 'Pensión Especial Noviembre 2016', '140.00', 'pension', '1', '2016-11-01', '2016-11-30', '0', 3, 67),
(77, 'Pensión Especial Diciembre 2016', '140.00', 'pension', '1', '2016-12-01', '2016-12-31', '0', 3, 67),
(78, 'Matricula 2016-III', '100.00', 'matricula', '1', '2016-09-01', '2016-12-31', '0', 4, NULL),
(79, 'Pensión 2016-III Septiembre 2016', '150.00', 'pension', '1', '2016-09-01', '2016-09-30', '0', 4, 78),
(80, 'Pensión 2016-III Octubre 2016', '150.00', 'pension', '1', '2016-10-01', '2016-10-31', '0', 4, 78),
(81, 'Pensión 2016-III Noviembre 2016', '150.00', 'pension', '1', '2016-11-01', '2016-11-30', '0', 4, 78),
(82, 'Pensión 2016-III Diciembre 2016', '150.00', 'pension', '1', '2016-12-01', '2016-12-31', '0', 4, 78),
(83, 'Pensión 2016-III Enero 2017', '150.00', 'pension', '1', '2017-01-01', '2017-01-31', '0', 4, 78),
(84, 'Matricula 2016-III', '150.00', 'matricula', '1', '2016-09-01', '2016-12-31', '0', 5, NULL),
(85, 'Pensión 2016-III Septiembre 2016', '200.00', 'pension', '1', '2016-09-01', '2016-09-30', '0', 5, 84),
(86, 'Pensión 2016-III Octubre 2016', '200.00', 'pension', '1', '2016-10-01', '2016-10-31', '0', 5, 84),
(87, 'Pensión 2016-III Noviembre 2016', '200.00', 'pension', '1', '2016-11-01', '2016-11-30', '0', 5, 84),
(88, 'Pensión 2016-III Diciembre 2016', '200.00', 'pension', '1', '2016-12-01', '2016-12-31', '0', 5, 84),
(89, 'Pensión 2016-III Enero 2017', '200.00', 'pension', '1', '2017-01-01', '2017-01-31', '0', 5, 84),
(90, 'Matricula Especial', '80.00', 'matricula', '1', '2016-09-01', '2016-12-31', '0', 4, NULL),
(91, 'Pensión Especial Septiembre 2016', '130.00', 'pension', '1', '2016-09-01', '2016-09-30', '0', 4, 90),
(92, 'Pensión Especial Octubre 2016', '130.00', 'pension', '1', '2016-10-01', '2016-10-31', '0', 4, 90),
(93, 'Pensión Especial Noviembre 2016', '130.00', 'pension', '1', '2016-11-01', '2016-11-30', '0', 4, 90),
(94, 'Pensión Especial Diciembre 2016', '130.00', 'pension', '1', '2016-12-01', '2016-12-31', '0', 4, 90),
(95, 'Pensión Especial Enero 2017', '130.00', 'pension', '1', '2017-01-01', '2017-01-31', '0', 4, 90),
(96, 'Matricula Especial', '130.00', 'matricula', '1', '2016-09-01', '2016-12-31', '0', 5, NULL),
(97, 'Pensión Especial Septiembre 2016', '180.00', 'pension', '1', '2016-09-01', '2016-09-30', '0', 5, 96),
(98, 'Pensión Especial Octubre 2016', '180.00', 'pension', '1', '2016-10-01', '2016-10-31', '0', 5, 96),
(99, 'Pensión Especial Noviembre 2016', '180.00', 'pension', '1', '2016-11-01', '2016-11-30', '0', 5, 96),
(100, 'Pensión Especial Diciembre 2016', '180.00', 'pension', '1', '2016-12-01', '2016-12-31', '0', 5, 96),
(101, 'Pensión Especial Enero 2017', '180.00', 'pension', '1', '2017-01-01', '2017-01-31', '0', 5, 96),
(102, 'Matricula 2017', '150.00', 'matricula', '1', '2016-11-01', '2016-12-31', '0', 6, NULL),
(103, 'Pensión Noviembre 2016', '180.00', 'pension', '1', '2016-11-01', '2016-11-30', '0', 6, 102),
(104, 'Pensión Diciembre 2016', '180.00', 'pension', '1', '2016-12-01', '2016-12-31', '0', 6, 102),
(105, 'Pensión Enero 2017', '180.00', 'pension', '1', '2017-01-01', '2017-01-31', '0', 6, 102),
(106, 'Pensión Febrero 2017', '180.00', 'pension', '1', '2017-02-01', '2017-02-28', '0', 6, 102),
(107, 'Matricula 2017', '150.00', 'matricula', '1', '2016-11-01', '2016-12-31', '0', 7, NULL),
(108, 'Pensión Noviembre 2016', '180.00', 'pension', '1', '2016-11-01', '2016-11-30', '0', 7, 107),
(109, 'Pensión Diciembre 2016', '180.00', 'pension', '1', '2016-12-01', '2016-12-31', '0', 7, 107),
(110, 'Pensión Enero 2017', '180.00', 'pension', '1', '2017-01-01', '2017-01-31', '0', 7, 107),
(111, 'Pensión Febrero 2017', '180.00', 'pension', '1', '2017-02-01', '2017-02-28', '0', 7, 107),
(112, 'Matricula 2017', '150.00', 'matricula', '1', '2016-11-01', '2016-12-31', '0', 8, NULL),
(113, 'Pensión Noviembre 2016', '180.00', 'pension', '1', '2016-11-01', '2016-11-30', '0', 8, 112),
(114, 'Pensión Diciembre 2016', '180.00', 'pension', '1', '2016-12-01', '2016-12-31', '0', 8, 112),
(115, 'Pensión Enero 2017', '180.00', 'pension', '1', '2017-01-01', '2017-01-31', '0', 8, 112),
(116, 'Pensión Febrero 2017', '180.00', 'pension', '1', '2017-02-01', '2017-02-28', '0', 8, 112),
(117, 'Matricula 2017', '150.00', 'matricula', '1', '2016-11-01', '2016-12-31', '0', 9, NULL),
(118, 'Pensión Noviembre 2016', '180.00', 'pension', '1', '2016-11-01', '2016-11-30', '0', 9, 117),
(119, 'Pensión Diciembre 2016', '180.00', 'pension', '1', '2016-12-01', '2016-12-31', '0', 9, 117),
(120, 'Pensión Enero 2017', '180.00', 'pension', '1', '2017-01-01', '2017-01-31', '0', 9, 117),
(121, 'Pensión Febrero 2017', '180.00', 'pension', '1', '2017-02-01', '2017-02-28', '0', 9, 117),
(122, 'Matricula 2017', '150.00', 'matricula', '1', '2016-11-01', '2016-12-31', '0', 10, NULL),
(123, 'Pensión Noviembre 2016', '180.00', 'pension', '1', '2016-11-01', '2016-11-30', '0', 10, 122),
(124, 'Pensión Diciembre 2016', '180.00', 'pension', '1', '2016-12-01', '2016-12-31', '0', 10, 122),
(125, 'Pensión Enero 2017', '180.00', 'pension', '1', '2017-01-01', '2017-01-31', '0', 10, 122),
(126, 'Pensión Febrero 2017', '180.00', 'pension', '1', '2017-02-01', '2017-02-28', '0', 10, 122),
(127, 'Matricula 2017', '150.00', 'matricula', '1', '2016-11-01', '2016-12-31', '0', 11, NULL),
(128, 'Pensión Noviembre 2016', '180.00', 'pension', '1', '2016-11-01', '2016-11-30', '0', 11, 127),
(129, 'Pensión Diciembre 2016', '180.00', 'pension', '1', '2016-12-01', '2016-12-31', '0', 11, 127),
(130, 'Pensión Enero 2017', '180.00', 'pension', '1', '2017-01-01', '2017-01-31', '0', 11, 127),
(131, 'Pensión Febrero 2017', '180.00', 'pension', '1', '2017-02-01', '2017-02-28', '0', 11, 127),
(132, 'Matricula 2017', '150.00', 'matricula', '1', '2016-11-01', '2016-12-31', '0', 12, NULL),
(133, 'Pensión Noviembre 2016', '180.00', 'pension', '1', '2016-11-01', '2016-11-30', '0', 12, 132),
(134, 'Pensión Diciembre 2016', '180.00', 'pension', '1', '2016-12-01', '2016-12-31', '0', 12, 132),
(135, 'Pensión Enero 2017', '180.00', 'pension', '1', '2017-01-01', '2017-01-31', '0', 12, 132),
(136, 'Pensión Febrero 2017', '180.00', 'pension', '1', '2017-02-01', '2017-02-28', '0', 12, 132),
(137, 'examen', '100.00', 'multiple', '1', NULL, NULL, '0', 18, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jsoria_comprobante`
--

CREATE TABLE IF NOT EXISTS `jsoria_comprobante` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` varchar(12) NOT NULL,
  `numero_comprobante` int(11) NOT NULL,
  `id_razon_social` char(1) NOT NULL,
  `tipo_impresora` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `jsoria_comprobante`
--

INSERT INTO `jsoria_comprobante` (`id`, `tipo`, `numero_comprobante`, `id_razon_social`, `tipo_impresora`) VALUES
(1, 'comprobante', 1, '1', 'matricial');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jsoria_detalle_egreso`
--

CREATE TABLE IF NOT EXISTS `jsoria_detalle_egreso` (
  `id_egreso` int(11) NOT NULL,
  `nro_detalle_egreso` int(11) NOT NULL,
  `id_rubro` int(11) NOT NULL,
  `monto` decimal(8,2) NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  PRIMARY KEY (`id_egreso`,`nro_detalle_egreso`) USING BTREE,
  KEY `fk_rubro_idx` (`id_rubro`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `jsoria_detalle_egreso`
--

INSERT INTO `jsoria_detalle_egreso` (`id_egreso`, `nro_detalle_egreso`, `id_rubro`, `monto`, `descripcion`) VALUES
(2, 1, 1, '50.00', 'papel'),
(3, 1, 1, '200.00', 'papel'),
(3, 2, 1, '200.00', 'papel 2'),
(4, 1, 2, '123.00', 'platos'),
(5, 1, 2, '12.00', 'carton'),
(6, 1, 2, '23.00', 'torta'),
(7, 1, 3, '54321.00', 'pago');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jsoria_detalle_institucion`
--

CREATE TABLE IF NOT EXISTS `jsoria_detalle_institucion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_institucion` int(11) NOT NULL,
  `nombre_division` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_institucion_detalle_institucion_idx` (`id_institucion`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

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
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  PRIMARY KEY (`id`),
  KEY `fk_categoria_deuda_idx` (`id_categoria`),
  KEY `fk_autorizacion_deuda_idx` (`id_autorizacion`),
  KEY `fk_retiro_deuda_idx` (`id_retiro`),
  KEY `fk_alumno_deuda_idx` (`id_alumno`),
  KEY `fkUsuario_Deuda_Ingreso` (`id_cajera`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Volcado de datos para la tabla `jsoria_deuda_ingreso`
--

INSERT INTO `jsoria_deuda_ingreso` (`id`, `saldo`, `descuento`, `estado_pago`, `estado_retiro`, `estado_descuento`, `estado_fraccionam`, `cliente_extr`, `descripcion_extr`, `fecha_hora_ingreso`, `id_categoria`, `id_alumno`, `id_autorizacion`, `id_retiro`, `id_cajera`) VALUES
(1, 1000.00, 0.00, '1', '2', '0', '0', 'Jose', 'alquiler', '2016-09-22 18:35:27', 1, NULL, NULL, 1, 7),
(2, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 12, '40404040', NULL, NULL, NULL),
(3, 120.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 19, '40404040', NULL, NULL, NULL),
(4, 120.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 20, '40404040', NULL, NULL, NULL),
(5, 120.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 21, '40404040', NULL, NULL, NULL),
(6, 120.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 22, '40404040', NULL, NULL, NULL),
(7, 50.00, 0.00, '0', '0', '0', '1', NULL, NULL, NULL, 11, '40404040', NULL, NULL, NULL),
(8, 50.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 11, '40404040', NULL, NULL, NULL),
(9, 80.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 45, '11111111', NULL, NULL, NULL),
(10, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 52, '11111111', NULL, NULL, NULL),
(11, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 53, '11111111', NULL, NULL, NULL),
(12, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 54, '11111111', NULL, NULL, NULL),
(13, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 55, '11111111', NULL, NULL, NULL),
(14, 100.00, 0.00, '1', '0', '0', '0', NULL, NULL, '2016-09-22 21:03:13', 12, '22222222', NULL, NULL, 7),
(15, 120.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 19, '22222222', NULL, NULL, NULL),
(16, 120.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 20, '22222222', NULL, NULL, NULL),
(17, 120.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 21, '22222222', NULL, NULL, NULL),
(18, 120.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 22, '22222222', NULL, NULL, NULL),
(19, 1000.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 11, '22222222', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jsoria_egreso`
--

CREATE TABLE IF NOT EXISTS `jsoria_egreso` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_comprobante` int(12) NOT NULL,
  `numero_comprobante` varchar(30) NOT NULL,
  `fecha` date NOT NULL,
  `id_institucion` int(11) NOT NULL,
  `id_tesorera` int(11) DEFAULT NULL,
  `fecha_registro` datetime DEFAULT NULL,
  `razon_social` varchar(255) DEFAULT NULL,
  `responsable` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_idx` (`id_institucion`),
  KEY `tipo_comprobante` (`tipo_comprobante`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Volcado de datos para la tabla `jsoria_egreso`
--

INSERT INTO `jsoria_egreso` (`id`, `tipo_comprobante`, `numero_comprobante`, `fecha`, `id_institucion`, `id_tesorera`, `fecha_registro`, `razon_social`, `responsable`) VALUES
(2, 1, 'B0001', '2016-09-18', 1, 4, '2016-09-18 06:58:37', 'orion', 'juanana'),
(3, 1, '123445', '2016-09-22', 1, 4, '2016-09-22 18:44:20', 'Mega', 'juan'),
(4, 2, '5432', '2016-09-22', 1, 4, '2016-09-22 18:45:05', 'Mega', 'juan'),
(5, 3, '543', '2016-09-22', 1, 4, '2016-09-22 18:45:47', 'mega', 'juana'),
(6, 4, '1234', '2016-09-22', 1, 4, '2016-09-22 18:46:32', 'Mega', 'juana'),
(7, 5, '183645467', '2016-09-22', 1, 4, '2016-09-22 18:47:12', 'maria', 'juana');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jsoria_grado`
--

CREATE TABLE IF NOT EXISTS `jsoria_grado` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_detalle` int(11) DEFAULT NULL,
  `nombre_grado` varchar(45) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_detalle_institucion_grado_idx` (`id_detalle`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=72 ;

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
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(60) NOT NULL,
  `id_razon_social` char(1) NOT NULL,
  `razon_social` varchar(50) NOT NULL,
  `ruc` char(11) NOT NULL,
  `direccion` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

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
('2016_09_22_232734_add_printer_to_comprobante', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jsoria_permisos`
--

CREATE TABLE IF NOT EXISTS `jsoria_permisos` (
  `id_institucion` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  PRIMARY KEY (`id_institucion`,`id_usuario`),
  KEY `fk_usuario_permisos_idx` (`id_usuario`)
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
(1, 4),
(2, 4),
(3, 4),
(1, 7),
(2, 7),
(3, 7),
(4, 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jsoria_retiro`
--

CREATE TABLE IF NOT EXISTS `jsoria_retiro` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `monto` double(8,2) DEFAULT '0.00',
  `fecha_hora_creacion` datetime DEFAULT NULL,
  `estado` char(1) DEFAULT '0' COMMENT '0: Pendiente, 1: Retirado.',
  `id_usuario` int(11) NOT NULL,
  `id_cajera` int(11) NOT NULL,
  `fecha_hora_retiro` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fkid_usuario_retiro_idx` (`id_usuario`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `jsoria_retiro`
--

INSERT INTO `jsoria_retiro` (`id`, `monto`, `fecha_hora_creacion`, `estado`, `id_usuario`, `id_cajera`, `fecha_hora_retiro`) VALUES
(1, 1000.00, '2016-09-22 18:51:26', '1', 4, 7, '2016-09-22 18:52:47');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jsoria_rubro`
--

CREATE TABLE IF NOT EXISTS `jsoria_rubro` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Tabla para almacenar los rubros.' AUTO_INCREMENT=6 ;

--
-- Volcado de datos para la tabla `jsoria_rubro`
--

INSERT INTO `jsoria_rubro` (`id`, `nombre`) VALUES
(1, 'Papelería'),
(2, 'Víveres'),
(3, 'Otros'),
(4, 'Utilitarios');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jsoria_tipo_comprobante`
--

CREATE TABLE IF NOT EXISTS `jsoria_tipo_comprobante` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `denominacion` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

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
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dni` char(8) NOT NULL,
  `nombres` varchar(30) NOT NULL,
  `apellidos` varchar(50) NOT NULL,
  `tipo` varchar(20) NOT NULL,
  `usuario_login` varchar(20) NOT NULL,
  `password` varchar(60) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Volcado de datos para la tabla `jsoria_usuario`
--

INSERT INTO `jsoria_usuario` (`id`, `dni`, `nombres`, `apellidos`, `tipo`, `usuario_login`, `password`, `remember_token`) VALUES
(1, '12345678', 'admin', 'admin', 'Administrador', 'admin', '$2y$10$1mMfIVg.QYQ2yPEALOWo2eIe/lKdFTOQvHmZvvXEU4.qLYOLYV5nK', 'NLAcLIu6FScdVJFOI1j94IQyqdrZZQyg1jFC5EnLvQ0KlNWZsbxvAbdKkcHX'),
(2, '12345678', 'Jeronimo', 'Soria Mormontoy', 'Administrador', 'admin', '$2y$10$P61SA96nobJ9n2s2OY769u2ALz1y3.lq8nl6higXZhVKcaszKy59u', NULL),
(3, '21354678', 'Secretari', 'secretaria', 'Secretaria', 'secretaria1', '$2y$10$CHcqIpdQjGBxeAeza8vDyunRZOaIWT.857QUz/GPT1kISoQfOCkdu', 'exUjU5EC69wnD5fInvq5v5pFC0zFEnh6kbLxI1vwQYyrY9vjJQq5jHjh5vyy'),
(4, '87654321', 'Tesorera', 'tesorera', 'Tesorera', 'tesorera1', '$2y$10$HQob4zvlse1lKdQ5MLfIYOagOoYd0a5aA5k0O4JUA/tPs0hSpc1uu', '67oTmIwNT4ZJQ54JBRvlxSYUbro7kljQFywaZxiIEr8XhxtwRaVdOsVRhGnU'),
(7, '20202020', 'Juana', 'Solis Salas', 'Cajera', 'cajera', '$2y$10$k1lzQSnEtLWYV04zCu/u3O86qBQHSJVcrpN0wak1xAiL5Ss2IdJbK', 'UPeOGvODQaxJB4lxlGa1Pji74ZPlD86cW7nmogzZ5FA7kAl72K9TtOAXkvgt');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jsoria_usuario_impresora`
--

CREATE TABLE IF NOT EXISTS `jsoria_usuario_impresora` (
  `id_cajera` int(11) NOT NULL,
  `tipo_impresora` varchar(20) DEFAULT NULL,
  `nombre_impresora` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_cajera`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `jsoria_usuario_impresora`
--

INSERT INTO `jsoria_usuario_impresora` (`id_cajera`, `tipo_impresora`, `nombre_impresora`) VALUES
(7, 'matricial', '//localhost/Matricial');

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
