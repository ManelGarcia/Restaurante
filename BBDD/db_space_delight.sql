-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-01-2024 a las 11:18:18
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
-- Base de datos: `db_space_delight`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado`
--

CREATE TABLE `estado` (
  `id_estado` int(11) NOT NULL,
  `estado` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estado`
--

INSERT INTO `estado` (`id_estado`, `estado`) VALUES
(1, 'Ocupado'),
(2, 'Desocupado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mesa`
--

CREATE TABLE `mesa` (
  `id_mesa` int(11) NOT NULL,
  `nombre_mesa` varchar(50) DEFAULT NULL,
  `estado_mesa` int(11) DEFAULT NULL,
  `ubicacion_mesa` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `mesa`
--

INSERT INTO `mesa` (`id_mesa`, `nombre_mesa`, `estado_mesa`, `ubicacion_mesa`) VALUES
(1, 'mesa test1', 2, 1),
(2, 'mesa test2', 2, 2),
(3, 'mesa test3', 2, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservas`
--

CREATE TABLE `reservas` (
  `id_reserva` int(11) NOT NULL,
  `inicio_res` datetime DEFAULT NULL,
  `final_res` datetime DEFAULT NULL,
  `mesa_res` int(11) DEFAULT NULL,
  `camarero_res` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id_rol` int(11) NOT NULL,
  `nombre_rol` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id_rol`, `nombre_rol`) VALUES
(1, 'Administrador'),
(2, 'Camarero'),
(3, 'Mantenimiento');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sillas`
--

CREATE TABLE `sillas` (
  `id_sillas` int(11) NOT NULL,
  `mesa_asig` int(11) DEFAULT NULL,
  `mesa_act` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `sillas`
--

INSERT INTO `sillas` (`id_sillas`, `mesa_asig`, `mesa_act`) VALUES
(1, 1, 2),
(2, 1, 1),
(3, 2, 2),
(4, 2, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tiempo`
--

CREATE TABLE `tiempo` (
  `id_tiempo` int(11) NOT NULL,
  `inicio_tmp` datetime DEFAULT NULL,
  `final_tmp` datetime DEFAULT NULL,
  `mesa_tmp` int(11) DEFAULT NULL,
  `camarero_tmp` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ubicacion`
--

CREATE TABLE `ubicacion` (
  `id_ubicacion` int(11) NOT NULL,
  `lugar` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ubicacion`
--

INSERT INTO `ubicacion` (`id_ubicacion`, `lugar`) VALUES
(1, 'comedor principal'),
(2, 'comedor secundario');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `usuario_us` varchar(30) DEFAULT NULL,
  `nombre_us` varchar(50) DEFAULT NULL,
  `email_us` varchar(50) DEFAULT NULL,
  `tipo_us` int(11) DEFAULT NULL,
  `password_us` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `usuario_us`, `nombre_us`, `email_us`, `tipo_us`, `password_us`) VALUES
(1, 'sergi_marin', 'Sergi Marín Ribes', 'sergi.marin@spaced.com', 1, '5c3c0d931d31a694bb4fdc39fc2ec15bb4875f3daba89c3018fe5f5ca96b7d37'),
(2, 'polmarc_montero', 'Pol Marc Montero Roca', 'polmarc.montero@spaced.com', 1, '5c3c0d931d31a694bb4fdc39fc2ec15bb4875f3daba89c3018fe5f5ca96b7d37'),
(3, 'manel_garcia', 'Manel García Moreno', 'manel.garcia@spaced.com', 1, '5c3c0d931d31a694bb4fdc39fc2ec15bb4875f3daba89c3018fe5f5ca96b7d37'),
(4, 'ana_lopez', 'Ana López Torres', 'ana.lopez@spaced.com', 2, '5c3c0d931d31a694bb4fdc39fc2ec15bb4875f3daba89c3018fe5f5ca96b7d37'),
(5, 'luis_martinez', 'Luis Martínez Gómez', 'luis.martinez@spaced.com', 2, '5c3c0d931d31a694bb4fdc39fc2ec15bb4875f3daba89c3018fe5f5ca96b7d37'),
(6, 'elena_sanchez', 'Elena Sánchez López', 'elena.sanchez@spaced.com', 2, '5c3c0d931d31a694bb4fdc39fc2ec15bb4875f3daba89c3018fe5f5ca96b7d37'),
(7, 'javier_torres', 'Javier Vázquez Baños', 'javier.vazquez@spaced.com', 2, '5c3c0d931d31a694bb4fdc39fc2ec15bb4875f3daba89c3018fe5f5ca96b7d37'),
(8, 'laura_gomez', 'Laura Gómez Sánchez', 'laura.gomez@spaced.com', 3, '5c3c0d931d31a694bb4fdc39fc2ec15bb4875f3daba89c3018fe5f5ca96b7d37');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `estado`
--
ALTER TABLE `estado`
  ADD PRIMARY KEY (`id_estado`);

--
-- Indices de la tabla `mesa`
--
ALTER TABLE `mesa`
  ADD PRIMARY KEY (`id_mesa`),
  ADD KEY `estado_mesa` (`estado_mesa`),
  ADD KEY `ubicacion_mesa` (`ubicacion_mesa`);

--
-- Indices de la tabla `reservas`
--
ALTER TABLE `reservas`
  ADD PRIMARY KEY (`id_reserva`),
  ADD KEY `mesa_res` (`mesa_res`),
  ADD KEY `camarero_res` (`camarero_res`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id_rol`);

--
-- Indices de la tabla `sillas`
--
ALTER TABLE `sillas`
  ADD PRIMARY KEY (`id_sillas`),
  ADD KEY `mesa_asig` (`mesa_asig`),
  ADD KEY `mesa_act` (`mesa_act`);

--
-- Indices de la tabla `tiempo`
--
ALTER TABLE `tiempo`
  ADD PRIMARY KEY (`id_tiempo`),
  ADD KEY `mesa_tmp` (`mesa_tmp`),
  ADD KEY `camarero_tmp` (`camarero_tmp`);

--
-- Indices de la tabla `ubicacion`
--
ALTER TABLE `ubicacion`
  ADD PRIMARY KEY (`id_ubicacion`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD KEY `fk_usuario_rol` (`tipo_us`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `ubicacion`
--
ALTER TABLE `ubicacion`
  MODIFY `id_ubicacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `mesa`
--
ALTER TABLE `mesa`
  ADD CONSTRAINT `mesa_ibfk_1` FOREIGN KEY (`estado_mesa`) REFERENCES `estado` (`id_estado`),
  ADD CONSTRAINT `mesa_ibfk_2` FOREIGN KEY (`ubicacion_mesa`) REFERENCES `ubicacion` (`id_ubicacion`);

--
-- Filtros para la tabla `reservas`
--
ALTER TABLE `reservas`
  ADD CONSTRAINT `reservas_ibfk_1` FOREIGN KEY (`mesa_res`) REFERENCES `mesa` (`id_mesa`),
  ADD CONSTRAINT `reservas_ibfk_2` FOREIGN KEY (`camarero_res`) REFERENCES `usuario` (`id_usuario`);

--
-- Filtros para la tabla `sillas`
--
ALTER TABLE `sillas`
  ADD CONSTRAINT `sillas_ibfk_1` FOREIGN KEY (`mesa_asig`) REFERENCES `mesa` (`id_mesa`),
  ADD CONSTRAINT `sillas_ibfk_2` FOREIGN KEY (`mesa_act`) REFERENCES `mesa` (`id_mesa`);

--
-- Filtros para la tabla `tiempo`
--
ALTER TABLE `tiempo`
  ADD CONSTRAINT `tiempo_ibfk_1` FOREIGN KEY (`mesa_tmp`) REFERENCES `mesa` (`id_mesa`),
  ADD CONSTRAINT `tiempo_ibfk_2` FOREIGN KEY (`camarero_tmp`) REFERENCES `usuario` (`id_usuario`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `fk_usuario_rol` FOREIGN KEY (`tipo_us`) REFERENCES `roles` (`id_rol`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
