-- Date: 2024-04-15 13:54
UPDATE alumno SET FechaRetiro = '2024-01-01';
ALTER TABLE alumno MODIFY COLUMN FechaRetiro date NULL;

ALTER TABLE alumno ADD AccesoSistema TINYINT UNSIGNED DEFAULT 1 NULL;
-- Date: 2024-04-21 22:28
ALTER TABLE materias MODIFY COLUMN Nombre varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL;
ALTER TABLE materias MODIFY COLUMN Abreviado varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL;
ALTER TABLE materias MODIFY COLUMN NombreAlterno1 varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL;
ALTER TABLE materias MODIFY COLUMN NombreAlterno2 varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL;
