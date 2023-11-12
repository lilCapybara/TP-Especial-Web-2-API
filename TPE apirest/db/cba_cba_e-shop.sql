-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 15-10-2023 a las 08:04:23
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `cba&cba e-shop`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `campeones`
--

CREATE TABLE `campeones` (
  `Champion_id` int(3) NOT NULL,
  `Nombre` varchar(20) NOT NULL,
  `Rol` varchar(10) NOT NULL,
  `Precio` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `campeones`
--

INSERT INTO `campeones` (`Champion_id`, `Nombre`, `Rol`, `Precio`) VALUES
(13, 'Braum', 'tanque', 1200),
(16, 'Caitlyn', 'tirador', 1200);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `skins`
--

CREATE TABLE `skins` (
  `Skin_id` int(2) NOT NULL,
  `Nombre` varchar(20) NOT NULL,
  `Champion_id` int(3) NOT NULL,
  `Precio` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `skins`
--

INSERT INTO `skins` (`Skin_id`, `Nombre`, `Champion_id`, `Precio`) VALUES
(18, 'Veraniega', 16, 1200);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `transacciones`
--

CREATE TABLE `transacciones` (
  `Transaction_id` int(10) NOT NULL,
  `User_id` int(10) NOT NULL,
  `Champion_id` int(3) DEFAULT NULL,
  `Skin_id` int(10) DEFAULT NULL,
  `Monto` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `transacciones`
--

INSERT INTO `transacciones` (`Transaction_id`, `User_id`, `Champion_id`, `Skin_id`, `Monto`) VALUES
(48, 1, 16, NULL, 1200);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(20) NOT NULL,
  `password` varchar(260) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`user_id`, `user_name`, `password`) VALUES
(1, 'webadmin', '$2y$10$dH5CwAVOMxKWOhjzKmnDe.dcM42uobleY.nacuKLj0ad7HfsTfVpa'),
(2, 'normal', '$2y$10$X1VsNo.dvrk0bEsteTAYre7RiA.1jhAtpt9nE3dsnppdLkP1V421G');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `campeones`
--
ALTER TABLE `campeones`
  ADD PRIMARY KEY (`Champion_id`);

--
-- Indices de la tabla `skins`
--
ALTER TABLE `skins`
  ADD PRIMARY KEY (`Skin_id`),
  ADD KEY `Champion_id` (`Champion_id`);

--
-- Indices de la tabla `transacciones`
--
ALTER TABLE `transacciones`
  ADD PRIMARY KEY (`Transaction_id`),
  ADD KEY `Product_id` (`Champion_id`),
  ADD KEY `Skin_id` (`Skin_id`),
  ADD KEY `User_id` (`User_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `campeones`
--
ALTER TABLE `campeones`
  MODIFY `Champion_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `skins`
--
ALTER TABLE `skins`
  MODIFY `Skin_id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `transacciones`
--
ALTER TABLE `transacciones`
  MODIFY `Transaction_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `skins`
--
ALTER TABLE `skins`
  ADD CONSTRAINT `skins_ibfk_1` FOREIGN KEY (`Champion_id`) REFERENCES `campeones` (`Champion_id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `transacciones`
--
ALTER TABLE `transacciones`
  ADD CONSTRAINT `transacciones_ibfk_1` FOREIGN KEY (`Champion_id`) REFERENCES `campeones` (`Champion_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transacciones_ibfk_2` FOREIGN KEY (`Skin_id`) REFERENCES `skins` (`Skin_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transacciones_ibfk_3` FOREIGN KEY (`User_id`) REFERENCES `usuarios` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
