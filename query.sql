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
ADD COLUMN Imagen LONGTEXT after Resaltar;
-- Date: 2024-06-03 19:26
ALTER TABLE notificaciones CHANGE CodMensajes CodNotificaciones int unsigned auto_increment NOT NULL;

ALTER TABLE casilleros MODIFY COLUMN NombreCasilla1 varchar(255) CHARACTER SET utf8mb3 COLLATE utf8_spanish_ci NOT NULL;
ALTER TABLE casilleros MODIFY COLUMN NombreCasilla2 varchar(255) CHARACTER SET utf8mb3 COLLATE utf8_spanish_ci NOT NULL;
ALTER TABLE casilleros MODIFY COLUMN NombreCasilla3 varchar(255) CHARACTER SET utf8mb3 COLLATE utf8_spanish_ci NOT NULL;
ALTER TABLE casilleros MODIFY COLUMN NombreCasilla4 varchar(255) CHARACTER SET utf8mb3 COLLATE utf8_spanish_ci NOT NULL;
ALTER TABLE casilleros MODIFY COLUMN NombreCasilla5 varchar(255) CHARACTER SET utf8mb3 COLLATE utf8_spanish_ci NOT NULL;
ALTER TABLE casilleros MODIFY COLUMN NombreCasilla6 varchar(255) CHARACTER SET utf8mb3 COLLATE utf8_spanish_ci NOT NULL;
ALTER TABLE casilleros MODIFY COLUMN NombreCasilla7 varchar(255) CHARACTER SET utf8mb3 COLLATE utf8_spanish_ci NOT NULL;
ALTER TABLE casilleros MODIFY COLUMN NombreCasilla8 varchar(255) CHARACTER SET utf8mb3 COLLATE utf8_spanish_ci NOT NULL;
ALTER TABLE casilleros MODIFY COLUMN NombreCasilla9 varchar(255) CHARACTER SET utf8mb3 COLLATE utf8_spanish_ci NOT NULL;
ALTER TABLE casilleros MODIFY COLUMN NombreCasilla10 varchar(255) CHARACTER SET utf8mb3 COLLATE utf8_spanish_ci NOT NULL;
ALTER TABLE casilleros MODIFY COLUMN NombreCasilla11 varchar(255) CHARACTER SET utf8mb3 COLLATE utf8_spanish_ci NOT NULL;
ALTER TABLE casilleros MODIFY COLUMN NombreCasilla12 varchar(255) CHARACTER SET utf8mb3 COLLATE utf8_spanish_ci NOT NULL;
ALTER TABLE casilleros MODIFY COLUMN NombreCasilla13 varchar(255) CHARACTER SET utf8mb3 COLLATE utf8_spanish_ci NOT NULL;
ALTER TABLE casilleros MODIFY COLUMN NombreCasilla14 varchar(255) CHARACTER SET utf8mb3 COLLATE utf8_spanish_ci NOT NULL;
ALTER TABLE casilleros MODIFY COLUMN NombreCasilla15 varchar(255) CHARACTER SET utf8mb3 COLLATE utf8_spanish_ci NOT NULL;
ALTER TABLE casilleros MODIFY COLUMN NombreCasilla16 varchar(255) CHARACTER SET utf8mb3 COLLATE utf8_spanish_ci NOT NULL;
ALTER TABLE casilleros MODIFY COLUMN NombreCasilla17 varchar(255) CHARACTER SET utf8mb3 COLLATE utf8_spanish_ci NOT NULL;
ALTER TABLE casilleros MODIFY COLUMN NombreCasilla18 varchar(255) CHARACTER SET utf8mb3 COLLATE utf8_spanish_ci NOT NULL;
ALTER TABLE casilleros MODIFY COLUMN NombreCasilla19 varchar(255) CHARACTER SET utf8mb3 COLLATE utf8_spanish_ci NOT NULL;
ALTER TABLE casilleros MODIFY COLUMN NombreCasilla25 varchar(255) CHARACTER SET utf8mb3 COLLATE utf8_spanish_ci NOT NULL;
ALTER TABLE casilleros MODIFY COLUMN NombreCasilla24 varchar(255) CHARACTER SET utf8mb3 COLLATE utf8_spanish_ci NOT NULL;
ALTER TABLE casilleros MODIFY COLUMN NombreCasilla23 varchar(255) CHARACTER SET utf8mb3 COLLATE utf8_spanish_ci NOT NULL;
ALTER TABLE casilleros MODIFY COLUMN NombreCasilla22 varchar(255) CHARACTER SET utf8mb3 COLLATE utf8_spanish_ci NOT NULL;
ALTER TABLE casilleros MODIFY COLUMN NombreCasilla21 varchar(255) CHARACTER SET utf8mb3 COLLATE utf8_spanish_ci NOT NULL;
ALTER TABLE casilleros MODIFY COLUMN NombreCasilla20 varchar(255) CHARACTER SET utf8mb3 COLLATE utf8_spanish_ci NOT NULL;
