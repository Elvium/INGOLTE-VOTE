-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-04-2025 a las 16:44:27
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
-- Base de datos: `voteingolte`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asistencia`
--

CREATE TABLE `asistencia` (
  `ID` int(11) NOT NULL,
  `Nombre` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NOT NULL,
  `Cedula` int(30) NOT NULL,
  `Acciones` int(5) NOT NULL,
  `Voto` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `asistencia`
--

INSERT INTO `asistencia` (`ID`, `Nombre`, `Cedula`, `Acciones`, `Voto`) VALUES
(1, 'Johan Sebas', 1005028827, 150, 1),
(2, 'Oscar', 1090501629, 100, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `base`
--

CREATE TABLE `base` (
  `ID` int(11) NOT NULL,
  `Nombre` varchar(54) NOT NULL,
  `Cedula` int(30) NOT NULL,
  `Acciones` int(3) NOT NULL,
  `Poder` tinyint(1) NOT NULL DEFAULT 0,
  `Apoderado` int(15) DEFAULT NULL,
  `nmApoderado` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `base`
--

INSERT INTO `base` (`ID`, `Nombre`, `Cedula`, `Acciones`, `Poder`, `Apoderado`, `nmApoderado`) VALUES
(1, 'Oscar', 1090501629, 100, 1, 1005028827, 'JOHAN SEBAS'),
(2, 'Johan Sebas', 1005028827, 50, 0, 0, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `plancha`
--

CREATE TABLE `plancha` (
  `ID` int(2) NOT NULL,
  `Nombre` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NOT NULL,
  `TotalAcciones` int(5) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `plancha`
--

INSERT INTO `plancha` (`ID`, `Nombre`, `TotalAcciones`) VALUES
(102, '1. Futbolistas', 150),
(103, '2. Golfistas', 100);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `poderes`
--

CREATE TABLE `poderes` (
  `ID` int(11) NOT NULL,
  `ccAccionista` int(11) NOT NULL COMMENT 'cedulaAccionista',
  `nmAccionista` varchar(255) NOT NULL COMMENT 'nombreAccionista',
  `ccApoderado` int(11) NOT NULL,
  `nmApoderado` varchar(255) NOT NULL,
  `nAcciones` varchar(11) NOT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `poderes`
--

INSERT INTO `poderes` (`ID`, `ccAccionista`, `nmAccionista`, `ccApoderado`, `nmApoderado`, `nAcciones`, `fecha`) VALUES
(1, 1090501629, 'Oscar', 1005028827, 'JOHAN SEBAS', '100', '2025-04-15'),
(2, 1090501629, 'Oscar', 1005028827, 'JOHAN SEBAS', '100', '2025-04-15');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `nombre`) VALUES
(1, 'ADMINISTRADOR');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `usuario` varchar(255) NOT NULL,
  `clave` varchar(100) NOT NULL,
  `id_rol` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `usuario`, `clave`, `id_rol`) VALUES
(1, 'Sebastian Lopez', '$2y$10$TOy3pjbW09SYYhNfEaH4k.4Lrlndijr/lLn2mP31tAeGKguwX0TuS', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `votaciones`
--

CREATE TABLE `votaciones` (
  `ID` int(11) NOT NULL,
  `Nombre` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NOT NULL,
  `Cedula` int(30) NOT NULL,
  `Plancha` int(2) NOT NULL,
  `Acciones` int(5) NOT NULL,
  `Estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `votaciones`
--

INSERT INTO `votaciones` (`ID`, `Nombre`, `Cedula`, `Plancha`, `Acciones`, `Estado`) VALUES
(1, 'Johan Sebas', 1005028827, 102, 150, 0),
(2, 'Oscar', 1090501629, 103, 100, 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `asistencia`
--
ALTER TABLE `asistencia`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `cedula` (`Cedula`);

--
-- Indices de la tabla `base`
--
ALTER TABLE `base`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `cedula` (`Cedula`);

--
-- Indices de la tabla `plancha`
--
ALTER TABLE `plancha`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `poderes`
--
ALTER TABLE `poderes`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `cedulaAccionista` (`ccAccionista`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_rol` (`id_rol`);

--
-- Indices de la tabla `votaciones`
--
ALTER TABLE `votaciones`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Plancha` (`Plancha`),
  ADD KEY `cedula` (`Cedula`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `asistencia`
--
ALTER TABLE `asistencia`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `base`
--
ALTER TABLE `base`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `plancha`
--
ALTER TABLE `plancha`
  MODIFY `ID` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- AUTO_INCREMENT de la tabla `poderes`
--
ALTER TABLE `poderes`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `votaciones`
--
ALTER TABLE `votaciones`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `asistencia`
--
ALTER TABLE `asistencia`
  ADD CONSTRAINT `asistencia_ibfk_1` FOREIGN KEY (`cedula`) REFERENCES `base` (`Cedula`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `poderes`
--
ALTER TABLE `poderes`
  ADD CONSTRAINT `poderes_ibfk_1` FOREIGN KEY (`ccAccionista`) REFERENCES `base` (`Cedula`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `votaciones`
--
ALTER TABLE `votaciones`
  ADD CONSTRAINT `votaciones_ibfk_1` FOREIGN KEY (`plancha`) REFERENCES `plancha` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `votaciones_ibfk_2` FOREIGN KEY (`cedula`) REFERENCES `asistencia` (`cedula`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
