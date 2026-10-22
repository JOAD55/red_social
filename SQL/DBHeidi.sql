-- CREAR LA BASE DE DATOS
CREATE DATABASE IF NOT EXISTS `red_social`;
USE `red_social`;

-- CREAR TABLA PARA MENSAJES
CREATE TABLE IF NOT EXISTS `mensaje` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `texto` varchar(255) COLLATE utf8_bin NOT NULL,
  `fecha_hora` datetime NOT NULL,
  `remitente` varchar(50) COLLATE utf8_bin NOT NULL,
  `destinatario` varchar(50) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- CREAR TABLA PARA USUARIOS
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `correo` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `contrasena` text COLLATE utf8_bin,
  PRIMARY KEY (`id`),
  UNIQUE KEY `correo` (`correo`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
