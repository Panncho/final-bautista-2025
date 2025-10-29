-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 26-09-2025 a las 17:40:46
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sistema_comercios`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_cambiar_estado_comercio` (IN `p_comercio_id` INT, IN `p_nuevo_estado` ENUM('pendiente','en_revision','aprobado','rechazado','suspendido'), IN `p_observaciones` TEXT, IN `p_usuario_id` INT)   BEGIN
    DECLARE v_estado_anterior ENUM('pendiente', 'en_revision', 'aprobado', 'rechazado', 'suspendido');
    
    SELECT estado INTO v_estado_anterior FROM comercios WHERE id = p_comercio_id;
    
    UPDATE comercios 
    SET estado = p_nuevo_estado,
        fecha_actualizacion = CURRENT_TIMESTAMP,
        fecha_aprobacion = CASE WHEN p_nuevo_estado = 'aprobado' THEN CURRENT_TIMESTAMP ELSE fecha_aprobacion END
    WHERE id = p_comercio_id;
    
    INSERT INTO comercio_historial (comercio_id, usuario_id, estado_anterior, estado_nuevo, observaciones)
    VALUES (p_comercio_id, p_usuario_id, v_estado_anterior, p_nuevo_estado, p_observaciones);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_obtener_documentacion_rubro` (IN `rubro_id` INT)   BEGIN
    SELECT 
        td.codigo,
        td.nombre,
        td.descripcion,
        rd.obligatorio,
        rd.instrucciones_especificas,
        td.vigencia_meses
    FROM rubro_documentacion rd
    JOIN tipos_documentacion td ON rd.tipo_documento_id = td.id
    WHERE rd.rubro_id = rubro_id
    ORDER BY rd.orden_solicitud;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comercios`
--

