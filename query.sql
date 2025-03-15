-- Date: 2024-04-15 13:54
UPDATE alumno
SET FechaRetiro = '2024-01-01';
ALTER TABLE alumno
MODIFY COLUMN FechaRetiro date NULL;
ALTER TABLE alumno
ADD AccesoSistema TINYINT UNSIGNED DEFAULT 1 NULL;
-- Date: 2024-04-21 22:28
ALTER TABLE materias
MODIFY COLUMN Nombre varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL;
ALTER TABLE materias
MODIFY COLUMN Abreviado varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL;
ALTER TABLE materias
MODIFY COLUMN NombreAlterno1 varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL;
ALTER TABLE materias
MODIFY COLUMN NombreAlterno2 varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL;
-- Date: 2024-04-25 00:00
ALTER TABLE anuncioslogin
ADD COLUMN Imagen LONGTEXT
after Resaltar;
-- Date: 2024-06-03 19:26
ALTER TABLE notificaciones CHANGE CodMensajes CodNotificaciones int unsigned auto_increment NOT NULL;
ALTER TABLE casilleros
MODIFY COLUMN NombreCasilla1 varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL;
ALTER TABLE casilleros
MODIFY COLUMN NombreCasilla2 varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL;
ALTER TABLE casilleros
MODIFY COLUMN NombreCasilla3 varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL;
ALTER TABLE casilleros
MODIFY COLUMN NombreCasilla4 varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL;
ALTER TABLE casilleros
MODIFY COLUMN NombreCasilla5 varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL;
ALTER TABLE casilleros
MODIFY COLUMN NombreCasilla6 varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL;
ALTER TABLE casilleros
MODIFY COLUMN NombreCasilla7 varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL;
ALTER TABLE casilleros
MODIFY COLUMN NombreCasilla8 varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL;
ALTER TABLE casilleros
MODIFY COLUMN NombreCasilla9 varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL;
ALTER TABLE casilleros
MODIFY COLUMN NombreCasilla10 varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL;
ALTER TABLE casilleros
MODIFY COLUMN NombreCasilla11 varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL;
ALTER TABLE casilleros
MODIFY COLUMN NombreCasilla12 varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL;
ALTER TABLE casilleros
MODIFY COLUMN NombreCasilla13 varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL;
ALTER TABLE casilleros
MODIFY COLUMN NombreCasilla14 varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL;
ALTER TABLE casilleros
MODIFY COLUMN NombreCasilla15 varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL;
ALTER TABLE casilleros
MODIFY COLUMN NombreCasilla16 varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL;
ALTER TABLE casilleros
MODIFY COLUMN NombreCasilla17 varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL;
ALTER TABLE casilleros
MODIFY COLUMN NombreCasilla18 varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL;
ALTER TABLE casilleros
MODIFY COLUMN NombreCasilla19 varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL;
ALTER TABLE casilleros
MODIFY COLUMN NombreCasilla25 varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL;
ALTER TABLE casilleros
MODIFY COLUMN NombreCasilla24 varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL;
ALTER TABLE casilleros
MODIFY COLUMN NombreCasilla23 varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL;
ALTER TABLE casilleros
MODIFY COLUMN NombreCasilla22 varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL;
ALTER TABLE casilleros
MODIFY COLUMN NombreCasilla21 varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL;
ALTER TABLE casilleros
MODIFY COLUMN NombreCasilla20 varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL;
--- 2024-06-07 17:18
insert into submenu (
		`CodMenu`,
		`Nombre`,
		`Url`,
		`Imagen`,
		`Admin`,
		`Director`,
		`Profesor`,
		`Secretaria`,
		`Regente`,
		`Padre`,
		`Alumno`,
		`Orden`,
		`Internet`,
		`Activo`
	)
values(
		19,
		'RegistrarEventoSignificativo',
		'registroeventosignificativo/',
		'eventosignificativo.png',
		1,
		1,
		0,
		0,
		0,
		0,
		0,
		10,
		0,
		1
	);
