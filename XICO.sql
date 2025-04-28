DROP DATABASE Xico;

CREATE DATABASE Xico;

USE Xico;

CREATE TABLE `usuarios` (
  `id` int PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `apellido` varchar(255) NOT NULL,
  `nombre_usuario` varchar(255) UNIQUE NOT NULL,
  `contraseña` text NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL
);

CREATE TABLE `lotes` (
  `id` varchar(255) PRIMARY KEY NOT NULL,
  `tamaño_lote` int NOT NULL,
  `stock` int NOT NULL,
  `caducidad` date NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  `producto_id` INT NULL
);

CREATE TABLE `salidas` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `lote_id` varchar(255) NOT NULL,
  `cantidad` int NOT NULL,
  `usuario_id` int NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL
);

CREATE TABLE `especificacion_incidencias` (
  `id` int PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `salida_id` int NOT NULL,
  `cantidad_defectuosos` int NOT NULL,
  `causa` ENUM ('Manipulación', 'Traslado', 'Acomodo', 'Caja de transporte', 'Sellado') NOT NULL,
  `especificacion` varchar(255),
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  `destino` ENUM('Reproceso', 'Reempacado', 'Desperdicio') NOT NULL
);

CREATE TABLE `productos` (
  `id` INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(255) NOT NULL,
  `presentacion` INT NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `categoria` varchar(255) NOT NULL
);

CREATE TABLE `sessions` (
  `id` VARCHAR(255) PRIMARY KEY NOT NULL,
  `user_id` INT NULL,
  `ip_address` VARCHAR(45) NULL,
  `user_agent` TEXT NULL,
  `payload` LONGTEXT NOT NULL,
  `last_activity` INT NOT NULL,
  INDEX (`user_id`)
);

ALTER TABLE `sessions`
ADD CONSTRAINT `fk_sessions_user`
FOREIGN KEY (`user_id`) REFERENCES `usuarios` (`id`)
ON DELETE SET NULL;

ALTER TABLE `salidas` ADD FOREIGN KEY (`lote_id`) REFERENCES `lotes` (`id`);

ALTER TABLE `salidas` ADD FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);

ALTER TABLE `especificacion_incidencias` ADD FOREIGN KEY (`salida_id`) REFERENCES `salidas` (`id`);

ALTER TABLE lotes DROP COLUMN tipo_producto;

ALTER TABLE lotes ADD CONSTRAINT fk_lotes_producto
  FOREIGN KEY (producto_id) REFERENCES productos(id)
  ON DELETE SET NULL;

INSERT INTO usuarios (nombre, apellido, nombre_usuario, contraseña, created_at, updated_at)
VALUES 
('Noelia', 'Gonzalez', 'Noelia', 'clave4862', NOW(), NOW()),
('Fidel', 'Leyva', 'Fidel', 'clave7913', NOW(), NOW()),
('Javier', 'Trejo', 'Trejo', 'clave7948', NOW(), NOW()),
('Blanca', 'Mosqueda', 'Blanca', 'clave8273', NOW(), NOW());

INSERT INTO lotes (id, producto_id, tamaño_lote, stock, caducidad, created_at, updated_at)
VALUES
('L003', 2, 120, 95, '2025-06-01', NOW(), NOW()),
('L004', 5, 200, 185, '2025-06-15', NOW(), NOW()),
('L005', 7, 300, 300, '2025-07-10', NOW(), NOW()),
('L006', 7, 180, 180, '2025-07-25', NOW(), NOW());

INSERT INTO salidas (lote_id, cantidad, usuario_id, created_at, updated_at)
VALUES
('L003', 20, 1, NOW(), NOW()),
('L004', 15, 2, NOW(), NOW());

INSERT INTO especificacion_incidencias (salida_id, cantidad_defectuosos, causa, especificacion, destino, created_at, updated_at)
VALUES
(1, 5, 'Manipulación', 'Paquetes mal sellados por presión incorrecta', 'Reproceso', NOW(), NOW());

ALTER TABLE salidas DROP FOREIGN KEY salidas_ibfk_1;

ALTER TABLE salidas
ADD CONSTRAINT salidas_ibfk_1
FOREIGN KEY (lote_id) REFERENCES lotes(id)
ON DELETE CASCADE;

ALTER TABLE especificacion_incidencias DROP FOREIGN KEY especificacion_incidencias_ibfk_1;

ALTER TABLE especificacion_incidencias
ADD CONSTRAINT especificacion_incidencias_ibfk_1
FOREIGN KEY (salida_id) REFERENCES salidas(id)
ON DELETE CASCADE;
