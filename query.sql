-- Date: 2024-04-15 13:54
UPDATE alumno SET FechaRetiro = '2024-01-01';
ALTER TABLE alumno MODIFY COLUMN FechaRetiro date NULL;

ALTER TABLE alumno ADD AccesoSistema TINYINT UNSIGNED DEFAULT 1 NULL;