-- //Correcion
ALTER TABLE agenda ENGINE = INNODB,
	COLLATE utf8mb4_spanish_ci;
ALTER TABLE agendaactividades ENGINE = INNODB,
	COLLATE utf8mb4_spanish_ci;
ALTER TABLE alumno ENGINE = INNODB,
	COLLATE utf8mb4_spanish_ci;
ALTER TABLE anuncioslogin ENGINE = INNODB,
	COLLATE utf8mb4_spanish_ci;
ALTER TABLE asesor ENGINE = INNODB,
	COLLATE utf8mb4_spanish_ci;
ALTER TABLE asistencia ENGINE = INNODB,
	COLLATE utf8mb4_spanish_ci;
ALTER TABLE casilleros ENGINE = INNODB,
	COLLATE utf8mb4_spanish_ci;
ALTER TABLE clases ENGINE = INNODB,
	COLLATE utf8mb4_spanish_ci;
ALTER TABLE clasesarchivos ENGINE = INNODB,
	COLLATE utf8mb4_spanish_ci;
ALTER TABLE config ENGINE = INNODB,
	COLLATE utf8mb4_spanish_ci;
ALTER TABLE config_1 ENGINE = INNODB,
	COLLATE utf8mb4_spanish_ci;
ALTER TABLE cuota ENGINE = INNODB,
	COLLATE utf8mb4_spanish_ci;
ALTER TABLE curso ENGINE = INNODB,
	COLLATE utf8mb4_spanish_ci;
ALTER TABLE cursoarea ENGINE = INNODB,
	COLLATE utf8mb4_spanish_ci;
ALTER TABLE cursomateria ENGINE = INNODB,
	COLLATE utf8mb4_spanish_ci;
ALTER TABLE cursomateriaexportar ENGINE = INNODB,
	COLLATE utf8mb4_spanish_ci;
ALTER TABLE docente ENGINE = INNODB,
	COLLATE utf8mb4_spanish_ci;
ALTER TABLE docentemateria ENGINE = INNODB,
	COLLATE utf8mb4_spanish_ci;
ALTER TABLE docentemateriacurso ENGINE = INNODB,
	COLLATE utf8mb4_spanish_ci;
ALTER TABLE documento ENGINE = INNODB,
	COLLATE utf8mb4_spanish_ci;
ALTER TABLE documentosimpresos ENGINE = INNODB,
	COLLATE utf8mb4_spanish_ci;
ALTER TABLE evaluaciondocopciones ENGINE = INNODB,
	COLLATE utf8mb4_spanish_ci;
ALTER TABLE evaluaciondocpreguntas ENGINE = INNODB,
	COLLATE utf8mb4_spanish_ci;
ALTER TABLE evaluaciondocrespuestas ENGINE = INNODB,
	COLLATE utf8mb4_spanish_ci;
ALTER TABLE factura ENGINE = INNODB,
	COLLATE utf8mb4_spanish_ci;
ALTER TABLE facturadetalle ENGINE = INNODB,
	COLLATE utf8mb4_spanish_ci;
ALTER TABLE lograstreo ENGINE = INNODB,
	COLLATE utf8mb4_spanish_ci;
ALTER TABLE logusuario ENGINE = INNODB,
	COLLATE utf8mb4_spanish_ci;
ALTER TABLE logusuarios ENGINE = INNODB,
	COLLATE utf8mb4_spanish_ci;
ALTER TABLE materias ENGINE = INNODB,
	COLLATE utf8mb4_spanish_ci;
ALTER TABLE materiasboletin ENGINE = INNODB,
	COLLATE utf8mb4_spanish_ci;
ALTER TABLE menu ENGINE = INNODB,
	COLLATE utf8mb4_spanish_ci;
ALTER TABLE notascualitativa ENGINE = INNODB,
	COLLATE utf8mb4_spanish_ci;
ALTER TABLE notascualitativabimestre ENGINE = INNODB,
	COLLATE utf8mb4_spanish_ci;
ALTER TABLE notificaciones ENGINE = INNODB,
	COLLATE utf8mb4_spanish_ci;