CREATE TABLE `comercios` (
  `id` int(11) NOT NULL,
  `titular_id` int(11) NOT NULL,
  `rubro_id` int(11) NOT NULL,
  `subrubro` varchar(255) DEFAULT NULL,
  `nombre` varchar(255) NOT NULL,
  `nombre_fantasia` varchar(255) DEFAULT NULL,
  `direccion` varchar(255) NOT NULL,
  `localidad` varchar(100) NOT NULL,
  `provincia` varchar(255) NOT NULL,
  `codigo_postal` varchar(10) DEFAULT NULL,
  `barrio` varchar(50) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `sitio_web` varchar(255) DEFAULT NULL,
  `email_contacto` varchar(150) DEFAULT NULL,
  `estado` enum('pendiente','en_revision','aprobado','rechazado','suspendido') DEFAULT 'pendiente',
  `fecha_alta` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_aprobacion` timestamp NULL DEFAULT NULL,
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `observaciones` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Disparadores `comercios`
--
DELIMITER $$
CREATE TRIGGER `tr_comercio_after_insert` AFTER INSERT ON `comercios` FOR EACH ROW BEGIN
    INSERT INTO comercio_historial (comercio_id, estado_anterior, estado_nuevo, observaciones)
    VALUES (NEW.id, NULL, NEW.estado, 'Alta inicial del comercio');
    
    INSERT INTO notificaciones (comercio_id, tipo, titulo, mensaje)
    VALUES (NEW.id, 'alta', 'Solicitud de alta recibida', 'Su solicitud de alta como comercio ha sido recibida y está en proceso de revisión.');
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comercio_documentos`
--

CREATE TABLE `comercio_documentos` (
  `id` int(11) NOT NULL,
  `comercio_id` int(11) NOT NULL,
  `tipo_documento_id` int(11) NOT NULL,
  `nombre_archivo` varchar(255) NOT NULL,
  `ruta_archivo` varchar(500) NOT NULL,
  `fecha_vencimiento` date DEFAULT NULL,
  `estado` enum('pendiente','aprobado','rechazado') DEFAULT 'pendiente',
  `observaciones` text DEFAULT NULL,
  `fecha_subida` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_revision` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Disparadores `comercio_documentos`
--
DELIMITER $$
CREATE TRIGGER `tr_documento_after_insert` AFTER INSERT ON `comercio_documentos` FOR EACH ROW BEGIN
    INSERT INTO notificaciones (comercio_id, tipo, titulo, mensaje)
    VALUES (NEW.comercio_id, 'documentacion', 'Documento subido', 'Se ha registrado la subida de un nuevo documento para su revisión.');
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comercio_historial`
--

CREATE TABLE `comercio_historial` (
  `id` int(11) NOT NULL,
  `comercio_id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `estado_anterior` enum('pendiente','en_revision','aprobado','rechazado','suspendido') DEFAULT NULL,
  `estado_nuevo` enum('pendiente','en_revision','aprobado','rechazado','suspendido') DEFAULT NULL,
  `observaciones` text DEFAULT NULL,
  `fecha_cambio` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notificaciones`
--

CREATE TABLE `notificaciones` (
  `id` int(11) NOT NULL,
  `comercio_id` int(11) NOT NULL,
  `tipo` enum('alta','documentacion','estado','recordatorio') DEFAULT NULL,
  `titulo` varchar(255) NOT NULL,
  `mensaje` text NOT NULL,
  `leida` tinyint(1) DEFAULT 0,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_lectura` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rubros`
--

CREATE TABLE `rubros` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `codigo` varchar(10) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `visible_publico` tinyint(1) DEFAULT 1,
  `activo` tinyint(1) DEFAULT 1,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `rubros`
--

INSERT INTO `rubros` (`id`, `nombre`, `codigo`, `descripcion`, `visible_publico`, `activo`, `fecha_creacion`, `fecha_actualizacion`) VALUES
(1, 'Alimentos y Bebidas', 'ALI', 'Comercios dedicados a la venta de alimentos, bebidas y productos alimenticios', 1, 1, '2025-09-25 18:20:06', '2025-09-25 18:20:06'),
(2, 'Electrónica y Tecnología', 'ELE', 'Venta de equipos electrónicos, computadoras y accesorios tecnológicos', 1, 0, '2025-09-25 18:20:06', '2025-09-25 19:43:43'),
(3, 'Ropa y Accesorios', 'ROP', 'Comercios de indumentaria, calzado y accesorios de moda', 0, 1, '2025-09-25 18:20:06', '2025-09-25 19:43:20'),
(4, 'Servicios Profesionales', 'SER', 'Servicios profesionales como abogados, contadores, consultores', 1, 1, '2025-09-25 18:20:06', '2025-09-25 18:20:06'),
(5, 'Salud y Belleza', 'SAL', 'Farmacias, perfumerías, centros de estética y salud', 1, 1, '2025-09-25 18:20:06', '2025-09-25 18:20:06'),
(6, 'Hogar y Jardín', 'HOG', 'Mueblerías, ferreterías, artículos para el hogar y jardín', 1, 1, '2025-09-25 18:20:06', '2025-09-25 18:20:06'),
(7, 'Automotriz', 'AUT', 'Venta de vehículos, repuestos y servicios automotrices', 1, 1, '2025-09-25 18:20:06', '2025-09-25 18:20:06'),
(8, 'Educación', 'EDU', 'Instituciones educativas, librerías, materiales didácticos', 1, 1, '2025-09-25 18:20:06', '2025-09-25 18:20:06'),
(9, 'Entretenimiento', 'ENT', 'Cines, teatros, salas de juego y entretenimiento', 1, 1, '2025-09-25 18:20:06', '2025-09-25 18:20:06'),
(10, 'Otros', 'OTR', 'Otras actividades comerciales no categorizadas', 1, 1, '2025-09-25 18:20:06', '2025-09-25 18:20:06'),
(13, 'rpuebasdasd', '21231', 'dasdadsadadsaaaa', 0, 0, '2025-09-25 20:12:39', '2025-09-25 20:12:39'),
(15, 'Prueba con documentacion', 'asd', '192313', 1, 0, '2025-09-25 20:40:48', '2025-09-25 20:40:48'),
(16, 'kjadhad', 'dhkahdaj', 'diwakdhakwa', 1, 1, '2025-09-25 22:14:07', '2025-09-25 22:14:07');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rubro_documentacion`
--

CREATE TABLE `rubro_documentacion` (
  `id` int(11) NOT NULL,
  `rubro_id` int(11) NOT NULL,
  `tipo_documento_id` int(11) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `rubro_documentacion`
--

INSERT INTO `rubro_documentacion` (`id`, `rubro_id`, `tipo_documento_id`, `fecha_creacion`) VALUES
(1, 1, 1, '2025-09-25 18:20:06'),
(2, 1, 2, '2025-09-25 18:20:06'),
(3, 1, 4, '2025-09-25 18:20:06'),
(4, 1, 5, '2025-09-25 18:20:06'),
(5, 1, 6, '2025-09-25 18:20:06'),
(6, 2, 1, '2025-09-25 18:20:06'),
(7, 2, 2, '2025-09-25 18:20:06'),
(8, 2, 6, '2025-09-25 18:20:06'),
(9, 2, 8, '2025-09-25 18:20:06'),
(10, 3, 1, '2025-09-25 18:20:06'),
(11, 3, 2, '2025-09-25 18:20:06'),
(12, 3, 6, '2025-09-25 18:20:06'),
(13, 4, 1, '2025-09-25 18:20:06'),
(14, 4, 2, '2025-09-25 18:20:06'),
(15, 4, 7, '2025-09-25 18:20:06'),
(16, 4, 8, '2025-09-25 18:20:06'),
(17, 5, 1, '2025-09-25 18:20:06'),
(18, 5, 2, '2025-09-25 18:20:06'),
(19, 5, 6, '2025-09-25 18:20:06'),
(20, 5, 7, '2025-09-25 18:20:06'),
(21, 15, 1, '2025-09-25 20:40:48'),
(22, 15, 2, '2025-09-25 20:40:48'),
(23, 15, 3, '2025-09-25 20:40:48'),
(24, 15, 5, '2025-09-25 20:40:48'),
(25, 15, 6, '2025-09-25 20:40:48'),
(26, 16, 1, '2025-09-25 22:14:07'),
(27, 16, 2, '2025-09-25 22:14:07'),
(28, 16, 4, '2025-09-25 22:14:07'),
(29, 16, 5, '2025-09-25 22:14:07');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_documentacion`
--

CREATE TABLE `tipos_documentacion` (
  `id` int(11) NOT NULL,
  `codigo` varchar(50) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `categoria` enum('personal','legal','tributaria','sanitaria','seguridad','municipal','profesional','otros') DEFAULT 'otros',
  `obligatorio_por_defecto` tinyint(1) DEFAULT 0,
  `vigencia_meses` int(11) DEFAULT 0 COMMENT '0 = no vence',
  `instrucciones` text DEFAULT NULL,
  `activo` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipos_documentacion`
--

INSERT INTO `tipos_documentacion` (`id`, `codigo`, `nombre`, `descripcion`, `categoria`, `obligatorio_por_defecto`, `vigencia_meses`, `instrucciones`, `activo`) VALUES
(1, 'dni', 'DNI del Titular', 'Documento Nacional de Identidad del titular del comercio', 'personal', 1, 0, 'Debe ser una copia legible de ambas caras', 1),
(2, 'constancia_cuit', 'Constancia de CUIT', 'Constancia de Clave Única de Identificación Tributaria', 'tributaria', 1, 0, 'Constancia emitida por AFIP', 1),
(3, 'contrato_alquiler', 'Contrato de Alquiler', 'Contrato de alquiler del local comercial', 'legal', 0, 0, 'Debe estar vigente y contener todas las cláusulas', 1),
(4, 'bromatologia', 'Certificado Bromatológico', 'Certificado de aptitud bromatológica para comercios de alimentos', 'sanitaria', 0, 12, 'Debe estar emitido por la autoridad sanitaria correspondiente', 1),
(5, 'seguridad_higiene', 'Certificado de Seguridad e Higiene', 'Certificado de condiciones de seguridad e higiene del local', 'seguridad', 0, 12, 'Emitido por profesional matriculado', 1),
(6, 'habilitacion_municipal', 'Habilitación Municipal', 'Habilitación comercial municipal', 'municipal', 1, 24, 'Debe estar vigente y corresponder a la actividad', 1),
(7, 'matricula_profesional', 'Matrícula Profesional', 'Matrícula profesional para actividades reguladas', 'profesional', 0, 0, 'Para médicos, abogados, ingenieros, etc.', 1),
(8, 'seguro_responsabilidad', 'Seguro de Responsabilidad Civil', 'Póliza de seguro de responsabilidad civil', 'legal', 0, 12, 'Debe cubrir la actividad desarrollada', 1),
(9, 'certificado_ambiental', 'Certificado Ambiental', 'Certificado de impacto ambiental', 'otros', 0, 24, 'Para actividades con impacto ambiental significativo', 1),
(10, 'registro_comercial', 'Registro Comercial', 'Inscripción en el registro comercial', 'legal', 0, 0, 'Para sociedades comerciales', 1),
(11, 'factibilidad_servicios', 'Factibilidad de Servicios', 'Factibilidad de servicios públicos (agua, luz, gas)', 'municipal', 0, 0, 'Según requerimientos del municipio', 1),
(12, 'planos_instalaciones', 'Planos de Instalaciones', 'Planos de instalaciones del local', 'seguridad', 0, 0, 'Para locales con instalaciones especiales', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `titulares`
--

CREATE TABLE `titulares` (
  `id` int(11) NOT NULL,
  `tipo` enum('física','jurídica') NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `cuit` varchar(20) NOT NULL,
  `celular` varchar(15) DEFAULT NULL,
  `web` varchar(50) DEFAULT NULL,
  `calle` varchar(255) NOT NULL,
  `numero` varchar(10) NOT NULL,
  `piso` varchar(10) DEFAULT NULL,
  `localidad` varchar(255) NOT NULL,
  `provincia` varchar(255) NOT NULL,
  `cod_postal` varchar(20) DEFAULT NULL,
  `observaciones` varchar(500) DEFAULT NULL,
  `estado` tinyint(1) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `rol` enum('admin','revisor','consultor') DEFAULT 'revisor',
  `activo` tinyint(1) DEFAULT 1,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `ultimo_acceso` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `username`, `email`, `password_hash`, `nombre`, `apellido`, `rol`, `activo`, `fecha_creacion`, `ultimo_acceso`) VALUES
(1, 'admin', 'admin@sistema.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrador', 'Principal', 'admin', 1, '2025-09-25 18:20:06', NULL);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_comercios_completos`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vista_comercios_completos` (
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_documentos_pendientes`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vista_documentos_pendientes` (
);

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_comercios_completos`
--
DROP TABLE IF EXISTS `vista_comercios_completos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_comercios_completos`  AS SELECT `c`.`id` AS `id`, `c`.`razon_social` AS `razon_social`, `c`.`nombre_fantasia` AS `nombre_fantasia`, `c`.`estado` AS `estado`, `c`.`fecha_alta` AS `fecha_alta`, `t`.`nombre` AS `titular_nombre`, `t`.`apellido` AS `titular_apellido`, `t`.`dni` AS `titular_dni`, `r`.`nombre` AS `rubro_nombre`, `r`.`codigo` AS `rubro_codigo` FROM ((`comercios` `c` join `titulares` `t` on(`c`.`titular_id` = `t`.`id`)) join `rubros` `r` on(`c`.`rubro_id` = `r`.`id`)) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_documentos_pendientes`
--
DROP TABLE IF EXISTS `vista_documentos_pendientes`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_documentos_pendientes`  AS SELECT `cd`.`id` AS `id`, `c`.`razon_social` AS `razon_social`, `r`.`nombre` AS `rubro`, `td`.`nombre` AS `documento`, `cd`.`estado` AS `estado`, `cd`.`fecha_subida` AS `fecha_subida` FROM (((`comercio_documentos` `cd` join `comercios` `c` on(`cd`.`comercio_id` = `c`.`id`)) join `rubros` `r` on(`c`.`rubro_id` = `r`.`id`)) join `tipos_documentacion` `td` on(`cd`.`tipo_documento_id` = `td`.`id`)) WHERE `cd`.`estado` = 'pendiente' ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `comercios`
--
ALTER TABLE `comercios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_comercios_estado` (`estado`),
  ADD KEY `idx_comercios_titular` (`titular_id`),
  ADD KEY `idx_comercios_rubro` (`rubro_id`);

--
-- Indices de la tabla `comercio_documentos`
--
ALTER TABLE `comercio_documentos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tipo_documento_id` (`tipo_documento_id`),
  ADD KEY `idx_documentos_comercio` (`comercio_id`,`estado`);

--
-- Indices de la tabla `comercio_historial`
--
ALTER TABLE `comercio_historial`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `idx_historial_comercio` (`comercio_id`,`fecha_cambio`);

--
-- Indices de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_notificaciones_comercio` (`comercio_id`,`leida`);

--
-- Indices de la tabla `rubros`
--
ALTER TABLE `rubros`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `codigo` (`codigo`),
  ADD KEY `idx_rubros_activos` (`activo`,`visible_publico`);

--
-- Indices de la tabla `rubro_documentacion`
--
ALTER TABLE `rubro_documentacion`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_rubro_documento` (`rubro_id`,`tipo_documento_id`),
  ADD KEY `tipo_documento_id` (`tipo_documento_id`);

--
-- Indices de la tabla `tipos_documentacion`
--
ALTER TABLE `tipos_documentacion`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `codigo` (`codigo`);

--
-- Indices de la tabla `titulares`
--
ALTER TABLE `titulares`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `cuit` (`cuit`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `comercios`
--
ALTER TABLE `comercios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `comercio_documentos`
--
ALTER TABLE `comercio_documentos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `comercio_historial`
--
ALTER TABLE `comercio_historial`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `rubros`
--
ALTER TABLE `rubros`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `rubro_documentacion`
--
ALTER TABLE `rubro_documentacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de la tabla `tipos_documentacion`
--
ALTER TABLE `tipos_documentacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `titulares`
--
ALTER TABLE `titulares`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `comercios`
--
ALTER TABLE `comercios`
  ADD CONSTRAINT `comercios_ibfk_1` FOREIGN KEY (`titular_id`) REFERENCES `titulares` (`id`),
  ADD CONSTRAINT `comercios_ibfk_2` FOREIGN KEY (`rubro_id`) REFERENCES `rubros` (`id`);

--
-- Filtros para la tabla `comercio_documentos`
--
ALTER TABLE `comercio_documentos`
  ADD CONSTRAINT `comercio_documentos_ibfk_1` FOREIGN KEY (`comercio_id`) REFERENCES `comercios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comercio_documentos_ibfk_2` FOREIGN KEY (`tipo_documento_id`) REFERENCES `tipos_documentacion` (`id`);

--
-- Filtros para la tabla `comercio_historial`
--
ALTER TABLE `comercio_historial`
  ADD CONSTRAINT `comercio_historial_ibfk_1` FOREIGN KEY (`comercio_id`) REFERENCES `comercios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comercio_historial_ibfk_2` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  ADD CONSTRAINT `notificaciones_ibfk_1` FOREIGN KEY (`comercio_id`) REFERENCES `comercios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `rubro_documentacion`
--
ALTER TABLE `rubro_documentacion`
  ADD CONSTRAINT `rubro_documentacion_ibfk_1` FOREIGN KEY (`rubro_id`) REFERENCES `rubros` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `rubro_documentacion_ibfk_2` FOREIGN KEY (`tipo_documento_id`) REFERENCES `tipos_documentacion` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
