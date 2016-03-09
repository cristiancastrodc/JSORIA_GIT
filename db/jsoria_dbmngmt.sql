-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-03-2016 a las 18:13:44
-- Versión del servidor: 5.6.24
-- Versión de PHP: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `jsoria_dbmngmt`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jsoria_alumno`
--

CREATE TABLE IF NOT EXISTS `jsoria_alumno` (
  `tipo_documento` varchar(50) NOT NULL DEFAULT 'DNI',
  `nro_documento` varchar(30) NOT NULL,
  `nombres` varchar(30) NOT NULL,
  `apellidos` varchar(50) NOT NULL,
  `estado` char(1) NOT NULL DEFAULT '0' COMMENT 'El estado del alumno es 0 para no matriculado y 1 para matriculado',
  `id_grado` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `jsoria_alumno`
--

INSERT INTO `jsoria_alumno` (`tipo_documento`, `nro_documento`, `nombres`, `apellidos`, `estado`, `id_grado`) VALUES
('DNI', '01010101', 'Raul', 'Toguchi Manta', '0', NULL),
('DNI', '09090909', 'Jorge', 'Pacheco Lima', '0', NULL),
('DNI', '11111111', 'carlos', 'cabrera cabrera', '1', 31),
('DNI', '12121212', 'Hermenegildo', 'Soto Pajoy', '1', 1),
('DNI', '12345678', 'Rosana', 'Quispe Lopez', '1', 1),
('DNI', '15432112', 'Micaela', 'Paz Zapata', '1', 2),
('DNI', '22222222', 'gabriela', 'cordova villar', '1', 4),
('DNI', '23456543', 'maria', 'gomez flores', '1', 11),
('DNI', '23456654', 'Miliquiades', 'Keiko Florian', '1', 8),
('DNI', '23456787', 'Aniseto', 'Quispe Palomino', '1', 6),
('DNI', '23456789', 'Sol', 'Galarreta Castro', '1', 7),
('DNI', '23498755', 'Pancho', 'Vila de las Pelotas', '1', 13),
('DNI', '24876756', 'Rodrigo', 'Meza Castro', '0', NULL),
('DNI', '32143222', 'Pablo', 'Pinto Paredes ', '0', NULL),
('DNI', '33333333', 'micaela', 'marques peralta', '1', 1),
('DNI', '33456789', 'rupertina', 'carrasco farfan', '0', NULL),
('DNI', '34567976', 'Roberto', 'Ramos Peralta', '1', 13),
('DNI', '44444444', 'Kamila', 'Ojeda Galvan', '0', NULL),
('DNI', '45454545', 'Jessica', 'Velarde Maruri', '0', NULL),
('DNI', '55555555', 'Gaby', 'Gutierrez Guzman', '1', 67),
('DNI', '56473288', 'Romero', 'Romero Ramires', '0', NULL),
('DNI', '65434567', 'pedro', 'martines castillo', '1', 16),
('DNI', '66666666', 'Alexandra Rocio', 'Guzman Olivera', '1', 2),
('DNI', '67876545', 'Carolina', 'Carrasco Verde', '0', NULL),
('DNI', '72626272', 'Maximo', 'Romero Uchuya', '1', 1),
('DNI', '82828282', 'Susana', 'Campos Zapata', '0', NULL),
('DNI', '87654332', 'Eustaquio', 'Flores Yucra', '0', NULL),
('DNI', '87656787', 'carol', 'dias caceres', '0', NULL),
('DNI', '87678987', 'toribio', 'umeres ramos', '0', NULL),
('DNI', '88393902', 'Jessi', 'Castro Galarreta', '0', NULL),
('DNI', '92187287', 'Katerine', 'Perez Condemayta', '0', NULL),
('DNI', '98765456', 'delia', 'morales morales', '0', NULL),
('DNI', '99612345', 'Pocoyo', 'Pato Elefante', '0', NULL),
('DNI', '99999999', 'Santiago', 'Mendoza Paredes', '1', 2),
('CARNET DE EXTRANJERIA', 'CE-6685902203938', 'Robert', 'Washinton ', '0', NULL),
('CARNET DE EXTRANJERIA', 'CN-11234', 'Bill', 'Mora', '0', NULL),
('PARTIDA DE NACIMIENTO', 'PN-012222', 'juan', 'gabriel', '0', NULL);

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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

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
(7, 'RD-395', '0', '22222222', '2016-02-28');

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
) ENGINE=InnoDB AUTO_INCREMENT=247 DEFAULT CHARSET=latin1;

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
(191, 'Matricula Regular', '110.00', 'matricula', '1', '2016-02-29', '2016-07-29', '0', 4),
(192, 'Matricula Regular', '110.00', 'matricula', '1', '2016-02-29', '2016-07-29', '0', 5),
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
(231, 'Venta Uniforme', '120.00', 'multiple', '1', NULL, NULL, '0', 18),
(232, 'Uniforme', '150.00', 'multiple', '1', NULL, NULL, '1', 21),
(233, 'Actuacion', '7.00', 'actividad', '1', NULL, NULL, '0', 4),
(234, 'Libro Prácticas', '55.00', 'con_factor', '1', NULL, NULL, '0', 20),
(235, 'Certificado Estudios', '10.00', 'con_factor', '1', NULL, NULL, '1', 21),
(236, 'Campamento', '100.00', 'actividad', '1', NULL, NULL, '0', 2),
(237, 'Cobro Extraordinario', NULL, 'cobro_extraordinario', '1', NULL, NULL, '0', 18),
(238, 'Cobro Extraordinario', NULL, 'cobro_extraordinario', '1', NULL, NULL, '0', 19),
(239, 'Cobro Extraordinario', NULL, 'cobro_extraordinario', '1', NULL, NULL, '0', 20),
(240, 'Cobro Extraordinario', NULL, 'cobro_extraordinario', '1', NULL, NULL, '0', 21),
(241, 'Cobro Extraordinario', NULL, 'cobro_extraordinario', '1', NULL, NULL, '1', 18),
(242, 'Cobro Extraordinario', NULL, 'cobro_extraordinario', '1', NULL, NULL, '1', 19),
(243, 'Cobro Extraordinario', NULL, 'cobro_extraordinario', '1', NULL, NULL, '1', 20),
(244, 'Cobro Extraordinario', NULL, 'cobro_extraordinario', '1', NULL, NULL, '1', 21),
(245, 'Constancia', '200.00', 'multiple', '0', NULL, NULL, '1', 20),
(246, 'Admisión 2016-I', '150.00', 'multiple', '1', NULL, NULL, '0', 21);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jsoria_comprobante`
--

