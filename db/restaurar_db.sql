/********** TABLA INSTITUCION **********/
TRUNCATE jsoria_institucion;
INSERT INTO jsoria_institucion(nombre, id_razon_social, razon_social, ruc, direccion)
VALUES ('Institución Educativa J. Soria', '1', 'Corporación Educativa J-Soria S.C.R.LTDA', '20490041339', 'Jr. Quillabamba N° 110 - Quillabamba'),
       ('CEBA Konrad Adenahuer', '1', 'Corporación Educativa J-Soria S.C.R.LTDA', '20490041339', 'Jr. Quillabamba N° 110 - Quillabamba'),
       ('Instituto Superior Tecnológico Urusayhua', '1', 'Corporación Educativa J-Soria S.C.R.LTDA', '20490041339', 'Jr. Quillabamba N° 110 - Quillabamba'),
       ('Universidad Líder Peruana', '2', 'Universidad Privada Líder Peruana S.A.C.', '20564356035', 'Jr. Quillabamba N° 110 - Quillabamba');


/********** TABLA USUARIO **********/
TRUNCATE jsoria_usuario;
INSERT INTO jsoria_usuario(dni, nombres, apellidos, tipo, usuario_login, password)
VALUES ('12324432', 'Jeronimo', 'Soria Mormontoy', 'Administrador', 'admin','123456');

/********** TABLA COMPROBANTE **********/
TRUNCATE jsoria_comprobante;
INSERT INTO jsoria_comprobante(tipo, numero_comprobante, id_razon_social)
VALUES ('comprobante', '0','1');


- Institucion: Todo
- Detalle Institucion: Todo
- Grado: Todo
- Categoria: Ocho categorías para cobros extraordinarios (destino=0,1) (institucion)
- Comprobante: Un comprobante para los C.P. emitidos por la ticketera
- Usuario: Un administrador
- Comprobante: creacion de correlativos.