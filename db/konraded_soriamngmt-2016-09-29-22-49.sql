-- phpMyAdmin SQL Dump
-- version 4.0.10.14
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Sep 29, 2016 at 11:49 PM
-- Server version: 5.5.52-cll-lve
-- PHP Version: 5.6.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `konraded_soriamngmt`
--

-- --------------------------------------------------------

--
-- Table structure for table `jsoria_alumno`
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

-- --------------------------------------------------------

--
-- Table structure for table `jsoria_autorizacion`
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
-- Table structure for table `jsoria_balance`
--

CREATE TABLE IF NOT EXISTS `jsoria_balance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` date NOT NULL,
  `id_tesorera` int(11) NOT NULL,
  `ingresos` decimal(8,2) NOT NULL DEFAULT '0.00',
  `egresos` decimal(8,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `jsoria_categoria`
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `jsoria_categoria`
--

INSERT INTO `jsoria_categoria` (`id`, `nombre`, `monto`, `tipo`, `estado`, `fecha_inicio`, `fecha_fin`, `destino`, `id_detalle_institucion`, `id_matricula`) VALUES
(1, 'Cobro Extraordinario', NULL, 'cobro_extraordinario', '1', NULL, NULL, '0', 18, NULL),
(2, 'Cobro Extraordinario', NULL, 'cobro_extraordinario', '1', NULL, NULL, '0', 19, NULL),
(3, 'Cobro Extraordinario', NULL, 'cobro_extraordinario', '1', NULL, NULL, '0', 20, NULL),
(4, 'Cobro Extraordinario', NULL, 'cobro_extraordinario', '1', NULL, NULL, '0', 21, NULL),
(5, 'Cobro Extraordinario', NULL, 'cobro_extraordinario', '1', NULL, NULL, '1', 18, NULL),
(6, 'Cobro Extraordinario', NULL, 'cobro_extraordinario', '1', NULL, NULL, '1', 19, NULL),
(7, 'Cobro Extraordinario', NULL, 'cobro_extraordinario', '1', NULL, NULL, '1', 20, NULL),
(8, 'Cobro Extraordinario', NULL, 'cobro_extraordinario', '1', NULL, NULL, '1', 21, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jsoria_comprobante`
--

CREATE TABLE IF NOT EXISTS `jsoria_comprobante` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` varchar(12) NOT NULL,
  `serie` varchar(15) DEFAULT '0001',
  `numero_comprobante` int(11) NOT NULL,
  `pad_izquierda` int(11) NOT NULL DEFAULT '8',
  `id_institucion` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `comprobante_id_institucion_foreign` (`id_institucion`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `jsoria_detalle_egreso`
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

-- --------------------------------------------------------

--
-- Table structure for table `jsoria_detalle_institucion`
--

CREATE TABLE IF NOT EXISTS `jsoria_detalle_institucion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_institucion` int(11) NOT NULL,
  `nombre_division` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_institucion_detalle_institucion_idx` (`id_institucion`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `jsoria_detalle_institucion`
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
-- Table structure for table `jsoria_deuda_ingreso`
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
  `tipo_comprobante` enum('comprobante','boleta','factura') DEFAULT NULL,
  `serie_comprobante` varchar(15) DEFAULT NULL,
  `numero_comprobante` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_categoria_deuda_idx` (`id_categoria`),
  KEY `fk_autorizacion_deuda_idx` (`id_autorizacion`),
  KEY `fk_retiro_deuda_idx` (`id_retiro`),
  KEY `fk_alumno_deuda_idx` (`id_alumno`),
  KEY `fkUsuario_Deuda_Ingreso` (`id_cajera`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `jsoria_egreso`
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `jsoria_grado`
--

CREATE TABLE IF NOT EXISTS `jsoria_grado` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_detalle` int(11) DEFAULT NULL,
  `nombre_grado` varchar(45) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_detalle_institucion_grado_idx` (`id_detalle`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=72 ;

--
-- Dumping data for table `jsoria_grado`
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
-- Table structure for table `jsoria_institucion`
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
-- Dumping data for table `jsoria_institucion`
--

INSERT INTO `jsoria_institucion` (`id`, `nombre`, `id_razon_social`, `razon_social`, `ruc`, `direccion`) VALUES
(1, 'Institución Educativa J. Soria', '1', 'Corporación Educativa J-Soria S.C.R.LTDA', '20490041339', 'Jr. Quillabamba N° 110 - Quillabamba'),
(2, 'CEBA Konrad Adenahuer', '1', 'Corporación Educativa J-Soria S.C.R.LTDA', '20490041339', 'Jr. Quillabamba N° 110 - Quillabamba'),
(3, 'Instituto Superior Tecnológico Urusayhua', '1', 'Corporación Educativa J-Soria S.C.R.LTDA', '20490041339', 'Jr. Quillabamba N° 110 - Quillabamba'),
(4, 'Universidad Líder Peruana', '2', 'Universidad Privada Líder Peruana S.A.C.', '20564356035', 'Jr. Quillabamba N° 110 - Quillabamba');

-- --------------------------------------------------------

--
-- Table structure for table `jsoria_migrations`
--

CREATE TABLE IF NOT EXISTS `jsoria_migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `jsoria_migrations`
--

INSERT INTO `jsoria_migrations` (`migration`, `batch`) VALUES
('2016_09_18_061348_add_razon_social_and_responsable_to_egreso', 1),
('2016_09_22_153014_change_user_printer_columns_to_nullable', 2),
('2016_09_22_232734_add_printer_to_comprobante', 2),
('2016_09_23_135351_add_fields_for_store_invoices', 3),
('2016_09_27_075431_add_detalle_institucion_to_table_comprobante', 4);

-- --------------------------------------------------------

--
-- Table structure for table `jsoria_permisos`
--

CREATE TABLE IF NOT EXISTS `jsoria_permisos` (
  `id_institucion` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  PRIMARY KEY (`id_institucion`,`id_usuario`),
  KEY `fk_usuario_permisos_idx` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jsoria_permisos`
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
(3, 3);

-- --------------------------------------------------------

--
-- Table structure for table `jsoria_retiro`
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `jsoria_rubro`
--

CREATE TABLE IF NOT EXISTS `jsoria_rubro` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tabla para almacenar los rubros.' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `jsoria_tipo_comprobante`
--

CREATE TABLE IF NOT EXISTS `jsoria_tipo_comprobante` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `denominacion` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `jsoria_tipo_comprobante`
--

INSERT INTO `jsoria_tipo_comprobante` (`id`, `denominacion`) VALUES
(1, 'Boleta'),
(2, 'Factura'),
(3, 'Comprobante de Pago'),
(4, 'Comprobante de Egreso'),
(5, 'Recibo por Honorario');

-- --------------------------------------------------------

--
-- Table structure for table `jsoria_usuario`
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `jsoria_usuario`
--

INSERT INTO `jsoria_usuario` (`id`, `dni`, `nombres`, `apellidos`, `tipo`, `usuario_login`, `password`, `remember_token`) VALUES
(1, '12345678', 'admin', 'admin', 'Administrador', 'admin', '$2y$10$1mMfIVg.QYQ2yPEALOWo2eIe/lKdFTOQvHmZvvXEU4.qLYOLYV5nK', 'BAid6gWF9skcmxFOnaXNAxfcOVOo2YddYHkPgNPUWX9fCWt2wfoAPGhkajBn'),
(2, '12345678', 'Jeronimo', 'Soria Mormontoy', 'Administrador', 'admin', '123456', NULL),
(3, '47055259', 'jeliseth', 'soria infantas', 'Administrador', 'jeliseth', '$2y$10$MlLClhYsYC8mC79Pl3dvguF0/7esXEqAql.KLJe/dWu7lMHPH2/4G', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jsoria_usuario_impresora`
--

CREATE TABLE IF NOT EXISTS `jsoria_usuario_impresora` (
  `id_cajera` int(11) NOT NULL,
  `tipo_impresora` varchar(20) DEFAULT NULL,
  `nombre_impresora` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_cajera`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `jsoria_autorizacion`
--
ALTER TABLE `jsoria_autorizacion`
  ADD CONSTRAINT `fk_id_alumno` FOREIGN KEY (`id_alumno`) REFERENCES `jsoria_alumno` (`nro_documento`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `jsoria_categoria`
--
ALTER TABLE `jsoria_categoria`
  ADD CONSTRAINT `fk_detalle:institucion_categoria` FOREIGN KEY (`id_detalle_institucion`) REFERENCES `jsoria_detalle_institucion` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_matricula_pension` FOREIGN KEY (`id_matricula`) REFERENCES `jsoria_categoria` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `jsoria_comprobante`
--
ALTER TABLE `jsoria_comprobante`
  ADD CONSTRAINT `comprobante_id_institucion_foreign` FOREIGN KEY (`id_institucion`) REFERENCES `jsoria_institucion` (`id`);

--
-- Constraints for table `jsoria_detalle_egreso`
--
ALTER TABLE `jsoria_detalle_egreso`
  ADD CONSTRAINT `fk_egreso_detalle_egreso` FOREIGN KEY (`id_egreso`) REFERENCES `jsoria_egreso` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_rubro_detalle_egreso` FOREIGN KEY (`id_rubro`) REFERENCES `jsoria_rubro` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `jsoria_detalle_institucion`
--
ALTER TABLE `jsoria_detalle_institucion`
  ADD CONSTRAINT `fk_institucion_detalle_institucion` FOREIGN KEY (`id_institucion`) REFERENCES `jsoria_institucion` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `jsoria_deuda_ingreso`
--
ALTER TABLE `jsoria_deuda_ingreso`
  ADD CONSTRAINT `fkUsuario_Deuda_Ingreso` FOREIGN KEY (`id_cajera`) REFERENCES `jsoria_usuario` (`id`),
  ADD CONSTRAINT `fk_alumno_deuda` FOREIGN KEY (`id_alumno`) REFERENCES `jsoria_alumno` (`nro_documento`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_autorizacion_deuda` FOREIGN KEY (`id_autorizacion`) REFERENCES `jsoria_autorizacion` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_categoria_deuda` FOREIGN KEY (`id_categoria`) REFERENCES `jsoria_categoria` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_retiro_deuda` FOREIGN KEY (`id_retiro`) REFERENCES `jsoria_retiro` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `jsoria_egreso`
--
ALTER TABLE `jsoria_egreso`
  ADD CONSTRAINT `fk_institucion_egreso_id` FOREIGN KEY (`id_institucion`) REFERENCES `jsoria_institucion` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tipo_comprobante_egreso` FOREIGN KEY (`tipo_comprobante`) REFERENCES `jsoria_tipo_comprobante` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `jsoria_grado`
--
ALTER TABLE `jsoria_grado`
  ADD CONSTRAINT `fk_detalle_institucion_grado` FOREIGN KEY (`id_detalle`) REFERENCES `jsoria_detalle_institucion` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `jsoria_permisos`
--
ALTER TABLE `jsoria_permisos`
  ADD CONSTRAINT `fk_institucion_permisos` FOREIGN KEY (`id_institucion`) REFERENCES `jsoria_institucion` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_usuario_permisos` FOREIGN KEY (`id_usuario`) REFERENCES `jsoria_usuario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `jsoria_retiro`
--
ALTER TABLE `jsoria_retiro`
  ADD CONSTRAINT `fkid_usuario_retiro` FOREIGN KEY (`id_usuario`) REFERENCES `jsoria_usuario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