CREATE TABLE IF NOT EXISTS `jsoria_comprobante` (
  `id` int(11) NOT NULL,
  `tipo` varchar(12) NOT NULL,
  `numero_comprobante` int(11) NOT NULL,
  `id_razon_social` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jsoria_detalle_egreso`
--

CREATE TABLE IF NOT EXISTS `jsoria_detalle_egreso` (
  `id_rubro` int(11) NOT NULL,
  `id_egreso` int(11) NOT NULL,
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
  `estado_pago` char(1) DEFAULT '0',
  `estado_retiro` char(1) NOT NULL DEFAULT '0',
  `estado_descuento` char(1) NOT NULL DEFAULT '0',
  `estado_fraccionam` char(1) NOT NULL DEFAULT '0',
  `cliente_extr` varchar(50) DEFAULT NULL,
  `descripcion_extr` varchar(50) DEFAULT NULL,
  `fecha_hora_ingreso` datetime DEFAULT CURRENT_TIMESTAMP,
  `id_categoria` int(11) NOT NULL,
  `id_alumno` varchar(30) DEFAULT NULL,
  `id_autorizacion` int(11) DEFAULT NULL,
  `id_retiro` int(11) DEFAULT NULL,
  `id_cajera` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=245 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `jsoria_deuda_ingreso`
--

INSERT INTO `jsoria_deuda_ingreso` (`id`, `saldo`, `descuento`, `estado_pago`, `estado_retiro`, `estado_descuento`, `estado_fraccionam`, `cliente_extr`, `descripcion_extr`, `fecha_hora_ingreso`, `id_categoria`, `id_alumno`, `id_autorizacion`, `id_retiro`, `id_cajera`) VALUES
(1, 220.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 18, '12345678', NULL, NULL, NULL),
(2, 220.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 18, '12121212', NULL, NULL, NULL),
(3, 220.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 19, '11111111', NULL, NULL, NULL),
(4, 100.00, 11.00, '0', '0', '0', '0', NULL, NULL, NULL, 111, '11111111', NULL, NULL, NULL),
(5, 100.00, 11.00, '0', '0', '0', '0', NULL, NULL, NULL, 115, '11111111', NULL, NULL, NULL),
(6, 100.00, 11.00, '0', '0', '0', '0', NULL, NULL, NULL, 118, '11111111', NULL, NULL, NULL),
(7, 100.00, 11.00, '0', '0', '0', '0', NULL, NULL, NULL, 121, '11111111', NULL, NULL, NULL),
(8, 100.00, 11.00, '0', '0', '0', '0', NULL, NULL, NULL, 124, '11111111', NULL, NULL, NULL),
(9, 100.00, 11.00, '0', '0', '0', '0', NULL, NULL, NULL, 127, '11111111', NULL, NULL, NULL),
(10, 100.00, 11.00, '0', '0', '0', '0', NULL, NULL, NULL, 130, '11111111', NULL, NULL, NULL),
(11, 100.00, 11.00, '0', '0', '0', '0', NULL, NULL, NULL, 133, '11111111', NULL, NULL, NULL),
(12, 100.00, 11.00, '0', '0', '0', '0', NULL, NULL, NULL, 136, '11111111', NULL, NULL, NULL),
(13, 100.00, 11.00, '0', '0', '0', '0', NULL, NULL, NULL, 139, '11111111', NULL, NULL, NULL),
(14, 110.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 20, '22222222', NULL, NULL, NULL),
(15, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 112, '22222222', NULL, NULL, NULL),
(16, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 114, '22222222', NULL, NULL, NULL),
(17, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 117, '22222222', NULL, NULL, NULL),
(18, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 120, '22222222', NULL, NULL, NULL),
(19, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 123, '22222222', NULL, NULL, NULL),
(20, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 126, '22222222', NULL, NULL, NULL),
(21, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 129, '22222222', NULL, NULL, NULL),
(22, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 132, '22222222', NULL, NULL, NULL),
(23, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 135, '22222222', NULL, NULL, NULL),
(24, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 138, '22222222', NULL, NULL, NULL),
(25, 220.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 18, '33333333', NULL, NULL, NULL),
(26, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 110, '33333333', NULL, NULL, NULL),
(27, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 113, '33333333', NULL, NULL, NULL),
(28, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 116, '33333333', NULL, NULL, NULL),
(29, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 119, '33333333', NULL, NULL, NULL),
(30, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 122, '33333333', NULL, NULL, NULL),
(31, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 125, '33333333', NULL, NULL, NULL),
(32, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 128, '33333333', NULL, NULL, NULL),
(33, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 131, '33333333', NULL, NULL, NULL),
(34, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 134, '33333333', NULL, NULL, NULL),
(35, 150.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 137, '33333333', NULL, NULL, NULL),
(36, 110.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 20, '15432112', NULL, NULL, NULL),
(37, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 112, '15432112', NULL, NULL, NULL),
(38, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 114, '15432112', NULL, NULL, NULL),
(39, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 117, '15432112', NULL, NULL, NULL),
(40, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 120, '15432112', NULL, NULL, NULL),
(41, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 123, '15432112', NULL, NULL, NULL),
(42, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 126, '15432112', NULL, NULL, NULL),
(43, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 129, '15432112', NULL, NULL, NULL),
(44, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 132, '15432112', NULL, NULL, NULL),
(45, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 135, '15432112', NULL, NULL, NULL),
(46, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 138, '15432112', NULL, NULL, NULL),
(47, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 11, '23456543', NULL, NULL, NULL),
(48, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 35, '23456543', NULL, NULL, NULL),
(49, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 43, '23456543', NULL, NULL, NULL),
(50, 110.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 62, '23456543', NULL, NULL, NULL),
(51, 110.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 69, '23456543', NULL, NULL, NULL),
(52, 110.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 76, '23456543', NULL, NULL, NULL),
(53, 110.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 83, '23456543', NULL, NULL, NULL),
(54, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 7, '23456654', NULL, NULL, NULL),
(55, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 33, '23456654', NULL, NULL, NULL),
(56, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 40, '23456654', NULL, NULL, NULL),
(57, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 58, '23456654', NULL, NULL, NULL),
(58, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 66, '23456654', NULL, NULL, NULL),
(59, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 73, '23456654', NULL, NULL, NULL),
(60, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 80, '23456654', NULL, NULL, NULL),
(61, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 6, '23456787', NULL, NULL, NULL),
(62, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 31, '23456787', NULL, NULL, NULL),
(63, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 38, '23456787', NULL, NULL, NULL),
(64, 150.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 57, '23456787', NULL, NULL, NULL),
(65, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 64, '23456787', NULL, NULL, NULL),
(66, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 71, '23456787', NULL, NULL, NULL),
(67, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 78, '23456787', NULL, NULL, NULL),
(68, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 8, '23456789', NULL, NULL, NULL),
(69, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 34, '23456789', NULL, NULL, NULL),
(70, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 39, '23456789', NULL, NULL, NULL),
(71, 110.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 59, '23456789', NULL, NULL, NULL),
(72, 110.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 65, '23456789', NULL, NULL, NULL),
(73, 110.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 72, '23456789', NULL, NULL, NULL),
(74, 110.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 79, '23456789', NULL, NULL, NULL),
(75, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 13, '23498755', NULL, NULL, NULL),
(76, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 21, '23498755', NULL, NULL, NULL),
(77, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 26, '23498755', NULL, NULL, NULL),
(78, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 85, '23498755', NULL, NULL, NULL),
(79, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 90, '23498755', NULL, NULL, NULL),
(80, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 95, '23498755', NULL, NULL, NULL),
(81, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 100, '23498755', NULL, NULL, NULL),
(82, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 105, '23498755', NULL, NULL, NULL),
(83, 100.00, 0.00, '1', '0', '0', '0', NULL, NULL, NULL, 17, '65434567', NULL, NULL, NULL),
(84, 100.00, 0.00, '1', '0', '0', '0', NULL, NULL, NULL, 24, '65434567', NULL, NULL, NULL),
(85, 100.00, 0.00, '1', '0', '0', '0', NULL, NULL, NULL, 29, '65434567', NULL, NULL, NULL),
(86, 110.00, 0.00, '1', '0', '0', '0', NULL, NULL, NULL, 87, '65434567', NULL, NULL, NULL),
(87, 110.00, 0.00, '1', '0', '0', '0', NULL, NULL, NULL, 93, '65434567', NULL, NULL, NULL),
(88, 110.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 98, '65434567', NULL, NULL, NULL),
(89, 110.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 103, '65434567', NULL, NULL, NULL),
(90, 110.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 108, '65434567', NULL, NULL, NULL),
(91, 100.00, 0.00, '1', '0', '0', '0', NULL, NULL, NULL, 17, '65434567', NULL, NULL, NULL),
(92, 100.00, 0.00, '1', '0', '0', '0', NULL, NULL, NULL, 24, '65434567', NULL, NULL, NULL),
(93, 100.00, 0.00, '1', '0', '0', '0', NULL, NULL, NULL, 29, '65434567', NULL, NULL, NULL),
(94, 110.00, 0.00, '1', '0', '0', '0', NULL, NULL, NULL, 87, '65434567', NULL, NULL, NULL),
(95, 110.00, 0.00, '1', '0', '0', '0', NULL, NULL, NULL, 93, '65434567', NULL, NULL, NULL),
(96, 110.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 98, '65434567', NULL, NULL, NULL),
(97, 110.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 103, '65434567', NULL, NULL, NULL),
(98, 110.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 108, '65434567', NULL, NULL, NULL),
(99, 110.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 20, '99999999', NULL, NULL, NULL),
(100, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 112, '99999999', NULL, NULL, NULL),
(101, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 114, '99999999', NULL, NULL, NULL),
(102, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 117, '99999999', NULL, NULL, NULL),
(103, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 120, '99999999', NULL, NULL, NULL),
(104, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 123, '99999999', NULL, NULL, NULL),
(105, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 126, '99999999', NULL, NULL, NULL),
(106, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 129, '99999999', NULL, NULL, NULL),
(107, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 132, '99999999', NULL, NULL, NULL),
(108, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 135, '99999999', NULL, NULL, NULL),
(109, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 138, '99999999', NULL, NULL, NULL),
(110, 220.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 18, '72626272', NULL, NULL, NULL),
(111, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 110, '72626272', NULL, NULL, NULL),
(112, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 113, '72626272', NULL, NULL, NULL),
(113, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 116, '72626272', NULL, NULL, NULL),
(114, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 119, '72626272', NULL, NULL, NULL),
(115, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 122, '72626272', NULL, NULL, NULL),
(116, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 125, '72626272', NULL, NULL, NULL),
(117, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 128, '72626272', NULL, NULL, NULL),
(118, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 131, '72626272', NULL, NULL, NULL),
(119, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 134, '72626272', NULL, NULL, NULL),
(120, 150.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 137, '72626272', NULL, NULL, NULL),
(121, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 161, '72626272', NULL, NULL, NULL),
(122, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 162, '72626272', NULL, NULL, NULL),
(123, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 167, '72626272', NULL, NULL, NULL),
(124, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 170, '72626272', NULL, NULL, NULL),
(125, 200.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 173, '72626272', NULL, NULL, NULL),
(126, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 176, '72626272', NULL, NULL, NULL),
(127, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 179, '72626272', NULL, NULL, NULL),
(128, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 182, '72626272', NULL, NULL, NULL),
(129, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 185, '72626272', NULL, NULL, NULL),
(130, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 188, '72626272', NULL, NULL, NULL),
(131, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 217, NULL, NULL, NULL, NULL),
(132, 120.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 219, '65434567', NULL, NULL, NULL),
(133, 20.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 221, '23456543', NULL, NULL, NULL),
(134, 20.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 221, '23498755', NULL, NULL, NULL),
(135, 10.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 222, '12121212', NULL, NULL, NULL),
(136, 10.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 222, '12345678', NULL, NULL, NULL),
(137, 10.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 222, '33333333', NULL, NULL, NULL),
(138, 10.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 222, '72626272', NULL, NULL, NULL),
(139, 10.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 222, '15432112', NULL, NULL, NULL),
(140, 10.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 222, '22222222', NULL, NULL, NULL),
(141, 10.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 222, '99999999', NULL, NULL, NULL),
(142, 10.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 222, '11111111', NULL, NULL, NULL),
(143, 10.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 223, '23456787', NULL, NULL, NULL),
(144, 10.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 223, '23456789', NULL, NULL, NULL),
(145, 10.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 223, '23456654', NULL, NULL, NULL),
(146, 10.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 224, '23456543', NULL, NULL, NULL),
(147, 10.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 224, '23498755', NULL, NULL, NULL),
(148, 7.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 233, '65434567', NULL, NULL, NULL),
(149, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 236, '23456787', NULL, NULL, NULL),
(150, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 236, '23456789', NULL, NULL, NULL),
(151, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 236, '23456654', NULL, NULL, NULL),
(152, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 11, '01010101', NULL, NULL, NULL),
(153, 110.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 62, '01010101', NULL, NULL, NULL),
(154, 110.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 69, '01010101', NULL, NULL, NULL),
(155, 110.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 76, '01010101', NULL, NULL, NULL),
(156, 110.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 83, '01010101', NULL, NULL, NULL),
(157, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 11, '01010101', NULL, NULL, NULL),
(158, 110.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 62, '01010101', NULL, NULL, NULL),
(159, 110.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 69, '01010101', NULL, NULL, NULL),
(160, 110.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 76, '01010101', NULL, NULL, NULL),
(161, 110.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 83, '01010101', NULL, NULL, NULL),
(162, 500.00, 0.00, '0', '0', '0', '0', 'Sr. Antonio Banderas', 'Alquiler de Local', NULL, 240, NULL, NULL, NULL, NULL),
(163, 550.00, 0.00, '0', '0', '0', '0', 'Inversiones Requeridas S.A.C', 'Venta de carpetas de segunda mano', NULL, 241, NULL, NULL, NULL, NULL),
(164, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 7, 'PN-012222', NULL, NULL, NULL),
(165, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 58, 'PN-012222', NULL, NULL, NULL),
(166, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 66, 'PN-012222', NULL, NULL, NULL),
(167, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 73, 'PN-012222', NULL, NULL, NULL),
(168, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 80, 'PN-012222', NULL, NULL, NULL),
(169, 150.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 20, '22222222', NULL, NULL, NULL),
(170, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 112, '22222222', NULL, NULL, NULL),
(171, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 114, '22222222', NULL, NULL, NULL),
(172, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 117, '22222222', NULL, NULL, NULL),
(173, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 120, '22222222', NULL, NULL, NULL),
(174, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 123, '22222222', NULL, NULL, NULL),
(175, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 126, '22222222', NULL, NULL, NULL),
(176, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 129, '22222222', NULL, NULL, NULL),
(177, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 132, '22222222', NULL, NULL, NULL),
(178, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 135, '22222222', NULL, NULL, NULL),
(179, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 138, '22222222', NULL, NULL, NULL),
(180, 110.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 163, '22222222', NULL, NULL, NULL),
(181, 110.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 166, '22222222', NULL, NULL, NULL),
(182, 110.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 168, '22222222', NULL, NULL, NULL),
(183, 110.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 171, '22222222', NULL, NULL, NULL),
(184, 110.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 174, '22222222', NULL, NULL, NULL),
(185, 110.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 177, '22222222', NULL, NULL, NULL),
(186, 110.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 180, '22222222', NULL, NULL, NULL),
(187, 110.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 183, '22222222', NULL, NULL, NULL),
(188, 110.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 186, '22222222', NULL, NULL, NULL),
(189, 110.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 189, '22222222', NULL, NULL, NULL),
(190, 220.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 18, '66666666', NULL, NULL, NULL),
(191, 190.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 110, '66666666', NULL, NULL, NULL),
(192, 190.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 113, '66666666', NULL, NULL, NULL),
(193, 200.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 116, '66666666', NULL, NULL, NULL),
(194, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 119, '66666666', NULL, NULL, NULL),
(195, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 122, '66666666', NULL, NULL, NULL),
(196, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 125, '66666666', NULL, NULL, NULL),
(197, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 128, '66666666', NULL, NULL, NULL),
(198, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 131, '66666666', NULL, NULL, NULL),
(199, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 134, '66666666', NULL, NULL, NULL),
(200, 150.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 137, '66666666', NULL, NULL, NULL),
(201, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 161, '66666666', NULL, NULL, NULL),
(202, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 162, '66666666', NULL, NULL, NULL),
(203, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 167, '66666666', NULL, NULL, NULL),
(204, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 170, '66666666', NULL, NULL, NULL),
(205, 200.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 173, '66666666', NULL, NULL, NULL),
(206, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 176, '66666666', NULL, NULL, NULL),
(207, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 179, '66666666', NULL, NULL, NULL),
(208, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 182, '66666666', NULL, NULL, NULL),
(209, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 185, '66666666', NULL, NULL, NULL),
(210, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 188, '66666666', NULL, NULL, NULL),
(211, 220.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 19, '34567976', NULL, NULL, NULL),
(212, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 111, '34567976', NULL, NULL, NULL),
(213, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 115, '34567976', NULL, NULL, NULL),
(214, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 118, '34567976', NULL, NULL, NULL),
(215, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 121, '34567976', NULL, NULL, NULL),
(216, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 124, '34567976', NULL, NULL, NULL),
(217, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 127, '34567976', NULL, NULL, NULL),
(218, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 130, '34567976', NULL, NULL, NULL),
(219, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 133, '34567976', NULL, NULL, NULL),
(220, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 136, '34567976', NULL, NULL, NULL),
(221, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 139, '34567976', NULL, NULL, NULL),
(222, 120.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 164, '34567976', NULL, NULL, NULL),
(223, 120.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 165, '34567976', NULL, NULL, NULL),
(224, 120.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 169, '34567976', NULL, NULL, NULL),
(225, 120.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 172, '34567976', NULL, NULL, NULL),
(226, 120.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 175, '34567976', NULL, NULL, NULL),
(227, 120.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 178, '34567976', NULL, NULL, NULL),
(228, 120.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 181, '34567976', NULL, NULL, NULL),
(229, 120.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 184, '34567976', NULL, NULL, NULL),
(230, 120.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 187, '34567976', NULL, NULL, NULL),
(231, 120.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 190, '34567976', NULL, NULL, NULL),
(232, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 13, '55555555', NULL, NULL, NULL),
(233, 100.00, 15.00, '0', '0', '0', '0', NULL, NULL, NULL, 85, '55555555', NULL, NULL, NULL),
(234, 100.00, 15.00, '0', '0', '0', '0', NULL, NULL, NULL, 90, '55555555', NULL, NULL, NULL),
(235, 100.00, 15.00, '0', '0', '0', '0', NULL, NULL, NULL, 95, '55555555', NULL, NULL, NULL),
(236, 100.00, 15.00, '0', '0', '0', '0', NULL, NULL, NULL, 100, '55555555', NULL, NULL, NULL),
(237, 100.00, 15.00, '0', '0', '0', '0', NULL, NULL, NULL, 105, '55555555', NULL, NULL, NULL),
(238, 100.00, 0.00, '0', '0', '0', '0', NULL, NULL, NULL, 8, '11111111', NULL, NULL, NULL),
(239, 110.00, 12.10, '0', '0', '0', '0', NULL, NULL, NULL, 59, '11111111', NULL, NULL, NULL),
(240, 110.00, 12.10, '0', '0', '0', '0', NULL, NULL, NULL, 65, '11111111', NULL, NULL, NULL),
(241, 110.00, 12.10, '0', '0', '0', '0', NULL, NULL, NULL, 72, '11111111', NULL, NULL, NULL),
(242, 110.00, 12.10, '0', '0', '0', '0', NULL, NULL, NULL, 79, '11111111', NULL, NULL, NULL),
(243, 1.50, 0.00, '1', '0', '0', '0', NULL, NULL, '2016-03-07 23:44:09', 228, '65434567', NULL, NULL, NULL),
(244, 1.50, 0.00, '1', '0', '0', '0', NULL, NULL, '2016-03-07 23:54:33', 228, '65434567', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jsoria_egreso`
--

CREATE TABLE IF NOT EXISTS `jsoria_egreso` (
  `id` int(11) NOT NULL,
  `tipo_comprobante` varchar(12) NOT NULL,
  `numero_comprobante` varchar(30) NOT NULL,
  `fecha` date NOT NULL,
  `id_institucion` int(11) NOT NULL
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
(25, 6, 'Ciclo I'),
(26, 6, 'Ciclo II'),
(27, 6, 'Ciclo III'),
(28, 6, 'Ciclo IV'),
(29, 6, 'Ciclo V'),
(30, 6, 'Ciclo VI'),
(31, 7, 'Ciclo I'),
(32, 7, 'Ciclo II'),
(33, 7, 'Ciclo III'),
(34, 7, 'Ciclo IV'),
(35, 7, 'Ciclo V'),
(36, 7, 'Ciclo VI'),
(37, 8, 'Ciclo I'),
(38, 8, 'Ciclo II'),
(39, 8, 'Ciclo III'),
(40, 8, 'Ciclo IV'),
(41, 8, 'Ciclo V'),
(42, 8, 'Ciclo VI'),
(43, 9, 'Ciclo I'),
(44, 9, 'Ciclo II'),
(45, 9, 'Ciclo III'),
(46, 9, 'Ciclo IV'),
(47, 9, 'Ciclo V'),
(48, 9, 'Ciclo VI'),
(49, 10, 'Ciclo I'),
(50, 10, 'Ciclo II'),
(51, 10, 'Ciclo III'),
(52, 10, 'Ciclo IV'),
(53, 10, 'Ciclo V'),
(54, 10, 'Ciclo VI'),
(55, 11, 'Ciclo I'),
(56, 11, 'Ciclo II'),
(57, 11, 'Ciclo III'),
(58, 11, 'Ciclo IV'),
(59, 11, 'Ciclo V'),
(60, 11, 'Ciclo VI'),
(61, 12, 'Ciclo I'),
(62, 12, 'Ciclo II'),
(63, 12, 'Ciclo III'),
(64, 12, 'Ciclo IV'),
(65, 12, 'Ciclo V'),
(66, 12, 'Ciclo VI'),
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
(4, 8),
(1, 10),
(3, 11),
(4, 12),
(1, 13),
(2, 13),
(3, 13),
(4, 15),
(1, 16);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jsoria_retiro`
--

CREATE TABLE IF NOT EXISTS `jsoria_retiro` (
  `id` int(11) NOT NULL,
  `monto` double(8,2) DEFAULT NULL,
  `fecha_hora` datetime DEFAULT NULL,
  `estado` char(1) DEFAULT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jsoria_rubro`
--

CREATE TABLE IF NOT EXISTS `jsoria_rubro` (
  `id` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1 COMMENT='Esta tabla almacena los rubros.';

--
-- Volcado de datos para la tabla `jsoria_rubro`
--

INSERT INTO `jsoria_rubro` (`id`, `nombre`) VALUES
(1, 'Movilidad'),
(2, 'Muebles'),
(3, 'Equipos'),
(4, 'moneda'),
(5, 'compras'),
(6, 'joji'),
(7, 'asd'),
(8, 'hdu'),
(9, 'qwerg');

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
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `jsoria_usuario`
--

INSERT INTO `jsoria_usuario` (`id`, `dni`, `nombres`, `apellidos`, `tipo`, `usuario_login`, `password`, `remember_token`) VALUES
(7, '12324432', 'Jeronimo', 'Soria Mormontoy', 'Administrador', 'admin', '$2y$10$L7ll7zPYKkD9RHB04e4k5O5Unid2NeVyyaakwD5B.SXxVv3smw0Vy', 'bu1xuWJqrrEkv5hPYrAdpohv3nFAn4s7KFXUWlm8MaQlXgQhml9vQLMLer2v'),
(8, '78665546', 'Carmen', 'Cajera', 'Cajera', 'cajera', '$2y$10$V6E1ye2vZkkynW8PKLLgF.Qv0SIdSOGFsZyNJ1dZKzVLti2DzoEm.', 'h848s4XeI0WGUdJFKCPBdbNbOfWDkx99Xf9od1BSuCKJM8jnkHn8TLSN72wU'),
(10, '23432546', 'Secretaria', 'CEBA3', 'Secretaria', 'secretaria2', '$2y$10$CJognbVvQWssmZ.RueCgHOg/uXWBGtWJKTbVqywoq1IhjjaetOr.W', 'nThXt9tXwk01imboJwvlfv6tea34490IJLJgG1VqRmpif2Tk787tIHmCDTYz'),
(11, '34354355', 'Secretaria', 'Instituto', 'Secretaria', 'secretaria3', '$2y$10$pn4iSXBJXGny9U9igqfkgu8MB42ulfTtffznJ5XzDM620quRcvGEu', 'j2a8QAc1EBSOrUpuH189OH81aZeTilviyA8kJFSZCydOC5iTF9uVZvuxnQOI'),
(12, '23434645', 'Secretaria', 'ULP', 'Secretaria', 'secretaria4', '$2y$10$wJc.HSR718MjetmW/6e9beQ0E4UB5eOiLkQALpd72k.KpW7jP1nLS', 'HAjB3tG2ytlgF20vjV0VnL5ztnwxYgDbvHvGTScK07WI34gTFEwLPjVCWnKv'),
(13, '81762668', 'Tesorera', 'Corporacion', 'Tesorera', 'tesorera1', '$2y$10$beNc70KJ.KSMpu9.FAjbaOVJckgoHpVww61pa3eaTSaP1bmrxdFgi', 'zUhiNdF9gaDpxlv74ObLQaQMkjlzRydWPpUmqVAg1zxPzrbrz8RIoypfFCPK'),
(15, '23435345', 'Tesorera', 'ULP', 'Tesorera', 'tesorera2', '$2y$10$yXnKMzrivTV0Jj..CwEcxeGJK0EKkTYx2i593JcnVPEp84CRiFP9q', NULL),
(16, '98767897', 'Sabrina', 'I.E. J. Soria', 'Secretaria', 'secretaria1', '$2y$10$5OVQTQVeP0uGRCl2SfrYvOCnLCEiDMR.YNq2jGY8FNjkeScsiVxLG', 'L9rYbpHBsu6e0wMDOulHLJSMMzIUVlfoGhT9igOV3jqGmn0GyCcaYSsoRJHx');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `jsoria_alumno`
--
ALTER TABLE `jsoria_alumno`
  ADD PRIMARY KEY (`nro_documento`), ADD KEY `fk_grado_alumno_idx` (`id_grado`);

--
-- Indices de la tabla `jsoria_autorizacion`
--
ALTER TABLE `jsoria_autorizacion`
  ADD PRIMARY KEY (`id`), ADD KEY `fk_id_alumno_idx` (`id_alumno`);

--
-- Indices de la tabla `jsoria_categoria`
--
ALTER TABLE `jsoria_categoria`
  ADD PRIMARY KEY (`id`), ADD KEY `fk_detalle:institucion_categoria_idx` (`id_detalle_institucion`);

--
-- Indices de la tabla `jsoria_comprobante`
--
ALTER TABLE `jsoria_comprobante`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `jsoria_detalle_egreso`
--
ALTER TABLE `jsoria_detalle_egreso`
  ADD PRIMARY KEY (`id_egreso`,`id_rubro`), ADD KEY `fk_rubro_idx` (`id_rubro`);

--
-- Indices de la tabla `jsoria_detalle_institucion`
--
ALTER TABLE `jsoria_detalle_institucion`
  ADD PRIMARY KEY (`id`), ADD KEY `fk_institucion_detalle_institucion_idx` (`id_institucion`);

--
-- Indices de la tabla `jsoria_deuda_ingreso`
--
ALTER TABLE `jsoria_deuda_ingreso`
  ADD PRIMARY KEY (`id`), ADD KEY `fk_categoria_deuda_idx` (`id_categoria`), ADD KEY `fk_autorizacion_deuda_idx` (`id_autorizacion`), ADD KEY `fk_retiro_deuda_idx` (`id_retiro`), ADD KEY `fk_alumno_deuda_idx` (`id_alumno`);

--
-- Indices de la tabla `jsoria_egreso`
--
ALTER TABLE `jsoria_egreso`
  ADD PRIMARY KEY (`id`), ADD KEY `id_idx` (`id_institucion`);

--
-- Indices de la tabla `jsoria_grado`
--
ALTER TABLE `jsoria_grado`
  ADD PRIMARY KEY (`id`), ADD KEY `fk_detalle_institucion_grado_idx` (`id_detalle`);

--
-- Indices de la tabla `jsoria_institucion`
--
ALTER TABLE `jsoria_institucion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `jsoria_permisos`
--
ALTER TABLE `jsoria_permisos`
  ADD PRIMARY KEY (`id_institucion`,`id_usuario`), ADD KEY `fk_usuario_permisos_idx` (`id_usuario`);

--
-- Indices de la tabla `jsoria_retiro`
--
ALTER TABLE `jsoria_retiro`
  ADD PRIMARY KEY (`id`), ADD KEY `fkid_usuario_retiro_idx` (`id_usuario`);

--
-- Indices de la tabla `jsoria_rubro`
--
ALTER TABLE `jsoria_rubro`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `jsoria_usuario`
--
ALTER TABLE `jsoria_usuario`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `jsoria_autorizacion`
--
ALTER TABLE `jsoria_autorizacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT de la tabla `jsoria_categoria`
--
ALTER TABLE `jsoria_categoria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=247;
--
-- AUTO_INCREMENT de la tabla `jsoria_comprobante`
--
ALTER TABLE `jsoria_comprobante`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `jsoria_detalle_institucion`
--
ALTER TABLE `jsoria_detalle_institucion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT de la tabla `jsoria_deuda_ingreso`
--
ALTER TABLE `jsoria_deuda_ingreso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=245;
--
-- AUTO_INCREMENT de la tabla `jsoria_grado`
--
ALTER TABLE `jsoria_grado`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=72;
--
-- AUTO_INCREMENT de la tabla `jsoria_retiro`
--
ALTER TABLE `jsoria_retiro`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `jsoria_rubro`
--
ALTER TABLE `jsoria_rubro`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT de la tabla `jsoria_usuario`
--
ALTER TABLE `jsoria_usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=17;
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
ADD CONSTRAINT `fk_egreso_detalle_egreso` FOREIGN KEY (`id_egreso`) REFERENCES `jsoria_egreso` (`id`) ON UPDATE CASCADE,
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
ADD CONSTRAINT `fk_alumno_deuda` FOREIGN KEY (`id_alumno`) REFERENCES `jsoria_alumno` (`nro_documento`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_autorizacion_deuda` FOREIGN KEY (`id_autorizacion`) REFERENCES `jsoria_autorizacion` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_categoria_deuda` FOREIGN KEY (`id_categoria`) REFERENCES `jsoria_categoria` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_retiro_deuda` FOREIGN KEY (`id_retiro`) REFERENCES `jsoria_retiro` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `jsoria_egreso`
--
ALTER TABLE `jsoria_egreso`
ADD CONSTRAINT `fk_institucion_egreso_id` FOREIGN KEY (`id_institucion`) REFERENCES `jsoria_institucion` (`id`) ON UPDATE CASCADE;

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