ALTER TABLE observaciones ENGINE = INNODB,
	COLLATE utf8mb4_spanish_ci;
ALTER TABLE observacionesfrecuentes ENGINE = INNODB,
	COLLATE utf8mb4_spanish_ci;
ALTER TABLE registronotas ENGINE = INNODB,
	COLLATE utf8mb4_spanish_ci;
ALTER TABLE registronotasexcel ENGINE = INNODB,
	COLLATE utf8mb4_spanish_ci;
ALTER TABLE reserva ENGINE = INNODB,
	COLLATE utf8mb4_spanish_ci;
ALTER TABLE rude ENGINE = INNODB,
	COLLATE utf8mb4_spanish_ci;
ALTER TABLE smsenviado ENGINE = INNODB,
	COLLATE utf8mb4_spanish_ci;
ALTER TABLE submenu ENGINE = INNODB,
	COLLATE utf8mb4_spanish_ci;
ALTER TABLE tarea ENGINE = INNODB,
	COLLATE utf8mb4_spanish_ci;
ALTER TABLE tmp_alumno ENGINE = INNODB,
	COLLATE utf8mb4_spanish_ci;
ALTER TABLE tmp_documento ENGINE = INNODB,
	COLLATE utf8mb4_spanish_ci;
ALTER TABLE tmp_rude ENGINE = INNODB,
	COLLATE utf8mb4_spanish_ci;
ALTER TABLE tmpcola ENGINE = INNODB,
	COLLATE utf8mb4_spanish_ci;
ALTER TABLE usuario ENGINE = INNODB,
	COLLATE utf8mb4_spanish_ci;
