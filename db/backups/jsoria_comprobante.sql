-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-02-2016 a las 04:37:48
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
-- Estructura de tabla para la tabla `jsoria_comprobante`
--

CREATE TABLE IF NOT EXISTS `jsoria_comprobante` (
  `id` int(11) NOT NULL,
  `tipo` varchar(12) NOT NULL,
  `numero_comprobante` int(11) NOT NULL,
  `id_institucion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `jsoria_comprobante`
--
ALTER TABLE `jsoria_comprobante`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_institucion_comprobante_idx` (`id_institucion`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `jsoria_comprobante`
--
ALTER TABLE `jsoria_comprobante`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `jsoria_comprobante`
--
ALTER TABLE `jsoria_comprobante`
  ADD CONSTRAINT `fk_institucion_comprobante` FOREIGN KEY (`id_institucion`) REFERENCES `jsoria_institucion` (`id`) ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
