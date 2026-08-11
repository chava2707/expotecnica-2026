CREATE TABLE `Persona` (
  `ID_Cedula` int PRIMARY KEY,
  `Nombre` varchar(255),
  `Apellido_1` varchar(255),
  `Apellido_2` varchar(255),
  `Fecha_Nacimiento` date,
  `Estado` bool
);

CREATE TABLE `Usuario` (
  `ID_Usuario` int PRIMARY KEY AUTO_INCREMENT,
  `IDPersona` int,
  `IDrol` int,
  `Nombre_usuario` varchar(255),
  `Contraseña` varchar(255),
  `Fecha_creacion` timestamp,
  `ultima_fecha_actualizacion` timestamp,
  `Activo` boolean
);

CREATE TABLE `Telefono` (
  `ID_Telefono` int PRIMARY KEY AUTO_INCREMENT,
  `IDPersona` int,
  `Numero_Telefono` varchar(255),
  `Activo` boolean,
  `Es_Principal` boolean,
  `Estado` varchar(255)
);

CREATE TABLE `Correo` (
  `ID_Correo` int PRIMARY KEY AUTO_INCREMENT,
  `IDPersona` int,
  `Correo` varchar(255),
  `Activo` boolean,
  `Es_Principal` boolean,
  `Estado` varchar(255)
);

CREATE TABLE `Roles` (
  `ID_Roles` int PRIMARY KEY AUTO_INCREMENT,
  `Nombre_rol` varchar(255),
  `Descripcion_rol` varchar(255),
  `Estado` varchar(255)
);

CREATE TABLE `Proyecto` (
  `ID_Proyecto` int PRIMARY KEY AUTO_INCREMENT,
  `Nombre` varchar(255),
  `Descripcion` varchar(255),
  `Imagen` varchar(255),
  `ID_categoria` int
);

CREATE TABLE `Categoria` (
  `ID_Categoria` int PRIMARY KEY AUTO_INCREMENT,
  `Nombre` varchar(255),
  `Descripcion` varchar(255)
);

CREATE TABLE `Persona_Asignada` (
  `ID_PersonaAsignada` int PRIMARY KEY AUTO_INCREMENT,
  `ID_Usuario` int,
  `ID_Proyecto` int
);

CREATE TABLE `Calificaciones` (
  `ID_Calificaciones` int PRIMARY KEY AUTO_INCREMENT,
  `ID_Proyecto` int,
  `Nota_Final` float,
  `Estado` varchar(255)
);

CREATE TABLE `Correo_Enviados` (
  `ID_Correo` int PRIMARY KEY AUTO_INCREMENT,
  `ID_Proyecto` int,
  `Estado` varchar(255)
);

CREATE TABLE `Preguntas` (
  `ID_Pregunta` int PRIMARY KEY AUTO_INCREMENT,
  `Pregunta` varchar(255),
  `ID_Categoria` int,
  `Maxima_Calificacion` int,
  `Estado` varchar(255)
);

CREATE TABLE `Respuestas` (
  `ID_Respuesta` int PRIMARY KEY AUTO_INCREMENT,
  `ID_Pregunta` int,
  `Calificacion` float,
  `Observaciones` varchar(255),
  `ID_Proyecto` int,
  `ID_Usuario` int,
  `Estado` varchar(255)
);

ALTER TABLE `Usuario` ADD FOREIGN KEY (`IDPersona`) REFERENCES `Persona` (`ID_Cedula`);

ALTER TABLE `Usuario` ADD FOREIGN KEY (`IDrol`) REFERENCES `Roles` (`ID_Roles`);

ALTER TABLE `Telefono` ADD FOREIGN KEY (`IDPersona`) REFERENCES `Persona` (`ID_Cedula`);

ALTER TABLE `Correo` ADD FOREIGN KEY (`IDPersona`) REFERENCES `Persona` (`ID_Cedula`);

ALTER TABLE `Persona_Asignada` ADD FOREIGN KEY (`ID_Usuario`) REFERENCES `Usuario` (`ID_Usuario`);

ALTER TABLE `Preguntas` ADD FOREIGN KEY (`ID_Categoria`) REFERENCES `Categoria` (`ID_Categoria`);

ALTER TABLE `Respuestas` ADD FOREIGN KEY (`ID_Pregunta`) REFERENCES `Preguntas` (`ID_Pregunta`);

ALTER TABLE `Respuestas` ADD FOREIGN KEY (`ID_Proyecto`) REFERENCES `Proyecto` (`ID_Proyecto`);

ALTER TABLE `Respuestas` ADD FOREIGN KEY (`ID_Usuario`) REFERENCES `Usuario` (`ID_Usuario`);

ALTER TABLE `Proyecto` ADD FOREIGN KEY (`ID_categoria`) REFERENCES `Categoria` (`ID_Categoria`);

ALTER TABLE `Persona_Asignada` ADD FOREIGN KEY (`ID_Proyecto`) REFERENCES `Proyecto` (`ID_Proyecto`);

ALTER TABLE `Calificaciones` ADD FOREIGN KEY (`ID_Proyecto`) REFERENCES `Proyecto` (`ID_Proyecto`);