-- Correcion tablas
ALTER TABLE curso
MODIFY COLUMN CodCursoArea INT UNSIGNED NULL;
ALTER TABLE `curso`
ADD FOREIGN KEY (`CodCursoArea`) REFERENCES `cursoarea`(`CodCursoArea`) ON DELETE
SET NULL ON UPDATE
SET NULL;
ALTER TABLE alumno
MODIFY COLUMN CodCurso INT UNSIGNED NOT NULL;
ALTER TABLE alumno
MODIFY COLUMN CodCurso int unsigned NULL;
ALTER TABLE `alumno`
ADD FOREIGN KEY (`CodCurso`) REFERENCES `curso`(`CodCurso`) ON DELETE
SET NULL ON UPDATE
SET NULL;
ALTER TABLE rude
MODIFY COLUMN CodAlumno INT UNSIGNED NULL;
ALTER TABLE `rude`
ADD FOREIGN KEY (`CodAlumno`) REFERENCES `alumno`(`CodAlumno`) ON DELETE
SET NULL ON UPDATE
SET NULL;
ALTER TABLE cuota
MODIFY COLUMN CodAlumno INT UNSIGNED NULL;
ALTER TABLE `cuota`
ADD FOREIGN KEY (`CodAlumno`) REFERENCES `alumno`(`CodAlumno`) ON DELETE
SET NULL ON UPDATE
SET NULL;
ALTER TABLE documentosimpresos
MODIFY COLUMN CodAlumno INT UNSIGNED NULL;
ALTER TABLE `documentosimpresos`
ADD FOREIGN KEY (`CodAlumno`) REFERENCES `alumno`(`CodAlumno`) ON DELETE
SET NULL ON UPDATE
SET NULL;
ALTER TABLE materias
MODIFY COLUMN CodMateria INT UNSIGNED auto_increment NOT NULL;
ALTER TABLE documento
MODIFY COLUMN CodAlumno int unsigned NULL;
ALTER TABLE `documento`
ADD FOREIGN KEY (`CodAlumno`) REFERENCES `alumno`(`CodAlumno`) ON DELETE
SET NULL ON UPDATE
SET NULL;
ALTER TABLE cursomateria
MODIFY COLUMN CodCurso int unsigned NULL;
ALTER TABLE cursomateria
MODIFY COLUMN CodMateria int unsigned NULL;
ALTER TABLE `cursomateria`
ADD FOREIGN KEY (`CodCurso`) REFERENCES `curso`(`CodCurso`) ON DELETE
SET NULL ON UPDATE
SET NULL;
ALTER TABLE `cursomateria`
ADD FOREIGN KEY (`CodMateria`) REFERENCES `materias`(`CodMateria`) ON DELETE
SET NULL ON UPDATE
SET NULL;
ALTER TABLE cursomateriaexportar
MODIFY COLUMN CodCurso int unsigned NULL;
ALTER TABLE cursomateriaexportar
MODIFY COLUMN CodMateria INT UNSIGNED NULL COMMENT '1000 para materia combinada';
Truncate table cursomateriaexportar;
ALTER TABLE `cursomateriaexportar`
ADD FOREIGN KEY (`CodCurso`) REFERENCES `curso`(`CodCurso`) ON DELETE
SET NULL ON UPDATE
SET NULL;
ALTER TABLE `cursomateriaexportar`
ADD FOREIGN KEY (`CodMateria`) REFERENCES `materias`(`CodMateria`) ON DELETE
SET NULL ON UPDATE
SET NULL;
ALTER TABLE reserva
MODIFY COLUMN CodAlumno int unsigned NULL;
ALTER TABLE `reserva`
ADD FOREIGN KEY (`CodAlumno`) REFERENCES `alumno`(`CodAlumno`) ON DELETE
SET NULL ON UPDATE
SET NULL;
ALTER TABLE materiasboletin
MODIFY COLUMN CodCurso int unsigned NULL;
ALTER TABLE materiasboletin
MODIFY COLUMN CodMateria int unsigned NULL;
ALTER TABLE `materiasboletin`
ADD FOREIGN KEY (`CodCurso`) REFERENCES `curso`(`CodCurso`) ON DELETE
SET NULL ON UPDATE
SET NULL;
ALTER TABLE `materiasboletin`
ADD FOREIGN KEY (`CodMateria`) REFERENCES `materias`(`CodMateria`) ON DELETE
SET NULL ON UPDATE
SET NULL;
ALTER TABLE asesor
MODIFY COLUMN CodDocente int unsigned NULL;
ALTER TABLE asesor
MODIFY COLUMN CodCurso INT UNSIGNED NULL;
ALTER TABLE `asesor`
ADD FOREIGN KEY (`CodDocente`) REFERENCES `docente`(`CodDocente`) ON DELETE
SET NULL ON UPDATE
SET NULL;
ALTER TABLE `asesor`
ADD FOREIGN KEY (`CodCurso`) REFERENCES `curso`(`CodCurso`) ON DELETE
SET NULL ON UPDATE
SET NULL;
ALTER TABLE menu
MODIFY COLUMN CodMenu int unsigned auto_increment NOT NULL;
ALTER TABLE submenu
MODIFY COLUMN CodMenu INT UNSIGNED NULL;
ALTER TABLE `submenu`
ADD FOREIGN KEY (`CodMenu`) REFERENCES `menu`(`CodMenu`) ON DELETE
SET NULL ON UPDATE
SET NULL;
ALTER TABLE clases
MODIFY COLUMN CodCurso int unsigned NULL;
ALTER TABLE clases
MODIFY COLUMN CodMateria int unsigned NULL;
ALTER TABLE clases
MODIFY COLUMN CodDocente int unsigned NULL;
ALTER TABLE clases
MODIFY COLUMN CodAlumno int unsigned NULL;
ALTER TABLE `clases`
ADD FOREIGN KEY (`CodCurso`) REFERENCES `curso`(`CodCurso`) ON DELETE
SET NULL ON UPDATE
SET NULL;
ALTER TABLE `clases`
ADD FOREIGN KEY (`CodMateria`) REFERENCES `materias`(`CodMateria`) ON DELETE
SET NULL ON UPDATE
SET NULL;
ALTER TABLE `clases`
ADD FOREIGN KEY (`CodDocente`) REFERENCES `docente`(`CodDocente`) ON DELETE
SET NULL ON UPDATE
SET NULL;
ALTER TABLE `clases`
ADD FOREIGN KEY (`CodAlumno`) REFERENCES `alumno`(`CodAlumno`) ON DELETE
SET NULL ON UPDATE
SET NULL;
ALTER TABLE clasesarchivos
MODIFY COLUMN CodClases int unsigned NULL;
ALTER TABLE `clasesarchivos`
ADD FOREIGN KEY (`CodClases`) REFERENCES `clases`(`CodClases`) ON DELETE
SET NULL ON UPDATE
SET NULL;
ALTER TABLE evaluaciondocopciones
MODIFY COLUMN CodEvaluacionDocPreguntas int unsigned NULL;
ALTER TABLE `evaluaciondocopciones`
ADD FOREIGN KEY (`CodEvaluacionDocPreguntas`) REFERENCES `evaluaciondocpreguntas`(`CodEvaluacionDocPreguntas`) ON DELETE
SET NULL ON UPDATE
SET NULL;
ALTER TABLE evaluaciondocrespuestas
MODIFY COLUMN CodDocente int unsigned NULL;
ALTER TABLE evaluaciondocrespuestas
MODIFY COLUMN CodCurso int unsigned NULL;
ALTER TABLE `evaluaciondocrespuestas`
ADD FOREIGN KEY (`CodDocente`) REFERENCES `docente`(`CodDocente`) ON DELETE
SET NULL ON UPDATE
SET NULL;
ALTER TABLE `evaluaciondocrespuestas`
ADD FOREIGN KEY (`CodCurso`) REFERENCES `curso`(`CodCurso`) ON DELETE
SET NULL ON UPDATE
SET NULL;
ALTER TABLE docentemateriacurso
MODIFY COLUMN CodDocente int unsigned NULL;
ALTER TABLE docentemateriacurso
MODIFY COLUMN CodMateria int unsigned NULL;
ALTER TABLE docentemateriacurso
MODIFY COLUMN CodCurso int unsigned NULL;
ALTER TABLE `docentemateriacurso`
ADD FOREIGN KEY (`CodDocente`) REFERENCES `docente`(`CodDocente`) ON DELETE
SET NULL ON UPDATE
SET NULL;
ALTER TABLE `docentemateriacurso`
ADD FOREIGN KEY (`CodMateria`) REFERENCES `materias`(`CodMateria`) ON DELETE
SET NULL ON UPDATE
SET NULL;
ALTER TABLE `docentemateriacurso`
ADD FOREIGN KEY (`CodCurso`) REFERENCES `curso`(`CodCurso`) ON DELETE
SET NULL ON UPDATE
SET NULL;
ALTER TABLE logusuario
MODIFY COLUMN CodUsuario int unsigned NULL;
-- ALTER TABLE `logusuario` ADD FOREIGN KEY (`CodUsuario`) REFERENCES `usuario`(`CodUsuario`) ON DELETE SET NULL ON UPDATE SET NULL;
-- ALTER TABLE usuario MODIFY COLUMN CodUsuario int unsigned auto_increment NOT NULL;
ALTER TABLE tarea
MODIFY COLUMN CodTarea int unsigned auto_increment NOT NULL;
ALTER TABLE tarea
MODIFY COLUMN CodDocente int unsigned NULL;
ALTER TABLE tarea
MODIFY COLUMN CodCurso int unsigned NULL;
ALTER TABLE tarea
MODIFY COLUMN CodMateria int unsigned NULL;
ALTER TABLE `tarea`
ADD FOREIGN KEY (`CodDocente`) REFERENCES `docente`(`CodDocente`) ON DELETE
SET NULL ON UPDATE
SET NULL;
ALTER TABLE `tarea`
ADD FOREIGN KEY (`CodCurso`) REFERENCES `curso`(`CodCurso`) ON DELETE
SET NULL ON UPDATE
SET NULL;
ALTER TABLE `tarea`
ADD FOREIGN KEY (`CodMateria`) REFERENCES `materias`(`CodMateria`) ON DELETE
SET NULL ON UPDATE
SET NULL;
ALTER TABLE asistencia
MODIFY COLUMN CodAlumno int unsigned NULL;
ALTER TABLE `asistencia`
ADD FOREIGN KEY (`CodAlumno`) REFERENCES `alumno`(`CodAlumno`) ON DELETE
SET NULL ON UPDATE
SET NULL;
ALTER TABLE anuncioslogin
MODIFY COLUMN CodUsuario int unsigned NULL;
update anuncioslogin
set CodUsuario = null
where anuncioslogin.CodAnunciosLogin = 1;

