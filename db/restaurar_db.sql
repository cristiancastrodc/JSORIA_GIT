/********** VACIAR OTRAS TABLAS **********/
TRUNCATE jsoria_detalle_egreso;
-- TRUNCATE jsoria_rubro;
DELETE FROM jsoria_rubro;
ALTER TABLE jsoria_rubro AUTO_INCREMENT =1;
-- TRUNCATE jsoria_egreso;
DELETE FROM jsoria_egreso;
ALTER TABLE jsoria_egreso AUTO_INCREMENT =1;
TRUNCATE jsoria_comprobante;
-- TRUNCATE jsoria_autorizacion;
DELETE FROM jsoria_autorizacion;
ALTER TABLE jsoria_autorizacion AUTO_INCREMENT =1;
TRUNCATE jsoria_deuda_ingreso;
-- TRUNCATE jsoria_retiro;
DELETE FROM jsoria_retiro;
ALTER TABLE jsoria_retiro AUTO_INCREMENT =1;
-- TRUNCATE jsoria_alumno;
DELETE FROM jsoria_alumno;
-- TRUNCATE jsoria_categoria;
DELETE FROM jsoria_categoria;
ALTER TABLE jsoria_categoria AUTO_INCREMENT =1;
TRUNCATE jsoria_grado;
-- TRUNCATE jsoria_detalle_institucion;
DELETE FROM jsoria_detalle_institucion;
ALTER TABLE jsoria_detalle_institucion AUTO_INCREMENT =1;
DELETE FROM jsoria_permisos;
TRUNCATE jsoria_balance;
TRUNCATE jsoria_usuario_impresora;
-- TRUNCATE jsoria_usuario;
DELETE FROM jsoria_usuario WHERE id NOT IN (1);
ALTER TABLE jsoria_usuario AUTO_INCREMENT =2;
-- TRUNCATE jsoria_institucion;
DELETE FROM jsoria_institucion;
ALTER TABLE jsoria_institucion AUTO_INCREMENT =1;
-- TRUNCATE jsoria_tipo_comprobante;
DELETE FROM jsoria_tipo_comprobante;
ALTER TABLE jsoria_tipo_comprobante AUTO_INCREMENT =1;
/********** TABLA INSTITUCION **********/
-- Institucion: Todo
INSERT INTO jsoria_institucion(nombre, id_razon_social, razon_social, ruc, direccion) VALUES
('Institución Educativa J. Soria', '1', 'Corporación Educativa J-Soria S.C.R.LTDA', '20490041339', 'Jr. Quillabamba N° 110 - Quillabamba'),
('CEBA Konrad Adenahuer', '1', 'Corporación Educativa J-Soria S.C.R.LTDA', '20490041339', 'Jr. Quillabamba N° 110 - Quillabamba'),
('Instituto Superior Tecnológico Urusayhua', '1', 'Corporación Educativa J-Soria S.C.R.LTDA', '20490041339', 'Jr. Quillabamba N° 110 - Quillabamba'),
('Universidad Líder Peruana', '2', 'Universidad Privada Líder Peruana S.A.C.', '20564356035', 'Jr. Quillabamba N° 110 - Quillabamba');
/********** TABLA DETALLE INSTITUCION **********/
-- Detalle Institucion: Todo
INSERT INTO jsoria_detalle_institucion (id_institucion, nombre_division) VALUES
(1, 'Inicial'),
(1, 'Primaria'),
(1, 'Secundaria'),
(2, 'Primaria'),
(2, 'Secundaria'),
(3, 'Contabilidad'),
(3, 'Enfermería'),
(3, 'Construcción Civil'),
(3, 'Farmacia'),
(3, 'Guía Oficial de Turismo'),
(3, 'Administración de Empresas'),
(3, 'Computación e Informática'),
(4, 'Ingeniería de Sistemas e Informática'),
(4, 'Contabilidad'),
(4, 'Economía'),
(4, 'Ingeniería Civil'),
(4, 'Ingeniería Ambiental'),
(1, 'Todo'),
(2, 'Todo'),
(3, 'Todo'),
(4, 'Todo');
/********** TABLA GRADO **********/
-- Grado: Todo
INSERT INTO jsoria_grado (id_detalle, nombre_grado) VALUES
(1, '3 años'),
(1, '4 años'),
(1, '5 años'),
(2, '1° grado'),
(2, '2° grado'),
(2, '3° grado'),
(2, '4° grado'),
(2, '5° grado'),
(2, '6° grado'),
(3, '1° grado'),
(3, '2° grado'),
(3, '3° grado'),
(3, '4° grado'),
(3, '5° grado'),
(4, '1° grado'),
(4, '2° grado'),
(4, '3° grado'),
(4, '4° grado'),
(4, '5° grado'),
(4, '6° grado'),
(5, '1° grado'),
(5, '2° grado'),
(5, '3° grado'),
(5, '4° grado'),
(6, 'Semestre I'),
(6, 'Semestre II'),
(6, 'Semestre III'),
(6, 'Semestre IV'),
(6, 'Semestre V'),
(6, 'Semestre VI'),
(7, 'Semestre I'),
(7, 'Semestre II'),
(7, 'Semestre III'),
(7, 'Semestre IV'),
(7, 'Semestre V'),
(7, 'Semestre VI'),
(8, 'Semestre I'),
(8, 'Semestre II'),
(8, 'Semestre III'),
(8, 'Semestre IV'),
(8, 'Semestre V'),
(8, 'Semestre VI'),
(9, 'Semestre I'),
(9, 'Semestre II'),
(9, 'Semestre III'),
(9, 'Semestre IV'),
(9, 'Semestre V'),
(9, 'Semestre VI'),
(10, 'Semestre I'),
(10, 'Semestre II'),
(10, 'Semestre III'),
(10, 'Semestre IV'),
(10, 'Semestre V'),
(10, 'Semestre VI'),
(11, 'Semestre I'),
(11, 'Semestre II'),
(11, 'Semestre III'),
(11, 'Semestre IV'),
(11, 'Semestre V'),
(11, 'Semestre VI'),
(12, 'Semestre I'),
(12, 'Semestre II'),
(12, 'Semestre III'),
(12, 'Semestre IV'),
(12, 'Semestre V'),
(12, 'Semestre VI'),
(13, 'Unico'),
(14, 'Unico'),
(15, 'Unico'),
(16, 'Unico'),
(17, 'Unico');
/********** TABLA CATEGORÍA **********/
-- Categoria: Ocho categorías para cobros extraordinarios (destino=0,1) (institucion)
INSERT INTO jsoria_categoria(nombre, tipo, estado, destino, id_detalle_institucion) VALUES
('Cobro Extraordinario', 'cobro_extraordinario', '1', '0', 18),
('Cobro Extraordinario', 'cobro_extraordinario', '1', '0', 19),
('Cobro Extraordinario', 'cobro_extraordinario', '1', '0', 20),
('Cobro Extraordinario', 'cobro_extraordinario', '1', '0', 21),
('Cobro Extraordinario', 'cobro_extraordinario', '1', '1', 18),
('Cobro Extraordinario', 'cobro_extraordinario', '1', '1', 19),
('Cobro Extraordinario', 'cobro_extraordinario', '1', '1', 20),
('Cobro Extraordinario', 'cobro_extraordinario', '1', '1', 21);
/********** TABLA USUARIO **********/
-- Usuario: Un administrador
INSERT INTO jsoria_usuario(dni, nombres, apellidos, tipo, usuario_login, password) VALUES
('12345678', 'Jeronimo', 'Soria Mormontoy', 'Administrador', 'admin','123456');
/********** TABLA PERMISOS **********/
INSERT INTO jsoria_permisos(id_institucion, id_usuario) VALUES
('1', '1'),
('2', '1'),
('3', '1'),
('4', '1'),
('1', '2'),
('2', '2'),
('3', '2'),
('4', '2');
/********** TABLA COMPROBANTE **********/
-- Comprobante: Un comprobante para los C.P. emitidos por la ticketera
/*
INSERT INTO jsoria_comprobante(tipo, serie, numero_comprobante, id_razon_social) VALUES
('comprobante', 'C001', 0, '1'),
('comprobante', 'C002', 0, '1'),
('comprobante', 'C001', 0, '2'),
('boleta', 'B001', 0, '1'),
('boleta', 'B001', 0, '2'),
('factura', 'F001', 0, '1'),
('factura', 'F001', 0, '2');
*/
/********** TABLA TIPO COMPROBANTE **********/
INSERT INTO jsoria_tipo_comprobante(id, denominacion) VALUES
('1', 'Boleta'),
('2', 'Factura'),
('3', 'Comprobante de Pago'),
('4', 'Comprobante de Egreso'),
('5', 'Recibo por Honorario');
/********** PENDIENTE **********/
-- Comprobante: creacion de correlativos.
