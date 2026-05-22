-- Base de datos BYH corregida
-- Importa este archivo desde phpMyAdmin antes de usar la web.

CREATE DATABASE IF NOT EXISTS buildyourhome CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE buildyourhome;

CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    apellidos VARCHAR(150) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    telefono VARCHAR(20) NOT NULL,
    password VARCHAR(255) NOT NULL,
    tipo ENUM('cliente','profesional','trabajador','admin') NOT NULL DEFAULT 'cliente',
    avatar VARCHAR(255) NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS profesionales (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    id_categoria INT NULL,
    descripcion TEXT NULL,
    experiencia VARCHAR(100) NULL,
    ubicacion VARCHAR(150) NULL,
    puntuacion DECIMAL(2,1) DEFAULT 5.0,
    verificado TINYINT(1) DEFAULT 0,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (id_categoria) REFERENCES categorias(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS mensajes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_emisor INT NOT NULL,
    id_receptor INT NOT NULL,
    mensaje TEXT NOT NULL,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_emisor) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (id_receptor) REFERENCES usuarios(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS valoraciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_cliente INT NOT NULL,
    id_profesional INT NOT NULL,
    estrellas INT NOT NULL DEFAULT 5,
    comentario TEXT NOT NULL,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_cliente) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (id_profesional) REFERENCES usuarios(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT IGNORE INTO categorias (id, nombre, descripcion) VALUES
(1, 'Albañilería', 'Trabajos de construcción y reparación'),
(2, 'Electricista', 'Instalaciones y reparaciones eléctricas'),
(3, 'Fontanería', 'Reparación de tuberías y grifos'),
(4, 'Cristalería', 'Cristales, ventanas y cerramientos'),
(5, 'Carpintería', 'Muebles, puertas y trabajos de madera'),
(6, 'Pintura', 'Pintura y decoración'),
(7, 'Reformas Integrales', 'Reformas completas del hogar'),
(8, 'Energía', 'Energías renovables y placas solares');