ALTER TABLE `usuario` CHANGE `CodUsuario` `CodUsuario` INT UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `anuncioslogin`
ADD FOREIGN KEY (`CodUsuario`) REFERENCES `usuario`(`CodUsuario`) ON DELETE
SET NULL ON UPDATE
SET NULL;

ALTER TABLE notificaciones
MODIFY COLUMN CodUsuario int unsigned NULL;
update notificaciones
set CodUsuario = null;
ALTER TABLE `notificaciones`
ADD FOREIGN KEY (`CodUsuario`) REFERENCES `usuario`(`CodUsuario`) ON DELETE
SET NULL ON UPDATE
SET NULL;
ALTER TABLE observaciones
MODIFY COLUMN CodObservacion int unsigned auto_increment NOT NULL;
ALTER TABLE agenda
MODIFY COLUMN CodAgenda int unsigned auto_increment NOT NULL;
ALTER TABLE agenda
MODIFY COLUMN CodCurso int unsigned NULL;
ALTER TABLE agenda
MODIFY COLUMN CodAlumno int unsigned NULL;
ALTER TABLE agenda
MODIFY COLUMN CodMateria int unsigned NULL;
ALTER TABLE agenda
MODIFY COLUMN CodObservacion int unsigned NULL;
ALTER TABLE `agenda`
ADD FOREIGN KEY (`CodCurso`) REFERENCES `curso`(`CodCurso`) ON DELETE
SET NULL ON UPDATE
SET NULL;
ALTER TABLE `agenda`
ADD FOREIGN KEY (`CodAlumno`) REFERENCES `alumno`(`CodAlumno`) ON DELETE
SET NULL ON UPDATE
SET NULL;
ALTER TABLE `agenda`
ADD FOREIGN KEY (`CodMateria`) REFERENCES `materias`(`CodMateria`) ON DELETE
SET NULL ON UPDATE
SET NULL;
ALTER TABLE `agenda`
ADD FOREIGN KEY (`CodObservacion`) REFERENCES `observaciones`(`CodObservacion`) ON DELETE
SET NULL ON UPDATE
SET NULL;
ALTER TABLE observacionesfrecuentes
MODIFY COLUMN CodUsuario int unsigned NULL;
update observacionesfrecuentes
set CodUsuario = null;
ALTER TABLE `observacionesfrecuentes`
ADD FOREIGN KEY (`CodUsuario`) REFERENCES `usuario`(`CodUsuario`) ON DELETE
SET NULL ON UPDATE
SET NULL;
ALTER TABLE tmpcola
MODIFY COLUMN CodAlumno int unsigned NULL;
ALTER TABLE `tmpcola`
ADD FOREIGN KEY (`CodAlumno`) REFERENCES `alumno`(`CodAlumno`) ON DELETE
SET NULL ON UPDATE
SET NULL;
ALTER TABLE smsenviado
MODIFY COLUMN CodUsuario int unsigned NULL;
ALTER TABLE `smsenviado`
ADD FOREIGN KEY (`CodUsuario`) REFERENCES `usuario`(`CodUsuario`) ON DELETE
SET NULL ON UPDATE
SET NULL;
ALTER TABLE docentemateria
MODIFY COLUMN CodDocenteMateria int unsigned auto_increment NOT NULL;
ALTER TABLE docentemateria
MODIFY COLUMN CodDocente int unsigned NULL;
ALTER TABLE docentemateria
MODIFY COLUMN CodMateria int unsigned NULL;
ALTER TABLE docentemateria
MODIFY COLUMN CodCurso int unsigned NULL;
ALTER TABLE `docentemateria`
ADD FOREIGN KEY (`CodDocente`) REFERENCES `docente`(`CodDocente`) ON DELETE
SET NULL ON UPDATE
SET NULL;
ALTER TABLE `docentemateria`
ADD FOREIGN KEY (`CodMateria`) REFERENCES `materias`(`CodMateria`) ON DELETE
SET NULL ON UPDATE
SET NULL;
ALTER TABLE `docentemateria`
ADD FOREIGN KEY (`CodCurso`) REFERENCES `curso`(`CodCurso`) ON DELETE
SET NULL ON UPDATE
SET NULL;
ALTER TABLE factura
MODIFY COLUMN CodAlumno int unsigned NULL;
ALTER TABLE `factura`
ADD FOREIGN KEY (`CodAlumno`) REFERENCES `alumno`(`CodAlumno`) ON DELETE
SET NULL ON UPDATE
SET NULL;
ALTER TABLE facturadetalle
MODIFY COLUMN CodFactura int unsigned NULL;
ALTER TABLE facturadetalle
MODIFY COLUMN CodAlumno int unsigned NULL;
ALTER TABLE facturadetalle
MODIFY COLUMN CodCuota varchar(11) CHARACTER SET utf8mb3 COLLATE utf8_spanish_ci NULL;
ALTER TABLE `facturadetalle`
ADD FOREIGN KEY (`CodFactura`) REFERENCES `factura`(`CodFactura`) ON DELETE
SET NULL ON UPDATE
SET NULL;
ALTER TABLE `facturadetalle`
ADD FOREIGN KEY (`CodAlumno`) REFERENCES `alumno`(`CodAlumno`) ON DELETE
SET NULL ON UPDATE
SET NULL;
ALTER TABLE agendaactividades
MODIFY COLUMN CodUsuario int unsigned NULL;
update agendaactividades
set CodUsuario = null;
ALTER TABLE `agendaactividades`
ADD FOREIGN KEY (`CodUsuario`) REFERENCES `usuario`(`CodUsuario`) ON DELETE
SET NULL ON UPDATE
SET NULL;
ALTER TABLE casilleros
MODIFY COLUMN CodDocenteMateriaCurso int unsigned NULL;
ALTER TABLE docentemateriacurso
MODIFY COLUMN CodDocenteMateriaCurso int unsigned auto_increment NOT NULL;
ALTER TABLE `casilleros`
ADD FOREIGN KEY (`CodDocenteMateriaCurso`) REFERENCES `docentemateriacurso`(`CodDocenteMateriaCurso`) ON DELETE
SET NULL ON UPDATE
SET NULL;
ALTER TABLE casilleros
MODIFY COLUMN CodCasilleros int unsigned auto_increment NOT NULL;
ALTER TABLE registronotas
MODIFY COLUMN CodCasilleros int unsigned NULL;
ALTER TABLE registronotas
MODIFY COLUMN CodAlumno int unsigned NULL;
ALTER TABLE `registronotas`
ADD FOREIGN KEY (`CodCasilleros`) REFERENCES `casilleros`(`CodCasilleros`) ON DELETE
SET NULL ON UPDATE
SET NULL;
ALTER TABLE `registronotas`
ADD FOREIGN KEY (`CodAlumno`) REFERENCES `alumno`(`CodAlumno`) ON DELETE
SET NULL ON UPDATE
SET NULL;
ALTER TABLE registronotasexcel
MODIFY COLUMN CodDocenteMateriaCurso int unsigned NULL;
ALTER TABLE registronotasexcel
MODIFY COLUMN CodCasilleros int unsigned NULL;
ALTER TABLE registronotasexcel
MODIFY COLUMN CodDocente int unsigned NULL;
ALTER TABLE registronotasexcel
MODIFY COLUMN CodMateria int unsigned NULL;
ALTER TABLE registronotasexcel
MODIFY COLUMN CodCurso int unsigned NULL;
ALTER TABLE `registronotasexcel`
ADD FOREIGN KEY (`CodDocenteMateriaCurso`) REFERENCES `docentemateriacurso`(`CodDocenteMateriaCurso`) ON DELETE
SET NULL ON UPDATE
SET NULL;
-- ALTER TABLE `registronotasexcel` ADD FOREIGN KEY (`CodCasilleros`) REFERENCES `casilleros`(`CodCasilleros`) ON DELETE SET NULL ON UPDATE SET NULL;
ALTER TABLE `registronotasexcel`
ADD FOREIGN KEY (`CodDocente`) REFERENCES `docente`(`CodDocente`) ON DELETE
SET NULL ON UPDATE
SET NULL;
ALTER TABLE `registronotasexcel`
ADD FOREIGN KEY (`CodMateria`) REFERENCES `materias`(`CodMateria`) ON DELETE
SET NULL ON UPDATE
SET NULL;
ALTER TABLE `registronotasexcel`
ADD FOREIGN KEY (`CodCurso`) REFERENCES `curso`(`CodCurso`) ON DELETE
SET NULL ON UPDATE
SET NULL;
DROP TABLE config_1;
ALTER TABLE notascualitativa
MODIFY COLUMN CodDocenteMateriaCurso int unsigned NULL;
ALTER TABLE `notascualitativa`
ADD FOREIGN KEY (`CodDocenteMateriaCurso`) REFERENCES `docentemateriacurso`(`CodDocenteMateriaCurso`) ON DELETE
SET NULL ON UPDATE
SET NULL;
ALTER TABLE notascualitativabimestre
MODIFY COLUMN CodCurso int unsigned NULL;
ALTER TABLE notascualitativabimestre
ADD FOREIGN KEY (`CodCurso`) REFERENCES `curso`(`CodCurso`) ON DELETE
SET NULL ON UPDATE
SET NULL;
ALTER TABLE tmp_documento
MODIFY COLUMN CodAlumno int unsigned NULL;
ALTER TABLE `tmp_documento`
ADD FOREIGN KEY (`CodAlumno`) REFERENCES `tmp_alumno`(`CodAlumno`) ON DELETE
SET NULL ON UPDATE
SET NULL;
ALTER TABLE tmp_rude
MODIFY COLUMN CodAlumno int unsigned NULL;
ALTER TABLE `tmp_rude`
ADD FOREIGN KEY (`CodAlumno`) REFERENCES `tmp_alumno`(`CodAlumno`) ON DELETE
SET NULL ON UPDATE
SET NULL;
DROP TABLE logusuarios;
-- 2025-01-10
CREATE TABLE gestionesanteriores (
	CodGestionAnterior INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
	Url VARCHAR(255),
	Label VARCHAR(255),
	EnlaceExterno TINYINT (1) DEFAULT 0,
	Activo TINYINT DEFAULT 1
) ENGINE=INNODB;
INSERT INTO `sanjose2025`.`config` (`Nombre`, `Valor`)
VALUES ('AlertaGestionAnterior', '1');
-- 2025-01-16
UPDATE `submenu`
SET `CodMenu` = '1', Nombre = 'RegistroEnEspera', Orden = 15, Url = 'espera/'
WHERE (`CodSubmenu` = '4');

-- 2025-02-23
ALTER TABLE `anuncioslogin` ADD `Visible` TINYINT(1) NOT NULL AFTER `Resaltar`;

ALTER TABLE `cuota` ADD `CodUsuario` INT UNSIGNED NOT NULL AFTER `Observaciones`, ADD `Nivel` TINYINT(1) NOT NULL AFTER `CodUsuario`, ADD `FechaRegistro` DATE NOT NULL AFTER `Nivel`, ADD `HoraRegistro` TIME NOT NULL AFTER `FechaRegistro`, ADD `Activo` TINYINT(1) NOT NULL AFTER `HoraRegistro`;