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
  `tipo_producto` ENUM ('Salchicha', 'Jamón', 'Salchichón', 'Chorizo', 'Cueros') NOT NULL,
  `tamaño_lote` int NOT NULL,
  `stock` int NOT NULL,
  `caducidad` date NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL
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
  `updated_at` timestamp NOT NULL
);

ALTER TABLE `salidas` ADD FOREIGN KEY (`lote_id`) REFERENCES `lotes` (`id`);

ALTER TABLE `salidas` ADD FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);

ALTER TABLE `especificacion_incidencias` ADD FOREIGN KEY (`salida_id`) REFERENCES `salidas` (`id`);

INSERT INTO usuarios (nombre, apellido, nombre_usuario, contraseña, created_at, updated_at)
VALUES 
('Ana', 'López', 'analo', 'secret123', NOW(), NOW()),
('Carlos', 'Ramírez', 'carlosr', 'clave456', NOW(), NOW());

INSERT INTO lotes (id, tipo_producto, tamaño_lote, stock, caducidad, created_at, updated_at)
VALUES
('L001', 'Salchicha', 100, 75, '2025-06-30', NOW(), NOW()),
('L002', 'Jamón', 200, 185, '2025-07-15', NOW(), NOW());

INSERT INTO salidas (lote_id, cantidad, usuario_id, created_at, updated_at)
VALUES
('L001', 20, 1, NOW(), NOW()),
('L002', 15, 2, NOW(), NOW());

INSERT INTO especificacion_incidencias (salida_id, cantidad_defectuosos, causa, especificacion, created_at, updated_at)
VALUES
(1, 5, 'Manipulación', 'Paquetes mal sellados por presión incorrecta', NOW(), NOW());
