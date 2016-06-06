-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 06-06-2016 a las 02:19:11
-- Versión del servidor: 5.6.26
-- Versión de PHP: 5.6.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `jsoria_dbmngmt`
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
  `estado` char(1) NOT NULL DEFAULT '0' COMMENT 'El estado del alumno es 0 para no matriculado y 1 para matriculado',
  `id_grado` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `jsoria_alumno`
--

INSERT INTO `jsoria_alumno` (`nro_documento`, `tipo_documento`, `nombres`, `apellidos`, `estado`, `id_grado`) VALUES
('01010101', 'DNI', 'Raul', 'Toguchi Manta', '0', NULL),
('09090909', 'DNI', 'Jorge', 'Pacheco Lima', '0', NULL),
('11111111', 'DNI', 'carlos', 'cabrera cabrera', '1', 31),
('12121212', 'DNI', 'Hermenegildo', 'Soto Pajoy', '1', 1),
('12345678', 'DNI', 'Rosana', 'Quispe Lopez', '1', 1),
('15432112', 'DNI', 'Micaela', 'Paz Zapata', '1', 2),
('22222222', 'DNI', 'gabriela', 'cordova villar', '1', 4),
('23456543', 'DNI', 'maria', 'gomez flores', '1', 11),
('23456654', 'DNI', 'Miliquiades', 'Keiko Florian', '1', 8),
('23456787', 'DNI', 'Aniseto', 'Quispe Palomino', '1', 6),
('23456789', 'DNI', 'Sol', 'Galarreta Castro', '1', 7),
('23498755', 'DNI', 'Pancho', 'Vila de las Pelotas', '1', 13),
('24876756', 'DNI', 'Rodrigo', 'Meza Castro', '0', NULL),
('32143222', 'DNI', 'Pablo', 'Pinto Paredes ', '0', NULL),
('33333333', 'DNI', 'micaela', 'marques peralta', '1', 1),
('33456789', 'DNI', 'rupertina', 'carrasco farfan', '0', NULL),
('34567976', 'DNI', 'Roberto', 'Ramos Peralta', '1', 13),
('44444444', 'DNI', 'Kamila', 'Ojeda Galvan', '0', NULL),
('44556677', 'DNI', 'Jose ', 'Galvez Peralta', '1', 13),
('45454545', 'DNI', 'Jessica', 'Velarde Maruri', '0', NULL),
('55555555', 'DNI', 'Gaby', 'Gutierrez Guzman', '1', 67),
('56473288', 'DNI', 'Romero', 'Romero Ramires', '0', NULL),
('65434567', 'DNI', 'pedro', 'martines castillo', '1', 16),
('66666666', 'DNI', 'Alexandra Rocio', 'Guzman Olivera', '1', 2),
('67876545', 'DNI', 'Carolina', 'Carrasco Verde', '0', NULL),
('72626272', 'DNI', 'Maximo', 'Romero Uchuya', '1', 1),
('82828282', 'DNI', 'Susana', 'Campos Zapata', '0', NULL),
('87654332', 'DNI', 'Eustaquio', 'Flores Yucra', '0', NULL),
('87656787', 'DNI', 'carol', 'dias caceres', '0', NULL),
('87678987', 'DNI', 'toribio', 'umeres ramos', '0', NULL),
('88393902', 'DNI', 'Jessi', 'Castro Galarreta', '0', NULL),
('92187287', 'DNI', 'Katerine', 'Perez Condemayta', '0', NULL),
('98765456', 'DNI', 'delia', 'morales morales', '0', NULL),
('99612345', 'DNI', 'Pocoyo', 'Pato Elefante', '0', NULL),
('99999999', 'DNI', 'Santiago', 'Mendoza Paredes', '1', 2),
('CE-6685902203938', 'CARNET DE EXTRANJERIA', 'Robert', 'Washinton ', '0', NULL),
('CN-11234', 'CARNET DE EXTRANJERIA', 'Bill', 'Mora', '0', NULL),
('PN-012222', 'PARTIDA DE NACIMIENTO', 'juan', 'gabriel', '0', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jsoria_autorizacion`
--

CREATE TABLE IF NOT EXISTS `jsoria_autorizacion` (
  `id` int(11) NOT NULL,
  `rd` varchar(20) NOT NULL,
  `estado` char(1) DEFAULT NULL,
  `id_alumno` varchar(30) NOT NULL,
  `fecha_limite` date DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `jsoria_autorizacion`
--

INSERT INTO `jsoria_autorizacion` (`id`, `rd`, `estado`, `id_alumno`, `fecha_limite`) VALUES
(1, 'RD-345', '0', '11111111', '2016-02-19'),
(2, 'RD-345', '0', '11111111', '2016-02-19'),
(3, 'RD-348', '0', '11111111', '2016-02-21'),
(4, 'RD-349', '0', '11111111', '2016-02-27'),
(5, 'RD-341', '0', '22222222', '2016-02-26'),
(6, 'RD-347', '0', '22222222', '2016-02-26'),
(7, 'RD-395', '0', '22222222', '2016-02-28'),
(8, 'RD-0002', '0', '44444444', '2016-03-31');

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
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `jsoria_balance`
--

INSERT INTO `jsoria_balance` (`id`, `fecha`, `id_tesorera`, `ingresos`, `egresos`) VALUES
(1, '2016-04-06', 13, '100.00', '0.00'),
(2, '2016-04-07', 13, '8361.60', '0.00'),
(3, '2016-04-21', 7, '203.00', '0.00'),
(4, '2016-04-21', 13, '8571.60', '0.00'),
(5, '2016-04-21', 15, '2525.00', '0.00'),
(6, '2016-04-22', 13, '8571.60', '12.00'),
(7, '2016-04-23', 13, '8559.60', '85.00'),
(8, '2016-04-30', 13, '8474.60', '111.00'),
(9, '2016-05-01', 13, '8363.60', '123.00'),
(10, '2016-05-14', 13, '8737.60', '120.00'),
(11, '2016-05-28', 13, '8637.60', '1600.00'),
(12, '2016-05-29', 13, '7237.60', '257.40'),
(13, '2016-06-05', 13, '7280.20', '305.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jsoria_categoria`
--

CREATE TABLE IF NOT EXISTS `jsoria_categoria` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `monto` decimal(8,2) DEFAULT NULL,
  `tipo` varchar(30) NOT NULL,
  `estado` char(1) DEFAULT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_fin` date DEFAULT NULL,
  `destino` char(1) DEFAULT '0',
  `id_detalle_institucion` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=336 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `jsoria_categoria`
--

INSERT INTO `jsoria_categoria` (`id`, `nombre`, `monto`, `tipo`, `estado`, `fecha_inicio`, `fecha_fin`, `destino`, `id_detalle_institucion`) VALUES
(6, 'Matrícula Ciclo 2016-I', '100.00', 'matricula', '0', '2016-02-28', '2016-05-27', '0', 6),
(7, 'Matrícula Ciclo 2016-I', '100.00', 'matricula', '0', '2016-02-28', '2016-05-27', '0', 8),
(8, 'Matrícula Ciclo 2016-I', '100.00', 'matricula', '1', '2016-02-28', '2016-05-27', '0', 7),
(9, 'Matrícula Ciclo 2016-I', '100.00', 'matricula', '1', '2016-02-28', '2016-05-27', '0', 9),
(10, 'Matrícula Ciclo 2016-I', '100.00', 'matricula', '1', '2016-02-28', '2016-05-27', '0', 10),
(11, 'Matrícula Ciclo 2016-I', '100.00', 'matricula', '1', '2016-02-28', '2016-05-27', '0', 11),
(12, 'Matrícula Ciclo 2016-I', '100.00', 'matricula', '1', '2016-02-28', '2016-05-27', '0', 12),
(13, 'Matrícula Semestre 2016-I', '100.00', 'matricula', '1', '2016-02-28', '2016-05-27', '0', 13),
(14, 'Matrícula Semestre 2016-I', '100.00', 'matricula', '1', '2016-02-28', '2016-05-27', '0', 15),
(15, 'Matrícula Semestre 2016-I', '100.00', 'matricula', '1', '2016-02-28', '2016-05-27', '0', 14),
(16, 'Matrícula Semestre 2016-I', '100.00', 'matricula', '1', '2016-02-28', '2016-05-27', '0', 17),
(17, 'Matrícula Semestre 2016-I', '100.00', 'matricula', '1', '2016-02-28', '2016-05-27', '0', 16),
(18, 'Matrícula Colegio Año 2016', '220.00', 'matricula', '1', '2016-03-01', '2016-12-09', '0', 1),
(19, 'Matrícula Colegio Año 2016', '220.00', 'matricula', '1', '2016-03-01', '2016-12-09', '0', 3),
(20, 'Matrícula Colegio Año 2016', '150.00', 'matricula', '1', '2016-03-01', '2016-12-09', '0', 2),
(21, 'Matrícula 2016-II', '100.00', 'matricula', '1', '2016-08-01', '2016-11-25', '0', 13),
(22, 'Matrícula 2016-II', '100.00', 'matricula', '1', '2016-08-01', '2016-11-25', '0', 14),
(23, 'Matrícula 2016-II', '100.00', 'matricula', '1', '2016-08-01', '2016-11-25', '0', 17),
(24, 'Matrícula 2016-II', '100.00', 'matricula', '1', '2016-08-01', '2016-11-25', '0', 16),
(25, 'Matrícula 2016-II', '100.00', 'matricula', '1', '2016-08-01', '2016-11-25', '0', 15),
(26, 'Matrícula 2016-II', '100.00', 'matricula', '1', '2016-08-01', '2016-11-25', '0', 13),
(27, 'Matrícula 2016-II', '100.00', 'matricula', '1', '2016-08-01', '2016-11-25', '0', 14),
(28, 'Matrícula 2016-II', '100.00', 'matricula', '1', '2016-08-01', '2016-11-25', '0', 15),
(29, 'Matrícula 2016-II', '100.00', 'matricula', '1', '2016-08-01', '2016-11-25', '0', 16),
(30, 'Matrícula 2016-II', '100.00', 'matricula', '1', '2016-08-01', '2016-11-25', '0', 17),
(31, 'Matrícula 2016-II', '100.00', 'matricula', '0', '2016-06-15', '2016-10-11', '0', 6),
(32, 'Matrícula 2016-II', '100.00', 'matricula', '1', '2016-06-15', '2016-10-11', '0', 9),
(33, 'Matrícula 2016-II', '100.00', 'matricula', '0', '2016-06-15', '2016-10-11', '0', 8),
(34, 'Matrícula 2016-II', '100.00', 'matricula', '0', '2016-06-15', '2016-10-11', '0', 7),
(35, 'Matrícula 2016-II', '100.00', 'matricula', '1', '2016-06-15', '2016-10-11', '0', 11),
(36, 'Matrícula 2016-II', '100.00', 'matricula', '1', '2016-06-15', '2016-10-11', '0', 10),
(37, 'Matrícula 2016-II', '100.00', 'matricula', '1', '2016-06-15', '2016-10-11', '0', 12),
(38, 'Matrícula 2016-II', '100.00', 'matricula', '0', '2016-06-15', '2016-10-11', '0', 6),
(39, 'Matrícula 2016-II', '100.00', 'matricula', '0', '2016-06-15', '2016-10-11', '0', 7),
(40, 'Matrícula 2016-II', '100.00', 'matricula', '1', '2016-06-15', '2016-10-11', '0', 8),
(41, 'Matrícula 2016-II', '100.00', 'matricula', '1', '2016-06-15', '2016-10-11', '0', 9),
(42, 'Matrícula 2016-II', '100.00', 'matricula', '1', '2016-06-15', '2016-10-11', '0', 10),
(43, 'Matrícula 2016-II', '100.00', 'matricula', '1', '2016-06-15', '2016-10-11', '0', 11),
(44, 'Matrícula 2016-II', '100.00', 'matricula', '1', '2016-06-15', '2016-10-11', '0', 12),
(45, 'Matrícula 2015', '100.00', 'matricula', '0', '2015-03-09', '2015-12-04', '0', 1),
(46, 'Matrícula 2015', '120.00', 'matricula', '0', '2015-03-09', '2015-12-04', '0', 3),
(47, 'Matrícula 2015', '110.00', 'matricula', '0', '2015-03-09', '2015-12-04', '0', 2),
(48, 'Matrícula', '200.00', 'matricula', '1', '2015-10-04', '2015-10-30', '0', 4),
(49, 'Matrícula', '220.00', 'matricula', '1', '2015-10-04', '2015-10-30', '0', 5),
(50, 'Matricula Prueba', '100.00', 'matricula', '0', '2016-02-29', '2016-04-29', '0', 6),
(51, 'Matricula Prueba', '100.00', 'matricula', '0', '2016-02-29', '2016-04-29', '0', 7),
(52, 'Matricula Prueba', '100.00', 'matricula', '0', '2016-02-29', '2016-04-29', '0', 9),
(53, 'Matricula Prueba', '110.00', 'matricula', '0', '2016-02-29', '2016-04-29', '0', 8),
(54, 'Matricula Prueba', '100.00', 'matricula', '0', '2016-02-29', '2016-04-29', '0', 11),
(55, 'Matricula Prueba', '100.00', 'matricula', '0', '2016-02-29', '2016-04-29', '0', 10),
(56, 'Matricula Prueba', '130.00', 'matricula', '0', '2016-02-29', '2016-04-29', '0', 12),
(57, 'Pension Marzo 2016', '150.00', 'pension', '1', '2016-03-01', '2016-03-31', '0', 6),
(58, 'Pension Marzo 2016', '100.00', 'pension', '1', '2016-03-01', '2016-03-28', '0', 8),
(59, 'Pension Marzo 2016', '110.00', 'pension', '1', '2016-03-01', '2016-03-28', '0', 7),
(60, 'Pension Marzo 2016', '100.00', 'pension', '1', '2016-03-01', '2016-03-28', '0', 10),
(61, 'Pension Marzo 2016', '110.00', 'pension', '1', '2016-03-01', '2016-03-28', '0', 9),
(62, 'Pension Marzo 2016', '110.00', 'pension', '1', '2016-03-01', '2016-03-28', '0', 11),
(63, 'Pension Marzo 2016', '150.00', 'pension', '1', '2016-03-01', '2016-03-28', '0', 12),
(64, 'Pension Abril 2016', '100.00', 'pension', '1', '2016-04-01', '2016-04-28', '0', 6),
(65, 'Pension Abril 2016', '110.00', 'pension', '1', '2016-04-01', '2016-04-28', '0', 7),
(66, 'Pension Abril 2016', '100.00', 'pension', '1', '2016-04-01', '2016-04-28', '0', 8),
(67, 'Pension Abril 2016', '110.00', 'pension', '1', '2016-04-01', '2016-04-28', '0', 9),
(68, 'Pension Abril 2016', '100.00', 'pension', '1', '2016-04-01', '2016-04-28', '0', 10),
(69, 'Pension Abril 2016', '110.00', 'pension', '1', '2016-04-01', '2016-04-28', '0', 11),
(70, 'Pension Abril 2016', '100.00', 'pension', '1', '2016-04-01', '2016-04-28', '0', 12),
(71, 'Pension Mayo 2016', '100.00', 'pension', '1', '2016-05-01', '2016-05-28', '0', 6),
(72, 'Pension Mayo 2016', '110.00', 'pension', '1', '2016-05-01', '2016-05-28', '0', 7),
(73, 'Pension Mayo 2016', '100.00', 'pension', '1', '2016-05-01', '2016-05-28', '0', 8),
(74, 'Pension Mayo 2016', '110.00', 'pension', '1', '2016-05-01', '2016-05-28', '0', 9),
(75, 'Pension Mayo 2016', '100.00', 'pension', '1', '2016-05-01', '2016-05-28', '0', 10),
(76, 'Pension Mayo 2016', '110.00', 'pension', '1', '2016-05-01', '2016-05-28', '0', 11),
(77, 'Pension Mayo 2016', '100.00', 'pension', '1', '2016-05-01', '2016-05-28', '0', 12),
(78, 'Pension Junio 2016', '100.00', 'pension', '1', '2016-06-01', '2016-06-28', '0', 6),
(79, 'Pension Junio 2016', '110.00', 'pension', '1', '2016-06-01', '2016-06-28', '0', 7),
(80, 'Pension Junio 2016', '100.00', 'pension', '1', '2016-06-01', '2016-06-28', '0', 8),
(81, 'Pension Junio 2016', '110.00', 'pension', '1', '2016-06-01', '2016-06-28', '0', 9),
(82, 'Pension Junio 2016', '100.00', 'pension', '1', '2016-06-01', '2016-06-28', '0', 10),
(83, 'Pension Junio 2016', '110.00', 'pension', '1', '2016-06-01', '2016-06-28', '0', 11),
(84, 'Pension Junio 2016', '100.00', 'pension', '1', '2016-06-01', '2016-06-28', '0', 12),
(85, 'Pension Noviembre 2016', '100.00', 'pension', '1', '2016-11-01', '2016-11-30', '0', 13),
(86, 'Pension Noviembre 2016', '110.00', 'pension', '1', '2016-11-01', '2016-11-28', '0', 14),
(87, 'Pension Noviembre 2016', '110.00', 'pension', '1', '2016-11-01', '2016-11-28', '0', 16),
(88, 'Pension Noviembre 2016', '100.00', 'pension', '1', '2016-11-01', '2016-11-28', '0', 15),
(89, 'Pension Noviembre 2016', '100.00', 'pension', '1', '2016-11-01', '2016-11-28', '0', 17),
(90, 'Pension Diciembre 2016', '100.00', 'pension', '1', '2016-12-01', '2016-12-31', '0', 13),
(91, 'Pension Diciembre 2016', '110.00', 'pension', '1', '2016-12-01', '2016-12-28', '0', 14),
(92, 'Pension Diciembre 2016', '100.00', 'pension', '1', '2016-12-01', '2016-12-28', '0', 15),
(93, 'Pension Diciembre 2016', '110.00', 'pension', '1', '2016-12-01', '2016-12-28', '0', 16),
(94, 'Pension Diciembre 2016', '100.00', 'pension', '1', '2016-12-01', '2016-12-28', '0', 17),
(95, 'Pension Enero 2017', '100.00', 'pension', '1', '2017-01-01', '2017-01-31', '0', 13),
(96, 'Pension Enero 2017', '110.00', 'pension', '1', '2017-01-01', '2017-01-28', '0', 14),
(97, 'Pension Enero 2017', '100.00', 'pension', '1', '2017-01-01', '2017-01-28', '0', 15),
(98, 'Pension Enero 2017', '110.00', 'pension', '1', '2017-01-01', '2017-01-28', '0', 16),
(99, 'Pension Enero 2017', '200.00', 'pension', '1', '2017-01-01', '2017-01-28', '0', 17),
(100, 'Pension Febrero 2017', '100.00', 'pension', '1', '2017-02-01', '2017-02-28', '0', 13),
(101, 'Pension Febrero 2017', '110.00', 'pension', '1', '2017-02-01', '2017-02-28', '0', 14),
(102, 'Pension Febrero 2017', '100.00', 'pension', '1', '2017-02-01', '2017-02-28', '0', 15),
(103, 'Pension Febrero 2017', '110.00', 'pension', '1', '2017-02-01', '2017-02-28', '0', 16),
(104, 'Pension Febrero 2017', '100.00', 'pension', '1', '2017-02-01', '2017-02-28', '0', 17),
(105, 'Pension Marzo 2017', '100.00', 'pension', '1', '2017-03-01', '2017-03-31', '0', 13),
(106, 'Pension Marzo 2017', '110.00', 'pension', '1', '2017-03-01', '2017-03-28', '0', 14),
(107, 'Pension Marzo 2017', '100.00', 'pension', '1', '2017-03-01', '2017-03-28', '0', 15),
(108, 'Pension Marzo 2017', '110.00', 'pension', '1', '2017-03-01', '2017-03-28', '0', 16),
(109, 'Pension Marzo 2017', '100.00', 'pension', '1', '2017-03-01', '2017-03-28', '0', 17),
(110, 'Pension Marzo 2016', '190.00', 'pension', '1', '2016-03-01', '2016-03-28', '0', 1),
(111, 'Pension Marzo 2016', '100.00', 'pension', '1', '2016-03-01', '2016-03-28', '0', 3),
(112, 'Pension Marzo 2016', '100.00', 'pension', '1', '2016-03-01', '2016-03-28', '0', 2),
(113, 'Pension Abril 2016', '190.00', 'pension', '1', '2016-04-01', '2016-04-28', '0', 1),
(114, 'Pension Abril 2016', '100.00', 'pension', '1', '2016-04-01', '2016-04-28', '0', 2),
(115, 'Pension Abril 2016', '100.00', 'pension', '1', '2016-04-01', '2016-04-28', '0', 3),
(116, 'Pension Mayo 2016', '200.00', 'pension', '1', '2016-05-01', '2016-05-28', '0', 1),
(117, 'Pension Mayo 2016', '100.00', 'pension', '1', '2016-05-01', '2016-05-28', '0', 2),
(118, 'Pension Mayo 2016', '100.00', 'pension', '1', '2016-05-01', '2016-05-28', '0', 3),
(119, 'Pension Junio 2016', '100.00', 'pension', '1', '2016-06-01', '2016-06-28', '0', 1),
(120, 'Pension Junio 2016', '100.00', 'pension', '1', '2016-06-01', '2016-06-28', '0', 2),
(121, 'Pension Junio 2016', '100.00', 'pension', '1', '2016-06-01', '2016-06-28', '0', 3),
(122, 'Pension Julio 2016', '100.00', 'pension', '1', '2016-07-01', '2016-07-28', '0', 1),
(123, 'Pension Julio 2016', '100.00', 'pension', '1', '2016-07-01', '2016-07-28', '0', 2),
(124, 'Pension Julio 2016', '100.00', 'pension', '1', '2016-07-01', '2016-07-28', '0', 3),
(125, 'Pension Agosto 2016', '100.00', 'pension', '1', '2016-08-01', '2016-08-28', '0', 1),
(126, 'Pension Agosto 2016', '100.00', 'pension', '1', '2016-08-01', '2016-08-28', '0', 2),
(127, 'Pension Agosto 2016', '100.00', 'pension', '1', '2016-08-01', '2016-08-28', '0', 3),
(128, 'Pension Septiembre 2016', '100.00', 'pension', '1', '2016-09-01', '2016-09-28', '0', 1),
(129, 'Pension Septiembre 2016', '100.00', 'pension', '1', '2016-09-01', '2016-09-28', '0', 2),
(130, 'Pension Septiembre 2016', '100.00', 'pension', '1', '2016-09-01', '2016-09-28', '0', 3),
(131, 'Pension Octubre 2016', '100.00', 'pension', '1', '2016-10-01', '2016-10-28', '0', 1),
(132, 'Pension Octubre 2016', '100.00', 'pension', '1', '2016-10-01', '2016-10-28', '0', 2),
(133, 'Pension Octubre 2016', '100.00', 'pension', '1', '2016-10-01', '2016-10-28', '0', 3),
(134, 'Pension Noviembre 2016', '100.00', 'pension', '1', '2016-11-01', '2016-11-28', '0', 1),
(135, 'Pension Noviembre 2016', '100.00', 'pension', '1', '2016-11-01', '2016-11-28', '0', 2),
(136, 'Pension Noviembre 2016', '100.00', 'pension', '1', '2016-11-01', '2016-11-28', '0', 3),
(137, 'Pension Diciembre 2016', '150.00', 'pension', '1', '2016-12-01', '2016-12-28', '0', 1),
(138, 'Pension Diciembre 2016', '100.00', 'pension', '1', '2016-12-01', '2016-12-28', '0', 2),
(139, 'Pension Diciembre 2016', '100.00', 'pension', '1', '2016-12-01', '2016-12-28', '0', 3),
(140, 'Pension Febrero 2016', '100.00', 'pension', '1', '2016-02-01', '2016-02-28', '0', 4),
(141, 'Pension Marzo 2016', '100.00', 'pension', '1', '2016-03-01', '2016-03-28', '0', 4),
(142, 'Pension Febrero 2016', '100.00', 'pension', '1', '2016-02-01', '2016-02-28', '0', 5),
(143, 'Pension Abril 2016', '100.00', 'pension', '1', '2016-04-01', '2016-04-28', '0', 4),
(144, 'Pension Marzo 2016', '100.00', 'pension', '1', '2016-03-01', '2016-03-28', '0', 5),
(145, 'Pension Abril 2016', '100.00', 'pension', '1', '2016-04-01', '2016-04-28', '0', 5),
(146, 'Pension Mayo 2016', '100.00', 'pension', '1', '2016-05-01', '2016-05-28', '0', 4),
(147, 'Pension Mayo 2016', '100.00', 'pension', '1', '2016-05-01', '2016-05-28', '0', 5),
(148, 'Pension Junio 2016', '100.00', 'pension', '1', '2016-06-01', '2016-06-28', '0', 4),
(149, 'Pension Junio 2016', '100.00', 'pension', '1', '2016-06-01', '2016-06-28', '0', 5),
(150, 'Pension Julio 2016', '100.00', 'pension', '1', '2016-07-01', '2016-07-28', '0', 4),
(151, 'Pension Julio 2016', '100.00', 'pension', '1', '2016-07-01', '2016-07-28', '0', 5),
(152, 'Pension Agosto 2016', '100.00', 'pension', '1', '2016-08-01', '2016-08-28', '0', 4),
(153, 'Pension Agosto 2016', '100.00', 'pension', '1', '2016-08-01', '2016-08-28', '0', 5),
(154, 'Pension Septiembre 2016', '100.00', 'pension', '1', '2016-09-01', '2016-09-28', '0', 4),
(155, 'Pension Septiembre 2016', '100.00', 'pension', '1', '2016-09-01', '2016-09-28', '0', 5),
(156, 'Matrícula 2019-I', '200.00', 'matricula', '1', '2019-01-07', '2019-05-15', '0', 13),
(157, 'Matrícula 2019-I', '120.00', 'matricula', '1', '2019-01-07', '2019-05-15', '0', 14),
(158, 'Matrícula 2019-I', '130.00', 'matricula', '1', '2019-01-07', '2019-05-15', '0', 15),
(159, 'Matrícula 2019-I', '170.00', 'matricula', '1', '2019-01-07', '2019-05-15', '0', 17),
(160, 'Matrícula 2019-I', '150.00', 'matricula', '1', '2019-01-07', '2019-05-15', '0', 16),
(161, 'Pension Marzo 2017', '100.00', 'pension', '1', '2017-03-01', '2017-03-28', '0', 1),
(162, 'Pension Abril 2017', '100.00', 'pension', '1', '2017-04-01', '2017-04-28', '0', 1),
(163, 'Pension Marzo 2017', '110.00', 'pension', '1', '2017-03-01', '2017-03-28', '0', 2),
(164, 'Pension Marzo 2017', '120.00', 'pension', '1', '2017-03-01', '2017-03-28', '0', 3),
(165, 'Pension Abril 2017', '120.00', 'pension', '1', '2017-04-01', '2017-04-28', '0', 3),
(166, 'Pension Abril 2017', '110.00', 'pension', '1', '2017-04-01', '2017-04-28', '0', 2),
(167, 'Pension Mayo 2017', '100.00', 'pension', '1', '2017-05-01', '2017-05-28', '0', 1),
(168, 'Pension Mayo 2017', '110.00', 'pension', '1', '2017-05-01', '2017-05-28', '0', 2),
(169, 'Pension Mayo 2017', '120.00', 'pension', '1', '2017-05-01', '2017-05-28', '0', 3),
(170, 'Pension Junio 2017', '100.00', 'pension', '1', '2017-06-01', '2017-06-28', '0', 1),
(171, 'Pension Junio 2017', '110.00', 'pension', '1', '2017-06-01', '2017-06-28', '0', 2),
(172, 'Pension Junio 2017', '120.00', 'pension', '1', '2017-06-01', '2017-06-28', '0', 3),
(173, 'Pension Julio 2017', '200.00', 'pension', '1', '2017-07-01', '2017-07-28', '0', 1),
(174, 'Pension Julio 2017', '110.00', 'pension', '1', '2017-07-01', '2017-07-28', '0', 2),
(175, 'Pension Julio 2017', '120.00', 'pension', '1', '2017-07-01', '2017-07-28', '0', 3),
(176, 'Pension Agosto 2017', '100.00', 'pension', '1', '2017-08-01', '2017-08-28', '0', 1),
(177, 'Pension Agosto 2017', '110.00', 'pension', '1', '2017-08-01', '2017-08-28', '0', 2),
(178, 'Pension Agosto 2017', '120.00', 'pension', '1', '2017-08-01', '2017-08-28', '0', 3),
(179, 'Pension Septiembre 2017', '100.00', 'pension', '1', '2017-09-01', '2017-09-28', '0', 1),
(180, 'Pension Septiembre 2017', '110.00', 'pension', '1', '2017-09-01', '2017-09-28', '0', 2),
(181, 'Pension Septiembre 2017', '120.00', 'pension', '1', '2017-09-01', '2017-09-28', '0', 3),
(182, 'Pension Octubre 2017', '100.00', 'pension', '1', '2017-10-01', '2017-10-28', '0', 1),
(183, 'Pension Octubre 2017', '110.00', 'pension', '1', '2017-10-01', '2017-10-28', '0', 2),
(184, 'Pension Octubre 2017', '120.00', 'pension', '1', '2017-10-01', '2017-10-28', '0', 3),
(185, 'Pension Noviembre 2017', '100.00', 'pension', '1', '2017-11-01', '2017-11-28', '0', 1),
(186, 'Pension Noviembre 2017', '110.00', 'pension', '1', '2017-11-01', '2017-11-28', '0', 2),
(187, 'Pension Noviembre 2017', '120.00', 'pension', '1', '2017-11-01', '2017-11-28', '0', 3),
(188, 'Pension Diciembre 2017', '100.00', 'pension', '1', '2017-12-01', '2017-12-28', '0', 1),
(189, 'Pension Diciembre 2017', '110.00', 'pension', '1', '2017-12-01', '2017-12-28', '0', 2),
(190, 'Pension Diciembre 2017', '120.00', 'pension', '1', '2017-12-01', '2017-12-28', '0', 3),
(191, 'Matricula Regular', '110.00', 'matricula', '0', '2016-02-29', '2016-07-29', '0', 4),
(192, 'Matricula Regular', '110.00', 'matricula', '0', '2016-02-29', '2016-07-29', '0', 5),
(193, 'Matricula', '123.00', 'matricula', '0', '2016-02-21', '2016-03-11', '0', 4),
(194, 'Matricula', '122.00', 'matricula', '0', '2016-02-21', '2016-03-11', '0', 5),
(195, 'Pension Febrero 2016', '120.00', 'pension', '1', '2016-02-01', '2016-02-28', '0', 4),
(196, 'Pension Marzo 2016', '120.00', 'pension', '1', '2016-03-01', '2016-03-28', '0', 4),
(197, 'Pension Febrero 2016', '150.00', 'pension', '1', '2016-02-01', '2016-02-28', '0', 5),
(198, 'Pension Marzo 2016', '150.00', 'pension', '1', '2016-03-01', '2016-03-28', '0', 5),
(199, 'Pension Abril 2016', '120.00', 'pension', '1', '2016-04-01', '2016-04-28', '0', 4),
(200, 'Pension Abril 2016', '150.00', 'pension', '1', '2016-04-01', '2016-04-28', '0', 5),
(201, 'Pension Mayo 2016', '120.00', 'pension', '1', '2016-05-01', '2016-05-28', '0', 4),
(202, 'Pension Mayo 2016', '150.00', 'pension', '1', '2016-05-01', '2016-05-28', '0', 5),
(203, 'Pension Junio 2016', '120.00', 'pension', '1', '2016-06-01', '2016-06-28', '0', 4),
(204, 'Pension Junio 2016', '150.00', 'pension', '1', '2016-06-01', '2016-06-28', '0', 5),
(205, 'Pension Julio 2016', '120.00', 'pension', '1', '2016-07-01', '2016-07-28', '0', 4),
(206, 'Pension Julio 2016', '150.00', 'pension', '1', '2016-07-01', '2016-07-28', '0', 5),
(207, 'Pension Agosto 2016', '120.00', 'pension', '1', '2016-08-01', '2016-08-28', '0', 4),
(208, 'Pension Agosto 2016', '150.00', 'pension', '1', '2016-08-01', '2016-08-28', '0', 5),
(209, 'Pension Septiembre 2016', '120.00', 'pension', '1', '2016-09-01', '2016-09-28', '0', 4),
(210, 'Pension Septiembre 2016', '150.00', 'pension', '1', '2016-09-01', '2016-09-28', '0', 5),
(211, 'Pension Octubre 2016', '120.00', 'pension', '1', '2016-10-01', '2016-10-28', '0', 4),
(212, 'Pension Octubre 2016', '150.00', 'pension', '1', '2016-10-01', '2016-10-28', '0', 5),
(213, 'Desfile Cusco Inicial ', '35.00', 'actividad', '1', NULL, NULL, '0', 1),
(214, 'Desfile', '100.00', 'actividad', '1', NULL, NULL, '0', 2),
(215, 'Desfile', '100.00', 'actividad', '1', NULL, NULL, '0', 3),
(216, 'Desfile Fin de Año', '30.00', 'actividad', '1', NULL, NULL, '0', 1),
(217, 'Desfile', '100.00', 'actividad', '1', NULL, NULL, '0', 4),
(218, 'Desfile', '100.00', 'actividad', '1', NULL, NULL, '0', 5),
(219, 'desfile', '120.00', 'actividad', '1', NULL, NULL, '0', 4),
(220, 'desfile', '120.00', 'actividad', '1', NULL, NULL, '0', 5),
(221, 'Danza', '20.00', 'actividad', '1', NULL, NULL, '0', 3),
(222, 'Danza QBBA', '25.00', 'actividad', '1', NULL, NULL, '0', 1),
(223, 'Danza QBBA', '10.00', 'actividad', '1', NULL, NULL, '0', 2),
(224, 'Danza QBBA', '10.00', 'actividad', '1', NULL, NULL, '0', 3),
(227, 'Certificado de estudios', '100.00', 'con_factor', '1', NULL, NULL, '1', 18),
(228, 'FUT', '1.50', 'sin_factor', '1', NULL, NULL, '1', 19),
(230, 'certificado de estudios', '2.00', 'con_factor', '1', NULL, NULL, '1', 19),
(231, 'Uniforme de Gala', '120.00', 'multiple', '1', NULL, NULL, '0', 18),
(232, 'Uniforme', '150.00', 'multiple', '1', NULL, NULL, '1', 21),
(233, 'Actuacion', '7.00', 'actividad', '1', NULL, NULL, '0', 4),
(234, 'Libro Prácticas', '55.00', 'sin_factor', '0', NULL, NULL, '0', 20),
(235, 'Certificado Estudios', '10.00', 'con_factor', '1', NULL, NULL, '1', 21),
(236, 'Campamento', '50.00', 'actividad', '1', NULL, NULL, '0', 2),
(237, 'Cobro Extraordinario', NULL, 'cobro_extraordinario', '1', NULL, NULL, '0', 18),
(238, 'Cobro Extraordinario', NULL, 'cobro_extraordinario', '1', NULL, NULL, '0', 19),
(239, 'Cobro Extraordinario', NULL, 'cobro_extraordinario', '1', NULL, NULL, '0', 20),
(240, 'Cobro Extraordinario', NULL, 'cobro_extraordinario', '1', NULL, NULL, '0', 21),
(241, 'Cobro Extraordinario', NULL, 'cobro_extraordinario', '1', NULL, NULL, '1', 18),
(242, 'Cobro Extraordinario', NULL, 'cobro_extraordinario', '1', NULL, NULL, '1', 19),
(243, 'Cobro Extraordinario', NULL, 'cobro_extraordinario', '1', NULL, NULL, '1', 20),
(244, 'Cobro Extraordinario', NULL, 'cobro_extraordinario', '1', NULL, NULL, '1', 21),
(245, 'Constancia', '200.00', 'multiple', '0', NULL, NULL, '1', 20),
(246, 'Admisión 2016-I', '150.00', 'multiple', '1', NULL, NULL, '0', 21),
(247, 'Pension Marzo 2016', '110.00', 'pension', '1', '2016-03-01', '2016-03-31', '0', 1),
(248, 'Pension Marzo 2016', '120.00', 'pension', '1', '2016-03-01', '2016-03-31', '0', 2),
(249, 'Pension Marzo 2016', '130.00', 'pension', '1', '2016-03-01', '2016-03-31', '0', 3),
(250, 'Pension Abril 2016', '110.00', 'pension', '1', '2016-04-01', '2016-04-30', '0', 1),
(251, 'Pension Abril 2016', '120.00', 'pension', '1', '2016-04-01', '2016-04-30', '0', 2),
(252, 'Pension Abril 2016', '130.00', 'pension', '1', '2016-04-01', '2016-04-30', '0', 3),
(253, 'Pension Marzo 2016', '150.00', 'pension', '1', '2016-03-01', '2016-03-31', '0', 4),
(254, 'Pension Abril 2016', '150.00', 'pension', '1', '2016-04-01', '2016-04-30', '0', 4),
(255, 'Pension Marzo 2016', '160.00', 'pension', '1', '2016-03-01', '2016-03-31', '0', 5),
(256, 'Pension Abril 2016', '160.00', 'pension', '1', '2016-04-01', '2016-04-30', '0', 5),
(257, 'Pension Noviembre 2016', '150.00', 'pension', '1', '2016-11-01', '2016-11-28', '0', 4),
(258, 'Pension Diciembre 2016', '150.00', 'pension', '1', '2016-12-01', '2016-12-28', '0', 4),
(259, 'Pension Noviembre 2016', '160.00', 'pension', '1', '2016-11-01', '2016-11-28', '0', 5),
(260, 'Pension Diciembre 2016', '160.00', 'pension', '1', '2016-12-01', '2016-12-28', '0', 5),
(261, 'Pension Enero 2017', '160.00', 'pension', '1', '2017-01-01', '2017-01-28', '0', 5),
(262, 'Pension Enero 2017', '150.00', 'pension', '1', '2017-01-01', '2017-01-28', '0', 4),
(263, 'Pension Febrero 2017', '150.00', 'pension', '1', '2017-02-01', '2017-02-28', '0', 4),
(264, 'Pension Febrero 2017', '160.00', 'pension', '1', '2017-02-01', '2017-02-28', '0', 5),
(265, 'Pension Marzo 2017', '150.00', 'pension', '1', '2017-03-01', '2017-03-28', '0', 4),
(266, 'Pension Marzo 2017', '160.00', 'pension', '1', '2017-03-01', '2017-03-28', '0', 5),
(267, 'Pension Junio 2016', '120.00', 'pension', '1', '2016-06-01', '2016-06-30', '0', 4),
(268, 'Pension Junio 2016', '130.00', 'pension', '1', '2016-06-01', '2016-06-30', '0', 5),
(269, 'Pension Julio 2016', '120.00', 'pension', '1', '2016-07-01', '2016-07-31', '0', 4),
(270, 'Pension Agosto 2016', '120.00', 'pension', '1', '2016-08-01', '2016-08-31', '0', 4),
(271, 'Pension Julio 2016', '130.00', 'pension', '1', '2016-07-01', '2016-07-31', '0', 5),
(272, 'Pension Agosto 2016', '130.00', 'pension', '1', '2016-08-01', '2016-08-31', '0', 5),
(273, 'Pension Diciembre 2016', '200.00', 'pension', '1', '2016-12-01', '2016-12-31', '0', 4),
(274, 'Pension Diciembre 2016', '250.00', 'pension', '1', '2016-12-01', '2016-12-31', '0', 5),
(275, 'Pension Enero 2017', '200.00', 'pension', '1', '2017-01-01', '2017-01-31', '0', 4),
(276, 'Pension Enero 2017', '250.00', 'pension', '1', '2017-01-01', '2017-01-31', '0', 5),
(277, 'Derecho de Grado', '400.00', 'sin_factor', '0', NULL, NULL, '0', 21),
(278, 'Toga y Birrete', '120.00', 'sin_factor', '1', NULL, NULL, '1', 20),
(279, 'DANZA FIESTAS', '30.00', 'actividad', '1', NULL, NULL, '0', 15),
(280, 'Matrícula 2016 Período I', '150.00', 'matricula', '1', '2016-03-01', '2016-07-31', '0', 4),
(281, 'Matrícula 2016 Período I', '170.00', 'matricula', '1', '2016-03-01', '2016-07-31', '0', 5),
(282, 'Matrícula Diferenciada 2016 Período I', '135.00', 'matricula', '1', '2016-03-01', '2016-07-31', '0', 4),
(283, 'Matrícula Diferenciada 2016 Período I', '150.00', 'matricula', '1', '2016-03-01', '2016-07-31', '0', 5),
(284, 'Pension Abril 2016', '120.00', 'pension', '1', '2016-04-01', '2016-04-30', '0', 13),
(285, 'Pension Abril 2016', '120.00', 'pension', '1', '2016-04-01', '2016-04-30', '0', 14),
(286, 'Pension Abril 2016', '120.00', 'pension', '1', '2016-04-01', '2016-04-30', '0', 15),
(287, 'Pension Abril 2016', '110.00', 'pension', '1', '2016-04-01', '2016-04-30', '0', 17),
(288, 'Pension Abril 2016', '130.00', 'pension', '1', '2016-04-01', '2016-04-30', '0', 16),
(289, 'Pension Mayo 2016', '120.00', 'pension', '1', '2016-05-01', '2016-05-31', '0', 13),
(290, 'Pension Mayo 2016', '120.00', 'pension', '1', '2016-05-01', '2016-05-31', '0', 14),
(291, 'Pension Mayo 2016', '120.00', 'pension', '1', '2016-05-01', '2016-05-31', '0', 15),
(292, 'Pension Mayo 2016', '130.00', 'pension', '1', '2016-05-01', '2016-05-31', '0', 16),
(293, 'Pension Mayo 2016', '110.00', 'pension', '1', '2016-05-01', '2016-05-31', '0', 17),
(294, 'Pension Junio 2016', '120.00', 'pension', '1', '2016-06-01', '2016-06-30', '0', 13),
(295, 'Pension Junio 2016', '120.00', 'pension', '1', '2016-06-01', '2016-06-30', '0', 14),
(296, 'Pension Junio 2016', '120.00', 'pension', '1', '2016-06-01', '2016-06-30', '0', 15),
(297, 'Pension Junio 2016', '130.00', 'pension', '1', '2016-06-01', '2016-06-30', '0', 16),
(298, 'Pension Junio 2016', '110.00', 'pension', '1', '2016-06-01', '2016-06-30', '0', 17),
(299, 'Pension Julio 2016', '120.00', 'pension', '1', '2016-07-01', '2016-07-31', '0', 13),
(300, 'Pension Julio 2016', '130.00', 'pension', '1', '2016-07-01', '2016-07-31', '0', 14),
(301, 'Pension Julio 2016', '120.00', 'pension', '1', '2016-07-01', '2016-07-31', '0', 15),
(302, 'Pension Julio 2016', '130.00', 'pension', '1', '2016-07-01', '2016-07-31', '0', 16),
(303, 'Pension Julio 2016', '110.00', 'pension', '1', '2016-07-01', '2016-07-31', '0', 17),
(304, 'Pension Agosto 2016', '120.00', 'pension', '1', '2016-08-01', '2016-08-31', '0', 13),
(305, 'Pension Agosto 2016', '115.00', 'pension', '1', '2016-08-01', '2016-08-31', '0', 14),
(306, 'Pension Agosto 2016', '120.00', 'pension', '1', '2016-08-01', '2016-08-31', '0', 15),
(307, 'Pension Agosto 2016', '130.00', 'pension', '1', '2016-08-01', '2016-08-31', '0', 16),
(308, 'Pension Agosto 2016', '110.00', 'pension', '1', '2016-08-01', '2016-08-31', '0', 17),
(309, 'Certificado de Estudios', '20.00', 'con_factor', '1', NULL, NULL, '0', 20),
(310, 'Agenda', '20.00', 'sin_factor', '0', NULL, NULL, '1', 18),
(311, 'Examen de Admisión', '200.00', 'multiple', '1', NULL, NULL, '0', 20),
(312, 'MATRICULA REGULAR 1', '250.00', 'matricula', '1', '2016-03-18', '2016-07-31', '0', 13),
(313, 'MATRICULA REGULAR 1', '250.00', 'matricula', '1', '2016-03-18', '2016-07-31', '0', 17),
(314, 'MATRICULA REGULAR 1', '250.00', 'matricula', '1', '2016-03-18', '2016-07-31', '0', 16),
(315, 'MATRICULA REGULAR 1', '250.00', 'matricula', '1', '2016-03-18', '2016-07-31', '0', 15),
(316, 'MATRICULA REGULAR 1', '250.00', 'matricula', '1', '2016-03-18', '2016-07-31', '0', 14),
(317, 'MATRICULA EXTEMPORANEA C1', '300.00', 'matricula', '1', '2016-03-01', '2016-07-31', '0', 13),
(318, 'MATRICULA EXTEMPORANEA C1', '300.00', 'matricula', '1', '2016-03-01', '2016-07-31', '0', 15),
(319, 'MATRICULA EXTEMPORANEA C1', '300.00', 'matricula', '1', '2016-03-01', '2016-07-31', '0', 14),
(320, 'MATRICULA EXTEMPORANEA C1', '300.00', 'matricula', '1', '2016-03-01', '2016-07-31', '0', 16),
(321, 'MATRICULA EXTEMPORANEA C1', '300.00', 'matricula', '1', '2016-03-01', '2016-07-31', '0', 17),
(322, 'MATRICULA REGULAR C2', '250.00', 'matricula', '1', '2016-03-01', '2016-07-31', '0', 13),
(323, 'MATRICULA REGULAR C2', '250.00', 'matricula', '1', '2016-03-01', '2016-07-31', '0', 15),
(324, 'MATRICULA REGULAR C2', '250.00', 'matricula', '1', '2016-03-01', '2016-07-31', '0', 14),
(325, 'MATRICULA REGULAR C2', '250.00', 'matricula', '1', '2016-03-01', '2016-07-31', '0', 17),
(326, 'MATRICULA REGULAR C2', '250.00', 'matricula', '1', '2016-03-01', '2016-07-31', '0', 16),
(327, 'MATRICULA EXTEMPORANEA C2', '300.00', 'matricula', '1', '2016-03-01', '2016-07-31', '0', 13),
(328, 'MATRICULA EXTEMPORANEA C2', '300.00', 'matricula', '1', '2016-03-01', '2016-07-31', '0', 15),
(329, 'MATRICULA EXTEMPORANEA C2', '300.00', 'matricula', '1', '2016-03-01', '2016-07-31', '0', 14),
(330, 'MATRICULA EXTEMPORANEA C2', '300.00', 'matricula', '1', '2016-03-01', '2016-07-31', '0', 17),
(331, 'MATRICULA EXTEMPORANEA C2', '300.00', 'matricula', '1', '2016-03-01', '2016-07-31', '0', 16),
(332, 'Examen Admisión 2016', '50.00', 'multiple', '1', NULL, NULL, '0', 18),
(333, 'Examen Admisión ULP 2016', '200.00', 'multiple', '1', NULL, NULL, '0', 21),
(334, 'Concurso Danzas Inicial', '10.00', 'actividad', '1', NULL, NULL, '0', 1),
(335, 'Examen Admisión Urusayhua 2016', '150.00', 'multiple', '0', NULL, NULL, '0', 20);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jsoria_comprobante`
--

CREATE TABLE IF NOT EXISTS `jsoria_comprobante` (
  `id` int(11) NOT NULL,
  `tipo` varchar(12) NOT NULL,
  `numero_comprobante` int(11) NOT NULL,
  `id_razon_social` char(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `jsoria_comprobante`
--

INSERT INTO `jsoria_comprobante` (`id`, `tipo`, `numero_comprobante`, `id_razon_social`) VALUES
(1, 'comprobante', 25, '1');

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

--
-- Volcado de datos para la tabla `jsoria_detalle_egreso`
--

INSERT INTO `jsoria_detalle_egreso` (`id_egreso`, `nro_detalle_egreso`, `id_rubro`, `monto`, `descripcion`) VALUES
(7, 1, 7, '1001.00', 'Carpetasx2'),
(7, 2, 5, '2020.00', 'Pizarrasx3'),
(8, 1, 3, '500.00', 'Personal Repintado'),
(8, 2, 2, '532.00', 'Proyector'),
(9, 1, 7, '9000.00', 'Implementos'),
(10, 1, 2, '450.00', 'Gastos Corrientes'),
(11, 1, 6, '12000.00', 'materiales'),
(11, 2, 16, '4500.00', 'complementos'),
(12, 1, 3, '4850.00', 'Computadorasx2'),
(13, 1, 7, '400.00', 'materiales'),
(14, 1, 18, '111.00', 'QUI COSA'),
(15, 1, 7, '120.00', 'mesa'),
(16, 1, 17, '123.00', 'suministros'),
(17, 1, 16, '12.00', 'reloj'),
(18, 1, 7, '88.00', 'resto a 100'),
(19, 1, 23, '20.00', 'pollo'),
(20, 1, 2, '65.00', 'mesa'),
(21, 1, 17, '111.00', 'otros'),
(22, 1, 19, '123.00', 'ffddf'),
(23, 1, 17, '100.00', 'gaseosas'),
(24, 1, 23, '20.00', 'jugo de papaya'),
(25, 1, 3, '1600.00', 'Computadora'),
(26, 1, 5, '172.40', 'Implementos'),
(27, 1, 2, '85.00', 'Limpieza'),
(28, 1, 5, '150.00', 'Insumos'),
(29, 1, 5, '130.00', 'Torta'),
(30, 1, 6, '25.00', 'estras');

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
  `estado_pago` char(1) DEFAULT '0',
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
  `id_cajera` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=329 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `jsoria_deuda_ingreso`
--

INSERT INTO `jsoria_deuda_ingreso` (`id`, `saldo`, `descuento`, `estado_pago`, `estado_retiro`, `estado_descuento`, `estado_fraccionam`, `cliente_extr`, `descripcion_extr`, `fecha_hora_ingreso`, `id_categoria`, `id_alumno`, `id_autorizacion`, `id_retiro`, `id_cajera`) VALUES
(1, 220.00, 0.00, '1', '1', '0', '0', NULL, NULL, '2016-03-19 07:28:51', 18, '12345678', NULL, 12, 17),
(2, 220.00, 0.00, '1', '1', '0', '0', NULL, NULL, '2016-03-19 07:27:11', 18, '12121212', NULL, 12, 17),
(3, 220.00, 0.00, '1', '2', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 19, '11111111', NULL, 10, 8),
(4, 100.00, 11.00, '1', '2', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 111, '11111111', NULL, 10, 8),
(5, 100.00, 11.00, '1', '2', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 115, '11111111', NULL, 10, 8),
(6, 100.00, 11.00, '1', '2', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 118, '11111111', NULL, 10, 8),
(7, 100.00, 11.00, '1', '2', '0', '0', NULL, NULL, '2016-03-18 10:34:23', 121, '11111111', NULL, 14, 8),
(8, 100.00, 11.00, '1', '2', '0', '0', NULL, NULL, '2016-03-18 09:07:00', 124, '11111111', NULL, 14, 8),
(9, 100.00, 11.00, '1', '2', '0', '0', NULL, NULL, '2016-03-18 09:07:00', 127, '11111111', NULL, 14, 8),
(10, 100.00, 11.00, '1', '2', '0', '0', NULL, NULL, '2016-03-18 09:06:01', 130, '11111111', NULL, 14, 8),
(11, 100.00, 11.00, '1', '2', '0', '0', NULL, NULL, '2016-03-18 09:03:33', 133, '11111111', NULL, 14, 8),
(12, 100.00, 11.00, '1', '2', '0', '0', NULL, NULL, '2016-03-18 09:03:33', 136, '11111111', NULL, 14, 8),
(13, 100.00, 11.00, '1', '2', '0', '0', NULL, NULL, '2016-03-18 09:06:01', 139, '11111111', NULL, 14, 8),
(14, 110.00, 0.00, '1', '2', '0', '0', NULL, NULL, '2016-03-18 06:58:14', 20, '22222222', NULL, 14, 8),
(15, 100.00, 0.00, '1', '2', '0', '0', NULL, NULL, '2016-03-18 06:59:01', 112, '22222222', NULL, 14, 8),
(16, 100.00, 0.00, '1', '2', '0', '0', NULL, NULL, '2016-03-18 13:25:04', 114, '22222222', NULL, 14, 8),
(17, 100.00, 0.00, '1', '2', '0', '0', NULL, NULL, '2016-03-18 20:45:39', 117, '22222222', NULL, 14, 8),
(18, 100.00, 0.00, '1', '2', '0', '0', NULL, NULL, '2016-03-18 20:46:08', 120, '22222222', NULL, 14, 8),
(19, 100.00, 0.00, '1', '2', '0', '0', NULL, NULL, '2016-03-18 20:58:11', 123, '22222222', NULL, 14, 8),
(20, 100.00, 0.00, '1', '2', '0', '0', NULL, NULL, '2016-03-18 22:53:02', 126, '22222222', NULL, 14, 8),
(21, 100.00, 0.00, '1', '2', '0', '0', NULL, NULL, '2016-03-18 13:24:20', 129, '22222222', NULL, 14, 8),
(22, 100.00, 0.00, '1', '2', '0', '0', NULL, NULL, '2016-04-07 21:31:14', 132, '22222222', NULL, 15, 8),
(23, 100.00, 0.00, '1', '2', '0', '0', NULL, NULL, '2016-03-18 10:42:28', 135, '22222222', NULL, 14, 8),
(24, 100.00, 0.00, '1', '2', '0', '0', NULL, NULL, '2016-03-18 10:42:28', 138, '22222222', NULL, 14, 8),
(25, 220.00, 0.00, '1', '2', '0', '0', NULL, NULL, '2016-03-19 05:26:32', 18, '33333333', NULL, 14, 8),
(26, 100.00, 0.00, '1', '2', '0', '0', NULL, NULL, '2016-03-19 05:38:54', 110, '33333333', NULL, 14, 8),
(27, 100.00, 0.00, '1', '2', '0', '0', NULL, NULL, '2016-03-19 05:25:48', 113, '33333333', NULL, 14, 8),
(28, 100.00, 0.00, '1', '2', '0', '0', NULL, NULL, '2016-03-19 05:08:19', 116, '33333333', NULL, 14, 8),
(29, 100.00, 0.00, '1', '2', '0', '0', NULL, NULL, '2016-03-19 05:15:09', 119, '33333333', NULL, 14, 8),
(30, 100.00, 0.00, '1', '1', '0', '0', NULL, NULL, '2016-03-19 05:06:13', 122, '33333333', NULL, 12, 17),
(31, 100.00, 0.00, '1', '1', '0', '0', NULL, NULL, '2016-03-19 04:37:41', 125, '33333333', NULL, 12, 17),
(32, 100.00, 0.00, '1', '1', '0', '0', NULL, NULL, '2016-03-19 04:35:07', 128, '33333333', NULL, 12, 17),
(33, 100.00, 0.00, '1', '2', '0', '0', NULL, NULL, '2016-03-19 00:04:21', 131, '33333333', NULL, 14, 8),
(34, 100.00, 0.00, '1', '2', '0', '0', NULL, NULL, '2016-03-18 23:58:17', 134, '33333333', NULL, 14, 8),
(35, 150.00, 0.00, '1', '1', '0', '0', NULL, NULL, '2016-03-18 23:54:53', 137, '33333333', NULL, 12, 17),
(36, 110.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 20, '15432112', NULL, NULL, 8),
(37, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 112, '15432112', NULL, NULL, 8),
(38, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 114, '15432112', NULL, NULL, 8),
(39, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 117, '15432112', NULL, NULL, 8),
(40, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 120, '15432112', NULL, NULL, 8),
(41, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 123, '15432112', NULL, NULL, 8),
(42, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 126, '15432112', NULL, NULL, 8),
(43, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 129, '15432112', NULL, NULL, 8),
(44, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 132, '15432112', NULL, NULL, 8),
(45, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 135, '15432112', NULL, NULL, 8),
(46, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 138, '15432112', NULL, NULL, 8),
(47, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 11, '23456543', NULL, NULL, 8),
(48, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 35, '23456543', NULL, NULL, 8),
(49, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 43, '23456543', NULL, NULL, 8),
(50, 110.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 62, '23456543', NULL, NULL, 8),
(51, 110.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 69, '23456543', NULL, NULL, 8),
(52, 110.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 76, '23456543', NULL, NULL, 8),
(53, 110.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 83, '23456543', NULL, NULL, 8),
(54, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 7, '23456654', NULL, NULL, 8),
(55, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 33, '23456654', NULL, NULL, 8),
(56, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 40, '23456654', NULL, NULL, 8),
(57, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 58, '23456654', NULL, NULL, 8),
(58, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 66, '23456654', NULL, NULL, 8),
(59, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 73, '23456654', NULL, NULL, 8),
(60, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 80, '23456654', NULL, NULL, 8),
(61, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 6, '23456787', NULL, NULL, 8),
(62, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 31, '23456787', NULL, NULL, 8),
(63, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 38, '23456787', NULL, NULL, 8),
(64, 150.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 57, '23456787', NULL, NULL, 8),
(65, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 64, '23456787', NULL, NULL, 8),
(66, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 71, '23456787', NULL, NULL, 8),
(67, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 78, '23456787', NULL, NULL, 8),
(68, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 8, '23456789', NULL, NULL, 8),
(69, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 34, '23456789', NULL, NULL, 8),
(70, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 39, '23456789', NULL, NULL, 8),
(71, 110.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 59, '23456789', NULL, NULL, 8),
(72, 110.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 65, '23456789', NULL, NULL, 8),
(73, 110.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 72, '23456789', NULL, NULL, 8),
(74, 110.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 79, '23456789', NULL, NULL, 8),
(75, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 13, '23498755', NULL, NULL, 8),
(76, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 21, '23498755', NULL, NULL, 8),
(77, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 26, '23498755', NULL, NULL, 8),
(78, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 85, '23498755', NULL, NULL, 8),
(79, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 90, '23498755', NULL, NULL, 8),
(80, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 95, '23498755', NULL, NULL, 8),
(81, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 100, '23498755', NULL, NULL, 8),
(82, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 105, '23498755', NULL, NULL, 8),
(83, 100.00, 0.00, '1', '2', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 17, '65434567', NULL, 13, 8),
(84, 100.00, 0.00, '1', '2', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 24, '65434567', NULL, 13, 8),
(85, 100.00, 0.00, '1', '2', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 29, '65434567', NULL, 13, 8),
(86, 110.00, 0.00, '1', '2', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 87, '65434567', NULL, 13, 8),
(87, 110.00, 0.00, '1', '2', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 93, '65434567', NULL, 13, 8),
(88, 110.00, 0.00, '1', '2', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 98, '65434567', NULL, 13, 8),
(89, 110.00, 0.00, '1', '2', '0', '0', NULL, NULL, '2016-03-18 06:38:47', 103, '65434567', NULL, 13, 8),
(90, 110.00, 0.00, '1', '2', '0', '0', NULL, NULL, '2016-03-18 06:47:32', 108, '65434567', NULL, 13, 8),
(91, 100.00, 0.00, '1', '2', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 17, '65434567', NULL, 13, 8),
(92, 100.00, 0.00, '1', '2', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 24, '65434567', NULL, 13, 8),
(93, 100.00, 0.00, '1', '2', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 29, '65434567', NULL, 13, 8),
(94, 110.00, 0.00, '1', '2', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 87, '65434567', NULL, 13, 8),
(95, 110.00, 0.00, '1', '2', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 93, '65434567', NULL, 13, 8),
(96, 110.00, 0.00, '1', '2', '0', '0', NULL, NULL, '2016-03-18 06:48:19', 98, '65434567', NULL, 13, 8),
(97, 110.00, 0.00, '1', '2', '0', '0', NULL, NULL, '2016-03-18 06:53:44', 103, '65434567', NULL, 13, 8),
(98, 110.00, 0.00, '1', '2', '0', '0', NULL, NULL, '2016-03-18 06:56:15', 108, '65434567', NULL, 13, 8),
(99, 110.00, 0.00, '1', '2', '0', '0', NULL, NULL, '2016-04-21 23:06:23', 20, '99999999', NULL, 17, 8),
(100, 100.00, 0.00, '1', '2', '0', '0', NULL, NULL, '2016-04-21 23:06:23', 112, '99999999', NULL, 17, 8),
(101, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 114, '99999999', NULL, NULL, 8),
(102, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 117, '99999999', NULL, NULL, 8),
(103, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 120, '99999999', NULL, NULL, 8),
(104, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 123, '99999999', NULL, NULL, 8),
(105, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 126, '99999999', NULL, NULL, 8),
(106, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 129, '99999999', NULL, NULL, 8),
(107, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 132, '99999999', NULL, NULL, 8),
(108, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 135, '99999999', NULL, NULL, 8),
(109, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 138, '99999999', NULL, NULL, 8),
(110, 220.00, 0.00, '1', '1', '0', '0', NULL, NULL, '2016-03-19 07:37:58', 18, '72626272', NULL, 12, 17),
(111, 100.00, 0.00, '1', '2', '0', '0', NULL, NULL, '2016-03-19 08:49:52', 110, '72626272', NULL, 14, 8),
(112, 100.00, 0.00, '1', '2', '0', '0', NULL, NULL, '2016-05-29 00:02:55', 113, '72626272', NULL, 22, 8),
(113, 100.00, 0.00, '1', '2', '0', '0', NULL, NULL, '2016-05-29 00:02:55', 116, '72626272', NULL, 22, 8),
(114, 100.00, 0.00, '1', '2', '0', '0', NULL, NULL, '2016-06-05 16:22:46', 119, '72626272', NULL, 23, 8),
(115, 100.00, 0.00, '1', '2', '0', '0', NULL, NULL, '2016-06-05 16:22:46', 122, '72626272', NULL, 23, 8),
(116, 100.00, 0.00, '1', '2', '0', '0', NULL, NULL, '2016-06-05 19:10:14', 125, '72626272', NULL, 24, 8),
(117, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 128, '72626272', NULL, NULL, 8),
(118, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 131, '72626272', NULL, NULL, 8),
(119, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 134, '72626272', NULL, NULL, 8),
(120, 150.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 137, '72626272', NULL, NULL, 8),
(121, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 161, '72626272', NULL, NULL, 8),
(122, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 162, '72626272', NULL, NULL, 8),
(123, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 167, '72626272', NULL, NULL, 8),
(124, 100.00, 0.00, '1', '1', '0', '0', NULL, NULL, '2016-03-19 07:57:58', 170, '72626272', NULL, 12, 17),
(125, 200.00, 0.00, '1', '1', '0', '0', NULL, NULL, '2016-03-19 07:57:58', 173, '72626272', NULL, 12, 17),
(126, 100.00, 0.00, '1', '1', '0', '0', NULL, NULL, '2016-03-19 07:56:44', 176, '72626272', NULL, 12, 17),
(127, 100.00, 0.00, '1', '1', '0', '0', NULL, NULL, '2016-03-19 07:56:44', 179, '72626272', NULL, 12, 17),
(128, 100.00, 0.00, '1', '1', '0', '0', NULL, NULL, '2016-03-19 07:54:50', 182, '72626272', NULL, 12, 17),
(129, 100.00, 0.00, '1', '1', '0', '0', NULL, NULL, '2016-03-19 07:54:50', 185, '72626272', NULL, 12, 17),
(130, 100.00, 0.00, '1', '1', '0', '0', NULL, NULL, '2016-03-19 07:51:30', 188, '72626272', NULL, 12, 17),
(131, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 217, NULL, NULL, NULL, 8),
(132, 120.00, 0.00, '1', '2', '0', '0', NULL, NULL, '2016-03-18 06:57:09', 219, '65434567', NULL, 14, 8),
(133, 20.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 221, '23456543', NULL, NULL, 8),
(134, 20.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 221, '23498755', NULL, NULL, 8),
(135, 10.00, 0.00, '1', '1', '0', '0', NULL, NULL, '2016-03-19 07:27:11', 222, '12121212', NULL, 12, 17),
(136, 10.00, 0.00, '1', '1', '0', '0', NULL, NULL, '2016-03-19 07:28:51', 222, '12345678', NULL, 12, 17),
(137, 10.00, 0.00, '1', '2', '0', '0', NULL, NULL, '2016-03-19 05:25:17', 222, '33333333', NULL, 14, 8),
(138, 10.00, 0.00, '1', '1', '0', '0', NULL, NULL, '2016-03-19 07:51:30', 222, '72626272', NULL, 12, 17),
(139, 10.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 222, '15432112', NULL, NULL, 8),
(140, 10.00, 0.00, '1', '2', '0', '0', NULL, NULL, '2016-03-18 10:41:24', 222, '22222222', NULL, 14, 8),
(142, 10.00, 0.00, '1', '2', '0', '0', NULL, NULL, '2016-03-18 08:42:48', 222, '11111111', NULL, 14, 8),
(143, 10.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 223, '23456787', NULL, NULL, 8),
(144, 10.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 223, '23456789', NULL, NULL, 8),
(145, 10.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 223, '23456654', NULL, NULL, 8),
(146, 10.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 224, '23456543', NULL, NULL, 8),
(147, 10.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 224, '23498755', NULL, NULL, 8),
(148, 7.00, 0.00, '1', '2', '0', '0', NULL, NULL, '2016-03-18 06:57:41', 233, '65434567', NULL, 14, 8),
(149, 50.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 236, '23456787', NULL, NULL, 8),
(150, 50.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 236, '23456789', NULL, NULL, 8),
(151, 50.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 236, '23456654', NULL, NULL, 8),
(152, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 11, '01010101', NULL, NULL, 8),
(153, 110.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 62, '01010101', NULL, NULL, 8),
(154, 110.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 69, '01010101', NULL, NULL, 8),
(155, 110.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 76, '01010101', NULL, NULL, 8),
(156, 110.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 83, '01010101', NULL, NULL, 8),
(157, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 11, '01010101', NULL, NULL, 8),
(158, 110.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 62, '01010101', NULL, NULL, 8),
(159, 110.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 69, '01010101', NULL, NULL, 8),
(160, 110.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 76, '01010101', NULL, NULL, 8),
(161, 110.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 83, '01010101', NULL, NULL, 8),
(162, 500.00, 0.00, '0', '0', '0', '0', 'Sr. Antonio Banderas', 'Alquiler de Local', '2016-03-15 07:22:25', 240, NULL, NULL, NULL, 8),
(163, 550.00, 0.00, '0', '0', '0', '0', 'Inversiones Requeridas S.A.C', 'Venta de carpetas de segunda mano', '2016-03-15 07:22:25', 241, NULL, NULL, NULL, 8),
(164, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 7, 'PN-012222', NULL, NULL, 8),
(165, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 58, 'PN-012222', NULL, NULL, 8),
(166, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 66, 'PN-012222', NULL, NULL, 8),
(167, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 73, 'PN-012222', NULL, NULL, 8),
(168, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 80, 'PN-012222', NULL, NULL, 8),
(169, 150.00, 0.00, '1', '2', '0', '0', NULL, NULL, '2016-03-18 10:41:24', 20, '22222222', NULL, 14, 8),
(170, 100.00, 0.00, '1', '2', '0', '0', NULL, NULL, '2016-03-18 10:38:28', 112, '22222222', NULL, 14, 8),
(171, 100.00, 0.00, '1', '2', '0', '0', NULL, NULL, '2016-03-18 10:38:28', 114, '22222222', NULL, 14, 8),
(172, 100.00, 0.00, '1', '2', '0', '0', NULL, NULL, '2016-03-18 08:34:09', 117, '22222222', NULL, 14, 8),
(173, 100.00, 0.00, '1', '2', '0', '0', NULL, NULL, '2016-03-18 10:36:54', 120, '22222222', NULL, 14, 8),
(174, 100.00, 0.00, '1', '2', '0', '0', NULL, NULL, '2016-03-18 10:36:54', 123, '22222222', NULL, 14, 8),
(175, 100.00, 0.00, '1', '2', '0', '0', NULL, NULL, '2016-03-18 08:35:15', 126, '22222222', NULL, 14, 8),
(176, 100.00, 0.00, '1', '2', '0', '0', NULL, NULL, '2016-03-18 08:35:15', 129, '22222222', NULL, 14, 8),
(177, 100.00, 0.00, '1', '2', '0', '0', NULL, NULL, '2016-03-18 08:09:14', 132, '22222222', NULL, 14, 8),
(178, 100.00, 0.00, '1', '2', '0', '0', NULL, NULL, '2016-03-18 08:11:35', 135, '22222222', NULL, 14, 8),
(179, 100.00, 0.00, '1', '2', '0', '0', NULL, NULL, '2016-03-18 08:08:29', 138, '22222222', NULL, 14, 8),
(180, 110.00, 0.00, '1', '2', '0', '0', NULL, NULL, '2016-03-18 08:01:36', 163, '22222222', NULL, 14, 8),
(181, 110.00, 0.00, '1', '2', '0', '0', NULL, NULL, '2016-03-18 08:01:06', 166, '22222222', NULL, 14, 8),
(182, 110.00, 0.00, '1', '2', '0', '0', NULL, NULL, '2016-03-18 08:10:34', 168, '22222222', NULL, 14, 8),
(183, 110.00, 0.00, '1', '2', '0', '0', NULL, NULL, '2016-03-18 07:57:56', 171, '22222222', NULL, 14, 8),
(184, 110.00, 0.00, '1', '2', '0', '0', NULL, NULL, '2016-03-18 07:52:37', 174, '22222222', NULL, 14, 8),
(185, 110.00, 0.00, '1', '2', '0', '0', NULL, NULL, '2016-03-18 08:09:50', 177, '22222222', NULL, 14, 8),
(186, 110.00, 0.00, '1', '2', '0', '0', NULL, NULL, '2016-03-18 08:07:37', 180, '22222222', NULL, 14, 8),
(187, 110.00, 0.00, '1', '2', '0', '0', NULL, NULL, '2016-03-18 07:40:48', 183, '22222222', NULL, 14, 8),
(188, 110.00, 0.00, '1', '2', '0', '0', NULL, NULL, '2016-03-18 07:30:25', 186, '22222222', NULL, 14, 8),
(189, 110.00, 0.00, '1', '2', '0', '0', NULL, NULL, '2016-03-18 07:59:04', 189, '22222222', NULL, 14, 8),
(190, 220.00, 0.00, '1', '2', '0', '0', NULL, NULL, '2016-03-18 13:21:48', 18, '66666666', NULL, 14, 8),
(191, 190.00, 0.00, '1', '2', '0', '0', NULL, NULL, '2016-03-18 13:21:48', 110, '66666666', NULL, 14, 8),
(192, 190.00, 0.00, '1', '1', '0', '0', NULL, NULL, '2016-03-19 06:29:18', 113, '66666666', NULL, 12, 17),
(193, 200.00, 0.00, '1', '1', '0', '0', NULL, NULL, '2016-03-19 06:31:06', 116, '66666666', NULL, 12, 17),
(194, 100.00, 0.00, '1', '1', '0', '0', NULL, NULL, '2016-03-19 06:37:04', 119, '66666666', NULL, 12, 17),
(195, 100.00, 0.00, '1', '2', '0', '0', NULL, NULL, '2016-03-19 06:23:48', 122, '66666666', NULL, 14, 8),
(196, 100.00, 0.00, '1', '2', '0', '0', NULL, NULL, '2016-03-19 06:23:31', 125, '66666666', NULL, 14, 8),
(197, 100.00, 0.00, '1', '2', '0', '0', NULL, NULL, '2016-03-19 06:23:48', 128, '66666666', NULL, 14, 8),
(198, 100.00, 0.00, '1', '2', '0', '0', NULL, NULL, '2016-03-19 05:56:19', 131, '66666666', NULL, 14, 8),
(199, 100.00, 0.00, '1', '2', '0', '0', NULL, NULL, '2016-03-19 05:56:19', 134, '66666666', NULL, 14, 8),
(200, 150.00, 0.00, '1', '2', '0', '0', NULL, NULL, '2016-03-19 06:10:29', 137, '66666666', NULL, 14, 8),
(201, 100.00, 0.00, '1', '2', '0', '0', NULL, NULL, '2016-03-19 06:10:29', 161, '66666666', NULL, 14, 8),
(202, 100.00, 0.00, '1', '2', '0', '0', NULL, NULL, '2016-03-19 06:08:19', 162, '66666666', NULL, 14, 8),
(203, 100.00, 0.00, '1', '2', '0', '0', NULL, NULL, '2016-03-18 23:52:37', 167, '66666666', NULL, 14, 8),
(204, 100.00, 0.00, '1', '2', '0', '0', NULL, NULL, '2016-03-18 23:51:01', 170, '66666666', NULL, 14, 8),
(205, 200.00, 0.00, '1', '2', '0', '0', NULL, NULL, '2016-03-18 23:36:59', 173, '66666666', NULL, 14, 8),
(206, 100.00, 0.00, '1', '2', '0', '0', NULL, NULL, '2016-03-18 23:36:59', 176, '66666666', NULL, 14, 8),
(207, 100.00, 0.00, '1', '2', '0', '0', NULL, NULL, '2016-03-19 06:08:19', 179, '66666666', NULL, 14, 8),
(208, 100.00, 0.00, '1', '2', '0', '0', NULL, NULL, '2016-03-18 23:43:20', 182, '66666666', NULL, 14, 8),
(209, 100.00, 0.00, '1', '2', '0', '0', NULL, NULL, '2016-03-18 23:41:41', 185, '66666666', NULL, 14, 8),
(210, 100.00, 0.00, '1', '2', '0', '0', NULL, NULL, '2016-03-18 23:40:28', 188, '66666666', NULL, 14, 8),
(211, 220.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 19, '34567976', NULL, NULL, 8),
(212, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 111, '34567976', NULL, NULL, 8),
(213, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 115, '34567976', NULL, NULL, 8),
(214, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 118, '34567976', NULL, NULL, 8),
(215, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 121, '34567976', NULL, NULL, 8),
(216, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 124, '34567976', NULL, NULL, 8),
(217, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 127, '34567976', NULL, NULL, 8),
(218, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 130, '34567976', NULL, NULL, 8),
(219, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 133, '34567976', NULL, NULL, 8),
(220, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 136, '34567976', NULL, NULL, 8),
(221, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 139, '34567976', NULL, NULL, 8),
(222, 120.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 164, '34567976', NULL, NULL, 8),
(223, 120.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 165, '34567976', NULL, NULL, 8),
(224, 120.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 169, '34567976', NULL, NULL, 8),
(225, 120.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 172, '34567976', NULL, NULL, 8),
(226, 120.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 175, '34567976', NULL, NULL, 8),
(227, 120.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 178, '34567976', NULL, NULL, 8),
(228, 120.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 181, '34567976', NULL, NULL, 8),
(229, 120.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 184, '34567976', NULL, NULL, 8),
(230, 120.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 187, '34567976', NULL, NULL, 8),
(231, 120.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-15 07:22:25', 190, '34567976', NULL, NULL, 8),
(232, 100.00, 0.00, '1', '2', '0', '0', NULL, NULL, '2016-03-19 06:45:44', 13, '55555555', NULL, 16, 17),
(233, 100.00, 15.00, '1', '2', '0', '0', NULL, NULL, '2016-03-19 06:45:44', 85, '55555555', NULL, 16, 17),
(234, 100.00, 15.00, '1', '2', '0', '0', NULL, NULL, '2016-03-19 06:43:25', 90, '55555555', NULL, 16, 17),
(235, 100.00, 15.00, '1', '2', '0', '0', NULL, NULL, '2016-03-19 05:55:37', 95, '55555555', NULL, 13, 8),
(236, 100.00, 15.00, '1', '2', '0', '0', NULL, NULL, '2016-03-19 05:55:37', 100, '55555555', NULL, 13, 8),
(237, 100.00, 15.00, '1', '2', '0', '0', NULL, NULL, '2016-03-19 06:46:39', 105, '55555555', NULL, 16, 17),
(238, 100.00, 0.00, '1', '2', '0', '0', NULL, NULL, '2016-03-18 08:40:04', 8, '11111111', NULL, 14, 8),
(239, 110.00, 12.10, '1', '2', '0', '0', NULL, NULL, '2016-03-18 09:04:37', 59, '11111111', NULL, 14, 8),
(240, 110.00, 12.10, '1', '2', '0', '0', NULL, NULL, '2016-03-18 08:52:20', 65, '11111111', NULL, 14, 8),
(241, 110.00, 12.10, '1', '2', '0', '0', NULL, NULL, '2016-03-18 09:02:37', 72, '11111111', NULL, 14, 8),
(242, 110.00, 12.10, '1', '2', '0', '0', NULL, NULL, '2016-03-18 09:04:37', 79, '11111111', NULL, 14, 8),
(243, 1.50, 0.00, '1', '1', '0', '0', NULL, NULL, '2016-03-07 23:44:09', 228, '65434567', NULL, 11, 8),
(244, 1.50, 0.00, '1', '1', '0', '0', NULL, NULL, '2016-03-07 23:54:33', 228, '65434567', NULL, 11, 8),
(245, 100.00, 0.00, '1', '1', '0', '0', NULL, NULL, '2016-03-13 05:59:36', 278, '11111111', NULL, 11, 8),
(246, 1.50, 0.00, '1', '1', '0', '0', NULL, NULL, '2016-03-13 17:31:24', 228, '65434567', NULL, 11, 8),
(247, 100.00, 0.00, '1', '1', '0', '0', NULL, NULL, '2016-03-14 15:03:22', 278, '11111111', NULL, 11, 8),
(248, 15.00, 0.00, '1', '1', '0', '0', NULL, NULL, '2016-03-14 23:35:26', 228, '65434567', NULL, 9, 8),
(249, 300.00, 0.00, '1', '1', '0', '0', NULL, NULL, '2016-03-18 08:20:19', 227, '22222222', NULL, 11, 8),
(250, 15.00, 0.00, '1', '0', '0', '0', NULL, NULL, '2016-03-18 06:19:25', 228, '65434567', NULL, NULL, NULL),
(251, 15.00, 0.00, '1', '0', '0', '0', NULL, NULL, '2016-03-18 06:57:41', 228, '65434567', NULL, NULL, NULL),
(252, 100.00, 0.00, '1', '0', '0', '0', NULL, NULL, '2016-03-18 08:40:04', 278, '11111111', NULL, NULL, NULL),
(253, 100.00, 0.00, '1', '0', '0', '0', NULL, NULL, '2016-03-18 08:42:48', 278, '11111111', NULL, NULL, NULL),
(254, 100.00, 0.00, '1', '0', '0', '0', NULL, NULL, '2016-03-18 08:52:20', 278, '11111111', NULL, NULL, NULL),
(255, 100.00, 0.00, '1', '0', '0', '0', NULL, NULL, '2016-03-18 09:02:38', 278, '11111111', NULL, NULL, NULL),
(256, 500.00, 0.00, '1', '2', '0', '0', 'Jesus Manya', 'Servicios Varios', '2016-03-19 08:53:30', 239, NULL, NULL, 14, 8),
(257, 220.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-18 11:25:08', 19, '44556677', NULL, NULL, NULL),
(258, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-18 11:25:08', 111, '44556677', NULL, NULL, NULL),
(259, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-18 11:25:08', 115, '44556677', NULL, NULL, NULL),
(260, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-18 11:25:08', 118, '44556677', NULL, NULL, NULL),
(261, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-18 11:25:08', 121, '44556677', NULL, NULL, NULL),
(262, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-18 11:25:08', 124, '44556677', NULL, NULL, NULL),
(263, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-18 11:25:08', 127, '44556677', NULL, NULL, NULL),
(264, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-18 11:25:08', 130, '44556677', NULL, NULL, NULL),
(265, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-18 11:25:08', 133, '44556677', NULL, NULL, NULL),
(266, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-18 11:25:08', 136, '44556677', NULL, NULL, NULL),
(267, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-18 11:25:08', 139, '44556677', NULL, NULL, NULL),
(268, 120.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-18 11:25:08', 164, '44556677', NULL, NULL, NULL),
(269, 120.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-18 11:25:08', 165, '44556677', NULL, NULL, NULL),
(270, 120.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-18 11:25:08', 169, '44556677', NULL, NULL, NULL),
(271, 120.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-18 11:25:08', 172, '44556677', NULL, NULL, NULL),
(272, 120.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-18 11:25:08', 175, '44556677', NULL, NULL, NULL),
(273, 120.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-18 11:25:08', 178, '44556677', NULL, NULL, NULL),
(274, 120.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-18 11:25:09', 181, '44556677', NULL, NULL, NULL),
(275, 120.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-18 11:25:09', 184, '44556677', NULL, NULL, NULL),
(276, 120.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-18 11:25:09', 187, '44556677', NULL, NULL, NULL),
(277, 120.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-18 11:25:09', 190, '44556677', NULL, NULL, NULL),
(278, 130.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-18 11:25:09', 249, '44556677', NULL, NULL, NULL),
(279, 130.00, 0.00, '0', '0', '0', '0', NULL, NULL, '2016-03-18 11:25:09', 252, '44556677', NULL, NULL, NULL),
(280, 150.00, 0.00, '0', '0', '0', '0', 'MAXIMO ROMERO', 'EXAMEN DE EXCEPCIONALIDAD', '2016-03-18 12:08:24', 240, NULL, NULL, NULL, NULL),
(281, 15.00, 0.00, '1', '0', '0', '0', NULL, NULL, '2016-03-18 12:20:29', 228, '65434567', NULL, NULL, NULL),
(282, 1.50, 0.00, '1', '0', '0', '0', NULL, NULL, '2016-03-18 13:23:03', 228, '65434567', NULL, NULL, NULL),
(283, 120.00, 0.00, '1', '0', '0', '0', NULL, NULL, '2016-03-19 06:49:39', 278, '11111111', NULL, NULL, NULL),
(284, 120.00, 0.00, '1', '0', '0', '0', NULL, NULL, '2016-03-19 06:50:08', 278, '11111111', NULL, NULL, NULL),
(285, 120.00, 0.00, '1', '0', '0', '0', NULL, NULL, '2016-03-19 06:52:09', 278, '11111111', NULL, NULL, NULL),
(286, 120.00, 0.00, '1', '0', '0', '0', NULL, NULL, '2016-03-19 06:53:17', 278, '11111111', NULL, NULL, NULL),
(287, 120.00, 0.00, '1', '0', '0', '0', NULL, NULL, '2016-03-19 06:56:05', 278, '11111111', NULL, NULL, NULL),
(288, 120.00, 0.00, '1', '0', '0', '0', NULL, NULL, '2016-03-19 07:00:06', 278, '11111111', NULL, NULL, NULL),
(289, 120.00, 0.00, '1', '0', '0', '0', NULL, NULL, '2016-03-19 07:02:29', 278, '11111111', NULL, NULL, NULL),
(290, 120.00, 0.00, '1', '0', '0', '0', NULL, NULL, '2016-03-19 07:04:42', 278, '11111111', NULL, NULL, NULL),
(291, 120.00, 0.00, '1', '0', '0', '0', NULL, NULL, '2016-03-19 07:06:46', 278, '11111111', NULL, NULL, NULL),
(292, 120.00, 0.00, '1', '0', '0', '0', NULL, NULL, '2016-03-19 07:07:39', 278, '11111111', NULL, NULL, NULL),
(293, 120.00, 0.00, '1', '0', '0', '0', NULL, NULL, '2016-03-19 07:08:47', 278, '11111111', NULL, NULL, NULL),
(294, 120.00, 0.00, '1', '0', '0', '0', NULL, NULL, '2016-03-19 07:10:37', 278, '11111111', NULL, NULL, NULL),
(295, 120.00, 0.00, '1', '0', '0', '0', NULL, NULL, '2016-03-19 07:12:43', 278, '11111111', NULL, NULL, NULL),
(296, 120.00, 0.00, '1', '0', '0', '0', NULL, NULL, '2016-03-19 07:16:33', 278, '11111111', NULL, NULL, NULL),
(297, 1000.00, 0.00, '1', '1', '0', '0', 'Daniel Chavez', 'Alquiler', '2016-03-19 09:29:32', 237, NULL, NULL, 12, 17),
(298, 50.00, 0.00, '1', '2', '0', '0', 'DNI: 82736478. Nombre: Roberto Diaz Diaz', NULL, '2016-03-27 14:10:18', 332, NULL, NULL, 14, 8),
(299, 50.00, 0.00, '1', '2', '0', '0', '56378292', 'Ramon', '2016-03-27 19:37:58', 332, NULL, NULL, 14, 8),
(300, 50.00, 0.00, '1', '1', '0', '0', '81818181', 'Ramon', '2016-03-27 19:39:20', 332, NULL, NULL, 12, 17),
(301, 50.00, 0.00, '1', '1', '0', '0', '71829301', 'Julio Rozas', '2016-03-27 23:46:23', 332, NULL, NULL, 12, 17),
(302, 50.00, 0.00, '1', '2', '0', '0', '98102993', 'Samuel Perez', '2016-03-27 23:47:11', 332, NULL, NULL, 14, 8),
(303, 150.00, 0.00, '1', '2', '0', '0', '112', '12', '2016-03-28 00:06:45', 246, NULL, NULL, 13, 8),
(304, 150.00, 0.00, '1', '2', '0', '0', '12', '12', '2016-03-28 00:30:52', 246, NULL, NULL, 13, 8),
(305, 10.00, 0.00, '1', '2', '0', '0', NULL, NULL, '2016-05-28 23:51:46', 334, '12121212', NULL, 20, 8),
(306, 10.00, 0.00, '1', '2', '0', '0', NULL, NULL, '2016-05-28 23:57:07', 334, '12345678', NULL, 21, 8),
(307, 10.00, 0.00, '1', '2', '0', '0', NULL, NULL, '2016-05-01 17:06:26', 334, '33333333', NULL, 19, 8),
(308, 10.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 334, '72626272', NULL, NULL, NULL),
(309, 10.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 334, '15432112', NULL, NULL, NULL),
(310, 10.00, 0.00, '1', '2', '0', '0', NULL, NULL, '2016-04-30 22:12:58', 334, '66666666', NULL, 18, 8),
(311, 10.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 334, '99999999', NULL, NULL, NULL),
(312, 120.00, 0.00, '1', '0', '0', '0', NULL, NULL, '2016-03-28 03:57:46', 278, '11111111', NULL, NULL, 8),
(313, 120.00, 0.00, '1', '0', '0', '0', NULL, NULL, NULL, 278, '11111111', NULL, NULL, 17),
(314, 830.00, 0.00, '0', '0', '0', '0', 'Inversiones Educativas SAC', 'Servicios Varios', NULL, 239, NULL, NULL, NULL, NULL),
(315, 120.00, 0.00, '1', '0', '0', '0', NULL, NULL, NULL, 278, '11111111', NULL, NULL, 8),
(316, 120.00, 0.00, '1', '0', '0', '0', NULL, NULL, NULL, 278, '11111111', NULL, NULL, 8),
(317, 120.00, 0.00, '1', '0', '0', '0', NULL, NULL, NULL, 278, '11111111', NULL, NULL, 8),
(318, 120.00, 0.00, '1', '0', '0', '0', NULL, NULL, NULL, 278, '11111111', NULL, NULL, 8),
(319, 120.00, 0.00, '1', '0', '0', '0', NULL, NULL, NULL, 278, '11111111', NULL, NULL, 8),
(320, 120.00, 0.00, '1', '0', '0', '0', NULL, NULL, NULL, 278, '11111111', NULL, NULL, 8),
(321, 120.00, 0.00, '1', '0', '0', '0', NULL, NULL, NULL, 278, '11111111', NULL, NULL, 8),
(322, 120.00, 0.00, '1', '0', '0', '0', NULL, NULL, NULL, 278, '11111111', NULL, NULL, 8),
(323, 120.00, 0.00, '1', '0', '0', '0', NULL, NULL, NULL, 278, '11111111', NULL, NULL, 8),
(324, 120.00, 0.00, '1', '0', '0', '0', NULL, NULL, NULL, 278, '11111111', NULL, NULL, 8),
(325, 120.00, 0.00, '1', '0', '0', '0', NULL, NULL, NULL, 278, '11111111', NULL, NULL, 8),
(326, 240.00, 0.00, '1', '0', '0', '0', NULL, NULL, '2016-04-07 21:28:00', 278, '11111111', NULL, NULL, 18),
(327, 240.00, 0.00, '1', '0', '0', '0', NULL, NULL, NULL, 278, '11111111', NULL, NULL, 8),
(328, 120.00, 0.00, '1', '0', '0', '0', NULL, NULL, '2016-06-05 19:09:39', 278, '11111111', NULL, NULL, 8);

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
  `fecha_registro` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `jsoria_egreso`
--

INSERT INTO `jsoria_egreso` (`id`, `tipo_comprobante`, `numero_comprobante`, `fecha`, `id_institucion`, `id_tesorera`, `fecha_registro`) VALUES
(3, 3, '2', '2016-03-17', 1, 13, '2016-03-17 00:00:00'),
(4, 1, '23123', '2016-03-17', 2, 13, '2016-03-17 00:00:00'),
(5, 3, '3', '2016-03-03', 1, 13, '2016-03-03 00:00:00'),
(6, 2, '009-019929', '2016-02-01', 1, 13, '2016-02-01 00:00:00'),
(7, 2, '001-23324325', '2016-02-19', 1, 13, '2016-02-19 00:00:00'),
(8, 3, '4', '2016-02-26', 2, 13, '2016-02-26 00:00:00'),
(9, 2, '001-0001', '2016-02-10', 3, 13, '2016-02-10 00:00:00'),
(10, 2, '002-12353', '2016-02-20', 3, 13, '2016-02-20 00:00:00'),
(11, 2, '009-1230', '2016-03-05', 2, 13, '2016-03-05 00:00:00'),
(12, 3, '5', '2016-03-09', 3, 13, '2016-03-09 00:00:00'),
(13, 3, '6', '2016-03-01', 3, 13, '2016-03-01 00:00:00'),
(14, 2, '12356', '2016-04-18', 1, 13, '2016-04-18 00:00:00'),
(15, 1, '778', '2016-04-20', 1, 13, '2016-04-20 00:00:00'),
(16, 2, '89876', '2016-04-19', 2, 13, '2016-04-19 00:00:00'),
(17, 2, '0019', '2016-04-20', 1, 13, '2016-04-20 00:00:00'),
(18, 1, '134', '2016-04-21', 2, 13, '2016-04-21 00:00:00'),
(19, 1, '28', '2016-04-23', 1, 13, '2016-04-23 00:00:00'),
(20, 1, '435435', '2016-04-16', 1, 13, '2016-04-16 00:00:00'),
(21, 1, '12345', '2016-04-24', 1, 13, '2016-04-24 00:00:00'),
(22, 1, '2121', '2016-05-01', 1, 13, '2016-05-01 00:00:00'),
(23, 1, '1352', '2016-05-14', 1, 13, '2016-05-14 00:00:00'),
(24, 2, '234324', '2016-05-14', 1, 13, '2016-05-14 00:00:00'),
(25, 1, '0012', '2016-05-27', 1, 13, '2016-05-27 00:00:00'),
(26, 2, '0192', '2016-05-28', 1, 13, '2016-05-29 00:00:00'),
(27, 2, '91882', '2016-05-28', 2, 13, '2016-05-29 00:00:00'),
(28, 1, '12312', '2016-06-04', 3, 13, '2016-06-05 16:18:39'),
(29, 1, '2131', '2016-06-03', 1, 13, '2016-06-05 17:00:00'),
(30, 1, '123', '2016-06-02', 2, 13, '2016-06-05 06:28:52');

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `jsoria_institucion`
--

INSERT INTO `jsoria_institucion` (`id`, `nombre`, `id_razon_social`, `razon_social`, `ruc`, `direccion`) VALUES
(1, 'Institución Educativa J Soria', '1', 'Corporación Educativa J-Soria S.C.R.LTDA', '20490041339', 'Jr. Quillabamba N° 110 - Quillabamba'),
(2, 'CEBA Konrad Adenahuer', '1', 'Corporación Educativa J-Soria S.C.R.LTDA', '20490041339', 'Jr. Quillabamba N° 110 - Quillabamba'),
(3, 'Instituto Superior Tecnológico Urusayhua', '1', 'Corporación Educativa J-Soria S.C.R.LTDA', '20490041339', 'Jr. Quillabamba N° 110 - Quillabamba'),
(4, 'Universidad Líder Peruana', '2', 'Universidad Privada Líder Peruana S.A.C.', '20564356035', 'Jr. Quillabamba N° 110 - Quillabamba');

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
(1, 7),
(2, 7),
(3, 7),
(4, 7),
(1, 8),
(2, 8),
(3, 8),
(1, 10),
(2, 10),
(3, 10),
(4, 10),
(4, 12),
(1, 13),
(2, 13),
(3, 13),
(4, 15),
(1, 16),
(4, 17),
(1, 18),
(2, 18),
(3, 18),
(4, 18);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jsoria_retiro`
--

CREATE TABLE IF NOT EXISTS `jsoria_retiro` (
  `id` int(11) NOT NULL,
  `monto` double(8,2) DEFAULT '0.00',
  `fecha_hora` datetime DEFAULT NULL,
  `estado` char(1) DEFAULT '0',
  `id_usuario` int(11) NOT NULL,
  `id_cajera` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `jsoria_retiro`
--

INSERT INTO `jsoria_retiro` (`id`, `monto`, `fecha_hora`, `estado`, `id_usuario`, `id_cajera`) VALUES
(1, 0.00, '2016-03-14 15:00:28', '1', 7, 8),
(2, 0.00, '2016-03-14 15:03:54', '0', 7, 8),
(3, 0.00, '2016-03-14 15:04:58', '0', 7, 8),
(4, 0.00, '2016-03-14 15:07:30', '0', 7, 8),
(5, 0.00, '2016-03-14 15:08:27', '0', 7, 8),
(6, 0.00, '2016-03-14 20:44:52', '0', 7, 8),
(7, 101.50, '2016-03-14 20:51:52', '1', 7, 8),
(8, 101.50, '2016-03-14 21:22:46', '1', 7, 8),
(9, 15.00, '2016-03-14 23:36:04', '0', 7, 8),
(10, 487.00, '2016-03-16 19:58:58', '1', 13, 8),
(11, 504.50, '2016-03-28 00:53:25', '0', 7, 0),
(12, 3530.00, '2016-03-28 01:09:22', '0', 13, 0),
(13, 2170.00, '2016-03-28 01:10:21', '1', 15, 8),
(14, 8261.60, '2016-04-07 21:24:55', '1', 13, 8),
(15, 100.00, '2016-04-07 21:32:27', '1', 13, 8),
(16, 355.00, '2016-04-21 22:13:53', '1', 15, 17),
(17, 210.00, '2016-04-21 23:07:16', '1', 13, 8),
(18, 10.00, '2016-04-30 22:13:20', '1', 13, 8),
(19, 10.00, '2016-05-01 17:06:59', '1', 13, 8),
(20, 10.00, '2016-05-28 23:52:00', '1', 13, 8),
(21, 10.00, '2016-05-28 23:57:20', '1', 13, 8),
(22, 200.00, '2016-05-29 00:03:10', '1', 13, 8),
(23, 200.00, '2016-06-05 16:24:14', '1', 13, 8),
(24, 100.00, '2016-06-05 19:13:22', '1', 13, 8);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jsoria_rubro`
--

CREATE TABLE IF NOT EXISTS `jsoria_rubro` (
  `id` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1 COMMENT='Esta tabla almacena los rubros.';

--
-- Volcado de datos para la tabla `jsoria_rubro`
--

INSERT INTO `jsoria_rubro` (`id`, `nombre`) VALUES
(2, 'Muebles'),
(3, 'Equipos'),
(5, 'compras'),
(6, 'EXTRAS'),
(7, 'mantenimiento'),
(16, 'Rubro22'),
(17, 'Rubro11'),
(18, 'Rubro13'),
(19, 'Rubro77'),
(20, 'Rubro50'),
(21, ''),
(22, 'blablabla'),
(23, 'comida'),
(24, 'hola');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jsoria_tipo_comprobante`
--

CREATE TABLE IF NOT EXISTS `jsoria_tipo_comprobante` (
  `id` int(11) NOT NULL,
  `denominacion` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `jsoria_tipo_comprobante`
--

INSERT INTO `jsoria_tipo_comprobante` (`id`, `denominacion`) VALUES
(1, 'Boleta'),
(2, 'Factura'),
(3, 'Comprobante de Pago'),
(4, 'Recibo por Honorarios');

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
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `jsoria_usuario`
--

INSERT INTO `jsoria_usuario` (`id`, `dni`, `nombres`, `apellidos`, `tipo`, `usuario_login`, `password`, `remember_token`) VALUES
(7, '12324432', 'Jeronimo', 'Soria Mormontoy', 'Administrador', 'admin', '$2y$10$0HVng/oC/YcoJI3.5psjKesIzfaJ.lv1cEpRVM.sPFqyVRO1fzm9y', 'FltgTnZ1kfNWRDM69k48QvtHzBtYK1QQgESQC8Z3pdvGSiVkFk98ZT0o7cfc'),
(8, '78665546', 'Carmen', 'Salas Gamarra', 'Cajera', 'cajera', '$2y$10$ltGiEF9reG9D5tEe/oxjP.MDUB87daAGzJgCDHImcM5EPgeQNWayi', 'ECP8XFJ8d8cu8x1xSjs8vLrRI7gtJjEeUwTovTFKqZvPRxh2NHd7x7Uuhcwg'),
(10, '23432546', 'ROSARIO', 'MENDOZA', 'Secretaria', 'secretaria2', '$2y$10$or.3RCALE9USMNI0jnKltu.HhDyBhuVs.xecPqb6FnKdHxDsxueTm', 'nThXt9tXwk01imboJwvlfv6tea34490IJLJgG1VqRmpif2Tk787tIHmCDTYz'),
(12, '23434645', 'Secretaria', 'ULP', 'Secretaria', 'secretaria4', '$2y$10$wJc.HSR718MjetmW/6e9beQ0E4UB5eOiLkQALpd72k.KpW7jP1nLS', 'HAjB3tG2ytlgF20vjV0VnL5ztnwxYgDbvHvGTScK07WI34gTFEwLPjVCWnKv'),
(13, '81762668', 'Tesorera', 'Corporacion', 'Tesorera', 'tesorera1', '$2y$10$beNc70KJ.KSMpu9.FAjbaOVJckgoHpVww61pa3eaTSaP1bmrxdFgi', '6MbvtWIg9ys3XvLgiD42NnZKSuzTqSprBxbB1DZLQtOOgJcMHu7uQAuI7azP'),
(15, '23435345', 'Tesorera', 'ULP', 'Tesorera', 'tesorera2', '$2y$10$yXnKMzrivTV0Jj..CwEcxeGJK0EKkTYx2i593JcnVPEp84CRiFP9q', 'CXxDQlGcsP6q7w134iHZFHPdDVpRZtIQ1Zi5nPZRexMHqV3TnxHUcQ4eavgA'),
(16, '98767897', 'Sabrina', 'I.E. J. Soria', 'Secretaria', 'secretaria1', '$2y$10$5OVQTQVeP0uGRCl2SfrYvOCnLCEiDMR.YNq2jGY8FNjkeScsiVxLG', '2e6clbrqPY8IA9PNJhx5XnHRE6wXW8IJtneQ05ClQQVySdDcHwzoowLUi7L0'),
(17, '78272145', 'KARINA', 'FLORES', 'Cajera', 'cajera2', '$2y$10$vt0LYmB/cJgnhRtbUMZsjeYPAZbxDj2OCI.vA9QphBMjhekBZFtpW', 'vV42SLGHiKoXev0P1ag5sU3TOZSZUYeBHnWhRMen700BLeDwrn8skCe0tkcV'),
(18, '09112289', 'Sara', 'Del Carpio', 'Cajera', 'cajera3', '$2y$10$UYmmmDZj7Mt7GXUhyrmS2OdfJHAixR8FmVuUhTKH9tB/IaMScxP.G', 'yjOhezIGn8GW0fgaUBdUOepQf4i7Eqrje0lQjUEHGoa7szqN5ind8QOBYBbi');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jsoria_usuario_impresora`
--

CREATE TABLE IF NOT EXISTS `jsoria_usuario_impresora` (
  `id_cajera` int(11) NOT NULL,
  `tipo_impresora` varchar(20) NOT NULL,
  `nombre_impresora` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `jsoria_usuario_impresora`
--

INSERT INTO `jsoria_usuario_impresora` (`id_cajera`, `tipo_impresora`, `nombre_impresora`) VALUES
(8, 'ticketera', 'Ticketera'),
(17, 'matricial', '//localhost/EpsonLX350'),
(18, 'ticketera', 'Ticketera');

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
  ADD KEY `fk_detalle:institucion_categoria_idx` (`id_detalle_institucion`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT de la tabla `jsoria_balance`
--
ALTER TABLE `jsoria_balance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT de la tabla `jsoria_categoria`
--
ALTER TABLE `jsoria_categoria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=336;
--
-- AUTO_INCREMENT de la tabla `jsoria_comprobante`
--
ALTER TABLE `jsoria_comprobante`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `jsoria_detalle_institucion`
--
ALTER TABLE `jsoria_detalle_institucion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT de la tabla `jsoria_deuda_ingreso`
--
ALTER TABLE `jsoria_deuda_ingreso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=329;
--
-- AUTO_INCREMENT de la tabla `jsoria_egreso`
--
ALTER TABLE `jsoria_egreso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT de la tabla `jsoria_grado`
--
ALTER TABLE `jsoria_grado`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=72;
--
-- AUTO_INCREMENT de la tabla `jsoria_retiro`
--
ALTER TABLE `jsoria_retiro`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT de la tabla `jsoria_rubro`
--
ALTER TABLE `jsoria_rubro`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT de la tabla `jsoria_tipo_comprobante`
--
ALTER TABLE `jsoria_tipo_comprobante`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `jsoria_usuario`
--
ALTER TABLE `jsoria_usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=19;
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
  ADD CONSTRAINT `fk_detalle:institucion_categoria` FOREIGN KEY (`id_detalle_institucion`) REFERENCES `jsoria_detalle_institucion` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

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
