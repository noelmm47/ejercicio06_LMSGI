-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Servidor: bbdd
-- Tiempo de generación: 18-03-2026 a las 17:27:01
-- Versión del servidor: 5.7.44
-- Versión de PHP: 8.3.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `proyecto`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `CLIENTES`
--

CREATE TABLE `CLIENTES` (
  `ID` int(11) NOT NULL,
  `NOMBRE` varchar(100) COLLATE utf8_bin NOT NULL,
  `APELLIDOS` varchar(200) COLLATE utf8_bin NOT NULL,
  `DNI` varchar(10) COLLATE utf8_bin NOT NULL,
  `DIRECCION` text COLLATE utf8_bin NOT NULL,
  `POBLACION` varchar(50) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `CLIENTES`
--

INSERT INTO `CLIENTES` (`ID`, `NOMBRE`, `APELLIDOS`, `DNI`, `DIRECCION`, `POBLACION`) VALUES
(1, 'Martin', 'Martinez', '11111111a', 'c/ falsa 123', 'Oviedo'),
(2, 'Gonzalo', 'Gonzalez', '22222222b', 'c/ falsa 124', 'Oviedo'),
(3, 'Fernando', 'Fernandez', '33333333c', 'c/ falsa 125', 'Oviedo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `USUARIOS`
--

CREATE TABLE `USUARIOS` (
  `ID` int(11) NOT NULL,
  `USER` varchar(20) COLLATE utf8_bin NOT NULL,
  `CONTRASENYA` varchar(256) COLLATE utf8_bin NOT NULL,
  `NAME` varchar(100) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `USUARIOS`
--

INSERT INTO `USUARIOS` (`ID`, `USER`, `CONTRASENYA`, `NAME`) VALUES
(1, 'admin', '1234', 'administrador'),
(2, 'victor', '1234', 'Víctor');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `CLIENTES`
--
ALTER TABLE `CLIENTES`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `USUARIOS`
--
ALTER TABLE `USUARIOS`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `CLIENTES`
--
ALTER TABLE `CLIENTES`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `USUARIOS`
--
ALTER TABLE `USUARIOS`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
